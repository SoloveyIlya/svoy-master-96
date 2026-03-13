@extends('layouts.app')

@section('title', $category->seo_title ?? $category->name)
@section('meta_description', $category->seo_description ?? '')

@section('content')
    <h1>{{ $category->seo_h1 ?? $category->name }}</h1>

    <p><a href="{{ route('home') }}">← Назад на главную</a></p>

    <p><strong>SEO title:</strong> {{ $category->seo_title ?? '-' }}</p>
    <p><strong>SEO description:</strong> {{ $category->seo_description ?? '-' }}</p>
    <p><strong>Описание:</strong> {{ $category->seo_intro ?? '-' }}</p>

    <h2>Бренды</h2>
    @if($brands->isEmpty())
        <p>Бренды не найдены.</p>
    @else
        <ul>
            @foreach($brands as $brand)
                <li>
                    <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}">
                        {{ $brand->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
