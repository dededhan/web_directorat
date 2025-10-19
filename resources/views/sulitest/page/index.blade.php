<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sulitest UNJ - Mainstreaming Sustainability Literacy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafaf9;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .decorative-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
        }
        .fab, .fas, .far, .fal, .fad {
            font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands' !important;
            font-weight: 900 !important;
            -webkit-font-smoothing: antialiased;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        .fab {
            font-family: 'Font Awesome 6 Brands' !important;
            font-weight: 400 !important;
        }
    </style>
</head>
<body class="bg-stone-50">

    @include('layout.navbar_pemeringkatan')

    <main>
        <!-- HERO -->
        <section class="relative bg-stone-50 pt-32 pb-20 overflow-hidden">
            <!-- Decorative Elements -->
            <div class="decorative-shape absolute top-10 right-32 w-8 h-8 bg-yellow-400"></div>
            <div class="decorative-shape absolute top-24 right-20 w-6 h-6 bg-yellow-400 opacity-70"></div>
            <div class="decorative-shape absolute top-16 right-40 w-4 h-4 bg-yellow-400 opacity-50"></div>
            <div class="decorative-shape absolute top-40 right-16 w-10 h-10 bg-yellow-400 opacity-40"></div>
            
            <div class="container mx-auto px-6 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center max-w-7xl mx-auto">
                    <!-- Left Content -->
                    <div>
                        <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900 mb-6">
                            Mainstreaming<br>sustainability<br>literacy!
                        </h1>
                        <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                            We provide internationally recognized online tools to <strong>measure, improve and certify sustainability knowledge</strong>
                        </p>
                        <a href="{{ route('sulitest.login') }}" class="inline-block bg-gray-800 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-gray-700 transition-all">
                            Schedule a demo
                        </a>
                    </div>
                    
                    <!-- Right Side - Cards -->
                    <div class="relative">
                        <div class="space-y-4">
                            <p class="text-sm text-gray-600 mb-4">I am ...</p>
                            
                            <a href="{{ route('sulitest.login') }}" class="card-hover flex items-center gap-4 bg-blue-50 border-2 border-blue-100 rounded-xl p-6 hover:border-blue-300">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">A professor or a university</h3>
                                </div>
                            </a>
                            
                            <a href="{{ route('sulitest.login') }}" class="card-hover flex items-center gap-4 bg-orange-50 border-2 border-orange-100 rounded-xl p-6 hover:border-orange-300">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">A company or an organization</h3>
                                </div>
                            </a>
                            
                            <a href="{{ route('sulitest.login') }}" class="card-hover flex items-center gap-4 bg-stone-100 border-2 border-stone-200 rounded-xl p-6 hover:border-stone-400">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
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

        <!-- TRUST/LOGOS STRIP -->
        <section class="py-10 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 items-center opacity-70">
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                </div>
            </div>
        </section>

        <!-- GLOBAL CHALLENGE -->
        <section id="about" class="py-20 bg-stone-50 relative overflow-hidden">
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 opacity-5">
                <svg width="300" height="400" viewBox="0 0 300 400">
                    <path d="M 50,200 Q 100,150 150,200 T 250,200" stroke="#d4d4d8" stroke-width="2" fill="none"/>
                </svg>
            </div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="grid md:grid-cols-2 gap-16 items-center max-w-6xl mx-auto">
                    <div class="flex justify-center">
                        <div class="relative">
                            <div class="w-72 h-96 bg-gray-800 rounded-3xl flex flex-col items-center justify-center p-8 shadow-xl">
                                <div class="decorative-shape w-6 h-6 bg-yellow-400 absolute top-8 left-8"></div>
                                <div class="decorative-shape w-4 h-4 bg-yellow-400 absolute top-12 left-16 opacity-70"></div>
                                <div class="decorative-shape w-3 h-3 bg-yellow-400 absolute top-16 left-12 opacity-50"></div>
                                <div class="mb-4">
                                    <svg class="w-32 h-32 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"></path>
                                        <path d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">A global challenge</h2>
                        <div class="bg-orange-50 rounded-2xl p-6 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                The environmental and social crisis we face require that <strong>everyone</strong>, regardless of discipline or profession understand the challenges ahead and how to address them.
                            </p>
                        </div>
                        <p class="text-gray-900 font-semibold leading-relaxed">
                            Building a sustainable future demands enhancing knowledge, skills, and mindsets around sustainability.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- OUR SOLUTION -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-5xl mx-auto text-center">
                    <div class="flex justify-center mb-6">
                        <div class="decorative-shape w-6 h-6 bg-yellow-400"></div>
                        <div class="decorative-shape w-4 h-4 bg-yellow-400 opacity-70 ml-2"></div>
                        <div class="decorative-shape w-3 h-3 bg-yellow-400 opacity-50 ml-1"></div>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Our solution</h2>
                    <p class="text-gray-700 text-lg leading-relaxed mb-12 max-w-4xl mx-auto">
                        Through <span class="text-orange-600 font-semibold">TASK™</span> – The Assessment of Sustainability Knowledge – and supporting resources, we enable institutions to <strong>manage their sustainability education and training efforts, measure progress, and report on their impact</strong>!
                    </p>
                    <div class="relative max-w-4xl mx-auto">
                        <div class="aspect-video bg-black rounded-3xl shadow-2xl overflow-hidden">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/Es42l5dmtsA" title="TASK Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-10">
                        <a href="{{ route('sulitest.login') }}" class="bg-yellow-400 text-gray-900 font-semibold px-8 py-3.5 rounded-full hover:bg-yellow-500 transition-all">Schedule a demo</a>
                        <a href="#fitur" class="border-2 border-gray-300 text-gray-900 font-semibold px-8 py-3.5 rounded-full hover:border-gray-400 transition-all">Learn more</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FITUR -->
        <section id="fitur" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">Komponen yang membantu tes berjalan efektif dan informatif untuk meningkatkan literasi keberlanjutan.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
                    <div class="card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                        <div class="h-16 w-16 bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-globe text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-900 mb-3">Modul Global & Lokal</h3>
                        <p class="text-gray-600 leading-relaxed">Pertanyaan berbasis standar global Sulitest dan konteks UNJ.</p>
                    </div>
                    <div class="card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                        <div class="h-16 w-16 bg-gradient-to-br from-amber-400 to-amber-500 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-chart-pie text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-900 mb-3">Umpan Balik Instan</h3>
                        <p class="text-gray-600 leading-relaxed">Gambaran kekuatan dan area yang perlu ditingkatkan.</p>
                    </div>
                    <div class="card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                        <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-900 mb-3">Akun Peserta</h3>
                        <p class="text-gray-600 leading-relaxed">Akses riwayat tes dan progres pembelajaran.</p>
                    </div>
                    <div class="card-hover p-8 border-2 border-gray-100 rounded-2xl bg-white shadow-sm">
                        <div class="h-16 w-16 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-file-export text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-900 mb-3">Pelaporan UNJ</h3>
                        <p class="text-gray-600 leading-relaxed">Agregasi data untuk kebijakan dan pelaporan institusi.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS -->
        <section class="py-20 bg-stone-50 relative overflow-hidden">
            <div class="absolute right-0 top-1/4 opacity-5">
                <svg width="300" height="300" viewBox="0 0 300 300">
                    <circle cx="150" cy="150" r="100" stroke="#d4d4d8" stroke-width="2" fill="none"/>
                </svg>
            </div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="text-center mb-16">
                    <div class="flex justify-center mb-6">
                        <div class="decorative-shape w-6 h-6 bg-orange-400"></div>
                        <div class="decorative-shape w-4 h-4 bg-orange-400 opacity-70 ml-2"></div>
                        <div class="decorative-shape w-3 h-3 bg-orange-400 opacity-50 ml-1"></div>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">They support the movement</h2>
                </div>
                
                <div class="max-w-6xl mx-auto">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-2xl p-8 card-hover">
                            <p class="text-gray-700 leading-relaxed mb-6">"Humanity is facing increasing pressure to tackle climate change and social disturbances. We must innovate in both our content and learning experience. To do so, we have to see students' academic results as an output, and the impact of our teaching on their behaviour and understanding of sustainability issues as an outcome. Understanding and measuring this outcome requires innovative tools, such as TASK™ by Sulitest. Every institution is unique, and combining our diversity through a common platform is one of the greatest strengths of TASK™ by Sulitest."</p>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="font-semibold text-orange-600">Jean-Michel Champagne</p>
                                <p class="text-gray-900 font-medium">HEC Montréal</p>
                                <p class="text-sm text-gray-600">Lecturer and Sustainability Officer</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-8 card-hover">
                            <p class="text-gray-700 leading-relaxed mb-6">"Sulitest encourages people to increase her/his literacy on sustainability, hence supporting an impact in the society aimed to achieve sustainable development. It is an easy and friendly way to make people aware of her/ his literacy on sustainability in a challenging way."</p>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="font-semibold text-orange-600">Benedetta Siboni</p>
                                <p class="text-gray-900 font-medium">Alma Mater Studiorum Università di Bologna</p>
                                <p class="text-sm text-gray-600">Associate Professor of Business Administration and Accounting Studies</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center mt-12">
                        <div class="flex gap-2">
                            <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                            <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                            <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                            <button class="w-3 h-3 rounded-full bg-gray-900"></button>
                            <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                        </div>
                    </div>
                    
                    <div class="text-center mt-10">
                        <a href="#" class="inline-block bg-yellow-400 text-gray-900 font-semibold px-8 py-3.5 rounded-full hover:bg-yellow-500 transition-all">Discover our partnerships</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- MEET SULITEST -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-16 items-center max-w-7xl mx-auto">
                    <!-- Left: Photo Collage -->
                    <div class="relative">
                        <div class="grid grid-cols-4 gap-4">
                            <div class="col-span-1 space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                            </div>
                            <div class="col-span-1 space-y-4 pt-8">
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                            </div>
                            <div class="col-span-1 space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                            </div>
                            <div class="col-span-1 space-y-4 pt-12">
                                <div class="w-24 h-24 rounded-full bg-gray-800 overflow-hidden flex items-center justify-center">
                                    <img src="https://via.placeholder.com/96" alt="Team Lead" class="w-full h-full object-cover">
                                </div>
                                <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden"><img src="https://via.placeholder.com/64" alt="Team" class="w-full h-full object-cover"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right: Content -->
                    <div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                            Meet <span class="inline-flex items-center"><img src="https://cdn.prod.website-files.com/65280e69dc36aa08d8c6a40e/65280e69dc36aa08d8c6a43b_logo-sulitest-certification-developpement-durable.svg" alt="Sulitest" class="h-10 ml-2"></span>
                        </h2>
                        <div class="bg-orange-50 rounded-2xl p-6 mb-6">
                            <p class="text-gray-700 leading-relaxed mb-4">
                                Established in 2014, Sulitest is a French-born <span class="text-orange-600 font-semibold">international movement</span> with the mission to mainstream sustainability literacy worldwide.
                            </p>
                            <p class="text-gray-700 leading-relaxed">
                                With over <span class="text-orange-600 font-semibold">40 Change Leader institutions</span> and 35,000 people assessed, our impact stretches across over 20 countries.
                            </p>
                        </div>
                        <div class="bg-teal-500 rounded-2xl p-8 text-white relative overflow-hidden">
                            <div class="absolute right-0 bottom-0 opacity-10">
                                <svg width="200" height="150" viewBox="0 0 200 150">
                                    <circle cx="150" cy="100" r="80" fill="white"/>
                                </svg>
                            </div>
                            <p class="text-lg font-medium mb-4 relative z-10">
                                Let's discuss your sustainability education objectives and how we can support you with our tools, expertise and over 10 years of experience
                            </p>
                            <a href="{{ route('sulitest.login') }}" class="inline-block border-2 border-white text-white font-semibold px-8 py-3 rounded-full hover:bg-white/10 transition-all relative z-10">
                                Contact us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- NEWSLETTER -->
        <section class="py-20 bg-stone-50">
            <div class="container mx-auto px-6">
                <div class="max-w-6xl mx-auto">
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <div class="bg-orange-50 rounded-2xl p-10">
                            <h2 class="text-3xl font-bold text-orange-600 mb-4">Stay in the loop!</h2>
                            <p class="text-gray-700 leading-relaxed">
                                Are you interested in sustainability education, the latest news on our movement, key events in the sector and our various partnerships?
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Subscribe to our newsletter</h3>
                            <form class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" placeholder="First name" class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                    <input type="text" placeholder="Last name" class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" placeholder="Job title" class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                    <input type="email" placeholder="Email" class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                </div>
                                <div class="flex items-start gap-2">
                                    <input type="checkbox" id="privacy" class="mt-1">
                                    <label for="privacy" class="text-sm text-gray-600">I have read and accepted the <a href="#" class="text-orange-600 underline">privacy policy</a></label>
                                </div>
                                <button type="submit" class="bg-yellow-400 text-gray-900 font-semibold px-8 py-3 rounded-full hover:bg-yellow-500 transition-all">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.footer')

</body>
</html>
