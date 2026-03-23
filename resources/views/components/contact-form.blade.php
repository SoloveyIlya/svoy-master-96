@props(['title' => 'Контакты'])

<section class="max-w-[87.5rem] mx-auto px-4 pb-20 mt-10">
    <div class="bg-[#0678A8] rounded-[2rem] p-5 sm:p-8 md:p-12 text-white grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center relative overflow-hidden shadow-xl">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay z-0"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">{{ $title }}</h2>
            <div class="space-y-4 mb-8">
                <a href="tel:+73432264622" class="flex items-center gap-3 hover:text-[#2AC0D5] transition"><svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +7 (343) 226-46-22</a>
                <a href="mailto:remont@svoymaster96.ru" class="flex items-center gap-3 hover:text-[#2AC0D5] transition"><svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> remont@svoymaster96.ru</a>
                <p class="flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> г. Екатеринбург, Антона Валека, 13, офис 200</p>
            </div>
            <x-map-block />
        </div>
        
        <div class="relative z-10 bg-white p-5 sm:p-8 rounded-[1rem] shadow-2xl text-[#1A1A1A]">
            <h3 class="text-xl sm:text-2xl font-bold mb-6 text-center">Оставьте заявку</h3>
            
            <!-- Success Message -->
            <div id="success-message" class="hidden mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <h4 class="font-bold text-emerald-900">Заявка отправлена!</h4>
                        <p class="text-sm text-emerald-800 mt-1">Спасибо за обращение. Наш менеджер свяжется с вами в ближайшее время.</p>
                    </div>
                </div>
            </div>
            
            <form id="contact-form" action="{{ route('leads.store') }}" method="POST" class="space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                @csrf
                <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">

                <div>
                    <input type="text" name="name" required placeholder="Имя" class="peer w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition focus:invalid:border-red-500 invalid:[&:not(:placeholder-shown)]:border-red-500">
                    <p class="hidden peer-invalid:[&:not(:placeholder-shown)]:block text-red-500 text-xs mt-1 pl-4">Обязательное поле для заполнения</p>
                </div>
                <div>
                    <input type="tel" name="phone" required pattern="[\+]\d{1}\s[\(]\d{3}[\)]\s\d{3}[\-]\d{2}[\-]\d{2}" placeholder="+7 (___) ___-__-__" x-mask="+7 (999) 999-99-99" class="peer w-full border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition focus:invalid:border-red-500 invalid:[&:not(:placeholder-shown)]:border-red-500">
                    <p class="hidden peer-invalid:[&:not(:placeholder-shown)]:block text-red-500 text-xs mt-1 pl-4">Введите телефон в формате +7 (XXX) XXX-XX-XX</p>
                </div>
                <textarea name="comment" rows="2" placeholder="Комментарий" class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-[#2AC0D5] transition resize-none"></textarea>

                <label class="inline-flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="agree" value="1" class="mt-1" required>
                    <span>Согласен на обработку данных</span>
                </label>

                <button type="submit" :disabled="isSubmitting" class="w-full bg-[#2AC0D5] hover:bg-[#0678A8] text-white font-bold rounded-full py-4 transition shadow-md cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed">
                    <span x-text="isSubmitting ? 'Отправка...' : 'Отправить'">Отправить</span>
                </button>

                <p class="text-xs text-center text-gray-500">
                    Нажимая кнопку, вы соглашаетесь с
                    <a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer" class="underline hover:text-[#0678A8]">политикой конфиденциальности</a>
                </p>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const successMessage = document.getElementById('success-message');
    
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
                // Show success message
                successMessage.classList.remove('hidden');
                
                // Reset form
                form.reset();
                
                // Scroll to success message
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    successMessage.classList.add('hidden');
                }, 5000);
            } else {
                console.error('Form submission failed:', response.statusText);
            }
        } catch (error) {
            console.error('Error submitting form:', error);
        }
    });
});
</script>
