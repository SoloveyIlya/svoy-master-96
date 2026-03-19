<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
Route::view('/about', 'about')->name('about');
Route::view('/warranty', 'warranty')->name('warranty');
Route::view('/privacy', 'privacy')->name('privacy');

Route::post('/leads', [LeadController::class, 'store'])
    ->name('leads.store')
    ->middleware('throttle:leads');

Route::get('/polomki', [DefectController::class, 'index'])->name('defects.index');
Route::get('/polomki/{slug}', [DefectController::class, 'show'])->name('defects.show');

// Маршруты со словом "/service/" размещены выше динамических брендов/моделей
Route::get('/{categorySlug}/service/{serviceSlug}', [CatalogController::class, 'serviceScopeCategory'])
    ->name('catalog.service-scope-category');

Route::get('/{categorySlug}/{brandSlug}/service/{serviceSlug}', [CatalogController::class, 'serviceScopeBrand'])
    ->name('catalog.service-scope-brand');

Route::get('/{categorySlug}/{brandSlug}/{modelSlug}/{serviceSlug}', [CatalogController::class, 'landing'])
    ->name('catalog.landing');

Route::get('/{categorySlug}/{brandSlug}/{modelSlug}', [CatalogController::class, 'model'])
    ->name('catalog.model');

Route::get('/{categorySlug}/{brandSlug}', [CatalogController::class, 'brand'])
    ->name('catalog.brand');

Route::get('/{categorySlug}', [CatalogController::class, 'category'])
    ->name('catalog.category');
