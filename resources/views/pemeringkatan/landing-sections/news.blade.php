@php
    $newsConfig = config('landing.pemeringkatan.news');
@endphp

<section id="news" class="py-16 sm:py-20 md:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12 sm:mb-16">
            <div class="inline-block mb-4">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider bg-blue-50 px-4 py-2 rounded-full">
                    Latest Updates
                </span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4 sm:mb-6">
                {{ $newsConfig['title'] }}
            </h2>
            <p class="text-lg sm:text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto font-light">
                {{ $newsConfig['subtitle'] }}
            </p>
        </div>
        
        {{-- News Grid --}}
        @if(isset($regularNews) && $regularNews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">
                @foreach($regularNews as $item)
                    <article class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 border border-gray-100">
                        {{-- News Image with Overlay --}}
                        @if($item->gambar)
                            <div class="relative h-52 sm:h-60 overflow-hidden bg-slate-900">
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="{{ $item->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90">
                                {{-- Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                
                                {{-- Date Badge --}}
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-2 rounded-lg shadow-lg">
                                    <div class="text-xs font-semibold text-blue-600 uppercase tracking-wide">
                                        {{ $item->created_at->format('M') }}
                                    </div>
                                    <div class="text-2xl font-black text-gray-900 leading-none">
                                        {{ $item->created_at->format('d') }}
                                    </div>
                                    <div class="text-xs text-gray-600 leading-none mt-0.5">
                                        {{ $item->created_at->format('Y') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="relative h-52 sm:h-60 bg-gradient-to-br from-slate-100 via-blue-50 to-slate-100 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgb(59 130 246) 1px, transparent 0); background-size: 32px 32px;"></div>
                                </div>
                                <i class="fas fa-newspaper text-gray-300 text-6xl relative z-10"></i>
                            </div>
                        @endif
                        
                        {{-- News Content --}}
                        <div class="relative p-6 sm:p-7">
                            {{-- Title --}}
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-700 transition-colors duration-300">
                                {{ $item->judul }}
                            </h3>
                            
                            {{-- Excerpt --}}
                            <p class="text-base sm:text-lg text-gray-600 mb-5 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($item->konten), 140) }}
                            </p>
                            
                            {{-- Read More Link --}}
                            <a href="{{ route('Berita.show', $item->slug) }}"
                               class="group/link inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-base font-semibold">
                                Read More
                                <i class="fas fa-arrow-right text-sm group-hover/link:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            
            {{-- View All Button --}}
            <div class="text-center">
                <a href="{{ $newsConfig['cta_link'] }}"
                   class="group inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 sm:px-10 py-4 rounded-full text-lg font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <span>{{ $newsConfig['cta_text'] }}</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
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
