@php
    $ctaConfig = config('landing.pemeringkatan.cta');
@endphp

<section class="py-16 sm:py-20 bg-gradient-to-br from-blue-600 to-blue-800 relative overflow-hidden">
    {{-- Decorative Background --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-white rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        {{-- Title --}}
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4 sm:mb-6">
            {{ $ctaConfig['title'] }}
        </h2>
        
        {{-- Subtitle --}}
        <p class="text-base sm:text-lg md:text-xl text-blue-100 mb-6 sm:mb-8">
            {{ $ctaConfig['subtitle'] }}
        </p>
        
        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @foreach($ctaConfig['buttons'] as $button)
                @if($button['style'] === 'primary')
                    <a href="{{ $button['link'] }}"
                       class="inline-block bg-white text-blue-600 px-6 sm:px-8 py-2.5 sm:py-3 rounded-full text-base sm:text-lg font-semibold hover:bg-blue-50 transition-all hover:shadow-lg hover:-translate-y-1">
                        <i class="{{ $button['icon'] }} mr-2"></i>
                        {{ $button['text'] }}
                    </a>
                @else
                    <a href="{{ $button['link'] }}"
                       class="inline-block bg-transparent border-2 border-white text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full text-base sm:text-lg font-semibold hover:bg-white hover:text-blue-600 transition-all hover:-translate-y-1">
                        <i class="{{ $button['icon'] }} mr-2"></i>
                        {{ $button['text'] }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
