<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Defect;
use App\Models\DeviceCase;
use App\Models\Review;
use App\Models\Service;

class PriceController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();
        
        $categorizedServices = [];
        foreach ($categories as $category) {
            $categorizedServices[$category->name] = $services->map(function ($s) use ($category) {
                return [
                    'name' => $s->name,
                    'price' => $s->price_from,
                    'duration' => $s->duration_text,
                    'url' => route('catalog.service-scope-category', ['categorySlug' => $category->slug, 'serviceSlug' => $s->slug]),
                ];
            })->toArray();
        }

        $defects = Defect::where('is_active', true)->get();
        $reviews = Review::where('is_published', true)->orderByDesc('published_at')->get();
        $cases = DeviceCase::where('is_published', true)->latest()->get();

        return view('prices', compact('categorizedServices', 'defects', 'reviews', 'cases'));
    }
}
