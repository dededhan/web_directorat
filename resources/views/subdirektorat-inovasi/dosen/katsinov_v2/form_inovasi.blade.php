@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Form Judul Inovasi</h1>
                <p class="mt-2 text-sm text-gray-600">{{ $katsinov->title }}</p>
            </div>
            <a href="{{ route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov->id) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <form id="form-inovasi" action="{{ route('subdirektorat-inovasi.dosen.katsinov-v2.form-inovasi.store', $katsinov->id) }}" method="POST">
            @csrf

            {{-- Section 1: Informasi Inovasi --}}
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    1. Informasi Inovasi
                </h2>
            </div>
            <div class="p-6 mb-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Inovasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ $inovasi->title ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan judul inovasi">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sub Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="sub_title" value="{{ $inovasi->sub_title ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan sub judul inovasi">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pendahuluan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="introduction" rows="5" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan latar belakang dan tujuan inovasi...">{{ $inovasi->introduction ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Jelaskan latar belakang, permasalahan, dan tujuan inovasi</p>
                    </div>
                </div>
            </div>

            {{-- Section 2: Produk & Teknologi --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    2. Produk & Teknologi
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Produk Teknologi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="tech_product" rows="5" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Deskripsikan produk atau teknologi yang dikembangkan...">{{ $inovasi->tech_product ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Jelaskan secara detail produk atau teknologi yang dihasilkan</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Keunggulan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="supremacy" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan keunggulan dan nilai tambah inovasi...">{{ $inovasi->supremacy ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Apa yang membedakan inovasi ini dengan yang sudah ada?</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Paten/HKI <span class="text-red-500">*</span>
                        </label>
                        <textarea name="patent" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan status paten atau HKI...">{{ $inovasi->patent ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Apakah sudah dipatenkan? Atau dalam proses?</p>
                    </div>
                </div>
            </div>

                </div>
            </div>
            </div>

            {{-- Section 3: Kesiapan --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    3. Tingkat Kesiapan
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kesiapan Teknologi (TRL) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="tech_preparation" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan tingkat kesiapan teknologi...">{{ $inovasi->tech_preparation ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Level 1-9, sejauh mana teknologi sudah matang?</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kesiapan Pasar (MRL) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="market_preparation" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan tingkat kesiapan pasar...">{{ $inovasi->market_preparation ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Apakah sudah ada pasar atau calon pengguna?</p>
                    </div>
                </div>
            </div>

                </div>
            </div>
            </div>

            {{-- Section 4: Kontak Person --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    4. Kontak Person
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ $inovasi->name ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Nama penanggung jawab">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ $inovasi->email ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="email@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" value="{{ $inovasi->phone ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="08XXXXXXXXXX">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Mobile/HP <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="mobile" value="{{ $inovasi->mobile ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="08XXXXXXXXXX">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fax <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="fax" value="{{ $inovasi->fax ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="021-XXXXXXX">
                    </div>
                </div>
            </div>

                </div>
            </div>
            </div>


        </form>
    </div>

    {{-- Floating Action Buttons --}}
    <div class="fixed bottom-6 right-6 flex gap-3 z-50">
        <button type="submit" form="form-inovasi" name="save_as_draft" value="1"
                class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-lg text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-all hover:scale-105">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
            </svg>
            Simpan Draft
        </button>
        
        <button type="submit" form="form-inovasi"
                class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:scale-105">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan & Selesai
        </button>
    </div>
</div>
</div>


@endsection


