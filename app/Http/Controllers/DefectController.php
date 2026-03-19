<?php

namespace App\Http\Controllers;

use App\Models\Defect;
use Illuminate\View\View;

class DefectController extends Controller
{
    public function index(): View
    {
        $defects = Defect::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('defects.index', compact('defects'));
    }

    public function show(string $slug): View
    {
        $defect = Defect::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('defects.show', compact('defect'));
    }
}
