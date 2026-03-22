@props(['cases'])

@if($cases && $cases->count() > 0)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Справимся с любой задачей</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cases as $case)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow overflow-hidden border border-gray-100 flex flex-col group">
                    <div class="relative h-56 bg-gray-100 overflow-hidden">
                        @if($case->image_after)
                            <img src="{{ Str::startsWith($case->image_after, 'http') ? $case->image_after : asset('storage/' . $case->image_after) }}" alt="{{ $case->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">Без фото</div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 py-4 px-6 bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="text-white font-bold text-lg leading-tight">{{ $case->title }}</h3>
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <p class="text-gray-600 mb-6 flex-grow text-sm leading-relaxed">{{ $case->description }}</p>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-auto">
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Стоимость</div>
                                <div class="font-bold text-gray-900 text-xl">
                                    @if($case->price)
                                        {{ number_format($case->price, 0, '', ' ') }} ₽
                                    @else
                                        По запросу
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 mb-1">Сроки</div>
                                <div class="text-sm font-semibold text-blue-700 bg-blue-50 py-1 px-3 rounded-full border border-blue-100 whitespace-nowrap">
                                    {{ $case->duration ?? 'от 30 мин' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
