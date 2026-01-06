@php
    $rankingsConfig = config('landing.pemeringkatan.featured_rankings');
@endphp

<section id="featured-rankings" class="py-16 sm:py-20 md:py-28 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12 sm:mb-16">
            <div class="inline-block mb-4">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider bg-blue-50 px-4 py-2 rounded-full">
                    University Rankings
                </span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4 sm:mb-6">
                {{ $rankingsConfig['title'] }}
            </h2>
            <p class="text-lg sm:text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto font-light">
                {{ $rankingsConfig['subtitle'] }}
            </p>
        </div>
        
        {{-- Rankings Grid --}}
        @if(isset($featuredRankings) && $featuredRankings->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">
                @foreach($featuredRankings as $ranking)
                    <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 border border-gray-100">
                        {{-- Hover Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        
                        {{-- Ranking Image --}}
                        @if($ranking->gambar)
                            <div class="relative h-48 sm:h-56 bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center p-6 sm:p-8 overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ asset('storage/' . $ranking->gambar) }}" 
                                     alt="{{ $ranking->judul }}"
                                     class="relative max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-700">
                            </div>
                        @else
                            <div class="h-48 sm:h-56 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors duration-500"></div>
                                <i class="fas fa-trophy text-white text-6xl sm:text-7xl relative z-10 group-hover:rotate-12 group-hover:scale-110 transition-all duration-500"></i>
                            </div>
                        @endif
                        
                        {{-- Ranking Info --}}
                        <div class="relative p-6 sm:p-7">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-blue-700 transition-colors duration-300">
                                {{ $ranking->judul }}
                            </h3>
                            
                            @if($ranking->score_ranking)
                                <div class="mb-6 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-sm font-medium text-gray-600">Score</span>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl sm:text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                                {{ $ranking->score_ranking }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <a href="{{ route('pemeringkatan.ranking-unj.show', $ranking->slug) }}"
                               class="group/btn relative block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3.5 rounded-xl text-base font-semibold shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    View Details
                                    <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- View All Button --}}
            <div class="text-center">
                <a href="{{ $rankingsConfig['cta_link'] }}"
                   class="group inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 sm:px-10 py-4 rounded-full text-lg font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <span>{{ $rankingsConfig['cta_text'] }}</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                <p class="text-gray-500 text-base sm:text-lg">Belum ada data pemeringkatan</p>
            </div>
        @endif
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
