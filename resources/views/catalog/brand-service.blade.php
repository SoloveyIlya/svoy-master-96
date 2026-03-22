@extends('layouts.app')

@section('content')
    <x-hero-banner 
        :title="isset($seo) && $seo->seo_h1 ? $seo->seo_h1 : $service->name . ' ' . $brand->name"
        :subtitle="isset($seo) && $seo->seo_description ? $seo->seo_description : 'Профессиональное решение проблемы с гарантией'"
    />

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Стоимость работы по моделям</h2>
    </div>

    <x-price-table :rows="$priceRows" />

    <x-steps-block />
    <x-cases-block :cases="$cases" />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" />
    <x-contact-form />
@endsection
