@extends('layouts.pemeringkatan')

@section('title', 'Global Engagement Program')

@push('styles')
    <style>
        .program-card {
            transition: all 0.3s ease;
        }
        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .hero-section {
            background: linear-gradient(135deg, #176369 0%, #277177 100%);
        }
    </style>
@endpush

@section('content')
    <main class="min-h-screen relative z-0">
        <!-- Hero Section -->
        <section class="hero-section py-24 text-white">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Global Engagement Program</h1>
                <p class="text-xl opacity-90 mb-8 max-w-3xl mx-auto">
                    Fostering international collaboration and building bridges across cultures through education and research
                </p>
            </div>
        </section>

        <!-- Introduction Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto">
                    <div class="border-l-4 border-yellow-400 pl-6 mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">About Global Engagement</h2>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Our Global Engagement Program is designed to strengthen international partnerships, 
                            enhance academic collaboration, and provide students and faculty with opportunities 
                            to engage with the global academic community.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Programs Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Key Programs</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Explore our diverse range of international programs and initiatives
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Program Card 1 -->
                    <div class="program-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center">
                            <i class="fas fa-globe text-white text-6xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">International Partnerships</h3>
                            <p class="text-gray-600">
                                Building strategic partnerships with universities and institutions worldwide 
                                to enhance academic collaboration and research opportunities.
                            </p>
                        </div>
                    </div>

                    <!-- Program Card 2 -->
                    <div class="program-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <i class="fas fa-users text-white text-6xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Student Exchange Programs</h3>
                            <p class="text-gray-600">
                                Facilitating student mobility and cultural exchange through semester-long 
                                and short-term exchange programs with partner institutions.
                            </p>
                        </div>
                    </div>

                    <!-- Program Card 3 -->
                    <div class="program-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-white text-6xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Faculty Development</h3>
                            <p class="text-gray-600">
                                Supporting faculty members in international research collaborations, 
                                conferences, and professional development opportunities.
                            </p>
                        </div>
                    </div>

                    <!-- Program Card 4 -->
                    <div class="program-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                            <i class="fas fa-microscope text-white text-6xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Joint Research Initiatives</h3>
                            <p class="text-gray-600">
                                Promoting collaborative research projects addressing global challenges 
                                through interdisciplinary and cross-border cooperation.
                            </p>
                        </div>
                    </div>

                    <!-- Program Card 5 -->
                    <div class="program-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-6xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">International Conferences</h3>
                            <p class="text-gray-600">
                                Hosting and participating in international conferences and symposia 
                                to share knowledge and foster academic discourse.
                            </p>
                        </div>
                    </div>

                    <!-- Program Card 6 -->
                    <div class="program-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                            <i class="fas fa-award text-white text-6xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Cultural Exchange</h3>
                            <p class="text-gray-600">
                                Organizing cultural programs and activities to promote mutual understanding 
                                and appreciation of diverse cultures and perspectives.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8">Global Impact</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <div class="text-5xl font-bold text-teal-600 mb-2">50+</div>
                            <div class="text-gray-600">Partner Universities</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold text-teal-600 mb-2">30+</div>
                            <div class="text-gray-600">Countries</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold text-teal-600 mb-2">200+</div>
                            <div class="text-gray-600">Annual Exchange Students</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 bg-gradient-to-r from-teal-600 to-teal-700 text-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-4">Join Our Global Network</h2>
                <p class="text-xl opacity-90 mb-8 max-w-2xl mx-auto">
                    Interested in collaborating with us or learning more about our programs?
                </p>
                <a href="{{ route('pemeringkatan.landing') }}" class="inline-block bg-yellow-400 text-gray-900 font-bold px-8 py-3 rounded-lg hover:bg-yellow-300 transition-colors">
                    Get in Touch
                </a>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
@endpush
