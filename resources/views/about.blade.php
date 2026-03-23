@extends('layouts.app')

@section('title', 'О компании')
@section('seo_description', 'Снайте этo о сервисном центре Svoy Master. Опыт работы 7+ лет, оценка 4.9 звезд, гарантия до 2 лет')
@section('og_title', 'О компании - Svoy Master')
@section('og_description', 'Снайте о нас: 7 лет опыта, гарантия до 2 лет, оригинальные запчасти. Оценка 4.9 звезд на Яндекс.Картах')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['О компании' => null]" />

    <section class="page-container catalog-page">
        <div class="catalog-card space-y-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">О компании</h1>
            <p class="text-gray-600 leading-relaxed">
                «Свой Мастер» – сервисный центр профессионального ремонта цифровой техники в Екатеринбурге. 
                Мы специализируемся на качественном и честном ремонте смартфонов, планшетов, ноутбуков и других устройств 
                с гарантией результата.
            </p>
        </div>
    </section>

    <!-- Информация о компании -->
    <section class="max-w-[87.5rem] mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-[#1A1A1A] mb-6">Информация о компании</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>
                        Мы работаем на рынке ремонта цифровой техники более 7 лет. Наша команда состоит из опытных мастеров, 
                        прошедших специальное обучение по диагностике и ремонту современных устройств.
                    </p>
                    <p>
                        Наша миссия – предоставить доступный и качественный ремонт техники каждому жителю Екатеринбурга. 
                        Мы гордимся своей репутацией: средняя оценка на Яндекс.Картах составляет 4.9 звезды из 5.
                    </p>
                    <p>
                        Используем только оригинальные и сертифицированные запчасти, что гарантирует долго жизнь 
                        отремонтированного устройства. Наша работа защищена гарантией до 2 лет.
                    </p>
                    <p>
                        Сервисный центр находится в центре города, легко добраться на метро или автомобиле. 
                        Работаем без перерывов с 9:00 до 22:00 каждый день.
                    </p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#0678A8]/10 to-[#2AC0D5]/10 rounded-3xl p-8 lg:p-12">
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-xl font-bold text-[#1A1A1A] mb-2">Опыт работы</h3>
                        <p class="text-3xl font-bold text-[#0678A8]">7+ лет</p>
                        <p class="text-sm text-gray-600 mt-1">На рынке ремонта техники</p>
                    </div>
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-xl font-bold text-[#1A1A1A] mb-2">Методы ремонта</h3>
                        <p class="text-lg text-[#0678A8] font-semibold">Холодная пайка + Ультразвук</p>
                        <p class="text-sm text-gray-600 mt-1">Современное оборудование, высокая точность</p>
                    </div>
                    <div class="pb-4">
                        <h3 class="text-xl font-bold text-[#1A1A1A] mb-2">Гарантия</h3>
                        <p class="text-3xl font-bold text-[#0678A8]">До 2 лет</p>
                        <p class="text-sm text-gray-600 mt-1">На все выполняемые работы</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Почему выбирают нас -->
    <x-advantages-block />

    <!-- Контакты -->
    <x-contact-form title="Свяжитесь с нами" />
@endsection
