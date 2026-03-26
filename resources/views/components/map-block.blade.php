<div {{ $attributes->merge(['class' => 'w-full h-[300px] lg:h-[400px] rounded-2xl overflow-hidden shadow-lg relative']) }}>
    <iframe
        src="https://yandex.ru/map-widget/v1/?ll=60.641972%2C56.838727&mode=search&z=11&pt=60.592641,56.838908;pm2dbm~60.691303,56.838547;pm2dbm"
        width="100%"
        height="100%"
        frameborder="0"
        allowfullscreen="true"
        class="relative z-10 block"
    >
    </iframe>
    <div class="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center z-0">
        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
    </div>
</div>
