<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Distinct price_from values in service_scopes:\n";
$rows = DB::table('service_scopes')
    ->select('price_from', DB::raw('count(*) as cnt'))
    ->groupBy('price_from')
    ->orderByDesc('cnt')
    ->get();
foreach ($rows as $r) {
    echo "  '{$r->price_from}' => {$r->cnt}\n";
}

echo "\nDistinct price_from values in services:\n";
$rows2 = DB::table('services')
    ->select('price_from', DB::raw('count(*) as cnt'))
    ->groupBy('price_from')
    ->orderByDesc('cnt')
    ->get();
foreach ($rows2 as $r) {
    echo "  '{$r->price_from}' => {$r->cnt}\n";
}

echo "\nDistinct price_from values in landing_pages:\n";
$rows3 = DB::table('landing_pages')
    ->select('price_from', DB::raw('count(*) as cnt'))
    ->groupBy('price_from')
    ->orderByDesc('cnt')
    ->get();
foreach ($rows3 as $r) {
    echo "  '{$r->price_from}' => {$r->cnt}\n";
}

echo "\nDone.\n";
