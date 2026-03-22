<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'Свой Мастер - Ремонт цифровой техники')</title>
    <meta name="description" content="@yield('seo_description', 'Профессиональный ремонт телефонов, ноутбуков и планшетов в Екатеринбурге. Оригинальные запчасти, гарантия до 2 лет.')">
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @endif
    @hasSection('noindex')
        <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        html { -webkit-text-size-adjust: 100%; }
        /* FIX FOR BUTTON CURSORS GLOBAL */
        button, .js-open-modal, .slider-dot, .faq-btn, a, .brand-tab {
            cursor: pointer !important;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

    <x-header />

    {{-- NAVIGATION MENU --}}
    <nav class="hidden lg:block w-full bg-[#0678A8] text-white shadow-md relative z-20 overflow-visible">
        <ul class="w-max min-w-full mx-auto px-4 flex items-center justify-start sm:justify-center lg:justify-evenly gap-5 lg:gap-8 py-3.5 text-sm font-medium whitespace-nowrap">
            
            {{-- 1. Ремонт телефонов --}}
            <li class="nav__item--has-dropdown" id="menu-trigger-phones">
                <a href="{{ route('catalog.category', ['categorySlug' => 'remont-telefonov']) }}" class="flex items-center gap-1 hover:text-[#2AC0D5] transition cursor-pointer">
                    Ремонт телефонов <svg class="w-4 h-4 opacity-70 nav__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                
                {{-- Mega Menu 1 --}}
                <div id="mega-menu-phones" class="header-mega-menu absolute top-full left-0 w-[100vw] max-w-[100vw] bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                    <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                        <div class="grid grid-cols-4 gap-8">
                            @if(isset($phoneBrands) && $phoneBrands->count() > 0)
                                @foreach($phoneBrands as $brand)
                                    <div>
                                        <h3 class="font-bold mb-4 text-[#0678A8]">{{ $brand->name }}</h3>
                                        <ul class="space-y-1 text-sm">
                                            @foreach($brand->models->where('category.slug', 'remont-telefonov')->take(5) as $model)
                                                <li><a href="{{ route('catalog.model', ['categorySlug' => 'remont-telefonov', 'brandSlug' => $brand->slug, 'modelSlug' => $model->slug]) }}" class="hover:text-[#2AC0D5] transition">{{ $model->name }}</a></li>
                                            @endforeach
                                            <li><a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => $brand->slug]) }}" class="text-[#2AC0D5] hover:underline font-semibold block mt-1">Все модели →</a></li>
                                        </ul>
                                    </div>
                                @endforeach
                            @else
                                {{-- Fallback --}}
                                <div><h3 class="font-bold mb-4 text-[#0678A8]">Популярные бренды</h3><ul class="space-y-2 text-sm"><li><a href="/" class="hover:text-[#2AC0D5] transition">Apple</a></li><li><a href="/" class="hover:text-[#2AC0D5] transition">Samsung</a></li></ul></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>

            {{-- 2. Ремонт Apple --}}
            <li class="nav__item--has-dropdown" id="menu-trigger-apple">
                <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'apple']) }}" class="flex items-center gap-1 hover:text-[#2AC0D5] transition cursor-pointer">
                    Ремонт Apple <svg class="w-4 h-4 opacity-70 nav__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                
                {{-- Mega Menu 2 --}}
                <div id="mega-menu-apple" class="header-mega-menu absolute top-full left-0 w-[100vw] max-w-[100vw] bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                    <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                        <div class="grid grid-cols-4 gap-8">
                            @if(isset($appleModels) && $appleModels->count() > 0)
                                @foreach($appleModels->chunk(ceil($appleModels->count() / 4)) as $chunk)
                                    <ul class="space-y-2 text-sm">
                                        @foreach($chunk as $model)
                                            <li><a href="{{ route('catalog.model', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'apple', 'modelSlug' => $model->slug]) }}" class="hover:text-[#2AC0D5] transition">{{ $model->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @else
                                {{-- Fallback --}}
                                <div><h3 class="font-bold mb-4 text-[#0678A8]">iPhone</h3><ul class="space-y-2 text-sm"><li><a href="/" class="hover:text-[#2AC0D5] transition">iPhone 15 Pro Max</a></li></ul></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>

            {{-- 3. Ремонт Samsung --}}
            <li class="nav__item--has-dropdown" id="menu-trigger-samsung">
                <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'samsung']) }}" class="flex items-center gap-1 hover:text-[#2AC0D5] transition cursor-pointer">
                    Ремонт Samsung <svg class="w-4 h-4 opacity-70 nav__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                
                {{-- Mega Menu 3 --}}
                <div id="mega-menu-samsung" class="header-mega-menu absolute top-full left-0 w-[100vw] max-w-[100vw] bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                    <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                        <div class="grid grid-cols-4 gap-8">
                            @if(isset($samsungModels) && $samsungModels->count() > 0)
                                @foreach($samsungModels->chunk(ceil($samsungModels->count() / 4)) as $chunk)
                                    <ul class="space-y-2 text-sm">
                                        @foreach($chunk as $model)
                                            <li><a href="{{ route('catalog.model', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'samsung', 'modelSlug' => $model->slug]) }}" class="hover:text-[#2AC0D5] transition">{{ $model->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @else
                                {{-- Fallback --}}
                                <div><h3 class="font-bold mb-4 text-[#0678A8]">Galaxy S</h3><ul class="space-y-2 text-sm"><li><a href="/" class="hover:text-[#2AC0D5] transition">Galaxy S24 Ultra</a></li></ul></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>

            {{-- 4. Ремонт ноутбуков --}}
            <li class="nav__item--has-dropdown" id="menu-trigger-laptops">
                <a href="{{ route('catalog.category', ['categorySlug' => 'remont-noutbukov']) }}" class="flex items-center gap-1 hover:text-[#2AC0D5] transition cursor-pointer">
                    Ремонт ноутбуков <svg class="w-4 h-4 opacity-70 nav__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                
                {{-- Mega Menu 4 --}}
                <div id="mega-menu-laptops" class="header-mega-menu absolute top-full left-0 w-[100vw] max-w-[100vw] bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                    <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                        <div class="grid grid-cols-4 gap-8">
                            @if(isset($laptopBrands) && $laptopBrands->count() > 0)
                                @foreach($laptopBrands as $brand)
                                    <div><a href="{{ route('catalog.brand', ['categorySlug' => 'remont-noutbukov', 'brandSlug' => $brand->slug]) }}" class="hover:text-[#2AC0D5] transition font-bold">{{ $brand->name }}</a></div>
                                @endforeach
                            @else
                                <div><h3 class="font-bold mb-4 text-[#0678A8]">Популярные бренды</h3><ul class="space-y-2 text-sm"><li><a href="/" class="hover:text-[#2AC0D5] transition">Apple MacBook</a></li></ul></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>

            {{-- 5. Ремонт Xiaomi --}}
            <li class="nav__item--has-dropdown" id="menu-trigger-xiaomi">
                <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'xiaomi']) }}" class="flex items-center gap-1 hover:text-[#2AC0D5] transition cursor-pointer">
                    Ремонт Xiaomi <svg class="w-4 h-4 opacity-70 nav__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                
                {{-- Mega Menu 5 --}}
                <div id="mega-menu-xiaomi" class="header-mega-menu absolute top-full left-0 w-[100vw] max-w-[100vw] bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                    <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                        <div class="grid grid-cols-4 gap-8">
                            @if(isset($xiaomiModels) && $xiaomiModels->count() > 0)
                                @foreach($xiaomiModels->chunk(ceil($xiaomiModels->count() / 4)) as $chunk)
                                    <ul class="space-y-2 text-sm">
                                        @foreach($chunk as $model)
                                            <li><a href="{{ route('catalog.model', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'xiaomi', 'modelSlug' => $model->slug]) }}" class="hover:text-[#2AC0D5] transition">{{ $model->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @else
                                {{-- Fallback --}}
                                <div><h3 class="font-bold mb-4 text-[#0678A8]">Redmi</h3><ul class="space-y-2 text-sm"><li><a href="/" class="hover:text-[#2AC0D5] transition">Redmi Note 13</a></li></ul></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    <x-footer />
    <x-modal-form />

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Мобильный бургер
            const burgerBtn = document.getElementById('burgerBtn');
            const closeBtn = document.getElementById('closeMobileMenu');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenu) {
                const toggleMenu = (show) => {
                    if (show) {
                        mobileMenu.classList.add('active', 'translate-x-0');
                        mobileMenu.classList.remove('-translate-x-full');
                        document.body.classList.add('overflow-hidden');
                    } else {
                        mobileMenu.classList.remove('active', 'translate-x-0');
                        mobileMenu.classList.add('-translate-x-full');
                        document.body.classList.remove('overflow-hidden');
                    }
                };

                if (burgerBtn) burgerBtn.addEventListener('click', () => toggleMenu(true));
                if (closeBtn) closeBtn.addEventListener('click', () => toggleMenu(false));
                
                // Закрытие по клику вне меню (на оверлей, если он будет добавлен позже)
                mobileMenu.addEventListener('click', (e) => {
                    if (e.target === mobileMenu) toggleMenu(false);
                });
            }

            // 2. Мобильный аккордеон
            document.querySelectorAll('.mobile-nav__group').forEach((group) => {
                const header = group.querySelector('.mobile-nav__header');
                if (header) {
                    header.addEventListener('click', () => { 
                        group.classList.toggle('open'); 
                        const content = group.querySelector('.mobile-nav__content');
                        if (content) {
                            content.classList.toggle('hidden');
                        }
                        const icon = group.querySelector('.text-gray-500');
                        if (icon) {
                            icon.classList.toggle('rotate-180');
                        }
                    });
                }
            });

            // 3. Мега-меню для КАЖДОГО пункта на десктопе
            const triggers = [
                { btn: 'menu-trigger-phones', menu: 'mega-menu-phones' },
                { btn: 'menu-trigger-apple', menu: 'mega-menu-apple' },
                { btn: 'menu-trigger-samsung', menu: 'mega-menu-samsung' },
                { btn: 'menu-trigger-laptops', menu: 'mega-menu-laptops' },
                { btn: 'menu-trigger-xiaomi', menu: 'mega-menu-xiaomi' },
            ];

            triggers.forEach(({btn, menu}) => {
                const triggerEl = document.getElementById(btn);
                const menuEl = document.getElementById(menu);
                
                if (triggerEl && menuEl) {
                    triggerEl.addEventListener('click', (e) => {
                        // Если клик внутри мега-меню (по моделям/брендам) - не блокируем переход
                        if(menuEl.contains(e.target) && e.target.closest('a')) return;

                        e.preventDefault();
                        
                        // Закрываем ВСЕ остальные открытые меню перед открытием нового
                        document.querySelectorAll('.header-mega-menu.is-active').forEach(el => {
                            if(el !== menuEl) {
                                el.classList.remove('is-active', '!opacity-100', '!visible');
                            }
                        });
                        
                        menuEl.classList.toggle('is-active');
                        menuEl.classList.toggle('!opacity-100');
                        menuEl.classList.toggle('!visible');
                    });
                }
            });

            // Закрытие меню при клике вне его
            document.addEventListener('click', (e) => {
                triggers.forEach(({btn, menu}) => {
                    const triggerEl = document.getElementById(btn);
                    const menuEl = document.getElementById(menu);
                    if (triggerEl && menuEl && menuEl.classList.contains('is-active')) {
                        if (!triggerEl.contains(e.target) && !menuEl.contains(e.target)) {
                            menuEl.classList.remove('is-active', '!opacity-100', '!visible');
                        }
                    }
                });
            });

            // 4. Глобальное модальное окно (CTA)
            const modal = document.getElementById('global-cta-modal');
            const modalTitle = document.getElementById('modal-title');
            
            const openModal = (title = 'Оставить заявку') => {
                if (!modal) return;
                if (modalTitle) modalTitle.textContent = title;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeModal = () => {
                if (!modal) return;
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            // Слушатель для всех кнопок с классом .js-open-modal
            document.addEventListener('click', (e) => {
                const target = e.target.closest('.js-open-modal');
                if (target) {
                    e.preventDefault();
                    const title = target.getAttribute('data-cta-title') || 'Оставить заявку';
                    openModal(title);
                }
            });

            // Закрытие модалки
            document.querySelectorAll('[data-modal-close]').forEach(el => {
                el.addEventListener('click', closeModal);
            });

            // Закрытие по Esc
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
</body>
</html>
