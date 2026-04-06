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
            <div class="flex flex-row flex-wrap justify-center items-center gap-3 sm:gap-4 mx-auto mb-8 sm:mb-10 w-full px-2">
                @if($price)
                    <div class="flex items-center gap-3 sm:gap-4 bg-white/90 backdrop-blur rounded-2xl shadow-lg p-3 md:p-4 min-w-[45%] flex-1 sm:flex-none">
                        <div class="bg-[#2AC0D5]/10 p-2 sm:p-2.5 rounded-full text-[#0678A8] hidden sm:block">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_6_13185)">
                                    <path d="M11 17H13V16H14C14.55 16 15 15.55 15 15V12C15 11.45 14.55 11 14 11H11V10H15V8H13V7H11V8H10C9.45 8 9 8.45 9 9V12C9 12.55 9.45 13 10 13H13V14H9V16H11V17ZM20 4H4C2.89 4 2.01 4.89 2.01 6L2 18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V6H20V18Z" fill="currentColor"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_6_13185">
                                        <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="text-left flex-1 border-l-2 border-gray-100 sm:border-transparent sm:pl-0 pl-3">
                            <div class="text-[10px] sm:text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5 sm:mb-1">Цена</div>
                            <div class="text-[#0678A8] font-bold text-base sm:text-xl leading-tight">
                                @if(is_numeric($price))
                                    от {{ number_format((int)$price, 0, '', ' ') }} ₽
                                @else
                                    {{ $price }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if($duration)
                    <div class="flex items-center gap-3 sm:gap-4 bg-white/90 backdrop-blur rounded-2xl shadow-lg p-3 md:p-4 min-w-[45%] flex-1 sm:flex-none">
                        <div class="bg-[#2AC0D5]/10 p-2 sm:p-2.5 rounded-full text-[#0678A8] hidden sm:block">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_6_12365)">
                                <path d="M22 5.72L17.4 1.86L16.11 3.39L20.71 7.25L22 5.72ZM7.88 3.39L6.6 1.86L2 5.71L3.29 7.24L7.88 3.39ZM12 4C7.03 4 3 8.03 3 13C3 17.97 7.02 22 12 22C16.97 22 21 17.97 21 13C21 8.03 16.97 4 12 4ZM12 20C8.13 20 5 16.87 5 13C5 9.13 8.13 6 12 6C15.87 6 19 9.13 19 13C19 16.87 15.87 20 12 20ZM10.54 14.53L8.41 12.4L7.35 13.46L10.53 16.64L16.53 10.64L15.47 9.58L10.54 14.53Z" fill="currentColor"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_6_12365">
                                <rect width="24" height="24" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="text-left flex-1 border-l-2 border-gray-100 sm:border-transparent sm:pl-0 pl-3">
                            <div class="text-[10px] sm:text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5 sm:mb-1">Срок</div>
                            <div class="text-[#0678A8] font-bold text-base sm:text-xl leading-tight">от {{ $duration }}</div>
                        </div>
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
