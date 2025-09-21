@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8" x-data="formIdentitasData()">

        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">
            <div class="space-y-2">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">
                    Formulir Usulan: Identitas Tim
                </h1>
                <p class="text-gray-600">
                    Anda mengajukan proposal untuk sesi: 
                    <span class="inline-flex items-center px-3 py-1 bg-sky-100 text-sky-800 font-semibold rounded-full text-sm">
                        <i class='bx bx-award mr-1'></i>
                        {{ $sesi->nama_sesi }}
                    </span>
                </p>
            </div>
            <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                <i class='bx bx-arrow-back mr-2 text-lg'></i>
                <span>Kembali ke Daftar Skema</span>
            </a>
        </div>

        {{-- Error Notification --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-500 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-red-800 mb-2">Terjadi Kesalahan dalam Pengisian Form</p>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <i class='bx bx-minus text-xs mt-1 mr-2 flex-shrink-0'></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.storeIdentitas', $sesi->id) }}" class="space-y-8">
            @csrf

            {{-- Team Leader Section --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-crown text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Ketua Tim Pengusul</h2>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        {{-- Name Field --}}
                        <div class="lg:col-span-1">
                            <label for="ketua_nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-user mr-1 text-blue-500'></i>
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <input id="ketua_nama" name="ketua[nama_lengkap]" 
                                       value="{{ old('ketua.nama_lengkap', $currentUser->name) }}" 
                                       class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                       readonly type="text">
                                <i class='bx bx-lock-alt absolute right-3 top-3 text-gray-400'></i>
                            </div>
                        </div>

                        {{-- NIP Field --}}
                        <div class="lg:col-span-1">
                            <label for="ketua_nip" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-id-card mr-1 text-green-500'></i>
                                NIP <span class="text-red-500">*</span>
                            </label>
                            <input id="ketua_nip" name="ketua[nik_nim_nip]" 
                                   value="{{ old('ketua.nik_nim_nip', $currentUser->nip ?? '') }}" 
                                   class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('ketua.nik_nim_nip') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                                   placeholder="Masukkan NIP Anda" type="text">
                            @error('ketua.nik_nim_nip') 
                                <p class="text-red-500 text-xs mt-2 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        {{-- Address Field --}}
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-map mr-1 text-purple-500'></i>
                                Alamat Jalan <span class="text-red-500">*</span>
                            </label>
                            <input name="ketua[alamat_jalan]" 
                                   value="{{ old('ketua.alamat_jalan') }}" 
                                   class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('ketua.alamat_jalan') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                                   placeholder="Contoh: Jl. Rawamangun Muka No. 1" type="text">
                            @error('ketua.alamat_jalan') 
                                <p class="text-red-500 text-xs mt-2 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        {{-- Location Selects --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:col-span-2">
                            
                            {{-- Province --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-location-plus mr-1 text-orange-500'></i>
                                    Provinsi
                                </label>
                                <select name="ketua[provinsi]" x-model="ketua.provinsi" 
                                        @change="ketua.kota = ''; ketua.kecamatan = ''; ketua.kelurahan = ''" 
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200">
                                    <option value="">Pilih Provinsi</option>
                                    <template x-for="prov in Object.keys(regions)" :key="prov">
                                        <option :value="prov" x-text="prov"></option>
                                    </template>
                                </select>
                            </div>

                            {{-- City --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-buildings mr-1 text-blue-500'></i>
                                    Kota/Kabupaten
                                </label>
                                <select name="ketua[kota_kabupaten]" x-model="ketua.kota" 
                                        @change="ketua.kecamatan = ''; ketua.kelurahan = ''" 
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                        :disabled="!ketua.provinsi">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    <template x-if="ketua.provinsi">
                                        <template x-for="kota in Object.keys(regions[ketua.provinsi])" :key="kota">
                                            <option :value="kota" x-text="kota"></option>
                                        </template>
                                    </template>
                                </select>
                            </div>

                            {{-- District --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-navigation mr-1 text-indigo-500'></i>
                                    Kecamatan
                                </label>
                                <select name="ketua[kecamatan]" x-model="ketua.kecamatan" 
                                        @change="ketua.kelurahan = ''" 
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                        :disabled="!ketua.kota">
                                     <option value="">Pilih Kecamatan</option>
                                     <template x-if="ketua.kota">
                                        <template x-for="kec in Object.keys(regions[ketua.provinsi][ketua.kota])" :key="kec">
                                            <option :value="kec" x-text="kec"></option>
                                        </template>
                                     </template>
                                </select>
                            </div>

                            {{-- Village --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-home mr-1 text-pink-500'></i>
                                    Kelurahan
                                </label>
                                <select name="ketua[kelurahan]" x-model="ketua.kelurahan" 
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                        :disabled="!ketua.kecamatan">
                                    <option value="">Pilih Kelurahan</option>
                                    <template x-if="ketua.kecamatan">
                                        <template x-for="kel in regions[ketua.provinsi][ketua.kota][ketua.kecamatan]" :key="kel">
                                            <option :value="kel" x-text="kel"></option>
                                        </template>
                                    </template>
                                </select>
                            </div>
                        </div>

                        {{-- Postal Code --}}
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-mail-send mr-1 text-red-500'></i>
                                Kode Pos
                            </label>
                            <input name="ketua[kode_pos]" 
                                   value="{{ old('ketua.kode_pos') }}" 
                                   class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                   placeholder="Contoh: 12345" type="text">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Team Members Section --}}
            <div class="space-y-6">
                
                {{-- Section Header --}}
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <i class='bx bx-group text-2xl text-teal-600 mr-3'></i>
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Anggota Tim Pengusul</h2>
                            <p class="text-gray-600 text-sm mt-1">
                                Minimal {{ $sesi->min_anggota - 1 }} anggota, maksimal {{ $sesi->max_anggota - 1 }} anggota
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="addAnggota" x-show="anggota.length < maxAnggota" 
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-user-plus mr-2 text-lg'></i>
                        <span>Tambah Anggota</span>
                    </button>
                </div>

                {{-- Team Members List --}}
                <div class="space-y-6">
                    <template x-for="(item, index) in anggota" :key="index">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden relative animate-fade-in">
                            
                            {{-- Delete Button --}}
                            <button type="button" @click="removeAnggota(index)" x-show="anggota.length > minAnggota" 
                                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 hover:text-red-600 transition-all duration-200 flex items-center justify-center group">
                                <i class='bx bx-trash text-xl group-hover:scale-110 transition-transform duration-200'></i>
                            </button>

                            {{-- Member Header --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 lg:px-8 py-4 border-b border-blue-100">
                                <h3 class="text-lg font-bold text-blue-800 flex items-center" x-text="'Anggota Tim ' + (index + 1)">
                                </h3>
                            </div>
                            
                            {{-- Member Form Fields --}}
                            <div class="p-6 lg:p-8">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    
                                    {{-- Name --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class='bx bx-user mr-1 text-blue-500'></i>
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" :name="`anggota[${index}][nama_lengkap]`" x-model="item.nama_lengkap" 
                                               class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                               placeholder="Masukkan nama lengkap anggota">
                                    </div>

                                    {{-- NIK/NIM/NIP --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class='bx bx-id-card mr-1 text-green-500'></i>
                                            NIK/NIM/NIP <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" :name="`anggota[${index}][nik_nim_nip]`" x-model="item.nik_nim_nip" 
                                               class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                               placeholder="Masukkan NIK/NIM/NIP">
                                    </div>

                                    {{-- Address --}}
                                    <div class="lg:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class='bx bx-map mr-1 text-purple-500'></i>
                                            Alamat Jalan <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" :name="`anggota[${index}][alamat_jalan]`" x-model="item.alamat_jalan" 
                                               class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                               placeholder="Contoh: Jl. Rawamangun Muka No. 1">
                                    </div>

                                    {{-- Location Selects for Members --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:col-span-2">
                                        
                                        {{-- Province --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class='bx bx-location-plus mr-1 text-orange-500'></i>
                                                Provinsi
                                            </label>
                                            <select :name="`anggota[${index}][provinsi]`" x-model="item.provinsi" 
                                                    @change="item.kota = ''; item.kecamatan = ''; item.kelurahan = ''" 
                                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200">
                                                <option value="">Pilih Provinsi</option>
                                                <template x-for="prov in Object.keys(regions)" :key="prov">
                                                    <option :value="prov" x-text="prov"></option>
                                                </template>
                                            </select>
                                        </div>

                                        {{-- City --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class='bx bx-buildings mr-1 text-blue-500'></i>
                                                Kota/Kabupaten
                                            </label>
                                            <select :name="`anggota[${index}][kota_kabupaten]`" x-model="item.kota" 
                                                    @change="item.kecamatan = ''; item.kelurahan = ''" 
                                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                                    :disabled="!item.provinsi">
                                                <option value="">Pilih Kota/Kabupaten</option>
                                                <template x-if="item.provinsi">
                                                    <template x-for="kota in Object.keys(regions[item.provinsi])" :key="kota">
                                                        <option :value="kota" x-text="kota"></option>
                                                    </template>
                                                </template>
                                            </select>
                                        </div>

                                        {{-- District --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class='bx bx-navigation mr-1 text-indigo-500'></i>
                                                Kecamatan
                                            </label>
                                            <select :name="`anggota[${index}][kecamatan]`" x-model="item.kecamatan" 
                                                    @change="item.kelurahan = ''" 
                                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                                    :disabled="!item.kota">
                                                <option value="">Pilih Kecamatan</option>
                                                <template x-if="item.kota">
                                                    <template x-for="kec in Object.keys(regions[item.provinsi][item.kota])" :key="kec">
                                                        <option :value="kec" x-text="kec"></option>
                                                    </template>
                                                </template>
                                            </select>
                                        </div>

                                        {{-- Village --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class='bx bx-home mr-1 text-pink-500'></i>
                                                Kelurahan
                                            </label>
                                            <select :name="`anggota[${index}][kelurahan]`" x-model="item.kelurahan" 
                                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                                    :disabled="!item.kecamatan">
                                                <option value="">Pilih Kelurahan</option>
                                                <template x-if="item.kecamatan">
                                                    <template x-for="kel in regions[item.provinsi][item.kota][item.kecamatan]" :key="kel">
                                                        <option :value="kel" x-text="kel"></option>
                                                    </template>
                                                </template>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Postal Code --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class='bx bx-mail-send mr-1 text-red-500'></i>
                                            Kode Pos
                                        </label>
                                        <input type="text" :name="`anggota[${index}][kode_pos]`" x-model="item.kode_pos" 
                                               class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                               placeholder="Contoh: 12345">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- No Members Message --}}
                    <div x-show="anggota.length === 0" class="text-center py-12 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                        <i class='bx bx-user-plus text-6xl text-gray-300 mb-4'></i>
                        <h3 class="text-lg font-medium text-gray-500 mb-2">Belum Ada Anggota Tim</h3>
                        <p class="text-gray-400 text-sm mb-4">Klik tombol "Tambah Anggota" untuk menambahkan anggota tim</p>
                        <button type="button" @click="addAnggota" 
                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-user-plus mr-2'></i>
                            Tambah Anggota Pertama
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 lg:p-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center text-gray-600">
                        <i class='bx bx-info-circle mr-2 text-lg'></i>
                        <span class="text-sm">Pastikan semua data telah diisi dengan benar</span>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span>Simpan dan Lanjutkan</span>
                            <i class='bx bx-chevron-right ml-2 text-lg'></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
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
    select::-webkit-scrollbar {
        width: 8px;
    }
    select::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    select::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    select::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    input:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    select:disabled {
        background-color: #f8fafc;
        color: #94a3b8;
        cursor: not-allowed;
    }
    button:hover {
        transform: translateY(-1px);
    }
    .bg-white:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    function formIdentitasData() {
        return {
            ketua: { 
                provinsi: '{{ old('ketua.provinsi') }}', 
                kota: '{{ old('ketua.kota_kabupaten') }}', 
                kecamatan: '{{ old('ketua.kecamatan') }}', 
                kelurahan: '{{ old('ketua.kelurahan') }}'
            },
            anggota: @json(old('anggota', [])),
            regions: {
                'Banten': { 
                    'Kota Serang': { 
                        'Serang': ['Cipare', 'Cimuncang'], 
                        'Taktakan': ['Pancur', 'Sayar'] 
                    }, 
                    'Kota Tangerang': { 
                        'Cipondoh': ['Cipondoh', 'Poris Plawad'], 
                        'Karawaci': ['Karawaci', 'Nambo Jaya'] 
                    } 
                },
                'DKI Jakarta': { 
                    'Jakarta Pusat': { 
                        'Gambir': ['Gambir', 'Cideng'], 
                        'Tanah Abang': ['Bendungan Hilir', 'Karet Tengsin'] 
                    } 
                },
                'Jawa Barat': { 
                    'Kota Bandung': { 
                        'Coblong': ['Dago', 'Sekeloa'], 
                        'Sukasari': ['Gegerkalong', 'Sarijadi'] 
                    } 
                }
            },
            minAnggota: {{ $sesi->min_anggota > 1 ? $sesi->min_anggota - 1 : 0 }},
            maxAnggota: {{ $sesi->max_anggota > 1 ? $sesi->max_anggota - 1 : 0 }},
            
            addAnggota() {
                if (this.anggota.length < this.maxAnggota) {
                    this.anggota.push({ 
                        nama_lengkap: '', 
                        nik_nim_nip: '', 
                        alamat_jalan: '', 
                        provinsi: '', 
                        kota: '', 
                        kecamatan: '', 
                        kelurahan: '', 
                        kode_pos: '' 
                    });
                    
                    // Smooth scroll to the new member
                    this.$nextTick(() => {
                        const newMemberCard = document.querySelector('.animate-fade-in:last-child');
                        if (newMemberCard) {
                            newMemberCard.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'center' 
                            });
                        }
                    });
                }
            },
            
            removeAnggota(index) { 
                // Add confirmation dialog
                if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
                    this.anggota.splice(index, 1); 
                }
            },
            
            init() {
                // Initialize minimum members if needed
                if (@json(old('anggota')) === null && this.anggota.length === 0 && this.minAnggota > 0) {
                    for (let i = 0; i < this.minAnggota; i++) {
                        this.addAnggota();
                    }
                }

                // Add form validation
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', (e) => {
                        const requiredFields = form.querySelectorAll('input[required], select[required]');
                        let isValid = true;
                        
                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                field.classList.add('border-red-500');
                                isValid = false;
                            } else {
                                field.classList.remove('border-red-500');
                            }
                        });
                        
                        if (!isValid) {
                            e.preventDefault();
                            alert('Mohon lengkapi semua field yang wajib diisi');
                            // Scroll to first invalid field
                            const firstInvalid = form.querySelector('.border-red-500');
                            if (firstInvalid) {
                                firstInvalid.scrollIntoView({ 
                                    behavior: 'smooth', 
                                    block: 'center' 
                                });
                                firstInvalid.focus();
                            }
                        }
                    });
                }
            }
        }
    }
</script>
@endpush
@endsection