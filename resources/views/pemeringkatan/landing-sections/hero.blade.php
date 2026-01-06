@php
    $hero = config('landing.pemeringkatan.hero');
@endphp

<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background with Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900"></div>
    
    {{-- Animated Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    {{-- Decorative Blurred Elements --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-slow"></div>
    </div>
    
    {{-- Main Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
        {{-- Logo with Glow Effect --}}
        <div class="mb-10 flex justify-center animate-fade-in-down">
            <div class="relative">
                <div class="absolute inset-0 bg-white rounded-full blur-xl opacity-30"></div>
                <img src="{{ asset($hero['logo_path']) }}" 
                     alt="UNJ Logo" 
                     class="relative h-28 sm:h-36 md:h-44 lg:h-48 w-auto drop-shadow-2xl">
            </div>
        </div>
        
        {{-- Main Headline with Gradient Text --}}
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight animate-fade-in-up">
            <span class="bg-gradient-to-r from-white via-blue-100 to-white bg-clip-text text-transparent">
                {{ $hero['title'] }}
            </span>
        </h1>
        
        {{-- Subtitle with Better Spacing --}}
        <p class="text-lg sm:text-xl md:text-2xl text-blue-50 mb-12 max-w-4xl mx-auto leading-relaxed font-light animate-fade-in-up animation-delay-200">
            {{ $hero['subtitle'] }}
        </p>
        
        {{-- CTA Button with Modern Design --}}
        <div class="animate-fade-in-up animation-delay-400">
            <a href="{{ $hero['cta_link'] }}"
               class="group inline-flex items-center gap-3 bg-white text-blue-700 px-8 py-4 rounded-full text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 hover:bg-blue-50">
                <i class="fas fa-chart-line group-hover:rotate-12 transition-transform duration-300"></i>
                <span>{{ $hero['cta_text'] }}</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>
    </div>
    
    {{-- Scroll Indicator with Pulse Effect --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 cursor-pointer animate-bounce-slow"
         onclick="document.getElementById('stats').scrollIntoView({ behavior: 'smooth' })">
        <div class="flex flex-col items-center gap-2 text-white/80 hover:text-white transition-colors group">
            <span class="text-sm font-medium uppercase tracking-wider">Scroll</span>
            <div class="relative">
                <div class="absolute inset-0 bg-white rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                <i class="relative fas fa-chevron-down text-2xl"></i>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -30px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

@keyframes float-delayed {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(-30px, 30px) scale(0.9);
    }
    66% {
        transform: translate(20px, -20px) scale(1.1);
    }
}

@keyframes pulse-slow {
    0%, 100% {
        opacity: 0.1;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.2;
        transform: translate(-50%, -50%) scale(1.1);
    }
}

@keyframes bounce-slow {
    0%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    50% {
        transform: translateX(-50%) translateY(-10px);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 1s ease-out;
}

.animate-fade-in-up {
    animation: fade-in-up 1s ease-out;
}

.animate-float {
    animation: float 20s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 25s ease-in-out infinite;
}

.animate-pulse-slow {
    animation: pulse-slow 8s ease-in-out infinite;
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
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
