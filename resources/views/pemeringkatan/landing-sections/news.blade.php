@php
    $newsConfig = config('landing.pemeringkatan.news');
@endphp

<section id="news" class="py-12 sm:py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                {{ $newsConfig['title'] }}
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $newsConfig['subtitle'] }}
            </p>
        </div>
        
        {{-- News Grid --}}
        @if(isset($regularNews) && $regularNews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-12">
                @foreach($regularNews as $item)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                        {{-- News Image --}}
                        @if($item->gambar)
                            <div class="h-40 sm:h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="{{ $item->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        @else
                            <div class="h-40 sm:h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <i class="fas fa-newspaper text-gray-400 text-4xl sm:text-5xl"></i>
                            </div>
                        @endif
                        
                        {{-- News Content --}}
                        <div class="p-4 sm:p-6">
                            {{-- Date --}}
                            <div class="text-xs sm:text-sm text-gray-500 mb-2 flex items-center">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $item->created_at->format('d F Y') }}
                            </div>
                            
                            {{-- Title --}}
                            <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                {{ $item->judul }}
                            </h3>
                            
                            {{-- Excerpt --}}
                            <p class="text-sm sm:text-base text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($item->konten), 120) }}
                            </p>
                            
                            {{-- Read More Link --}}
                            <a href="{{ route('Berita.show', $item->slug) }}"
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm sm:text-base font-medium">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- View All Button --}}
            <div class="text-center">
                <a href="{{ $newsConfig['cta_link'] }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full text-base sm:text-lg font-semibold transition-all hover:shadow-lg hover:-translate-y-1">
                    {{ $newsConfig['cta_text'] }}
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                <p class="text-gray-500 text-base sm:text-lg">Belum ada berita tersedia</p>
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

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
