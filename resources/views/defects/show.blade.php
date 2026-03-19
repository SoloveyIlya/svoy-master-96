@extends('layouts.app')

@section('title', $defect->name)

@section('content')
    <section class="container py-5">
        <h1 class="mb-2">{{ $defect->name }}</h1>
        <p class="mb-4">{{ $defect->description }}</p>

        <a href="{{ route('defects.index') }}">Все поломки</a>
    </section>
@endsection
