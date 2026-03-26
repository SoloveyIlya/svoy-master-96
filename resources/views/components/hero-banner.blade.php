@props(['title', 'subtitle', 'image' => null, 'price' => null, 'duration' => null])

<section class="relative bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] text-white overflow-hidden py-16 sm:py-20 px-4 sm:px-6 lg:px-8 rounded-[2rem] mx-4 my-6 shadow-xl">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
    
    @if($image)
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ $image }}');"></div>
    @endif
    
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight mb-6 leading-tight">
            {{ $title }}
        </h1>
        <p class="text-lg sm:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
            {{ $subtitle }}
        </p>
        
        @if($price || $duration)
            <div class="flex flex-wrap justify-center gap-4 mb-10">
                @if($price)
                    <div class="flex items-center gap-2 bg-white/20 hover:bg-white/30 transition-colors backdrop-blur-sm px-6 py-3 rounded-2xl text-white font-bold shadow-sm">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>От {{ number_format((int)$price, 0, '', ' ') }} руб.</span>
                    </div>
                @endif
                @if($duration)
                    <div class="flex items-center gap-2 bg-white/20 hover:bg-white/30 transition-colors backdrop-blur-sm px-6 py-3 rounded-2xl text-white font-bold shadow-sm">
                        <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>От {{ $duration }}</span>
                    </div>
                @endif
            </div>
        @endif
        <button type="button" 
                class="js-open-modal inline-block bg-white hover:bg-cyan-50 text-[#0678A8] font-bold py-4 px-10 rounded-full transition-all transform hover:scale-105 shadow-lg"
                data-cta-title="{{ $title }}">
            Оставить заявку
        </button>
    </div>
</section>
