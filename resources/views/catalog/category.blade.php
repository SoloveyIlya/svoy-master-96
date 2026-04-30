@extends('layouts.app')

@section('title', $category->seo_title ?? 'Ремонт ' . $category->name . ' в Екатеринбурге')
@section('seo_description', $category->seo_description ?? 'Профессиональный ремонт ' . mb_strtolower($category->name) . ' в Екатеринбурге с гарантией')
@section('og_title', $category->seo_title ?? 'Ремонт ' . $category->name)
@section('og_description', $category->seo_description ?? 'Профессиональный ремонт ' . mb_strtolower($category->name) . ' в Екатеринбурге с гарантией')
@section('og_image', asset('images/logo.png'))
@section('og_url', route('catalog.category', ['categorySlug' => $category->slug]))

@section('content')
    <x-breadcrumbs :links="['' => $categoryLabel]" />

    <x-hero-banner 
        :title="$category->seo_h1 ?: $categoryLabel"
        :subtitle="'Профессиональный ' . mb_strtolower($categoryLabel) . ' в Екатеринбурге с гарантией'"
    />

    @if($brands->count() > 0)
        <section class="py-10 max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6 text-center">Выберите бренд</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($brands as $b)
                    <a href="{{ route('catalog.resolve', [$category->slug, $b->slug]) }}" 
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

    {{-- ЗАДАЧА 2: сначала поломки, потом преимущества --}}
    <x-defects-block :defects="$defects" />

    <x-advantages-block />

    <x-workflow-block />

    {{-- Акции перед отзывами --}}
    <x-promo-banner :banners="$banners ?? collect()" />

    <x-reviews-block :reviews="$reviews" />

    {{-- SEO-текст с спойлером --}}
    @if(!empty($category->seo_bottom_text))
        <div class="max-w-[87.5rem] mx-auto px-4 py-12">
            <div
                x-data="seoSpoiler()"
                x-init="init()"
                class="relative"
            >
                {{-- Контент --}}
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
                    {!! $category->seo_bottom_text !!}
                </div>

                {{-- Градиент и кнопка "Показать ещё" --}}
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
@endsection

@push('scripts')
<script>
function seoSpoiler() {
    return {
        expanded: false,
        needsSpoiler: false,
        init() {
            this.$nextTick(() => {
                // Показываем спойлер только если контент выше 520px
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
