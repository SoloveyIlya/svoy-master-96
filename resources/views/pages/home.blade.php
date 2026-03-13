@extends('layouts.app')

@section('title', 'Свой Мастер - Ремонт цифровой техники в Екатеринбурге')

@section('content')

    {{-- HERO SECTION --}}
    <section class="max-w-[87.5rem] mx-auto px-4 pt-10 pb-16 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl lg:text-[2.875rem] font-bold leading-[1.2] mb-10 text-[#1A1A1A]">
                <span class="text-[#2AC0D5]">Профессиональный ремонт</span><br>
                техники - в Екатеринбурге от 450 рублей
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-4 mb-12">
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

            <div class="flex flex-wrap items-center gap-4">
                <button class="bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-medium py-3 px-8 rounded-[2rem] transition shadow-md">
                    Узнать цену ремонта бесплатно
                </button>
                <button class="border-2 border-[#2AC0D5] text-[#2AC0D5] hover:bg-[#2AC0D5] hover:text-white font-medium py-3 px-8 rounded-[2rem] transition">
                    Вызвать курьера
                </button>
            </div>
        </div>

        <div class="relative z-0 flex justify-center lg:justify-end">
            <div class="absolute inset-0 bg-gradient-to-r from-white to-cyan-50 opacity-50 blur-3xl z-0"></div>
            {{-- Убедись, что путь до картинки верный --}}
            <img src="{{ asset('images/iphonelogo.svg') }}" alt="Ремонт техники" class="relative z-10 w-full max-w-[45rem] object-contain drop-shadow-2xl" />
        </div>
    </section>

    {{-- PROMO SLIDER SECTION --}}
    <section class="w-full py-10 overflow-hidden bg-gray-50">
        <div id="slider-container" class="w-full relative">
            <div id="slider-track" class="flex gap-4 md:gap-6 will-change-transform px-4 md:px-[10%]">
                
                {{-- SLIDE 1 --}}
                <div class="slider-item w-[90%] md:w-[85%] lg:w-[60rem] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[18rem] md:h-[22rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] shadow-lg flex">
                    
                    {{-- Паттерн фона --}}
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
                    
                    {{-- ЛЕВАЯ КОЛОНКА: Текст (занимает 60% ширины) --}}
                    <div class="relative z-10 w-[60%] h-full flex flex-col justify-center items-start pl-8 md:pl-16">
                        <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-6 tracking-tight">
                            <span class="text-[#FFD12A]">-10%</span> на работу мастера<br>
                            Каждому клиенту за отзыв<br>
                            промо код "Спасибо Мастер"
                        </h2>
                        <button class="border border-white/50 text-white hover:bg-white hover:text-[#0678A8] text-sm font-medium py-2.5 px-6 rounded-full transition backdrop-blur-sm">
                            Подробнее →
                        </button>
                    </div>

                    {{-- ПРАВАЯ КОЛОНКА: Картинка (занимает 40% ширины, прижата к низу) --}}
                    <div class="relative z-10 w-[40%] h-full flex items-end justify-center hidden md:flex">
                        {{-- object-contain гарантирует, что человек впишется в свою колонку без искажений --}}
                        <img src="{{ asset('images/man.png') }}" alt="Мастер" class="max-h-[95%] max-w-full object-contain object-bottom drop-shadow-lg" />
                    </div>

                </div>

                {{-- SLIDE 2 --}}
                <div class="slider-item w-[90%] md:w-[85%] lg:w-[60rem] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[18rem] md:h-[22rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] shadow-lg flex">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
                    
                    <div class="relative z-10 w-[60%] h-full flex flex-col justify-center items-start pl-8 md:pl-16">
                        <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-6 tracking-tight">
                            <span class="text-[#FFD12A]">-15%</span> при заказе ремонта<br>
                            двух устройств сразу
                        </h2>
                        <button class="border border-white/50 text-white hover:bg-white hover:text-[#0678A8] text-sm font-medium py-2.5 px-6 rounded-full transition backdrop-blur-sm">
                            Подробнее →
                        </button>
                    </div>

                    <div class="relative z-10 w-[40%] h-full flex items-end justify-center hidden md:flex">
                        <img src="{{ asset('images/man.png') }}" alt="Мастер" class="max-h-[95%] max-w-full object-contain object-bottom drop-shadow-lg" />
                    </div>
                </div>

                {{-- SLIDE 3 --}}
                <div class="slider-item w-[90%] md:w-[85%] lg:w-[60rem] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[18rem] md:h-[22rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] shadow-lg flex">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
                    
                    <div class="relative z-10 w-[60%] h-full flex flex-col justify-center items-start pl-8 md:pl-16">
                        <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-6 tracking-tight">
                            <span class="text-[#FFD12A]">Бесплатное</span> защитное<br>
                            стекло при замене дисплея
                        </h2>
                        <button class="border border-white/50 text-white hover:bg-white hover:text-[#0678A8] text-sm font-medium py-2.5 px-6 rounded-full transition backdrop-blur-sm">
                            Подробнее →
                        </button>
                    </div>

                    <div class="relative z-10 w-[40%] h-full flex items-end justify-center hidden md:flex">
                        <img src="{{ asset('images/man.png') }}" alt="Мастер" class="max-h-[95%] max-w-full object-contain object-bottom drop-shadow-lg" />
                    </div>
                </div>

            </div>
        </div>

        <div class="flex justify-center items-center gap-3 mt-8">
            <button class="slider-dot w-3 h-3 rounded-full bg-[#0678A8] transition-all duration-300 transform scale-125"></button>
            <button class="slider-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-[#2AC0D5] transition-all duration-300"></button>
            <button class="slider-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-[#2AC0D5] transition-all duration-300"></button>
        </div>
    </section>

    {{-- ТРОУБЛШУТИНГ (ЧТО СЛУЧИЛОСЬ?) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold mb-3 text-[#1A1A1A]">Что случилось?</h2>
            <p class="text-gray-500">Выберите проблему — подскажем решение и примерную стоимость</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $issues = [
                    ['title' => 'Разбилось стекло', 'desc' => 'Трещины / паутинка'],
                    ['title' => 'Не заряжается', 'desc' => 'Разъем / кабель / плата'],
                    ['title' => 'Быстро садится', 'desc' => 'Аккумулятор'],
                    ['title' => 'Попала вода', 'desc' => 'Срочно в диагностику'],
                    ['title' => 'Нет сети / Wi-Fi', 'desc' => 'Связь / модуль'],
                    ['title' => 'Камера / звук', 'desc' => 'Микрофон / динамик'],
                    ['title' => 'Не включается', 'desc' => 'Питание / плата'],
                    ['title' => 'Тормозит', 'desc' => 'ПО / память']
                ];
            @endphp

            @foreach($issues as $issue)
            <div class="border border-gray-200 rounded-[1rem] p-6 hover:shadow-lg hover:border-[#2AC0D5] transition cursor-pointer bg-white">
                <h3 class="font-bold text-[#1A1A1A] mb-1">{{ $issue['title'] }}</h3>
                <p class="text-sm text-gray-500">{{ $issue['desc'] }}</p>
            </div>
            @endforeach
        </div>
        
        <div class="flex justify-center">
            <button class="bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-medium py-3 px-8 rounded-[2rem] transition">
                Другая поломка
            </button>
        </div>
    </section>

    {{-- ЗАМЕНА СТЕКЛА (С ТАБАМИ МАРКИ) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-8">
            <div class="bg-[#0678A8] rounded-[2rem] relative flex flex-col md:flex-row items-end pt-8 px-8 pb-0 md:pt-12 md:px-12 md:pb-0 shadow-xl">
                
                <div class="absolute inset-0 bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] opacity-90 z-0 rounded-[2rem]"></div>
                
                <!-- 2. У блока картинки: добавили self-end, чтобы он всегда стоял на нижней линии -->
                <div class="relative z-10 md:w-1/3 self-end">
                    <img src="{{ asset('images/broken-phone.png') }}" 
                        alt="Разбитое стекло" 
                        class="w-full transform transition-transform duration-300 
                                md:scale-130       /* Увеличиваем */
                                md:translate-y-[0%] /* Позволяем ей чуть-чуть «свисать» или стоять впритык */
                                drop-shadow-2xl object-contain origin-bottom" />
                </div>

                <!-- 3. Блок текста: ему нужно вернуть нижний отступ, иначе он упадет на пол -->
                <div class="relative z-10 md:w-2/3 md:pl-16 text-white py-12 self-center">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Замена стекла</h2>
                <p class="text-white/80 mb-8 max-w-2xl leading-relaxed">
                    Если изображение и сенсор работают — часто можно заменить только стекло, без замены всего дисплейного модуля. Это выгоднее и аккуратнее для устройства.
                </p>

                <div class="mb-4">
                    <p class="font-semibold mb-3">Выберите марку устройства:</p>
                    <div class="flex flex-wrap gap-2" id="brand-tabs">
                        <button onclick="changeBrandTab('apple')" class="brand-tab active bg-white text-[#0678A8] px-5 py-2 rounded-full font-medium transition">Apple</button>
                        <button onclick="changeBrandTab('samsung')" class="brand-tab bg-white/20 hover:bg-white/40 text-white px-5 py-2 rounded-full font-medium transition">Samsung</button>
                        <button onclick="changeBrandTab('xiaomi')" class="brand-tab bg-white/20 hover:bg-white/40 text-white px-5 py-2 rounded-full font-medium transition">Xiaomi</button>
                    </div>
                </div>

                <div class="mt-6 border-t border-white/20 pt-6">
                    {{-- Модели Apple --}}
                    <div id="models-apple" class="models-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach(['iPhone 14', 'iPhone 14 Pro', 'iPhone 15', 'iPhone 15 Pro', 'iPhone 16', 'iPhone 16 Pro', 'iPhone 13', 'iPhone 12'] as $model)
                            <a href="{{ route('catalog.landing', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'apple', 'modelSlug' => 'iphone-14', 'serviceSlug' => 'zamena-stekla']) }}" class="text-sm text-white/90 hover:text-white hover:underline transition">{{ $model }}</a>
                        @endforeach
                    </div>
                    
                    {{-- Модели Samsung --}}
                    <div id="models-samsung" class="models-grid hidden grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach(['Galaxy S24', 'Galaxy S23', 'Galaxy S22', 'Galaxy A54', 'Galaxy A34', 'Galaxy Z Fold', 'Galaxy Z Flip'] as $model)
                            <a href="{{ route('catalog.landing', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'samsung', 'modelSlug' => 's20', 'serviceSlug' => 'zamena-stekla']) }}" class="text-sm text-white/90 hover:text-white hover:underline transition">{{ $model }}</a>
                        @endforeach
                    </div>

                    {{-- Модели Xiaomi --}}
                    <div id="models-xiaomi" class="models-grid hidden grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach(['Xiaomi 14', 'Xiaomi 13T', 'Redmi Note 13', 'Redmi Note 12', 'POCO X6', 'POCO F5'] as $model)
                            <a href="{{ route('catalog.landing', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'xiaomi', 'modelSlug' => 'redmi-note-7', 'serviceSlug' => 'zamena-stekla']) }}" class="text-sm text-white/90 hover:text-white hover:underline transition">{{ $model }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- КАТЕГОРИИ РЕМОНТА (Без выделения Apple) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center mb-12 text-[#1A1A1A]">
            Узнайте цену на ремонт, выбрав<br>Ваше устройство
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-telefonov']) }}" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт телефонов</span>
                <img src="{{ asset('images/android.svg') }}" alt="Телефоны" class="absolute bottom-[-5%] right-[0%] w-[80%] object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-noutbukov']) }}" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт ноутбуков</span>
                <img src="{{ asset('images/laptop.svg') }}" alt="Ноутбуки" class="absolute bottom-[2%] right-[-5%] w-[90%] object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-planshetov']) }}" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт планшетов</span>
                <img src="{{ asset('images/tablet.svg') }}" alt="Планшеты" class="absolute bottom-[-5%] left-[10%] w-[90%] object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-smart-chasov']) }}" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт смарт-часов</span>
                <img src="{{ asset('images/watch.svg') }}" alt="Смарт-часы" class="absolute bottom-0 right-0 w-[85%] object-contain group-hover:scale-105 transition duration-500" />
            </a>

            <a href="{{ route('catalog.category', ['categorySlug' => 'remont-telefonov']) }}" class="flex items-center justify-center relative h-[20rem] rounded-[2rem] border-2 border-[#2AC0D5] bg-white group shadow-sm hover:bg-cyan-50 transition duration-300">
                <span class="text-[#0678A8] font-bold text-2xl text-center px-8 group-hover:scale-105 transition duration-300">Смотреть все<br>категории</span>
            </a>
        </div>
    </section>

    {{-- БРЕНДЫ --}}
    <section class="max-w-[87.5rem] mx-auto px-4 pb-16">
        <h2 class="text-2xl font-bold text-center mb-10 text-[#1A1A1A]">Ремонтируем популярные устройства</h2>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 [&_img]:h-14 opacity-60 grayscale hover:grayscale-0 transition duration-500">
            <img src="{{ asset('images/brands/apple.png') }}" alt="Apple" class="h-10 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/samsung.png') }}" alt="Samsung" class="h-6 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/asus.png') }}" alt="Asus" class="h-6 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/huawei.png') }}" alt="Huawei" class="h-10 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/lenovo.png') }}" alt="Lenovo" class="h-6 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/xiaomi.png') }}" alt="Xiaomi" class="h-10 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/nokia.png') }}" alt="Nokia" class="h-6 object-contain hover:grayscale-0 transition" />
            <img src="{{ asset('images/brands/sony.png') }}" alt="Sony" class="h-6 object-contain hover:grayscale-0 transition" />
        </div>
    </section>

    {{-- ПОЧЕМУ ВЫБИРАЮТ НАС --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16 border-t border-gray-100">
        <h2 class="text-3xl lg:text-4xl font-bold mb-12 text-[#1A1A1A]">Почему выбирают нас</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div>
                    <svg class="w-10 h-10 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="font-bold text-lg mb-2">С 2017 года</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Ремонтируем различные устройства от замены стекла до восстановления ПО.</p>
                </div>
                <div>
                    <svg class="w-10 h-10 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <h3 class="font-bold text-lg mb-2">Ремонт в вашем присутствии</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Мы не заставим вас долго ждать, ремонт устройства происходит в кратчайшие сроки.</p>
                </div>
                <div>
                    <svg class="w-10 h-10 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                    <h3 class="font-bold text-lg mb-2">Запчасти высокого качества</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Устанавливаем запчасти только высокого качества. Даем гарантию на ремонт.</p>
                </div>
                <div>
                    <svg class="w-10 h-10 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <h3 class="font-bold text-lg mb-2">Честная цена</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Актуальные цены, которые включают в себя стоимость работы и запчастей.</p>
                </div>
            </div>

            <div class="h-full min-h-[300px] rounded-[2rem] overflow-hidden relative shadow-lg">
                <img src="{{ asset('images/reception.png') }}" alt="Наш сервис" class="absolute inset-0 w-full h-full object-cover" />
            </div>
        </div>
    </section>

    {{-- О КОМПАНИИ И СОТРУДНИКИ (Новые блоки) --}}
    <section class="bg-gray-50 py-16">
        <div class="max-w-[87.5rem] mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- О компании --}}
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-[#1A1A1A]">Информация о компании</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Сервисный центр «Свой Мастер» специализируется на компонентном и модульном ремонте цифровой техники любой сложности. Мы ответственно подходим к каждому заказу, обеспечивая надежный результат.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Наш главный приоритет — честность и качество. Мы используем только проверенные комплектующие, а наши инженеры имеют профильное образование и многолетний опыт восстановления даже «безнадежных» устройств.
                    </p>
                </div>

                {{-- Сотрудники --}}
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-[#1A1A1A]">Наши специалисты</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-[1rem] shadow-sm text-center">
                            <img src="{{ asset('images/man.png') }}" alt="Мастер Иван" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover bg-gray-200">
                            <h4 class="font-bold text-[#1A1A1A]">Иван С.</h4>
                            <p class="text-xs text-gray-500">Старший инженер</p>
                        </div>
                        <div class="bg-white p-4 rounded-[1rem] shadow-sm text-center">
                            <img src="{{ asset('images/man.png') }}" alt="Мастер Алексей" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover bg-gray-200">
                            <h4 class="font-bold text-[#1A1A1A]">Алексей В.</h4>
                            <p class="text-xs text-gray-500">Мастер по BGA-пайке</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ЭТАПЫ РАБОТ --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-[#1A1A1A]">Алгоритм работы</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center relative">
            <div class="hidden lg:block absolute top-[2.5rem] left-[10%] w-[80%] h-[2px] bg-gray-200 -z-10"></div>
            
            <div class="relative">
                <div class="w-20 h-20 mx-auto bg-[#2AC0D5] text-white rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md">1</div>
                <h3 class="font-bold text-lg mb-2">Заявка</h3>
                <p class="text-sm text-gray-500">Вы оставляете заявку на сайте или приносите технику к нам</p>
            </div>
            <div class="relative">
                <div class="w-20 h-20 mx-auto bg-white border-4 border-[#2AC0D5] text-[#2AC0D5] rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md">2</div>
                <h3 class="font-bold text-lg mb-2">Диагностика</h3>
                <p class="text-sm text-gray-500">Бесплатно выявляем точную причину неисправности</p>
            </div>
            <div class="relative">
                <div class="w-20 h-20 mx-auto bg-white border-4 border-[#2AC0D5] text-[#2AC0D5] rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md">3</div>
                <h3 class="font-bold text-lg mb-2">Ремонт</h3>
                <p class="text-sm text-gray-500">Согласовываем цену и производим ремонт устройства</p>
            </div>
            <div class="relative">
                <div class="w-20 h-20 mx-auto bg-white border-4 border-[#2AC0D5] text-[#2AC0D5] rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md">4</div>
                <h3 class="font-bold text-lg mb-2">Выдача</h3>
                <p class="text-sm text-gray-500">Возвращаем рабочее устройство вместе с гарантией</p>
            </div>
        </div>
    </section>

    {{-- ОТЗЫВЫ (Слайдер из БД) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-16 bg-gray-50 rounded-[2rem] mb-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center mb-10 text-[#1A1A1A]">Отзывы наших клиентов</h2>
        
        <div class="relative overflow-hidden" id="reviews-slider">
            <div class="flex transition-transform duration-500 ease-in-out" id="reviews-track">
                
                {{-- Проверяем наличие переменной $reviews (данные из контроллера) --}}
                @if(isset($reviews) && $reviews->count() > 0)
                    @foreach($reviews as $review)
                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-4">
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
                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-4">
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
            
            {{-- Кнопки управления отзывами --}}
            <button onclick="prevReview()" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full w-10 h-10 flex items-center justify-center text-[#0678A8] hover:bg-[#2AC0D5] hover:text-white transition">←</button>
            <button onclick="nextReview()" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full w-10 h-10 flex items-center justify-center text-[#0678A8] hover:bg-[#2AC0D5] hover:text-white transition">→</button>
        </div>
    </section>

    {{-- FAQ (Аккордеон) --}}
    <section class="max-w-3xl mx-auto px-4 pb-16">
        <h2 class="text-3xl font-bold text-center mb-10 text-[#1A1A1A]">Часто задаваемые вопросы</h2>
        
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

    {{-- КОНТАКТЫ (Блок с формой из макета) --}}
    <section class="max-w-[87.5rem] mx-auto px-4 pb-20">
        <div class="bg-[#0678A8] rounded-[2rem] p-8 md:p-12 text-white grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay z-0"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-8">Контакты</h2>
                <div class="space-y-4 mb-8">
                    <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +7 (343) 226-46-22</p>
                    <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> remont@svoymaster96.ru</p>
                    <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> г. Екатеринбург, Антона Валека, 13, офис 200</p>
                </div>
                {{-- Карта (Заглушка или реальный iframe) --}}
                <div class="w-full h-48 rounded-[1rem] bg-gray-200 overflow-hidden">
                    <img src="{{ asset('images/map.png') }}" alt="Карта" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="relative z-10 bg-white/10 p-8 rounded-[1rem] backdrop-blur-sm">
                <h3 class="text-xl font-bold mb-6 text-center">Оставьте заявку на бесплатную диагностику</h3>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" placeholder="Имя" class="w-full bg-transparent border border-white/30 rounded-full px-5 py-3 text-white placeholder-white/70 focus:outline-none focus:border-white transition">
                    <input type="tel" placeholder="+7 (___) ___-__-__" class="w-full bg-transparent border border-white/30 rounded-full px-5 py-3 text-white placeholder-white/70 focus:outline-none focus:border-white transition">
                    <textarea placeholder="Комментарий" rows="3" class="w-full bg-transparent border border-white/30 rounded-2xl px-5 py-3 text-white placeholder-white/70 focus:outline-none focus:border-white transition resize-none"></textarea>
                    <button type="submit" class="w-full bg-[#2AC0D5] hover:bg-white hover:text-[#0678A8] text-white font-bold rounded-full py-4 transition shadow-md">Отправить</button>
                    <p class="text-[10px] text-center text-white/60 mt-2">Нажимая кнопку, вы соглашаетесь с политикой обработки персональных данных</p>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // 1. ТАБЫ ДЛЯ БЛОКА "ЗАМЕНА СТЕКЛА"
    function changeBrandTab(brand) {
        // Убираем активный класс у кнопок
        document.querySelectorAll('.brand-tab').forEach(btn => {
            btn.classList.remove('active', 'bg-white', 'text-[#0678A8]');
            btn.classList.add('bg-white/20', 'text-white');
        });
        
        // Добавляем активный класс нажатой кнопке
        const activeBtn = event.target;
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

    // 3. ПРОСТОЙ СЛАЙДЕР ДЛЯ ОТЗЫВОВ
    let currentReviewIndex = 0;
    function showReviewSlide(index) {
        const track = document.getElementById('reviews-track');
        const items = track.children;
        
        // Определяем сколько карточек видно на экране
        let visibleCards = 1;
        if (window.innerWidth >= 768) visibleCards = 2;
        if (window.innerWidth >= 1024) visibleCards = 3;

        const maxIndex = items.length - visibleCards;
        
        if (index > maxIndex) currentReviewIndex = 0;
        else if (index < 0) currentReviewIndex = maxIndex;
        else currentReviewIndex = index;

        // Расчет смещения в %
        const percentage = -(currentReviewIndex * (100 / visibleCards));
        track.style.transform = `translateX(${percentage}%)`;
    }

    function nextReview() { showReviewSlide(currentReviewIndex + 1); }
    function prevReview() { showReviewSlide(currentReviewIndex - 1); }

    // Пересчитываем слайдер при ресайзе экрана
    window.addEventListener('resize', () => showReviewSlide(currentReviewIndex));

    // --- АВТО-СЛАЙДЕР БАННЕРОВ ---
document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('slider-track');
    if (!track) return;
    
    const originalItems = Array.from(document.querySelectorAll('.slider-item'));
    const container = document.getElementById('slider-container');
    const dots = document.querySelectorAll('.slider-dot');
    const realCount = originalItems.length;

    if (realCount === 0) return;

    // Клонируем элементы для бесконечной прокрутки
    const cloneFirst = originalItems[0].cloneNode(true);
    const cloneLast = originalItems[realCount - 1].cloneNode(true);
    track.insertBefore(cloneLast, originalItems[0]);
    track.appendChild(cloneFirst);

    const allItems = document.querySelectorAll('.slider-item');
    let currentIndex = 1;
    let isAnimating = false;
    let interval;

    function updateSlider(animate = true) {
        const transitionStyle = animate ? 'transform 0.5s ease-out' : 'none';
        track.style.transition = transitionStyle;

        const targetSlide = allItems[currentIndex];
        const slideLeft = targetSlide.offsetLeft;
        const centerOffset = (container.offsetWidth - targetSlide.offsetWidth) / 2;
        const translateX = slideLeft - centerOffset;

        track.style.transform = `translate3d(-${translateX}px, 0, 0)`;

            // --- ВОТ ЭТА ЧАСТЬ ЧИНИТ "БЛЕДНОСТЬ" ---
    allItems.forEach((item, index) => {
        // Добавляем плавность изменения прозрачности
        item.style.transition = animate ? 'transform 0.5s ease-out, opacity 0.5s ease-out' : 'none';
        
        if (index === currentIndex) {
            item.style.opacity = '1';       // Активный — яркий
            item.style.filter = 'none';      // Убираем размытие, если было
        } else {
            item.style.opacity = '0.4';     // Неактивные — бледные (можешь поставить 0.5 или 0.6)
            item.style.filter = 'blur(1px)'; // Легкое размытие для фокуса (опционально)
        }
    });
    // ---------------------------------------

        let dotIndex = currentIndex - 1;
        if (dotIndex < 0) dotIndex = realCount - 1;
        if (dotIndex >= realCount) dotIndex = 0;

        dots.forEach((dot, index) => {
            if (index === dotIndex) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-[#0678A8]', 'scale-125');
            } else {
                dot.classList.remove('bg-[#0678A8]', 'scale-125');
                dot.classList.add('bg-gray-300');
            }
        });
    }

    function nextSlide() {
        if (isAnimating) return;
        isAnimating = true;
        currentIndex++;
        updateSlider(true);

        setTimeout(() => {
            if (currentIndex === allItems.length - 1) {
                currentIndex = 1;
                updateSlider(false);
            }
            isAnimating = false;
        }, 500);
    }

    function startTimer() { interval = setInterval(nextSlide, 3500); }
    window.addEventListener('resize', () => updateSlider(false));

    setTimeout(() => {
        updateSlider(false);
        startTimer();
    }, 50);
});
</script>
@endpush