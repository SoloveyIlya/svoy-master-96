<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Свой Мастер - Ремонт цифровой техники</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

    <x-header />

    <!-- NAVIGATION MENU -->
    <nav class="w-full bg-[#0678A8] text-white shadow-md relative z-20">
        <div class="max-w-[87.5rem] mx-auto px-4 flex items-center justify-between lg:justify-start lg:gap-12 py-3.5 text-[0.9375rem] font-medium">
            <a href="#" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт Apple <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="#" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт телефонов <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="#" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт ноутбуков <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="#" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт планшетов <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="#" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт других устройств <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="max-w-[87.5rem] mx-auto px-4 pt-16 pb-20 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl lg:text-[2.875rem] font-bold leading-[1.2] mb-10 text-[#1A1A1A]">
                <span class="text-[#2AC0D5]">Профессиональный ремонт</span><br>
                техники - в Екатеринбурге от 450 рублей
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-4 mb-12">
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8]" fill="currentColor" viewBox="0 0 40 40">
                        <path d="M36.1167 30.2833L27.2834 21.45H25.6334L21.4 25.6833V27.3333L30.2334 36.1666C30.8834 36.8166 31.9334 36.8166 32.5834 36.1666L36.1167 32.6333C36.7667 32 36.7667 30.9333 36.1167 30.2833ZM31.4 32.65L24.3334 25.5833L25.5167 24.4L32.5834 31.4666L31.4 32.65Z"/>
                        <path d="M28.9 16.9833L31.25 14.6333L34.7834 18.1666C36.7334 16.2166 36.7334 13.05 34.7834 11.1L28.8834 5.19996L26.5334 7.54996V2.84996L25.3667 1.66663L19.4667 7.56663L20.65 8.74996H25.3667L23.0167 11.1L24.7834 12.8666L19.9667 17.6833L13.0834 10.8V8.43329L8.05004 3.39996L3.33337 8.11663L8.38337 13.1666H10.7334L17.6167 20.05L16.2 21.4666H12.6667L3.83337 30.3C3.18337 30.95 3.18337 32 3.83337 32.65L7.36671 36.1833C8.01671 36.8333 9.06671 36.8333 9.71671 36.1833L18.55 27.35V23.8166L27.1334 15.2333L28.9 16.9833ZM15.6 25.5666L8.53337 32.6333L7.35004 31.45L14.4167 24.3833L15.6 25.5666Z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">С 2010 года</h3>
                        <p class="text-gray-500 text-sm">Ремонтируем устройства</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">До 2-х лет</h3>
                        <p class="text-gray-500 text-sm">Гарантия на работы</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Не более 30 минут</h3>
                        <p class="text-gray-500 text-sm">Среднее время ремонта</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-[#0678A8]" fill="currentColor" viewBox="0 0 40 40">
                        <path d="M20 36.6666C21.8333 36.6666 23.3333 35.1666 23.3333 33.3333H16.6666C16.6666 35.1666 18.1666 36.6666 20 36.6666ZM20 10.8333C24.15 10.8333 26.6666 14.2 26.6666 18.3333V18.5L30 21.8333V18.3333C30 13.2166 27.2833 8.93329 22.5 7.79996V6.66663C22.5 5.28329 21.3833 4.16663 20 4.16663C18.6166 4.16663 17.5 5.28329 17.5 6.66663V7.79996C17.1 7.89996 16.7166 8.04996 16.35 8.18329L19.0833 10.9166C19.3833 10.8833 19.6833 10.8333 20 10.8333ZM9.01663 5.58329L6.66663 7.93329L11.35 12.6166C10.4833 14.2833 9.99996 16.2333 9.99996 18.3333V26.6666L6.66663 30V31.6666H30.4L33.3 34.5666L35.65 32.2166L9.01663 5.58329ZM26.6666 28.3333H13.3333V18.3333C13.3333 17.2 13.5333 16.1333 13.9 15.1666L26.6666 27.9333V28.3333Z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Конфиденциально</h3>
                        <p class="text-gray-500 text-sm">Ваши данные в сохранности</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <button class="bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-medium py-3 px-8 rounded-full flex items-center gap-2 transition shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"></path></svg>
                    Вызвать мастера
                </button>
                <button class="border-2 border-[#2AC0D5] text-[#2AC0D5] hover:bg-[#2AC0D5] hover:text-white font-medium py-3 px-8 rounded-full flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Приехать к нам
                </button>
            </div>
        </div>

        <div class="relative z-0 flex justify-center lg:justify-end">
            <div class="absolute inset-0 bg-gradient-to-r from-white to-cyan-50 opacity-50 blur-3xl z-0"></div>
            <img src="{{ asset('images/iphonelogo.svg') }}" alt="Phone Render" class="relative z-10 max-h-[37.5rem] object-contain drop-shadow-2xl rounded-3xl mix-blend-multiply" />
        </div>
    </section>

    <!-- 4 BENEFITS SECTION -->
    <section class="max-w-[87.5rem] mx-auto px-4 py-16 border-t border-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-[#0678A8] mb-4" fill="currentColor" viewBox="0 0 60 60">
                    <path d="M31.25 17.25C35.7 17.25 37.35 19.375 37.5 22.5H43.025C42.85 18.2 40.225 14.25 35 12.975V7.5H27.5V12.9C26.525 13.1 25.625 13.425 24.75 13.8L28.525 17.575C29.325 17.375 30.25 17.25 31.25 17.25ZM13.675 9.8L10.15 13.325L18.75 21.925C18.75 27.125 22.65 29.975 28.525 31.7L37.3 40.475C36.45 41.7 34.675 42.75 31.25 42.75C26.1 42.75 24.075 40.45 23.8 37.5H18.3C18.6 42.975 22.7 46.05 27.5 47.075V52.5H35V47.125C37.4 46.675 39.575 45.75 41.15 44.325L46.7 49.875L50.225 46.35L13.675 9.8Z"/>
                </svg>
                <h3 class="font-bold text-lg mb-2">Бесплатная диагностика</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Наши мастера абсолютно бесплатно установят причину неисправности устройства</p>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <h3 class="font-bold text-lg mb-2">Ремонт в вашем присутствии</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Мы не заставим вас долго ждать, ремонт устройства происходит в кратчайшие сроки</p>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                <h3 class="font-bold text-lg mb-2">Запчасти высокого качества</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Устанавливаем запчасти только высокого качества. Даем гарантию на ремонт</p>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-[#0678A8] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                <h3 class="font-bold text-lg mb-2">Честная цена</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Актуальные цены, которые включают в себя стоимость работы и запчастей</p>
            </div>
        </div>
    </section>

    <section class="w-full py-10 overflow-hidden">
        <!-- Контейнер слайдера -->
        <div id="slider-container" class="w-full relative">
            
            <!-- Трек слайдов -->
            <div id="slider-track" class="flex gap-4 md:gap-6 will-change-transform">
                
                <!-- SLIDE 1 -->
                <div class="slider-item w-[85%] md:w-[70%] lg:w-[60%] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[18.75rem] md:h-[21.25rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] flex items-center shadow-lg">
                    <!-- Текстура фона -->
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    
                    <div class="relative z-10 w-full flex flex-col md:flex-row items-center justify-between px-6 md:px-12 h-full">
                        <div class="md:w-3/5 flex flex-col justify-center items-start h-full py-8">
                            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-6">
                                <span class="text-[#FFD12A]">-10%</span> на работу мастера Каждому клиенту за отзыв
                            </h2>
                            <button class="border border-white/50 text-white hover:bg-white hover:text-[#0678A8] hover:border-white font-medium py-2.5 px-6 rounded-full flex items-center gap-2 transition w-max backdrop-blur-sm">
                                Подробнее <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                        <img src="{{ asset('images/man.png') }}" alt="Man" class="hidden md:block w-64 lg:w-80 object-cover mt-auto self-end" />
                    </div>
                </div>

                <!-- SLIDE 2 -->
                <div class="slider-item w-[85%] md:w-[70%] lg:w-[60%] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[18.75rem] md:h-[21.25rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] flex items-center shadow-lg">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    
                    <div class="relative z-10 w-full flex flex-col md:flex-row items-center justify-between px-6 md:px-12 h-full">
                        <div class="md:w-3/5 flex flex-col justify-center items-start h-full py-8">
                            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-6">
                                <span class="text-[#FFD12A]">-15%</span> при заказе ремонта двух устройств сразу
                            </h2>
                            <button class="border border-white/50 text-white hover:bg-white hover:text-[#0678A8] hover:border-white font-medium py-2.5 px-6 rounded-full flex items-center gap-2 transition w-max backdrop-blur-sm">
                                Подробнее <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                        <img src="{{ asset('images/man.png') }}" alt="Man" class="hidden md:block w-64 lg:w-80 object-cover mt-auto self-end" />
                    </div>
                </div>

                <!-- SLIDE 3 -->
                <div class="slider-item w-[85%] md:w-[70%] lg:w-[60%] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[18.75rem] md:h-[21.25rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] flex items-center shadow-lg">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    
                    <div class="relative z-10 w-full flex flex-col md:flex-row items-center justify-between px-6 md:px-12 h-full">
                        <div class="md:w-3/5 flex flex-col justify-center items-start h-full py-8">
                            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-6">
                                <span class="text-[#FFD12A]">Бесплатное</span> защитное стекло при замене дисплея
                            </h2>
                            <button class="border border-white/50 text-white hover:bg-white hover:text-[#0678A8] hover:border-white font-medium py-2.5 px-6 rounded-full flex items-center gap-2 transition w-max backdrop-blur-sm">
                                Подробнее <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                        <img src="{{ asset('images/man.png') }}" alt="Man" class="hidden md:block w-64 lg:w-80 object-cover mt-auto self-end" />
                    </div>
                </div>

            </div>
        </div>

        <!-- Точки навигации -->
        <div class="flex justify-center items-center gap-3 mt-8">
            <button onclick="setSlide(0)" class="slider-dot w-3 h-3 rounded-full bg-[#0678A8] transition-all duration-300 transform scale-125"></button>
            <button onclick="setSlide(1)" class="slider-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-[#2AC0D5] transition-all duration-300"></button>
            <button onclick="setSlide(2)" class="slider-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-[#2AC0D5] transition-all duration-300"></button>
        </div>
    </section>

    <!-- CATEGORIES GRID SECTION -->
    <section class="max-w-[87.5rem] mx-auto px-4 py-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center mb-12 text-[#1A1A1A]">
            Узнайте цену на ремонт, выбрав<br>Ваше устройство
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Category Card 1 (Apple) -->
            <a href="#" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт Apple</span>
                <img src="{{ asset('images/iphone.svg') }}" alt="Apple" class="absolute bottom-[-8%] right-[0%] w-[90%] object-contain group-hover:scale-110 transition duration-500" />
            </a>

            <!-- Category Card 2 (Phones) -->
            <a href="#" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт телефонов</span>
                <img src="{{ asset('images/android.svg') }}" alt="Phones" class="absolute bottom-[-7%] right-[0%] w-[90%] object-contain group-hover:scale-110 transition duration-500" />
            </a>

            <!-- Category Card 3 (Laptops) -->
            <a href="#" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт ноутбуков</span>
                <img src="{{ asset('images/laptop.svg') }}" alt="Laptops" class="absolute bottom-[0%] right-[-1%] w-[95%] object-contain group-hover:scale-110 transition duration-500" />
            </a>

            <!-- Category Card 4 (Tablets) -->
            <a href="#" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт планшетов</span>
                <img src="{{ asset('images/tablet.svg') }}" alt="Tablets" class="absolute bottom-[-10%] left-[0%] w-[110%] object-contain group-hover:scale-110 transition duration-500" />
            </a>

            <!-- Category Card 5 (Smartwatches) -->
            <a href="#" class="block relative h-[20rem] rounded-[2rem] overflow-hidden bg-gradient-to-b from-[#2AC0D5] to-[#0678A8] group shadow-sm hover:shadow-2xl transition duration-300">
                <span class="absolute top-8 left-8 text-white font-semibold text-2xl z-10">Ремонт смарт часов</span>
                <img src="{{ asset('images/watch.svg') }}" alt="Watches" class="absolute bottom-0 right-[-0%] w-[90%] object-contain group-hover:scale-110 transition duration-500" />
            </a>

            <!-- Category Card 6 (See All) -->
            <a href="#" class="flex items-center justify-center relative h-[20rem] rounded-[2rem] border-2 border-[#2AC0D5] bg-white group shadow-sm hover:bg-cyan-50 transition duration-300">
                <span class="text-[#0678A8] font-bold text-2xl text-center px-8">Смотреть все<br>категории</span>
            </a>

        </div>
    </section>

    <!-- FREE CONSULTATION CALLOUT -->
    <section class="max-w-[87.5rem] mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-bold text-[#1A1A1A]">
            Бесплатная консультация <span class="text-[#0678A8]">за 1 минуту</span>
        </h2>
    </section>

<!-- Slider Logic -->
<!-- Slider Logic Script -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('slider-track');
            const originalItems = Array.from(document.querySelectorAll('.slider-item'));
            const container = document.getElementById('slider-container');
            const dots = document.querySelectorAll('.slider-dot');
            const realCount = originalItems.length;

            if (realCount === 0) return;

            // 1. Создаем клоны по краям для бесконечности
            const cloneFirst = originalItems[0].cloneNode(true);
            const cloneLast = originalItems[realCount - 1].cloneNode(true);
            track.insertBefore(cloneLast, originalItems[0]); // [Клон 3] в начало
            track.appendChild(cloneFirst); // [Клон 1] в конец

            const allItems = document.querySelectorAll('.slider-item');
            let currentIndex = 1; // Начинаем с оригинального слайда №1
            let isAnimating = false; // Блокировка кликов во время полета
            let interval;

            // 2. Главная функция позиционирования и анимации
            function updateSlider(animate = true) {
                // Если нужна анимация - включаем её, если это тайный прыжок - выключаем
                const transitionStyle = animate ? 'transform 0.5s ease-out' : 'none';
                const slideTransition = animate ? 'transform 0.5s ease-out, opacity 0.5s ease-out' : 'none';

                track.style.transition = transitionStyle;

                const targetSlide = allItems[currentIndex];
                
                // Центрируем слайд
                const slideLeft = targetSlide.offsetLeft;
                const centerOffset = (container.offsetWidth - targetSlide.offsetWidth) / 2;
                const translateX = slideLeft - centerOffset;

                track.style.transform = `translate3d(-${translateX}px, 0, 0)`;

                // Раздаем классы .active и управляем анимацией самих карточек
                allItems.forEach((item, index) => {
                    item.style.transition = slideTransition;
                    if (index === currentIndex) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });

                // Подсвечиваем нужную точку
                let dotIndex = currentIndex - 1;
                if (dotIndex < 0) dotIndex = realCount - 1; // Если стоим на Клоне 3
                if (dotIndex >= realCount) dotIndex = 0;    // Если стоим на Клоне 1

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

            // 3. Логика перелистывания
            function nextSlide() {
                if (isAnimating) return;
                isAnimating = true;
                
                currentIndex++;
                updateSlider(true); // Плавно едем к следующему

                // Ждем ровно 500мс (время окончания анимации)
                setTimeout(() => {
                    // Если доехали до Клона 1 в самом конце ленты
                    if (currentIndex === allItems.length - 1) {
                        currentIndex = 1; // Возвращаем индекс в начало
                        updateSlider(false); // Прыжок БЕЗ анимации
                    }
                    // Если уехали назад на Клон 3 (при ручном управлении)
                    if (currentIndex === 0) {
                        currentIndex = realCount;
                        updateSlider(false);
                    }
                    isAnimating = false; // Открываем слайдер для следующих действий
                }, 500); 
            }

            // Управление кликами по точкам
            window.setSlide = function(index) {
                if (isAnimating) return;
                currentIndex = index + 1; // Учитываем сдвиг из-за клона в начале
                updateSlider(true);
                resetTimer();
            }

            // Автотаймер
            function startTimer() {
                interval = setInterval(nextSlide, 3500);
            }

            function resetTimer() {
                clearInterval(interval);
                startTimer();
            }

            // Ресайз окна (просто держим по центру, без анимации перестроения)
            window.addEventListener('resize', () => updateSlider(false));

            // Запуск
            setTimeout(() => {
                updateSlider(false);
                startTimer();
            }, 50);
        });
    </script>
</body>
</html>