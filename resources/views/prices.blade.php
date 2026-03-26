@extends('layouts.app')

@section('title', 'Цены на ремонт')
@section('seo_description', 'Прозрачный прайс-лист на все основные услуги по ремонту. Бесплатная диагностика.')
@section('og_title', 'Цены на ремонт - Svoy Master')
@section('og_description', 'Экономные и прозрачные цены на ремонт. Нет скрытых доплат')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'Цены на ремонт']" />

    <x-hero-banner 
        title="Цены на ремонт"
        subtitle="Прозрачный прайс-лист без скрытых доплат. Выберите категорию вашего устройства."
    />

    <div class="max-w-5xl mx-auto px-4 mt-8">
        @foreach($categorizedServices as $categoryName => $rows)
            @if(count($rows) > 0)
            <div class="mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 border-b-2 border-[#0678A8] pb-3 mb-6 inline-block">{{ $categoryName }}</h2>
                <x-price-table :rows="$rows" />
            </div>
            @endif
        @endforeach
    </div>

    <x-advantages-block />

    <x-defects-block :defects="$defects" />
    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
