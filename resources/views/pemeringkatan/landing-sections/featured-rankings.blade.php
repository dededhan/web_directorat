@php
    $rankingsConfig = config('landing.pemeringkatan.featured_rankings');
@endphp

<section id="featured-rankings" class="py-12 sm:py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                {{ $rankingsConfig['title'] }}
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $rankingsConfig['subtitle'] }}
            </p>
        </div>
        
        {{-- Rankings Grid --}}
        @if(isset($featuredRankings) && $featuredRankings->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-12">
                @foreach($featuredRankings as $ranking)
                    <div class="bg-gray-50 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                        {{-- Ranking Image --}}
                        @if($ranking->gambar)
                            <div class="h-40 sm:h-48 bg-white flex items-center justify-center p-4 sm:p-6">
                                <img src="{{ asset('storage/' . $ranking->gambar) }}" 
                                     alt="{{ $ranking->judul }}"
                                     class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="h-40 sm:h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                <i class="fas fa-trophy text-white text-5xl sm:text-6xl"></i>
                            </div>
                        @endif
                        
                        {{-- Ranking Info --}}
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ $ranking->judul }}
                            </h3>
                            
                            <div class="space-y-2 mb-4">
                                @if($ranking->score_ranking)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Skor:</span>
                                        <span class="text-xl sm:text-2xl font-bold text-blue-600">
                                            {{ $ranking->score_ranking }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('pemeringkatan.ranking-unj.show', $ranking->slug) }}"
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 sm:py-2.5 rounded-lg text-sm sm:text-base font-medium transition-colors">
                                Lihat Detail
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- View All Button --}}
            <div class="text-center">
                <a href="{{ $rankingsConfig['cta_link'] }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full text-base sm:text-lg font-semibold transition-all hover:shadow-lg hover:-translate-y-1">
                    {{ $rankingsConfig['cta_text'] }}
                    <i class="fas fa-arrow-right ml-2"></i>
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
