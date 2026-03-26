@extends('layouts.app')

@section('title', 'Гарантия на ремонт')
@section('seo_description', 'Условия гарантии на ремонт техники в Екатеринбурге. Гарантия до 2 лет на все оригинальные запчасти.')
@section('og_title', 'Гарантия - Svoy Master')
@section('og_description', 'Условия гарантии на ремонт. Мы гарантируем надежность и качество')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'Гарантия']" />

    <section class="page-container catalog-page">
        <div class="catalog-card space-y-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">Гарантия</h1>
            <p class="text-gray-600 leading-relaxed">
                На этой странице будут опубликованы условия гарантии на выполненные работы и установленные комплектующие,
                а также порядок обращения при гарантийном случае.
            </p>
        </div>
    </section>
@endsection
