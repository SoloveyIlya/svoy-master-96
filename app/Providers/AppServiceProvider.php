<?php

namespace App\Providers;

use App\Models\DeviceModel;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
    }
}
