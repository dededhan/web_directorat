<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE Impact Rankings Initiatives - UNJ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Fix Font Awesome icons - prevent Tailwind from overriding */
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
<body class="bg-gray-50">
    @include('layout.navbarpemeringkatan')

    <main class="min-h-screen relative z-0">
        <section class="relative bg-cover bg-center py-32" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920');">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Championing Sustainable Development</h2>
                <p class="text-xl text-white mb-8">Our Commitment to the Sustainability</p>
            </div>
        </section>

        <section class="bg-white py-12">
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
        </section>

        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Leading the Way: Top 3 SDG Initiatives</h3>
                <p class="text-cyan-500 text-lg mb-12">Explore our most impactful projects driving progress in the top three Sustainable Development Goals.</p>

                <div class="space-y-8">
                    @foreach($featuredSdgs as $featured)
                        @php
                            $borderColors = [
                                1 => 'border-red-200 bg-red-50',
                                2 => 'border-yellow-200 bg-yellow-50',
                                6 => 'border-cyan-200 bg-cyan-50'
                            ];
                            $textColors = [
                                1 => 'text-red-600 hover:text-red-800',
                                2 => 'text-yellow-700 hover:text-yellow-900',
                                6 => 'text-cyan-600 hover:text-cyan-800'
                            ];
                            $rootContent = $featured->rootContents->first();
                        @endphp
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/sdgs/sdg-' . str_pad($featured->number, 2, '0', STR_PAD_LEFT) . '.jpg') }}" 
                                     alt="SDG {{ $featured->number }} - {{ $featured->title }}" 
                                     class="w-48 h-48 object-cover">
                            </div>
                            <div class="flex-1 border-2 {{ $borderColors[$featured->number] ?? 'border-gray-200 bg-gray-50' }} p-6">
                                <h4 class="text-xl font-bold text-gray-800 mb-3">
                                    {{ $rootContent ? $rootContent->title : $featured->title }}
                                </h4>
                                <p class="text-gray-700 mb-4">
                                    @if($rootContent && $rootContent->content_type === 'text')
                                        {{ Str::limit($rootContent->content, 300) }}
                                    @else
                                        {{ $featured->description ?? $featured->subtitle }}
                                    @endif
                                </p>
                                <a href="{{ route('sdg.detail', $featured->number) }}" 
                                   class="{{ $textColors[$featured->number] ?? 'text-gray-600 hover:text-gray-800' }} font-semibold transition-colors">
                                    Read more
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Explore More about Our Initiatives in All SDGs</h3>
                <p class="text-cyan-500 text-lg mb-12">Select and click the SDGs to read our detailed initiatives</p>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <a href="{{ route('sdg.detail', 1) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-01.jpg') }}" alt="SDG 1 - No Poverty" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 2) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-02.jpg') }}" alt="SDG 2 - Zero Hunger" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 3) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-03.jpg') }}" alt="SDG 3 - Good Health and Well-Being" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 4) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-04.jpg') }}" alt="SDG 4 - Quality Education" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 5) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-05.jpg') }}" alt="SDG 5 - Gender Equality" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 6) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-06.jpg') }}" alt="SDG 6 - Clean Water and Sanitation" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 7) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-07.jpg') }}" alt="SDG 7 - Affordable and Clean Energy" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 8) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-08.jpg') }}" alt="SDG 8 - Decent Work and Economic Growth" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 9) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-09.jpg') }}" alt="SDG 9 - Industry, Innovation and Infrastructure" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 10) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-10.jpg') }}" alt="SDG 10 - Reduced Inequalities" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 11) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-11.jpg') }}" alt="SDG 11 - Sustainable Cities and Communities" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 12) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-12.jpg') }}" alt="SDG 12 - Responsible Consumption and Production" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 13) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-13.jpg') }}" alt="SDG 13 - Climate Action" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 14) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-14.jpg') }}" alt="SDG 14 - Life Below Water" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 15) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-15.jpg') }}" alt="SDG 15 - Life on Land" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 16) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-16.jpg') }}" alt="SDG 16 - Peace, Justice and Strong Institutions" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <a href="{{ route('sdg.detail', 17) }}" class="transform hover:scale-105 active:scale-95 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('images/sdgs/sdg-17.jpg') }}" alt="SDG 17 - Partnerships for the Goals" class="w-full shadow-md hover:shadow-xl rounded-lg">
                    </a>
                    <div class="flex items-center justify-center">
                        <div class="w-full max-w-[200px] mx-auto aspect-square bg-gradient-to-br from-blue-500 via-green-500 to-yellow-500 rounded-full flex items-center justify-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <div class="text-white text-center p-4">
                                <div class="text-4xl font-bold mb-2">17</div>
                                <div class="text-xs font-semibold">GOALS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
