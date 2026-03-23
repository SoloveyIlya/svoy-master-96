<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
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

        $reviews = Review::query()
            ->where('is_published', true)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(9)
            ->get();

        $brands = Brand::query()
            ->where('status', 'active')
            ->whereHas('models', function($q) {
                $q->where('status', 'active')
                    ->whereHas('category', fn($c) => $c->whereIn('slug', ['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov', 'remont-noutbukov']));
            })
            ->with(['models' => function($q) {
                $q->where('status', 'active')
                    ->whereHas('category', fn($c) => $c->whereIn('slug', ['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov', 'remont-noutbukov']))
                    ->with('category')
                    ->limit(12);
            }])
            ->get();

        return view('pages.home', compact('banners', 'defects', 'reviews', 'brands'));
    }

    public function contacts()
    {
        return view('pages.contacts');
    }
}
