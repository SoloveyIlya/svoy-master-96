@props(['links' => []])

{{-- JSON-LD Structured Data для SEO --}}
@php
    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Главная',
            'item' => route('home')
        ]
    ];
    
    $position = 2;
    foreach ($links as $url => $title) {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $title,
            'item' => $url ?? request()->url()
        ];
        $position++;
    }
    
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems
    ];
@endphp

<script type="application/ld+json">{!! json_encode($jsonLd) !!}</script>

<div class="max-w-[87.5rem] mx-auto px-4 py-3">
    <nav class="flex text-sm overflow-visible hide-scrollbar" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-2 w-full">
            <li class="flex items-center h-5">
                <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-[#0678A8] transition-colors font-medium" itemscope itemtype="https://schema.org/Thing">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    <span itemprop="name">Главная</span>
                </a>
            </li>
            @foreach($links as $url => $title)
                <li class="flex items-center h-5">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 shrink-0 mx-1 md:mx-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        @if($loop->last || !$url)
                            <span class="text-[#0678A8] font-semibold" aria-current="page" itemprop="name">{{ $title }}</span>
                        @else
                            <a href="{{ $url }}" class="text-gray-600 hover:text-[#0678A8] transition-colors" itemprop="url" itemscope itemtype="https://schema.org/Thing">
                                <span itemprop="name">{{ $title }}</span>
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
</div>

