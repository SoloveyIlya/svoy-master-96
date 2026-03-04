@extends('layouts.app')

@section('title', $seo['title'] ?? $service->name . ' — ' . $brand->name)
@section('meta_description', $seo['description'] ?? '')

@section('content')
    <h1>{{ $seo['h1'] ?? $service->name }}</h1>

    @if($seo['intro'])
        <div class="intro">{!! $seo['intro'] !!}</div>
    @endif

    <h2>Debug: Переменные</h2>
    <pre>Category: {{ $category->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Brand: {{ $brand->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Service: {{ $service->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Scope: {{ $scope->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>SEO Data: {{ json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
@endsection
