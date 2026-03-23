@extends('layouts.app')

@section('title', $defect->name . ' - Поломки')
@section('seo_description', $defect->name . ': ' . $defect->description)
@section('og_title', $defect->name)
@section('og_description', $defect->name . ' - частые поломки оборудования и способы их решения')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-hero-banner 
        :title="$defect->name"
        subtitle="Разбираем причины и предлагаем решения"
    />

    <section class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-lg border border-gray-100">
            <h2 class="text-2xl font-bold text-[#1A1A1A] mb-6">Описание неисправности</h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                {{ $defect->description }}
            </div>

            @if($defect->service)
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-8">
                    <h3 class="text-lg font-bold text-[#1A1A1A] mb-4">Решение: {{ $defect->service->name }}</h3>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-gray-600 mb-1">Связанная услуга поможет устранить эту поломку.</p>
                        </div>
                        <a href="{{ url('ceny') }}" class="shrink-0 bg-gradient-to-r from-[#0678A8] to-[#029DBF] text-white px-6 py-3 rounded-full font-bold hover:opacity-90 transition shadow-md text-center w-full sm:w-auto">
                            Смотреть цены
                        </a>
                    </div>
                </div>
            @endif

            <a href="{{ route('defects.index') }}" class="inline-flex items-center text-gray-500 hover:text-[#0678A8] transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Вернуться к списку поломок
            </a>
        </div>
    </section>

    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
    <x-workflow-block />
@endsection
