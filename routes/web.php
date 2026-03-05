<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

Route::post('/leads', [LeadController::class, 'store'])
    ->name('leads.store')
    ->middleware('throttle:leads');

Route::prefix('services')->group(function () {
    // Specific routes with literal "service" segment FIRST
    Route::get('/{category:slug}/service/{service:slug}', [CatalogController::class, 'categoryService'])
        ->name('catalog.category-service');

    Route::get('/{category:slug}/{brand:slug}/service/{service:slug}', [CatalogController::class, 'brandService'])
        ->name('catalog.brand-service');

    // Generic parameter routes AFTER
    Route::get('/{category:slug}', [CatalogController::class, 'category'])
        ->name('catalog.category');

    Route::get('/{category:slug}/{brand:slug}', [CatalogController::class, 'brand'])
        ->name('catalog.brand');

    Route::get('/{category:slug}/{brand:slug}/{model:slug}', [CatalogController::class, 'model'])
        ->name('catalog.model');

    Route::get('/{category:slug}/{brand:slug}/{model:slug}/{service:slug}', [CatalogController::class, 'landing'])
        ->name('catalog.landing');
});
