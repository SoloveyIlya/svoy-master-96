@extends('layouts.app')

@section('title', $brand->seo_title ?? $brand->name . ' — ' . $category->name)
@section('meta_description', $brand->seo_description ?? '')

@section('content')
    <section class="page-container catalog-page">
        <div class="catalog-card space-y-4">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a href="{{ route('catalog.category', [$category->slug]) }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">← Назад к категории</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('home') }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">На главную</a>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">{{ $brand->seo_h1 ?? $brand->name }}</h1>
            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>SEO title:</strong> {{ $brand->seo_title ?? '-' }}</p>
                <p><strong>SEO description:</strong> {{ $brand->seo_description ?? '-' }}</p>
                <p><strong>Категория:</strong> {{ $category->name }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] mb-4">Модели</h2>
            @if($models->isEmpty())
                <p class="text-gray-500">Модели не найдены.</p>
            @else
                <div class="catalog-list">
                    @foreach($models as $deviceModel)
                        <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $deviceModel->slug]) }}">
                            {{ $deviceModel->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
