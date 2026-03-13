@extends('layouts.app')

@section('title', $category->seo_title ?? $category->name)
@section('meta_description', $category->seo_description ?? '')

@section('content')
    <section class="page-container catalog-page">
        <div class="catalog-card space-y-4">
            <a href="{{ route('home') }}" class="inline-flex text-sm text-[#0678A8] hover:text-[#2AC0D5] transition">← Назад на главную</a>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">{{ $category->seo_h1 ?? $category->name }}</h1>

            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>SEO title:</strong> {{ $category->seo_title ?? '-' }}</p>
                <p><strong>SEO description:</strong> {{ $category->seo_description ?? '-' }}</p>
                <p><strong>Описание:</strong> {{ $category->seo_intro ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] mb-4">Бренды</h2>
            @if($brands->isEmpty())
                <p class="text-gray-500">Бренды не найдены.</p>
            @else
                <div class="catalog-list">
                    @foreach($brands as $brand)
                        <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}">
                            {{ $brand->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
