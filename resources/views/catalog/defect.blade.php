@extends('layouts.app')

@section('title', 'Ремонт: ' . $defect->name . ' - ' . $category->name)
@section('seo_description', 'Профессиональный ремонт: ' . mb_strtolower($defect->name) . ' в ' . mb_strtolower($category->name) . '. Быстрый ремонт с гарантией.')

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => 'Ремонт ' . $category->name, '' => $defect->name]" />

    <x-hero-banner 
        :title="$defect->name"
        :subtitle="$defect->description ?? 'Диагностика и устранение неисправности с использованием оригинальных запчастей и гарантией качества.'"
        :price="isset($defect->service) ? $defect->service->price_from : null"
        :duration="isset($defect->service) ? $defect->service->duration_text : null"
    />

    @if($brands->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 mb-6">
        <h2 class="text-3xl font-bold text-center mb-8">Выберите производителя</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($brands as $b)
                <a href="{{ route('catalog.brand', [$category->slug, $b->slug]) }}" 
                   class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#0678A8] hover:shadow-md transition-all group">
                    <span class="font-bold text-gray-800 group-hover:text-[#0678A8] transition-colors">{{ $b->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Все цены на услуги: {{ $category->name }}</h2>
    </div>

    <x-price-table :rows="$priceRows" :active-slug="$activeSlug ?? null" />

    <x-advantages-block />

    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" :active-slug="$activeSlug ?? null" />
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
