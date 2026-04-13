@extends('layouts.app')

@section('title', $model->seo_title ?? 'Ремонт ' . $model->name . ' в Екатеринбурге')
@section('seo_description', $model->seo_description ?? 'Ремонт ' . $model->name . ' в Екатеринбурге: оригинальные запчасти, гарантия до 2 лет')
@section('og_title', $model->seo_title ?? 'Ремонт ' . $model->name)
@section('og_description', $model->seo_description ?? 'Ремонт ' . $model->name . ' с бесплатной диагностикой и гарантией')
@section('og_image', asset('images/logo.png'))
@section('og_url', route('catalog.model', ['categorySlug' => $category->slug, 'brandSlug' => $brand->slug, 'modelSlug' => $model->slug]))

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => $categoryLabel, route('catalog.resolve', ['categorySlug' => $category->slug, 'slug' => $brand->slug]) => $brand->name, '' => $model->name]" />

    <x-hero-banner 
        :title="$model->seo_h1 ?: 'Ремонт ' . $model->name"
        :subtitle="'Закажите ремонт ' . $model->name . ' с бесплатной диагностикой'"
    />

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Цены на ремонт {{ $model->name }}</h2>
    </div>
    
    <x-price-table :rows="$priceRows" />

    {{-- ЗАДАЧА 2: сначала поломки, потом преимущества --}}
    <x-defects-block :defects="$defects" :brand="$brand" :model="$model" />

    <x-advantages-block />

    @php
        $otherModels = \App\Models\DeviceModel::where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->where('id', '!=', $model->id)
            ->where('status', 'active')
            ->limit(8)
            ->get();
    @endphp

    @if($otherModels->count() > 0)
        <section class="py-10 max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 text-center">Другие модели {{ $brand->name }}</h2>
            <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                @foreach($otherModels as $m)
                    <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $m->slug]) }}" 
                       class="border border-gray-100 rounded-xl px-6 py-4 text-center hover:shadow-md transition-shadow bg-white hover:bg-[#2AC0D5]/5 font-medium text-gray-700">
                        {{ $m->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <x-workflow-block />

    {{-- Акции перед отзывами --}}
    <x-promo-banner :banners="$banners ?? collect()" />

    <x-reviews-block :reviews="$reviews" />

    <x-contact-form />
@endsection
