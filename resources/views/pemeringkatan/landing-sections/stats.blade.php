@php
    $statsConfig = config('landing.pemeringkatan.stats');
@endphp

<section id="stats" class="py-12 sm:py-16 md:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                {{ $statsConfig['title'] }}
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $statsConfig['subtitle'] }}
            </p>
        </div>
        
        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8">
            @foreach($statsConfig['cards'] as $card)
                @php
                    $value = $stats[$card['key']] ?? 0;
                @endphp
                
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    {{-- Icon --}}
                    <div class="mb-4">
                        <i class="{{ $card['icon'] }} text-4xl sm:text-5xl text-{{ $card['color'] }}-500"></i>
                    </div>
                    
                    {{-- Number with Alpine.js Counter --}}
                    <div class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2" 
                         x-data="{ count: 0, target: {{ $value }} }"
                         x-init="() => {
                             let duration = 2000;
                             let steps = 60;
                             let increment = target / steps;
                             let stepDuration = duration / steps;
                             let currentCount = 0;
                             
                             let interval = setInterval(() => {
                                 currentCount += increment;
                                 if (currentCount >= target) {
                                     count = target;
                                     clearInterval(interval);
                                 } else {
                                     count = Math.floor(currentCount);
                                 }
                             }, stepDuration);
                         }">
                        <span x-text="count"></span>
                    </div>
                    
                    {{-- Label --}}
                    <div class="text-xs sm:text-sm text-gray-600 font-medium">
                        {{ $card['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
