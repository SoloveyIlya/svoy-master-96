@extends('layouts.app')

@section('title', $model->seo_title ?? $model->name . ' — ' . $brand->name)
@section('meta_description', $model->seo_description ?? '')

@section('content')
    <h1>{{ $model->seo_h1 ?? $model->name }}</h1>

    <h2>Debug: Переменные</h2>
    <pre>Category: {{ $category->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Brand: {{ $brand->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Model: {{ $model->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <pre>Landing Pages: {{ $landingPages->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
@endsection
