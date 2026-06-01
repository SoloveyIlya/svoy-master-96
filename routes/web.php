<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 301 РЕДИРЕКТЫ СО СТАРОГО САЙТА (SEO)
// ==========================================
Route::group([], function () {
    Route::redirect('/remont-telefona', '/remont-telefonov', 301);
    Route::redirect('/apple-iphone', '/remont-telefonov/apple', 301);
    Route::redirect('/samsung-mobile', '/remont-telefonov/samsung', 301);
    Route::redirect('/xiaomi-mobile', '/remont-telefonov/xiaomi', 301);
    Route::redirect('/honor-mobile', '/remont-telefonov/honor', 301);
    Route::redirect('/huawei-mobile', '/remont-telefonov/huawei', 301);
    Route::redirect('/meizu-mobile', '/remont-telefonov/meizu', 301);
    Route::redirect('/zte-mobile', '/remont-telefonov/zte', 301);
    Route::redirect('/lenovo-mobile', '/remont-telefonov/lenovo', 301);
    Route::redirect('/asus-mobile', '/remont-telefonov/asus', 301);
    Route::redirect('/sony-mobile', '/remont-telefonov/sony', 301);
    
    Route::redirect('/remont-plansheta', '/remont-planshetov', 301);
    Route::redirect('/ipad-planshety', '/remont-planshetov/apple', 301);
    Route::redirect('/samsung-planshety', '/remont-planshetov/samsung', 301);
    Route::redirect('/xiaomi-planshety', '/remont-planshetov/xiaomi', 301);
    Route::redirect('/huawei-planshety', '/remont-planshetov/huawei', 301);
    Route::redirect('/lenovo-planshety', '/remont-planshetov/lenovo', 301);
    Route::redirect('/asus-planshety', '/remont-planshetov/asus', 301);
    Route::redirect('/meizu-planshety', '/remont-planshetov/meizu', 301);
    Route::redirect('/sony-planshety', '/remont-planshetov/sony', 301);
    Route::redirect('/lg-planshety', '/remont-planshetov/lg', 301);
    Route::redirect('/nokia-planshety', '/remont-planshetov/nokia', 301);
    
    Route::redirect('/remont-noutbuka', '/remont-noutbukov', 301);
    Route::redirect('/noutbuk-apple-macbook', '/remont-noutbukov/apple', 301);
    Route::redirect('/noutbuk-asus', '/remont-noutbukov/asus', 301);
    Route::redirect('/noutbuk-hp', '/remont-noutbukov/hp', 301);
    Route::redirect('/noutbuk-lenovo', '/remont-noutbukov/lenovo', 301);
    Route::redirect('/noutbuk-acer', '/remont-noutbukov/acer', 301);
    Route::redirect('/noutbuk-dell', '/remont-noutbukov/dell', 301);
    Route::redirect('/noutbuk-samsung', '/remont-noutbukov/samsung', 301);
    Route::redirect('/noutbuk-sony', '/remont-noutbukov/sony', 301);
    Route::redirect('/noutbuk-toshiba', '/remont-noutbukov/toshiba', 301);
    
    Route::redirect('/apple-watch', '/remont-smart-chasov/apple', 301);
    Route::redirect('/find-us', '/contacts', 301);
});

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
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// 1. Страница модели (Категория / Бренд / Модель)
Route::get('/{categorySlug}/{brandSlug}/{modelSlug}', [CatalogController::class, 'model'])->name('catalog.model');

// 2. Универсальный обработчик второго сегмента: Бренд, Услуга или Поломка
Route::get('/{categorySlug}/{slug}', [CatalogController::class, 'resolveSecondSegment'])->name('catalog.resolve');

// 3. Страница категории
Route::get('/{categorySlug}', [CatalogController::class, 'category'])->name('catalog.category');
