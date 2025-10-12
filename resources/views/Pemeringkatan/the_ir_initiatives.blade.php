<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE Impact Rankings Initiatives - UNJ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .fas, .far, .fab, .fa {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900;
            -webkit-font-smoothing: antialiased;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        .fab {
            font-family: "Font Awesome 6 Brands" !important;
            font-weight: 400;
        }
        .far {
            font-weight: 400;
        }
    </style>
</head>
<body class="overflow-x-hidden">
    @include('layout.navbarpemeringkatan')

    <main class="relative z-0">
        <!-- Hero Section - Full Screen -->
        <section class="relative min-h-screen flex items-center justify-center bg-cover bg-center overflow-hidden" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920');">
            <!-- Animated Background Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/95 via-indigo-800/90 to-cyan-600/95"></div>
            
            <!-- Decorative Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-yellow-400/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            </div>

            <div class="container mx-auto px-4 md:px-6 lg:px-8 text-center relative z-10 py-20">
                <div data-aos="fade-down" data-aos-duration="1000">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 mb-6 md:mb-8 px-5 md:px-7 py-2.5 md:py-3 bg-white/10 backdrop-blur-xl rounded-full border border-white/20 shadow-lg">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                        <span class="text-white font-bold tracking-widest text-xs md:text-sm uppercase">THE Impact Rankings</span>
                    </div>
                    
                    <!-- Main Title -->
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white mb-6 md:mb-8 leading-tight px-4">
                        <span data-aos="fade-right" data-aos-delay="200">Championing</span>
                        <br/>
                        <span data-aos="fade-left" data-aos-delay="400" class="bg-gradient-to-r from-yellow-300 via-orange-400 to-red-400 bg-clip-text text-transparent drop-shadow-lg">
                            Sustainable Development
                        </span>
                    </h1>
                    
                    <!-- Subtitle -->
                    <p data-aos="fade-up" data-aos-delay="600" class="text-base md:text-xl lg:text-2xl text-white/90 mb-10 md:mb-14 max-w-4xl mx-auto font-light leading-relaxed px-4">
                        Building a Better Future Through the 17 United Nations Sustainable Development Goals
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div data-aos="zoom-in" data-aos-delay="800" class="flex gap-4 md:gap-5 justify-center flex-wrap items-center">
                        <a href="#featured-sdgs" class="group bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-7 md:px-10 py-3.5 md:py-4 rounded-full font-bold shadow-2xl inline-flex items-center gap-3 transform hover:scale-105 hover:-translate-y-1 transition-all duration-300">
                            <span>Explore Initiatives</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#all-sdgs" class="group bg-white/10 hover:bg-white/20 text-white px-7 md:px-10 py-3.5 md:py-4 rounded-full font-bold backdrop-blur-xl border-2 border-white/30 hover:border-white/50 inline-flex items-center gap-3 transform hover:scale-105 hover:-translate-y-1 transition-all duration-300">
                            <i class="fas fa-globe text-lg"></i>
                            <span>All 17 Goals</span>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div data-aos="fade-up" data-aos-delay="1000" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-4xl mx-auto mt-16 md:mt-20">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 md:p-6 border border-white/20">
                            <div class="text-3xl md:text-4xl font-black text-yellow-400 mb-2">17</div>
                            <div class="text-xs md:text-sm text-white/80 font-semibold uppercase tracking-wide">Global Goals</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 md:p-6 border border-white/20">
                            <div class="text-3xl md:text-4xl font-black text-cyan-400 mb-2">3</div>
                            <div class="text-xs md:text-sm text-white/80 font-semibold uppercase tracking-wide">Top Initiatives</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 md:p-6 border border-white/20">
                            <div class="text-3xl md:text-4xl font-black text-green-400 mb-2">100+</div>
                            <div class="text-xs md:text-sm text-white/80 font-semibold uppercase tracking-wide">Programs</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 md:p-6 border border-white/20">
                            <div class="text-3xl md:text-4xl font-black text-orange-400 mb-2">∞</div>
                            <div class="text-xs md:text-sm text-white/80 font-semibold uppercase tracking-wide">Impact</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 md:bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div class="flex flex-col items-center gap-2">
                    <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">Scroll Down</span>
                    <i class="fas fa-chevron-down text-white/80 text-xl md:text-2xl"></i>
                </div>
            </div>
        </section>

        <!-- <section class="bg-white py-12">
            <div class="container mx-auto px-6">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Global Recognition: Our Standing in THE Impact Rankings 2024</h3>
                <p class="text-cyan-500 mb-8">Universitas Negeri Jakarta is recognized globally for its leadership in sustainability through the prestigious Times Higher Education Impact Rankings.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-yellow-500 text-4xl flex-shrink-0">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">1st rank in Indonesia</h4>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-yellow-500 text-4xl flex-shrink-0">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">3rd rank in South East Asia</h4>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-yellow-500 text-4xl flex-shrink-0">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">6th rank in Asia</h4>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-yellow-500 text-4xl flex-shrink-0">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">31st rank in the World</h4>
                        </div>
                    </div>
                </div>

                <div class="text-left">
                    <a href="https://www.timeshighereducation.com/impactrankings" target="_blank" class="inline-flex items-center border-2 border-gray-800 text-gray-800 px-6 py-2 rounded font-semibold hover:bg-gray-800 hover:text-white transition-colors duration-300">
                        View ranking <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section> -->

        <!-- Featured SDGs Section - Full Screen -->
        <section id="featured-sdgs" class="relative min-h-screen flex items-center bg-gradient-to-br from-gray-50 via-blue-50/30 to-cyan-50/30 py-16 md:py-20 overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 right-10 w-72 h-72 bg-blue-200/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 left-10 w-96 h-96 bg-cyan-200/20 rounded-full blur-3xl"></div>
            </div>

            <div class="container mx-auto px-4 md:px-6 lg:px-8 w-full relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16" data-aos="fade-up">
                    <div class="inline-flex items-center gap-3 mb-4 px-4 py-2 bg-blue-100 rounded-full">
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                        <span class="text-blue-700 font-bold text-xs md:text-sm uppercase tracking-wider">Top Initiatives</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-4 md:mb-6">
                        Leading the Way
                    </h2>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 rounded-full mx-auto mb-6"></div>
                    <p class="text-base md:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed px-4">
                        Discover our most impactful initiatives driving measurable progress across three critical Sustainable Development Goals
                    </p>
                </div>

                <!-- Featured Cards -->
                <div class="space-y-8 md:space-y-10 lg:space-y-12">
                    @foreach($featuredSdgs as $index => $featured)
                        @php
                            $borderColors = [
                                1 => 'border-l-red-500',
                                2 => 'border-l-yellow-500',
                                6 => 'border-l-cyan-500'
                            ];
                            $bgGradients = [
                                1 => 'from-red-50 to-white',
                                2 => 'from-yellow-50 to-white',
                                6 => 'from-cyan-50 to-white'
                            ];
                            $badgeColors = [
                                1 => 'bg-red-500',
                                2 => 'bg-yellow-500',
                                6 => 'bg-cyan-500'
                            ];
                            $textColors = [
                                1 => 'text-red-600 hover:text-red-700',
                                2 => 'text-yellow-700 hover:text-yellow-800',
                                6 => 'text-cyan-600 hover:text-cyan-700'
                            ];
                            $rootContent = $featured->rootContents->first();
                        @endphp
                        <div class="group relative bg-white rounded-2xl md:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden" 
                             data-aos="fade-up" 
                             data-aos-delay="{{ $index * 150 }}">
                            <!-- Colored Border & Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-r {{ $bgGradients[$featured->number] ?? 'from-gray-50 to-white' }} opacity-50 group-hover:opacity-70 transition-opacity"></div>
                            <div class="absolute top-0 left-0 w-2 md:w-3 h-full {{ $badgeColors[$featured->number] ?? 'bg-gray-500' }}"></div>
                            
                            <div class="relative flex flex-col md:flex-row gap-0 md:gap-6">
                                <!-- Image Section -->
                                <div class="relative overflow-hidden w-full md:w-80 lg:w-96 h-56 md:h-auto">
                                    <!-- SDG Badge -->
                                    <div class="absolute top-4 left-4 z-20 {{ $badgeColors[$featured->number] ?? 'bg-gray-500' }} text-white px-4 md:px-5 py-2 md:py-2.5 rounded-full font-black text-sm md:text-base shadow-2xl backdrop-blur-sm bg-opacity-95">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-globe text-xs md:text-sm"></i>
                                            SDG {{ $featured->number }}
                                        </span>
                                    </div>
                                    
                                    <!-- Rank Badge -->
                                    <div class="absolute top-4 right-4 z-20 bg-white/90 backdrop-blur-md text-gray-800 w-12 h-12 md:w-14 md:h-14 rounded-full font-black text-xl md:text-2xl shadow-lg flex items-center justify-center border-4 border-white">
                                        #{{ $index + 1 }}
                                    </div>
                                    
                                    <!-- Image with Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
                                    <img src="{{ asset('images/sdgs/sdg-' . str_pad($featured->number, 2, '0', STR_PAD_LEFT) . '.jpg') }}" 
                                         alt="SDG {{ $featured->number }} - {{ $featured->title }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                </div>
                                
                                <!-- Content Section -->
                                <div class="flex-1 p-6 md:p-8 lg:p-10 flex flex-col justify-between">
                                    <div>
                                        <!-- Category Tag -->
                                        <div class="flex items-center gap-2 mb-4">
                                            <div class="w-10 h-1 {{ $badgeColors[$featured->number] ?? 'bg-gray-500' }} rounded-full"></div>
                                            <span class="text-xs md:text-sm font-bold text-gray-500 uppercase tracking-widest">Featured Initiative</span>
                                        </div>
                                        
                                        <!-- Title -->
                                        <h3 class="text-xl md:text-2xl lg:text-3xl font-black text-gray-900 mb-4 leading-tight group-hover:text-blue-700 transition-colors">
                                            {{ $rootContent ? $rootContent->title : $featured->title }}
                                        </h3>
                                        
                                        <!-- Description -->
                                        <p class="text-sm md:text-base lg:text-lg text-gray-600 leading-relaxed mb-6 line-clamp-3 md:line-clamp-4">
                                            @if($rootContent && $rootContent->content_type === 'text')
                                                {{ Str::limit($rootContent->content, 280) }}
                                            @else
                                                {{ $featured->description ?? $featured->subtitle }}
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <!-- CTA Button -->
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('sdg.detail', $featured->number) }}" 
                                           class="group/link inline-flex items-center gap-3 {{ $textColors[$featured->number] ?? 'text-gray-600 hover:text-gray-800' }} font-bold text-sm md:text-base lg:text-lg">
                                            <span class="border-b-2 border-transparent group-hover/link:border-current transition-all">Explore Initiative</span>
                                            <i class="fas fa-arrow-right transform group-hover/link:translate-x-2 transition-transform"></i>
                                        </a>
                                        <div class="flex-1 h-px bg-gradient-to-r from-gray-300 to-transparent"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- All SDGs Section - Full Screen -->
        <section id="all-sdgs" class="relative min-h-screen flex items-center bg-gradient-to-br from-white via-indigo-50/30 to-purple-50/30 py-16 md:py-20 overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-32 left-20 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-32 right-20 w-80 h-80 bg-indigo-200/20 rounded-full blur-3xl"></div>
            </div>

            <div class="container mx-auto px-4 md:px-6 lg:px-8 w-full relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16" data-aos="fade-up">
                    <div class="inline-flex items-center gap-3 mb-4 px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full">
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                        <span class="bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent font-bold text-xs md:text-sm uppercase tracking-wider">Complete SDG Portfolio</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-4 md:mb-6">
                        All 17 Global Goals
                    </h2>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-blue-600 via-purple-500 to-pink-500 rounded-full mx-auto mb-6"></div>
                    <p class="text-base md:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed px-4">
                        Click on any goal to explore our comprehensive initiatives and discover how we're making a real impact
                    </p>
                </div>

                <!-- SDG Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-5 lg:gap-6 mb-12 md:mb-16">
                    @for($i = 1; $i <= 17; $i++)
                        <a href="{{ route('sdg.detail', $i) }}" 
                           class="group relative rounded-xl md:rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transform transition-all duration-500 hover:-translate-y-3 hover:scale-105"
                           data-aos="zoom-in"
                           data-aos-delay="{{ ($i - 1) * 30 }}">
                            <!-- SDG Image -->
                            <div class="relative aspect-square">
                                <img src="{{ asset('images/sdgs/sdg-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.jpg') }}" 
                                     alt="SDG {{ $i }}" 
                                     class="w-full h-full object-cover">
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4">
                                        <div class="bg-white/20 backdrop-blur-md rounded-full p-3 mb-2 transform scale-0 group-hover:scale-100 transition-transform duration-300 delay-100">
                                            <i class="fas fa-arrow-right text-white text-lg md:text-xl"></i>
                                        </div>
                                        <span class="text-white font-bold text-xs md:text-sm text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-150">Explore Goal {{ $i }}</span>
                                    </div>
                                </div>
                                
                                <!-- Number Badge -->
                                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm text-gray-900 w-8 h-8 md:w-10 md:h-10 rounded-full font-black text-sm md:text-base flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                    {{ $i }}
                                </div>
                            </div>
                        </a>
                    @endfor
                    
                    <!-- 17 Goals Summary Card -->
                    <div class="col-span-2 sm:col-span-1 flex items-center justify-center" data-aos="zoom-in" data-aos-delay="510">
                        <div class="w-full aspect-square bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-xl transform transition-all duration-500 hover:scale-105 hover:rotate-6 relative overflow-hidden group cursor-pointer">
                            <!-- Shine Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-white/0 via-white/30 to-white/0 transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            
                            <!-- Content -->
                            <div class="text-white text-center p-4 md:p-6 relative z-10">
                                <div class="text-4xl md:text-5xl lg:text-6xl font-black mb-2 transform group-hover:scale-110 transition-transform">17</div>
                                <div class="text-xs md:text-sm lg:text-base font-black uppercase tracking-widest">Goals</div>
                                <div class="text-xs mt-2 opacity-90 font-semibold">One Future</div>
                            </div>
                            
                            <!-- Animated Dots -->
                            <div class="absolute top-4 left-4 w-2 h-2 bg-white/40 rounded-full animate-ping"></div>
                            <div class="absolute bottom-4 right-4 w-2 h-2 bg-white/40 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                        </div>
                    </div>
                </div>

                <!-- Bottom CTA Card -->
                <div class="max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-3xl p-8 md:p-12 lg:p-16 shadow-2xl overflow-hidden">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10 text-center text-white">
                            <div class="inline-flex items-center gap-3 mb-6">
                                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-white/50 to-transparent rounded-full"></div>
                                <i class="fas fa-globe text-4xl md:text-5xl"></i>
                                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-white/50 to-transparent rounded-full"></div>
                            </div>
                            <h3 class="text-2xl md:text-3xl lg:text-4xl font-black mb-4 md:mb-6">Together We Achieve More</h3>
                            <p class="text-base md:text-lg lg:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed mb-8">
                                The 17 Sustainable Development Goals are our blueprint to achieve a better and more sustainable future for all. 
                                They address global challenges including poverty, inequality, climate change, environmental degradation, peace and justice.
                            </p>
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-white text-blue-700 px-8 py-4 rounded-full font-bold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                                <span>Learn More About UNJ</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 50
        });
    </script>
</body>
</html>
