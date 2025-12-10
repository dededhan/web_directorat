@php
    $programsConfig = config('landing.pemeringkatan.programs');
@endphp

<section id="programs" class="py-12 sm:py-16 md:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                {{ $programsConfig['title'] }}
            </h2>
        </div>
        
        {{-- Programs Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            @foreach($programsConfig['items'] as $program)
                <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    {{-- Icon --}}
                    <div class="mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $program['icon'] }} text-5xl sm:text-6xl text-{{ $program['color'] }}-500"></i>
                    </div>
                    
                    {{-- Title --}}
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">
                        {{ $program['title'] }}
                    </h3>
                    
                    {{-- Description --}}
                    <p class="text-sm sm:text-base text-gray-600 mb-6 leading-relaxed">
                        {{ $program['description'] }}
                    </p>
                    
                    {{-- Link --}}
                    <a href="{{ $program['link'] }}"
                       class="inline-block bg-{{ $program['color'] }}-600 hover:bg-{{ $program['color'] }}-700 text-white px-6 py-2.5 sm:py-3 rounded-lg text-sm sm:text-base font-semibold transition-colors">
                        Pelajari Lebih Lanjut
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
