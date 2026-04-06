@extends('layouts.app')

@section('title', isset($seo) && $seo['title'] ? $seo['title'] : $service->name . ' ' . $brand->name)
@section('seo_description', isset($seo) && $seo['description'] ? $seo['description'] : $service->name . ' устройств ' . $brand->name)
@section('og_title', isset($seo) && $seo['title'] ? $seo['title'] : $service->name . ' ' . $brand->name)
@section('og_description', isset($seo) && $seo['description'] ? $seo['description'] : $service->name . ' для ' . $brand->name . ' с гарантией')
@section('og_image', asset('images/logo.png'))
@section('og_url', route('catalog.service-scope-brand', ['categorySlug' => $brand->models->first()?->category?->slug ?? 'remont-telefonov', 'brandSlug' => $brand->slug, 'serviceSlug' => $service->slug]))

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $brand->models->first()?->category?->slug ?? 'remont-telefonov']) => $categoryLabel, route('catalog.brand', ['categorySlug' => $brand->models->first()?->category?->slug ?? 'remont-telefonov', 'brandSlug' => $brand->slug]) => $brand->name, '' => $service->name]" />

    <x-hero-banner 
        :title="isset($seo) && $seo['h1'] ? $seo['h1'] : $service->name . ' ' . $brand->name"
        :subtitle="isset($seo) && $seo['description'] ? $seo['description'] : 'Профессиональное решение проблемы с гарантией'"
        :price="$scope->resolvedPriceFrom()"
        :duration="$scope->resolvedDurationText()"
    />

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Стоимость работы по моделям</h2>
    </div>

    <x-price-table :rows="$priceRows" :active-slug="$activeSlug ?? null" />

    {{-- ЗАДАЧА 2: сначала поломки, потом преимущества --}}
    <x-defects-block :defects="$defects" :active-slug="$activeSlug ?? null" :brand="$brand" />

    <x-advantages-block />

    <x-workflow-block />

    {{-- Акции перед отзывами --}}
    <x-promo-banner :banners="$banners ?? collect()" />

    <x-reviews-block :reviews="$reviews" />
    <x-contact-form />
@endsection
