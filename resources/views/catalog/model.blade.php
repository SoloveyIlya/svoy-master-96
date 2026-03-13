@extends('layouts.app')

@section('title', $model->seo_title ?? $model->name . ' — ' . $brand->name)
@section('meta_description', $model->seo_description ?? '')

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

            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">{{ $model->seo_h1 ?? $model->name }}</h1>
            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>SEO title:</strong> {{ $model->seo_title ?? '-' }}</p>
                <p><strong>SEO description:</strong> {{ $model->seo_description ?? '-' }}</p>
                <p><strong>Категория / Бренд:</strong> {{ $category->name }} / {{ $brand->name }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] mb-4">Услуги</h2>
            @if($landingPages->isEmpty())
                <p class="text-gray-500">Услуги не найдены.</p>
            @else
                <div class="catalog-list">
                    @foreach($landingPages as $landingPage)
                        @if($landingPage->service)
                            <a href="{{ route('catalog.landing', [$category->slug, $brand->slug, $model->slug, $landingPage->service->slug]) }}">
                                {{ $landingPage->service->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
