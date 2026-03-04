@extends('layouts.app')

@section('title', $seo['title'] ?? $service->name . ' ' . $model->name)
@section('meta_description', $seo['description'] ?? '')

@if($seo['canonical_url'])
    @section('canonical', $seo['canonical_url'])
@endif

@if($seo['noindex'])
    @section('noindex', true)
@endif

@section('content')
    <h1>{{ $seo['h1'] ?? $service->name . ' ' . $model->name }}</h1>

    @if($seo['intro'])
        <div class="intro">{!! $seo['intro'] !!}</div>
    @endif

    @if($seo['body'])
        <div class="body">{!! $seo['body'] !!}</div>
    @endif

    @if($seo['faq'])
        <div class="faq">
            <h2>FAQ</h2>
            @foreach($seo['faq'] as $item)
                <details>
                    <summary>{{ $item['question'] }}</summary>
                    <p>{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    @endif

    <h2>Debug: Переменные</h2>
    <pre>Category: {{ $category->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Brand: {{ $brand->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Model: {{ $model->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Service: {{ $service->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Landing: {{ $landing->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>SEO Data: {{ json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
@endsection
