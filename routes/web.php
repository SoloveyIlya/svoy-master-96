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
Route::get('/otzyvy', [PageController::class, 'reviews'])->name('reviews');

Route::post('/leads', [LeadController::class, 'store'])
    ->name('leads.store')
    ->middleware('throttle:leads');

Route::get('/polomki', [DefectController::class, 'index'])->name('defects.index');
Route::get('/polomki/{slug}', [DefectController::class, 'legacyShow'])->name('defects.show');

// Маршрут цен
Route::get('/ceny', [App\Http\Controllers\PriceController::class, 'index'])->name('prices');

// Статические страницы (должны быть ВЫШЕ динамического /{categorySlug})
Route::get('/akcii', [PageController::class, 'akcii'])->name('akcii');
Route::get('/garantiya', [PageController::class, 'garantiya'])->name('garantiya');
Route::get('/voprosy', [PageController::class, 'faq'])->name('faq');

// 1. Срезы услуг внутри бренда и категории (СТАТИЧЕСКИЙ СЕГМЕНТ "service")
Route::get('/{categorySlug}/{brandSlug}/service/{serviceSlug}', [CatalogController::class, 'serviceScopeBrand'])->name('catalog.service-scope-brand');
Route::get('/{categorySlug}/service/{serviceSlug}', [CatalogController::class, 'serviceScopeCategory'])->name('catalog.service-scope-category');

// 2. Страницы поломок (СТАТИЧЕСКИЙ СЕГМЕНТ "polomka")
Route::get('/{categorySlug}/polomka/{defectSlug}', [CatalogController::class, 'defect'])->name('catalog.defect');

// 3. Конечная посадочная страница (Модель + Услуга)
Route::get('/{categorySlug}/{brandSlug}/{modelSlug}/{serviceSlug}', [CatalogController::class, 'landing'])->name('catalog.landing');

// 4. Динамические страницы каталога (ОБЩИЕ РОУТЫ)
Route::get('/{categorySlug}/{brandSlug}/{modelSlug}', [CatalogController::class, 'model'])->name('catalog.model');
Route::get('/{categorySlug}/{brandSlug}', [CatalogController::class, 'brand'])->name('catalog.brand');
Route::get('/{categorySlug}', [CatalogController::class, 'category'])->name('catalog.category');
