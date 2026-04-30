@extends('layouts.app')

@section('title', 'Вопрос-ответ (FAQ) — Свой Мастер Екатеринбург')
@section('seo_description', 'Ответы на частые вопросы о ремонте телефонов, ноутбуков и планшетов в сервисном центре Свой Мастер в Екатеринбурге.')

@section('content')

    <x-hero-banner
        title="Вопрос — Ответ"
        subtitle="Собрали ответы на самые популярные вопросы о нашем сервисном центре, процессе ремонта и условиях работы."
    />

    {{-- FAQ аккордеон --}}
    <section class="max-w-[87.5rem] mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <div class="space-y-3" x-data="{ open: null }">

                @php
                $faqs = [
                    [
                        'q' => 'Сколько стоит диагностика?',
                        'a' => 'Диагностика абсолютно бесплатна. Мы определяем причину поломки и озвучиваем стоимость ремонта — без скрытых платежей. Если вы решаете не ремонтировать устройство, ничего платить не нужно.',
                    ],
                    [
                        'q' => 'Как долго занимает ремонт?',
                        'a' => 'Большинство видов ремонта выполняется в день обращения, прямо при вас: замена стекла, батареи, разъёма зарядки — от 30 минут до 2 часов. Сложные случаи (ремонт платы, залитие) могут занять 1–3 дня.',
                    ],
                    [
                        'q' => 'Какую гарантию вы даёте на ремонт?',
                        'a' => 'Мы предоставляем гарантию от 1 месяца до 2 лет в зависимости от вида ремонта и типа запчастей. Гарантийные обязательства фиксируются в договоре до начала работ.',
                    ],
                    [
                        'q' => 'Вы используете оригинальные запчасти?',
                        'a' => 'Да, мы работаем с оригинальными запчастями и качественными аналогами от проверенных поставщиков. Перед ремонтом мастер обсудит с вами выбор компонентов и их стоимость.',
                    ],
                    [
                        'q' => 'Могу ли я остаться и наблюдать за ремонтом?',
                        'a' => 'Конечно! Мы рады клиентам, которые хотят наблюдать за процессом. Большинство ремонтов выполняется прямо при вас.',
                    ],
                    [
                        'q' => 'Есть ли у вас выездной ремонт?',
                        'a' => 'Да, мы предоставляем услугу выездного мастера для корпоративных клиентов и в отдельных случаях — для физических лиц. Уточните детали по телефону или через форму обратной связи.',
                    ],
                    [
                        'q' => 'Что если ремонт не поможет?',
                        'a' => 'Если после диагностики окажется, что ремонт нецелесообразен или стоит слишком дорого, мы честно скажем об этом. Вы не платите за диагностику и ничем не обязаны.',
                    ],
                    [
                        'q' => 'Как вы обеспечиваете сохранность моих данных?',
                        'a' => 'Ваши личные данные, фотографии и файлы остаются в полной сохранности. Наши мастера не имеют доступа к вашим аккаунтам и приложениям — ремонт не требует разблокировки устройства.',
                    ],
                ];
                @endphp

                @foreach($faqs as $i => $faq)
                    <div class="border border-gray-200 rounded-2xl overflow-hidden"
                         x-data="{ isOpen: false }">
                        <button
                            @click="isOpen = !isOpen"
                            class="w-full flex items-center justify-between px-6 py-4 text-left font-semibold text-[#1A1A1A] hover:bg-gray-50 transition"
                            :aria-expanded="isOpen"
                        >
                            <span>{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-[#0678A8] shrink-0 transition-transform duration-300"
                                 :class="{ 'rotate-180': isOpen }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="isOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <x-contact-form title="Не нашли ответ? Спросите нас!" />

@endsection
