@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.fee_editor.list-sesi') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Fee Editor</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Formulir Pelaporan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Pelaporan Fee Editor</h1>
                    <p class="mt-2 text-gray-600 text-base">Anda mengajukan untuk sesi: <strong class="text-teal-700">{{ $session->nama_sesi }}</strong></p>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
                        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Form --}}
        <form action="{{ route('subdirektorat-inovasi.dosen.fee_editor.store', $session->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Informasi Jurnal & Peran --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-file-plus text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Informasi Jurnal & Peran Editorial</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Nama Jurnal --}}
                    <div>
                        <label for="nama_jurnal" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-book-content text-purple-500 mr-2'></i>
                            Nama Jurnal Q1 yang Dieditori <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" 
                               name="nama_jurnal" 
                               id="nama_jurnal" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="Masukkan nama jurnal Q1"
                               value="{{ old('nama_jurnal') }}">
                        @error('nama_jurnal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link ScimagoJR --}}
                    <div>
                        <label for="link_scimagojr" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-link-external text-green-500 mr-2'></i>
                            Link Scimagojr <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="url" 
                               name="link_scimagojr" 
                               id="link_scimagojr" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="https://www.scimagojr.com/..."
                               value="{{ old('link_scimagojr') }}">
                        @error('link_scimagojr')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Peran dalam Jurnal --}}
                    <div>
                        <label for="peran" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-user-check text-indigo-500 mr-2'></i>
                            Peran dalam Jurnal <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="peran" 
                                id="peran" 
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                            <option value="">Pilih Peran</option>
                            <option value="Editor-in-Chief" {{ old('peran') == 'Editor-in-Chief' ? 'selected' : '' }}>Editor-in-Chief</option>
                            <option value="Associate Editor" {{ old('peran') == 'Associate Editor' ? 'selected' : '' }}>Associate Editor</option>
                            <option value="Section Editor" {{ old('peran') == 'Section Editor' ? 'selected' : '' }}>Section Editor</option>
                            <option value="Editorial Board Member" {{ old('peran') == 'Editorial Board Member' ? 'selected' : '' }}>Editorial Board Member</option>
                        </select>
                        @error('peran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Periode Penugasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="penugasan_awal" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-calendar text-orange-500 mr-2'></i>
                                Tahun Awal Penugasan <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="number" 
                                   name="penugasan_awal" 
                                   id="penugasan_awal" 
                                   required 
                                   min="1900" 
                                   max="{{ date('Y') + 10 }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="2023"
                                   value="{{ old('penugasan_awal') }}">
                            @error('penugasan_awal')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="penugasan_akhir" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-calendar-check text-orange-500 mr-2'></i>
                                Tahun Akhir Penugasan <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="number" 
                                   name="penugasan_akhir" 
                                   id="penugasan_akhir" 
                                   required 
                                   min="1900" 
                                   max="{{ date('Y') + 10 }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="2025"
                                   value="{{ old('penugasan_akhir') }}">
                            @error('penugasan_akhir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Link Laman Resmi --}}
                    <div>
                        <label for="link_laman_resmi" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-link text-blue-500 mr-2'></i>
                            Tautan Laman Resmi Jurnal <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="url" 
                               name="link_laman_resmi" 
                               id="link_laman_resmi" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="https://..."
                               value="{{ old('link_laman_resmi') }}">
                        <p class="text-xs text-gray-500 mt-1">Link laman resmi jurnal yang mencantumkan nama Anda sebagai editor</p>
                        @error('link_laman_resmi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Dokumen Pendukung --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-cloud-upload text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Unggah Dokumen Pendukung</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Bukti Undangan --}}
                    <div>
                        <label for="bukti_undangan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-envelope text-blue-500 mr-2'></i>
                            Bukti Surat Undangan Menjadi Editor Jurnal <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="file" 
                               name="bukti_undangan" 
                               id="bukti_undangan" 
                               required 
                               accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Upload file PDF (Maks. 10MB)</p>
                        @error('bukti_undangan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bukti Aktivitas --}}
                    <div>
                        <label for="bukti_aktivitas" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-screenshot text-purple-500 mr-2'></i>
                            Bukti Aktivitas Editorial <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="file" 
                               name="bukti_aktivitas" 
                               id="bukti_aktivitas" 
                               required 
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Upload screenshot dashboard OJS/editorial system (PDF/JPG/PNG, Maks. 10MB)</p>
                        @error('bukti_aktivitas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('subdirektorat-inovasi.dosen.fee_editor.list-sesi') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class='bx bx-send mr-2 text-lg'></i>
                    Ajukan Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    input:focus,
    select:focus,
    textarea:focus {
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }
</style>
@endpush
