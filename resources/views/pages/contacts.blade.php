@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <section class="page-container catalog-page">
        <div class="catalog-card">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A] mb-6">Контакты</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm sm:text-base">
                <div class="space-y-3 text-gray-700">
                    <p><strong>Телефон:</strong> <a href="tel:+73432264622" class="text-[#0678A8] hover:text-[#2AC0D5]">+7 (343) 226-46-22</a></p>
                    <p><strong>Email:</strong> <a href="mailto:remont@svoymaster96.ru" class="text-[#0678A8] hover:text-[#2AC0D5]">remont@svoymaster96.ru</a></p>
                    <p><strong>Адрес:</strong> г. Екатеринбург, Антона Валека, 13, офис 200</p>
                    <p><strong>Режим работы:</strong> Пн-Вс 09:00-22:00</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-gray-600">
                    Свяжитесь с нами по телефону или в мессенджерах. Мы подскажем стоимость, сроки и удобный формат приема устройства.
                </div>
            </div>
        </div>
    </section>
@endsection
