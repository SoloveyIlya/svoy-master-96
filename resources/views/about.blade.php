@extends('layouts.app')

@section('title', 'О компании')
@section('seo_description', 'Снайте этo о сервисном центре Svoy Master. Опыт работы 7+ лет, оценка 4.9 звезд, гарантия до 2 лет')
@section('og_title', 'О компании - Svoy Master')
@section('og_description', 'Снайте о нас: 7 лет опыта, гарантия до 2 лет, оригинальные запчасти. Оценка 4.9 звезд на Яндекс.Картах')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'О компании']" />

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

    <!-- Почему выбирают нас -->
    <x-advantages-block />

    <!-- Контакты -->
    <x-contact-form title="Свяжитесь с нами" />
@endsection
