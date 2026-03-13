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

    <p>
        <a href="{{ route('catalog.model', [$category->slug, $brand->slug, $model->slug]) }}">← Назад к модели</a> |
        <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}">К бренду</a> |
        <a href="{{ route('catalog.category', [$category->slug]) }}">К категории</a> |
        <a href="{{ route('home') }}">На главную</a>
    </p>

    <p><strong>Цена от:</strong> {{ $landing->resolvedPriceFrom() ?? '-' }}</p>
    <p><strong>Срок ремонта:</strong> {{ $service->duration_text ?? '-' }}</p>
    <p><strong>Гарантия:</strong> {{ $service->warranty_text ?? '-' }}</p>
    <p><strong>SEO title:</strong> {{ $seo['title'] ?? '-' }}</p>
    <p><strong>SEO description:</strong> {{ $seo['description'] ?? '-' }}</p>

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

    <h2>Оставить заявку</h2>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('leads.store') }}" method="POST">
        @csrf
        <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">
        <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">

        <p>
            <label for="name">Имя</label><br>
            <input id="name" type="text" name="name" value="{{ old('name') }}">
        </p>

        <p>
            <label for="phone">Телефон *</label><br>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
            @error('phone')
                <br><span>{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label for="comment">Комментарий</label><br>
            <textarea id="comment" name="comment">{{ old('comment') }}</textarea>
        </p>

        <p>
            <label>
                <input type="checkbox" name="agree" value="1" {{ old('agree') ? 'checked' : '' }}>
                Согласен на обработку персональных данных
            </label>
            @error('agree')
                <br><span>{{ $message }}</span>
            @enderror
        </p>

        <p>
            <button type="submit">Отправить заявку</button>
        </p>
    </form>
@endsection
