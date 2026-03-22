@extends('layouts.app')

@section('title', 'Страница не найдена - 404')
@section('meta_description', 'Страница не найдена. Вернитесь на главную страницу сервисного центра Свой Мастер.')

@section('content')
<section class="max-w-[87.5rem] mx-auto px-4 py-20 text-center min-h-[60vh] flex flex-col items-center justify-center">
    <h1 class="text-[#0678A8] font-bold text-9xl drop-shadow-lg mb-6">404</h1>
    <h2 class="text-3xl sm:text-4xl font-bold text-[#1A1A1A] mb-4">Упс! Страница не найдена</h2>
    <p class="text-gray-500 text-lg mb-8 max-w-xl">
        Возможно, она была удалена, перемещена или вы ошиблись при вводе адреса. 
        Не переживайте, наша главная страница всегда работает!
    </p>
    <a href="{{ route('home') }}" class="inline-flex items-center justify-center bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-bold rounded-full py-4 px-10 transition shadow-md">
        Вернуться на главную
    </a>
</section>
@endsection
