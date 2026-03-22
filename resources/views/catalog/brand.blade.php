@extends('layouts.app')

@section('content')
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

    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" />
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
