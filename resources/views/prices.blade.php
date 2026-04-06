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

    <div class="max-w-5xl mx-auto px-4 mt-8 mb-16">

        {{-- Main categories with service lists --}}
        @foreach($mainCategories as $category)
            @php
                $rows = $priceRowsByCategory[$category->slug] ?? [];
            @endphp

            <div class="mb-12">
                <div class="flex items-center justify-between border-b-2 border-[#0678A8] pb-3 mb-2">
                    <a href="{{ route('catalog.category', $category->slug) }}"
                        class="text-2xl sm:text-3xl font-extrabold text-gray-900 hover:text-[#0678A8] transition flex items-center gap-2 group">
                        {{ $category->name }}
                        <svg class="w-5 h-5 text-[#0678A8] opacity-0 group-hover:opacity-100 transition -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('catalog.category', $category->slug) }}"
                        class="hidden sm:flex items-center gap-1 text-sm text-[#0678A8] hover:text-[#2AC0D5] font-medium transition">
                        Все услуги категории
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @if(count($rows) > 0)
                    <x-price-table
                        :rows="$rows"
                        :collapse-after="10"
                        :collapse-group-id="$category->slug"
                    />
                @else
                    <div class="text-center py-10 text-gray-400">
                        <p>Прайс для этой категории скоро появится.</p>
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Other categories as tiles --}}
        @if($otherCategories->count() > 0)
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-[#1A1A1A] mb-6">Другие устройства</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($otherCategories as $category)
                        <a
                            href="{{ route('catalog.category', $category->slug) }}"
                            class="block bg-white border-2 border-gray-200 rounded-2xl p-5 text-center font-semibold text-gray-700 hover:border-[#2AC0D5] hover:text-[#0678A8] hover:shadow-md transition"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <x-advantages-block />

    <x-defects-block :categories="$defectCategories ?? collect()" />
    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.price-show-more-btn');
        if (!btn || !btn.dataset.slug) return;
        var slug = btn.dataset.slug;
        document.querySelectorAll('li[data-price-collapsed="' + slug + '"]').forEach(function (li) {
            li.classList.remove('hidden');
        });
        var footer = btn.closest('.price-show-more-footer');
        if (footer) footer.classList.add('hidden');
    });
</script>
@endpush
