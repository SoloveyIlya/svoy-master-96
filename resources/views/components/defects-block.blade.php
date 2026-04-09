{{--
  Props:
    $defects     – flat Collection (catalog/brand/model pages — без табов)
    $categories  – Collection<Category> with ->defects loaded (главная — с табами)
    $activeSlug  – slug текущей поломки (подсвечивает карточку на catalog-страницах)
--}}
@props(['defects' => null, 'categories' => null, 'activeSlug' => null, 'brand' => null, 'model' => null])

@if($categories && $categories->count() > 0)
{{-- ═══════════════════════════════════════════════════════
     TAB MODE — главная страница
═══════════════════════════════════════════════════════ --}}
@php
    $tabLabels = [
        'remont-telefonov'    => 'Телефоны',
        'remont-planshetov'   => 'Планшеты',
        'remont-noutbukov'    => 'Ноутбуки',
        'remont-smart-chasov' => 'Смарт-часы',
    ];
    $firstSlug   = $categories->first()->slug;
    $initialShow = 10; // карточек видно сразу, остальные скрыты
@endphp

<section class="py-14 bg-gray-50" id="defects-section">
    <div class="max-w-[87.5rem] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Что случилось с устройством?</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Выберите категорию — покажем частые поломки и стоимость ремонта</p>
        </div>

        {{-- ── Табы ── --}}
        <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-10" role="tablist" id="defect-tabs">
            @foreach($categories as $cat)
            @php $label = $tabLabels[$cat->slug] ?? $cat->name; @endphp
            <button
                type="button"
                role="tab"
                data-defect-tab="{{ $cat->slug }}"
                class="defect-tab-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-[#0678A8]
                       {{ $loop->first
                            ? 'bg-[#0678A8] text-white shadow-md'
                            : 'bg-white text-gray-700 border border-gray-200 hover:border-[#0678A8] hover:text-[#0678A8]' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- ── Панели ── --}}
        @foreach($categories as $cat)
        <div
            data-defect-panel="{{ $cat->slug }}"
            role="tabpanel"
            class="defect-panel {{ $loop->first ? '' : 'hidden' }}">

            @php
                $all     = $cat->defects;
                $initial = $all->take($initialShow);
                $more    = $all->skip($initialShow);
            @endphp

            @if($all->count() > 0)

            {{-- Сетка: первые $initialShow карточек --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                @foreach($initial as $defect)
                    @php
                        $url = route('catalog.defect', ['categorySlug' => $defect->category->slug ?? $cat->slug, 'defectSlug' => $defect->slug]);
                    @endphp
                    <a href="{{ $url }}"
                       class="w-full max-w-[14rem] mx-auto flex flex-col items-center text-center bg-white border border-gray-200 rounded-2xl p-4
                              hover:border-[#2AC0D5] hover:shadow-md transition-all group">
                            @if($defect->icon_svg)
                            <div class="flex items-center justify-center w-full min-h-[3rem] mb-2.5 shrink-0 text-[#0678A8] [&_svg]:block [&_svg]:h-10 [&_svg]:w-10 [&_svg]:max-h-full [&_svg]:max-w-full [&_svg]:shrink-0">
                                {!! $defect->icon_svg !!}
                            </div>
                            @else
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 group-hover:bg-[#e8f7fb] flex items-center justify-center mb-3 transition-colors shrink-0">
                                <svg class="w-7 h-7 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            @endif
                        <span class="text-sm font-semibold text-gray-800 leading-tight group-hover:text-[#0678A8] transition-colors">
                            {{ $defect->name }}
                        </span>
                        <span class="mt-2 text-xs text-[#0678A8] opacity-0 group-hover:opacity-100 transition-opacity font-medium">
                            Узнать цену →
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Скрытые карточки ($more) --}}
            @if($more->count() > 0)
            <div class="hidden defect-extra-cards grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 mt-4">
                @foreach($more as $defect)
                    @php
                        $url = route('catalog.defect', ['categorySlug' => $defect->category->slug ?? $cat->slug, 'defectSlug' => $defect->slug]);
                    @endphp
                    <a href="{{ $url }}"
                       class="w-full max-w-[14rem] mx-auto flex flex-col items-center text-center bg-white border border-gray-200 rounded-2xl p-4
                              hover:border-[#2AC0D5] hover:shadow-md transition-all group">
                            @if($defect->icon_svg)
                            <div class="flex items-center justify-center w-full min-h-[3rem] mb-2.5 shrink-0 text-[#0678A8] [&_svg]:block [&_svg]:h-10 [&_svg]:w-10 [&_svg]:max-h-full [&_svg]:max-w-full [&_svg]:shrink-0">
                                {!! $defect->icon_svg !!}
                            </div>
                            @else
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 group-hover:bg-[#e8f7fb] flex items-center justify-center mb-3 transition-colors shrink-0">
                                <svg class="w-7 h-7 text-[#0678A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            @endif
                        <span class="text-sm font-semibold text-gray-800 leading-tight group-hover:text-[#0678A8] transition-colors">
                            {{ $defect->name }}
                        </span>
                        <span class="mt-2 text-xs text-[#0678A8] opacity-0 group-hover:opacity-100 transition-opacity font-medium">
                            Узнать цену →
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Кнопка «Показать все» --}}
            <div class="flex justify-center mt-6">
                <button type="button"
                        class="defect-show-more flex items-center gap-2 text-[#0678A8] font-semibold hover:text-[#2AC0D5] transition">
                    <span>Показать все поломки (ещё {{ $more->count() }})</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            @endif

            @else
            <p class="text-center text-gray-400 py-10">Поломки для этой категории скоро добавим.</p>
            @endif

        </div>
        @endforeach

        {{-- ── Нижние кнопки ── --}}
        <div class="flex flex-wrap justify-center gap-4 mt-10">
            <button type="button"
                    class="js-open-modal bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-semibold py-3 px-8 rounded-full transition"
                    data-cta-title="Другая поломка">
                Другая поломка
            </button>
            <a href="{{ route('defects.index') }}"
               class="flex items-center gap-2 border border-[#0678A8] text-[#0678A8] hover:bg-[#0678A8] hover:text-white font-semibold py-3 px-8 rounded-full transition">
                Все поломки
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</section>

@elseif($defects && $defects->count() > 0)
{{-- ═══════════════════════════════════════════════════════
     FLAT MODE — страницы каталога (категория / бренд / модель)
═══════════════════════════════════════════════════════ --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-[87.5rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Частые неисправности</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Выберите неисправность — покажем стоимость ремонта</p>
        </div>

        @php
            $initialShow = 10;
            $initial     = $defects->take($initialShow);
            $more        = $defects->skip($initialShow);
        @endphp

        <div class="defect-panel">
            {{-- первые 8 карточек --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                @foreach($initial as $defect)
                    @php
                        $isActive = $defect->slug === $activeSlug;
                        $href = !$isActive
                            ? route('catalog.defect', ['categorySlug' => $defect->category->slug ?? request()->route('categorySlug'), 'defectSlug' => $defect->slug])
                            : null;
                    @endphp

                    @if($href)
                        <a href="{{ $href }}"
                           class="w-full max-w-[14rem] mx-auto flex flex-col items-center text-center bg-white border border-gray-200 rounded-2xl p-4
                                  hover:border-[#2AC0D5] hover:shadow-md transition-all group">
                    @else
                        <div class="w-full max-w-[14rem] mx-auto flex flex-col items-center text-center bg-white border rounded-2xl p-4 transition-all group
                                    {{ $isActive ? 'border-[#0678A8] shadow-md' : 'border-gray-200' }}">
                    @endif
                            @if(!empty($defect->icon_svg))
                                <div class="flex items-center justify-center w-full min-h-[3rem] mb-2.5 shrink-0 text-[#0678A8] [&_svg]:block [&_svg]:h-10 [&_svg]:w-10 [&_svg]:max-h-full [&_svg]:max-w-full [&_svg]:shrink-0">
                                    {!! $defect->icon_svg !!}
                                </div>
                            @endif

                            <span class="text-sm font-semibold text-gray-800 leading-tight {{ $isActive ? 'text-[#0678A8]' : 'group-hover:text-[#0678A8] transition-colors' }}">
                                {{ $defect->name }}
                            </span>

                            @if($href)
                                <span class="mt-2 text-xs text-[#0678A8] opacity-0 group-hover:opacity-100 transition-opacity font-medium">
                                    Узнать цену →
                                </span>
                            @endif
                    @if($href)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- скрытые карточки --}}
            @if($more->count() > 0)
            <div class="hidden defect-extra-cards grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 mt-4">
                @foreach($more as $defect)
                    @php
                        $isActive = $defect->slug === $activeSlug;
                        $href = !$isActive
                            ? route('catalog.defect', ['categorySlug' => $defect->category->slug ?? request()->route('categorySlug'), 'defectSlug' => $defect->slug])
                            : null;
                    @endphp

                    @if($href)
                        <a href="{{ $href }}"
                           class="w-full max-w-[14rem] mx-auto flex flex-col items-center text-center bg-white border border-gray-200 rounded-2xl p-4
                                  hover:border-[#2AC0D5] hover:shadow-md transition-all group">
                    @else
                        <div class="w-full max-w-[14rem] mx-auto flex flex-col items-center text-center bg-white border rounded-2xl p-4 transition-all group
                                    {{ $isActive ? 'border-[#0678A8] shadow-md' : 'border-gray-200' }}">
                    @endif
                            @if(!empty($defect->icon_svg))
                                <div class="flex items-center justify-center w-full min-h-[3rem] mb-2.5 shrink-0 text-[#0678A8] [&_svg]:block [&_svg]:h-10 [&_svg]:w-10 [&_svg]:max-h-full [&_svg]:max-w-full [&_svg]:shrink-0">
                                    {!! $defect->icon_svg !!}
                                </div>
                            @endif

                            <span class="text-sm font-semibold text-gray-800 leading-tight {{ $isActive ? 'text-[#0678A8]' : 'group-hover:text-[#0678A8] transition-colors' }}">
                                {{ $defect->name }}
                            </span>

                            @if($href)
                                <span class="mt-2 text-xs text-[#0678A8] opacity-0 group-hover:opacity-100 transition-opacity font-medium">
                                    Узнать цену →
                                </span>
                            @endif
                    @if($href)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Кнопка показать/скрыть --}}
            <div class="flex justify-center mt-6">
                <button type="button"
                        class="defect-show-more flex items-center gap-2 text-[#0678A8] font-semibold hover:text-[#2AC0D5] transition">
                    <span>Показать все неисправности (ещё {{ $more->count() }})</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

@once
@push('scripts')
<script>
(function () {
    'use strict';

    // ── Tab switching (главная) ─────────────────────────────────────
    const tabBtns   = document.querySelectorAll('.defect-tab-btn');
    const panels    = document.querySelectorAll('.defect-panel');

    tabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = btn.dataset.defectTab;

            tabBtns.forEach(function (b) {
                if (b.dataset.defectTab === target) {
                    b.classList.add('bg-[#0678A8]', 'text-white', 'shadow-md');
                    b.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200',
                                       'hover:border-[#0678A8]', 'hover:text-[#0678A8]');
                } else {
                    b.classList.remove('bg-[#0678A8]', 'text-white', 'shadow-md');
                    b.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200',
                                    'hover:border-[#0678A8]', 'hover:text-[#0678A8]');
                }
            });

            panels.forEach(function (p) {
                if (p.dataset.defectPanel === target) {
                    p.classList.remove('hidden');
                } else {
                    p.classList.add('hidden');
                }
            });
        });
    });

    // ── Show more / collapse (главная и внутренние страницы) ───────
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.defect-show-more');
        if (!btn) return;

        var panel = btn.closest('.defect-panel');
        if (!panel) return;
        var extra   = panel.querySelector('.defect-extra-cards');
        var arrow   = btn.querySelector('svg');
        var label   = btn.querySelector('span');
        var count   = extra ? extra.querySelectorAll('a, div').length : 0;

        if (extra && extra.classList.contains('hidden')) {
            extra.classList.remove('hidden');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
            if (label) label.textContent = 'Скрыть';
        } else if (extra) {
            extra.classList.add('hidden');
            if (arrow) arrow.style.transform = '';
            if (label) label.textContent = 'Показать все поломки (ещё ' + count + ')';
        }
    });

}());
</script>
@endpush
@endonce
