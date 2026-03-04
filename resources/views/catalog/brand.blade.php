@extends('layouts.app')

@section('title', $brand->seo_title ?? $brand->name . ' — ' . $category->name)
@section('meta_description', $brand->seo_description ?? '')

@section('content')
    <h1>{{ $brand->seo_h1 ?? $brand->name }}</h1>

    <h2>Debug: Переменные</h2>
    <pre>Category: {{ $category->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Brand: {{ $brand->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Models: {{ $models->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Services: {{ $services->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
@endsection
