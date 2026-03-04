@extends('layouts.app')

@section('title', $category->seo_title ?? $category->name)
@section('meta_description', $category->seo_description ?? '')

@section('content')
    <h1>{{ $category->seo_h1 ?? $category->name }}</h1>

    <h2>Debug: Переменные</h2>
    <pre>Category: {{ $category->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Brands: {{ $brands->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Services: {{ $services->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
@endsection
