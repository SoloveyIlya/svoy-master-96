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
    public function category(Category $category)
    {
        abort_unless($category->status === 'active', 404);

        $brands = Brand::whereHas('deviceModels', function ($q) use ($category) {
            $q->where('category_id', $category->id)->where('status', 'active');
        })->where('status', 'active')->get();

        $services = ServiceScope::forCategory($category->id)
            ->where('status', 'active')
            ->with('service')
            ->get()
            ->pluck('service')
            ->filter();

        return view('catalog.category', compact('category', 'brands', 'services'));
    }

    public function brand(Category $category, Brand $brand)
    {
        abort_unless($category->status === 'active' && $brand->status === 'active', 404);

        $hasModelsInCategory = DeviceModel::where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->exists();

        abort_unless($hasModelsInCategory, 404);

        $models = DeviceModel::where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->get();

        $services = ServiceScope::forBrand($brand->id)
            ->where('status', 'active')
            ->with('service')
            ->get()
            ->pluck('service')
            ->filter();

        return view('catalog.brand', compact('category', 'brand', 'models', 'services'));
    }

    public function model(Category $category, Brand $brand, DeviceModel $model)
    {
        abort_unless(
            $model->category_id === $category->id && $model->brand_id === $brand->id,
            404,
        );
        abort_unless($model->status === 'active', 404);

        $landingPages = LandingPage::where('model_id', $model->id)
            ->where('status', 'active')
            ->with('service')
            ->get();

        return view('catalog.model', compact('category', 'brand', 'model', 'landingPages'));
    }

    public function categoryService(Category $category, Service $service)
    {
        $scope = ServiceScope::forCategory($category->id)
            ->where('service_id', $service->id)
            ->where('status', 'active')
            ->firstOrFail();

        $seo = $scope->getSeoData();

        return view('catalog.category-service', compact('category', 'service', 'scope', 'seo'));
    }

    public function brandService(Category $category, Brand $brand, Service $service)
    {
        abort_unless(
            DeviceModel::where('category_id', $category->id)
                ->where('brand_id', $brand->id)
                ->exists(),
            404,
        );

        $scope = ServiceScope::forBrand($brand->id)
            ->where('service_id', $service->id)
            ->where('status', 'active')
            ->firstOrFail();

        $seo = $scope->getSeoData();

        return view('catalog.brand-service', compact('category', 'brand', 'service', 'scope', 'seo'));
    }

    public function landing(Category $category, Brand $brand, DeviceModel $model, Service $service)
    {
        abort_unless(
            $model->category_id === $category->id && $model->brand_id === $brand->id,
            404,
        );

        $landing = LandingPage::where('model_id', $model->id)
            ->where('service_id', $service->id)
            ->where('status', 'active')
            ->firstOrFail();

        $seo = $landing->getSeoData();

        return view('catalog.landing', compact('category', 'brand', 'model', 'service', 'landing', 'seo'));
    }
}
