@extends('layouts.app')

@section('title', 'Контакты - Svoy Master')
@section('seo_description', 'Адрес, телефон и мессенджеры сервисного центра. Г. Екатеринбург, открыты пн-вс: 9:00-22:00')
@section('og_title', 'Контакты - Svoy Master')
@section('og_description', 'Свяжитесь с нами: +7 (343) 226-46-22, г. Екатеринбург, Антона Валека, 13')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'Контакты']" />

    <x-hero-banner 
        title="Контакты"
        subtitle="Мы всегда на связи. Приезжайте в наш сервисный центр или закажите выезд мастера."
    />

    <section class="max-w-[87.5rem] mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-[#1A1A1A]">Наши филиалы</h2>
                
                {{-- Филиал 1 --}}
                <div class="space-y-3">
                    <h3 class="font-bold text-[#0678A8]">Центральный офис</h3>
                    <p class="flex items-center gap-3 text-gray-700">
                        <svg class="w-6 h-6 text-[#0678A8] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        г. Екатеринбург, Антона Валека, 13, офис 200
                    </p>
                    <p class="flex items-center gap-3 text-gray-700">
                        <svg class="w-6 h-6 text-[#0678A8] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Пн - Вс: 09:00 - 22:00
                    </p>
                </div>

                {{-- Филиал 2 --}}
                <div class="space-y-3">
                    <h3 class="font-bold text-[#0678A8]">Филиал ЖБИ</h3>
                    <p class="flex items-center gap-3 text-gray-700">
                        <svg class="w-6 h-6 text-[#0678A8] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        г. Екатеринбург, Рассветная улица, 8/1
                    </p>
                    <p class="flex items-center gap-3 text-gray-700">
                        <svg class="w-6 h-6 text-[#0678A8] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Пн - Вс: 09:00 - 22:00
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-[#1A1A1A]">Связь с нами</h2>
                <div class="space-y-3">
                    <a href="tel:+73432264622" class="flex items-center gap-3 text-gray-700 hover:text-[#0678A8] transition">
                        <svg class="w-6 h-6 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        +7 (343) 226-46-22
                    </a>
                    <a href="mailto:remont@svoymaster96.ru" class="flex items-center gap-3 text-gray-700 hover:text-[#0678A8] transition">
                        <svg class="w-6 h-6 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        remont@svoymaster96.ru
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-[#1A1A1A]">Мессенджеры</h2>
                <div class="flex items-center gap-4">
                    <a href="/" class="w-12 h-12 rounded-full bg-gradient-to-r from-[#0678A8] to-[#029DBF] flex items-center justify-center hover:opacity-90 transition shadow-md">
                        <img src="{{ asset('images/TG.svg') }}" alt="Telegram" class="w-6 h-6 object-contain" />
                    </a>
                    <a href="/" class="w-12 h-12 rounded-full bg-gradient-to-r from-[#0678A8] to-[#029DBF] flex items-center justify-center hover:opacity-90 transition shadow-md">
                        <img src="{{ asset('images/WA.svg') }}" alt="WhatsApp" class="w-6 h-6 object-contain" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-[87.5rem] mx-auto px-4 pb-20">
        <x-map-block class="h-[400px] lg:h-[600px]" />
    </div>
@endsection
