<?php

namespace App\Http\Controllers;

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
            'defects' => Defect::where('is_active', true)->get(),
            'reviews' => Review::where('is_published', true)->orderByDesc('published_at')->get(),
            'cases' => DeviceCase::where('is_published', true)->latest()->get(),
        ];
    }

    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();

        $brands = Brand::whereHas('models', function ($q) use ($category) {
                $q->where('category_id', $category->id)->where('status', 'active');
            })
            ->where('status', 'active')->orderBy('name')->get();

        extract($this->getGlobals());

        $services = Service::where('status', 'active')->take(10)->get();
        $priceRows = $services->map(function ($s) {
            return [
                'name' => $s->name,
                'price' => $s->price_from,
                'duration' => $s->duration_text,
                'url' => route('prices'), 
            ];
        })->toArray();

        return view('catalog.category', compact('category', 'brands', 'defects', 'reviews', 'cases', 'priceRows'));
    }

    public function brand(string $categorySlug, string $brandSlug)
    {
        $category = Category::where('slug', $categorySlug)->where('status', 'active')->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)->where('status', 'active')->firstOrFail();

        $models = DeviceModel::where('category_id', $category->id)->where('brand_id', $brand->id)
            ->where('status', 'active')->orderBy('name')->get();

        abort_if($models->isEmpty(), 404);

        extract($this->getGlobals());

        $services = Service::where('status', 'active')->take(10)->get();
        $priceRows = $services->map(function ($s) {
            return [
                'name' => $s->name,
                'price' => $s->price_from,
                'duration' => $s->duration_text,
                'url' => route('prices'),
            ];
        })->toArray();

        return view('catalog.brand', compact('category', 'brand', 'models', 'defects', 'reviews', 'cases', 'priceRows'));
    }

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

        $priceRows = $landingPages->map(function ($l) use ($category, $brand, $model) {
            return [
                'name' => $l->service->name,
                'price' => $l->service->price_from,
                'duration' => $l->service->duration_text,
                'url' => route('catalog.landing', [$category->slug, $brand->slug, $model->slug, $l->service->slug]),
            ];
        })->toArray();

        return view('catalog.model', compact('category', 'brand', 'model', 'landingPages', 'defects', 'reviews', 'cases', 'priceRows'));
    }

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
        $priceRows = [];

        return view('catalog.landing', compact('category', 'brand', 'model', 'service', 'landing', 'seo', 'defects', 'reviews', 'cases', 'priceRows'));
    }

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

        $landings = LandingPage::where('service_id', $service->id)
            ->whereHas('model', function($q) use ($category) {
                $q->where('category_id', $category->id)->where('status', 'active');
            })->with(['model', 'model.brand'])->get();

        $priceRows = $landings->map(function ($l) use ($category, $service) {
            return [
                'name' => $l->model->name,
                'price' => $service->price_from,
                'duration' => $service->duration_text,
                'url' => route('catalog.landing', [$category->slug, $l->model->brand->slug, $l->model->slug, $service->slug]),
            ];
        })->toArray();

        return view('catalog.category-service', compact('category', 'service', 'scope', 'seo', 'defects', 'reviews', 'cases', 'priceRows'));
    }

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
                'name' => $l->model->name,
                'price' => $service->price_from,
                'duration' => $service->duration_text,
                'url' => route('catalog.landing', [$category->slug, $brand->slug, $l->model->slug, $service->slug]),
            ];
        })->toArray();

        return view('catalog.brand-service', compact('category', 'brand', 'service', 'scope', 'seo', 'defects', 'reviews', 'cases', 'priceRows'));
    }
}
