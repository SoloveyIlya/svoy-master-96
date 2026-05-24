<?php

namespace App\Http\View\Composers;

use App\Models\SeoMetadata;
use Illuminate\View\View;

class SeoComposer
{
    public function compose(View $view): void
    {
        $path = trim(request()->path(), '/');
        if ($path === '') {
            $path = '/';
        }

        $seo = SeoMetadata::where('url_path', $path)->first();

        view()->share([
            'seoTitle' => $seo?->title,
            'seoDescription' => $seo?->description,
            'seoH1' => $seo?->h1,
        ]);
    }
}
