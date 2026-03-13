<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeviceModel;
use App\Models\LandingPage;
use App\Models\Service;
use App\Models\ServiceScope;

class CatalogController extends Controller
{
    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();

        $brands = Brand::whereHas('deviceModels', function ($q) use ($category) {
                $q->where('category_id', $category->id)
                    ->where('status', 'active');
            })
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('catalog.category', compact('category', 'brands'));
    }

    public function brand(string $categorySlug, string $brandSlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)
            ->where('status', 'active')
            ->firstOrFail();

        $models = DeviceModel::where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        abort_if($models->isEmpty(), 404);

        return view('catalog.brand', compact('category', 'brand', 'models'));
    }

    public function model(string $categorySlug, string $brandSlug, string $modelSlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)
            ->where('status', 'active')
            ->firstOrFail();
        $model = DeviceModel::where('slug', $modelSlug)
            ->where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->firstOrFail();

        $landingPages = LandingPage::where('model_id', $model->id)
            ->where('status', 'active')
            ->whereHas('service', function ($q) {
                $q->where('status', 'active');
            })
            ->with('service:id,name,slug')
            ->orderBy('id')
            ->get();

        return view('catalog.model', compact('category', 'brand', 'model', 'landingPages'));
    }

    public function landing(string $categorySlug, string $brandSlug, string $modelSlug, string $serviceSlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)
            ->where('status', 'active')
            ->firstOrFail();
        $model = DeviceModel::where('slug', $modelSlug)
            ->where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->firstOrFail();
        $service = Service::where('slug', $serviceSlug)
            ->where('status', 'active')
            ->firstOrFail();

        $landing = LandingPage::where('model_id', $model->id)
            ->where('service_id', $service->id)
            ->where('status', 'active')
            ->with('service')
            ->firstOrFail();

        $seo = $landing->getSeoData();

        return view('catalog.landing', compact('category', 'brand', 'model', 'service', 'landing', 'seo'));
    }

    public function serviceScopeCategory(string $categorySlug, string $serviceSlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();

        $scope = ServiceScope::forCategory($category->id)
            ->where('status', 'active')
            ->whereHas('service', function ($q) use ($serviceSlug) {
                $q->where('slug', $serviceSlug)
                    ->where('status', 'active');
            })
            ->with('service')
            ->firstOrFail();

        $service = $scope->service;
        $seo = $scope->getSeoData();

        return view('catalog.category-service', compact('category', 'service', 'scope', 'seo'));
    }

    public function serviceScopeBrand(string $categorySlug, string $brandSlug, string $serviceSlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)
            ->where('status', 'active')
            ->firstOrFail();

        abort_unless(
            DeviceModel::where('category_id', $category->id)
                ->where('brand_id', $brand->id)
                ->where('status', 'active')
                ->exists(),
            404,
        );

        $scope = ServiceScope::forBrand($brand->id)
            ->where('status', 'active')
            ->whereHas('service', function ($q) use ($serviceSlug) {
                $q->where('slug', $serviceSlug)
                    ->where('status', 'active');
            })
            ->with('service')
            ->firstOrFail();

        $service = $scope->service;
        $seo = $scope->getSeoData();

        return view('catalog.brand-service', compact('category', 'brand', 'service', 'scope', 'seo'));
    }
}
