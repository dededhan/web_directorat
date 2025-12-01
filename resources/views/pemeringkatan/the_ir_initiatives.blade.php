@extends('layouts.pemeringkatan')

@section('title', 'THE Impact Rankings Initiatives')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
@endpush

@section('content')
    <main class="min-h-screen relative z-0">
        <section class="relative bg-cover bg-center py-32" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920');">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Championing Sustainable Development</h2>
                <p class="text-xl text-white mb-8">Our Commitment to the Sustainability</p>
            </div>
        </section>

        <section class="bg-white py-12">
            <div class="container mx-auto px-6">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Global Recognition: Our Standing in THE Impact Rankings</h3>
                <p class="text-cyan-500 mb-8">Universitas Negeri Jakarta is recognized globally for its leadership in sustainability through the prestigious Times Higher Education Impact Rankings.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-yellow-500 text-4xl flex-shrink-0">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Recognition in Indonesia</h4>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-teal-500 text-4xl flex-shrink-0">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Global Impact</h4>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-green-500 text-4xl flex-shrink-0">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Sustainability Focus</h4>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-blue-500 text-4xl flex-shrink-0">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Continuous Growth</h4>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h4 class="text-xl font-bold text-gray-800 mb-4">Our THE Impact Rankings Journey</h4>
                    <p class="text-gray-600 mb-4">
                        Universitas Negeri Jakarta (UNJ) has consistently demonstrated its commitment to the United Nations' 
                        Sustainable Development Goals (SDGs) through various initiatives and programs. Our participation in 
                        THE Impact Rankings showcases our dedication to making a positive impact on society and the environment.
                    </p>
                    <p class="text-gray-600">
                        Through innovative research, community engagement, and sustainable campus practices, we continue to 
                        advance our mission of contributing to global sustainability challenges while maintaining academic excellence.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white py-12">
            <div class="container mx-auto px-6">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Our SDG Initiatives</h3>
                <p class="text-gray-600 text-center mb-12 max-w-3xl mx-auto">
                    Explore our comprehensive initiatives aligned with the United Nations Sustainable Development Goals
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for($i = 1; $i <= 17; $i++)
                        <a href="{{ route('pemeringkatan.the-ir.sdg.show', $i) }}" 
                           class="block bg-white border-2 border-gray-200 rounded-lg p-6 hover:border-teal-500 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-2xl font-bold text-teal-600">{{ $i }}</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">SDG {{ $i }}</h4>
                                    <p class="text-sm text-gray-500">View Initiatives</p>
                                </div>
                            </div>
                        </a>
                    @endfor
                </div>
            </div>
        </section>

        <section class="bg-gradient-to-r from-teal-600 to-teal-700 py-16 text-white">
            <div class="container mx-auto px-6 text-center">
                <h3 class="text-3xl font-bold mb-4">Join Our Sustainability Journey</h3>
                <p class="text-xl opacity-90 mb-8 max-w-2xl mx-auto">
                    Together, we can create a more sustainable and equitable future for all
                </p>
                <a href="{{ route('pemeringkatan.landing') }}" 
                   class="inline-block bg-yellow-400 text-gray-900 font-bold px-8 py-3 rounded-lg hover:bg-yellow-300 transition-colors">
                    Learn More
                </a>
            </div>
        </section>
    </main>
@endsection
