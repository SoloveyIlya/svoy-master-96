<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Форма запуска --}}
        <x-filament::section>
            <x-slot name="heading">Настройки парсинга</x-slot>
            <x-slot name="description">
                Парсер обходит все страницы брендов на сайте svoymaster96.ru и загружает
                категории, бренды, модели и услуги в базу данных нового сайта.
            </x-slot>

            <div>
                {{ $this->form }}
            </div>
        </x-filament::section>

        {{-- Как это работает --}}
        <x-filament::section>
            <x-slot name="heading">Как работает парсер</x-slot>

            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-5">
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-2 font-semibold text-primary-600">1. Discover</div>
                    <p class="text-gray-600 dark:text-gray-400">Формирует список из 30 страниц брендов (смартфоны, планшеты, ноутбуки, часы)</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-2 font-semibold text-primary-600">2. Fetch</div>
                    <p class="text-gray-600 dark:text-gray-400">Скачивает HTML каждой страницы с задержкой 1 сек между запросами</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-2 font-semibold text-primary-600">3. Parse</div>
                    <p class="text-gray-600 dark:text-gray-400">Извлекает модели и таблицы услуг/цен по паттерну «прайс-лист ремонта {модель}»</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-2 font-semibold text-primary-600">4. Upsert</div>
                    <p class="text-gray-600 dark:text-gray-400">Создаёт / обновляет Category → Brand → DeviceModel → Service → LandingPage</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-2 font-semibold text-primary-600">5. Finalize</div>
                    <p class="text-gray-600 dark:text-gray-400">Деактивирует модели и лендинги из предыдущих запусков, которых больше нет на сайте</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Таблица истории запусков --}}
        <x-filament::section>
            <x-slot name="heading">История запусков</x-slot>
            <x-slot name="description">Обновляется автоматически каждые 5 секунд</x-slot>

            {{ $this->table }}
        </x-filament::section>

    </div>
</x-filament-panels::page>
