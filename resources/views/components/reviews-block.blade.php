@props(['reviews'])

@if($reviews && $reviews->count() > 0)
<section class="max-w-[87.5rem] mx-auto px-4 py-16 bg-gray-50 rounded-[2rem] mb-16">
    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center mb-8 sm:mb-10 text-[#1A1A1A]">Отзывы наших клиентов</h2>
    
    <div class="relative group" id="comp-reviews-slider">
        {{-- Кнопки навигации --}}
        <button id="comp-reviews-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 z-20 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-[#0678A8] hover:text-[#2AC0D5] transition group-hover:opacity-100 lg:opacity-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button id="comp-reviews-next" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 z-20 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-[#0678A8] hover:text-[#2AC0D5] transition group-hover:opacity-100 lg:opacity-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar gap-0 pb-6" id="comp-reviews-track">
            @foreach($reviews as $review)
                <div class="flex-shrink-0 w-full snap-center px-4 md:px-20 lg:px-40">
                    <div class="bg-white p-8 rounded-[1rem] shadow-sm h-full flex flex-col border border-gray-50 text-left">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-[#2AC0D5] rounded-full flex justify-center items-center text-white font-bold text-lg">
                                {{ mb_substr($review->client_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $review->client_name }}</h4>
                                <p class="text-xs text-gray-500">{{ optional($review->published_at)->format('d.m.Y') ?? $review->created_at->format('d.m.Y') }}</p>
                            </div>
                        </div>
                        <div class="flex text-[#FFD12A] mb-3 text-sm">
                            @for($i = 0; $i < ($review->rating ?? 5); $i++) ★ @endfor
                        </div>
                        <p class="text-gray-600 text-sm flex-grow">"{{ $review->text }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('comp-reviews-track');
            const btnPrev = document.getElementById('comp-reviews-prev');
            const btnNext = document.getElementById('comp-reviews-next');

            if (track && btnPrev && btnNext) {
                btnPrev.addEventListener('click', () => {
                    track.scrollBy({ left: -track.offsetWidth, behavior: 'smooth' });
                });
                btnNext.addEventListener('click', () => {
                    track.scrollBy({ left: track.offsetWidth, behavior: 'smooth' });
                });
            }
        });
    </script>
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</section>
@endif
