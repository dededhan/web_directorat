@extends('subdirektorat-inovasi.hackaton.public-layout')

@section('title', 'Hackathon Deep Tech UNJ 2026 | From Real-World Challenges to Deep Tech Innovation')

@section('content_public_hackaton')
    <div class="mx-auto max-w-7xl px-5 py-8 sm:px-8 lg:px-12 lg:py-14 space-y-16 lg:space-y-24">

        {{-- 1. HERO SECTION --}}
        <section class="border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div class="grid gap-10 lg:grid-cols-[1.3fr_.7fr] lg:items-start">
                <div>
                    <div class="inline-flex items-center gap-2 border-2 border-gray-950 bg-emerald-50 px-3.5 py-1 text-xs font-black uppercase tracking-[0.2em] text-emerald-800">
                        <span class="inline-block h-2 w-2 bg-emerald-600"></span>
                        HACKATHON DEEP TECH UNJ 2026
                    </div>
                    
                    <h1 class="mt-5 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight text-gray-950 sm:text-5xl lg:text-6xl">
                        From Real-World Challenges to Deep Tech Innovation
                    </h1>
                    
                    <p class="mt-6 text-xl font-bold leading-snug text-emerald-900 sm:text-2xl">
                        Ubah permasalahan nyata menjadi solusi teknologi yang siap diuji, dikembangkan, dan dihilirkan.
                    </p>

                    <p class="mt-4 max-w-3xl text-base leading-relaxed text-gray-700 sm:text-lg">
                        Hackathon Deep Tech UNJ 2026 mempertemukan mahasiswa, dosen, peneliti, alumni, startup, profesional, industri, pemerintah, dan mitra pengguna untuk mengembangkan solusi berbasis deep technology berdasarkan problem statement nyata dari mitra.
                    </p>

                    {{-- Highlight Box --}}
                    <div class="mt-7 border-l-4 border-emerald-700 bg-white p-5 border-2 border-l-4 border-gray-950">
                        <p class="text-xs font-black uppercase tracking-wider text-emerald-700">Prinsip Program</p>
                        <p class="mt-1 text-lg font-black text-gray-950 sm:text-xl">Bukan sekadar kompetisi ide.</p>
                        <p class="mt-1 text-sm font-semibold text-gray-700 sm:text-base">
                            Bangun solusi. Buat purwarupa. Validasi bersama pengguna. Dorong menuju hilirisasi.
                        </p>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="mt-8 flex flex-wrap gap-3 sm:gap-4">
                        <a href="{{ route('hackaton.register.form') }}" class="inline-flex min-h-12 items-center justify-center bg-emerald-700 px-7 py-3 text-base font-black text-white transition hover:bg-emerald-800">
                            Daftar Sekarang <span aria-hidden="true" class="ml-3">→</span>
                        </a>
                        <a href="#challenge" class="inline-flex min-h-12 items-center justify-center border-2 border-gray-950 bg-white px-6 py-3 text-base font-black text-gray-950 transition hover:bg-gray-100">
                            Lihat Challenge
                        </a>
                        @if(auth()->check())
                            <a href="{{ route('hackaton.dashboard') }}" class="inline-flex min-h-12 items-center justify-center border-2 border-dashed border-gray-950 bg-amber-50 px-5 py-3 text-base font-black text-gray-950 hover:bg-amber-100">
                                Buka Dashboard
                            </a>
                        @else
                            <button type="button" class="login inline-flex min-h-12 items-center justify-center border-2 border-dashed border-gray-950 bg-gray-50 px-5 py-3 text-base font-black text-gray-950 hover:bg-gray-100 cursor-pointer">
                                Masuk Peserta
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Hero Side Stats: Dari Ide Menjadi Dampak --}}
                <div class="flex flex-col gap-4">
                    <div class="border-2 border-gray-950 bg-white p-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-700">Target & Capaian</p>
                        <h2 class="mt-1 text-2xl font-black text-gray-950">Dari Ide Menjadi Dampak</h2>
                        
                        <div class="mt-6 grid grid-cols-2 gap-4 border-t-2 border-gray-950 pt-5">
                            <div>
                                <span class="block text-3xl font-black text-emerald-700">10+</span>
                                <span class="text-xs font-black uppercase text-gray-950">Teams</span>
                                <p class="mt-1 text-xs text-gray-600">Target minimal tim yang mengikuti Hackathon</p>
                            </div>
                            <div>
                                <span class="block text-3xl font-black text-emerald-700">3+</span>
                                <span class="text-xs font-black uppercase text-gray-950">Innovation</span>
                                <p class="mt-1 text-xs text-gray-600">Target produk inovasi unggulan siap hilirisasi</p>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4 border-t border-gray-200 pt-4">
                            <div>
                                <span class="block text-sm font-black text-gray-950">Real Challenge</span>
                                <p class="mt-1 text-xs text-gray-600">Problem statement dari kebutuhan nyata mitra</p>
                            </div>
                            <div>
                                <span class="block text-sm font-black text-gray-950">Prototype → Market</span>
                                <p class="mt-1 text-xs text-gray-600">Validasi, TKT, model bisnis, dan implementasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-2 border-gray-950 bg-[#111827] p-6 text-white">
                        <p class="text-xs font-black uppercase tracking-wider text-emerald-400">Dua Jalur Holding Program</p>
                        <div class="mt-3 space-y-2.5 text-sm">
                            <div class="flex items-start gap-2">
                                <span class="text-base">🏥</span>
                                <div>
                                    <span class="font-black text-white">D-MARC UNJ</span>
                                    <p class="text-xs text-gray-300">Medical Devices & Healthcare Tech</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-base">🌾</span>
                                <div>
                                    <span class="font-black text-white">D-FARM UNJ</span>
                                    <p class="text-xs text-gray-300">Smart Food Systems & Food Security</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- 2. TENTANG PROGRAM --}}
        <section id="tentang" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div class="grid gap-8 lg:grid-cols-[.65fr_1.35fr]">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Akselerasi Inovasi</p>
                    <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Tentang Program</h2>
                </div>
                <div class="space-y-6">
                    <p class="text-lg leading-relaxed text-gray-800">
                        <strong>Hackathon Deep Tech UNJ 2026</strong> merupakan program akselerasi inovasi yang menggunakan pendekatan <strong>Challenge-Based Learning</strong>, <strong>Design Thinking</strong>, dan <strong>Demand-Driven Innovation</strong>.
                    </p>
                    <p class="text-base leading-relaxed text-gray-700">
                        Peserta tidak memulai dari masalah yang abstrak. Setiap challenge berasal dari kebutuhan nyata mitra pengguna, kemudian dikembangkan menjadi solusi berbasis teknologi melalui proses berjenjang:
                    </p>

                    {{-- Process Pipeline --}}
                    <div class="border-2 border-gray-950 bg-white p-5">
                        <p class="text-xs font-black uppercase tracking-wider text-gray-500 mb-3">Siklus Pengembangan Solusi</p>
                        <div class="flex flex-wrap items-center gap-2 font-mono text-xs sm:text-sm font-bold">
                            <span class="bg-gray-100 border border-gray-950 px-2.5 py-1 text-gray-950">Problem</span>
                            <span class="text-emerald-700">→</span>
                            <span class="bg-gray-100 border border-gray-950 px-2.5 py-1 text-gray-950">Challenge</span>
                            <span class="text-emerald-700">→</span>
                            <span class="bg-gray-100 border border-gray-950 px-2.5 py-1 text-gray-950">Solution</span>
                            <span class="text-emerald-700">→</span>
                            <span class="bg-gray-100 border border-gray-950 px-2.5 py-1 text-gray-950">Prototype</span>
                            <span class="text-emerald-700">→</span>
                            <span class="bg-gray-100 border border-gray-950 px-2.5 py-1 text-gray-950">Validation</span>
                            <span class="text-emerald-700">→</span>
                            <span class="bg-gray-100 border border-gray-950 px-2.5 py-1 text-gray-950">Business</span>
                            <span class="text-emerald-700">→</span>
                            <span class="bg-emerald-700 text-white px-2.5 py-1 font-black">Scale</span>
                        </div>
                    </div>

                    <p class="text-base leading-relaxed text-gray-700">
                        Program dirancang untuk mempertemukan kapasitas riset dan teknologi dengan kebutuhan nyata industri, layanan kesehatan, pemerintah, dan masyarakat.
                    </p>

                    {{-- Dua Program. Satu Ekosistem Inovasi --}}
                    <div class="pt-4">
                        <h3 class="text-xl font-black text-gray-950 sm:text-2xl">Dua Program. Satu Ekosistem Inovasi.</h3>
                        <p class="mt-1 text-sm text-gray-600">D-MARC berfokus pada inovasi alat kesehatan dan teknologi medis, sedangkan D-FARM berfokus pada smart food systems dan ketahanan pangan.</p>

                        <div class="mt-6 grid gap-6 md:grid-cols-2">
                            {{-- D-MARC Card --}}
                            <div class="border-2 border-gray-950 bg-white p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between gap-2 border-b-2 border-gray-950 pb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl">🏥</span>
                                            <h4 class="text-xl font-black text-gray-950">D-MARC UNJ</h4>
                                        </div>
                                        <span class="text-[11px] font-black uppercase tracking-wider bg-rose-100 border border-rose-900 px-2 py-0.5 text-rose-900">Health</span>
                                    </div>
                                    <p class="mt-3 text-xs font-black uppercase tracking-wider text-gray-500">Fokus Program</p>
                                    <p class="text-base font-bold text-gray-950">Medical & Healthcare</p>
                                    
                                    <p class="mt-3 text-xs font-black uppercase tracking-wider text-gray-500">Tema Resmi</p>
                                    <p class="text-sm font-semibold text-emerald-800">
                                        "Collaborative Deep Technology Innovation for Medical Devices and Pharmaceutical Products"
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600">
                                        D-MARC berfokus pada inovasi alat kesehatan, biosensor, AI kesehatan, IoMT, dan teknologi medis.
                                    </p>
                                </div>
                                <a href="#dmarc" class="mt-6 inline-flex items-center text-sm font-black text-emerald-700 hover:text-emerald-900 hover:underline">
                                    Lihat 7 Challenge D-MARC <span aria-hidden="true" class="ml-1">↓</span>
                                </a>
                            </div>

                            {{-- D-FARM Card --}}
                            <div class="border-2 border-gray-950 bg-white p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between gap-2 border-b-2 border-gray-950 pb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl">🌾</span>
                                            <h4 class="text-xl font-black text-gray-950">D-FARM UNJ</h4>
                                        </div>
                                        <span class="text-[11px] font-black uppercase tracking-wider bg-amber-100 border border-amber-900 px-2 py-0.5 text-amber-950">Food</span>
                                    </div>
                                    <p class="mt-3 text-xs font-black uppercase tracking-wider text-gray-500">Fokus Program</p>
                                    <p class="text-base font-bold text-gray-950">Food & Food Systems</p>
                                    
                                    <p class="mt-3 text-xs font-black uppercase tracking-wider text-gray-500">Tema Resmi</p>
                                    <p class="text-sm font-semibold text-emerald-800">
                                        "Collaborative Deep Technology Innovation for Smart Food Systems"
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600">
                                        D-FARM berfokus pada smart food systems, ketahanan pangan, nutrisi unggul, dan circular production.
                                    </p>
                                </div>
                                <a href="#dfarm" class="mt-6 inline-flex items-center text-sm font-black text-emerald-700 hover:text-emerald-900 hover:underline">
                                    Lihat 4 Challenge & 10 Grand Areas <span aria-hidden="true" class="ml-1">↓</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- 3. PILIH CHALLENGE --}}
        <section id="challenge" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Problem Statements Mitra</p>
                <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl lg:text-5xl">Pilih Challenge</h2>
                <p class="mt-2 text-xl font-bold text-gray-800">Solve a Real Problem from a Real Partner</p>
                <p class="mt-3 max-w-3xl text-base text-gray-700">
                    Pilih challenge sesuai keahlian, teknologi, dan minat tim Anda. Challenge dikembangkan berdasarkan problem statement dari mitra pengguna, sehingga solusi yang dibangun diarahkan pada kebutuhan nyata dan peluang implementasi.
                </p>
            </div>

            <div class="mt-12 space-y-16">
                {{-- D-MARC Challenge Section --}}
                <div id="dmarc" class="scroll-mt-24 border-2 border-gray-950 bg-white p-6 sm:p-8 lg:p-10">
                    <div class="border-b-2 border-gray-950 pb-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl">🏥</span>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-950 sm:text-3xl">D-MARC UNJ</h3>
                                    <p class="text-sm font-bold text-gray-600">DeepTech Medical Acceleration Research-to-Challenge</p>
                                </div>
                            </div>
                            <span class="border-2 border-gray-950 bg-emerald-50 px-3 py-1 text-xs font-black uppercase tracking-wider text-emerald-900">
                                Fokus: Medical Devices & Healthcare Technology
                            </span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-black uppercase tracking-wider text-gray-950">Challenge Areas (01 — 07)</h4>
                            <span class="text-xs text-gray-500 font-bold">Proposal D-MARC Innovation Scope</span>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">01</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">Smart Medical Devices</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Mengembangkan perangkat medis cerdas yang aman, efektif, terhubung, dan sesuai kebutuhan pengguna.
                                    </p>
                                </div>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">02</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">Diagnostic Devices</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Solusi teknologi untuk mendukung proses diagnosis dan pemantauan kesehatan yang akurat dan terjangkau.
                                    </p>
                                </div>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">03</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">Biosensor & Sensing Technology</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Pengembangan biosensor dan teknologi sensor mutakhir untuk kebutuhan deteksi dan kesehatan.
                                    </p>
                                </div>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">04</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">AI for Healthcare</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Pemanfaatan Artificial Intelligence untuk mendukung alat diagnosa, automasi, dan layanan kesehatan.
                                    </p>
                                </div>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">05</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">IoMT & Patient Monitoring</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Solusi Internet of Medical Things dan sistem pemantauan kondisi pasien secara real-time dan terintegrasi.
                                    </p>
                                </div>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">06</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">Wearable Medical Devices</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Teknologi wearable untuk monitoring, diagnosis, rehabilitasi, atau kebutuhan pemeliharaan kesehatan mandiri.
                                    </p>
                                </div>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5 flex flex-col justify-between sm:col-span-2 lg:col-span-3">
                                <div>
                                    <span class="text-xs font-black text-emerald-700">07</span>
                                    <h5 class="mt-1 text-lg font-black text-gray-950">Rehabilitation Technology</h5>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                        Teknologi untuk mendukung proses terapi, rehabilitasi medis, serta peningkatan kualitas layanan pasien pasca-tindakan.
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t-2 border-gray-950 pt-6">
                        <p class="text-xs font-bold text-gray-600">
                            * Area tersebut sesuai dengan ruang inovasi yang ditetapkan dalam proposal D-MARC.
                        </p>
                        <a href="{{ route('hackaton.register.form') }}" class="inline-flex items-center bg-gray-950 px-6 py-2.5 text-sm font-black text-white hover:bg-emerald-700">
                            Pilih Problem Statement D-MARC →
                        </a>
                    </div>
                </div>

                {{-- D-FARM Challenge Section --}}
                <div id="dfarm" class="scroll-mt-24 border-2 border-gray-950 bg-white p-6 sm:p-8 lg:p-10">
                    <div class="border-b-2 border-gray-950 pb-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl">🌾</span>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-950 sm:text-3xl">D-FARM UNJ</h3>
                                    <p class="text-sm font-bold text-gray-600">DeepTech Food Acceleration Research-to-Market</p>
                                </div>
                            </div>
                            <span class="border-2 border-gray-950 bg-amber-50 px-3 py-1 text-xs font-black uppercase tracking-wider text-amber-950">
                                Fokus: Smart Food Systems & National Food Security
                            </span>
                        </div>
                    </div>

                    {{-- 4 Challenge Utama --}}
                    <div class="mt-8">
                        <h4 class="text-lg font-black uppercase tracking-wider text-gray-950 mb-4">4 Challenge Utama</h4>
                        
                        <div class="grid gap-4 sm:grid-cols-2">
                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5">
                                <span class="text-xs font-black text-emerald-700">01</span>
                                <h5 class="mt-1 text-lg font-black text-gray-950">Next-Generation Nutrition</h5>
                                <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                    Mengembangkan telur dengan nilai nutrisi dan nilai tambah yang lebih tinggi menggunakan teknologi deep tech.
                                </p>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5">
                                <span class="text-xs font-black text-emerald-700">02</span>
                                <h5 class="mt-1 text-lg font-black text-gray-950">Smart Egg Production</h5>
                                <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                    Meningkatkan produktivitas dan kualitas produksi telur melalui penerapan teknologi cerdas dan automasi.
                                </p>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5">
                                <span class="text-xs font-black text-emerald-700">03</span>
                                <h5 class="mt-1 text-lg font-black text-gray-950">Better Nutrition Crops & Food</h5>
                                <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                    Mengembangkan tanaman dan pangan dengan kualitas nutrisi yang lebih baik melalui riset dan teknologi deep tech.
                                </p>
                            </article>

                            <article class="border-2 border-gray-950 bg-[#fbfbf9] p-5">
                                <span class="text-xs font-black text-emerald-700">04</span>
                                <h5 class="mt-1 text-lg font-black text-gray-950">Circular Production</h5>
                                <p class="mt-2 text-sm leading-relaxed text-gray-700">
                                    Mengolah limbah pertanian, peternakan, dan pangan menjadi pupuk, biogas, energi, bahan pakan, atau produk bernilai tambah dengan pendekatan precision agriculture.
                                </p>
                            </article>
                        </div>
                    </div>

                    {{-- Grand Challenge Area --}}
                    <div class="mt-8 border-t-2 border-gray-950 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-black uppercase tracking-wider text-gray-950">Area Grand Challenge Solusi Pangan</h4>
                            <span class="text-xs text-gray-500 font-bold">10 Bidang Eksplorasi</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-4">Solusi D-FARM juga dapat dikembangkan dalam area strategis berikut:</p>
                        
                        <div class="flex flex-wrap gap-2">
                            @foreach([
                                'Smart Food Safety System',
                                'Rapid Foodborne Pathogen Detection',
                                'Smart Food Traceability',
                                'AI-Based Food Quality Inspection',
                                'Smart Cold Chain Monitoring',
                                'IoT-Based Food Storage Monitoring',
                                'Smart Supply Chain Management',
                                'Smart Agriculture & Precision Farming',
                                'Food Waste Reduction Technology',
                                'Sustainable Food Processing'
                            ] as $grand)
                                <span class="border border-gray-950 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-900">
                                    ✓ {{ $grand }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t-2 border-gray-950 pt-6">
                        <p class="text-xs font-bold text-gray-600">
                            * Solusi diarahkan untuk ketahanan pangan nasional dan efisiensi rantai pasok.
                        </p>
                        <a href="{{ route('hackaton.register.form') }}" class="inline-flex items-center bg-gray-950 px-6 py-2.5 text-sm font-black text-white hover:bg-emerald-700">
                            Pilih Problem Statement D-FARM →
                        </a>
                    </div>
                </div>
            </div>
        </section>


        {{-- 4. JADWAL PROGRAM --}}
        <section id="jadwal" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div class="grid gap-8 lg:grid-cols-[.65fr_1.35fr]">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Rencana Kegiatan</p>
                    <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Jadwal Program</h2>
                    <p class="mt-3 text-lg font-bold text-gray-800">10 Bulan Perjalanan dari Challenge hingga Hilirisasi</p>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                        Rangkaian waktu September 2026 – Juli 2027 tercantum dalam rencana kegiatan resmi kedua program.
                    </p>
                    <div class="mt-6 border-l-2 border-gray-950 pl-4 py-1 text-xs text-gray-600">
                        <strong>Catatan:</strong> Tanggal harian dan deadline setiap tahapan mengikuti pengumuman resmi penyelenggara melalui dashboard sistem.
                    </div>
                </div>

                {{-- Schedule Table / Cards --}}
                <div class="border-2 border-gray-950 bg-white">
                    <div class="divide-y-2 divide-gray-950">
                        @php
                            $jadwal = [
                                ['tahap' => '01', 'waktu' => 'September 2026', 'aktivitas' => 'Persiapan, FGD Problem Statement & sistem Hackathon'],
                                ['tahap' => '02', 'waktu' => 'Oktober 2026', 'aktivitas' => 'Sosialisasi & Delivery Problem Statement'],
                                ['tahap' => '03', 'waktu' => 'November 2026', 'aktivitas' => 'Open Call, Seleksi Administrasi & Seleksi Substansi'],
                                ['tahap' => '04', 'waktu' => 'Desember 2026 – Februari 2027', 'aktivitas' => 'Bootcamp, Workshop, Hackathon & Prototype Development'],
                                ['tahap' => '05', 'waktu' => 'Maret 2027', 'aktivitas' => 'Demo Day & Awarding'],
                                ['tahap' => '06', 'waktu' => 'April – Mei 2027', 'aktivitas' => 'Pendampingan & pengembangan lanjutan'],
                                ['tahap' => '07', 'waktu' => 'Juni 2027', 'aktivitas' => 'Final Dissemination'],
                                ['tahap' => '08', 'waktu' => 'Juli 2027', 'aktivitas' => 'Evaluasi & Pelaporan'],
                            ];
                        @endphp

                        @foreach($jadwal as $item)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-5 gap-3 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center bg-gray-950 text-xs font-black text-white">
                                        {{ $item['tahap'] }}
                                    </span>
                                    <div>
                                        <p class="text-sm font-black text-gray-950">{{ $item['aktivitas'] }}</p>
                                    </div>
                                </div>
                                <span class="self-start sm:self-center border border-gray-950 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-900 whitespace-nowrap">
                                    {{ $item['waktu'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>


        {{-- 5. SIAPA YANG BISA IKUT & KOMPONEN TIM --}}
        <section id="peserta" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16 space-y-12">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Kriteria Peserta</p>
                <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Siapa yang Bisa Ikut?</h2>
                <p class="mt-3 max-w-3xl text-base text-gray-700">
                    Hackathon Deep Tech UNJ terbuka bagi individu yang membentuk tim multidisiplin, terutama dari:
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="border-2 border-gray-950 bg-white p-5">
                        <span class="text-3xl">🎓</span>
                        <h3 class="mt-3 text-lg font-black text-gray-950">Akademisi</h3>
                        <p class="mt-2 text-sm text-gray-700">Dosen, peneliti, dan civitas akademika berlatar riset sains dan teknologi.</p>
                    </div>

                    <div class="border-2 border-gray-950 bg-white p-5">
                        <span class="text-3xl">👨‍🎓</span>
                        <h3 class="mt-3 text-lg font-black text-gray-950">Mahasiswa</h3>
                        <p class="mt-2 text-sm text-gray-700">Mahasiswa yang memiliki kemampuan atau ketertarikan kuat pada teknologi dan inovasi.</p>
                    </div>

                    <div class="border-2 border-gray-950 bg-white p-5">
                        <span class="text-3xl">🚀</span>
                        <h3 class="mt-3 text-lg font-black text-gray-950">Innovator</h3>
                        <p class="mt-2 text-sm text-gray-700">Alumni, startup, profesional, dan pengembang inovasi deep technology.</p>
                    </div>

                    <div class="border-2 border-gray-950 bg-white p-5">
                        <span class="text-3xl">🏭</span>
                        <h3 class="mt-3 text-lg font-black text-gray-950">Industry</h3>
                        <p class="mt-2 text-sm text-gray-700">Pelaku industri, praktisi, dan calon mitra pengembangan serta pengguna teknologi.</p>
                    </div>
                </div>

                <div class="mt-4 border-2 border-gray-950 bg-gray-100 p-4 text-xs sm:text-sm text-gray-700">
                    <strong>Cakupan Peserta Jalur:</strong> D-MARC secara khusus menyasar dosen, peneliti, mahasiswa, alumni, startup, dan mitra industri; D-FARM mencakup dosen, mahasiswa, peneliti, alumni, startup, profesional, dan pelaku industri.
                </div>
            </div>

            {{-- Komponen Tim --}}
            <div id="tim" class="border-t-2 border-gray-950 pt-10">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Build Your Dream Team</p>
                <h3 class="mt-2 text-2xl font-black text-gray-950 sm:text-3xl">Komponen Tim</h3>
                <p class="mt-2 max-w-3xl text-base text-gray-700">
                    Hackathon membutuhkan lebih dari sekadar programmer. Bangun tim dengan kompetensi yang saling melengkapi:
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <article class="border-2 border-gray-950 bg-white p-5">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">🧠</span>
                            <h4 class="text-base font-black text-gray-950">Problem & Research</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">Memahami masalah, riset data, studi pustaka, dan kebutuhan nyata calon pengguna.</p>
                    </article>

                    <article class="border-2 border-gray-950 bg-white p-5">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">⚙️</span>
                            <h4 class="text-base font-black text-gray-950">Technology & Engineering</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">AI, IoT, hardware, software, sensor, embedded system, data science, atau teknologi terkait.</p>
                    </article>

                    <article class="border-2 border-gray-950 bg-white p-5">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">🎨</span>
                            <h4 class="text-base font-black text-gray-950">Product & UX</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">Human-centered design, UI/UX, prototyping, ergonomi, dan interaksi pengguna.</p>
                    </article>

                    <article class="border-2 border-gray-950 bg-white p-5">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">📊</span>
                            <h4 class="text-base font-black text-gray-950">Business & Commercialization</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">Business model, market opportunity, kalkulasi biaya, strategi hilirisasi, dan pitching.</p>
                    </article>

                    <article class="border-2 border-gray-950 bg-white p-5">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">🏥/🌾</span>
                            <h4 class="text-base font-black text-gray-950">Domain Expertise</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">Pengetahuan mendalam bidang kesehatan atau pangan sesuai challenge yang dipilih.</p>
                    </article>

                    <article class="border-2 border-gray-950 bg-white p-5">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">🤝</span>
                            <h4 class="text-base font-black text-gray-950">Collaboration</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">Kemampuan bekerja lintas disiplin dan berkolaborasi intensif dengan mentor serta mitra.</p>
                    </article>
                </div>

                <div class="mt-6 border-2 border-gray-950 bg-amber-50 p-5">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-users text-lg text-emerald-800 mt-1"></i>
                        <div>
                            <p class="text-sm font-black text-gray-950">Ketentuan Tim:</p>
                            <ul class="mt-1 list-disc list-inside text-xs sm:text-sm text-gray-700 space-y-1">
                                <li><strong>Minimal 5 peserta</strong> dalam satu tim diperlukan untuk mengikuti tahapan pelaksanaan hackathon.</li>
                                <li>Tidak harus sudah memiliki semua kompetensi secara lengkap sejak awal. Yang paling penting, tim memiliki kombinasi kemampuan yang relevan dengan challenge yang dipilih.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- 6. APA YANG AKAN KAMU KERJAKAN? --}}
        <section id="proses" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Tahapan Pengembangan</p>
                <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Apa yang Akan Kamu Kerjakan?</h2>
                <p class="mt-2 text-lg font-bold text-gray-800">Bukan hanya membuat pitch deck.</p>
                <p class="mt-1 text-sm text-gray-600 max-w-3xl">
                    Selama program, tim akan dibimbing melalui proses akselerasi komprehensif mulai dari memahami masalah hingga business matching:
                </p>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $proses = [
                        ['no' => '01', 'step' => 'Understand', 'desc' => 'Pahami problem statement dan kebutuhan pengguna secara mendalam.'],
                        ['no' => '02', 'step' => 'Define', 'desc' => 'Validasi masalah dan tentukan fokus solusi yang paling berdampak.'],
                        ['no' => '03', 'step' => 'Design', 'desc' => 'Rancang konsep solusi dan arsitektur teknologi terperinci.'],
                        ['no' => '04', 'step' => 'Build', 'desc' => 'Kembangkan purwarupa (prototype) yang fungsional dan teruji.'],
                        ['no' => '05', 'step' => 'Validate', 'desc' => 'Uji solusi secara teknis dan bersama mitra pengguna langsung.'],
                        ['no' => '06', 'step' => 'Refine', 'desc' => 'Tingkatkan kualitas teknologi dan kesiapan implementasi nyata.'],
                        ['no' => '07', 'step' => 'Business', 'desc' => 'Bangun model bisnis, analisis pasar, dan strategi hilirisasi.'],
                        ['no' => '08', 'step' => 'Pitch', 'desc' => 'Presentasikan solusi pada Demo Day & sesi Business Matching.'],
                    ];
                @endphp

                @foreach($proses as $p)
                    <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-black text-emerald-700">{{ $p['no'] }}</span>
                            <h3 class="mt-2 text-lg font-black text-gray-950">{{ $p['step'] }}</h3>
                            <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">{{ $p['desc'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="mt-6 text-xs text-gray-500 font-medium">
                * Tahapan pengembangan tersebut konsisten dengan pendekatan pendampingan D-FARM & D-MARC, termasuk validasi problem statement, arsitektur teknologi, prototype development, validasi pengguna, model bisnis, Demo Day, dan business matching.
            </p>
        </section>


        {{-- 7. ALUR PENDAFTARAN --}}
        <section id="alur" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div class="grid gap-8 lg:grid-cols-[.65fr_1.35fr]">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Tahapan Seleksi</p>
                    <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Alur Pendaftaran</h2>
                    <p class="mt-3 text-base text-gray-700 leading-relaxed">
                        Alur seleksi mencakup pendaftaran akun, pembentukan tim, pemilihan challenge, desk evaluation, seleksi substansi, penetapan tim finalis, bootcamp/hackathon, hingga Demo Day.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('hackaton.register.form') }}" class="inline-flex items-center bg-emerald-700 px-6 py-3 text-sm font-black text-white hover:bg-emerald-800">
                            Mulai Buat Akun Tim →
                        </a>
                    </div>
                </div>

                <div class="border-2 border-gray-950 bg-white p-6 sm:p-8">
                    <ol class="relative border-l-2 border-gray-950 space-y-6 ml-3">
                        @php
                            $alur = [
                                ['title' => 'REGISTER', 'desc' => 'Buat akun pada platform Hackathon Deep Tech UNJ.'],
                                ['title' => 'BUILD YOUR TEAM', 'desc' => 'Bentuk tim multidisiplin dengan minimal 1 Ketua dan 2 anggota pada pendaftaran awal.'],
                                ['title' => 'CHOOSE YOUR CHALLENGE', 'desc' => 'Pilih program (D-MARC / D-FARM) dan problem statement mitra yang ingin diselesaikan.'],
                                ['title' => 'SUBMIT', 'desc' => 'Kirim proposal atau ide inovasi sesuai format yang telah ditentukan di sistem.'],
                                ['title' => 'ADMINISTRATIVE SELECTION', 'desc' => 'Proposal diperiksa oleh panitia berdasarkan kelengkapan dan kesesuaian persyaratan administrasi.'],
                                ['title' => 'SUBSTANTIVE SELECTION', 'desc' => 'Tim terpilih mempresentasikan ide atau produk inovasinya di hadapan reviewer substansi.'],
                                ['title' => 'JOIN THE HACKATHON', 'desc' => 'Tim terpilih mengikuti bootcamp, workshop intensif, coaching clinic, dan pengembangan purwarupa.'],
                                ['title' => 'DEMO DAY', 'desc' => 'Presentasikan solusi, prototype, business model, dan roadmap hilirisasi di depan industri & investor.'],
                            ];
                        @endphp

                        @foreach($alur as $index => $step)
                            <li class="ml-6">
                                <span class="absolute -left-[13px] flex h-6 w-6 items-center justify-center border-2 border-gray-950 bg-emerald-700 text-[11px] font-black text-white">
                                    {{ $index + 1 }}
                                </span>
                                <h3 class="text-base font-black text-gray-950">{{ $step['title'] }}</h3>
                                <p class="mt-1 text-sm text-gray-700 leading-relaxed">{{ $step['desc'] }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>


        {{-- 8. BENEFIT --}}
        <section id="benefit" class="scroll-mt-20 border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Dukungan & Fasilitasi</p>
                <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Benefit Program</h2>
                <p class="mt-2 text-xl font-bold text-gray-800">More Than a Competition</p>
                <p class="mt-2 max-w-3xl text-sm text-gray-600">
                    Peserta mendapatkan akses ke pendampingan intensif, fasilitas riset, jejaring mitra, hingga peluang investasi hilirisasi:
                </p>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">🧑‍🏫</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">Expert Mentoring</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Pendampingan dari akademisi, peneliti, praktisi industri, regulator, dan mentor sesuai bidang inovasi.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">🛠️</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">Prototype Development</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Kesempatan mengembangkan dan menyempurnakan purwarupa dengan dukungan fasilitas dan keahlian yang tersedia.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">🔬</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">Technical & User Validation</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Solusi diarahkan untuk memperoleh validasi teknis dan validasi langsung dari calon pengguna & mitra industri.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">📈</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">TKT Acceleration</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Pendampingan terstruktur untuk meningkatkan Tingkat Kesiapterapan Teknologi (TKT) menuju kesiapan pasar.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">🧾</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">HKI & Regulatory Guidance</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Pembekalan mengenai perlindungan HKI/Paten, regulasi, sertifikasi standar, dan jalur pengembangan produk.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">💼</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">Business Model</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Belajar menyusun model bisnis, kalkulasi finansial, strategi pasar, dan rencana hilirisasi komersial.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">🤝</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">Business Matching</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Kesempatan berinteraksi dengan industri, pemerintah, investor, venture capital, dan inkubator bisnis.
                        </p>
                    </div>
                </article>

                <article class="border-2 border-gray-950 bg-white p-5 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl">🚀</span>
                        <h3 class="mt-3 text-base font-black text-gray-950">Hilirisasi</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-700 leading-relaxed">
                            Inovasi terbaik diarahkan untuk validasi pilot, lisensi, co-development, atau komersialisasi nyata.
                        </p>
                    </div>
                </article>
            </div>
        </section>


        {{-- 9. CALL TO ACTION --}}
        <section class="border-4 border-gray-950 bg-emerald-900 text-white p-8 sm:p-12 lg:p-16">
            <div class="max-w-4xl">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-300">Bergabung Sekarang</p>
                <h2 class="mt-2 text-3xl font-black leading-tight sm:text-4xl lg:text-5xl">
                    Siap Menyelesaikan Masalah Nyata?
                </h2>
                <p class="mt-3 text-xl font-bold text-emerald-200">
                    Your Technology. Their Challenge. Real-World Impact.
                </p>
                <p class="mt-4 text-base sm:text-lg text-emerald-100 leading-relaxed max-w-2xl">
                    Pilih challenge. Bangun tim. Kembangkan prototype. Validasi bersama pengguna. Bawa inovasimu menuju hilirisasi.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('hackaton.register.form') }}" class="inline-flex min-h-12 items-center justify-center bg-white px-8 py-3 text-base font-black text-emerald-950 hover:bg-gray-100">
                        DAFTAR HACKATHON <span aria-hidden="true" class="ml-3">→</span>
                    </a>
                    <a href="#challenge" class="inline-flex min-h-12 items-center justify-center border-2 border-white bg-transparent px-6 py-3 text-base font-black text-white hover:bg-white hover:text-emerald-950">
                        Lihat Semua Challenge
                    </a>
                </div>
            </div>
        </section>


        {{-- 10. FAQ SECTION --}}
        <section id="faq" class="scroll-mt-20 border-b-2 border-gray-950 pb-12 lg:pb-16" x-data="{ active: null }">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">Frequently Asked Questions</p>
                <h2 class="mt-2 text-3xl font-black leading-tight text-gray-950 sm:text-4xl">Pertanyaan yang Sering Diajukan</h2>
                <p class="mt-2 text-base text-gray-600">Temukan jawaban seputar teknis kepesertaan, tim, dan ketentuan Hackathon Deep Tech UNJ.</p>
            </div>

            <div class="mt-10 divide-y-2 divide-gray-950 border-2 border-gray-950 bg-white">
                @php
                    $faqs = [
                        [
                            'q' => 'Apa itu Hackathon Deep Tech UNJ?',
                            'a' => 'Hackathon Deep Tech UNJ adalah program akselerasi inovasi berbasis deep technology yang mempertemukan peserta dengan problem statement nyata dari mitra untuk menghasilkan solusi dan purwarupa yang berpotensi diimplementasikan dan dihilirkan.'
                        ],
                        [
                            'q' => 'Apa saja program yang tersedia?',
                            'a' => 'Terdapat dua program utama: (1) D-MARC UNJ — fokus pada inovasi alat kesehatan dan teknologi medis; (2) D-FARM UNJ — fokus pada smart food systems dan ketahanan pangan.'
                        ],
                        [
                            'q' => 'Siapa yang dapat mengikuti program?',
                            'a' => 'Program menyasar dosen, mahasiswa, peneliti, alumni, startup, profesional, dan pelaku industri sesuai karakteristik masing-masing program.'
                        ],
                        [
                            'q' => 'Apakah harus sudah memiliki produk?',
                            'a' => 'Tidak selalu. Tahapan seleksi menerima produk yang sudah berjalan maupun ide inovasi baru untuk dipresentasikan pada seleksi substansi.'
                        ],
                        [
                            'q' => 'Berapa jumlah anggota dalam satu tim?',
                            'a' => 'Pendaftaran akun awal mensyaratkan minimal 1 ketua dan 2 peserta/anggota. Untuk tahapan pelaksanaan hackathon/bootcamp lanjutan disyaratkan tim minimal berjumlah 5 orang.'
                        ],
                        [
                            'q' => 'Apakah challenge boleh berasal dari ide sendiri?',
                            'a' => 'Peserta memilih dan mengembangkan solusi berdasarkan challenge/problem statement dari mitra. Ide dan pendekatan teknologinya dapat dikembangkan secara bebas dan kreatif oleh tim sesuai kebutuhan challenge tersebut.'
                        ],
                        [
                            'q' => 'Teknologi apa yang dapat digunakan?',
                            'a' => 'Tergantung challenge yang dipilih. Contohnya meliputi AI, IoT/IoMT, sensor, biosensor, computer vision, embedded system, wearable technology, precision agriculture, biotechnology, dan teknologi pengolahan.'
                        ],
                        [
                            'q' => 'Apakah setelah hackathon program selesai?',
                            'a' => 'Tidak. Inovasi terbaik memperoleh pendampingan lanjutan yang dapat mencakup validasi, peningkatan TKT, HKI/Paten, regulasi, model bisnis, business matching, hingga implementasi/pilot sesuai kebutuhan dan kesiapan inovasi.'
                        ],
                        [
                            'q' => 'Kapan pendaftaran dibuka?',
                            'a' => 'Dalam rencana kegiatan, pendaftaran dan seleksi peserta berada pada November 2026, setelah sosialisasi pada Oktober 2026. Detail tanggal harian akan mengikuti pengumuman resmi penyelenggara melalui portal ini.'
                        ],
                        [
                            'q' => 'Apakah kegiatan hanya untuk bidang kesehatan dan pangan?',
                            'a' => 'Untuk edisi holding program 2026 ini, dua jalur strategis yang disiapkan adalah D-MARC (Kesehatan & Alat Medis) dan D-FARM (Pangan & Ketahanan Pangan).'
                        ],
                    ];
                @endphp

                @foreach($faqs as $i => $faq)
                    <div>
                        <button type="button" 
                                @click="active === {{ $i }} ? active = null : active = {{ $i }}"
                                class="flex w-full items-center justify-between p-5 text-left font-black text-gray-950 hover:bg-gray-50 transition"
                                :aria-expanded="(active === {{ $i }}).toString()">
                            <span class="text-base sm:text-lg">{{ $i + 1 }}. {{ $faq['q'] }}</span>
                            <span class="ml-4 text-xl font-black text-emerald-700" x-text="active === {{ $i }} ? '−' : '+'">+</span>
                        </button>
                        <div x-show="active === {{ $i }}" x-cloak class="border-t border-gray-200 bg-gray-50 p-5 text-sm sm:text-base leading-relaxed text-gray-700">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
@endsection

