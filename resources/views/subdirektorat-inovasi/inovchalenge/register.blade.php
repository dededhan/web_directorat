<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | UNJ Innovative Challenge</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }
    </style>
</head>
@include('layout.navbar_hilirisasi')

<body>

    <div class="min-h-screen flex items-center justify-center py-12 px-4" style="margin-top: 80px;">
        <div class="w-full max-w-lg">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4"
                    style="background: linear-gradient(135deg, #277177, #1d5559);">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Daftar Akun</h1>
                <p class="text-gray-500 mt-2">Buat akun untuk berpartisipasi di UNJ Innovative Challenge</p>
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-start gap-3">
                    <i class="fas fa-check-circle mt-0.5 text-green-500"></i>
                    <div>
                        <p class="font-semibold">Pendaftaran Berhasil!</p>
                        <p class="text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Error summary --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
                    <p class="font-semibold mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> Terdapat kesalahan:
                    </p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Registration Form --}}
            <form action="{{ route('inovchalenge.register.submit') }}" method="POST"
                class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 space-y-6" x-data="{ selectedRole: '{{ old('role', '') }}' }">
                @csrf

                {{-- Role Selection --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-id-badge mr-1 text-teal-600"></i> Pilih Role
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ([
        'alumni' => ['label' => 'Alumni', 'icon' => 'fa-user-graduate'],
        'peneliti' => ['label' => 'Peneliti', 'icon' => 'fa-microscope'],
        'dudi' => ['label' => 'DUDI', 'icon' => 'fa-building'],
        'pppk' => ['label' => 'PPPK', 'icon' => 'fa-user-tie'],
        'mahasiswa' => ['label' => 'Mahasiswa', 'icon' => 'fa-graduation-cap'],
    ] as $value => $info)
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="{{ $value }}" class="hidden peer"
                                    x-model="selectedRole" {{ old('role') === $value ? 'checked' : '' }}>
                                <div
                                    class="flex flex-col items-center justify-center p-4 rounded-lg border-2 border-gray-200 transition-all duration-200
                                        peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:shadow-md
                                        hover:border-teal-300 hover:bg-gray-50">
                                    <i class="fas {{ $info['icon'] }} text-2xl mb-2 text-gray-400 peer-checked:text-teal-600"
                                        :class="selectedRole === '{{ $value }}' ? 'text-teal-600' : 'text-gray-400'"></i>
                                    <span class="text-sm font-medium"
                                        :class="selectedRole === '{{ $value }}' ? 'text-teal-700' : 'text-gray-600'">{{ $info['label'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('role')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-user mr-1 text-teal-600"></i> Nama Lengkap
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-envelope mr-1 text-teal-600"></i> Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                        placeholder="contoh@email.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1 text-teal-600"></i> Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors pr-12"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1 text-teal-600"></i> Konfirmasi Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors pr-12"
                            placeholder="Ulangi password" required>
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-3 px-6 rounded-lg text-white font-semibold text-base transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, #277177, #1d5559);">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Pendaftaran
                </button>

                {{-- Login link --}}
                <p class="text-center text-sm text-gray-500 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('subdirektorat-inovasi.inovation_chalangge.index') }}"
                        class="text-teal-600 font-semibold hover:underline">Kembali ke halaman utama</a>
                </p>
            </form>

            {{-- Info box --}}
            <div class="mt-6 p-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-sm">
                <p class="font-semibold mb-1"><i class="fas fa-info-circle mr-1"></i> Informasi</p>
                <p>Setelah mendaftar, akun Anda akan ditinjau oleh admin. Anda akan dapat login setelah pendaftaran
                    disetujui.</p>
            </div>
        </div>
    </div>

</body>
@include('layout.footer')

</html>
