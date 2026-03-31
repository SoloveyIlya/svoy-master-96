<?php

namespace App\Providers;

use App\Models\DeviceModel;
use App\Models\Brand;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::model('model', DeviceModel::class);

        RateLimiter::for('leads', function (Request $request) {
            return Limit::perMinutes(10, 3)->by($request->ip());
        });

        View::composer('layouts.app', function ($view) {
            $navData = \Illuminate\Support\Facades\Cache::remember('nav_data', 3600, function () {
                $mainSlugs = ['remont-telefonov', 'remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'];
                
                $mainCategories = \App\Models\Category::whereIn('slug', $mainSlugs)
                    ->where('status', 'active')
                    ->get()
                    ->sortBy(function($category) use ($mainSlugs) {
                        return array_search($category->slug, $mainSlugs);
                    })->values();
                    
                foreach ($mainCategories as $category) {
                    $category->navBrands = \App\Models\Brand::whereHas('models', function($q) use ($category) {
                        $q->where('category_id', $category->id)->where('status', 'active');
                    })->where('status', 'active')->orderBy('name')->get();
                    
                    foreach ($category->navBrands as $brand) {
                        $models = \App\Models\DeviceModel::where('category_id', $category->id)
                            ->where('brand_id', $brand->id)
                            ->where('status', 'active')
                            ->get();

                        // Сортировка актуальных моделей по числу в названии (например, 15 > 14 > 13)
                        $brand->navModels = $models
                            ->sortByDesc(function ($model) {
                                if (preg_match('/(\d+)/', $model->name, $m)) {
                                    return (int) $m[1];
                                }
                                // Модели без числа отправляем в конец, сохраняя ид-шник как вторичный критерий
                                return -INF;
                            })
                            ->values()
                            ->take(6);
                    }
                }
                
                $otherCategories = \App\Models\Category::whereNotIn('slug', $mainSlugs)
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->get();
                    
                return compact('mainCategories', 'otherCategories');
            });

            $view->with($navData);
        });
    }
}
