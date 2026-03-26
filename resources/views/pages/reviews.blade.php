@extends('layouts.app')

@section('title', 'Отзывы клиентов - Svoy Master')
@section('seo_description', 'Отзывы о ремонте телефонов, ноутбуков и планшетов в сервисном центре Свой Мастер в Екатеринбурге. Честные мнения наших клиентов.')

@section('content')
    <x-breadcrumbs :links="['' => 'Отзывы']" />

    <x-hero-banner 
        title="Отзывы наших клиентов" 
        subtitle="Честные мнения о ремонте от тех, кто уже доверил нам свою технику" 
    />

    <x-reviews-block :reviews="$reviews" :title="null" :isWhite="true" />

    <div class="pb-12">
        <x-contact-form />
    </div>
@endsection
