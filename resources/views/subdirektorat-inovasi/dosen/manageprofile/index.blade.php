@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8" 
         x-data="profileForm()">

        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" 
                       class="inline-flex items-center text-gray-500 hover:text-teal-600 transition-colors duration-200">
                        <i class='bx bx-home mr-2 text-lg'></i>
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class='bx bx-chevron-right text-gray-400 mx-1'></i>
                        <span class="font-medium text-gray-700">Manajemen Profil</span>
                    </div>
                </li>
            </ol>
        </nav>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                 class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><i class='bx bxs-check-circle text-2xl mr-3'></i></div>
                    <div>
                        <p class="font-bold">Sukses</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto">
                        <button @click="show = false" class="text-green-600 hover:text-green-800">
                            <i class='bx bx-x text-xl'></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-8">
            <div class="text-center lg:text-left">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-3">
                    Pengaturan Akun
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto lg:mx-0">
                    Perbarui informasi profil dan detail akun Anda
                </p>
            </div>
        </div>

        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class='bx bx-info-circle text-blue-500 text-xl mr-3 mt-0.5'></i>
                <div>
                    <p class="text-blue-700 font-medium text-sm">Informasi Penting</p>
                    <p class="text-blue-600 text-sm">
                        <span class="text-red-500 font-bold">*</span> menunjukkan kolom yang wajib diisi
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-8">
                <div class="text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-white mb-2">Informasi Profil</h2>
                    <p class="text-teal-100 text-sm">
                        Lengkapi dan perbarui informasi profil Anda
                    </p>
                </div>
            </div>

            <div class="p-6 lg:p-8">
                <form action="{{ route('subdirektorat-inovasi.dosen.manageprofile.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                            <div class="flex items-center">
                                <i class='bx bx-user text-white text-2xl mr-3'></i>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Informasi Pribadi</h3>
                                    <p class="text-blue-100 text-sm">Detail dasar dan kontak Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                                <div class="mb-6">
                                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-user text-blue-500 mr-2'></i>
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                               class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 bg-red-50 @enderror"
                                               placeholder="Masukkan nama lengkap Anda" required>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('name') text-red-500 @enderror">
                                            <i class='bx bx-user'></i>
                                        </div>
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="email" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-envelope text-blue-500 mr-2'></i>
                                        Alamat Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                               class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('email') border-red-500 bg-red-50 @enderror"
                                               placeholder="contoh@unj.ac.id" required>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('email') text-red-500 @enderror">
                                            <i class='bx bx-envelope'></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="lg:hidden space-y-6">
                                <div class="mb-6">
                                    <label for="name_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-user text-blue-500 mr-2'></i>
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <input type="text" id="name_mobile" name="name" value="{{ old('name', $user->name) }}"
                                               class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 bg-red-50 @enderror"
                                               placeholder="Masukkan nama lengkap Anda" required>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('name') text-red-500 @enderror">
                                            <i class='bx bx-user'></i>
                                        </div>
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="email_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-envelope text-blue-500 mr-2'></i>
                                        Alamat Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <input type="email" id="email_mobile" name="email" value="{{ old('email', $user->email) }}"
                                               class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('email') border-red-500 bg-red-50 @enderror"
                                               placeholder="contoh@unj.ac.id" required>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('email') text-red-500 @enderror">
                                            <i class='bx bx-envelope'></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <div class="flex items-center">
                                <i class='bx bx-id-card text-white text-2xl mr-3'></i>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Profil Dosen</h3>
                                    <p class="text-purple-100 text-sm">Informasi terkait identitas kedosenan Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                                <div class="lg:col-span-2 mb-6">
                                    <label for="identifier_number" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-id-card text-purple-500 mr-2'></i>
                                        NIP / NIDN <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <input type="text" id="identifier_number" name="identifier_number" 
                                               value="{{ old('identifier_number', $user->profile?->identifier_number) }}"
                                               class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('identifier_number') border-red-500 bg-red-50 @enderror"
                                               placeholder="Masukkan NIP atau NIDN" required>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('identifier_number') text-red-500 @enderror">
                                            <i class='bx bx-id-card'></i>
                                        </div>
                                    </div>
                                    @error('identifier_number')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="fakultas" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-buildings text-purple-500 mr-2'></i>
                                        Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <select id="fakultas" name="fakultas_id" class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm text-gray-900 text-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 cursor-pointer @error('fakultas_id') border-red-500 bg-red-50 @enderror" 
                                                @change="fetchProdi($event.target.value)" required>
                                            <option value="">Pilih Fakultas</option>
                                            @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}" {{ $selectedFakultasId == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('fakultas_id') text-red-500 @enderror">
                                            <i class='bx bx-buildings'></i>
                                        </div>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('fakultas_id') text-red-500 @enderror">
                                            <i class='bx bx-chevron-down'></i>
                                        </div>
                                    </div>
                                    @error('fakultas_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="prodi" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-book text-purple-500 mr-2'></i>
                                        Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <select id="prodi" name="prodi_id" class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm text-gray-900 text-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 cursor-pointer disabled:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60 disabled:text-gray-500 @error('prodi_id') border-red-500 bg-red-50 @enderror" 
                                                :disabled="loading" required>
                                            <option x-text="loading ? 'Memuat...' : (prodiOptions.length === 0 ? 'Pilih fakultas terlebih dahulu' : 'Pilih Program Studi')"></option>
                                            <template x-for="p in prodiOptions" :key="p.id">
                                                <option :value="p.id" :selected="p.id == selectedProdiId" x-text="p.name"></option>
                                            </template>
                                        </select>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('prodi_id') text-red-500 @enderror"
                                             :class="loading ? 'text-gray-300' : ''">
                                            <i class='bx bx-book'></i>
                                        </div>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('prodi_id') text-red-500 @enderror"
                                             :class="loading ? 'text-gray-300' : ''">
                                            <i class='bx bx-chevron-down'></i>
                                        </div>
                                    </div>
                                    @error('prodi_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="lg:hidden space-y-6">
                                <div class="mb-6">
                                    <label for="identifier_number_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-id-card text-purple-500 mr-2'></i>
                                        NIP / NIDN <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <input type="text" id="identifier_number_mobile" name="identifier_number" 
                                               value="{{ old('identifier_number', $user->profile?->identifier_number) }}"
                                               class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('identifier_number') border-red-500 bg-red-50 @enderror"
                                               placeholder="Masukkan NIP atau NIDN" required>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('identifier_number') text-red-500 @enderror">
                                            <i class='bx bx-id-card'></i>
                                        </div>
                                    </div>
                                    @error('identifier_number')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="fakultas_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-buildings text-purple-500 mr-2'></i>
                                        Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <select id="fakultas_mobile" name="fakultas_id" class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm text-gray-900 text-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 cursor-pointer @error('fakultas_id') border-red-500 bg-red-50 @enderror" 
                                                @change="fetchProdi($event.target.value)" required>
                                            <option value="">Pilih Fakultas</option>
                                            @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}" {{ $selectedFakultasId == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('fakultas_id') text-red-500 @enderror">
                                            <i class='bx bx-buildings'></i>
                                        </div>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('fakultas_id') text-red-500 @enderror">
                                            <i class='bx bx-chevron-down'></i>
                                        </div>
                                    </div>
                                    @error('fakultas_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="prodi_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-book text-purple-500 mr-2'></i>
                                        Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <select id="prodi_mobile" name="prodi_id" class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm text-gray-900 text-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 cursor-pointer disabled:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60 disabled:text-gray-500 @error('prodi_id') border-red-500 bg-red-50 @enderror" 
                                                :disabled="loading" required>
                                            <option x-text="loading ? 'Memuat...' : (prodiOptions.length === 0 ? 'Pilih fakultas terlebih dahulu' : 'Pilih Program Studi')"></option>
                                            <template x-for="p in prodiOptions" :key="p.id">
                                                <option :value="p.id" :selected="p.id == selectedProdiId" x-text="p.name"></option>
                                            </template>
                                        </select>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('prodi_id') text-red-500 @enderror"
                                             :class="loading ? 'text-gray-300' : ''">
                                            <i class='bx bx-book'></i>
                                        </div>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('prodi_id') text-red-500 @enderror"
                                             :class="loading ? 'text-gray-300' : ''">
                                            <i class='bx bx-chevron-down'></i>
                                        </div>
                                    </div>
                                    @error('prodi_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl border border-orange-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                            <div class="flex items-center">
                                <i class='bx bx-lock text-white text-2xl mr-3'></i>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Ubah Password</h3>
                                    <p class="text-orange-100 text-sm">Kosongkan jika Anda tidak ingin mengubah password</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                                <div class="mb-6" x-data="{ showPassword: false }">
                                    <label for="password" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-lock text-orange-500 mr-2'></i>
                                        Password Baru
                                    </label>
                                    <div class="relative group">
                                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                               class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('password') border-red-500 bg-red-50 @enderror"
                                               placeholder="Masukkan password baru">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('password') text-red-500 @enderror">
                                            <i class='bx bx-lock'></i>
                                        </div>
                                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:text-teal-500 p-1 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50" @click="showPassword = !showPassword">
                                            <i :class="showPassword ? 'bx bx-hide' : 'bx bx-show'"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6" x-data="{ showPassword: false }">
                                    <label for="password_confirmation" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-lock-alt text-orange-500 mr-2'></i>
                                        Konfirmasi Password Baru
                                    </label>
                                    <div class="relative group">
                                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" 
                                               class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="Ketik ulang password baru">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                                            <i class='bx bx-lock-alt'></i>
                                        </div>
                                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:text-teal-500 p-1 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50" @click="showPassword = !showPassword">
                                            <i :class="showPassword ? 'bx bx-hide' : 'bx bx-show'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:hidden space-y-6">
                                <div class="mb-6" x-data="{ showPassword: false }">
                                    <label for="password_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-lock text-orange-500 mr-2'></i>
                                        Password Baru
                                    </label>
                                    <div class="relative group">
                                        <input :type="showPassword ? 'text' : 'password'" id="password_mobile" name="password"
                                               class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('password') border-red-500 bg-red-50 @enderror"
                                               placeholder="Masukkan password baru">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none @error('password') text-red-500 @enderror">
                                            <i class='bx bx-lock'></i>
                                        </div>
                                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:text-teal-500 p-1 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50" @click="showPassword = !showPassword">
                                            <i :class="showPassword ? 'bx bx-hide' : 'bx bx-show'"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-6" x-data="{ showPassword: false }">
                                    <label for="password_confirmation_mobile" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <i class='bx bx-lock-alt text-orange-500 mr-2'></i>
                                        Konfirmasi Password Baru
                                    </label>
                                    <div class="relative group">
                                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation_mobile" name="password_confirmation" 
                                               class="block w-full pl-12 pr-12 py-4 bg-white border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 text-gray-900 text-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="Ketik ulang password baru">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                                            <i class='bx bx-lock-alt'></i>
                                        </div>
                                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:text-teal-500 p-1 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50" @click="showPassword = !showPassword">
                                            <i :class="showPassword ? 'bx bx-hide' : 'bx bx-show'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl border border-gray-200 p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                            <div class="text-center sm:text-left">
                                <p class="text-sm text-gray-600">
                                    Pastikan semua informasi yang Anda masukkan sudah benar sebelum menyimpan perubahan.
                                </p>
                            </div>
                            <button type="submit"
                                    class="inline-flex justify-center items-center py-4 px-8 border border-transparent shadow-lg text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 hover:shadow-xl w-full sm:w-auto">
                                <i class='bx bx-save mr-2 text-lg'></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function profileForm() {
        return {
            loading: false,
            prodiOptions: @json($prodi),
            selectedFakultasId: '{{ $selectedFakultasId }}',
            selectedProdiId: '{{ $selectedProdiId }}',
            
            async fetchProdi(fakultasId) {
                this.prodiOptions = [];
                if (!fakultasId) return;

                this.loading = true;
                try {
                    const response = await fetch(`/api/prodi/${fakultasId}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    this.prodiOptions = data;
                } catch (error) {
                    console.error('Error fetching prodi:', error);
                    alert('Gagal memuat data program studi. Silakan coba lagi.');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endpush