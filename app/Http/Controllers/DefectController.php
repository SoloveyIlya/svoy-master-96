<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Defect;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DefectController extends Controller
{
    /**
     * Страница /polomki — поломки по типам устройств (с табами).
     */
    public function index(): View
    {
        $tabSlugs = ['remont-telefonov', 'remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'];

        // Основные категории с поломками (tab mode — как на главной)
        $defectCategories = Category::whereIn('slug', $tabSlugs)
            ->where('status', 'active')
            ->with(['defects' => fn ($q) => $q->where('is_active', true)->with('service')])
            ->get()
            ->sortBy(fn ($c) => array_search($c->slug, $tabSlugs))
            ->values();

        $reviews = Review::where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('defects.index', compact('defectCategories', 'reviews', 'banners'));
    }

    /**
     * Старый URL /polomki/{slug}: редирект на страницу поломки в каталоге.
     */
    public function legacyShow(string $slug): RedirectResponse
    {
        $defects = Defect::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->get();

        if ($defects->isEmpty()) {
            abort(404);
        }

        if ($defects->count() === 1) {
            $d = $defects->first();
        } else {
            $priority = ['remont-telefonov', 'remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'];
            $d = null;
            foreach ($priority as $categorySlug) {
                $d = $defects->first(fn (Defect $def) => $def->category->slug === $categorySlug);
                if ($d) {
                    break;
                }
            }
            $d = $d ?? $defects->first();
        }

        return redirect()->route('catalog.defect', [$d->category->slug, $d->slug], 301);
    }
}
