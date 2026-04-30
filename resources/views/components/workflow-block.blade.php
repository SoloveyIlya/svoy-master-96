<section class="max-w-[87.5rem] mx-auto px-4 py-16">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10 sm:mb-12 text-[#1A1A1A]">Алгоритм работы</h2>
    
    <div class="relative">
        {{-- Линия и стрелочки между этапами (только для десктопа) --}}
        <div class="hidden lg:block absolute top-[2.5rem] left-0 w-full h-0 z-0 pointer-events-none">
            {{-- Соединительная линия --}}
            <div class="absolute top-0 left-[12.5%] w-[75%] h-[2px] bg-gray-200"></div>
            
            {{-- Стрелки ровно в промежутках (25%, 50%, 75%) --}}
            <div class="absolute left-[25%] top-0 -translate-x-1/2 -translate-y-1/2">
                <svg class="w-8 h-8 text-[#2AC0D5] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
            </div>
            <div class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2">
                <svg class="w-8 h-8 text-[#2AC0D5] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
            </div>
            <div class="absolute left-[75%] top-0 -translate-x-1/2 -translate-y-1/2">
                <svg class="w-8 h-8 text-[#2AC0D5] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
            </div>
        </div>

        {{-- Сама сетка с шагами --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center relative z-10 px-4 sm:px-0">
            <div class="group">
                <div class="w-20 h-20 mx-auto bg-[#2AC0D5] text-white rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md relative z-10 transition-transform group-hover:scale-110 duration-300">1</div>
                <div class="font-bold text-lg mb-2">Заявка</div>
                <p class="text-sm text-gray-500 font-light">Вы оставляете заявку на сайте или приносите технику к нам</p>
            </div>
            {{-- Стрелка для мобилок --}}
            <div class="lg:hidden flex justify-center -my-4 relative z-0">
                <svg class="w-6 h-6 text-[#2AC0D5] animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path></svg>
            </div>
            <div class="group">
                <div class="w-20 h-20 mx-auto bg-white border-4 border-[#2AC0D5] text-[#2AC0D5] rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md relative z-10 transition-transform group-hover:scale-110 duration-300">2</div>
                <div class="font-bold text-lg mb-2">Диагностика</div>
                <p class="text-sm text-gray-500 font-light">Бесплатно выявляем точную причину неисправности</p>
            </div>
            {{-- Стрелка для мобилок --}}
            <div class="lg:hidden flex justify-center -my-4 relative z-0">
                <svg class="w-6 h-6 text-[#2AC0D5] animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path></svg>
            </div>
            <div class="group">
                <div class="w-20 h-20 mx-auto bg-white border-4 border-[#2AC0D5] text-[#2AC0D5] rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md relative z-10 transition-transform group-hover:scale-110 duration-300">3</div>
                <div class="font-bold text-lg mb-2">Ремонт</div>
                <p class="text-sm text-gray-500 font-light">Согласовываем цену и производим ремонт устройства</p>
            </div>
            {{-- Стрелка для мобилок --}}
            <div class="lg:hidden flex justify-center -my-4 relative z-0">
                <svg class="w-6 h-6 text-[#2AC0D5] animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path></svg>
            </div>
            <div class="group">
                <div class="w-20 h-20 mx-auto bg-white border-4 border-[#2AC0D5] text-[#2AC0D5] rounded-full flex items-center justify-center text-2xl font-bold mb-4 shadow-md relative z-10 transition-transform group-hover:scale-110 duration-300">4</div>
                <div class="font-bold text-lg mb-2">Выдача</div>
                <p class="text-sm text-gray-500 font-light">Возвращаем рабочее устройство вместе с гарантией</p>
            </div>
        </div>
    </div>
</section>
