@extends('subdirektorat-inovasi.dosen.index')

@push('styles')
    {{-- CDN untuk Tagify (plugin untuk input tag) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <style>
        /* Kustomisasi styling untuk Tagify agar sesuai dengan desain TEAL */
        .tagify {
            --tags-border-color: #e5e7eb;
            /* border-gray-200 */
            --tag-bg: #ccfbf1;
            /* bg-teal-50 */
            --tag-text-color: #115e59;
            /* text-teal-800 */
            border-width: 2px;
            border-radius: 0.75rem;
            /* rounded-xl */
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
            transition: all 0.2s;
        }

        .tagify:hover {
            --tags-border-color: #14b8a6;
            /* border-teal-500 */
        }

        .tagify.tagify--focus {
            --tags-border-color: #14b8a6;
            /* border-teal-500 */
        }

        .tagify__input {
            margin: 0;
            padding: 0.5rem 0.75rem;
        }

        /* Styling untuk focus pada input dan select agar konsisten dengan tema TEAL */
        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }

        .tagify.tagify--focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
        sdgOptions: ['SDG 1: Tanpa Kemiskinan', 'SDG 2: Tanpa Kelaparan', 'SDG 3: Kehidupan Sehat dan Sejahtera', 'SDG 4: Pendidikan Berkualitas', 'SDG 5: Kesetaraan Gender', 'SDG 6: Air Bersih dan Sanitasi Layak', 'SDG 7: Energi Bersih dan Terjangkau', 'SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi', 'SDG 9: Industri, Inovasi, dan Infrastruktur', 'SDG 10: Berkurangnya Kesenjangan', 'SDG 11: Kota dan Pemukiman yang Berkelanjutan', 'SDG 12: Konsumsi dan Produksi yang Bertanggung Jawab', 'SDG 13: Penanganan Perubahan Iklim', 'SDG 14: Ekosistem Lautan', 'SDG 15: Ekosistem Daratan', 'SDG 16: Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 'SDG 17: Kemitraan untuk Mencapai Tujuan'],
        selectedSdgs: {{ json_encode(old('sdgs', $submission->sdgs ?? [])) }},
        sdgDropdownOpen: false,
        get availableSdgs() { return this.sdgOptions.filter(opt => !this.selectedSdgs.includes(opt)); },
        selectSdg(sdg) {
            if (!this.selectedSdgs.includes(sdg)) this.selectedSdgs.push(sdg);
            this.sdgDropdownOpen = false;
        },
        removeSdg(index) { this.selectedSdgs.splice(index, 1); },
    
        maxFund: {{ $submission->sesi->dana_maksimal ?? 0 }},
        currentNominal: 0,
        parseNominal(value) {
            return parseInt(value.replace(/\./g, '')) || 0;
        },

        luaranWajib: {{ json_encode(old('luaran_wajib', $submission->luaran_wajib ?? [['type' => 'file', 'value' => '']])) }},
        luaranOpsional: {{ json_encode(old('luaran_opsional', $submission->luaran_opsional ?? [['type' => 'file', 'value' => '']])) }},
    
        addLuaran(type) {
            if (type === 'wajib') {
                this.luaranWajib.push({ type: 'file', value: '' });
            } else {
                this.luaranOpsional.push({ type: 'file', value: '' });
            }
        },
        removeLuaran(type, index) { // Ini untuk menghapus baris baru yg belum disimpan
            if (type === 'wajib' && this.luaranWajib.length > 1) {
                this.luaranWajib.splice(index, 1);
            } else if (type === 'opsional' && this.luaranOpsional.length > 1) {
                this.luaranOpsional.splice(index, 1);
            }
        },
    
        // --- FUNGSI BARU UNTUK MENGHAPUS FILE YANG SUDAH ADA ---
        deleteExistingFile(type, index) {
            if (confirm('Anda yakin ingin menghapus file ini? File akan dihapus permanen saat Anda menyimpan form.')) {
                if (type === 'wajib') {
                    // Tandai untuk dihapus di backend & kosongkan value agar input file muncul
                    this.luaranWajib[index].deleted = true;
                    this.luaranWajib[index].value = '';
                    this.luaranWajib[index].nama_file = '';
                }
                // (tambahkan else if untuk 'opsional' jika perlu)
            }
        },
    
        formatNominal(event) {
            let value = event.target.value.replace(/[^,\d]/g, '').toString();
            this.currentNominal = this.parseNominal(value);
            if (value === '') {
                event.target.value = '';
                return;
            }
            let number_string = value.replace(/[\.]/g, '').replace(/,/g, '.');
            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            event.target.value = rupiah;
        }
    }" x-init="new Tagify($refs.keywords, { maxTags: 5, whitelist: [], originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)) });
    new Tagify($refs.mitra_nasional, { whitelist: [], originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)) });
    new Tagify($refs.mitra_internasional, { whitelist: [], originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)) });
    
    // INI BAGIAN YANG DIPERBAIKI (this. dihapus)
    currentNominal = parseNominal($refs.nominalInput.value);">

        {{-- Header dan Breadcrumb --}}
        <div class="mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Usulan: Detail Proposal</h1>
            <p class="text-gray-600 mt-1">Lengkapi informasi detail untuk proposal Anda di bawah ini.</p>
        </div>

        {{-- Menampilkan pesan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0"><i class='bx bx-error-circle text-red-500 text-xl'></i></div>
                    <div class="ml-3">
                        <p class="font-semibold text-red-800 mb-2">Terjadi Kesalahan</p>
                        <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <form method="POST"
                action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.storePengajuan', $submission->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bxs-file-detail text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Detail Usulan Proposal</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Judul --}}
                        <div class="md:col-span-2">
                            <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-text mr-1 text-blue-500'></i> Judul Proposal
                            </label>
                            <input type="text" id="judul" name="judul"
                                value="{{ old('judul', $submission->judul) }}"
                                class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('judul') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan judul proposal Anda">
                            @error('judul')
                                <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                        class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tahun & Tempat --}}
                        <div>
                            <label for="tahun_usulan" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-calendar-event mr-1 text-indigo-500'></i> Tahun Usulan
                            </label>
                            <input type="number" id="tahun_usulan" name="tahun_usulan"
                                value="{{ old('tahun_usulan', $submission->tahun_usulan ?? date('Y')) }}"
                                class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('tahun_usulan') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Contoh: {{ date('Y') }}">
                            @error('tahun_usulan')
                                <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                        class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tempat_pelaksanaan" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-map-pin mr-1 text-purple-500'></i> Tempat Pelaksanaan
                            </label>
                            <input type="text" id="tempat_pelaksanaan" name="tempat_pelaksanaan"
                                value="{{ old('tempat_pelaksanaan', $submission->tempat_pelaksanaan) }}"
                                class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('tempat_pelaksanaan') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Contoh: Jakarta, Indonesia">
                            @error('tempat_pelaksanaan')
                                <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                        class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Abstrak --}}
                        <div class="md:col-span-2">
                            <label for="abstrak" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-paragraph mr-1 text-gray-500'></i> Abstrak (Min. 50 kata)
                            </label>
                            <textarea id="abstrak" name="abstrak" rows="5"
                                class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('abstrak') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Tuliskan abstrak proposal Anda di sini...">{{ old('abstrak', $submission->abstrak) }}</textarea>
                            @error('abstrak')
                                <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                        class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kata Kunci (dengan Tagify) --}}
                       <div class="md:col-span-2">
    <label for="kata_kunci" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class='bx bx-purchase-tag-alt mr-1 text-orange-500'></i> Kata Kunci (Maksimal 5)
    </label>
    @php
        // Logika untuk memastikan value selalu array sebelum di-implode
        $kataKunciValue = old('kata_kunci', $submission->kata_kunci ?? []);
        if (is_string($kataKunciValue)) {
            $kataKunciValue = json_decode($kataKunciValue, true) ?? [];
        }
    @endphp
    <input type="text" id="kata_kunci" name="kata_kunci" x-ref="keywords"
        value="{{ implode(',', $kataKunciValue) }}"
        placeholder="Ketik kata kunci lalu tekan Enter">
    @error('kata_kunci')
        <p class="text-red-500 text-xs mt-2 flex items-center"><i
                class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
    @enderror
</div>

                        {{-- SDGs --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-globe-alt mr-1 text-pink-500'></i> Tujuan Pembangunan Berkelanjutan
                                (SDGs)
                            </label>
                            <input type="hidden" name="sdgs" :value="JSON.stringify(selectedSdgs)">
                            <div class="relative">
                                <div class="w-full bg-white border-2 border-gray-200 rounded-xl p-2 min-h-[50px] flex flex-wrap gap-2 items-center cursor-pointer transition-all duration-200 @error('sdgs') border-red-500 focus-within:border-red-500 focus-within:ring-red-500 @else focus-within:ring-2 focus-within:ring-teal-500 focus-within:border-teal-500 @enderror"
                                    @click="sdgDropdownOpen = !sdgDropdownOpen">
                                    <template x-for="(sdg, index) in selectedSdgs" :key="index">
                                        <span
                                            class="flex items-center gap-1.5 bg-teal-100 text-teal-800 text-xs font-semibold px-2.5 py-1.5 rounded-md">
                                            <span x-text="sdg"></span>
                                            <button type="button" @click.stop="removeSdg(index)"
                                                class="text-teal-600 hover:text-teal-800 font-bold">&times;</button>
                                        </span>
                                    </template>
                                    <span x-show="selectedSdgs.length === 0" class="text-gray-400 text-sm px-2">Pilih
                                        satu atau lebih SDGs...</span>
                                </div>
                                <div x-show="sdgDropdownOpen" @click.away="sdgDropdownOpen = false" x-transition
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                    style="display: none;">
                                    <template x-for="sdg in availableSdgs" :key="sdg">
                                        <a href="#" @click.prevent="selectSdg(sdg)"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            x-text="sdg"></a>
                                    </template>
                                    <div x-show="availableSdgs.length === 0" class="px-4 py-2 text-sm text-gray-500">
                                        Semua SDGs telah dipilih.</div>
                                </div>
                            </div>
                            @error('sdgs')
                                <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                        class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Mitra Nasional (dengan Tagify) --}}
                       {{-- GANTI BLOK MITRA NASIONAL ANDA DENGAN INI --}}
<div>
    <label for="mitra_nasional" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class='bx bxs-buildings mr-1 text-gray-500'></i> Mitra Nasional (Min. 1)
    </label>
    @php
        $mitraNasionalValue = old('mitra_nasional', $submission->mitra_nasional ?? []);
        if (is_string($mitraNasionalValue)) {
            $mitraNasionalValue = json_decode($mitraNasionalValue, true) ?? [];
        }
    @endphp
    <input type="text" id="mitra_nasional" name="mitra_nasional" x-ref="mitra_nasional"
        value="{{ implode(',', $mitraNasionalValue) }}"
        placeholder="Ketik nama mitra lalu tekan Enter">
</div>

                        {{-- Mitra Internasional (dengan Tagify) --}}
                        <div>
    <label for="mitra_internasional" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class='bx bxs-plane-alt mr-1 text-gray-500'></i> Mitra Internasional (Min. 1)
    </label>
    @php
        $mitraInternasionalValue = old('mitra_internasional', $submission->mitra_internasional ?? []);
        if (is_string($mitraInternasionalValue)) {
            $mitraInternasionalValue = json_decode($mitraInternasionalValue, true) ?? [];
        }
    @endphp
    <input type="text" id="mitra_internasional" name="mitra_internasional"
        x-ref="mitra_internasional"
        value="{{ implode(',', $mitraInternasionalValue) }}"
        placeholder="Ketik nama mitra lalu tekan Enter">
</div>

                        {{-- Nominal Usulan --}}
                        <div class="md:col-span-2">
                            <label for="nominal_usulan" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-money-withdraw mr-1 text-green-500'></i> Nominal Usulan
                                <span class="font-normal text-gray-500">(Maks: Rp
                                    {{ number_format($submission->sesi->dana_maksimal, 0, ',', '.') }})</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="text" name="nominal_usulan" id="nominal_usulan" x-ref="nominalInput"
                                    {{-- Tambahkan x-ref --}} @input="formatNominal($event)"
                                    value="{{ old('nominal_usulan', number_format($submission->nominal_usulan ?? 0, 0, ',', '.')) }}"
                                    class="w-full bg-white border-2 border-gray-200 rounded-xl py-3 px-4 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('nominal_usulan') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="0">
                            </div>

                            {{-- === WARNING DANA MAKSIMAL === --}}
                            <div x-show="currentNominal > maxFund" x-transition
                                class="mt-2 p-3 bg-red-100 border border-yellow-300 rounded-lg text-yellow-800 text-xs flex items-center">
                                <i class='bx bx-error-circle mr-2'></i>
                                Peringatan: Nominal yang Anda ajukan melebihi dana maksimal yang ditetapkan untuk sesi
                                ini.
                            </div>

                            @error('nominal_usulan')
                                <p class="text-red-500 text-xs mt-2 flex items-center"><i
                                        class='bx bx-error-circle mr-1'></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- DOKUMEN LUARAN WAJIB --}}

                        <div class="md:col-span-2 p-4 bg-gray-50 border-2 border-dashed rounded-xl">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class='bx bxs-file-import mr-1 text-red-500'></i> Dokumen Luaran Wajib
                            </label>
                            <div class="space-y-4">
                                <template x-for="(item, index) in luaranWajib" :key="index">
                                    <div class="p-3 bg-white rounded-lg border">
                                        <div class="flex items-start gap-3">
                                            <span x-text="index + 1 + '.'" class="pt-3 font-medium text-gray-500"></span>
                                            <div class="flex-grow space-y-3">

                                                {{-- KONDISI 1: JIKA FILE SUDAH ADA (MODE EDIT) --}}
                                                <template x-if="item.value && item.type === 'file'">
                                                    <div class="p-3 bg-teal-50 border border-teal-200 rounded-lg">
                                                        <p class="text-xs text-gray-600 mb-2">File Terunggah:</p>
                                                        <div class="flex items-center justify-between gap-3">
                                                            <a :href="item.value" target="_blank"
                                                                class="flex items-center gap-2 text-sm font-semibold text-teal-700 hover:underline">
                                                                <i class='bx bxs-file-pdf text-lg'></i>
                                                                <span x-text="item.nama_file || 'Lihat File'"></span>
                                                            </a>
                                                            <button @click.prevent="deleteExistingFile('wajib', index)"
                                                                type="button"
                                                                class="text-red-500 hover:text-red-700 font-bold text-lg">&times;</button>
                                                        </div>
                                                        {{-- Input hidden untuk menandai file ini akan dihapus saat form disubmit --}}
                                                        <input type="hidden"
                                                            :name="'luaran_wajib[' + index + '][deleted]'"
                                                            x-show="item.deleted" x-bind:value="true">
                                                        {{-- Input hidden untuk tetap mengirim value lama jika tidak dihapus --}}
                                                        <input type="hidden" :name="'luaran_wajib[' + index + '][value]'"
                                                            x-show="!item.deleted" :value="item.value">
                                                        <input type="hidden" :name="'luaran_wajib[' + index + '][type]'"
                                                            value="file">
                                                        <input type="hidden"
                                                            :name="'luaran_wajib[' + index + '][nama_file]'"
                                                            :value="item.nama_file">
                                                    </div>
                                                </template>

                                                {{-- KONDISI 2: JIKA BELUM ADA FILE (MODE CREATE / SETELAH HAPUS) --}}
                                                <template x-if="!item.value || item.type === 'link'">
                                                    <div> {{-- div pembungkus agar tidak bentrok --}}
                                                        <div class="flex items-center gap-4">
                                                            <label class="text-xs font-medium text-gray-600">Tipe:</label>
                                                            <div class="flex items-center">
                                                                <input type="radio"
                                                                    :name="'luaran_wajib[' + index + '][type]'"
                                                                    :id="'lw_type_file_' + index" value="file"
                                                                    x-model="item.type" class="mr-1">
                                                                <label :for="'lw_type_file_' + index"
                                                                    class="text-sm">Upload PDF</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input type="radio"
                                                                    :name="'luaran_wajib[' + index + '][type]'"
                                                                    :id="'lw_type_link_' + index" value="link"
                                                                    x-model="item.type" class="mr-1">
                                                                <label :for="'lw_type_link_' + index"
                                                                    class="text-sm">Link</label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div x-show="item.type === 'file'">
                                                                <label :for="'lw_value_file_' + index"
                                                                    class="text-xs font-medium text-gray-600">Pilih File
                                                                    PDF (Maks: 2MB)</label>
                                                                <input type="file"
                                                                    :name="'luaran_wajib[' + index + '][value]'"
                                                                    :id="'lw_value_file_' + index" accept=".pdf"
                                                                    class="mt-1 w-full text-sm ...">
                                                            </div>
                                                            <div x-show="item.type === 'link'">
                                                                <label :for="'lw_value_link_' + index"
                                                                    class="text-xs font-medium text-gray-600">Link Dokumen
                                                                    (Google Drive, dll)</label>
                                                                <input type="url"
                                                                    :name="'luaran_wajib[' + index + '][value]'"
                                                                    :id="'lw_value_link_' + index" x-model="item.value"
                                                                    class="mt-1 w-full ...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                            </div>
                                            {{-- Tombol hapus baris (hanya untuk baris baru) --}}
                                            <button type="button" @click="removeLuaran('wajib', index)"
                                                x-show="!item.id && luaranWajib.length > 1" class="mt-1 ...">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="addLuaran('wajib')" class="mt-4 ...">
                                <i class='bx bx-plus mr-1'></i> Tambah Luaran Wajib
                            </button>
                        </div>

                        {{-- DOKUMEN LUARAN OPSIONAL --}}
                        {{-- <div class="md:col-span-2 p-4 bg-gray-50 border-2 border-dashed rounded-xl">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class='bx bxs-file-plus mr-1 text-gray-500'></i> Dokumen Luaran Opsional
                            </label>
                            <div class="space-y-4">
                                <template x-for="(item, index) in luaranOpsional" :key="index">
                                    <div class="flex items-start gap-3 p-3 bg-white rounded-lg border">
                                        <span x-text="index + 1 + '.'" class="pt-3 font-medium text-gray-500"></span>
                                        <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label :for="'lo_judul_' + index" class="text-xs font-medium text-gray-600">Judul Luaran</label>
                                                <input type="text" :name="'luaran_opsional[' + index + '][judul]'" :id="'lo_judul_' + index" x-model="item.judul"
                                                    class="mt-1 w-full bg-white border-2 border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                                                    placeholder="Contoh: Artikel Media Massa">
                                            </div>
                                            <div>
                                                <label :for="'lo_link_' + index" class="text-xs font-medium text-gray-600">Link Dokumen</label>
                                                <input type="url" :name="'luaran_opsional[' + index + '][link]'" :id="'lo_link_' + index" x-model="item.link"
                                                    class="mt-1 w-full bg-white border-2 border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                                                    placeholder="https://...">
                                            </div>
                                        </div>
                                        <button type="button" @click="removeLuaran('opsional', index)" x-show="luaranOpsional.length > 1"
                                                class="mt-6 text-gray-400 hover:text-red-500 transition-colors">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="addLuaran('opsional')"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                                <i class='bx bx-plus mr-1'></i> Tambah Luaran Opsional
                            </button>
                        </div> --}}
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="p-6 lg:p-8 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class='bx bx-arrow-back mr-2'></i> Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class='bx bxs-send mr-2'></i> Ajukan & Lanjutkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    {{-- CDN untuk Tagify --}}
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
@endpush
