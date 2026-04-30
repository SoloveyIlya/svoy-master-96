@extends('layouts.app')

@section('title', $model->seo_title ?? 'Ремонт ' . $model->name . ' в Екатеринбурге')
@section('seo_description', $model->seo_description ?? 'Ремонт ' . $model->name . ' в Екатеринбурге: оригинальные запчасти, гарантия до 2 лет')
@section('og_title', $model->seo_title ?? 'Ремонт ' . $model->name)
@section('og_description', $model->seo_description ?? 'Ремонт ' . $model->name . ' с бесплатной диагностикой и гарантией')
@section('og_image', asset('images/logo.png'))
@section('og_url', route('catalog.model', ['categorySlug' => $category->slug, 'brandSlug' => $brand->slug, 'modelSlug' => $model->slug]))

@section('content')
    <x-breadcrumbs :links="[route('catalog.category', ['categorySlug' => $category->slug]) => $categoryLabel, route('catalog.resolve', ['categorySlug' => $category->slug, 'slug' => $brand->slug]) => $brand->name, '' => $model->name]" />

    <x-hero-banner 
        :title="$model->seo_h1 ?: 'Ремонт ' . $model->name"
        :subtitle="'Закажите ремонт ' . $model->name . ' с бесплатной диагностикой'"
    />

    <div class="max-w-7xl mx-auto px-4 mb-4">
        <h2 class="text-3xl font-bold mt-10 text-center">Цены на ремонт {{ $model->name }}</h2>
    </div>
    
    <x-price-table :rows="$priceRows" />

    {{-- ЗАДАЧА 2: сначала поломки, потом преимущества --}}
    <x-defects-block :defects="$defects" :brand="$brand" :model="$model" />

    <x-advantages-block />

    @php
        $otherModels = \App\Models\DeviceModel::where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->where('id', '!=', $model->id)
            ->where('status', 'active')
            ->limit(8)
            ->get();
    @endphp

    @if($otherModels->count() > 0)
        <section class="py-10 max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 text-center">Другие модели {{ $brand->name }}</h2>
            <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                @foreach($otherModels as $m)
                    <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $m->slug]) }}" 
                       class="border border-gray-100 rounded-xl px-6 py-4 text-center hover:shadow-md transition-shadow bg-white hover:bg-[#2AC0D5]/5 font-medium text-gray-700">
                        {{ $m->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <x-workflow-block />

    {{-- Акции перед отзывами --}}
    <x-promo-banner :banners="$banners ?? collect()" />

    <x-reviews-block :reviews="$reviews" />
    {{-- SEO-текст с спойлером (модель) --}}
    @if(!empty($model->seo_bottom_text))
        <div class="max-w-[87.5rem] mx-auto px-4 py-12">
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
                    @php
                        $seo = str_replace(['<модель>', '&lt;модель&gt;'], $model->name, $model->seo_bottom_text);
                        // Убираем дублирующиеся подряд слова (например "iPad iPad Air" -> "iPad Air")
                        $seo = preg_replace('/\b(\p{L}+)\s+\1\b/ui', '$1', $seo);
                    @endphp
                    {!! $seo !!}
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
