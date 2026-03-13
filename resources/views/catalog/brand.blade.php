@extends('layouts.app')

@section('title', $brand->seo_title ?? $brand->name . ' — ' . $category->name)
@section('meta_description', $brand->seo_description ?? '')

@section('content')
    <h1>{{ $brand->seo_h1 ?? $brand->name }}</h1>

    <p>
        <a href="{{ route('catalog.category', [$category->slug]) }}">← Назад к категории</a> |
        <a href="{{ route('home') }}">На главную</a>
    </p>

    <p><strong>SEO title:</strong> {{ $brand->seo_title ?? '-' }}</p>
    <p><strong>SEO description:</strong> {{ $brand->seo_description ?? '-' }}</p>
    <p><strong>Категория:</strong> {{ $category->name }}</p>

    <h2>Модели</h2>
    @if($models->isEmpty())
        <p>Модели не найдены.</p>
    @else
        <ul>
            @foreach($models as $deviceModel)
                <li>
                    <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $deviceModel->slug]) }}">
                        {{ $deviceModel->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
