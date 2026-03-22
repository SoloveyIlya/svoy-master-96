@props(['banners' => collect()])

<section class="w-full py-10 overflow-hidden bg-gray-50 banners-slider-wrapper">
    <div class="slider-container w-full relative">
        <div class="slider-track flex gap-4 md:gap-6 items-stretch will-change-transform px-4 md:px-[10%]">

            @if(isset($banners) && $banners->count() > 0)
                {{-- Динамические баннеры из БД --}}
                @foreach($banners as $banner)
                    <div class="slider-item w-[92%] sm:w-[88%] md:w-[85%] lg:w-[60rem] flex-shrink-0 rounded-[2rem] overflow-hidden h-[16.5rem] sm:h-[18rem] md:h-[22rem]">
                        <img src="{{ Str::startsWith($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Баннер" class="w-full h-full rounded-[2rem] object-cover" />
                    </div>
                @endforeach
            @else
                {{-- Хардкод-слайды (fallback) --}}
                <div class="slider-item w-[92%] sm:w-[88%] md:w-[85%] lg:w-[60rem] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[16.5rem] sm:h-[18rem] md:h-[22rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] shadow-lg flex">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
                    <div class="relative z-10 w-full md:w-[60%] h-full flex flex-col justify-center items-start px-6 sm:px-8 md:pl-16">
                        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-6 tracking-tight">
                            <span class="text-[#FFD12A]">-10%</span> на работу мастера<br>
                            Каждому клиенту за отзыв<br>
                            промо код "Спасибо Мастер"
                        </h2>
                        <button type="button" class="js-open-modal border border-white/50 text-white hover:bg-white hover:text-[#0678A8] text-sm font-medium py-2.5 px-6 rounded-full transition backdrop-blur-sm" data-cta-title="Оставить заявку по акции -10%">
                            Подробнее →
                        </button>
                    </div>
                    <div class="relative z-10 w-[40%] h-full flex items-end justify-center hidden md:flex">
                        <img src="{{ asset('images/man.png') }}" alt="Мастер" class="max-h-[95%] max-w-full object-contain object-bottom drop-shadow-lg" />
                    </div>
                </div>

                <div class="slider-item w-[92%] sm:w-[88%] md:w-[85%] lg:w-[60rem] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[16.5rem] sm:h-[18rem] md:h-[22rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] shadow-lg flex">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
                    <div class="relative z-10 w-full md:w-[60%] h-full flex flex-col justify-center items-start px-6 sm:px-8 md:pl-16">
                        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-6 tracking-tight">
                            <span class="text-[#FFD12A]">-15%</span> при заказе ремонта<br>
                            двух устройств сразу
                        </h2>
                        <button type="button" class="js-open-modal border border-white/50 text-white hover:bg-white hover:text-[#0678A8] text-sm font-medium py-2.5 px-6 rounded-full transition backdrop-blur-sm" data-cta-title="Оставить заявку по акции -15%">
                            Подробнее →
                        </button>
                    </div>
                    <div class="relative z-10 w-[40%] h-full flex items-end justify-center hidden md:flex">
                        <img src="{{ asset('images/man.png') }}" alt="Мастер" class="max-h-[95%] max-w-full object-contain object-bottom drop-shadow-lg" />
                    </div>
                </div>

                <div class="slider-item w-[92%] sm:w-[88%] md:w-[85%] lg:w-[60rem] flex-shrink-0 relative rounded-[2rem] overflow-hidden h-[16.5rem] sm:h-[18rem] md:h-[22rem] bg-gradient-to-r from-[#2AC0D5] to-[#0678A8] shadow-lg flex">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay pointer-events-none z-0"></div>
                    <div class="relative z-10 w-full md:w-[60%] h-full flex flex-col justify-center items-start px-6 sm:px-8 md:pl-16">
                        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-6 tracking-tight">
                            <span class="text-[#FFD12A]">Бесплатное</span> защитное<br>
                            стекло при замене дисплея
                        </h2>
                        <button type="button" class="js-open-modal border border-white/50 text-white hover:bg-white hover:text-[#0678A8] text-sm font-medium py-2.5 px-6 rounded-full transition backdrop-blur-sm" data-cta-title="Оставить заявку на замену дисплея">
                            Подробнее →
                        </button>
                    </div>
                    <div class="relative z-10 w-[40%] h-full flex items-end justify-center hidden md:flex">
                        <img src="{{ asset('images/man.png') }}" alt="Мастер" class="max-h-[95%] max-w-full object-contain object-bottom drop-shadow-lg" />
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="flex justify-center items-center gap-3 mt-8">
        @php
            $slideCount = (isset($banners) && $banners->count() > 0) ? $banners->count() : 3;
        @endphp
        @for($i = 0; $i < $slideCount; $i++)
            <button type="button" class="slider-dot w-3 h-3 rounded-full {{ $i === 0 ? 'bg-[#0678A8] scale-125' : 'bg-gray-300 hover:bg-[#2AC0D5]' }} transition-all duration-300"></button>
        @endfor
    </div>
</section>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sliders = document.querySelectorAll('.banners-slider-wrapper');
            
            sliders.forEach(slider => {
                const track = slider.querySelector('.slider-track');
                if (!track) return;

                const originalItems = Array.from(track.querySelectorAll('.slider-item'));
                const container = slider.querySelector('.slider-container');
                const dots = slider.querySelectorAll('.slider-dot');
                const realCount = originalItems.length;

                if (realCount === 0) return;

                // Клонирование для бесконечности
                const cloneFirst = originalItems[0].cloneNode(true);
                const cloneLast = originalItems[realCount - 1].cloneNode(true);
                track.insertBefore(cloneLast, originalItems[0]);
                track.appendChild(cloneFirst);

                const allItems = track.querySelectorAll('.slider-item');
                let currentIndex = 1;
                let isAnimating = false;
                let interval;

                function updateSlider(animate = true) {
                    const transitionStyle = animate ? 'transform 0.5s ease-out' : 'none';
                    track.style.transition = transitionStyle;

                    const targetSlide = allItems[currentIndex];
                    const slideLeft = targetSlide.offsetLeft;
                    const centerOffset = (container.offsetWidth - targetSlide.offsetWidth) / 2;
                    const translateX = slideLeft - centerOffset;

                    track.style.transform = `translate3d(-${translateX}px, 0, 0)`;

                    allItems.forEach((item, index) => {
                        item.style.transition = animate ? 'transform 0.5s ease-out, opacity 0.5s ease-out' : 'none';
                        if (index === currentIndex) {
                            item.style.opacity = '1';
                            item.style.filter = 'none';
                        } else {
                            item.style.opacity = '0.4';
                            item.style.filter = 'blur(1px)';
                        }
                    });

                    let dotIndex = currentIndex - 1;
                    if (dotIndex < 0) dotIndex = realCount - 1;
                    if (dotIndex >= realCount) dotIndex = 0;

                    dots.forEach((dot, index) => {
                        if (index === dotIndex) {
                            dot.classList.remove('bg-gray-300');
                            dot.classList.add('bg-[#0678A8]', 'scale-125');
                        } else {
                            dot.classList.remove('bg-[#0678A8]', 'scale-125');
                            dot.classList.add('bg-gray-300');
                        }
                    });
                }

                function nextSlide() {
                    if (isAnimating) return;
                    isAnimating = true;
                    currentIndex++;
                    updateSlider(true);

                    setTimeout(() => {
                        if (currentIndex === allItems.length - 1) {
                            currentIndex = 1;
                            updateSlider(false);
                        }
                        isAnimating = false;
                    }, 500);
                }

                function goToSlide(realSlideIndex) {
                    if (isAnimating) return;
                    currentIndex = realSlideIndex + 1;
                    updateSlider(true);
                }

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => goToSlide(index));
                });

                function startTimer() {
                    interval = setInterval(nextSlide, 3500);
                }

                window.addEventListener('resize', () => updateSlider(false));

                setTimeout(() => {
                    updateSlider(false);
                    startTimer();
                }, 50);
            });
        });
    </script>
    @endpush
@endonce
