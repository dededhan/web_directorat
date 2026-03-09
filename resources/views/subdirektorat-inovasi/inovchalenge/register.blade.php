<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | UNJ Innovative Challenge</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    @vite(['resources/css/app.css'])
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('fontawesome/all.min.js') }}" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .role-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .role-card:hover {
            transform: translateY(-2px);
        }

        .role-card.active {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(39, 113, 119, 0.3);
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(39, 113, 119, 0.15);
        }

        .btn-submit {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(39, 113, 119, 0.4);
        }

        .floating-shape {
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape-delay {
            animation: float 8s ease-in-out infinite;
            animation-delay: 2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Force circular icons regardless of Tailwind load status */
        .rounded-full {
            border-radius: 9999px !important;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        /* gradient backgrounds */
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        .from-\[\#1d5559\] {
            --tw-gradient-from: #1d5559;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(29, 85, 89, 0));
        }

        .to-\[\#2d8a8a\] {
            --tw-gradient-to: #2d8a8a;
        }

        .from-cyan-500 {
            --tw-gradient-from: #06b6d4;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(6, 182, 212, 0));
        }

        .to-cyan-600 {
            --tw-gradient-to: #0891b2;
        }

        .from-blue-500 {
            --tw-gradient-from: #3b82f6;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(59, 130, 246, 0));
        }

        .to-blue-600 {
            --tw-gradient-to: #2563eb;
        }

        .from-orange-500 {
            --tw-gradient-from: #f97316;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(249, 115, 22, 0));
        }

        .to-orange-600 {
            --tw-gradient-to: #ea580c;
        }

        .from-teal-500 {
            --tw-gradient-from: #14b8a6;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(20, 184, 166, 0));
        }

        .to-teal-600 {
            --tw-gradient-to: #0d9488;
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -2px rgba(0, 0, 0, .1);
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -4px rgba(0, 0, 0, .1);
        }

        .text-white {
            color: #fff !important;
        }
    </style>
</head>
@include('layout.navbar_hilirisasi')

<body class="bg-gray-50">

    <div class="min-h-screen relative overflow-hidden" style="margin-top: 70px;">
        {{-- Background decoration --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-teal-400/20 to-emerald-300/10 rounded-full blur-3xl floating-shape">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-blue-400/15 to-purple-300/10 rounded-full blur-3xl floating-shape-delay">
            </div>
            <div
                class="absolute top-1/3 left-1/4 w-64 h-64 bg-gradient-to-br from-teal-500/10 to-cyan-400/5 rounded-full blur-2xl">
            </div>
        </div>

        <div class="relative z-10 flex items-center justify-center py-10 px-4 sm:px-6">
            <div class="w-full max-w-5xl">

                {{-- Two-column layout --}}
                <div
                    class="flex flex-col lg:flex-row gap-0 bg-white rounded-3xl shadow-2xl shadow-gray-200/60 overflow-hidden border border-gray-100">

                    {{-- Left panel - Branding --}}
                    <div
                        class="lg:w-5/12 relative bg-gradient-to-br from-[#1d5559] via-[#277177] to-[#2d8a8a] hero-pattern p-8 lg:p-10 flex flex-col justify-between text-white">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/20">
                        </div>

                        <div class="relative z-10">
                            {{-- Logo --}}
                            <div class="flex items-center gap-3 mb-10">
                                <div
                                    class="w-12 h-12 bg-white/15 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20">
                                    <i class="fas fa-trophy text-xl text-yellow-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold leading-tight">Innovation</h3>
                                    <p class="text-teal-200 text-xs font-medium tracking-wider">CHALLENGE UNJ</p>
                                </div>
                            </div>

                            {{-- Heading --}}
                            <h1 class="text-3xl lg:text-4xl font-extrabold leading-tight mb-4">
                                Bergabung<br>
                                <span class="text-teal-200">Sekarang!</span>
                            </h1>
                            <p class="text-teal-100/90 text-sm leading-relaxed mb-8 max-w-xs">
                                Daftarkan diri Anda dan jadilah bagian dari ekosistem inovasi UNJ. Wujudkan ide kreatif
                                menjadi solusi nyata.
                            </p>

                            {{-- Feature list --}}
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-lightbulb text-yellow-300 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">Ajukan Inovasi</p>
                                        <p class="text-teal-200/80 text-xs">Submit proposal dan kembangkan ide bersama
                                            tim</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-users text-blue-300 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">Kolaborasi Tim</p>
                                        <p class="text-teal-200/80 text-xs">Bentuk tim lintas disiplin untuk hasil
                                            maksimal</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-award text-orange-300 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">Pendanaan & Mentoring</p>
                                        <p class="text-teal-200/80 text-xs">Dapatkan dukungan dana dan bimbingan ahli
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bottom decoration --}}
                        <div class="relative z-10 mt-10 hidden lg:block">
                            <div class="glass rounded-2xl p-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex -space-x-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-teal-400 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20">
                                            A</div>
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-400 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20">
                                            R</div>
                                        <div
                                            class="w-8 h-8 rounded-full bg-purple-400 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20">
                                            D</div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-white">Bergabung bersama inovator lainnya
                                        </p>
                                        <p class="text-[10px] text-teal-200/80">dan ciptakan dampak nyata</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right panel - Form --}}
                    <div class="lg:w-7/12 p-8 lg:p-10" x-data="registerForm()">

                        {{-- Mobile header --}}
                        <div class="lg:hidden text-center mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-[#1d5559] to-[#2d8a8a] rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                                <i class="fas fa-user-plus text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                            <p class="text-gray-500 text-sm mt-1">Isi formulir di bawah untuk mendaftar</p>
                        </div>

                        {{-- Desktop header --}}
                        <div class="hidden lg:block mb-8">
                            <div class="flex items-center gap-4 mb-1">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-[#1d5559] to-[#2d8a8a] rounded-full flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fas fa-user-plus text-white text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                                    <p class="text-gray-500 text-sm mt-0.5">Lengkapi data berikut untuk mendaftar di
                                        Innovation Challenge</p>
                                </div>
                            </div>
                        </div>

                        {{-- Success message --}}
                        @if (session('success'))
                            <div
                                class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 flex items-start gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-green-800 text-sm">Pendaftaran Berhasil!</p>
                                    <p class="text-xs text-green-600 mt-0.5">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Error summary --}}
                        @if ($errors->any())
                            <div
                                class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-red-50 to-rose-50 border border-red-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                                    <p class="font-bold text-red-700 text-sm">Terdapat kesalahan</p>
                                </div>
                                <ul class="list-disc list-inside text-xs text-red-600 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Registration Form --}}
                        <form action="{{ route('inovchalenge.register.submit') }}" method="POST" class="space-y-6">
                            @csrf

                            {{-- Step indicator --}}
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-7 h-7 rounded-full bg-[#277177] text-white flex items-center justify-center text-xs font-bold">
                                        <i class="fas fa-id-badge text-[10px]"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">Pilih Role</span>
                                </div>
                                <div class="flex-1 h-px bg-gray-200"></div>
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center"
                                        :class="selectedRole ? 'bg-[#277177] text-white' : 'bg-gray-200 text-gray-400'">
                                        <i class="fas fa-user-edit text-[10px]"></i>
                                    </div>
                                    <span class="text-xs font-semibold"
                                        :class="selectedRole ? 'text-gray-700' : 'text-gray-400'">Data Diri</span>
                                </div>
                            </div>

                            {{-- Role Selection --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                                    Daftar Sebagai
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    @foreach ([
        'dosen' => ['label' => 'Dosen', 'icon' => 'fa-chalkboard-teacher', 'color' => 'from-cyan-500 to-cyan-600'],
        'alumni' => ['label' => 'Alumni', 'icon' => 'fa-user-graduate', 'color' => 'from-blue-500 to-blue-600'],
        'dudi' => ['label' => 'DUDI', 'icon' => 'fa-building', 'color' => 'from-orange-500 to-orange-600'],
        'mahasiswa' => ['label' => 'Mahasiswa', 'icon' => 'fa-graduation-cap', 'color' => 'from-teal-500 to-teal-600'],
    ] as $value => $info)
                                        <label class="cursor-pointer role-card"
                                            :class="selectedRole === '{{ $value }}' ? 'active' : ''">
                                            <input type="radio" name="role" value="{{ $value }}"
                                                class="hidden peer" x-model="selectedRole"
                                                {{ old('role') === $value ? 'checked' : '' }}>
                                            <div class="relative flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl border-2 transition-all duration-300 text-center"
                                                :class="selectedRole === '{{ $value }}'
                                                    ?
                                                    'border-[#277177] bg-gradient-to-br from-teal-50 to-emerald-50 shadow-lg' :
                                                    'border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50'">
                                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center mb-2 transition-all duration-300"
                                                    :class="selectedRole === '{{ $value }}'
                                                        ?
                                                        'bg-gradient-to-br {{ $info['color'] }} shadow-md' :
                                                        'bg-gray-100'">
                                                    <i class="fas {{ $info['icon'] }} text-sm sm:text-base transition-colors duration-300"
                                                        :class="selectedRole === '{{ $value }}' ? 'text-white' :
                                                            'text-gray-400'"></i>
                                                </div>
                                                <span
                                                    class="text-[11px] sm:text-xs font-semibold transition-colors duration-300"
                                                    :class="selectedRole === '{{ $value }}' ? 'text-[#1d5559]' :
                                                        'text-gray-500'">{{ $info['label'] }}</span>
                                                {{-- Checkmark --}}
                                                <div x-show="selectedRole === '{{ $value }}'" x-transition
                                                    class="absolute -top-1 -right-1 w-5 h-5 bg-[#277177] rounded-full flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-check text-white text-[8px]"></i>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('role')
                                    <p class="text-red-500 text-xs mt-2"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Form fields (shown after role selection) --}}
                            <div x-show="selectedRole" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-1 translate-y-0" class="space-y-5">

                                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>

                                {{-- Nama Lengkap --}}
                                <div>
                                    <label for="name"
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                        Nama Lengkap <span class="text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-user text-sm"></i>
                                        </div>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name') }}"
                                            class="input-field w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:border-[#277177] focus:ring-0 transition-all bg-gray-50/50 focus:bg-white @error('name') border-red-300 @enderror"
                                            placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email"
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                        Email <span class="text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-envelope text-sm"></i>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email') }}"
                                            class="input-field w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:border-[#277177] focus:ring-0 transition-all bg-gray-50/50 focus:bg-white @error('email') border-red-300 @enderror"
                                            placeholder="contoh@email.com" required>
                                    </div>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Password grid --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    {{-- Password --}}
                                    <div>
                                        <label for="password"
                                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                            Password <span class="text-red-400">*</span>
                                        </label>
                                        <div class="relative" x-data="{ show: false }">
                                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                                <i class="fas fa-lock text-sm"></i>
                                            </div>
                                            <input :type="show ? 'text' : 'password'" id="password" name="password"
                                                class="input-field w-full pl-11 pr-11 py-3 border-2 border-gray-200 rounded-xl text-sm focus:border-[#277177] focus:ring-0 transition-all bg-gray-50/50 focus:bg-white @error('password') border-red-300 @enderror"
                                                placeholder="Min. 8 karakter" required>
                                            <button type="button" @click="show = !show"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-1">
                                                <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fas text-sm"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1"><i
                                                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Konfirmasi Password --}}
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                            Konfirmasi <span class="text-red-400">*</span>
                                        </label>
                                        <div class="relative" x-data="{ show: false }">
                                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                                <i class="fas fa-lock text-sm"></i>
                                            </div>
                                            <input :type="show ? 'text' : 'password'" id="password_confirmation"
                                                name="password_confirmation"
                                                class="input-field w-full pl-11 pr-11 py-3 border-2 border-gray-200 rounded-xl text-sm focus:border-[#277177] focus:ring-0 transition-all bg-gray-50/50 focus:bg-white"
                                                placeholder="Ulangi password" required>
                                            <button type="button" @click="show = !show"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-1">
                                                <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fas text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="pt-2">
                                    <button type="submit"
                                        class="btn-submit w-full py-3.5 px-6 rounded-xl text-white font-bold text-sm tracking-wide bg-gradient-to-r from-[#1d5559] via-[#277177] to-[#2d8a8a] shadow-lg flex items-center justify-center gap-2">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Kirim Pendaftaran</span>
                                    </button>
                                </div>

                                {{-- Login link --}}
                                <p class="text-center text-sm text-gray-500">
                                    Sudah punya akun?
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                        class="text-[#277177] font-semibold hover:underline hover:text-[#1d5559] transition-colors">Masuk
                                        di sini</a>
                                </p>
                            </div>

                            {{-- Placeholder when no role selected --}}
                            <div x-show="!selectedRole" class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-hand-pointer text-2xl text-gray-300"></i>
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Pilih role di atas untuk melanjutkan
                                    pendaftaran</p>
                            </div>
                        </form>

                        {{-- Info box --}}
                        <div
                            class="mt-6 p-4 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info text-blue-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-blue-800 text-xs">Informasi Penting</p>
                                <p class="text-[11px] text-blue-600/80 mt-0.5 leading-relaxed">Setelah mendaftar, akun
                                    Anda akan ditinjau oleh admin. Anda akan dapat login setelah pendaftaran disetujui.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} UNJ Innovation Challenge.
                    All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        function registerForm() {
            return {
                selectedRole: '{{ old('role', '') }}',
            }
        }
    </script>

</body>

</html>
