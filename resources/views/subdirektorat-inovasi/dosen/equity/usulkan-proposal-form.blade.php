@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="proposalFormData()">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Identitas Pengusul</h1>
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Home</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Usulkan Proposal</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium text-gray-700">Identitas Tim</span></li>
                </ol>
            </nav>
        </div>
        <a href="#" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
            <i class='bx bx-arrow-back mr-2'></i>
            <span>Kembali ke Daftar Skema</span>
        </a>
    </div>

    {{-- Form Ketua Tim --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200 mb-8">
        <div class="p-6 md:p-8">
            <div class="flex items-center gap-4 border-b border-slate-200 pb-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                    <i class='bx bxs-user-crown text-2xl'></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Ketua Tim Pengusul</h2>
                    <p class="text-gray-500 mt-1">Detail informasi ketua tim.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan Nama Lengkap"></div>
                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">NIK / NIM / NIP</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan NIK, NIM, atau NIP"></div>
                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">Alamat Jalan</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: Jl. Merdeka No. 10"></div>
                
                {{-- Dropdown Alamat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Provinsi</label>
                    <select x-model="ketua.provinsi" @change="ketua.kota = ''; ketua.kecamatan = ''; ketua.kelurahan = ''" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">Pilih Provinsi</option>
                        <template x-for="prov in Object.keys(regions)" :key="prov">
                            <option :value="prov" x-text="prov"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kota / Kabupaten</label>
                    <select x-model="ketua.kota" @change="ketua.kecamatan = ''; ketua.kelurahan = ''" :disabled="!ketua.provinsi" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <option value="">Pilih Kota/Kabupaten</option>
                        <template x-if="ketua.provinsi">
                            <template x-for="kota in Object.keys(regions[ketua.provinsi])" :key="kota">
                                <option :value="kota" x-text="kota"></option>
                            </template>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kecamatan</label>
                    <select x-model="ketua.kecamatan" @change="ketua.kelurahan = ''" :disabled="!ketua.kota" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <option value="">Pilih Kecamatan</option>
                        <template x-if="ketua.kota">
                            <template x-for="kec in Object.keys(regions[ketua.provinsi][ketua.kota])" :key="kec">
                                <option :value="kec" x-text="kec"></option>
                            </template>
                        </template>
                    </select>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kelurahan</label>
                    <select x-model="ketua.kelurahan" :disabled="!ketua.kecamatan" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <option value="">Pilih Kelurahan</option>
                         <template x-if="ketua.kecamatan">
                            <template x-for="kel in regions[ketua.provinsi][ketua.kota][ketua.kecamatan]" :key="kel">
                                <option :value="kel" x-text="kel"></option>
                            </template>
                        </template>
                    </select>
                </div>
                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">Kode Pos</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan Kode Pos"></div>
            </div>
        </div>
    </div>

    {{-- Form Anggota Tim --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Anggota Tim Pengusul</h2>
        <button @click="addAnggota" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg shadow-sm hover:bg-green-600 transition-colors duration-200 text-sm font-medium">
            <i class='bx bx-user-plus mr-2'></i>
            <span>Tambah Anggota</span>
        </button>
    </div>

    <template x-for="(anggotaItem, index) in anggota" :key="index">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200 mb-6 relative">
            <div class="p-6 md:p-8">
                 <button @click="removeAnggota(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition">
                    <i class='bx bx-trash text-xl'></i>
                </button>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center font-bold text-xl" x-text="index + 1"></div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800" x-text="'Anggota ' + (index + 1)"></h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan Nama Lengkap"></div>
                    <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">NIK / NIM / NIP</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan NIK, NIM, atau NIP"></div>
                    <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">Alamat Jalan</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: Jl. Merdeka No. 10"></div>
                    
                     {{-- Dropdown Alamat Anggota --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Provinsi</label>
                        <select x-model="anggotaItem.provinsi" @change="anggotaItem.kota = ''; anggotaItem.kecamatan = ''; anggotaItem.kelurahan = ''" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">Pilih Provinsi</option>
                            <template x-for="prov in Object.keys(regions)" :key="prov"><option :value="prov" x-text="prov"></option></template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kota / Kabupaten</label>
                        <select x-model="anggotaItem.kota" @change="anggotaItem.kecamatan = ''; anggotaItem.kelurahan = ''" :disabled="!anggotaItem.provinsi" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">Pilih Kota/Kabupaten</option>
                            <template x-if="anggotaItem.provinsi"><template x-for="kota in Object.keys(regions[anggotaItem.provinsi])" :key="kota"><option :value="kota" x-text="kota"></option></template></template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kecamatan</label>
                        <select x-model="anggotaItem.kecamatan" @change="anggotaItem.kelurahan = ''" :disabled="!anggotaItem.kota" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">Pilih Kecamatan</option>
                            <template x-if="anggotaItem.kota"><template x-for="kec in Object.keys(regions[anggotaItem.provinsi][anggotaItem.kota])" :key="kec"><option :value="kec" x-text="kec"></option></template></template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kelurahan</label>
                        <select x-model="anggotaItem.kelurahan" :disabled="!anggotaItem.kecamatan" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">Pilih Kelurahan</option>
                            <template x-if="anggotaItem.kecamatan"><template x-for="kel in regions[anggotaItem.provinsi][anggotaItem.kota][anggotaItem.kecamatan]" :key="kel"><option :value="kel" x-text="kel"></option></template></template>
                        </select>
                    </div>
                    <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600 mb-1">Kode Pos</label><input type="text" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan Kode Pos"></div>
                </div>
            </div>
        </div>
    </template>
    
    {{-- Tombol Aksi --}}
     <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
        <button type="button" class="px-5 py-2 bg-white border border-gray-300 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-sm">Batal</button>
        <button type="button" class="px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Simpan dan Lanjutkan
        </button>
    </div>
</div>

{{-- Memuat skrip langsung di sini untuk memastikan semuanya berjalan --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection

