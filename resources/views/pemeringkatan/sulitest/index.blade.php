@extends('layouts.pemeringkatan')

@section('title', 'UNJ Sustain Quest - Mainstreaming Sustainability Literacy')

@section('meta_description', 'UNJ Sustain Quest provides internationally recognized online tools to measure, improve and certify sustainability knowledge.')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite('resources/css/pemeringkatan/sulitest.css')
@endpush

@section('content')
    <main>
        {{-- ═══════════════════════════════════════════════════════════════
             HERO — Centered full-width with floating orbs
        ═══════════════════════════════════════════════════════════════ --}}
        <section class="sulitest-hero relative overflow-hidden">
            <div class="hero-mesh"></div>

            {{-- Floating orbs --}}
            <div class="hero-orb hero-orb--1"></div>
            <div class="hero-orb hero-orb--2"></div>
            <div class="hero-orb hero-orb--3"></div>

            <div class="container mx-auto px-6 relative z-10">
                {{-- Centered headline block --}}
                <div class="hero-centered" data-reveal="up">
                    <span class="hero-pill">
                        <span class="hero-pill__dot"></span>
                        UNJ Sustain Quest
                    </span>

                    <h1 class="hero-title">
                        Empowering <span class="hero-gradient-text">Sustainability</span>
                        <br class="hidden sm:block">Literacy Across Campus
                    </h1>

                    <p class="hero-subtitle">
                        Measure, improve, and certify sustainability knowledge — building a
                        <strong class="text-white">greener and smarter</strong> UNJ community.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('sulitest.login') }}" class="hero-btn-primary group">
                            <span>Take the Assessment</span>
                            <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
                        </a>
                        <a href="#about" class="hero-btn-secondary">
                            <i class="fas fa-play-circle"></i>
                            <span>Learn More</span>
                        </a>
                    </div>
                </div>

                {{-- Role selector strip — 3 columns --}}
                <div class="hero-roles" data-reveal="up">
                    <a href="{{ route('sulitest.login') }}" class="hero-role-card group">
                        <div class="hero-role-card__icon-wrap hero-role-card__icon-wrap--red">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="hero-role-card__body">
                            <h3 class="hero-role-card__title">Faculty Member / Lecturer</h3>
                            <p class="hero-role-card__desc">Embed sustainability literacy into your curriculum and research.</p>
                        </div>
                        <div class="hero-role-card__arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('sulitest.login') }}" class="hero-role-card group">
                        <div class="hero-role-card__icon-wrap hero-role-card__icon-wrap--amber">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div class="hero-role-card__body">
                            <h3 class="hero-role-card__title">Administrative Staff</h3>
                            <p class="hero-role-card__desc">Enable sustainable campus operations and institutional goals.</p>
                        </div>
                        <div class="hero-role-card__arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('sulitest.login') }}" class="hero-role-card group">
                        <div class="hero-role-card__icon-wrap hero-role-card__icon-wrap--blue">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="hero-role-card__body">
                            <h3 class="hero-role-card__title">Students</h3>
                            <p class="hero-role-card__desc">Certify your sustainability knowledge and become a change agent.</p>
                        </div>
                        <div class="hero-role-card__arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Angled bottom divider --}}
            <div class="hero-divider">
                <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0 100V60C240 20 480 0 720 10C960 20 1200 50 1440 40V100H0Z" fill="#f8fafc"/>
                </svg>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             GLOBAL CHALLENGE
        ═══════════════════════════════════════════════════════════════ --}}
        <section id="about" class="py-24 lg:py-32 bg-slate-50 relative overflow-hidden">
            <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-red-100/30 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-amber-100/30 blur-3xl pointer-events-none"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="grid md:grid-cols-2 gap-16 lg:gap-24 items-center max-w-6xl mx-auto">
                    {{-- Left visual --}}
                    <div class="flex justify-center" data-reveal="up">
                        <div class="challenge-visual">
                            <div class="challenge-visual__ring challenge-visual__ring--outer"></div>
                            <div class="challenge-visual__ring challenge-visual__ring--inner"></div>
                            <div class="challenge-visual__core">
                                <i class="fas fa-leaf text-4xl text-red-500"></i>
                                <span class="text-sm font-bold text-gray-500 mt-2 tracking-widest uppercase">SDG</span>
                            </div>
                            <div class="challenge-visual__float challenge-visual__float--1">
                                <i class="fas fa-water text-blue-500"></i>
                            </div>
                            <div class="challenge-visual__float challenge-visual__float--2">
                                <i class="fas fa-sun text-amber-500"></i>
                            </div>
                            <div class="challenge-visual__float challenge-visual__float--3">
                                <i class="fas fa-heart text-red-400"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Right copy --}}
                    <div data-reveal="up">
                        <span class="section-badge section-badge--red">About</span>
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                            A Global Challenge,<br><span class="text-red-600">A Local Commitment</span>
                        </h2>
                        <div class="glass-card mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                The environmental and social challenges of our era demand that every student, educator,
                                and professional understands sustainability issues and takes part in solving them.
                            </p>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            <strong class="text-gray-900">UNJ Sustain Quest</strong> is Universitas Negeri Jakarta's initiative to strengthen sustainability literacy and foster environmentally responsible mindsets across all disciplines.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             MISSION + SOLUTION
        ═══════════════════════════════════════════════════════════════ --}}
        <section class="py-24 lg:py-32 bg-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-gradient-to-br from-red-50 to-transparent blur-3xl opacity-60 pointer-events-none"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-start max-w-7xl mx-auto">
                    {{-- Mission --}}
                    <div data-reveal="up">
                        <span class="section-badge section-badge--amber">Our Purpose</span>
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                            Our <span class="text-amber-500">Mission</span>
                        </h2>
                        <div class="glass-card glass-card--warm">
                            <p class="text-gray-800 leading-relaxed text-lg">
                                To integrate sustainability knowledge, values, and practices into education, research, and community engagement—preparing UNJ graduates to become future-ready leaders who contribute to Indonesia's sustainable development goals.
                            </p>
                        </div>
                    </div>

                    {{-- Solution --}}
                    <div data-reveal="up">
                        <span class="section-badge section-badge--navy">What We Do</span>
                        <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Our Solution: <span class="text-red-600">UNJ Sustain Quest (USQ)</span></h3>
                        <p class="text-gray-600 mb-8 leading-relaxed">Through USQ, UNJ provides a standardized tool to:</p>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div class="solution-card">
                                <div class="solution-card__icon solution-card__icon--red">
                                    <i class="fas fa-globe text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-1.5">Measure</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Sustainability knowledge and awareness among students and staff.</p>
                            </div>
                            <div class="solution-card">
                                <div class="solution-card__icon solution-card__icon--amber">
                                    <i class="fas fa-chart-pie text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-1.5">Improve</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Sustainability literacy through tailored learning modules and workshops.</p>
                            </div>
                            <div class="solution-card">
                                <div class="solution-card__icon solution-card__icon--navy">
                                    <i class="fas fa-user-check text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-1.5">Report</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Progress in alignment with UI GreenMetric and THE Impact Rankings indicators.</p>
                            </div>
                            <div class="solution-card">
                                <div class="solution-card__icon solution-card__icon--blue">
                                    <i class="fas fa-file-export text-xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mb-1.5">Certify</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Sustainability competence to support graduates' employability and green job readiness.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             WHY IT MATTERS — dark navy section with carousel
        ═══════════════════════════════════════════════════════════════ --}}
        <section id="why-matters" class="py-24 lg:py-32 bg-gray-900 relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><rect width=%2260%22 height=%2260%22 fill=%22none%22 stroke=%22white%22 stroke-width=%221%22/></svg>');"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="text-center mb-14" data-reveal="up">
                    <span class="section-badge section-badge--white">Impact</span>
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight">
                        Why UNJ Sustain Quest <span class="text-red-400">Matters</span>
                    </h2>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                        Driving real impact across education, research, and community engagement.
                    </p>
                </div>

                <div class="relative max-w-7xl mx-auto" data-reveal="up">
                    <div id="scroll-container"
                         class="flex gap-6 overflow-x-auto pb-6 snap-x snap-mandatory scroll-smooth"
                         style="scrollbar-width: none; -ms-overflow-style: none;">

                        <style>#scroll-container::-webkit-scrollbar { display: none; }</style>

                        {{-- Lead card --}}
                        <div class="snap-start flex-shrink-0 w-80 matters-card matters-card--lead">
                            <div class="h-full flex flex-col justify-between">
                                <div>
                                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mb-6">
                                        <i class="fas fa-lightbulb text-2xl text-red-400"></i>
                                    </div>
                                    <h3 class="font-extrabold text-2xl text-white mb-2">Why It Matters</h3>
                                    <p class="text-gray-400 text-sm leading-relaxed">Discover how sustainability literacy transforms institutions and communities.</p>
                                </div>
                                <div class="flex items-center gap-2 text-red-400 text-sm font-semibold mt-6">
                                    <span>Scroll to explore</span>
                                    <i class="fas fa-arrow-right animate-pulse"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Card 1 --}}
                        <div class="snap-start flex-shrink-0 w-80 matters-card matters-card--item group">
                            <div class="matters-card__number text-red-500/20 group-hover:text-red-500/40">01</div>
                            <h3 class="font-bold text-xl text-white mb-3 relative z-10">Change Leader</h3>
                            <div class="w-10 h-0.5 bg-red-500 mb-4 group-hover:w-16 transition-all duration-300"></div>
                            <p class="text-gray-400 leading-relaxed relative z-10">Empowers UNJ as a Change Leader in sustainability education in Indonesia.</p>
                        </div>

                        {{-- Card 2 --}}
                        <div class="snap-start flex-shrink-0 w-80 matters-card matters-card--item group">
                            <div class="matters-card__number text-amber-500/20 group-hover:text-amber-500/40">02</div>
                            <h3 class="font-bold text-xl text-white mb-3 relative z-10">SDG-Based Curricula</h3>
                            <div class="w-10 h-0.5 bg-amber-500 mb-4 group-hover:w-16 transition-all duration-300"></div>
                            <p class="text-gray-400 leading-relaxed relative z-10">Supports the implementation of SDG-based curricula.</p>
                        </div>

                        {{-- Card 3 --}}
                        <div class="snap-start flex-shrink-0 w-80 matters-card matters-card--item group">
                            <div class="matters-card__number text-blue-500/20 group-hover:text-blue-500/40">03</div>
                            <h3 class="font-bold text-xl text-white mb-3 relative z-10">Interdisciplinary Collaboration</h3>
                            <div class="w-10 h-0.5 bg-blue-500 mb-4 group-hover:w-16 transition-all duration-300"></div>
                            <p class="text-gray-400 leading-relaxed relative z-10">Encourages interdisciplinary collaboration on sustainability research and community projects.</p>
                        </div>

                        {{-- Card 4 --}}
                        <div class="snap-start flex-shrink-0 w-80 matters-card matters-card--item group">
                            <div class="matters-card__number text-indigo-500/20 group-hover:text-indigo-500/40">04</div>
                            <h3 class="font-bold text-xl text-white mb-3 relative z-10">Evidence for Rankings</h3>
                            <div class="w-10 h-0.5 bg-indigo-500 mb-4 group-hover:w-16 transition-all duration-300"></div>
                            <p class="text-gray-400 leading-relaxed relative z-10">Contributes evidence for national and international university rankings related to sustainability impact.</p>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <div class="flex justify-center gap-3 mt-8">
                        <button id="scroll-left-btn" class="scroll-nav-btn" aria-label="Scroll left">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <button id="scroll-right-btn" class="scroll-nav-btn" aria-label="Scroll right">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             COMMUNITY
        ═══════════════════════════════════════════════════════════════ --}}
        <section class="py-24 lg:py-32 bg-white relative overflow-hidden">
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-red-50/50 blur-3xl pointer-events-none"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 lg:gap-20 items-center max-w-7xl mx-auto">
                    {{-- Left — CTA card --}}
                    <div data-reveal="up">
                        <div class="community-cta-card">
                            <div class="community-cta-card__bg"></div>
                            <div class="relative z-10">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-6">
                                    <i class="fas fa-rocket text-2xl text-white"></i>
                                </div>
                                <h3 class="text-2xl md:text-3xl font-extrabold text-white mb-3">Join the Movement!</h3>
                                <p class="text-white/80 mb-2">Let's strengthen UNJ's sustainability culture together.</p>
                                <p class="text-white/80 mb-6">Explore the modules, take the UNJ Sustain Quest Assessment, and be part of a campus that leads by example.</p>
                                <div class="inline-flex items-center gap-3 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 px-5 py-2.5 text-white">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:dir.inovasi@unj.ac.id" class="font-medium hover:underline">dir.inovasi@unj.ac.id</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right — stakeholder list --}}
                    <div data-reveal="up">
                        <span class="section-badge section-badge--red">Together</span>
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                            Our <span class="text-red-600">Community</span>
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-8 text-lg">UNJ Sustain Quest brings together:</p>

                        <div class="space-y-4">
                            <div class="stakeholder-row">
                                <div class="stakeholder-dot bg-red-500"></div>
                                <div>
                                    <span class="font-bold text-gray-900">Students</span>
                                    <span class="text-gray-500"> – as change agents for sustainable lifestyles.</span>
                                </div>
                            </div>
                            <div class="stakeholder-row">
                                <div class="stakeholder-dot bg-amber-500"></div>
                                <div>
                                    <span class="font-bold text-gray-900">Faculty</span>
                                    <span class="text-gray-500"> – as mentors embedding sustainability in teaching.</span>
                                </div>
                            </div>
                            <div class="stakeholder-row">
                                <div class="stakeholder-dot bg-blue-600"></div>
                                <div>
                                    <span class="font-bold text-gray-900">Administrative staff</span>
                                    <span class="text-gray-500"> – as enablers of sustainable campus operations.</span>
                                </div>
                            </div>
                            <div class="stakeholder-row">
                                <div class="stakeholder-dot bg-indigo-600"></div>
                                <div>
                                    <span class="font-bold text-gray-900">Partners and alumni</span>
                                    <span class="text-gray-500"> – as advocates for sustainable practices beyond campus.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @vite('resources/js/pemeringkatan/sulitest.js')
@endpush
