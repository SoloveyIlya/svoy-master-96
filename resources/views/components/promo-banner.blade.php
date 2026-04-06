@props(['banners' => collect()])

{{-- Прomo-баннер перед блоком отзывов --}}
<section class="max-w-[87.5rem] mx-auto px-4 py-6">
    <x-banners-slider :banners="$banners" />
</section>
