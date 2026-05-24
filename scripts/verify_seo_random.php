<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$count = (int) ($argv[1] ?? 10);
$exclude = ['/', 'about', 'remont-dzhojstikov/diagnostika'];

$paths = App\Models\SeoMetadata::query()
    ->whereNotIn('url_path', $exclude)
    ->inRandomOrder()
    ->limit($count)
    ->pluck('url_path')
    ->all();

$passed = 0;
$failed = 0;

echo "Random SEO render check ({$count} pages)\n";
echo str_repeat('=', 60) . "\n";

foreach ($paths as $path) {
    $url = $path === '/' ? '/' : '/' . $path;
    $seo = App\Models\SeoMetadata::where('url_path', $path)->first();

    $request = Illuminate\Http\Request::create($url, 'GET');
    $response = $kernel->handle($request);
    $html = $response->getContent();
    $status = $response->getStatusCode();

    preg_match('/<title>(.*?)<\/title>/s', $html, $titleMatch);
    preg_match('/<meta name="description" content="([^"]*)"/', $html, $descMatch);
    preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $h1Match);

    $renderedTitle = html_entity_decode($titleMatch[1] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $renderedDesc = html_entity_decode($descMatch[1] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $renderedH1 = trim(strip_tags($h1Match[1] ?? ''));

    $titleOk = $status === 200 && $renderedTitle === $seo->title;
    $descOk = $status === 200 && $renderedDesc === $seo->description;
    $h1Ok = $status === 200 && $renderedH1 === $seo->h1;
    $allOk = $titleOk && $descOk && $h1Ok;

    if ($allOk) {
        $passed++;
        $result = 'PASS';
    } else {
        $failed++;
        $result = 'FAIL';
    }

    echo "{$result} | HTTP {$status} | {$url}\n";
    echo "  DB title:      {$seo->title}\n";
    echo "  HTML title:    " . ($renderedTitle ?: 'MISSING') . " [" . ($titleOk ? 'OK' : 'FAIL') . "]\n";
    echo "  DB h1:         {$seo->h1}\n";
    echo "  HTML h1:       " . ($renderedH1 ?: 'MISSING') . " [" . ($h1Ok ? 'OK' : 'FAIL') . "]\n";
    echo "  description:   [" . ($descOk ? 'OK' : 'FAIL') . "]\n\n";

    $kernel->terminate($request, $response);
}

echo str_repeat('=', 60) . "\n";
echo "Summary: {$passed}/{$count} passed, {$failed}/{$count} failed\n";

exit($failed > 0 ? 1 : 0);
