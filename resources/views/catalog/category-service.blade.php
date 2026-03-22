@extends('layouts.app')

@section('content')
    <x-hero-banner 
        :title="isset($seo) && $seo->seo_h1 ? $seo->seo_h1 : $service->name . ' ' . (isset($brand) ? $brand->name : $category->name)"
        :subtitle="isset($seo) && $seo->seo_description ? $seo->seo_description : 'Гарантия качества и честные цены'"
    />

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Цена на {{ mb_strtolower($service->name) }} по моделям</h2>
    </div>

    <x-price-table :rows="$priceRows" />

    <x-steps-block />
    <x-cases-block :cases="$cases" />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" />
    <x-contact-form />
@endsection
