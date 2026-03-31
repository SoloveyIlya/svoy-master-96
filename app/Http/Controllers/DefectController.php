<?php

namespace App\Http\Controllers;

use App\Models\Defect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DefectController extends Controller
{
    public function index(): View
    {
        $defects = Defect::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('defects.index', compact('defects'));
    }

    /**
     * Старый URL /polomki/{slug}: при однозначном совпадении редирект на страницу поломки в каталоге.
     */
    public function legacyShow(string $slug): RedirectResponse
    {
        $defects = Defect::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->get();

        if ($defects->count() === 1) {
            $d = $defects->first();

            return redirect()->route('catalog.defect', [$d->category->slug, $d->slug], 301);
        }

        abort(404);
    }
}
