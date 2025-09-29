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
                        
                        {{-- PERUBAHAN 1: Input Nama Ketua tidak lagi readonly --}}
                        <div class="lg:col-span-1">
                            <label for="ketua_nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-user mr-1 text-blue-500'></i>
                                Nama Lengkap <span class="text-red-500">*</span> {{-- Tanda Wajib Ditambahkan --}}
                            </label>
                            <input id="ketua_nama" name="ketua[nama_lengkap]" 
                                   value="{{ old('ketua.nama_lengkap', $currentUser->name) }}" 
                                   class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('ketua.nama_lengkap') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                                   type="text" placeholder="Masukkan nama lengkap"> {{-- Atribut readonly dihapus & bg-gray-50 diubah --}}
                            @error('ketua.nama_lengkap')
                                <p class="text-red-500 text-xs mt-2 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- NIP Field --}}
                        <div class="lg:col-span-1">
                            <label for="ketua_nip" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-id-card mr-1 text-green-500'></i>
                                NIP <span class="text-red-500">*</span>
                            </label>
                            <input id="ketua_nip" name="ketua[nik_nim_nip]" 
                                   value="{{ old('ketua.nik_nim_nip', $currentUser->profile?->identifier_number ?? '') }}" 
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
                                Alamat Rumah <span class="text-red-500">*</span>
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

                        {{-- PERUBAHAN 2: Location Selects dinamis dari API --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:col-span-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-location-plus mr-1 text-orange-500'></i> Provinsi
                                </label>
                                <input type="hidden" name="ketua[provinsi]" :value="ketua.provinsiName">
                                <select x-model="ketua.provinsiId" @change="handleProvinsiChange(ketua, $event.target.value)" class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option value="">Pilih Provinsi</option>
                                    <template x-for="prov in provinces" :key="prov.id">
                                        <option :value="prov.id" x-text="prov.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-buildings mr-1 text-blue-500'></i> Kota/Kabupaten
                                </label>
                                <input type="hidden" name="ketua[kota_kabupaten]" :value="ketua.kotaName">
                                <select x-model="ketua.kotaId" @change="handleKotaChange(ketua, $event.target.value)" :disabled="!ketua.provinsiId || ketua.loadingKota" class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option x-text="ketua.loadingKota ? 'Memuat...' : 'Pilih Kota/Kabupaten'" value=""></option>
                                    <template x-for="kota in ketua.listKota" :key="kota.id">
                                        <option :value="kota.id" x-text="kota.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-navigation mr-1 text-indigo-500'></i> Kecamatan
                                </label>
                                <input type="hidden" name="ketua[kecamatan]" :value="ketua.kecamatanName">
                                <select x-model="ketua.kecamatanId" @change="handleKecamatanChange(ketua, $event.target.value)" :disabled="!ketua.kotaId || ketua.loadingKecamatan" class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option x-text="ketua.loadingKecamatan ? 'Memuat...' : 'Pilih Kecamatan'" value=""></option>
                                    <template x-for="kec in ketua.listKecamatan" :key="kec.id">
                                        <option :value="kec.id" x-text="kec.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-home mr-1 text-pink-500'></i> Kelurahan
                                </label>
                                <input type="hidden" name="ketua[kelurahan]" :value="ketua.kelurahanName">
                                <select x-model="ketua.kelurahanId" @change="ketua.kelurahanName = $event.target.options[$event.target.selectedIndex].text" :disabled="!ketua.kecamatanId || ketua.loadingKelurahan" class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option x-text="ketua.loadingKelurahan ? 'Memuat...' : 'Pilih Kelurahan'" value=""></option>
                                    <template x-for="kel in ketua.listKelurahan" :key="kel.id">
                                        <option :value="kel.id" x-text="kel.name"></option>
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
                            <button type="button" @click="removeAnggota(index)" x-show="anggota.length > minAnggota" 
                                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 hover:text-red-600 transition-all duration-200 flex items-center justify-center group">
                                <i class='bx bx-trash text-xl group-hover:scale-110 transition-transform duration-200'></i>
                            </button>
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 lg:px-8 py-4 border-b border-blue-100">
                                <h3 class="text-lg font-bold text-blue-800 flex items-center" x-text="'Anggota Tim ' + (index + 1)"></h3>
                            </div>
                            
                            <div class="p-6 lg:p-8">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    {{-- Form fields untuk anggota --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" :name="`anggota[${index}][nama_lengkap]`" x-model="item.nama_lengkap" class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK/NIM/NIP <span class="text-red-500">*</span></label>
                                        <input type="text" :name="`anggota[${index}][nik_nim_nip]`" x-model="item.nik_nim_nip" class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </template>
                    {{-- No Members Message --}}
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
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
    select:disabled { background-color: #f8fafc; color: #94a3b8; cursor: not-allowed; }
</style>
@endpush

@push('scripts')
{{-- PERUBAHAN 3: Seluruh script diganti dengan logika API baru --}}
<script>
    function formIdentitasData() {
        return {
            provinces: [],
            // Data untuk Ketua
            ketua: {
                provinsiId: '', provinsiName: '{{ old('ketua.provinsi') }}',
                kotaId: '', kotaName: '{{ old('ketua.kota_kabupaten') }}',
                kecamatanId: '', kecamatanName: '{{ old('ketua.kecamatan') }}',
                kelurahanId: '', kelurahanName: '{{ old('ketua.kelurahan') }}',
                listKota: [], listKecamatan: [], listKelurahan: [],
                loadingKota: false, loadingKecamatan: false, loadingKelurahan: false
            },
            // Data untuk Anggota
            anggota: @json(old('anggota', [])).map(item => ({
                ...item,
                provinsiId: '', provinsiName: item.provinsi || '',
                kotaId: '', kotaName: item.kota_kabupaten || '',
                kecamatanId: '', kecamatanName: item.kecamatan || '',
                kelurahanId: '', kelurahanName: item.kelurahan || '',
                listKota: [], listKecamatan: [], listKelurahan: [],
                loadingKota: false, loadingKecamatan: false, loadingKelurahan: false
            })),
            minAnggota: {{ $sesi->min_anggota > 1 ? $sesi->min_anggota - 1 : 0 }},
            maxAnggota: {{ $sesi->max_anggota > 1 ? $sesi->max_anggota - 1 : 0 }},

            // Fungsi untuk mengambil data dari API
            async fetchData(url) {
                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok');
                    return await response.json();
                } catch (error) {
                    console.error('Failed to fetch data:', error);
                    return [];
                }
            },
            
            // Handler saat provinsi dipilih
            async handleProvinsiChange(person, provinceId) {
                person.provinsiName = this.provinces.find(p => p.id == provinceId)?.name || '';
                person.kotaId = ''; person.kecamatanId = ''; person.kelurahanId = '';
                person.listKota = []; person.listKecamatan = []; person.listKelurahan = [];
                if (!provinceId) return;
                person.loadingKota = true;
                person.listKota = await this.fetchData(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
                person.loadingKota = false;
            },

            // Handler saat kota dipilih
            async handleKotaChange(person, kotaId) {
                person.kotaName = person.listKota.find(k => k.id == kotaId)?.name || '';
                person.kecamatanId = ''; person.kelurahanId = '';
                person.listKecamatan = []; person.listKelurahan = [];
                if (!kotaId) return;
                person.loadingKecamatan = true;
                person.listKecamatan = await this.fetchData(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`);
                person.loadingKecamatan = false;
            },

            // Handler saat kecamatan dipilih
            async handleKecamatanChange(person, kecamatanId) {
                person.kecamatanName = person.listKecamatan.find(k => k.id == kecamatanId)?.name || '';
                person.kelurahanId = '';
                person.listKelurahan = [];
                if (!kecamatanId) return;
                person.loadingKelurahan = true;
                person.listKelurahan = await this.fetchData(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`);
                person.loadingKelurahan = false;
            },

            // Fungsi untuk memuat ulang data jika ada old input (setelah validasi error)
            async rehydratePerson(person) {
                if (person.provinsiName) {
                    const prov = this.provinces.find(p => p.name === person.provinsiName);
                    if (prov) {
                        await this.handleProvinsiChange(person, prov.id);
                        person.provinsiId = prov.id;
                        if(person.kotaName) {
                            const kota = person.listKota.find(k => k.name === person.kotaName);
                            if (kota) {
                                await this.handleKotaChange(person, kota.id);
                                person.kotaId = kota.id;
                                if(person.kecamatanName) {
                                    const kec = person.listKecamatan.find(kc => kc.name === person.kecamatanName);
                                    if(kec) {
                                        await this.handleKecamatanChange(person, kec.id);
                                        person.kecamatanId = kec.id;
                                        if (person.kelurahanName) {
                                            const kel = person.listKelurahan.find(kl => kl.name === person.kelurahanName);
                                            if (kel) person.kelurahanId = kel.id;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            },

            addAnggota() {
                if (this.anggota.length < this.maxAnggota) {
                    this.anggota.push({ 
                        nama_lengkap: '', nik_nim_nip: '', alamat_jalan: '', kode_pos: '',
                        provinsiId: '', provinsiName: '', kotaId: '', kotaName: '',
                        kecamatanId: '', kecamatanName: '', kelurahanId: '', kelurahanName: '',
                        listKota: [], listKecamatan: [], listKelurahan: [],
                        loadingKota: false, loadingKecamatan: false, loadingKelurahan: false
                    });
                }
            },
            removeAnggota(index) { 
                if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
                    this.anggota.splice(index, 1); 
                }
            },
            
            async init() {
                this.provinces = await this.fetchData('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                
                // Rehydrate/muat ulang data ketua jika ada old input
                await this.rehydratePerson(this.ketua);

                // Rehydrate/muat ulang data setiap anggota jika ada old input
                for (const member of this.anggota) {
                    await this.rehydratePerson(member);
                }

                // Inisialisasi anggota minimum jika form baru dibuka
                if (@json(old('anggota')) === null && this.anggota.length === 0) {
                    for (let i = 0; i < this.minAnggota; i++) {
                        this.addAnggota();
                    }
                }
            }
        }
    }
</script>
@endpush
@endsection