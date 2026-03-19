<div
    id="global-cta-modal"
    class="fixed inset-0 z-[70] hidden"
    aria-hidden="true"
>
    <div class="absolute inset-0 bg-black/55" data-modal-close></div>

    <div class="relative z-10 min-h-full flex items-center justify-center p-4">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-6 sm:p-8 relative">
            <button
                type="button"
                class="absolute top-4 right-4 inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-200 text-gray-500 hover:text-[#0678A8]"
                aria-label="Закрыть"
                data-modal-close
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 id="modal-title" class="text-2xl sm:text-3xl font-bold text-[#1A1A1A] mb-6">Оставить заявку</h2>

            <form action="{{ route('leads.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">

                <input
                    type="text"
                    name="name"
                    placeholder="Имя"
                    class="w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition"
                >
                <input
                    type="tel"
                    name="phone"
                    required
                    placeholder="+7 (___) ___-__-__"
                    class="w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition"
                >
                <textarea
                    name="comment"
                    rows="3"
                    placeholder="Комментарий"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition resize-none"
                ></textarea>

                <label class="inline-flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="agree" value="1" class="mt-1" required>
                    <span>Согласен на обработку персональных данных</span>
                </label>

                <button type="submit" class="w-full bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-bold rounded-full py-4 transition shadow-md">
                    Отправить
                </button>

                <p class="text-sm text-center text-gray-600">
                    Нажимая кнопку, вы соглашаетесь с
                    <a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer" class="underline hover:text-[#0678A8]">
                        политикой обработки персональных данных
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
