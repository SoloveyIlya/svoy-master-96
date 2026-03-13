@extends('layouts.app')

@section('title', $seo['title'] ?? $service->name . ' ' . $model->name)
@section('meta_description', $seo['description'] ?? '')

@if($seo['canonical_url'])
    @section('canonical', $seo['canonical_url'])
@endif

@if($seo['noindex'])
    @section('noindex', true)
@endif

@section('content')
    <section class="page-container catalog-page">
        <div class="catalog-card space-y-4">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $model->slug]) }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">← Назад к модели</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">К бренду</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('catalog.category', [$category->slug]) }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">К категории</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('home') }}" class="text-[#0678A8] hover:text-[#2AC0D5] transition">На главную</a>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">{{ $seo['h1'] ?? $service->name . ' ' . $model->name }}</h1>
            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>Цена от:</strong> {{ $landing->resolvedPriceFrom() ?? '-' }}</p>
                <p><strong>Срок ремонта:</strong> {{ $service->duration_text ?? '-' }}</p>
                <p><strong>Гарантия:</strong> {{ $service->warranty_text ?? '-' }}</p>
                <p><strong>SEO title:</strong> {{ $seo['title'] ?? '-' }}</p>
                <p><strong>SEO description:</strong> {{ $seo['description'] ?? '-' }}</p>
            </div>
        </div>

        @if($seo['intro'])
            <div class="catalog-card mt-6 prose-content">
                {!! $seo['intro'] !!}
            </div>
        @endif

        @if($seo['body'])
            <div class="catalog-card mt-6 prose-content">
                {!! $seo['body'] !!}
            </div>
        @endif

        @if($seo['faq'])
            <div class="catalog-card mt-6">
                <h2 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] mb-4">FAQ</h2>
                <div class="space-y-3">
                    @foreach($seo['faq'] as $item)
                        <details class="border border-gray-200 rounded-xl px-4 py-3">
                            <summary class="font-semibold cursor-pointer">{{ $item['question'] }}</summary>
                            <p class="text-sm text-gray-600 mt-2">{{ $item['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="catalog-card mt-6">
            <h2 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] mb-4">Оставить заявку</h2>
            @if(session('success'))
                <p class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">{{ session('success') }}</p>
            @endif

            <form action="{{ route('leads.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">
                <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">

                <div>
                    <label for="name" class="block text-sm font-medium mb-1">Имя</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#2AC0D5]">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium mb-1">Телефон *</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#2AC0D5]">
                    @error('phone')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium mb-1">Комментарий</label>
                    <textarea id="comment" name="comment" rows="4" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#2AC0D5]">{{ old('comment') }}</textarea>
                </div>

                <div>
                    <label class="inline-flex items-start gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="agree" value="1" {{ old('agree') ? 'checked' : '' }} class="mt-1">
                        <span>Согласен на обработку персональных данных</span>
                    </label>
                    @error('agree')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full sm:w-auto bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-semibold px-6 py-3 rounded-full transition">
                    Отправить заявку
                </button>
            </form>
        </div>
    </section>
@endsection
