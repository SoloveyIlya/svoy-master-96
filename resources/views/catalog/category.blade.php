@extends('layouts.app')

@section('content')
    <x-hero-banner 
        :title="$category->seo_h1 ?: $category->name"
        :subtitle="'Профессиональный ремонт ' . mb_strtolower($category->name) . ' в Екатеринбурге с гарантией'"
    />

    @if($brands->count() > 0)
        <section class="py-10 max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6 text-center">Выберите бренд</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($brands as $b)
                    <a href="{{ route('catalog.brand', [$category->slug, $b->slug]) }}" 
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
        </section>
    @endif

    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mt-10 text-center mb-2">Наши цены</h2>
    </div>
    <x-price-table :rows="$priceRows" />

    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" />
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
