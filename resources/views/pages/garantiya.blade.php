@extends('layouts.app')

@section('title', 'Гарантия на ремонт — Свой Мастер Екатеринбург')
@section('seo_description', 'Гарантия на ремонт телефонов, ноутбуков и планшетов в сервисном центре Свой Мастер в Екатеринбурге. До 2 лет на работы и запчасти.')

@section('content')

    <x-hero-banner
        title="Гарантия на ремонт"
        subtitle="Мы уверены в качестве своей работы. Предоставляем гарантию до 2 лет на все виды ремонта и установленные запчасти."
    />

    {{-- Условия гарантии --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-12">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A] mb-4">Условия гарантии</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Мы работаем честно и открыто. Все гарантийные обязательства фиксируются в договоре.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#0678A8] flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1A1A1A] mb-1">До 2 лет на запчасти и работы</h3>
                        <p class="text-gray-600 text-sm">Гарантийный срок зависит от типа ремонта и установленных компонентов. Стандартная гарантия — 6 месяцев, на оригинальные запчасти — до 2 лет.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#0678A8] flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1A1A1A] mb-1">Письменный договор</h3>
                        <p class="text-gray-600 text-sm">Все условия ремонта и гарантийные обязательства фиксируются в договоре до начала работ. Никаких устных договорённостей.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#0678A8] flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1A1A1A] mb-1">Бесплатное гарантийное обслуживание</h3>
                        <p class="text-gray-600 text-sm">Если в течение гарантийного срока возникнет проблема по нашей вине, устраним её бесплатно и в кратчайшие сроки.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <h3 class="font-bold text-[#1A1A1A] mb-4 text-lg">Сроки гарантии по видам ремонта</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Замена экрана (оригинал)</span>
                        <span class="font-bold text-[#0678A8]">12 мес.</span>
                    </li>
                    <li class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Замена батареи</span>
                        <span class="font-bold text-[#0678A8]">6 мес.</span>
                    </li>
                    <li class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Замена корпуса / стекла</span>
                        <span class="font-bold text-[#0678A8]">6 мес.</span>
                    </li>
                    <li class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Ремонт платы / пайка</span>
                        <span class="font-bold text-[#0678A8]">3 мес.</span>
                    </li>
                    <li class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Прошивка / настройка ПО</span>
                        <span class="font-bold text-[#0678A8]">1 мес.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <x-contact-form title="Есть вопросы по гарантии?" />

@endsection
