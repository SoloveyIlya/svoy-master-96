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

// 1. Страница модели (Категория / Бренд / Модель)
Route::get('/{categorySlug}/{brandSlug}/{modelSlug}', [CatalogController::class, 'model'])->name('catalog.model');

// 2. Универсальный обработчик второго сегмента: Бренд, Услуга или Поломка
Route::get('/{categorySlug}/{slug}', [CatalogController::class, 'resolveSecondSegment'])->name('catalog.resolve');

// 3. Страница категории
Route::get('/{categorySlug}', [CatalogController::class, 'category'])->name('catalog.category');
