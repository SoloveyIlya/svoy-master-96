@props(['rows', 'activeSlug' => null])

@if(!empty($rows) && count($rows) > 0)
<div class="max-w-5xl mx-auto my-10 px-4 sm:px-6">
    <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">
        <ul class="divide-y divide-gray-100">
            @foreach($rows as $row)
                @php
                    $isActive = isset($row['slug']) && $row['slug'] === $activeSlug;
                @endphp
                <li class="flex flex-col md:flex-row items-start md:items-center justify-between p-5 sm:p-6 hover:bg-[#2AC0D5]/5 transition-colors group {{ $isActive ? 'bg-blue-50/50 border-l-4 border-[#0678A8]' : '' }}">
                    <div class="flex-grow pr-4 mb-4 md:mb-0 w-full md:w-auto">
                        @if(!$isActive && !empty($row['url']))
                            <a href="{{ $row['url'] }}" class="block text-lg font-bold text-gray-900 mb-1 group-hover:text-[#0678A8] transition-colors hover:underline">
                                {{ $row['name'] }}
                            </a>
                        @else
                            <h4 class="text-lg font-bold text-gray-900 mb-1 {{ $isActive ? 'text-[#0678A8]' : 'group-hover:text-[#0678A8] transition-colors' }}">{{ $row['name'] }}</h4>
                        @endif
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1.5 text-[#2AC0D5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Время ремонта: <span class="font-medium text-gray-700">{{ $row['duration'] }}</span></span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between md:justify-end w-full md:w-auto gap-4 md:gap-8 border-t md:border-t-0 pt-4 md:pt-0 border-gray-100">
                        <div class="text-left md:text-right">
                            <div class="text-xs text-gray-500 mb-0.5">Стоимость</div>
                            <div class="text-xl sm:text-2xl font-black text-gray-900 whitespace-nowrap">
                                {{ $row['price'] && (int)$row['price'] > 0 ? 'от ' . number_format((int)$row['price'], 0, '', ' ') . ' ₽' : 'от 500 ₽' }}
                            </div>
                        </div>
                        <button type="button" class="js-open-modal shrink-0 bg-[#0678A8]/10 hover:bg-[#0678A8] text-[#0678A8] hover:text-white font-bold py-2.5 px-6 rounded-xl transition-all hover:shadow-md cursor-pointer" data-cta-title="Заказать: {{ $row['name'] }}">
                            Заказать
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
