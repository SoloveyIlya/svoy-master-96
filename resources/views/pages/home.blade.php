@extends('layouts.app')

@section('title', 'Свой Мастер - Ремонт цифровой техники в Екатеринбурге')
@section('seo_description', 'Ремонт смартфонов, ноутбуков и планшетов в Екатеринбурге. Бесплатная диагностика, гарантия до 2 лет, честные цены')
@section('og_title', 'Свой Мастер - Ремонт цифровой техники')
@section('og_description', 'Профессиональный ремонт техники в Екатеринбурге. Честные цены, оригинальные запчасти, гарантия до 2 лет')
@section('og_image', asset('images/logo.png'))
@section('og_type', 'website')

@push('styles')
<style>
    @keyframes slideInUp {
        from { transform: translateY(100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-in-up {
        animation: slideInUp 0.8s ease-out forwards;
    }
    .flip-char {
        display: inline-block;
        transform-style: preserve-3d;
        transform-origin: 50% 50%;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.6s ease;
    }
    .flip-out {
        transform: rotateX(90deg);
        opacity: 0;
    }
    .flip-in {
        transform: rotateX(-90deg);
        opacity: 0;
    }
    .flip-normal {
        transform: rotateX(0deg);
        opacity: 1;
    }
</style>
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="max-w-[87.5rem] mx-auto px-4 pt-8 sm:pt-10 pb-12 sm:pb-16 lg:pb-24 relative overflow-hidden">
        <div class="relative z-10 lg:max-w-[55%]">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[2.875rem] font-bold leading-[1.2] mb-8 sm:mb-10 text-[#1A1A1A]">
                <div class="flex flex-wrap items-center gap-x-2">
                    <span id="animated-word-container" class="text-[#2AC0D5] inline-block relative whitespace-nowrap overflow-visible perspective-[1000px] transition-[width] duration-300 ease-in-out"></span>
                    <span class="text-[#1A1A1A]">ремонт</span>
                </div>
                <div class="mt-2">техники - в Екатеринбурге от 450 рублей</div>
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 sm:gap-y-8 gap-x-4 mb-10 sm:mb-12">
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8] flex-shrink-0" fill="currentColor" viewBox="0 0 60 60">
                        <path d="M31.25 17.25C35.7 17.25 37.35 19.375 37.5 22.5H43.025C42.85 18.2 40.225 14.25 35 12.975V7.5H27.5V12.9C26.525 13.1 25.625 13.425 24.75 13.8L28.525 17.575C29.325 17.375 30.25 17.25 31.25 17.25ZM13.675 9.8L10.15 13.325L18.75 21.925C18.75 27.125 22.65 29.975 28.525 31.7L37.3 40.475C36.45 41.7 34.675 42.75 31.25 42.75C26.1 42.75 24.075 40.45 23.8 37.5H18.3C18.6 42.975 22.7 46.05 27.5 47.075V52.5H35V47.125C37.4 46.675 39.575 45.75 41.15 44.325L46.7 49.875L50.225 46.35L13.675 9.8Z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Бесплатная</h3>
                        <p class="text-gray-500 text-sm">Диагностика устройства</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">До 2-х лет</h3>
                        <p class="text-gray-500 text-sm">Гарантия на работы</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Не более 30 минут</h3>
                        <p class="text-gray-500 text-sm">Среднее время ремонта</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8] flex-shrink-0" fill="currentColor" viewBox="0 0 40 40">
                        <path d="M20 36.6666C21.8333 36.6666 23.3333 35.1666 23.3333 33.3333H16.6666C16.6666 35.1666 18.1666 36.6666 20 36.6666ZM20 10.8333C24.15 10.8333 26.6666 14.2 26.6666 18.3333V18.5L30 21.8333V18.3333C30 13.2166 27.2833 8.93329 22.5 7.79996V6.66663C22.5 5.28329 21.3833 4.16663 20 4.16663C18.6166 4.16663 17.5 5.28329 17.5 6.66663V7.79996C17.1 7.89996 16.7166 8.04996 16.35 8.18329L19.0833 10.9166C19.3833 10.8833 19.6833 10.8333 20 10.8333ZM9.01663 5.58329L6.66663 7.93329L11.35 12.6166C10.4833 14.2833 9.99996 16.2333 9.99996 18.3333V26.6666L6.66663 30V31.6666H30.4L33.3 34.5666L35.65 32.2166L9.01663 5.58329ZM26.6666 28.3333H13.3333V18.3333C13.3333 17.2 13.5333 16.1333 13.9 15.1666L26.6666 27.9333V28.3333Z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Конфиденциально</h3>
                        <p class="text-gray-500 text-sm">Ваши данные в сохранности</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                <button
                    type="button"
                    class="js-open-modal w-full sm:w-auto bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-medium py-3 px-6 sm:px-8 rounded-[2rem] transition shadow-md"
                    data-cta-title="Узнать цену ремонта бесплатно"
                >
                    Узнать цену ремонта бесплатно
                </button>
                <button
                    type="button"
                    class="js-open-modal w-full sm:w-auto border-2 border-[#2AC0D5] text-[#2AC0D5] hover:bg-[#2AC0D5] hover:text-white font-medium py-3 px-6 sm:px-8 rounded-[2rem] transition"
                    data-cta-title="Вызвать курьера"
                >
                    Вызвать курьера
                </button>
            </div>
        </div>

        <div class="absolute -right-20 sm:-right-48 lg:right-0 top-1/2 -translate-y-1/2 w-[300px] sm:w-[350px] lg:w-[550px] xl:w-[650px] z-0 pointer-events-none transition-all duration-500 opacity-40 sm:opacity-100">
            <img src="{{ asset('images/iphonelogo.svg') }}" alt="Ремонт техники" class="w-full object-contain drop-shadow-2xl opacity-100 lg:opacity-100" />
        </div>
    </section>

    {{-- PROMO SLIDER SECTION --}}
    <x-banners-slider :banners="$banners ?? collect()" />

    {{-- ПОЛОМКИ (с табами по категориям) --}}
    <x-defects-block :categories="$defectCategories ?? collect()" />

    {{-- ЗАМЕНА СТЕКЛА (С ТАБАМИ МАРКИ) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-8">
            <div class="bg-[#0678A8] rounded-[2rem] relative flex flex-col-reverse md:flex-row items-end pt-8 px-6 sm:px-8 pb-0 md:pt-12 md:px-12 md:pb-0 shadow-xl overflow-hidden">
                
                <div class="absolute inset-0 bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] opacity-90 z-0 rounded-[2rem]"></div>
                
                <div class="relative z-10 md:w-1/3 self-end -mb-10 md:mb-0">
                    <img src="{{ asset('images/broken-phone.png') }}" 
                        alt="Разбитое стекло" 
                        class="opacity-0 js-scroll-trigger w-[120%] sm:w-[110%] md:w-full transform transition-transform duration-300 scale-110 md:scale-[1.28] drop-shadow-2xl object-contain origin-bottom" />
                </div>

                <div class="relative z-10 md:w-2/3 md:pl-16 text-white py-8 md:py-12 self-center">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4">Замена стекла</h2>
                <p class="text-white/80 mb-8 max-w-2xl leading-relaxed">
                    Если изображение и сенсор работают — часто можно заменить только стекло, без замены всего дисплейного модуля. Это выгоднее и аккуратнее для устройства.
                </p>

                <div class="mb-4">
                    <p class="font-semibold mb-3">Выберите марку устройства:</p>
                    <div class="flex flex-wrap gap-2" id="brand-tabs">
                        @foreach($phoneBrands as $index => $brand)
                        <button onclick="changeBrandTab('{{ $brand->slug }}', this)" 
                            class="brand-tab {{ $index === 0 ? 'active bg-white text-[#0678A8]' : 'bg-white/20 hover:bg-white/40 text-white' }} px-5 py-2 rounded-full font-medium transition">
                            {{ $brand->name }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 border-t border-white/20 pt-6">
                    @foreach($phoneBrands as $index => $brand)
                    <div id="models-{{ $brand->slug }}" class="models-grid {{ $index === 0 ? '' : 'hidden' }}">
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
                            @foreach($brand->models as $model)
                                <a href="{{ route('catalog.landing', ['categorySlug' => 'remont-telefonov', 'brandSlug' => $brand->slug, 'modelSlug' => $model->slug, 'serviceSlug' => 'zamena-stekla']) }}" class="text-sm text-white/90 hover:text-white hover:underline transition">
                                    {{ $model->name }}
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => $brand->slug]) }}"
                            class="inline-flex items-center gap-1 text-sm text-white/70 hover:text-white border border-white/30 hover:border-white rounded-full px-4 py-1.5 transition mt-1">
                            Другая модель →
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- КАТЕГОРИИ РЕМОНТА (Без выделения Apple) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center mb-10 sm:mb-12 text-[#1A1A1A]">
            Узнайте цену на ремонт, выбрав<br>Ваше устройство
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-telefonov']) }}" class="block relative h-[16rem] sm:h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-6 sm:top-8 left-6 sm:left-8 text-white font-semibold text-xl sm:text-2xl z-10">Ремонт телефонов</span>
                <img src="{{ asset('images/android.svg') }}" alt="Телефоны" loading="lazy" class="absolute bottom-[-8%] left-0 right-0 mx-auto sm:mx-0 w-[58%] sm:w-[80%] sm:left-auto sm:right-[0%] object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-noutbukov']) }}" class="block relative h-[16rem] sm:h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-6 sm:top-8 left-6 sm:left-8 text-white font-semibold text-xl sm:text-2xl z-10">Ремонт ноутбуков</span>
                <img src="{{ asset('images/laptop.svg') }}" alt="Ноутбуки" loading="lazy" class="absolute bottom-[-4%] left-0 right-0 mx-auto sm:mx-0 w-[62%] sm:w-[90%] sm:left-auto sm:right-[-5%] object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-planshetov']) }}" class="block relative h-[16rem] sm:h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-6 sm:top-8 left-6 sm:left-8 text-white font-semibold text-xl sm:text-2xl z-10">Ремонт планшетов</span>
                <img src="{{ asset('images/tablet.svg') }}" alt="Планшеты" loading="lazy" class="absolute bottom-[-15%] left-0 right-0 mx-auto sm:mx-0 w-[62%] sm:w-[90%] sm:left-[10%] sm:right-auto object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-smart-chasov']) }}" class="block relative h-[16rem] sm:h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-6 sm:top-8 left-6 sm:left-8 text-white font-semibold text-xl sm:text-2xl z-10">Ремонт смарт-часов</span>
                <img src="{{ asset('images/watch.svg') }}" alt="Смарт-часы" loading="lazy" class="absolute bottom-0 left-0 right-0 mx-auto sm:mx-0 w-[56%] sm:w-[85%] sm:left-auto sm:right-0 object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('prices') }}" class="flex items-center justify-center relative h-[16rem] sm:h-[20rem] rounded-[2rem] border-2 border-[#2AC0D5] bg-white group shadow-sm hover:bg-cyan-50 transition duration-300">
                <span class="text-[#0678A8] font-bold text-xl sm:text-2xl text-center px-6 sm:px-8 group-hover:scale-105 transition duration-300">Смотреть все<br>категории</span>
            </a>
        </div>
    </section>

    {{-- БРЕНДЫ --}}
    <section class="max-w-[87.5rem] mx-auto px-4 pb-16">
        <h2 class="text-2xl font-bold text-center mb-10 text-[#1A1A1A]">Ремонтируем популярные устройства</h2>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 transition duration-500">
            @foreach($popularBrands as $brand)
                @php
                    $categorySlug = $brand->models->first()->category->slug ?? 'remont-telefonov';
                @endphp
                <a href="{{ route('catalog.brand', ['categorySlug' => $categorySlug, 'brandSlug' => $brand->slug]) }}" 
                   class="hover:scale-110 transition-transform block"
                   title="{{ $brand->name }}">
                    <img src="{{ asset('images/brands/' . $brand->slug . '.png') }}" 
                         alt="{{ $brand->name }}" 
                         loading="lazy"
                         class="h-12 object-contain transition" 
                         onerror="this.onerror=null; this.outerHTML='<span class=\'font-bold text-xl text-gray-400\'>{{ $brand->name }}</span>'" />
                </a>
            @endforeach
        </div>
    </section>

    {{-- ПОЧЕМУ ВЫБИРАЮТ НАС --}}
    <x-advantages-block />

    {{-- О КОМПАНИИ И СОТРУДНИКИ (Новые блоки) --}}
    <section class="bg-gray-50 py-16">
        <div class="max-w-[87.5rem] mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- О компании --}}
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-[#1A1A1A]">Информация о компании</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Сервисный центр «Свой Мастер» специализируется на компонентном и модульном ремонте цифровой техники любой сложности. Мы ответственно подходим к каждому заказу, обеспечивая надежный результат.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Наш главный приоритет — честность и качество. Мы используем только проверенные комплектующие, а наши инженеры имеют профильное образование и многолетний опыт восстановления даже «безнадежных» устройств.
                    </p>
                </div>

                {{-- Сотрудники --}}
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-[#1A1A1A]">Наши специалисты</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-[1rem] shadow-sm text-center">
                            <img src="{{ asset('images/oleg.jpg') }}" alt="Мастер Иван" loading="lazy" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover bg-gray-200">
                            <h4 class="font-bold text-[#1A1A1A]">Олег Валерьевич Егоров</h4>
                            <p class="text-xs text-gray-500">Мастер по ремонту телефонов и планшетов, сметчик</p>
                        </div>
                        <div class="bg-white p-4 rounded-[1rem] shadow-sm text-center">
                            <img src="{{ asset('images/kate.jpg') }}" alt="Мастер Алексей" loading="lazy" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover bg-gray-200">
                            <h4 class="font-bold text-[#1A1A1A]">Екатерина Сергеевна Сыропятова</h4>
                            <p class="text-xs text-gray-500">Администратор, мастер по ремонту телефонов и планшетов, системный администратор</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ЭТАПЫ РАБОТ --}}
    <x-workflow-block />

    {{-- ОТЗЫВЫ (Слайдер из БД) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16 bg-gray-50 rounded-[2rem] mb-16">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center mb-8 sm:mb-10 text-[#1A1A1A]">Отзывы наших клиентов</h2>
        
        <div class="relative group" id="reviews-slider">
            {{-- Кнопки навигации (только для десктопа) --}}
            <button id="reviews-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 z-20 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-[#0678A8] hover:bg-[#2AC0D5] hover:text-white transition opacity-0 group-hover:opacity-100 hidden lg:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button id="reviews-next" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 z-20 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-[#0678A8] hover:bg-[#2AC0D5] hover:text-white transition opacity-0 group-hover:opacity-100 hidden lg:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar gap-0 pb-6" id="reviews-track">
                
                {{-- Проверяем наличие переменной $reviews (данные из контроллера) --}}
                @if(isset($reviews) && $reviews->count() > 0)
                    @foreach($reviews as $review)
                    <div class="flex-shrink-0 w-full snap-center px-4 md:px-20 lg:px-40">
                        <div class="bg-white p-8 rounded-[1rem] shadow-sm h-full flex flex-col">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-[#2AC0D5] rounded-full flex justify-center items-center text-white font-bold text-lg">
                                    {{ mb_substr($review->client_name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $review->client_name }}</h4>
                                    <p class="text-xs text-gray-500">{{ optional($review->published_at)->format('d.m.Y') ?? $review->created_at->format('d.m.Y') }}</p>
                                </div>
                            </div>
                            <div class="flex text-[#FFD12A] mb-3 text-sm">
                                @for($i = 0; $i < ($review->rating ?? 5); $i++) ★ @endfor
                            </div>
                            <p class="text-gray-600 text-sm flex-grow">"{{ $review->text }}"</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    {{-- Демонстрационные отзывы, если БД пуста --}}
                    @for($i = 1; $i <= 3; $i++)
                    <div class="flex-shrink-0 w-full snap-center px-4 md:px-20 lg:px-40">
                        <div class="bg-white p-8 rounded-[1rem] shadow-sm h-full flex flex-col">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-[#0678A8] rounded-full flex justify-center items-center text-white font-bold text-lg">О</div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Ольга Г.</h4>
                                    <p class="text-xs text-gray-500">16 декабря 2023</p>
                                </div>
                            </div>
                            <div class="flex text-[#FFD12A] mb-3 text-sm">★★★★★</div>
                            <p class="text-gray-600 text-sm flex-grow">"Мой айфон умер вчера. Привезла к ребятам. Решили проблему за 5 минут и еще и денег не взяли! Просто волшебники!"</p>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>

        {{-- Плашки с отзывами на платформах --}}
        <div class="flex flex-wrap justify-center gap-4 mt-8">
        <a href="https://yandex.by/maps/org/svoy_master/155446185701/?ll=60.589708%2C56.838908&z=16.49" target="_blank" rel="noopener noreferrer"
            class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl px-5 py-3 hover:border-[#2AC0D5] hover:shadow-md transition">
            <img src="{{ asset('images/yandex.png') }}" alt="Яндекс Карты" class="w-6 h-6 object-contain shrink-0">
            <span class="text-2xl font-bold text-[#1A1A1A]">4.9</span>
            <div>
                <div class="flex text-[#FFD12A] text-sm leading-none">★★★★★</div>
                <span class="text-xs text-gray-500">Яндекс Карты</span>
            </div>
        </a>
        <a href="https://2gis.ru/ekaterinburg/firm/70000001007219338/tab/reviews" target="_blank" rel="noopener noreferrer"
            class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl px-5 py-3 hover:border-[#2AC0D5] hover:shadow-md transition">
            <img src="{{ asset('images/2gis.png') }}" alt="2ГИС" class="w-6 h-6 object-contain shrink-0">
            <span class="text-2xl font-bold text-[#1A1A1A]">4.9</span>
            <div>
                <div class="flex text-[#FFD12A] text-sm leading-none">★★★★★</div>
                <span class="text-xs text-gray-500">2ГИС</span>
            </div>
        </a>
        <a href="https://ekaterinburg.flamp.ru/firm/svojj_master_torgovo_servisnaya_kompaniya-70000001007219338" target="_blank" rel="noopener noreferrer"
            class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl px-5 py-3 hover:border-[#2AC0D5] hover:shadow-md transition">
            <img src="{{ asset('images/flamp.png') }}" alt="Flamp" class="w-6 h-6 object-contain shrink-0">
            <span class="text-2xl font-bold text-[#1A1A1A]">5.0</span>
            <div>
                <div class="flex text-[#FFD12A] text-sm leading-none">★★★★★</div>
                <span class="text-xs text-gray-500">Flamp</span>
            </div>
        </a>
        </div>
    </section>

    {{-- FAQ (Аккордеон) --}}
    <section class="max-w-3xl mx-auto px-4 pb-16">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-10 text-[#1A1A1A]">Часто задаваемые вопросы</h2>
        
        <div class="space-y-4">
            <div class="border border-gray-200 rounded-[1rem] overflow-hidden bg-white">
                <button class="faq-btn w-full px-6 py-5 flex justify-between items-center font-semibold text-left focus:outline-none">
                    Пропадут ли фото и данные?
                    <svg class="w-6 h-6 transform transition-transform text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600 text-sm">
                    Обычно данные сохраняются. Если есть риск — предупредим и предложим резервную копию.
                </div>
            </div>

            <div class="border border-gray-200 rounded-[1rem] overflow-hidden bg-white">
                <button class="faq-btn w-full px-6 py-5 flex justify-between items-center font-semibold text-left focus:outline-none">
                    Поставите дешевые запчасти вместо оригинальных?
                    <svg class="w-6 h-6 transform transition-transform text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600 text-sm">
                    Класс запчастей согласуем заранее и фиксируем в заказ-наряде. Без согласования ничего не меняем.
                </div>
            </div>

            <div class="border border-gray-200 rounded-[1rem] overflow-hidden bg-white">
                <button class="faq-btn w-full px-6 py-5 flex justify-between items-center font-semibold text-left focus:outline-none">
                    Цена "в процессе" вырастет?
                    <svg class="w-6 h-6 transform transition-transform text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600 text-sm">
                    Точную цену называем после диагностики и согласуем до старта. Без подтверждения — не начинаем.
                </div>
            </div>
            
            <div class="border border-gray-200 rounded-[1rem] overflow-hidden bg-white">
                <button class="faq-btn w-full px-6 py-5 flex justify-between items-center font-semibold text-left focus:outline-none">
                    Какая гарантия?
                    <svg class="w-6 h-6 transform transition-transform text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600 text-sm">
                    Выдаём гарантию на работы. Срок зависит от услуги — расскажем при оформлении.
                </div>
            </div>
        </div>
    </section>

    {{-- КОНТАКТЫ (Компонент) --}}
    <x-contact-form />

    <x-modal-form />

@endsection

@push('scripts')
<script>
    // 1. ТАБЫ ДЛЯ БЛОКА "ЗАМЕНА СТЕКЛА"
    function changeBrandTab(brand, activeBtn) {
        // Убираем активный класс у кнопок
        document.querySelectorAll('.brand-tab').forEach(btn => {
            btn.classList.remove('active', 'bg-white', 'text-[#0678A8]');
            btn.classList.add('bg-white/20', 'text-white');
        });

        activeBtn.classList.remove('bg-white/20', 'text-white');
        activeBtn.classList.add('active', 'bg-white', 'text-[#0678A8]');

        // Скрываем все сетки моделей
        document.querySelectorAll('.models-grid').forEach(grid => {
            grid.classList.add('hidden');
        });

        // Показываем нужную
        document.getElementById('models-' + brand).classList.remove('hidden');
    }

    // 2. АККОРДЕОН ДЛЯ FAQ
    document.querySelectorAll('.faq-btn').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            // Сворачиваем остальные (по желанию, можно закомментить, чтобы открывались несколько)
            document.querySelectorAll('.faq-content').forEach(item => {
                if(item !== content) {
                    item.classList.add('hidden');
                    item.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
                }
            });

            // Тоггл текущего
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // 3. ГЛОБАЛЬНАЯ МОДАЛКА ДЛЯ CTA-КНОПОК
        const modal = document.getElementById('global-cta-modal');
        const modalTitle = document.getElementById('modal-title');
        const openModalButtons = document.querySelectorAll('.js-open-modal');
        const closeModalButtons = document.querySelectorAll('[data-modal-close]');

        const openModal = (titleText) => {
            if (!modal) return;
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            if (modalTitle && titleText) {
                modalTitle.textContent = titleText;
            }
        };

        const closeModal = () => {
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        openModalButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const titleText = button.dataset.ctaTitle || 'Оставить заявку';
                openModal(titleText);
            });
        });

        closeModalButtons.forEach((button) => {
            button.addEventListener('click', closeModal);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal();
            }
        });



        // 5. СКРОЛЛ ОТЗЫВОВ
        const reviewsTrack = document.getElementById('reviews-track');
        const btnPrev = document.getElementById('reviews-prev');
        const btnNext = document.getElementById('reviews-next');

        if (reviewsTrack && btnPrev && btnNext) {
            btnPrev.addEventListener('click', () => {
                reviewsTrack.scrollBy({ left: -reviewsTrack.offsetWidth, behavior: 'smooth' });
            });
            btnNext.addEventListener('click', () => {
                reviewsTrack.scrollBy({ left: reviewsTrack.offsetWidth, behavior: 'smooth' });
            });
        }

        // 6. АНИМАЦИЯ ПРИ СКРОЛЛЕ
        const obsOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, obsOptions);

        document.querySelectorAll('.js-scroll-trigger').forEach(el => observer.observe(el));

        // 7. СЛОВО В ЗАГОЛОВКЕ АНИМАЦИЯ
        const words = ["Профессиональный", "Быстрый", "Качественный", "Надёжный", "Недорогой"];
        let currentWordIndex = 0;
        const animatedContainer = document.getElementById('animated-word-container');
        if (animatedContainer) {
            function createSpans(word) {
                // Измеряем ширину нового слова
                const temp = document.createElement('span');
                temp.style.visibility = 'hidden';
                temp.style.position = 'absolute';
                temp.style.whiteSpace = 'nowrap';
                temp.className = 'text-[#2AC0D5] font-bold text-2xl sm:text-3xl md:text-4xl lg:text-[2.875rem]';
                temp.innerText = word;
                document.body.appendChild(temp);
                const width = temp.offsetWidth;
                document.body.removeChild(temp);
                
                // Устанавливаем ширину контейнеру для плавной анимации
                animatedContainer.style.width = width + 'px';

                animatedContainer.innerHTML = '';
                const wrapper = document.createElement('span');
                wrapper.className = 'inline-block';
                
                word.split('').forEach(char => {
                    const span = document.createElement('span');
                    span.innerHTML = char === ' ' ? '&nbsp;' : char;
                    span.className = 'flip-char flip-normal';
                    wrapper.appendChild(span);
                });
                animatedContainer.appendChild(wrapper);
                return wrapper.childNodes;
            }

            let currentSpans = createSpans(words[0]);

            function changeWord() {
                const nextWordIndex = (currentWordIndex + 1) % words.length;
                const nextWord = words[nextWordIndex];
                
                currentSpans.forEach((span, i) => {
                    setTimeout(() => {
                        span.classList.remove('flip-normal');
                        span.classList.add('flip-out');
                    }, i * 30); 
                });

                const outDuration = (currentSpans.length * 30) + 400; 

                setTimeout(() => {
                    currentSpans = createSpans(nextWord);
                    currentSpans.forEach(span => {
                        span.classList.remove('flip-normal');
                        span.classList.add('flip-in');
                    });

                    setTimeout(() => {
                        currentSpans.forEach((span, i) => {
                            setTimeout(() => {
                                span.classList.remove('flip-in');
                                span.classList.add('flip-normal');
                            }, i * 30);
                        });
                    }, 50);

                }, outDuration);

                currentWordIndex = nextWordIndex;
            }

            setInterval(changeWord, 4000);
        }

        // 8. ПЕРЕКЛЮЧАТЕЛЬ ПОЛОМОК (ЧТО СЛУЧИЛОСЬ?)
        const toggleBtn = document.getElementById('toggle-defects');
        if (toggleBtn) {
            const extraDefects = document.querySelectorAll('.defect-card.hidden');
            const btnText = toggleBtn.querySelector('span');
            const btnIcon = toggleBtn.querySelector('svg');
            let isExpanded = false;

            toggleBtn.addEventListener('click', () => {
                isExpanded = !isExpanded;
                
                extraDefects.forEach(card => {
                    card.classList.toggle('hidden');
                });

                if (isExpanded) {
                    btnText.textContent = 'Скрыть';
                    btnIcon.classList.add('rotate-180');
                } else {
                    btnText.textContent = 'Показать все';
                    btnIcon.classList.remove('rotate-180');
                }
            });
        }
    });
</script>
@endpush