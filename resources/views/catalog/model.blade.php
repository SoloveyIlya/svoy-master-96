@extends('layouts.app')

@section('title', $model->seo_title ?? $model->name . ' — ' . $brand->name)
@section('meta_description', $model->seo_description ?? '')

@section('content')
    <h1>{{ $model->seo_h1 ?? $model->name }}</h1>

    <p>
        <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}">← Назад к бренду</a> |
        <a href="{{ route('catalog.category', [$category->slug]) }}">К категории</a> |
        <a href="{{ route('home') }}">На главную</a>
    </p>

    <p><strong>SEO title:</strong> {{ $model->seo_title ?? '-' }}</p>
    <p><strong>SEO description:</strong> {{ $model->seo_description ?? '-' }}</p>
    <p><strong>Категория / Бренд:</strong> {{ $category->name }} / {{ $brand->name }}</p>

    <h2>Услуги</h2>
    @if($landingPages->isEmpty())
        <p>Услуги не найдены.</p>
    @else
        <ul>
            @foreach($landingPages as $landingPage)
                @if($landingPage->service)
                    <li>
                        <a href="{{ route('catalog.landing', [$category->slug, $brand->slug, $model->slug, $landingPage->service->slug]) }}">
                            {{ $landingPage->service->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
@endsection
