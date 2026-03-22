@extends('layouts.app')

@section('content')
    <x-hero-banner 
        :title="$category->seo_h1 ?: $category->name"
        :subtitle="'Профессиональный ремонт ' . mb_strtolower($category->name) . ' в Екатеринбурге с гарантией'"
    />

    @if($brands->count() > 0)
        <section class="py-10 max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6 text-center">Выберите бренд</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($brands as $b)
                    <a href="{{ route('catalog.brand', [$category->slug, $b->slug]) }}" 
                       class="border border-gray-100 rounded-xl p-4 text-center hover:shadow-md transition-shadow bg-white hover:bg-[#2AC0D5]/5 font-semibold text-gray-800">
                        {{ $b->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mt-10 text-center mb-2">Наши цены</h2>
    </div>
    <x-price-table :rows="$priceRows" />

    <x-steps-block />
    <x-cases-block :cases="$cases" />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" />
    <x-contact-form />
@endsection
