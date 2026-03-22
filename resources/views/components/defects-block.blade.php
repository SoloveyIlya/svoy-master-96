@props(['defects'])

@if($defects && $defects->count() > 0)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Частые неисправности</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($defects as $defect)
                <a href="{{ $defect->service_id ? url('ceny') : '#' }}" 
                   class="flex flex-col h-full bg-white hover:bg-blue-50 transition-all border border-gray-200 hover:border-blue-200 rounded-2xl p-6 group shadow-sm hover:shadow-md">
                    <div class="w-12 h-12 bg-gray-50 group-hover:bg-white rounded-xl flex items-center justify-center mb-4 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-700 mb-2 transition-colors">{{ $defect->name }}</h3>
                    <p class="text-sm text-gray-600 flex-grow">{{ $defect->description }}</p>
                    <div class="mt-4 text-sm font-semibold text-blue-600 inline-flex items-center opacity-0 group-hover:opacity-100 transition-opacity translate-y-2 group-hover:translate-y-0">
                        Узнать решение
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
