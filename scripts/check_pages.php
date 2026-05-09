<?php

use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

function fetch(string $path)
{
    global $kernel;
    $request = Request::create($path, 'GET');
    $response = $kernel->handle($request);
    $content = $response->getContent();
    $kernel->terminate($request, $response);
    return $content;
}

function firstTagText(string $html, string $tag)
{
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    // Ensure UTF-8
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    $els = $dom->getElementsByTagName($tag);
    if ($els->length > 0) {
        return trim($els->item(0)->textContent);
    }
    return null;
}

function countTag(string $html, string $tag)
{
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    return $dom->getElementsByTagName($tag)->length;
}

// --- Checks ---
$results = [];

// 1) Brand H1 checks
$brands = [
    '/remont-telefonov/bq' => 'Ремонт телефонов BQ',
    '/remont-planshetov/blackview' => 'Ремонт планшетов Blackview',
];

foreach ($brands as $url => $expected) {
    echo "Checking brand page: {$url}\n";
    $html = fetch($url);
    $h1 = firstTagText($html, 'h1');
    $countH1 = countTag($html, 'h1');
    $ok = ($h1 === $expected) && ($countH1 === 1);
    $results[] = ['check' => "brand H1 {$url}", 'ok' => $ok, 'expected' => $expected, 'found' => $h1, 'h1_count' => $countH1];
    echo ($ok ? "  PASS\n" : "  FAIL\n");
    if (!$ok) {
        echo "    expected: {$expected}\n    found: {$h1}\n    h1_count: {$countH1}\n";
    }
}

// 2) Service H1 and price header checks
$serviceSamples = [
    '/remont-naushnikov/diagnostika',
];

foreach ($serviceSamples as $url) {
    echo "Checking service page: {$url}\n";
    $html = fetch($url);
    $h1 = firstTagText($html, 'h1');
    // Determine expected from DB
    $parts = explode('/', trim($url, '/'));
    $categorySlug = $parts[0] ?? null;
    $serviceSlug = $parts[1] ?? null;
    $service = null;
    if ($serviceSlug) {
        $service = \App\Models\Service::where('slug', $serviceSlug)->first();
    }
    $expectedName = $service ? ($service->seo_h1 ?: $service->name) : null;
    $okH1 = ($h1 === $expectedName);
    $results[] = ['check' => "service H1 {$url}", 'ok' => $okH1, 'expected' => $expectedName, 'found' => $h1];
    echo ($okH1 ? "  PASS\n" : "  FAIL\n");
    if (!$okH1) {
        echo "    expected: {$expectedName}\n    found: {$h1}\n";
    }

    // Price header
    $hasPriceHeader = mb_strpos($html, 'Стоимость услуг') !== false;
    $results[] = ['check' => "price header {$url}", 'ok' => $hasPriceHeader, 'found' => $hasPriceHeader ? 'found' : 'not found'];
    echo ($hasPriceHeader ? "  Price header: PASS\n" : "  Price header: FAIL (" . strlen($html) . " bytes)\n");
}

// 3) URL slug duplication check in DB
echo "Checking service slugs for category prefixes...\n";
$cats = \App\Models\Category::pluck('slug')->toArray();
$offenders = [];
foreach (\App\Models\Service::all() as $s) {
    foreach ($cats as $c) {
        if (str_starts_with($s->slug, $c . '-')) {
            $offenders[] = ['service_id' => $s->id, 'slug' => $s->slug, 'category_prefix' => $c];
            break;
        }
    }
}
if (count($offenders) === 0) {
    echo "  PASS: no service slugs with category prefixes found.\n";
    $results[] = ['check' => 'service slugs prefixes', 'ok' => true];
} else {
    echo "  FAIL: found services with category prefixes in slug:\n";
    foreach ($offenders as $o) {
        echo "    id={$o['service_id']} slug={$o['slug']} prefix={$o['category_prefix']}\n";
    }
    $results[] = ['check' => 'service slugs prefixes', 'ok' => false, 'offenders' => $offenders];
}

// 4) Scan selected pages for remaining <h4> tags
$pagesToScan = ['/', '/remont-telefonov/bq', '/remont-naushnikov/diagnostika', '/about', '/contacts'];
foreach ($pagesToScan as $p) {
    echo "Scanning page {$p} for <h4> tags...\n";
    $html = fetch($p);
    $hasH4 = stripos($html, '<h4') !== false;
    $results[] = ['check' => "page h4 {$p}", 'ok' => !$hasH4, 'found' => $hasH4];
    echo ($hasH4 ? "  FAIL: <h4> found\n" : "  PASS: no <h4>\n");
}

// 5) Search view files for remaining <h4> occurrences
echo "Searching view files for literal '<h4' strings...\n";
$root = __DIR__ . '/../resources/views';
$filesWithH4 = [];
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    $path = $file->getPathname();
    if (str_ends_with($path, '.blade.php')) {
        $content = file_get_contents($path);
        if (stripos($content, '<h4') !== false) {
            $filesWithH4[] = str_replace(__DIR__ . '/../', '', $path);
        }
    }
}
if (count($filesWithH4) === 0) {
    echo "  PASS: no '<h4' found in view files under resources/views\n";
    $results[] = ['check' => 'views h4', 'ok' => true];
} else {
    echo "  FAIL: found '<h4' in view files:\n";
    foreach ($filesWithH4 as $f) echo "    {$f}\n";
    $results[] = ['check' => 'views h4', 'ok' => false, 'files' => $filesWithH4];
}

// 6) Summary
$passed = array_filter($results, fn($r) => $r['ok'] ?? false);
$failed = array_filter($results, fn($r) => !($r['ok'] ?? false));
echo "\n=== SUMMARY ===\n";
echo "Checks run: " . count($results) . "\n";
echo "Passed: " . count($passed) . "\n";
echo "Failed: " . count($failed) . "\n";
if (count($failed) > 0) {
    echo "Failed checks details:\n";
    foreach ($failed as $f) {
        echo " - " . ($f['check'] ?? json_encode($f)) . "\n";
    }
}

echo "\nDone.\n";
