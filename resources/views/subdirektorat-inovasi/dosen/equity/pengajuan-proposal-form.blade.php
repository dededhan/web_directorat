@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{
        // Data untuk Kata Kunci
        keywords: [''],
        maxKeywords: 5,
        addKeyword() {
            if (this.keywords.length < this.maxKeywords) {
                this.keywords.push('');
            }
        },
        removeKeyword(index) {
            this.keywords.splice(index, 1);
        },

        // Data untuk SDGs
        sdgOptions: [
            'SDG 1: Tanpa Kemiskinan', 
            'SDG 2: Tanpa Kelaparan', 
            'SDG 3: Kehidupan Sehat dan Sejahtera',
            'SDG 4: Pendidikan Berkualitas', 
            'SDG 5: Kesetaraan Gender', 
            'SDG 6: Air Bersih dan Sanitasi Layak',
            'SDG 7: Energi Bersih dan Terjangkau', 
            'SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi',
            'SDG 9: Industri, Inovasi, dan Infrastruktur', 
            'SDG 10: Berkurangnya Kesenjangan',
            'SDG 11: Kota dan Pemukiman yang Berkelanjutan', 
            'SDG 12: Konsumsi dan Produksi yang Bertanggung Jawab',
            'SDG 13: Penanganan Perubahan Iklim', 
            'SDG 14: Ekosistem Lautan', 
            'SDG 15: Ekosistem Daratan',
            'SDG 16: Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 
            'SDG 17: Kemitraan untuk Mencapai Tujuan'
        ],
        selectedSdgs: [],
        sdgDropdownOpen: false,
        get availableSdgs() {
            return this.sdgOptions.filter(opt => !this.selectedSdgs.includes(opt));
        },
        selectSdg(sdg) {
            if (!this.selectedSdgs.includes(sdg)) {
                this.selectedSdgs.push(sdg);
            }
            this.sdgDropdownOpen = false;
        },
        removeSdg(index) {
            this.selectedSdgs.splice(index, 1);
        },

        // Data untuk Mitra Nasional
        mitraNasional: [''],
        addMitraNasional() {
            this.mitraNasional.push('');
        },
        removeMitraNasional(index) {
            this.mitraNasional.splice(index, 1);
        },
        
        // Data untuk Mitra Internasional
        mitraInternasional: [''],
        addMitraInternasional() {
            this.mitraInternasional.push('');
        },
        removeMitraInternasional(index) {
            this.mitraInternasional.splice(index, 1);
        },

        // Helper untuk format nominal
        formatNominal(event) {
            let value = event.target.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            event.target.value = rupiah;
        }
    }">

    {{-- Header dan Breadcrumb --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Formulir Pengajuan Proposal</h1>
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Home</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Usulkan Proposal</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium text-gray-700">Detail Proposal</span></li>
                </ol>
            </nav>
        </div>
        <a href="#" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
            <i class='bx bx-arrow-back mr-2'></i>
            <span>Kembali ke Identitas</span>
        </a>
    </div>

    {{-- Form Utama --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <form class="p-6 md:p-8" action="#" method="POST">
            <div class="flex items-start gap-4 border-b border-slate-200 pb-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class='bx bxs-file-plus text-2xl'></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Detail Usulan Proposal</h2>
                    <p class="text-gray-500 mt-1">Lengkapi semua informasi yang diperlukan untuk proposal Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label for="judul" class="block text-sm font-medium text-gray-600 mb-1">Judul Proposal</label>
                    <input type="text" id="judul" class="form-input" placeholder="Masukkan judul proposal Anda">
                </div>

                {{-- Tahun --}}
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-600 mb-1">Tahun Usulan</label>
                    <input type="number" id="tahun" class="form-input" placeholder="Contoh: {{ date('Y') }}" value="{{ date('Y') }}">
                </div>

                {{-- Tempat Pelaksanaan --}}
                <div>
                    <label for="tempat" class="block text-sm font-medium text-gray-600 mb-1">Tempat Pelaksanaan</label>
                    <input type="text" id="tempat" class="form-input" placeholder="Contoh: Jakarta, Indonesia">
                </div>

                {{-- Abstrak --}}
                <div class="md:col-span-2">
                    <label for="abstrak" class="block text-sm font-medium text-gray-600 mb-1">Abstrak</label>
                    <textarea id="abstrak" rows="5" class="form-input" placeholder="Tuliskan abstrak proposal Anda di sini..."></textarea>
                </div>

                {{-- Kata Kunci --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-sm font-medium text-gray-600">Kata Kunci (Maksimal 5)</label>
                    <template x-for="(keyword, index) in keywords" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" :name="'keywords['+index+']'" x-model="keywords[index]" class="form-input flex-grow" placeholder="Contoh: Teknologi, Pendidikan">
                            <button type="button" @click="removeKeyword(index)" x-show="keywords.length > 1" class="text-gray-400 hover:text-red-500 transition">
                                <i class='bx bx-trash text-xl'></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addKeyword" x-show="keywords.length < maxKeywords" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors text-sm font-medium">
                        <i class='bx bx-plus mr-1'></i>
                        Tambah Kata Kunci
                    </button>
                </div>
                
                {{-- SDGs --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tujuan Pembangunan Berkelanjutan (SDGs)</label>
                    <div class="relative">
                        <div class="w-full border border-gray-300 rounded-lg p-2 min-h-[42px] flex flex-wrap gap-2 items-center cursor-pointer" @click="sdgDropdownOpen = !sdgDropdownOpen">
                            <template x-for="(sdg, index) in selectedSdgs" :key="index">
                                <span class="flex items-center gap-1.5 bg-teal-100 text-teal-800 text-xs font-medium px-2 py-1 rounded-full">
                                    <span x-text="sdg"></span>
                                    <button type="button" @click.stop="removeSdg(index)" class="text-teal-600 hover:text-teal-800">&times;</button>
                                </span>
                            </template>
                            <span x-show="selectedSdgs.length === 0" class="text-gray-400 text-sm">Pilih satu atau lebih SDGs...</span>
                        </div>
                        <div x-show="sdgDropdownOpen" @click.away="sdgDropdownOpen = false" x-transition class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" style="display: none;">
                            <template x-for="sdg in availableSdgs" :key="sdg">
                                <a href="#" @click.prevent="selectSdg(sdg)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" x-text="sdg"></a>
                            </template>
                             <div x-show="availableSdgs.length === 0" class="px-4 py-2 text-sm text-gray-500">Semua SDGs telah dipilih.</div>
                        </div>
                    </div>
                </div>

                {{-- Mitra Nasional --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-600">Mitra Nasional (Opsional)</label>
                    <template x-for="(mitra, index) in mitraNasional" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" :name="'mitra_nasional['+index+']'" x-model="mitraNasional[index]" class="form-input flex-grow" placeholder="Nama instansi/mitra nasional">
                             <button type="button" @click="removeMitraNasional(index)" x-show="mitraNasional.length > 1" class="text-gray-400 hover:text-red-500 transition">
                                <i class='bx bx-trash text-xl'></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addMitraNasional" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors text-sm font-medium">
                        <i class='bx bx-plus mr-1'></i>
                        Tambah Mitra
                    </button>
                </div>
                
                {{-- Mitra Internasional --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-600">Mitra Internasional (Opsional)</label>
                    <template x-for="(mitra, index) in mitraInternasional" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" :name="'mitra_internasional['+index+']'" x-model="mitraInternasional[index]" class="form-input flex-grow" placeholder="Nama instansi/mitra internasional">
                            <button type="button" @click="removeMitraInternasional(index)" x-show="mitraInternasional.length > 1" class="text-gray-400 hover:text-red-500 transition">
                                <i class='bx bx-trash text-xl'></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addMitraInternasional" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors text-sm font-medium">
                        <i class='bx bx-plus mr-1'></i>
                        Tambah Mitra
                    </button>
                </div>
                
                {{-- Nominal Usulan --}}
                <div class="md:col-span-2">
                    <label for="nominal" class="block text-sm font-medium text-gray-600 mb-1">Nominal Usulan</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="text" name="nominal" id="nominal" @input="formatNominal($event)" class="form-input pl-8" placeholder="0">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="button" class="px-5 py-2 bg-white border border-gray-300 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-sm">Kembali</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ajukan Proposal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-input {
        width: 100%;
        background-color: white;
        border: 1px solid #d1d5db; /* border-gray-300 */
        border-radius: 0.5rem; /* rounded-lg */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        padding: 0.5rem 0.75rem; /* py-2 px-3 */
        font-size: 0.875rem; /* text-sm */
        transition: all 0.2s ease-in-out;
    }
    .form-input:focus {
        outline: none;
        box-shadow: 0 0 0 2px #ffffff, 0 0 0 4px #3b82f6; /* focus:ring-2 focus:ring-blue-500 */
        border-color: #3b82f6; /* focus:border-blue-500 */
    }
</style>
@endpush

