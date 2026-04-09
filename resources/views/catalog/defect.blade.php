@extends('layouts.app')

@section('title', 'Ремонт: ' . $defect->name . ' - ' . $category->name)
@section('seo_description', 'Профессиональный ремонт: ' . mb_strtolower($defect->name) . ' в ' . mb_strtolower($category->name) . '. Быстрый ремонт с гарантией.')

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => $categoryLabel, '' => $defect->name]" />

    <x-hero-banner 
        :title="$defect->name"
        :subtitle="$defect->description ?? 'Диагностика и устранение неисправности с использованием оригинальных запчастей и гарантией качества.'"
        :price="isset($defect->service) ? $defect->service->price_from : null"
        :duration="isset($defect->service) ? $defect->service->duration_text : null"
    />

    @if($brands->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 mb-6">
        <h2 class="text-3xl font-bold text-center mb-8">Выберите производителя</h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($brands as $b)
                <a href="{{ $defect->getBrandUrl($b) }}" 
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
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Все цены на услуги: {{ $category->name }}</h2>
    </div>

    <x-price-table :rows="$priceRows" :active-slug="$activeSlug ?? null" />

    <x-advantages-block />

    <x-workflow-block />
    <x-reviews-block :reviews="$reviews" />
    <x-defects-block :defects="$defects" :active-slug="$activeSlug ?? null" />

    @if(!empty($defect->seo_bottom_text))
        <div class="max-w-4xl mx-auto px-4 py-12 bg-white">
            <div
                x-data="seoSpoiler()"
                x-init="init()"
                class="relative"
            >
                <div
                    x-ref="content"
                    :class="expanded ? '' : 'max-h-[520px] overflow-hidden'"
                    class="
                        prose prose-lg max-w-none
                        prose-headings:text-[#0678A8] prose-headings:font-bold
                        prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-3
                        prose-p:text-gray-600 prose-p:leading-relaxed
                        prose-strong:font-semibold prose-strong:not-italic
                        prose-a:text-[#2AC0D5] prose-a:no-underline hover:prose-a:underline
                        prose-ul:text-gray-600 prose-li:my-1
                        transition-all duration-500
                    "
                >
                    {!! $defect->seo_bottom_text !!}
                </div>

                <div
                    x-show="needsSpoiler && !expanded"
                    class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-white to-transparent flex items-end justify-center pb-4"
                >
                    <button
                        @click="expanded = true"
                        type="button"
                        class="inline-flex items-center gap-2 bg-white border border-[#0678A8] text-[#0678A8] font-semibold px-6 py-2.5 rounded-full shadow-sm hover:bg-[#0678A8] hover:text-white transition"
                    >
                        Показать ещё
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection

@push('scripts')
<script>
function seoSpoiler() {
    return {
        expanded: false,
        needsSpoiler: false,
        init() {
            this.$nextTick(() => {
                const el = this.$refs.content;
                if (el && el.scrollHeight > 520) {
                    this.needsSpoiler = true;
                }
            });
        }
    }
}
</script>
@endpush
