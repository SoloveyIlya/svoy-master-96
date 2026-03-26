<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Defect;
use App\Models\DeviceCase;
use App\Models\DeviceModel;
use App\Models\LandingPage;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceScope;

class CatalogController extends Controller
{
    private function getGlobals()
    {
        return [
            'reviews' => Review::where('is_published', true)->orderByDesc('published_at')->get(),
            'cases' => DeviceCase::where('is_published', true)->latest()->get(),
            'banners' => Banner::where('is_active', true)->orderBy('sort_order')->get(),
        ];
    }

    /**
     * Подготовить коллекцию поломок с resolved_url для текущего контекста.
     *
     * Логика resolved_url:
     * - Если у поломки нет service_id → null
     * - Иначе ищем LandingPage/ServiceScope в текущем контексте → URL или null
     */
    private function resolveDefects(Category $category, ?Brand $brand = null, ?DeviceModel $model = null)
    {
        $defects = Defect::where('is_active', true)
            ->where('category_id', $category->id)
            ->with('service')
            ->get();

        foreach ($defects as $defect) {
            $defect->resolved_url = null;

            if (!$defect->service_id || !$defect->service) {
                continue;
            }

            $serviceSlug = $defect->service->slug;

            // Контекст модели → ищем LandingPage
            if ($model && $brand) {
                $landing = LandingPage::where('model_id', $model->id)
                    ->where('service_id', $defect->service_id)
                    ->where('status', 'active')
                    ->first();

                if ($landing) {
                    $defect->resolved_url = route('catalog.landing', [
                        $category->slug, $brand->slug, $model->slug, $serviceSlug,
                    ]);
                }
                continue;
            }

            // Контекст бренда → ищем ServiceScope по бренду
            if ($brand) {
                $scope = ServiceScope::forBrand($brand->id)
                    ->where('service_id', $defect->service_id)
                    ->where('status', 'active')
                    ->first();

                if ($scope) {
                    $defect->resolved_url = route('catalog.service-scope-brand', [
                        $category->slug, $brand->slug, $serviceSlug,
                    ]);
                }
                continue;
            }

            // Контекст категории → ищем ServiceScope по категории
            if ($category) {
                $scope = ServiceScope::forCategory($category->id)
                    ->where('service_id', $defect->service_id)
                    ->where('status', 'active')
                    ->first();

                if ($scope) {
                    $defect->resolved_url = route('catalog.service-scope-category', [
                        $category->slug, $serviceSlug,
                    ]);
                }
            }
        }

        return $defects;
    }

    // ─── Страница категории (/remont-telefonov) ───
    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();

        $brands = Brand::whereHas('models', function ($q) use ($category) {
                $q->where('category_id', $category->id)->where('status', 'active');
            })
            ->where('status', 'active')->orderBy('name')->get();

        extract($this->getGlobals());

        // Прайс: услуги ТОЛЬКО для этой категории
        $services = $category->services()->where('status', 'active')->get();

        $priceRows = $services->map(function ($s) use ($category) {
            // Ищем ServiceScope для этой категории и этой услуги
            $scope = ServiceScope::forCategory($category->id)
                ->where('service_id', $s->id)
                ->where('status', 'active')
                ->first();

            $url = $scope ? route('catalog.service-scope-category', [$category->slug, $s->slug]) : null;
            $price = $scope && $scope->price_from ? $scope->price_from : $s->price_from;

            return [
                'name'     => $s->name,
                'price'    => $price,
                'duration' => $s->duration_text,
                'slug'     => $s->slug,
                'url'      => $url,
            ];
        })->toArray();

        $defects = $this->resolveDefects($category);

        return view('catalog.category', compact('category', 'brands', 'defects', 'reviews', 'cases', 'banners', 'priceRows'));
    }

    // ─── Страница бренда (/remont-telefonov/apple) ───
    public function brand(string $categorySlug, string $brandSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)->where('status', 'active')->firstOrFail();

        $models = DeviceModel::where('category_id', $category->id)->where('brand_id', $brand->id)
            ->where('status', 'active')->orderBy('name')->get();

        abort_if($models->isEmpty(), 404);

        extract($this->getGlobals());

        // Прайс: услуги ТОЛЬКО для этой категории
        $services = $category->services()->where('status', 'active')->get();

        $priceRows = $services->map(function ($s) use ($category, $brand) {
            // 1. Ищем ServiceScope для этого БРЕНДА
            $scope = ServiceScope::forBrand($brand->id)
                ->where('service_id', $s->id)
                ->where('status', 'active')
                ->first();

            // 2. Если нет брендового — ищем для КАТЕГОРИИ
            if (!$scope) {
                $scope = ServiceScope::forCategory($category->id)
                    ->where('service_id', $s->id)
                    ->where('status', 'active')
                    ->first();
            }

            $url = route('catalog.service-scope-brand', [$category->slug, $brand->slug, $s->slug]);
            $price = $scope && $scope->price_from ? $scope->price_from : $s->price_from;

            return [
                'name'     => $s->name,
                'price'    => $price,
                'duration' => $s->duration_text,
                'slug'     => $s->slug,
                'url'      => $url,
            ];
        })->toArray();

        $defects = $this->resolveDefects($category, $brand);

        return view('catalog.brand', compact('category', 'brand', 'models', 'defects', 'reviews', 'cases', 'banners', 'priceRows'));
    }

    // ─── Страница модели (/remont-telefonov/apple/iphone-17) ───
    public function model(string $categorySlug, string $brandSlug, string $modelSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)->where('status', 'active')->firstOrFail();
        $model = DeviceModel::where('slug', $modelSlug)->where('category_id', $category->id)
            ->where('brand_id', $brand->id)->where('status', 'active')->firstOrFail();

        $landingPages = LandingPage::where('model_id', $model->id)->where('status', 'active')
            ->whereHas('service', function ($q) { $q->where('status', 'active'); })
            ->with('service')->orderBy('id')->get();

        extract($this->getGlobals());

        // Прайс: LandingPage есть → URL на лендинг
        $priceRows = $landingPages->map(function ($l) use ($category, $brand, $model) {
            return [
                'name'     => $l->service->name,
                'price'    => $l->service->price_from,
                'duration' => $l->service->duration_text,
                'slug'     => $l->service->slug,
                'url'      => route('catalog.landing', [$category->slug, $brand->slug, $model->slug, $l->service->slug]),
            ];
        })->toArray();

        $defects = $this->resolveDefects($category, $brand, $model);

        return view('catalog.model', compact('category', 'brand', 'model', 'landingPages', 'defects', 'reviews', 'cases', 'banners', 'priceRows'));
    }

    // ─── Посадочная страница (услуга+модель) ───
    public function landing(string $categorySlug, string $brandSlug, string $modelSlug, string $serviceSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)->where('status', 'active')->firstOrFail();
        $model = DeviceModel::where('slug', $modelSlug)->where('category_id', $category->id)
            ->where('brand_id', $brand->id)->where('status', 'active')->firstOrFail();
        $service = Service::where('slug', $serviceSlug)->where('status', 'active')->firstOrFail();

        $landing = LandingPage::where('model_id', $model->id)->where('service_id', $service->id)
            ->where('status', 'active')->with('service')->firstOrFail();

        $seo = $landing->getSeoData();

        extract($this->getGlobals());

        // Список всех услуг для этой модели (Прайс-таблица)
        $landingPages = LandingPage::where('model_id', $model->id)->where('status', 'active')
            ->whereHas('service', function ($q) { $q->where('status', 'active'); })
            ->with('service')->orderBy('id')->get();

        $priceRows = $landingPages->map(function ($l) use ($category, $brand, $model) {
            return [
                'name'     => $l->service->name,
                'price'    => $l->service->price_from,
                'duration' => $l->service->duration_text,
                'slug'     => $l->service->slug,
                'url'      => route('catalog.landing', [$category->slug, $brand->slug, $model->slug, $l->service->slug]),
            ];
        })->toArray();

        $defects = $this->resolveDefects($category, $brand, $model);
        $activeSlug = $serviceSlug;

        return view('catalog.landing', compact(
            'category', 'brand', 'model', 'service', 'landing', 'seo',
            'defects', 'reviews', 'cases', 'banners', 'priceRows', 'activeSlug'
        ));
    }

    // ─── ServiceScope: категория + услуга (/remont-komputerov/service/diagnostika) ───
    public function serviceScopeCategory(string $categorySlug, string $serviceSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();

        $scope = ServiceScope::forCategory($category->id)->where('status', 'active')
            ->whereHas('service', function ($q) use ($serviceSlug) {
                $q->where('slug', $serviceSlug)->where('status', 'active');
            })->with('service')->firstOrFail();

        $service = $scope->service;
        $seo = $scope->getSeoData();

        extract($this->getGlobals());

        // Если есть LandingPages для этой услуги в данной категории → показываем модели со ссылками
        $landings = LandingPage::where('service_id', $service->id)
            ->whereHas('model', function($q) use ($category) {
                $q->where('category_id', $category->id)->where('status', 'active');
            })->with(['model', 'model.brand'])->get();

        $priceRows = $landings->map(function ($l) use ($category, $service) {
            return [
                'name'     => $l->model->name,
                'price'    => $service->price_from,
                'duration' => $service->duration_text,
                'url'      => route('catalog.landing', [$category->slug, $l->model->brand->slug, $l->model->slug, $service->slug]),
            ];
        })->toArray();

        $defects = $this->resolveDefects($category);
        $activeSlug = $serviceSlug;

        return view('catalog.category-service', compact('category', 'service', 'scope', 'seo', 'defects', 'reviews', 'cases', 'banners', 'priceRows', 'activeSlug'));
    }

    // ─── ServiceScope: бренд + услуга (/remont-telefonov/apple/service/zamena-stekla) ───
    public function serviceScopeBrand(string $categorySlug, string $brandSlug, string $serviceSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)->where('status', 'active')->firstOrFail();

        abort_unless(DeviceModel::where('category_id', $category->id)->where('brand_id', $brand->id)->where('status', 'active')->exists(), 404);

        $scope = ServiceScope::forBrand($brand->id)->where('status', 'active')
            ->whereHas('service', function ($q) use ($serviceSlug) {
                $q->where('slug', $serviceSlug)->where('status', 'active');
            })->with('service')->firstOrFail();

        $service = $scope->service;
        $seo = $scope->getSeoData();

        extract($this->getGlobals());

        $landings = LandingPage::where('service_id', $service->id)
            ->whereHas('model', function($q) use ($category, $brand) {
                $q->where('category_id', $category->id)->where('brand_id', $brand->id)->where('status', 'active');
            })->with('model')->get();

        $priceRows = $landings->map(function ($l) use ($category, $brand, $service) {
            return [
                'name'     => $l->model->name,
                'price'    => $service->price_from,
                'duration' => $service->duration_text,
                'url'      => route('catalog.landing', [$category->slug, $brand->slug, $l->model->slug, $service->slug]),
            ];
        })->toArray();

        $defects = $this->resolveDefects($category, $brand);
        $activeSlug = $serviceSlug;

        return view('catalog.brand-service', compact('category', 'brand', 'service', 'scope', 'seo', 'defects', 'reviews', 'cases', 'banners', 'priceRows', 'activeSlug'));
    }
    // ─── Страница поломки (/remont-telefonov/polomka/ne-vklyuchaetsya) ───
    public function defect(string $categorySlug, string $defectSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $defect = Defect::where('slug', $defectSlug)->where('category_slug', $categorySlug)->where('is_active', true)->firstOrFail();

        $brands = Brand::whereHas('models', function ($q) use ($category) {
                $q->where('category_id', $category->id)->where('status', 'active');
            })
            ->where('status', 'active')->orderBy('name')->get();

        extract($this->getGlobals());

        // Прайс: услуги ТОЛЬКО для этой категории
        $services = $category->services()->where('status', 'active')->get();

        $priceRows = $services->map(function ($s) use ($category) {
            // Ищем ServiceScope для этой категории и этой услуги
            $scope = ServiceScope::forCategory($category->id)
                ->where('service_id', $s->id)
                ->where('status', 'active')
                ->first();

            $url = $scope ? route('catalog.service-scope-category', [$category->slug, $s->slug]) : null;
            $price = $scope && $scope->price_from ? $scope->price_from : $s->price_from;

            return [
                'name'     => $s->name,
                'price'    => $price,
                'duration' => $s->duration_text,
                'slug'     => $s->slug,
                'url'      => $url,
            ];
        })->toArray();

        $defects = $this->resolveDefects($category);
        $activeSlug = $defectSlug;

        return view('catalog.defect', compact('category', 'defect', 'brands', 'defects', 'reviews', 'cases', 'banners', 'priceRows', 'activeSlug'));
    }
}
