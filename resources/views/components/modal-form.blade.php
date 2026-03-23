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

            <!-- Success Message -->
            <div id="modal-success" class="hidden text-center py-12">
                <div class="mb-6">
                    <svg class="w-16 h-16 text-emerald-500 mx-auto animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#1A1A1A] mb-2">Заявка отправлена!</h3>
                <p class="text-gray-600 mb-6">Спасибо за обращение. Наш менеджер свяжется с вами в ближайшее время по указанному номеру телефона.</p>
                <button
                    type="button"
                    class="bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-bold px-8 py-3 rounded-full transition"
                    data-modal-close
                >
                    Закрыть
                </button>
            </div>

            <!-- Form Content -->
            <div id="modal-form-content">
                <h2 id="modal-title" class="text-2xl sm:text-3xl font-bold text-[#1A1A1A] mb-6">Оставить заявку</h2>

                <form id="modal-form" action="{{ route('leads.store') }}" method="POST" class="space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                    @csrf
                    <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">

                    <div>
                        <input
                            type="text"
                            name="name"
                            required
                            placeholder="Имя"
                            class="peer w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition focus:invalid:border-red-500 invalid:[&:not(:placeholder-shown)]:border-red-500"
                        >
                        <p class="hidden peer-invalid:[&:not(:placeholder-shown)]:block text-red-500 text-xs mt-1 pl-4">Обязательное поле для заполнения</p>
                    </div>
                    <div>
                        <input
                            type="tel"
                            name="phone"
                            required
                            pattern="[\+]\d{1}\s[\(]\d{3}[\)]\s\d{3}[\-]\d{2}[\-]\d{2}"
                            placeholder="+7 (___) ___-__-__"
                            x-mask="+7 (999) 999-99-99"
                            class="peer w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition focus:invalid:border-red-500 invalid:[&:not(:placeholder-shown)]:border-red-500"
                        >
                        <p class="hidden peer-invalid:[&:not(:placeholder-shown)]:block text-red-500 text-xs mt-1 pl-4">Введите телефон в формате +7 (XXX) XXX-XX-XX</p>
                    </div>
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

                    <button type="submit" :disabled="isSubmitting" class="w-full bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-bold rounded-full py-4 transition shadow-md disabled:opacity-75 disabled:cursor-not-allowed">
                        <span x-text="isSubmitting ? 'Отправка...' : 'Отправить'">Отправить</span>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('modal-form');
    const formContent = document.getElementById('modal-form-content');
    const successMessage = document.getElementById('modal-success');
    
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });
            
            if (response.ok) {
                // Hide form, show success
                formContent.classList.add('hidden');
                successMessage.classList.remove('hidden');
            } else {
                console.error('Form submission failed:', response.statusText);
            }
        } catch (error) {
            console.error('Error submitting form:', error);
        }
    });
});
</script>
