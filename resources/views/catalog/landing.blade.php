@extends('layouts.app')

@section('title', $seo['title'] ?? ($service->name . ' ' . $model->name))
@section('seo_description', $seo['description'] ?? ('Профессиональный ремонт ' . $model->name . ' в Екатеринбурге'))
@section('og_title', $seo['title'] ?? ($service->name . ' ' . $model->name))
@section('og_description', $seo['description'] ?? ('Профессиональный ремонт ' . $model->name . ' в Екатеринбурге'))
@section('og_image', asset('images/logo.png'))
@section('og_url', request()->fullUrl())

@if(!empty($seo['canonical_url']))
    @section('canonical', $seo['canonical_url'])
@endif

@if(!empty($seo['noindex']))
    @section('noindex', true)
@endif

@section('content')
    <x-breadcrumbs :links="[
        route('catalog.category', [$category->slug]) => $categoryLabel,
        route('catalog.brand', [$category->slug, $brand->slug]) => $brand->name,
        route('catalog.model', [$category->slug, $brand->slug, $model->slug]) => $model->name,
        '' => $service->name
    ]" />

    <x-hero-banner 
        :title="$seo['h1'] ?? ($service->name . ' на ' . $model->name)"
        subtitle="Профессиональный ремонт в Екатеринбурге с гарантией до 1 года. Используем оригинальные запчасти."
        :price="$landing->resolvedPriceFrom()"
        :duration="$landing->resolvedDurationText()"
    />

    @if(!empty($seo['intro']))
        <section class="max-w-5xl mx-auto px-4 sm:px-6 mt-12 prose-content">
            {!! $seo['intro'] !!}
        </section>
    @endif

    <section class="max-w-5xl mx-auto px-4 sm:px-6 mt-16 -mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A] text-center">Цены на другие услуги для {{ $model->name }}</h2>
    </section>
    
    <x-price-table :rows="$priceRows" :activeSlug="$activeSlug" />

    {{-- ЗАДАЧА 2: сначала поломки, потом преимущества --}}
    <x-defects-block :defects="$defects" :brand="$brand" :model="$model" />

    <x-advantages-block />

    @if(!empty($seo['body']))
        <section class="max-w-5xl mx-auto px-4 sm:px-6 my-16 prose-content">
            {!! $seo['body'] !!}
        </section>
    @endif

    <x-workflow-block />

    {{-- Акции перед отзывами --}}
    <x-promo-banner :banners="$banners ?? collect()" />

    <x-reviews-block :reviews="$reviews" />

    <x-contact-form title="Оставить заявку на ремонт" />

    @if(!empty($seo['faq']) && is_array($seo['faq']))
         <section class="max-w-5xl mx-auto px-4 sm:px-6 py-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A] mb-10 text-center">Часто задаваемые вопросы</h2>
            <div class="space-y-4">
                @foreach($seo['faq'] as $item)
                    <details class="group bg-white border border-gray-200 rounded-2xl p-6 transition-all hover:shadow-md">
                        <summary class="flex justify-between items-center font-bold text-lg cursor-pointer list-none">
                            {{ $item['question'] }}
                            <span class="text-[#2AC0D5] group-open:rotate-180 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <div class="mt-4 text-gray-600 leading-relaxed border-t border-gray-100 pt-4">
                            {{ $item['answer'] }}
                        </div>
                    </details>
                @endforeach
            </div>
         </section>
    @endif

@endsection
