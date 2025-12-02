@extends('subdirektorat-inovasi.dosen.index')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<style>
    .tagify {
        --tags-border-color: #e5e7eb;
        --tag-bg: #ccfbf1;
        --tag-text-color: #115e59;
        border-width: 2px;
        border-radius: 0.75rem;
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        transition: all 0.2s;
    }
    .tagify:hover {
        --tags-border-color: #14b8a6;
    }
    .tagify.tagify--focus {
        --tags-border-color: #14b8a6;
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="proposalFormData()">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header & Breadcrumb --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.manage') }}" class="hover:text-teal-600">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.sesi') }}" class="hover:text-teal-600">Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Buat Proposal</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Buat Proposal Student Exchange</h1>
                    <p class="mt-2 text-gray-600">Sesi: <span class="font-semibold text-teal-600">{{ $sesi->nama_sesi }}</span></p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.sesi') }}" class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class='bx bx-arrow-back mr-2 text-lg'></i> Kembali
                </a>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0"><i class='bx bx-error-circle text-red-400 text-xl'></i></div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Terdapat Kesalahan</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.student_exchange.store', $sesi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            @csrf
            
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-edit mr-3 text-2xl'></i> Formulir Proposal
                </h2>
            </div>

            <div class="p-6 lg:p-8 space-y-8">
                
                {{-- Section 1: Informasi Dasar --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center border-b pb-3">
                        <i class='bx bx-info-circle text-teal-600 mr-2 text-xl'></i> Informasi Dasar Kegiatan
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_kegiatan" value="{{ old('judul_kegiatan') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Masukkan judul kegiatan pertukaran mahasiswa">
                        @error('judul_kegiatan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan Kegiatan <span class="text-red-500">*</span></label>
                        <textarea name="ringkasan_kegiatan" rows="5" required maxlength="300" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Tuliskan ringkasan kegiatan (maksimal 300 karakter)">{{ old('ringkasan_kegiatan') }}</textarea>
                        @error('ringkasan_kegiatan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SDGs Fokus --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SDGs Fokus</label>
                        <input type="hidden" name="sdgs_fokus" :value="JSON.stringify(selectedSdgsFokus)">
                        <div class="relative">
                            <div class="w-full bg-white border-2 border-gray-300 rounded-xl p-2 min-h-[50px] flex flex-wrap gap-2 items-center cursor-pointer" @click="sdgFokusDropdownOpen = !sdgFokusDropdownOpen">
                                <template x-for="(sdg, index) in selectedSdgsFokus" :key="index">
                                    <span class="flex items-center gap-1.5 bg-teal-100 text-teal-800 text-xs font-semibold px-2.5 py-1.5 rounded-md">
                                        <span x-text="'SDG ' + sdg"></span>
                                        <button type="button" @click.stop="removeSdgFokus(index)" class="text-teal-600 hover:text-teal-800 font-bold">&times;</button>
                                    </span>
                                </template>
                                <span x-show="selectedSdgsFokus.length === 0" class="text-gray-400 text-sm px-2">Pilih SDG Fokus...</span>
                            </div>
                            <div x-show="sdgFokusDropdownOpen" @click.away="sdgFokusDropdownOpen = false" x-transition class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-xl py-1 ring-1 ring-black ring-opacity-5 overflow-auto" style="display: none;">
                                <template x-for="sdg in [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]" :key="sdg">
                                    <a href="#" @click.prevent="selectSdgFokus(sdg)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" x-text="'SDG ' + sdg"></a>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- SDGs Pendukung --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SDGs Pendukung</label>
                        <input type="hidden" name="sdgs_pendukung" :value="JSON.stringify(selectedSdgsPendukung)">
                        <div class="relative">
                            <div class="w-full bg-white border-2 border-gray-300 rounded-xl p-2 min-h-[50px] flex flex-wrap gap-2 items-center cursor-pointer" @click="sdgPendukungDropdownOpen = !sdgPendukungDropdownOpen">
                                <template x-for="(sdg, index) in selectedSdgsPendukung" :key="index">
                                    <span class="flex items-center gap-1.5 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1.5 rounded-md">
                                        <span x-text="'SDG ' + sdg"></span>
                                        <button type="button" @click.stop="removeSdgPendukung(index)" class="text-blue-600 hover:text-blue-800 font-bold">&times;</button>
                                    </span>
                                </template>
                                <span x-show="selectedSdgsPendukung.length === 0" class="text-gray-400 text-sm px-2">Pilih SDG Pendukung...</span>
                            </div>
                            <div x-show="sdgPendukungDropdownOpen" @click.away="sdgPendukungDropdownOpen = false" x-transition class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-xl py-1 ring-1 ring-black ring-opacity-5 overflow-auto" style="display: none;">
                                <template x-for="sdg in [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]" :key="sdg">
                                    <a href="#" @click.prevent="selectSdgPendukung(sdg)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" x-text="'SDG ' + sdg"></a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kegiatan <span class="text-red-500">*</span></label>
                        <select name="jenis_kegiatan" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            <option value="">-- Pilih Jenis Kegiatan --</option>
                            <option value="inbound" {{ old('jenis_kegiatan') == 'inbound' ? 'selected' : '' }}>Inbound (Mahasiswa Asing ke UNJ)</option>
                            <option value="outbound" {{ old('jenis_kegiatan') == 'outbound' ? 'selected' : '' }}>Outbound (Mahasiswa UNJ ke Luar Negeri)</option>
                        </select>
                        @error('jenis_kegiatan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Peserta <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" min="1" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Jumlah mahasiswa peserta">
                            @error('jumlah_peserta')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">SKS <span class="text-red-500">*</span></label>
                            <input type="number" name="sks" value="{{ old('sks') }}" min="1" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Total SKS">
                            @error('sks')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Online</label>
                            <input type="date" name="tanggal_online" value="{{ old('tanggal_online') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            @error('tanggal_online')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Onsite</label>
                            <input type="date" name="tanggal_onsite" value="{{ old('tanggal_onsite') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            @error('tanggal_onsite')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Informasi Mitra --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center border-b pb-3">
                        <i class='bx bx-buildings text-teal-600 mr-2 text-xl'></i> Informasi Institusi Mitra
                    </h3>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_mitra" value="{{ old('nama_mitra') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Nama institusi mitra">
                        @error('nama_mitra')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Negara <span class="text-red-500">*</span></label>
                        <input type="text" name="negara" value="{{ old('negara') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Negara asal institusi">
                        @error('negara')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama PIC <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pic" value="{{ old('nama_pic') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Nama person in charge">
                        @error('nama_pic')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kontak PIC <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_kontak_pic" value="{{ old('nomor_kontak_pic') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="+62xxx">
                            @error('nomor_kontak_pic')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email PIC <span class="text-red-500">*</span></label>
                            <input type="email" name="email_pic" value="{{ old('email_pic') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="email@example.com">
                            @error('email_pic')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dokumen Kesediaan Mitra (PDF) <span class="text-red-500">*</span></label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class='bx bx-cloud-upload text-4xl text-gray-400 mb-2'></i>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                    <p class="text-xs text-gray-500">PDF (MAX. 10MB)</p>
                                </div>
                                <input type="file" name="kesediaan_mitra" accept=".pdf" required class="hidden" @change="handleFileUpload($event, 'kesediaan_mitra')">
                            </label>
                        </div>
                        <p x-show="uploadedFiles.kesediaan_mitra" class="text-sm text-green-600 mt-2 flex items-center">
                            <i class='bx bx-check-circle mr-1'></i>
                            <span x-text="'File: ' + uploadedFiles.kesediaan_mitra"></span>
                        </p>
                        @error('kesediaan_mitra')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Section 3: Tim Pelaksana --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class='bx bx-group text-teal-600 mr-2 text-xl'></i> Anggota Tim Pelaksana
                        </h3>
                        <button type="button" @click="addAnggota" class="inline-flex items-center px-3 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 transition-all">
                            <i class='bx bx-plus mr-1'></i> Tambah Anggota
                        </button>
                    </div>

                    <template x-for="(anggota, index) in anggotaList" :key="index">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-800" x-text="'Anggota ' + (index + 1)"></h4>
                                <button type="button" @click="removeAnggota(index)" x-show="anggotaList.length > 1" class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                    <i class='bx bx-trash mr-1'></i> Hapus
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Dosen <span class="text-red-500">*</span></label>
                                    <input type="text" :name="'anggota[' + index + '][nama_dosen]'" x-model="anggota.nama_dosen" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Nama lengkap">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIP</label>
                                    <input type="text" :name="'anggota[' + index + '][nip]'" x-model="anggota.nip" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="NIP">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fakultas</label>
                                    <input type="text" :name="'anggota[' + index + '][fakultas]'" x-model="anggota.fakultas" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Fakultas">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                                    <input type="text" :name="'anggota[' + index + '][prodi]'" x-model="anggota.prodi" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Program Studi">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Section 4: Dokumen Pendukung --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center border-b pb-3">
                        <i class='bx bx-file text-teal-600 mr-2 text-xl'></i> Dokumen Pendukung
                    </h3>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Nama Mahasiswa (PDF)</label>
                        <input type="file" name="nama_mahasiswa" accept=".pdf" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500" @change="handleFileUpload($event, 'nama_mahasiswa')">
                        <p x-show="uploadedFiles.nama_mahasiswa" class="text-sm text-green-600 mt-2 flex items-center">
                            <i class='bx bx-check-circle mr-1'></i>
                            <span x-text="'File: ' + uploadedFiles.nama_mahasiswa"></span>
                        </p>
                        @error('nama_mahasiswa')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Mata Kuliah (PDF)</label>
                        <input type="file" name="mata_kuliah" accept=".pdf" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500" @change="handleFileUpload($event, 'mata_kuliah')">
                        <p x-show="uploadedFiles.mata_kuliah" class="text-sm text-green-600 mt-2 flex items-center">
                            <i class='bx bx-check-circle mr-1'></i>
                            <span x-text="'File: ' + uploadedFiles.mata_kuliah"></span>
                        </p>
                        @error('mata_kuliah')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rencana Anggaran Biaya / RAB (PDF)</label>
                        <input type="file" name="rab" accept=".pdf" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500" @change="handleFileUpload($event, 'rab')">
                        <p x-show="uploadedFiles.rab" class="text-sm text-green-600 mt-2 flex items-center">
                            <i class='bx bx-check-circle mr-1'></i>
                            <span x-text="'File: ' + uploadedFiles.rab"></span>
                        </p>
                        @error('rab')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 focus:ring-4 focus:ring-teal-200 transition-all shadow-lg">
                        <i class='bx bx-save mr-2 text-lg'></i>
                        Simpan Sebagai Draft
                    </button>
                    <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.sesi') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                        <i class='bx bx-x mr-2 text-lg'></i>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
    function proposalFormData() {
        return {
            selectedSdgsFokus: [],
            selectedSdgsPendukung: [],
            sdgFokusDropdownOpen: false,
            sdgPendukungDropdownOpen: false,
            anggotaList: [{ nama_dosen: '', nip: '', fakultas: '', prodi: '' }],
            uploadedFiles: {
                kesediaan_mitra: '',
                nama_mahasiswa: '',
                mata_kuliah: '',
                rab: ''
            },
            
            selectSdgFokus(sdg) {
                if (!this.selectedSdgsFokus.includes(sdg)) {
                    this.selectedSdgsFokus.push(sdg);
                }
                this.sdgFokusDropdownOpen = false;
            },
            
            removeSdgFokus(index) {
                this.selectedSdgsFokus.splice(index, 1);
            },
            
            selectSdgPendukung(sdg) {
                if (!this.selectedSdgsPendukung.includes(sdg)) {
                    this.selectedSdgsPendukung.push(sdg);
                }
                this.sdgPendukungDropdownOpen = false;
            },
            
            removeSdgPendukung(index) {
                this.selectedSdgsPendukung.splice(index, 1);
            },
            
            addAnggota() {
                this.anggotaList.push({ nama_dosen: '', nip: '', fakultas: '', prodi: '' });
            },
            
            removeAnggota(index) {
                if (this.anggotaList.length > 1) {
                    this.anggotaList.splice(index, 1);
                }
            },
            
            handleFileUpload(event, fieldName) {
                const file = event.target.files[0];
                if (file) {
                    this.uploadedFiles[fieldName] = file.name;
                }
            }
        }
    }
</script>
@endpush
@endsection
