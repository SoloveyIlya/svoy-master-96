<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeviceModel;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        // 1. Главная страница
        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 2. Статичные страницы
        $staticRoutes = [
            'contacts' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'about' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'garantiya' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'reviews' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'akcii' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'faq' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'prices' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'privacy' => ['priority' => '0.3', 'changefreq' => 'monthly'],
        ];

        foreach ($staticRoutes as $name => $meta) {
            try {
                $urls[] = [
                    'loc' => route($name),
                    'lastmod' => now()->toAtomString(),
                    'changefreq' => $meta['changefreq'],
                    'priority' => $meta['priority'],
                ];
            } catch (\Exception $e) {
                // Игнорируем ошибки, если роут не зарегистрирован
            }
        }

        // 3. Категории устройств
        $categories = Category::where('status', 'active')
            ->where('noindex', false)
            ->get();

        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('catalog.category', ['categorySlug' => $category->slug]),
                'lastmod' => ($category->updated_at ?? now())->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ];

            // 4. Бренды внутри категорий
            $brands = Brand::where(function($q) use ($category) {
                    $q->whereHas('models', function ($q2) use ($category) {
                        $q2->where('category_id', $category->id)->where('status', 'active');
                    })->orWhereHas('categories', function ($q2) use ($category) {
                        $q2->where('categories.id', $category->id);
                    });
                })
                ->where('status', 'active')
                ->where('noindex', false)
                ->get();

            foreach ($brands as $brand) {
                $urls[] = [
                    'loc' => route('catalog.resolve', ['categorySlug' => $category->slug, 'slug' => $brand->slug]),
                    'lastmod' => ($brand->updated_at ?? $category->updated_at ?? now())->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }
        }

        // 5. Модели устройств из базы данных
        $models = DeviceModel::where('status', 'active')
            ->where('noindex', false)
            ->with(['category', 'brand'])
            ->get();

        foreach ($models as $model) {
            if ($model->category && $model->brand && 
                $model->category->status === 'active' && $model->brand->status === 'active' && 
                !$model->category->noindex && !$model->brand->noindex) {
                
                $urls[] = [
                    'loc' => route('catalog.model', [
                        'categorySlug' => $model->category->slug,
                        'brandSlug' => $model->brand->slug,
                        'modelSlug' => $model->slug
                    ]),
                    'lastmod' => ($model->updated_at ?? now())->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        }

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }
}
