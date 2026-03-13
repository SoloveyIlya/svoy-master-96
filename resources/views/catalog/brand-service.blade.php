@extends('layouts.app')

@section('title', $seo['title'] ?? $service->name . ' — ' . $brand->name)
@section('meta_description', $seo['description'] ?? '')

@section('content')
    <section class="page-container catalog-page">
        <div class="catalog-card space-y-4">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">← Назад к бренду</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('catalog.category', [$category->slug]) }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">К категории</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('home') }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">На главную</a>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">{{ $seo['h1'] ?? $service->name }}</h1>
        </div>

        @if($seo['intro'])
            <div class="catalog-card mt-6 prose-content">{!! $seo['intro'] !!}</div>
        @endif

        <div class="catalog-card mt-6">
            <h2 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] mb-4">Debug: Переменные</h2>
            <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto">Category: {{ $category->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto mt-3">Brand: {{ $brand->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto mt-3">Service: {{ $service->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto mt-3">Scope: {{ $scope->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto mt-3">SEO Data: {{ json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </section>
@endsection
