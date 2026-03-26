@extends('layouts.app')

@section('title', $seo['title'] ?? $service->name . ' в ' . $category->name)
@section('seo_description', $seo['description'] ?? $service->name . ' различных устройств в Екатеринбурге')
@section('og_title', $seo['title'] ?? $service->name . ' в ' . $category->name)
@section('og_description', $seo['description'] ?? $service->name . ' с честными ценами и гарантией')
@section('og_image', asset('images/logo.png'))
@section('og_url', route('catalog.service-scope-category', ['categorySlug' => $category->slug, 'serviceSlug' => $service->slug]))

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => 'Ремонт ' . $category->name, '' => $service->name]" />

    <x-hero-banner 
        :title="isset($seo) && $seo['h1'] ? $seo['h1'] : $service->name . ' ' . (isset($brand) ? $brand->name : $category->name)"
        :subtitle="isset($seo) && $seo['description'] ? $seo['description'] : 'Гарантия качества и честные цены'"
    />

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Цена на {{ mb_strtolower($service->name) }} по моделям</h2>
    </div>

    <x-price-table :rows="$priceRows" :active-slug="$activeSlug ?? null" />

    <x-advantages-block />

    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" :active-slug="$activeSlug ?? null" />
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
