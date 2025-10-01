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
                        <span
                            class="inline-flex items-center px-3 py-1 bg-sky-100 text-sky-800 font-semibold rounded-full text-sm">
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

            <form method="POST"
                action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.storeIdentitas', $sesi->id) }}"
                class="space-y-8">
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

                            <div class="lg:col-span-1">
                                <label for="ketua_nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-user mr-1 text-blue-500'></i>
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input id="ketua_nama" name="ketua[nama_lengkap]"
                                    value="{{ old('ketua.nama_lengkap', $currentUser->name) }}"
                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('ketua.nama_lengkap') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                    type="text" placeholder="Masukkan nama lengkap">
                                @error('ketua.nama_lengkap')
                                    <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                            class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                                @enderror
                            </div>

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
                                    <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                            class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-map mr-1 text-purple-500'></i>
                                    Alamat Rumah <span class="text-red-500">*</span>
                                </label>
                                <input name="ketua[alamat_jalan]" value="{{ old('ketua.alamat_jalan') }}"
                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('ketua.alamat_jalan') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: Jl. Rawamangun Muka No. 1" type="text">
                                @error('ketua.alamat_jalan')
                                    <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                            class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:col-span-2">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                            class='bx bx-location-plus mr-1 text-orange-500'></i> Provinsi</label>
                                    <input type="hidden" name="ketua[provinsi]" :value="ketua.provinsiName">
                                    <select x-model="ketua.provinsiId"
                                        @change="handleProvinsiChange(ketua, $event.target.value)"
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="prov in provinces" :key="prov.id">
                                            <option :value="prov.id" x-text="prov.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                            class='bx bx-buildings mr-1 text-blue-500'></i> Kota/Kabupaten</label>
                                    <input type="hidden" name="ketua[kota_kabupaten]" :value="ketua.kotaName">
                                    <select x-model="ketua.kotaId" @change="handleKotaChange(ketua, $event.target.value)"
                                        :disabled="!ketua.provinsiId || ketua.loadingKota"
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                        <option x-text="ketua.loadingKota ? 'Memuat...' : 'Pilih Kota/Kabupaten'"
                                            value=""></option>
                                        <template x-for="kota in ketua.listKota" :key="kota.id">
                                            <option :value="kota.id" x-text="kota.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                            class='bx bx-navigation mr-1 text-indigo-500'></i> Kecamatan</label>
                                    <input type="hidden" name="ketua[kecamatan]" :value="ketua.kecamatanName">
                                    <select x-model="ketua.kecamatanId"
                                        @change="handleKecamatanChange(ketua, $event.target.value)"
                                        :disabled="!ketua.kotaId || ketua.loadingKecamatan"
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                        <option x-text="ketua.loadingKecamatan ? 'Memuat...' : 'Pilih Kecamatan'"
                                            value=""></option>
                                        <template x-for="kec in ketua.listKecamatan" :key="kec.id">
                                            <option :value="kec.id" x-text="kec.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                            class='bx bx-home mr-1 text-pink-500'></i> Kelurahan</label>
                                    <input type="hidden" name="ketua[kelurahan]" :value="ketua.kelurahanName">
                                    <select x-model="ketua.kelurahanId"
                                        @change="ketua.kelurahanName = $event.target.options[$event.target.selectedIndex].text"
                                        :disabled="!ketua.kecamatanId || ketua.loadingKelurahan"
                                        class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                        <option x-text="ketua.loadingKelurahan ? 'Memuat...' : 'Pilih Kelurahan'"
                                            value=""></option>
                                        <template x-for="kel in ketua.listKelurahan" :key="kel.id">
                                            <option :value="kel.id" x-text="kel.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div class="lg:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class='bx bx-mail-send mr-1 text-red-500'></i> Kode Pos</label>
                                <input name="ketua[kode_pos]" value="{{ old('ketua.kode_pos') }}"
                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                    placeholder="Contoh: 12345" type="text">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Team Members Section --}}
                <div class="space-y-6">
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <div class="flex items-center">
                            <i class='bx bx-group text-2xl text-teal-600 mr-3'></i>
                            <div>
                                <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Anggota Tim Pengusul</h2>
                                <p class="text-gray-600 text-sm mt-1">Minimal {{ $sesi->min_anggota - 1 }} anggota,
                                    maksimal {{ $sesi->max_anggota - 1 }} anggota</p>
                            </div>
                        </div>
                        <button type="button" @click="addAnggota" x-show="anggota.length < maxAnggota"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-user-plus mr-2 text-lg'></i>
                            <span>Tambah Anggota</span>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(item, index) in anggota" :key="item.id">
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 relative animate-fade-in">
                                <button type="button" @click="removeAnggota(index)" x-show="anggota.length > minAnggota"
                                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 hover:text-red-600 flex items-center justify-center group">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 lg:px-8 py-4 border-b border-blue-100">
                                    <h3 class="text-lg font-bold text-blue-800 flex items-center"
                                        x-text="'Anggota Tim ' + (index + 1)"></h3>
                                </div>

                                {{-- FORM ANGGOTA YANG DISEDERHANAKAN --}}
                                <div class="p-6 lg:p-8">
                                    <div class="grid grid-cols-1 gap-6" x-init="initAnggotaSearch(item.id, index)">
                                        <div>
                                            <label :for="'anggota-search-' + item.id"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                Cari Nama/NIP Anggota <span class="text-red-500">*</span>
                                            </label>
                                            <select :id="'anggota-search-' + item.id"
                                                placeholder="Ketik untuk mencari dosen..."></select>

                                            <input type="hidden" :name="`anggota[${index}][nama_lengkap]`"
                                                x-model="item.nama_lengkap">
                                            <input type="hidden" :name="`anggota[${index}][nik_nim_nip]`"
                                                x-model="item.nik_nim_nip">
                                        </div>

                                        <div x-show="item.selected_dosen_details" x-transition
                                            class="mt-2 p-4 bg-teal-50 border border-teal-200 rounded-lg text-sm">
                                            <h5 class="font-semibold text-teal-800 mb-2">Informasi Dosen Terpilih:</h5>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 text-teal-700">
                                                <p><strong>NIP:</strong> <span
                                                        x-text="item.selected_dosen_details?.identifier_number || 'N/A'"></span>
                                                </p>
                                                <p><strong>Fakultas:</strong> <span
                                                        x-text="item.selected_dosen_details?.fakultas || 'N/A'"></span></p>
                                                <p class="sm:col-span-2"><strong>Program Studi:</strong> <span
                                                        x-text="item.selected_dosen_details?.prodi || 'N/A'"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
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
                                <i class='bx bx-x mr-2'></i>Batal
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
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
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

            select:disabled {
                background-color: #f8fafc;
                color: #94a3b8;
                cursor: not-allowed;
            }

            .ts-control {
                border-radius: 0.75rem !important;
                border: 2px solid #e5e7eb !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
            }

            .ts-control.focus {
                border-color: #14b8a6 !important;
                box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.5) !important;
            }

            .ts-dropdown .option {
                padding: 0.5rem 1rem;
            }
        </style>
    @endpush


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            function formIdentitasData() {
                return {
                    // --- PROPERTIES ---
                    anggotaCounter: 0,
                    provinces: [],
                    ketua: {
                        provinsiId: '{{ old('ketua.provinsiId') }}',
                        provinsiName: '{{ old('ketua.provinsi') }}',
                        kotaId: '{{ old('ketua.kotaId') }}',
                        kotaName: '{{ old('ketua.kota_kabupaten') }}',
                        kecamatanId: '{{ old('ketua.kecamatanId') }}',
                        kecamatanName: '{{ old('ketua.kecamatan') }}',
                        kelurahanId: '{{ old('ketua.kelurahanId') }}',
                        kelurahanName: '{{ old('ketua.kelurahan') }}',
                        listKota: [],
                        listKecamatan: [],
                        listKelurahan: [],
                        loadingKota: false,
                        loadingKecamatan: false,
                        loadingKelurahan: false
                    },
                    anggota: [],
                    minAnggota: {{ $sesi->min_anggota > 1 ? $sesi->min_anggota - 1 : 0 }},
                    maxAnggota: {{ $sesi->max_anggota > 1 ? $sesi->max_anggota - 1 : 0 }},

                    // --- METHODS ---

                    // A. Method untuk Anggota
                    initAnggotaSearch(id, index) {
                        this.$nextTick(() => {
                            const el = document.getElementById(`anggota-search-${id}`);
                            if (!el) {
                                console.error(`Error: Elemen 'anggota-search-${id}' tidak ditemukan.`);
                                return;
                            }
                            if (el.tomselect) { // Mencegah inisialisasi ulang
                                return;
                            }

                            const tom = new TomSelect(el, {
                                valueField: 'id',
                                labelField: 'text',
                                searchField: ['text', 'identifier_number'],
                                maxItems: 1,
                                create: false,
                                render: {
                                    option: (data, escape) =>
                                        `<div class="py-1"><div class="font-semibold">${escape(data.text)}</div><div class="text-xs text-gray-500">NIP: ${escape(data.identifier_number)}</div></div>`,
                                    item: (data, escape) => `<div>${escape(data.text)}</div>`
                                },
                                load: (query, callback) => {
                                    if (!query.length) return callback();
                                    const url =
                                        `{{ route('subdirektorat-inovasi.dosen.search-dosen') }}?q=${encodeURIComponent(query)}`;
                                    fetch(url).then(res => res.json()).then(json => callback(json)).catch(
                                    () => callback());
                                },
                                onChange: (value) => {
                                    const selectedData = tom.options[value];
                                    if (this.anggota[index]) {
                                        if (selectedData) {
                                            this.anggota[index].nama_lengkap = selectedData.text;
                                            this.anggota[index].nik_nim_nip = selectedData
                                            .identifier_number;
                                            this.anggota[index].selected_dosen_details = selectedData;
                                        } else {
                                            this.anggota[index].nama_lengkap = '';
                                            this.anggota[index].nik_nim_nip = '';
                                            this.anggota[index].selected_dosen_details = null;
                                        }
                                    }
                                }
                            });
                        });
                    },
                    addAnggota() {
                        if (this.anggota.length < this.maxAnggota) {
                            this.anggotaCounter++;
                            this.anggota.push({
                                id: this.anggotaCounter,
                                nama_lengkap: '',
                                nik_nim_nip: '',
                                selected_dosen_details: null
                            });
                        }
                    },
                    removeAnggota(index) {
                        this.anggota.splice(index, 1);
                    },

                    // B. Method untuk Alamat Ketua (yang sebelumnya hilang)
                    async fetchData(url) {
                        try {
                            const response = await fetch(url);
                            if (!response.ok) throw new Error('Network response was not ok');
                            return await response.json();
                        } catch (error) {
                            console.error('Gagal fetch data:', error);
                            return [];
                        }
                    },
                    async handleProvinsiChange(person, provinceId) {
                        const prov = this.provinces.find(p => p.id == provinceId);
                        person.provinsiName = prov ? prov.name : '';
                        person.kotaId = '';
                        person.kecamatanId = '';
                        person.kelurahanId = '';
                        person.listKota = [];
                        person.listKecamatan = [];
                        person.listKelurahan = [];

                        if (provinceId) {
                            person.loadingKota = true;
                            person.listKota = await this.fetchData(
                                `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
                            person.loadingKota = false;
                        }
                    },
                    async handleKotaChange(person, kotaId) {
                        const kota = person.listKota.find(k => k.id == kotaId);
                        person.kotaName = kota ? kota.name : '';
                        person.kecamatanId = '';
                        person.kelurahanId = '';
                        person.listKecamatan = [];
                        person.listKelurahan = [];

                        if (kotaId) {
                            person.loadingKecamatan = true;
                            person.listKecamatan = await this.fetchData(
                                `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`);
                            person.loadingKecamatan = false;
                        }
                    },
                    async handleKecamatanChange(person, kecamatanId) {
                        const kec = person.listKecamatan.find(k => k.id == kecamatanId);
                        person.kecamatanName = kec ? kec.name : '';
                        person.kelurahanId = '';
                        person.listKelurahan = [];

                        if (kecamatanId) {
                            person.loadingKelurahan = true;
                            person.listKelurahan = await this.fetchData(
                                `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`);
                            person.loadingKelurahan = false;
                        }
                    },

                    // C. Method Inisialisasi Utama
                    async init() {
                        // Inisialisasi data alamat untuk Ketua
                        let provincesData = await this.fetchData(
                            'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                        this.provinces = provincesData;

                        // Isi dropdown provinsi untuk KETUA
                        const ketuaProvSelect = document.querySelector('select[x-model="ketua.provinsiId"]');
                        ketuaProvSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                        this.provinces.forEach(p => {
                            ketuaProvSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
                        });

                        // Inisialisasi anggota dari data lama (jika ada error validasi) atau anggota minimum
                        let oldAnggota = @json(old('anggota', []));
                        if (oldAnggota.length > 0) {
                            oldAnggota.forEach(item => this.addAnggota());
                        } else {
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
