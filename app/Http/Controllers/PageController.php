<?php

namespace App\Http\Controllers;

use App\Models\Review;

class PageController extends Controller
{
    public function home()
    {
        $reviews = Review::query()
            ->where('is_published', true)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(9)
            ->get();

        return view('pages.home', compact('reviews'));
    }

    public function contacts()
    {
        return view('pages.contacts');
    }
}
