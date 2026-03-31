<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\DeviceCase;
use App\Models\Review;

class PriceController extends Controller
{
    public function index()
    {
        $mainSlugs = ['remont-telefonov', 'remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'];

        $mainCategories = Category::whereIn('slug', $mainSlugs)
            ->where('status', 'active')
            ->with(['services' => function ($q) {
                $q->where('status', 'active');
            }])
            ->get()
            ->sortBy(fn ($c) => array_search($c->slug, $mainSlugs))
            ->values();

        $otherCategories = Category::whereNotIn('slug', $mainSlugs)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $tabSlugs = ['remont-telefonov', 'remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'];
        $defectCategories = Category::whereIn('slug', $tabSlugs)
            ->where('status', 'active')
            ->with(['defects' => fn ($q) => $q->where('is_active', true)->with('service')])
            ->get()
            ->sortBy(fn ($c) => array_search($c->slug, $tabSlugs))
            ->values();

        $reviews = Review::where('is_published', true)->orderByDesc('published_at')->get();
        $cases = DeviceCase::where('is_published', true)->latest()->get();
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();

        return view('prices', compact('mainCategories', 'otherCategories', 'defectCategories', 'reviews', 'cases', 'banners'));
    }
}
