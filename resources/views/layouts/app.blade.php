<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700;800&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'Свой Мастер - Ремонт цифровой техники')</title>
    <meta name="description" content="@yield('seo_description', 'Профессиональный ремонт телефонов, ноутбуков и планшетов в Екатеринбурге. Оригинальные запчасти, гарантия до 2 лет.')">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Свой Мастер - Ремонт цифровой техники')">
    <meta property="og:description" content="@yield('og_description', 'Профессиональный ремонт телефонов, ноутбуков и планшетов в Екатеринбурге. Оригинальные запчасти, гарантия до 2 лет.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:locale" content="ru_RU">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Свой Мастер - Ремонт цифровой техники')">
    <meta name="twitter:description" content="@yield('og_description', 'Профессиональный ремонт телефонов, ноутбуков и планшетов в Екатеринбурге. Оригинальные запчасти, гарантия до 2 лет.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))">
    
    <!-- VK Meta Tags -->
    <meta property="vk:image" content="@yield('og_image', asset('images/logo.png'))">
    
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
    <style>
        html { -webkit-text-size-adjust: 100%; scroll-behavior: smooth; }
        /* FIX FOR BUTTON CURSORS GLOBAL */
        button, .js-open-modal, .slider-dot, .faq-btn, a, .brand-tab {
            cursor: pointer !important;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

    <div class="sticky top-0 z-50 shadow-md">
    <x-header />
<nav class="hidden lg:block w-full bg-[#0678A8] text-white shadow-md relative z-20 overflow-visible">
    <ul class="max-w-[87.5rem] w-full mx-auto px-4 flex items-center justify-between gap-3 xl:gap-5 py-3.5 text-sm font-medium whitespace-nowrap">
        @if(isset($mainCategories))
            @foreach($mainCategories as $category)
                    <li class="nav__item--has-dropdown flex items-center group static">
                        <a href="{{ route('catalog.category', $category->slug) }}" class="flex items-center hover:text-[#2AC0D5] transition group-hover:text-[#2AC0D5]">
                            {{ str_replace('Ремонт ', '', $category->name) }}
                        </a>
                        <button type="button" class="js-mega-menu-trigger ml-1 px-1 h-full py-2 -my-2 text-white/50 hover:text-white transition" data-target="mega-menu-{{ $category->id }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        {{-- Mega Menu --}}
                        <div id="mega-menu-{{ $category->id }}" class="header-mega-menu absolute top-full left-0 w-full bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                            <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                                    @if($category->navBrands && $category->navBrands->count() > 0)
                                        @foreach($category->navBrands as $brand)
                                            <div>
                                                <a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}" class="font-bold mb-3 text-[#0678A8] block hover:text-[#2AC0D5] transition">{{ $brand->name }}</a>
                                                <ul class="space-y-2 text-sm">
                                                    @foreach($brand->navModels as $model)
                                                        <li><a href="{{ route('catalog.model', [$category->slug, $brand->slug, $model->slug]) }}" class="hover:text-[#2AC0D5] transition text-gray-600 block">{{ $model->name }}</a></li>
                                                    @endforeach
                                                    @if($brand->navModels->count() >= 4)
                                                        <li><a href="{{ route('catalog.brand', [$category->slug, $brand->slug]) }}" class="text-[#2AC0D5] hover:underline font-semibold block mt-3">Все модели →</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-span-full py-4 text-center text-gray-500">Нет брендов</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif

            {{-- Другие устройства --}}
            @if(isset($otherCategories) && $otherCategories->count() > 0)
                <li class="nav__item--has-dropdown flex items-center group static">
                    <button type="button" class="js-mega-menu-trigger flex items-center gap-1 text-white/90 hover:text-[#2AC0D5] transition" data-target="mega-menu-others">
                        Другие устройства
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    {{-- Mega Menu Other Devices --}}
                    <div id="mega-menu-others" class="header-mega-menu absolute top-full left-0 w-full bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                        <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($otherCategories as $otherCat)
                                    <div>
                                        <a href="{{ route('catalog.category', $otherCat->slug) }}" class="font-bold text-[#0678A8] hover:text-[#2AC0D5] transition block py-1">{{ $otherCat->name }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
            @endif

        {{-- ═══ Дополнительные пункты меню ═══ --}}

        {{-- Цены --}}
        <li class="flex items-center">
            <a href="{{ route('prices') }}" class="text-white/90 hover:text-[#2AC0D5] transition font-medium">Цены</a>
        </li>

        {{-- О компании (dropdown) --}}
        <li class="nav__item--has-dropdown flex items-center group static">
            <a href="{{ route('about') }}" class="text-white/90 hover:text-[#2AC0D5] transition font-medium">О компании</a>
            <button type="button" class="js-mega-menu-trigger ml-1 px-1 h-full py-2 -my-2 text-white/50 hover:text-white transition" data-target="mega-menu-about">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            {{-- Dropdown О компании --}}
            <div id="mega-menu-about" class="header-mega-menu absolute top-full left-0 w-full bg-gray-50 border-t-4 border-[#2AC0D5] shadow-2xl transition-all duration-300 opacity-0 invisible z-50 text-gray-800 text-left whitespace-normal cursor-default">
                <div class="max-w-[87.5rem] mx-auto px-4 py-8">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        <div>
                            <a href="{{ route('about') }}" class="font-bold text-[#0678A8] hover:text-[#2AC0D5] transition block py-1">О компании</a>
                            <p class="text-sm text-gray-500 mt-1">Наша история, команда и принципы работы</p>
                        </div>
                        <div>
                            <a href="{{ route('reviews') }}" class="font-bold text-[#0678A8] hover:text-[#2AC0D5] transition block py-1">Отзывы</a>
                            <p class="text-sm text-gray-500 mt-1">Что говорят наши клиенты</p>
                        </div>
                        <div>
                            <a href="{{ route('akcii') }}" class="font-bold text-[#0678A8] hover:text-[#2AC0D5] transition block py-1">Акции</a>
                            <p class="text-sm text-gray-500 mt-1">Скидки и специальные предложения</p>
                        </div>
                        <div>
                            <a href="{{ route('garantiya') }}" class="font-bold text-[#0678A8] hover:text-[#2AC0D5] transition block py-1">Гарантия</a>
                            <p class="text-sm text-gray-500 mt-1">Условия гарантии на ремонт</p>
                        </div>
                        <div>
                            <a href="{{ route('faq') }}" class="font-bold text-[#0678A8] hover:text-[#2AC0D5] transition block py-1">Вопрос-ответ</a>
                            <p class="text-sm text-gray-500 mt-1">Ответы на частые вопросы</p>
                        </div>
                    </div>
                </div>
            </div>
        </li>

        {{-- Контакты --}}
        <li class="flex items-center">
            <a href="{{ route('contacts') }}" class="text-white/90 hover:text-[#2AC0D5] transition font-medium">Контакты</a>
        </li>

        </ul>
    </nav>
    </div>

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

            // 3. Мега-меню (динамическое)
            document.addEventListener('click', (e) => {
                const trigger = e.target.closest('.js-mega-menu-trigger');
                const allMenus = document.querySelectorAll('.header-mega-menu');
                
                // Если кликнули по кнопке-стрелочке
                if (trigger) {
                    e.preventDefault();
                    e.stopPropagation();
                    const targetId = trigger.getAttribute('data-target');
                    const targetMenu = document.getElementById(targetId);
                    
                    // Закрываем все остальные открытые меню
                    allMenus.forEach(menu => {
                        if (menu.id !== targetId) {
                            menu.classList.remove('is-active', '!opacity-100', '!visible');
                        }
                    });
                    
                    // Переключаем текущее
                    if (targetMenu) {
                        targetMenu.classList.toggle('is-active');
                        targetMenu.classList.toggle('!opacity-100');
                        targetMenu.classList.toggle('!visible');
                    }
                    return;
                }
                
                // Если клик внутри уже открытого мега-меню
                const activeMenu = document.querySelector('.header-mega-menu.is-active');
                if (activeMenu && activeMenu.contains(e.target)) {
                    // Разрешаем переход по ссылкам внутри
                    if (e.target.closest('a')) return;
                    return; // Иначе ничего не делаем
                }
                
                // Если клик мимо меню -> закрываем всё
                allMenus.forEach(menu => {
                    menu.classList.remove('is-active', '!opacity-100', '!visible');
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
