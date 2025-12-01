@extends('layouts.pemeringkatan')

@section('title', 'Sulitest UNJ - Mainstreaming Sustainability Literacy')

@section('meta_description', 'UNJ Sustain Quest provides internationally recognized online tools to measure, improve and certify sustainability knowledge.')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/pemeringkatan/sulitest.css')
@endpush

@section('content')
    <main>
        <!-- HERO -->
        <section class="relative bg-white pt-32 pb-20 overflow-hidden">
            <div class="decorative-shape absolute top-10 right-32 w-8 h-8 bg-yellow-400"></div>
            <div class="decorative-shape absolute top-24 right-20 w-6 h-6 bg-yellow-400 opacity-70"></div>
            <div class="decorative-shape absolute top-16 right-40 w-4 h-4 bg-yellow-400 opacity-50"></div>
            <div class="decorative-shape absolute top-40 right-16 w-10 h-10 bg-yellow-400 opacity-40"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center max-w-7xl mx-auto">
                    <!-- Left -->
                    <div>
                        <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900 mb-6">
                            Mainstreaming<br>sustainability<br>literacy!
                        </h1>
                        <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                            We provide internationally recognized online tools to <strong>measure, improve and certify
                                sustainability knowledge</strong>
                        </p>
                        <a href="{{ route('sulitest.login') }}"
                            class="inline-block bg-gray-800 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-gray-700 transition-all">
                            Schedule a demo
                        </a>
                    </div>

                    <!-- Right-->
                    <div class="relative">
                        <div class="space-y-4">

                            <a href="{{ route('sulitest.login') }}"
                                class="card-hover flex items-center gap-4 bg-blue-50 border-2 border-blue-100 rounded-xl p-6 hover:border-blue-300">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">A professor or a university</h3>
                                </div>
                            </a>

                            <a href="{{ route('sulitest.login') }}"
                                class="card-hover flex items-center gap-4 bg-orange-50 border-2 border-orange-100 rounded-xl p-6 hover:border-orange-300">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">A company or an organization</h3>
                                </div>
                            </a>

                            <a href="{{ route('sulitest.login') }}"
                                class="card-hover flex items-center gap-4 bg-stone-100 border-2 border-stone-200 rounded-xl p-6 hover:border-stone-400">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">A student or a professional</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- GLOBAL CHALLENGE -->
        <section id="about" class="py-20 bg-stone-50 relative overflow-hidden">
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 opacity-5">
                <svg width="300" height="400" viewBox="0 0 300 400">
                    <path d="M 50,200 Q 100,150 150,200 T 250,200" stroke="#d4d4d8" stroke-width="2" fill="none" />
                </svg>
            </div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="grid md:grid-cols-2 gap-16 items-center max-w-6xl mx-auto">
                    <div class="flex justify-center">
                        <div class="relative">
                            <div
                                class="w-72 h-96 bg-gray-800 rounded-3xl flex flex-col items-center justify-center p-8 shadow-xl">
                                <div class="decorative-shape w-6 h-6 bg-yellow-400 absolute top-8 left-8"></div>
                                <div class="decorative-shape w-4 h-4 bg-yellow-400 absolute top-12 left-16 opacity-70">
                                </div>
                                <div class="decorative-shape w-3 h-3 bg-yellow-400 absolute top-16 left-12 opacity-50">
                                </div>
                                <div class="mb-4">
                                    <svg class="w-32 h-32 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z">
                                        </path>
                                        <path
                                            d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">A global challenge</h2>
                        <div class="bg-orange-50 rounded-2xl p-6 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                The environmental and social challenges of our era demand that every student, educator,
                                and professional understands sustainability issues and takes part in solving them.
                            </p>
                        </div>
                        <p class="text-gray-900 font-semibold leading-relaxed">
                            Building a sustainable future demands enhancing knowledge, skills, and mindsets around
                            sustainability.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Combine -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-16 items-start max-w-7xl mx-auto">
                    <!-- Left: Our Mission -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="decorative-shape w-6 h-6 bg-yellow-400"></div>
                            <div class="decorative-shape w-3 h-3 bg-yellow-400 opacity-60"></div>
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Our Mission</h2>
                        <div class="bg-orange-50 rounded-2xl p-6">
                            <p class="text-gray-800 leading-relaxed">
                                To integrate sustainability knowledge, values, and practices into education, research, and community engagement—preparing UNJ graduates to become future-ready leaders who contribute to Indonesia's sustainable development goals.
                            </p>
                        </div>
                    </div>

                    <!-- Right: Our Solution -->
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Our Solution</h3>
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div class="card-hover p-6 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                                <div
                                    class="h-14 w-14 bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                                    <i class="fas fa-globe text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-2">Measure</h4>
                                <p class="text-gray-600 leading-relaxed">Sustainability knowledge and awareness among students and staff.</p>
                            </div>
                            <div class="card-hover p-6 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                                <div
                                    class="h-14 w-14 bg-gradient-to-br from-amber-400 to-amber-500 text-white rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                                    <i class="fas fa-chart-pie text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-2">Improve</h4>
                                <p class="text-gray-600 leading-relaxed">Sustainability literacy through tailored learning modules and workshops.</p>
                            </div>
                            <div class="card-hover p-6 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                                <div
                                    class="h-14 w-14 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                                    <i class="fas fa-user-check text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-2">Report</h4>
                                <p class="text-gray-600 leading-relaxed">Progress in alignment with UI GreenMetric and THE Impact Rankings indicators.</p>
                            </div>
                            <div class="card-hover p-6 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                                <div
                                    class="h-14 w-14 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                                    <i class="fas fa-file-export text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-2">Certify</h4>
                                <p class="text-gray-600 leading-relaxed">Sustainability competence to support graduates' employability and green job readiness.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Matters -->
        <section id="why-matters" class="py-20 bg-stone-50 overflow-hidden">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <div class="flex justify-center mb-6">
                        <div class="decorative-shape w-6 h-6 bg-yellow-400"></div>
                        <div class="decorative-shape w-4 h-4 bg-yellow-400 opacity-70 ml-2"></div>
                        <div class="decorative-shape w-3 h-3 bg-yellow-400 opacity-50 ml-1"></div>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Why UNJ Sustain Quest Matters</h2>
                </div>

                <div class="relative max-w-7xl mx-auto">
                    <div id="scroll-container"
                        class="flex gap-8 overflow-x-auto pb-8 snap-x snap-mandatory scroll-smooth"
                        style="scrollbar-width: none; -ms-overflow-style: none;">

                        <style>
                            #scroll-container::-webkit-scrollbar {
                                display: none;
                            }
                        </style>

                        <div
                            class="snap-start flex-shrink-0 w-80 bg-gray-800 text-white rounded-2xl p-8 flex flex-col justify-between shadow-lg">
                            <div>
                                <h3 class="font-bold text-2xl mb-3">Why It Matters</h3>
                            </div>
                            <div class="text-right">
                                <i class="fas fa-info-circle text-2xl opacity-50"></i>
                            </div>
                        </div>

                        <!-- Card 1-->
                        <div
                            class="group snap-start flex-shrink-0 w-80 card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm flex flex-col justify-between min-h-[280px]">
                            <div>
                                <h3 class="font-bold text-xl text-gray-900 mb-3">Change Leader</h3>
                                <div class="w-10 h-0.5 bg-teal-500 mb-4"></div>
                                <p class="text-gray-600 leading-relaxed">Empowers UNJ as a Change Leader in
                                    sustainability education in Indonesia.</p>
                            </div>
                            <div class="text-right mt-4">
                                <i
                                    class="fas fa-arrow-right text-gray-400 group-hover:text-teal-500 transition-colors"></i>
                            </div>
                        </div>

                        <!-- Card 2-->
                        <div
                            class="group snap-start flex-shrink-0 w-80 card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm flex flex-col justify-between min-h-[280px]">
                            <div>
                                <h3 class="font-bold text-xl text-gray-900 mb-3">SDG-Based Curricula</h3>
                                <div class="w-10 h-0.5 bg-amber-500 mb-4"></div>
                                <p class="text-gray-600 leading-relaxed">Supports the implementation of SDG-based
                                    curricula.</p>
                            </div>
                            <div class="text-right mt-4">
                                <i
                                    class="fas fa-arrow-right text-gray-400 group-hover:text-amber-500 transition-colors"></i>
                            </div>
                        </div>

                        <!-- Card 3-->
                        <div
                            class="group snap-start flex-shrink-0 w-80 card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm flex flex-col justify-between min-h-[280px]">
                            <div>
                                <h3 class="font-bold text-xl text-gray-900 mb-3">Interdisciplinary Collaboration</h3>
                                <div class="w-10 h-0.5 bg-blue-500 mb-4"></div>
                                <p class="text-gray-600 leading-relaxed">Encourages interdisciplinary collaboration on
                                    sustainability research and community projects.</p>
                            </div>
                            <div class="text-right mt-4">
                                <i
                                    class="fas fa-arrow-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                            </div>
                        </div>

                        <!-- Card 4-->
                        <div
                            class="group snap-start flex-shrink-0 w-80 card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm flex flex-col justify-between min-h-[280px]">
                            <div>
                                <h3 class="font-bold text-xl text-gray-900 mb-3">Evidence for Rankings</h3>
                                <div class="w-10 h-0.5 bg-purple-500 mb-4"></div>
                                <p class="text-gray-600 leading-relaxed">Contributes evidence for national and
                                    international university rankings related to sustainability impact.</p>
                            </div>
                            <div class="text-right mt-4">
                                <i
                                    class="fas fa-arrow-right text-gray-400 group-hover:text-purple-500 transition-colors"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4 mt-8">
                        <button id="scroll-left-btn"
                            class="w-12 h-12 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition-all shadow-md">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <button id="scroll-right-btn"
                            class="w-12 h-12 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition-all shadow-md">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Community -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-16 items-center max-w-7xl mx-auto">
                    <div class="relative">
                        <div class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white p-8 md:p-10 shadow-sm">
                            <div class="pointer-events-none absolute -top-16 -right-16 h-48 w-48 rounded-full bg-yellow-300/30 blur-2xl"></div>
                            <div class="pointer-events-none absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-teal-300/20 blur-2xl"></div>

                            <div class="relative z-10 flex flex-col gap-4">
                                <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Join the Movement!</h3>
                                <p class="text-gray-700">Let's strengthen UNJ's sustainability culture together.</p>
                                <p class="text-gray-700">Explore the modules, take the UNJ Sustain Quest Assessment, and be part of a campus that leads by example.</p>

                                <div class="pt-2">
                                    <div class="inline-flex items-center gap-3 rounded-full bg-stone-100 px-4 py-2 text-gray-800">
                                        <span class="text-xl">📩</span>
                                        <a href="mailto:dir.inovasi@unj.ac.id" class="font-medium hover:underline">dir.inovasi@unj.ac.id</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right -->
                    <div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Our Community</h2>
                        <p class="text-gray-700 leading-relaxed mb-6">UNJ Sustain Quest brings together:</p>

                        <ul class="space-y-4">
                            <li class="flex gap-3">
                                <span class="mt-2 h-2.5 w-2.5 rounded-full bg-teal-500 flex-shrink-0"></span>
                                <p class="text-gray-800"><span class="font-semibold">Students</span> – as change agents for sustainable lifestyles.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-2 h-2.5 w-2.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                                <p class="text-gray-800"><span class="font-semibold">Faculty</span> – as mentors embedding sustainability in teaching.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-2 h-2.5 w-2.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                                <p class="text-gray-800"><span class="font-semibold">Administrative staff</span> – as enablers of sustainable campus operations.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-2 h-2.5 w-2.5 rounded-full bg-purple-500 flex-shrink-0"></span>
                                <p class="text-gray-800"><span class="font-semibold">Partners and alumni</span> – as advocates for sustainable practices beyond campus.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @vite('resources/js/pemeringkatan/sulitest.js')
@endpush
