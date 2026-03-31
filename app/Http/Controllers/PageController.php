<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Defect;
use App\Models\Review;

class PageController extends Controller
{
    public function home()
    {
        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $defects = Defect::query()
            ->with('service')
            ->where('is_active', true)
            ->get();

        $tabSlugs = ['remont-telefonov', 'remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'];
        $defectCategories = Category::whereIn('slug', $tabSlugs)
            ->with(['defects' => fn($q) => $q->where('is_active', true)->with('service')])
            ->get()
            ->sortBy(fn($c) => array_search($c->slug, $tabSlugs))
            ->values();

        $reviews = Review::query()
            ->where('is_published', true)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(9)
            ->get();

        $popularBrands = Brand::query()
            ->where('status', 'active')
            ->whereNotIn('slug', [
                'ipad', 'apple-macbook', 'apple-watch', 
                'samsung-galaxy-watch', 'huawei-watch', 
                'xiaomi-mi-band', 'honor-watch', 'realme-watch'
            ])
            ->whereHas('models', function($q) {
                $q->where('status', 'active')
                    ->whereHas('category', fn($c) => $c->whereIn('slug', ['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov', 'remont-noutbukov']));
            })
            ->with(['models' => function($q) {
                $q->where('status', 'active')
                    ->with('category')
                    ->limit(1);
            }])
            ->get();

        $phoneBrands = Brand::query()
            ->where('status', 'active')
            ->whereHas('models', function($q) {
                $q->where('status', 'active')
                    ->whereHas('category', fn($c) => $c->where('slug', 'remont-telefonov'));
            })
            ->with(['models' => function($q) {
                $q->where('status', 'active')
                    ->whereHas('category', fn($c) => $c->where('slug', 'remont-telefonov'))
                    ->with('category');
            }])
            ->get();

        // Сортируем модели по числу в названии (iPhone 17 > 16 > 15 и т.п.)
        foreach ($phoneBrands as $brand) {
            $brand->models = $brand->models
                ->sortByDesc(function ($model) {
                    if (preg_match('/(\d+)/', $model->name, $m)) {
                        return (int) $m[1];
                    }
                    return -INF;
                })
                ->values()
                ->take(12); // показываем только 12 самых свежих моделей
        }

        return view('pages.home', compact('banners', 'defects', 'reviews', 'popularBrands', 'phoneBrands', 'defectCategories'));
    }

    public function contacts()
    {
        return view('pages.contacts');
    }

    public function reviews()
    {
        $reviews = Review::query()
            ->where('is_published', true)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->get();

        return view('pages.reviews', compact('reviews'));
    }
}
