@extends('layouts.app')

@section('title', 'Частые поломки и неисправности — Свой Мастер Екатеринбург')
@section('seo_description', 'Частые поломки телефонов, ноутбуков, планшетов и часов. Выберите неисправность — узнайте стоимость ремонта в Екатеринбурге.')
@section('og_title', 'Частые поломки и неисправности — Свой Мастер')
@section('og_description', 'Выберите категорию устройства и тип поломки — мы покажем стоимость ремонта и сроки.')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'Частые поломки']" />

    <x-hero-banner 
        title="Частые поломки устройств"
        subtitle="Выберите категорию и тип неисправности — узнайте стоимость ремонта и запишитесь к мастеру."
    />

    {{-- Блок с табами по типам устройств --}}
    <x-defects-block :categories="$defectCategories" />

    <x-workflow-block />

    <x-reviews-block :reviews="$reviews" />

    <x-contact-form />
    <x-banners-slider :banners="$banners ?? collect()" />
@endsection
