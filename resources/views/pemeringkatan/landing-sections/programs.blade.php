@php
    $programsConfig = config('landing.pemeringkatan.programs');
@endphp

<section id="programs" class="py-16 sm:py-20 md:py-28 bg-gradient-to-b from-white to-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12 sm:mb-16">
            <div class="inline-block mb-4">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider bg-blue-50 px-4 py-2 rounded-full">
                    Our Programs
                </span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4 sm:mb-6">
                {{ $programsConfig['title'] }}
            </h2>
        </div>
        
        {{-- Tabbed Content with Image --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 rounded-2xl overflow-hidden shadow-2xl bg-white" x-data="{ activeTab: 0 }">
            {{-- Left Side: Background Image --}}
            <div class="relative h-64 lg:h-auto min-h-[400px] lg:min-h-[600px] overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
                </div>
                
                {{-- Decorative Elements --}}
                <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-10 left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                
                {{-- Content Overlay --}}
                <div class="relative h-full flex items-center justify-center p-8 sm:p-12">
                    <div class="text-center text-white">
                        <div class="mb-6">
                            <i class="fas fa-graduation-cap text-7xl sm:text-8xl opacity-90"></i>
                        </div>
                        <h3 class="text-3xl sm:text-4xl font-bold mb-4">Excellence in Ranking</h3>
                        <p class="text-lg sm:text-xl text-blue-100 max-w-md mx-auto">
                            Discover our comprehensive programs designed to elevate university rankings
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Right Side: Tabs --}}
            <div class="bg-white p-8 sm:p-10 lg:p-12 flex flex-col">
                {{-- Tab Navigation --}}
                <div class="flex flex-col space-y-3 mb-8">
                    @foreach($programsConfig['items'] as $index => $program)
                        <button 
                            @click="activeTab = {{ $index }}"
                            :class="activeTab === {{ $index }} 
                                ? 'bg-blue-600 text-white shadow-lg scale-105' 
                                : 'bg-white text-gray-700 hover:bg-blue-50 border border-gray-200'"
                            class="group relative text-left px-6 py-5 rounded-xl font-semibold text-lg transition-all duration-300 transform">
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <i class="{{ $program['icon'] }} text-2xl" 
                                       :class="activeTab === {{ $index }} ? 'text-white' : 'text-{{ $program['color'] }}-500'"></i>
                                    <span>{{ $program['title'] }}</span>
                                </div>
                                <i class="fas fa-chevron-right transition-transform duration-300"
                                   :class="activeTab === {{ $index }} ? 'rotate-90 text-white' : 'text-gray-400'"></i>
                            </div>
                        </button>
                    @endforeach
                </div>
                
                {{-- Tab Content --}}
                <div class="flex-1 relative">
                    @foreach($programsConfig['items'] as $index => $program)
                        <div 
                            x-show="activeTab === {{ $index }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="space-y-6"
                            style="display: none;">
                            
                            {{-- Content Header --}}
                            <div class="flex items-start gap-4 pb-6 border-b border-gray-200">
                                <div class="flex-shrink-0 w-12 h-12 bg-{{ $program['color'] }}-100 rounded-lg flex items-center justify-center">
                                    <i class="{{ $program['icon'] }} text-2xl text-{{ $program['color'] }}-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $program['title'] }}</h4>
                                    <p class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Program Overview</p>
                                </div>
                            </div>
                            
                            {{-- Description --}}
                            <div class="prose prose-lg max-w-none">
                                <p class="text-gray-600 leading-relaxed text-base sm:text-lg">
                                    {{ $program['description'] }}
                                </p>
                            </div>
                            
                            {{-- Action Button --}}
                            <div class="pt-4">
                                <a href="{{ $program['link'] }}"
                                   class="group inline-flex items-center gap-3 bg-gradient-to-r from-{{ $program['color'] }}-600 to-{{ $program['color'] }}-700 hover:from-{{ $program['color'] }}-700 hover:to-{{ $program['color'] }}-800 text-white px-6 py-3.5 rounded-xl text-base font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
                                    <span>Learn More</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Initialize Alpine.js if not already loaded
if (typeof Alpine === 'undefined') {
    document.addEventListener('alpine:init', () => {
        // Alpine will auto-initialize the x-data
    });
}
</script>
