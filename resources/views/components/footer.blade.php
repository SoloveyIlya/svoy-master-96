<footer class="border-t border-gray-200 pt-12 pb-8">
    <div class="max-w-[87.5rem] mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
        {{-- Колонка 1: Лого, контакты --}}
        <div>
            <a href="{{ route('home') }}" class="inline-block mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Свой Мастер" loading="lazy" class="h-[4.5rem] w-auto object-contain">
            </a>
            <a href="tel:+73432264622" class="block text-lg font-bold text-[#1A1A1A] mb-1 hover:text-[#2AC0D5] transition">+7 (343) 226-46-22</a>
            <a href="mailto:remont@svoymaster96.ru" class="block text-sm text-[#0678A8] mb-4 hover:underline">remont@svoymaster96.ru</a>
            <div class="flex items-center gap-3">
                <a href="{{ route('contacts') }}" class="w-10 h-10 rounded-full bg-gradient-to-r from-[#0678A8] to-[#029DBF] flex items-center justify-center hover:opacity-90 transition shadow-sm hover:shadow-md">
                    <img src="{{ asset('images/TG.svg') }}" alt="Telegram" loading="lazy" class="w-5 h-5 object-contain" />
                </a>
                <a href="{{ route('contacts') }}" class="w-10 h-10 rounded-full bg-gradient-to-r from-[#0678A8] to-[#029DBF] flex items-center justify-center hover:opacity-90 transition shadow-sm hover:shadow-md">
                    <img src="{{ asset('images/WA.svg') }}" alt="WhatsApp" loading="lazy" class="w-5 h-5 object-contain" />
                </a>
            </div>
        </div>

        {{-- Колонка 2: Услуги --}}
        <div>
            <h4 class="font-bold text-[#1A1A1A] mb-4">Услуги</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('catalog.category', ['categorySlug' => 'remont-telefonov']) }}" class="hover:text-[#2AC0D5] transition">Ремонт телефонов</a></li>
                <li><a href="{{ route('catalog.category', ['categorySlug' => 'remont-noutbukov']) }}" class="hover:text-[#2AC0D5] transition">Ремонт ноутбуков</a></li>
                <li><a href="{{ route('catalog.category', ['categorySlug' => 'remont-planshetov']) }}" class="hover:text-[#2AC0D5] transition">Ремонт планшетов</a></li>
                <li><a href="{{ route('catalog.category', ['categorySlug' => 'remont-smart-chasov']) }}" class="hover:text-[#2AC0D5] transition">Ремонт смарт-часов</a></li>
                <li><a href="{{ route('catalog.category', ['categorySlug' => 'remont-komputerov']) }}" class="hover:text-[#2AC0D5] transition">Другие устройства</a></li>
            </ul>
        </div>

        {{-- Колонка 3: Информация --}}
        <div>
            <h4 class="font-bold text-[#1A1A1A] mb-4">Информация</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('about') }}" class="hover:text-[#2AC0D5] transition">О компании</a></li>
                <li><a href="https://yandex.by/maps/org/svoy_master/155446185701/?ll=60.589708%2C56.838908&z=16.49" target="_blank" rel="noopener noreferrer" class="hover:text-[#2AC0D5] transition">Отзывы</a></li>
                <li><a href="{{ route('warranty') }}" class="hover:text-[#2AC0D5] transition">Гарантия</a></li>
                <li><a href="{{ route('contacts') }}" class="hover:text-[#2AC0D5] transition">Контакты</a></li>
                <li><a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#2AC0D5] transition">Политика конфиденциальности</a></li>
            </ul>
        </div>

        {{-- Колонка 4: Адрес, рейтинг, оплата --}}
        <div>
            <h4 class="font-bold text-[#1A1A1A] mb-4">Ждем вас</h4>
            <p class="text-sm text-gray-600 mb-1">г. Екатеринбург, ул. Антона Валека, 13</p>
            <p class="text-sm text-gray-600 mb-4">Пн-Вс: 09:00 - 22:00</p>

            <a href="https://yandex.by/maps/org/svoy_master/155446185701/?ll=60.589708%2C56.838908&z=16.49" target="_blank" rel="noopener noreferrer" class="bg-gray-50 p-3 rounded-lg flex items-center gap-3 mb-4 w-max border border-gray-200 hover:border-[#2AC0D5] transition">
                <span class="text-2xl font-bold text-[#1A1A1A]">4.9</span>
                <div>
                    <div class="flex text-[#FFD12A] text-sm">★★★★★</div>
                    <span class="text-[10px] text-gray-500">Яндекс Карты</span>
                </div>
            </a>

            <div class="flex gap-2 opacity-50">
                <img src="{{ asset('images/visa.svg') }}" alt="Visa" loading="lazy" class="h-6">
                <img src="{{ asset('images/mastercard.svg') }}" alt="Mastercard" loading="lazy" class="h-6">
                <img src="{{ asset('images/mir.svg') }}" alt="Mir" loading="lazy" class="h-6">
            </div>
        </div>
    </div>

    <div class="max-w-[87.5rem] mx-auto px-4 text-xs text-gray-400 flex flex-col md:flex-row justify-between pt-4 border-t border-gray-100">
        <p>© 2024 Свой Мастер. Все права защищены.</p>
        <p>ИП Егоров Олег Валерьевич ИНН 661403702400</p>
    </div>
</footer>
