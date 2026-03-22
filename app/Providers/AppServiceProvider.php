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
            $phoneBrands = Brand::where('status', 'active')
                ->whereHas('models', function($q) {
                    $q->where('status', 'active')
                      ->whereHas('category', fn($c) => $c->where('slug', 'remont-telefonov'));
                })->get();

            $appleModels = DeviceModel::where('status', 'active')
                ->whereHas('brand', fn($q) => $q->where('slug', 'apple'))
                ->whereHas('category', fn($q) => $q->where('slug', 'remont-telefonov'))
                ->get();

            $samsungModels = DeviceModel::where('status', 'active')
                ->whereHas('brand', fn($q) => $q->where('slug', 'samsung'))
                ->whereHas('category', fn($q) => $q->where('slug', 'remont-telefonov'))
                ->get();

            $laptopBrands = Brand::where('status', 'active')
                ->whereHas('models', function($q) {
                    $q->where('status', 'active')
                      ->whereHas('category', fn($c) => $c->where('slug', 'remont-noutbukov'));
                })->get();

            $xiaomiModels = DeviceModel::where('status', 'active')
                ->whereHas('brand', fn($q) => $q->where('slug', 'xiaomi-poco'))
                ->whereHas('category', fn($q) => $q->where('slug', 'remont-telefonov'))
                ->get();

            $view->with(compact('phoneBrands', 'appleModels', 'samsungModels', 'laptopBrands', 'xiaomiModels'));
        });
    }
}
