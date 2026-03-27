@extends('layouts.app')

@section('title', $brand->seo_title ?? 'Ремонт ' . $brand->name . ' в Екатеринбурге')
@section('seo_description', $brand->seo_description ?? 'Ремонт ' . $brand->name . ' в Екатеринбурге: смартфонов, ноутбуков, планшетов с гарантией')
@section('og_title', $brand->seo_title ?? 'Ремонт ' . $brand->name)
@section('og_description', $brand->seo_description ?? 'Ремонт ' . $brand->name . ' с гарантией и честными ценами')
@section('og_image', asset('images/logo.png'))
@section('og_url', route('catalog.brand', ['categorySlug' => $category->slug, 'brandSlug' => $brand->slug]))

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => 'Ремонт ' . $category->name, '' => $brand->name]" />

    <x-hero-banner 
        :title="$brand->seo_h1 ?: 'Ремонт ' . $brand->name"
        :subtitle="'Честные цены и гарантия на ремонт устройств ' . $brand->name"
    />

    @if($models->count() > 0)
        <section class="py-10 max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6 text-center">Модели {{ $brand->name }}</h2>
            <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                @foreach($models as $m)
                    <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $m->slug]) }}" 
                       class="border border-gray-100 rounded-xl px-6 py-4 text-center hover:shadow-md transition-shadow bg-white hover:bg-[#2AC0D5]/5 font-semibold text-gray-800">
                        {{ $m->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mt-10 text-center mb-2">Цены на услуги</h2>
    </div>
    <x-price-table :rows="$priceRows" />

    <x-advantages-block />

    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" />
    @if(!empty($seoBottomText))
        <div class="max-w-[87.5rem] mx-auto px-4 py-12 prose prose-lg max-w-none text-gray-600 prose-headings:text-[#0678A8] prose-a:text-[#2AC0D5]">
            {!! $seoBottomText !!}
        </div>
    @endif

    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
