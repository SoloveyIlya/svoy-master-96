<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use App\Models\ServiceScope;
use App\Models\LandingPage;
use Illuminate\Support\Facades\DB;

echo "Querying services with slug 'diagnostika'...\n";
$services = Service::where('slug', 'diagnostika')->get();
if ($services->isEmpty()) {
    echo "No services found with slug 'diagnostika'.\n";
    exit(0);
}

foreach ($services as $s) {
    echo "--- Service ID: {$s->id} ---\n";
    echo "name: {$s->name}\n";
    echo "seo_h1: " . ($s->seo_h1 ?? '(null)') . "\n";
    echo "price_from (service): " . ($s->price_from ?? '(null)') . "\n";
    echo "duration_text: " . ($s->duration_text ?? '(null)') . "\n";

    // Categories via pivot
    $cats = DB::table('category_service')->where('service_id', $s->id)->pluck('category_id')->toArray();
    echo "linked category IDs: " . implode(',', $cats) . "\n";

    // ServiceScopes
    $scopes = ServiceScope::where('service_id', $s->id)->get();
    echo "ServiceScopes: " . $scopes->count() . "\n";
    foreach ($scopes as $sc) {
        echo "  scope_type: {$sc->scope_type}, scope_id: {$sc->scope_id}, price_from: {$sc->price_from}, seo_h1: {$sc->seo_h1}\n";
    }

    // Landing pages sample
    $landings = LandingPage::where('service_id', $s->id)->limit(20)->get();
    echo "LandingPages (sample up to 20): " . $landings->count() . "\n";
    foreach ($landings as $l) {
        echo "  id: {$l->id}, category_id: {$l->category_id}, brand_id: {$l->brand_id}, model_id: {$l->model_id}, price_from: {$l->price_from}, slug: {$l->slug}\n";
    }

}

// Also check any landing pages that might have price_from = 500 for diagnostika-like titles
echo "\nChecking LandingPage entries with price_from=500...\n";
$lp500 = LandingPage::where('price_from', 500)->get();
echo "Found " . $lp500->count() . " landing pages with price_from=500. Listing first 10:\n";
foreach ($lp500->take(10) as $l) {
    echo "  id: {$l->id}, service_id: {$l->service_id}, slug: {$l->slug}, price_from: {$l->price_from}\n";
}

echo "\nChecking ServiceScope entries with price_from=500...\n";
$ss500 = \App\Models\ServiceScope::where('price_from', 500)->get();
echo "Found " . $ss500->count() . " service_scopes with price_from=500. Listing first 10:\n";
foreach ($ss500->take(10) as $s) {
    echo "  id: {$s->id}, scope_type: {$s->scope_type}, scope_id: {$s->scope_id}, service_id: {$s->service_id}, price_from: {$s->price_from}\n";
}

echo "\nChecking Service entries with price_from=500...\n";
$s500 = Service::where('price_from', 500)->get();
echo "Found " . $s500->count() . " services with price_from=500. Listing first 10:\n";
foreach ($s500->take(10) as $s) {
    echo "  id: {$s->id}, slug: {$s->slug}, name: {$s->name}, price_from: {$s->price_from}\n";
}

echo "\nDone.\n";
