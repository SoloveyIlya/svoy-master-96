<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\BrandCategorySeoText;
use App\Models\Category;
use App\Models\Defect;
use App\Models\DeviceCase;
use App\Models\DeviceModel;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceScope;

class CatalogController extends Controller
{
    /**
     * Отсортировать коллекцию моделей по числу в названии (15 > 14 > 13 ...),
     * модели без числа отправляем в конец.
     */
    private function sortModelsByNumber($models)
    {
        return $models
            ->sortByDesc(function ($model) {
                if (preg_match('/(\d+)/', $model->name, $m)) {
                    return (int) $m[1];
                }
                return -INF;
            })
            ->values();
    }

    /**
     * Формирует метку категории для хлебных крошек:
     * если имя не начинается со слова «Ремонт» — добавляем его.
     */
    private function categoryLabel(Category $category): string
    {
        $overrides = [
            'Телефоны' => 'телефонов',
            'Планшеты' => 'планшетов',
            'Ноутбуки' => 'ноутбуков',
            'Смарт-часы' => 'смарт-часов',
        ];

        $name = $category->name;
        if (array_key_exists($name, $overrides)) {
            $name = $overrides[$name];
        }

        if (!str_starts_with(mb_strtolower($name), 'ремонт')) {
            return 'Ремонт ' . mb_strtolower($name);
        }
        
        // Если уже начинается с "Ремонт", приводим всё после первого слова к нижнему регистру
        return 'Ремонт ' . mb_strtolower(trim(str_ireplace('Ремонт', '', $name)));
    }

    private function getGlobals()
    {
        return [
            'reviews' => Review::where('is_published', true)->orderByDesc('published_at')->get(),
            'cases'   => DeviceCase::where('is_published', true)->latest()->get(),
            'banners' => Banner::where('is_active', true)->orderBy('sort_order')->get(),
        ];
    }

    /**
     * Подготовить коллекцию поломок с resolved_url для текущего контекста.
     * resolved_url теперь всегда ведёт на плоскую страницу поломки: /{category}/{defect}
     */
    private function resolveDefects(Category $category, ?Brand $brand = null, ?DeviceModel $model = null)
    {
        $defects = Defect::where('is_active', true)
            ->where('category_id', $category->id)
            ->with('service')
            ->get();

        foreach ($defects as $defect) {
            $defect->resolved_url = url('/' . $category->slug . '/' . $defect->slug);
        }

        return $defects;
    }

    /**
     * Формирует $priceRows для категории: ссылки на /{category}/{service} (плоский URL).
     */
    private function buildCategoryPriceRows(Category $category): array
    {
        $services = $category->services()->where('status', 'active')->get();

        return $services->map(function ($s) use ($category) {
            $scope = ServiceScope::forCategory($category->id)
                ->where('service_id', $s->id)
                ->where('status', 'active')
                ->first();

            $price = $scope && $scope->price_from ? $scope->price_from : $s->price_from;

            return [
                'name'     => $s->name,
                'price'    => $price,
                'duration' => $s->duration_text,
                'slug'     => $s->slug,
                'url'      => url('/' . $category->slug . '/' . $s->slug),
            ];
        })->toArray();
    }

    // ─── Страница категории (/{categorySlug}) ───
    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();

        $brands = Brand::where(function($q) use ($category) {
                $q->whereHas('models', function ($q2) use ($category) {
                    $q2->where('category_id', $category->id)->where('status', 'active');
                })->orWhereHas('categories', function ($q2) use ($category) {
                    $q2->where('categories.id', $category->id);
                });
            })
            ->where('status', 'active')->orderBy('name')->get();

        extract($this->getGlobals());

        $priceRows = $this->buildCategoryPriceRows($category);
        $defects   = $this->resolveDefects($category);
        $categoryLabel = $this->categoryLabel($category);

        return view('catalog.category', compact(
            'category', 'brands', 'defects', 'reviews', 'cases', 'banners', 'priceRows', 'categoryLabel'
        ));
    }

    // ─── Страница модели (/{categorySlug}/{brandSlug}/{modelSlug}) ───
    public function model(string $categorySlug, string $brandSlug, string $modelSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $brand    = Brand::where('slug', $brandSlug)->where('status', 'active')->firstOrFail();
        $model    = DeviceModel::where('slug', $modelSlug)->where('category_id', $category->id)
            ->where('brand_id', $brand->id)->where('status', 'active')->firstOrFail();

        extract($this->getGlobals());

        // Прайс: все услуги категории со ссылками на /{category}/{service}
        $priceRows = $this->buildCategoryPriceRows($category);

        $defects = $this->resolveDefects($category, $brand, $model);
        $categoryLabel = $this->categoryLabel($category);

        return view('catalog.model', compact(
            'category', 'brand', 'model', 'defects', 'reviews', 'cases', 'banners', 'priceRows', 'categoryLabel'
        ));
    }

    // ─── Универсальный обработчик второго сегмента (/{categorySlug}/{slug}) ───
    // Определяет: Бренд → Услуга → Поломка → 404
    public function resolveSecondSegment(string $categorySlug, string $slug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();

        // 1. БРЕНД?
        $brand = Brand::where('slug', $slug)->where('status', 'active')->first();
        if ($brand) {
            return $this->showBrand($category, $brand);
        }

        // 2. УСЛУГА?
        $service = Service::where('slug', $slug)->where('status', 'active')->first();
        if ($service) {
            return $this->showService($category, $service, $slug);
        }

        // 3. ПОЛОМКА?
        $defect = Defect::where('slug', $slug)
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->first();
        if ($defect) {
            return $this->showDefect($category, $defect, $slug);
        }

        abort(404);
    }

    // ─── Внутренний рендер страницы бренда ───
    private function showBrand(Category $category, Brand $brand)
    {
        $models = DeviceModel::where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->get();

        $models = $this->sortModelsByNumber($models);

        // abort_if($models->isEmpty(), 404); // Удалено, так как мы теперь выводим бренды без моделей

        extract($this->getGlobals());

        // Прайс: все услуги категории → ссылки на /{category}/{service}
        $priceRows = $this->buildCategoryPriceRows($category);

        $defects = $this->resolveDefects($category, $brand);

        $seoBottomText = BrandCategorySeoText::where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->value('seo_bottom_text');

        $categoryLabel = $this->categoryLabel($category);

        return view('catalog.brand', compact(
            'category', 'brand', 'models', 'defects', 'reviews', 'cases',
            'banners', 'priceRows', 'seoBottomText', 'categoryLabel'
        ));
    }

    // ─── Внутренний рендер страницы услуги (/{categorySlug}/{serviceSlug}) ───
    private function showService(Category $category, Service $service, string $serviceSlug)
    {
        $scope = ServiceScope::forCategory($category->id)
            ->where('service_id', $service->id)
            ->where('status', 'active')
            ->first();

        $seo = $scope ? $scope->getSeoData() : [];

        extract($this->getGlobals());

        // Прайс: все услуги категории → ссылки на /{category}/{service}
        $priceRows = $this->buildCategoryPriceRows($category);

        $defects   = $this->resolveDefects($category);
        $activeSlug = $serviceSlug;
        $h1 = $service->name . ' на ' . ($category->name_prepositional ?? $category->name);
        $categoryLabel = $this->categoryLabel($category);

        return view('catalog.category-service', compact(
            'category', 'service', 'scope', 'seo', 'defects', 'reviews',
            'cases', 'banners', 'priceRows', 'activeSlug', 'categoryLabel', 'h1'
        ));
    }

    // ─── Внутренний рендер страницы поломки (/{categorySlug}/{defectSlug}) ───
    private function showDefect(Category $category, Defect $defect, string $defectSlug)
    {
        $brands = Brand::whereHas('models', function ($q) use ($category) {
                $q->where('category_id', $category->id)->where('status', 'active');
            })
            ->where('status', 'active')->orderBy('name')->get();

        extract($this->getGlobals());

        // Прайс: все услуги категории → ссылки на /{category}/{service}
        $priceRows = $this->buildCategoryPriceRows($category);

        $defects   = $this->resolveDefects($category);
        $activeSlug = $defectSlug;
        $categoryLabel = $this->categoryLabel($category);

        return view('catalog.defect', compact(
            'category', 'defect', 'brands', 'defects', 'reviews',
            'cases', 'banners', 'priceRows', 'activeSlug', 'categoryLabel'
        ));
    }
}
