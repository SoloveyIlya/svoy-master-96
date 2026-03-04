<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Свой Мастер - Ремонт цифровой техники')</title>
    <meta name="description" content="@yield('meta_description', '')">
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @endif
    @hasSection('noindex')
        <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body { font-family: 'Inter', sans-serif; }
        @stack('styles')
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

    <x-header />

    {{-- NAVIGATION MENU --}}
    <nav class="w-full bg-[#0678A8] text-white shadow-md relative z-20">
        <div class="max-w-[1400px] mx-auto px-4 flex items-center justify-between lg:justify-start lg:gap-12 py-3.5 text-[15px] font-medium">
            <a href="/services/remont-apple" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт Apple <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="/services/remont-telefonov" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт телефонов <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="/services/remont-noutbukov" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт ноутбуков <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="/services/remont-planshetov" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт планшетов <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
            <a href="/services/remont-drugikh-ustroystv" class="flex items-center gap-1 hover:text-[#2AC0D5] transition">
                Ремонт других устройств <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
