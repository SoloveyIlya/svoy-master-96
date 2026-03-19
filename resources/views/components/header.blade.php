<!-- HEADER (Top Info Bar) -->
<header class="w-full bg-white border-b border-gray-100">
    <div class="max-w-[87.5rem] mx-auto px-4 py-3 flex items-center justify-between lg:hidden">
        <a href="{{ route('home') }}" class="block">
            <img src="{{ asset('images/logo.png') }}" alt="Свой Мастер" class="h-12 w-auto object-contain">
        </a>
        <button
            type="button"
            id="burgerBtn"
            class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 text-[#0678A8]"
            aria-label="Открыть меню"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <div class="max-w-[87.5rem] mx-auto px-4 py-3 hidden lg:flex items-center justify-between">
        <!-- Logo Placeholder -->
        <a href="{{ route('home') }}" class="block">
            <img src="{{ asset('images/logo.png') }}" alt="Свой Мастер" class="w-[11.6875rem] h-[4.5rem] w-auto object-contain">
        </a>

        <!-- Info Blocks -->
        <div class="flex items-center gap-8 text-sm">
            <!-- Schedule -->
            <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-[#0678A8] mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs">График работы</span>
                    <span class="font-medium">Пн - Вс 09:00 - 22:00</span>
                </div>
            </div>

            <!-- Location -->
            <div class="flex items-center gap-2 border-l border-gray-200 pl-8">
                <svg class="w-5 h-5 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-medium">г. Екатеринбург</span>
            </div>

            <!-- Contacts -->
            <div class="flex flex-col border-l border-gray-200 pl-8 gap-1">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span class="font-semibold text-base">+7 (343) 226-46-22</span>
                </div>
                <div class="flex items-center gap-2 text-gray-500">
                    <svg class="w-4 h-4 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>remont@svoymaster96.ru</span>
                </div>
            </div>
        </div>

        <!-- Actions (Socials + CTA) -->
        <div class="flex items-center gap-4">
            <a href="{{ route('contacts') }}" class="w-10 h-10 rounded-full bg-gradient-to-r from-[#0678A8] to-[#029DBF] flex items-center justify-center hover:opacity-90 transition shadow-sm hover:shadow-md">
                <img src="{{ asset('images/TG.svg') }}" alt="Telegram" class="w-5 h-5 object-contain" />
            </a>
            <a href="{{ route('contacts') }}" class="w-10 h-10 rounded-full bg-gradient-to-r from-[#0678A8] to-[#029DBF] flex items-center justify-center hover:opacity-90 transition shadow-sm hover:shadow-md">
                <img src="{{ asset('images/WA.svg') }}" alt="WhatsApp" class="w-5 h-5 object-contain" />
            </a>
            <button
                type="button"
                class="js-open-modal bg-gradient-to-r from-[#0678A8] to-[#029DBF] hover:opacity-90 text-white font-medium py-2.5 px-6 rounded-full transition shadow-md hover:shadow-lg"
                data-cta-title="Вызвать мастера"
            >
                Вызвать мастера
            </button>
        </div>
    </div>

    <div
        id="mobileMenu"
        class="fixed inset-0 -translate-x-full transition-transform duration-300 bg-white z-[999] overflow-y-auto"
        aria-hidden="true"
    >
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Свой Мастер" class="h-12 w-auto object-contain">
                </a>
                <button
                    type="button"
                    id="closeMobileMenu"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 text-[#0678A8]"
                    aria-label="Закрыть меню"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mb-8 space-y-4">
                {{-- Category 1 --}}
                <div class="mobile-nav__group border-b border-gray-100 pb-2">
                    <div class="mobile-nav__header flex items-center justify-between cursor-pointer py-2">
                        <span class="text-lg font-semibold text-[#1A1A1A]">Ремонт телефонов</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="mobile-nav__content hidden pt-2 pb-4 space-y-2 pl-4">
                        <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'apple']) }}" class="block text-gray-600 hover:text-[#0678A8]">Apple</a>
                        <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'samsung']) }}" class="block text-gray-600 hover:text-[#0678A8]">Samsung</a>
                        <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'xiaomi']) }}" class="block text-gray-600 hover:text-[#0678A8]">Xiaomi</a>
                        <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'honor']) }}" class="block text-gray-600 hover:text-[#0678A8]">Honor</a>
                        <a href="{{ route('catalog.category', ['categorySlug' => 'remont-telefonov']) }}" class="block text-[#0678A8] font-medium pt-2">Все бренды &rarr;</a>
                    </div>
                </div>

                {{-- Category 2 --}}
                <div class="mobile-nav__group border-b border-gray-100 pb-2">
                    <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'apple']) }}" class="block py-2 text-lg font-semibold text-[#1A1A1A]">Ремонт Apple</a>
                </div>

                {{-- Category 3 --}}
                <div class="mobile-nav__group border-b border-gray-100 pb-2">
                    <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'samsung']) }}" class="block py-2 text-lg font-semibold text-[#1A1A1A]">Ремонт Samsung</a>
                </div>

                {{-- Category 4 --}}
                <div class="mobile-nav__group border-b border-gray-100 pb-2">
                    <div class="mobile-nav__header flex items-center justify-between cursor-pointer py-2">
                        <span class="text-lg font-semibold text-[#1A1A1A]">Ремонт ноутбуков</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="mobile-nav__content hidden pt-2 pb-4 space-y-2 pl-4">
                        <a href="#" class="block text-gray-600 hover:text-[#0678A8]">Apple MacBook</a>
                        <a href="#" class="block text-gray-600 hover:text-[#0678A8]">Asus</a>
                        <a href="#" class="block text-gray-600 hover:text-[#0678A8]">Acer</a>
                        <a href="#" class="block text-gray-600 hover:text-[#0678A8]">Lenovo</a>
                        <a href="#" class="block text-gray-600 hover:text-[#0678A8]">HP</a>
                        <a href="{{ route('catalog.category', ['categorySlug' => 'remont-noutbukov']) }}" class="block text-[#0678A8] font-medium pt-2">Все бренды &rarr;</a>
                    </div>
                </div>

                {{-- Category 5 --}}
                <div class="mobile-nav__group border-b border-gray-100 pb-2">
                    <a href="{{ route('catalog.brand', ['categorySlug' => 'remont-telefonov', 'brandSlug' => 'xiaomi']) }}" class="block py-2 text-lg font-semibold text-[#1A1A1A]">Ремонт Xiaomi</a>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200 space-y-3">
                <h3 class="text-sm uppercase tracking-wide text-gray-500 mb-2">Контакты</h3>
                <a href="tel:+73432264622" class="block text-lg font-semibold text-[#0678A8]">+7 (343) 226-46-22</a>
                <p class="text-gray-600">г. Екатеринбург, Антона Валека, 13, офис 200</p>
                <p class="text-gray-600">Пн - Вс 09:00 - 22:00</p>
            </div>
        </div>
    </div>
