<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$paths = ['/', 'about', 'remont-dzhojstikov/diagnostika'];

foreach ($paths as $path) {
    $url = $path === '/' ? '/' : '/' . $path;
    $dbPath = trim($path, '/');
    if ($dbPath === '') {
        $dbPath = '/';
    }

    $seo = App\Models\SeoMetadata::where('url_path', $dbPath)->first();

    echo "=== {$url} (db: {$dbPath}) ===\n";
    if ($seo) {
        echo "DB h1: {$seo->h1}\n";
        echo "DB title: {$seo->title}\n";
        echo "DB description: " . mb_substr($seo->description, 0, 70) . "...\n";
    } else {
        echo "NOT FOUND IN DB\n";
    }

    $request = Illuminate\Http\Request::create($url, 'GET');
    $response = $kernel->handle($request);
    $html = $response->getContent();

    preg_match('/<title>(.*?)<\/title>/s', $html, $titleMatch);
    preg_match('/<meta name="description" content="([^"]*)"/', $html, $descMatch);
    preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $h1Match);

    echo "--- Rendered HTML ---\n";
    echo 'title: ' . html_entity_decode($titleMatch[1] ?? 'MISSING', ENT_QUOTES | ENT_HTML5, 'UTF-8') . "\n";
    echo 'description: ' . mb_substr(html_entity_decode($descMatch[1] ?? 'MISSING', ENT_QUOTES | ENT_HTML5, 'UTF-8'), 0, 70) . "\n";
    echo 'h1: ' . trim(strip_tags($h1Match[1] ?? 'MISSING')) . "\n";

    $titleOk = isset($titleMatch[1]) && $seo && html_entity_decode($titleMatch[1], ENT_QUOTES | ENT_HTML5, 'UTF-8') === $seo->title;
    $descOk = isset($descMatch[1]) && $seo && html_entity_decode($descMatch[1], ENT_QUOTES | ENT_HTML5, 'UTF-8') === $seo->description;
    $h1Ok = isset($h1Match[1]) && $seo && trim(strip_tags($h1Match[1])) === $seo->h1;

    echo 'match: title=' . ($titleOk ? 'OK' : 'FAIL') . ', description=' . ($descOk ? 'OK' : 'FAIL') . ', h1=' . ($h1Ok ? 'OK' : 'FAIL') . "\n\n";

    $kernel->terminate($request, $response);
}
