@props(['title' => 'Контакты'])

<section class="max-w-[87.5rem] mx-auto px-4 pb-20 mt-10">
    <div class="bg-[#0678A8] rounded-[2rem] p-5 sm:p-8 md:p-12 text-white grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center relative overflow-hidden shadow-xl">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay z-0"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">{{ $title }}</h2>
            <div class="space-y-4 mb-8">
                <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +7 (343) 226-46-22</p>
                <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> remont@svoymaster96.ru</p>
                <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> г. Екатеринбург, Антона Валека, 13, офис 200</p>
            </div>
            <x-map-block />
        </div>
        
        <div class="relative z-10 bg-white p-5 sm:p-8 rounded-[1rem] shadow-2xl text-[#1A1A1A]">
            <h3 class="text-xl sm:text-2xl font-bold mb-6 text-center">Оставьте заявку</h3>
            <form action="{{ route('leads.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">

                <input type="text" name="name" placeholder="Имя" class="w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition">
                <input type="tel" name="phone" required placeholder="+7 (___) ___-__-__" class="w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition">
                <textarea name="comment" rows="2" placeholder="Комментарий" class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition resize-none"></textarea>

                <label class="inline-flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="agree" value="1" class="mt-1" required>
                    <span>Согласен на обработку данных</span>
                </label>

                <button type="submit" class="w-full bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-bold rounded-full py-4 transition shadow-md cursor-pointer">
                    Отправить
                </button>

                <p class="text-xs text-center text-gray-500">
                    Нажимая кнопку, вы соглашаетесь с
                    <a href="{{ route('privacy') }}" target="_blank" class="underline hover:text-[#0678A8]">политикой конфиденциальности</a>
                </p>
            </form>
        </div>
    </div>
</section>
