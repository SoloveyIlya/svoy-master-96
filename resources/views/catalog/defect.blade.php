@extends('layouts.app')

@section('title', 'Ремонт: ' . $defect->name . ' - ' . $category->name)
@section('seo_description', 'Профессиональный ремонт: ' . mb_strtolower($defect->name) . ' в ' . mb_strtolower($category->name) . '. Быстрый ремонт с гарантией.')

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => $categoryLabel, '' => $defect->name]" />

    <x-hero-banner 
        :title="$defect->name"
        :subtitle="$defect->description ?? 'Диагностика и устранение неисправности с использованием оригинальных запчастей и гарантией качества.'"
        :price="isset($defect->service) ? $defect->service->price_from : null"
        :duration="isset($defect->service) ? $defect->service->duration_text : null"
    />

    @if($brands->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 mb-6">
        <h2 class="text-3xl font-bold text-center mb-8">Выберите производителя</h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($brands as $b)
                <a href="{{ $defect->getBrandUrl($b) }}" 
                   class="w-36 sm:w-40 md:w-48 flex flex-col items-center justify-center gap-4 border border-gray-100 rounded-2xl p-6 text-center hover:shadow-lg hover:border-[#2AC0D5] transition-all bg-white group">
                    <div class="h-12 w-full flex items-center justify-center">
                        <img src="{{ asset('images/brands/' . $b->slug . '.png') }}" 
                             alt="{{ $b->name }}" 
                             loading="lazy"
                             class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
                        <span class="hidden font-bold text-xl text-gray-300">{{ mb_substr($b->name, 0, 1) }}</span>
                    </div>
                    <span class="font-bold text-[#1A1A1A] group-hover:text-[#0678A8] transition-colors">{{ $b->name }}</span>
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
