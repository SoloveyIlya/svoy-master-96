@extends('layouts.app')

@section('title', 'Частые поломки и неисправности')
@section('seo_description', 'Симптомы, причины и решения для самых популярных неисправностей вашей техники')
@section('og_title', 'Частые поломки и неисправности - Svoy Master')
@section('og_description', 'Узнайте о распространённых поломках оборудования и получите рекомендации мастеров')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'Частые поломки']" />

    <x-hero-banner 
        title="Частые поломки"
        subtitle="Симптомы, причины и решения для самых популярных неисправностей вашей техники"
    />

    <section class="max-w-7xl mx-auto px-4 py-12">
        @if ($defects->isEmpty())
            <p class="text-center text-gray-500">Список поломок пока пуст.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($defects as $defect)
                    <a href="{{ route('catalog.defect', [$defect->category->slug, $defect->slug]) }}" class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-[#2AC0D5] transition-all group">
                        <h3 class="text-xl font-bold text-[#1A1A1A] mb-3 group-hover:text-[#0678A8] transition-colors">{{ $defect->name }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $defect->description }}</p>
                        <span class="inline-flex items-center text-[#2AC0D5] font-semibold mt-4 text-sm group-hover:text-[#0678A8] transition-colors">
                            Подробнее
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
    
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
    <x-workflow-block />
@endsection
