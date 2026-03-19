@extends('layouts.app')

@section('title', 'Поломки')

@section('content')
    <section class="container py-5">
        <h1 class="mb-4">Поломки</h1>

        @if ($defects->isEmpty())
            <p>Список поломок пока пуст.</p>
        @else
            <ul>
                @foreach ($defects as $defect)
                    <li>
                        <a href="{{ route('defects.show', $defect->slug) }}">
                            {{ $defect->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
