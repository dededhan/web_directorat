@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" 
               class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Form Judul Inovasi</h1>
                <p class="text-gray-600 mt-1">{{ $katsinov->title }}</p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('admin_inovasi.katsinov-v2.form-inovasi.store', $katsinov->id) }}" method="POST">
            @csrf

            {{-- Section 1: Informasi Inovasi --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Inovasi
                </h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Inovasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ $inovasi->title ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan judul inovasi">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sub Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="sub_judul" value="{{ $inovasi->sub_title ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan sub judul inovasi">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pendahuluan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="pendahuluan" rows="5" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan latar belakang dan tujuan inovasi...">{{ $inovasi->introduction ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Jelaskan latar belakang, permasalahan, dan tujuan inovasi</p>
                    </div>
                </div>
            </div>

            {{-- Section 2: Produk & Teknologi --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Produk & Teknologi
                </h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Produk Teknologi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="produk_teknologi" rows="5" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Deskripsikan produk atau teknologi yang dikembangkan...">{{ $inovasi->tech_product ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Jelaskan secara detail produk atau teknologi yang dihasilkan</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Keunggulan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keunggulan" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan keunggulan dan nilai tambah inovasi...">{{ $inovasi->supremacy ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Apa yang membedakan inovasi ini dengan yang sudah ada?</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Paten/HKI <span class="text-red-500">*</span>
                        </label>
                        <textarea name="paten" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan status paten atau HKI...">{{ $inovasi->patent ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Apakah sudah dipatenkan? Atau dalam proses?</p>
                    </div>
                </div>
            </div>

            {{-- Section 3: Kesiapan --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tingkat Kesiapan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kesiapan Teknologi (TRL) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="kesiapan_teknologi" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan tingkat kesiapan teknologi...">{{ $inovasi->tech_preparation ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Level 1-9, sejauh mana teknologi sudah matang?</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kesiapan Pasar (MRL) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="kesiapan_pasar" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan tingkat kesiapan pasar...">{{ $inovasi->market_preparation ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Apakah sudah ada pasar atau calon pengguna?</p>
                    </div>
                </div>
            </div>

            {{-- Section 4: Kontak Person --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Kontak Person
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ $inovasi->name ?? '' }}" required
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

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" 
                   class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-300">
                    Kembali
                </a>
                
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    alert('{{ session("success") }}');
</script>
@endif

@if(session('error'))
<script>
    alert('{{ session("error") }}');
</script>
@endif
@endsection
