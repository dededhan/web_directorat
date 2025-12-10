@php
    $hero = config('landing.pemeringkatan.hero');
@endphp

<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900"></div>
    
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute -top-1/2 -right-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    
    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        {{-- Logo --}}
        <div class="mb-8 flex justify-center animate-fade-in">
            <img src="{{ asset($hero['logo_path']) }}" 
                 alt="UNJ Logo" 
                 class="h-24 sm:h-32 md:h-40 w-auto drop-shadow-2xl">
        </div>
        
        {{-- Headline --}}
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white mb-6 leading-tight animate-slide-up">
            {{ $hero['title'] }}
        </h1>
        
        {{-- Subtitle --}}
        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-blue-100 mb-10 max-w-4xl mx-auto leading-relaxed animate-slide-up animation-delay-200">
            {{ $hero['subtitle'] }}
        </p>
        
        {{-- CTA Button --}}
        <a href="{{ $hero['cta_link'] }}"
           class="inline-block bg-white text-blue-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full text-base sm:text-lg font-semibold hover:bg-blue-50 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 animate-slide-up animation-delay-400">
            <i class="fas fa-chart-line mr-2"></i>
            {{ $hero['cta_text'] }}
        </a>
    </div>
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce cursor-pointer z-20"
         onclick="document.getElementById('stats').scrollIntoView({ behavior: 'smooth' })">
        <i class="fas fa-chevron-down text-white text-2xl sm:text-3xl opacity-75 hover:opacity-100 transition-opacity"></i>
    </div>
</section>

<style>
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out;
}

.animate-slide-up {
    animation: slide-up 1s ease-out;
}

.animation-delay-200 {
    animation-delay: 0.2s;
    opacity: 0;
    animation-fill-mode: forwards;
}

.animation-delay-400 {
    animation-delay: 0.4s;
    opacity: 0;
    animation-fill-mode: forwards;
}
</style>
