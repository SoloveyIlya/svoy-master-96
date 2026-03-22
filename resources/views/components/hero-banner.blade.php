@props(['title', 'subtitle', 'image' => null])

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
        <button type="button" 
                class="js-open-modal inline-block bg-white hover:bg-[#FFD12A] text-[#0678A8] hover:text-[#1A1A1A] font-bold py-4 px-10 rounded-full transition-all transform hover:scale-105 shadow-lg"
                data-cta-title="{{ $title }}">
            Оставить заявку
        </button>
    </div>
</section>
