<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceScope;
use Illuminate\Http\Request;

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
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    $els = $dom->getElementsByTagName($tag);
    if ($els->length > 0) {
        return trim($els->item(0)->textContent);
    }
    return null;
}

function parseHeroPrice(string $html)
{
    // Narrow search to the first <section> (hero banner) to avoid matching SEO text further on the page
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    $sections = $dom->getElementsByTagName('section');
    $searchHtml = '';
    if ($sections->length > 0) {
        $section = $sections->item(0);
        $searchHtml = $dom->saveHTML($section);
    } else {
        $searchHtml = $html;
    }

    if (preg_match('/от\s*([0-9\s]+)\s*₽/u', $searchHtml, $m)) {
        return (int) str_replace(' ', '', $m[1]);
    }
    // Also accept explicit 'Бесплатно' inside hero
    if (stripos($searchHtml, 'бесплатн') !== false) return 'Бесплатно';

    // Fallback: try to find any number with ₽ nearby in the hero
    if (preg_match('/([0-9\s]+)\s*₽/u', $searchHtml, $m)) {
        return (int) str_replace(' ', '', $m[1]);
    }

    return null;
}

$issues = [];

echo "Starting full audit: iterating categories and services...\n";
$categories = Category::where('status', 'active')->get();
$totalPages = 0;

foreach ($categories as $category) {
    $services = $category->services()->where('status', 'active')->get();
    foreach ($services as $s) {
        $totalPages++;
        $url = '/' . $category->slug . '/' . $s->slug;
        $html = fetch($url);

        $h1 = firstTagText($html, 'h1');

        // expected h1 per controller: service->seo_h1 ?: service->name
        $expectedH1 = $s->seo_h1 ?: $s->name;
        if ($expectedH1 !== $h1) {
            $issues[] = ['type' => 'h1_mismatch', 'url' => $url, 'expected' => $expectedH1, 'found' => $h1];
            echo "[H1 MISMATCH] {$url} — expected='{$expectedH1}' found='{$h1}'\n";
        }

        // price: compute resolved price via ServiceScope or service fallback
        $scope = ServiceScope::forCategory($category->id)->where('service_id', $s->id)->where('status', 'active')->first();
        $expectedPrice = null;
        if ($scope) {
            $expectedPrice = $scope->resolvedPriceFrom();
        } else {
            $expectedPrice = (string) ($s->price_from ?? '');
        }

        $displayedPrice = parseHeroPrice($html);

        // Normalize expectedPrice: numeric strings to int, '0' -> 0
        $expectedNumeric = null;
        if (is_numeric($expectedPrice)) {
            $expectedNumeric = (int) $expectedPrice;
        } elseif (trim((string)$expectedPrice) === '') {
            $expectedNumeric = null;
        }

        // If expected numeric is 0 (free), ensure displayedPrice is 'Бесплатно' or null
        if ($expectedNumeric === 0) {
            if ($displayedPrice !== 'Бесплатно' && ($displayedPrice !== 0 && $displayedPrice !== null)) {
                $issues[] = ['type' => 'price_mismatch_free', 'url' => $url, 'expected' => 'free', 'found' => $displayedPrice];
                echo "[PRICE MISMATCH - FREE] {$url} — expected free, found='{$displayedPrice}'\n";
            }
        } elseif (is_int($expectedNumeric)) {
            if ($displayedPrice !== $expectedNumeric) {
                $issues[] = ['type' => 'price_mismatch_numeric', 'url' => $url, 'expected' => $expectedNumeric, 'found' => $displayedPrice];
                echo "[PRICE MISMATCH] {$url} — expected='{$expectedNumeric}' found='{$displayedPrice}'\n";
            }
        }

        // check for multiple H1 tags
        if (substr_count(strtolower($html), '<h1') > 1) {
            $issues[] = ['type' => 'multiple_h1', 'url' => $url, 'count' => substr_count(strtolower($html), '<h1')];
            echo "[MULTIPLE H1] {$url}\n";
        }

        // check for <h4> on page
        if (stripos($html, '<h4') !== false) {
            $issues[] = ['type' => 'h4_found', 'url' => $url];
            echo "[H4 FOUND] {$url}\n";
        }

        // check for hardcoded fallback 'от 500' in price lists
        if (stripos($html, 'от 500') !== false || stripos($html, 'от&nbsp;500') !== false || preg_match('/от\s*500\s*₽/u', $html)) {
            $issues[] = ['type' => 'hardcoded_500', 'url' => $url];
            echo "[HARDCODED 500] {$url}\n";
        }
    }
}

echo "\nAudit finished. Pages checked: {$totalPages}. Issues found: " . count($issues) . "\n";

// write issues to file (always write, even if empty)
$out = __DIR__ . '/../storage/audit_issues.json';
file_put_contents($out, json_encode($issues, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Wrote issues to {$out}\n";

echo "Done.\n";
