@extends('subdirektorat-inovasi.dosen.index')

@push('styles')
    {{-- CDN untuk Tagify, Tom-Select, dan styling kustom --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <style>
        /* Kustomisasi styling untuk Tagify agar sesuai dengan desain TEAL */
        .tagify {
            --tags-border-color: #e5e7eb; /* border-gray-200 */
            --tag-bg: #ccfbf1; /* bg-teal-50 */
            --tag-text-color: #115e59; /* text-teal-800 */
            border-width: 2px;
            border-radius: 0.75rem; /* rounded-xl */
            padding-top: 0.4rem; padding-bottom: 0.4rem;
            transition: all 0.2s;
        }
        .tagify:hover { --tags-border-color: #14b8a6; }
        .tagify.tagify--focus {
            --tags-border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }
        .tagify__input { margin: 0; padding: 0.5rem 0.75rem; }

        /* Kustomisasi styling untuk Tom-Select */
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

        /* Animasi fade-in */
        @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" 
    x-data="proposalFormData()">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header dan Breadcrumb (Tidak Berubah) --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.manage') }}" class="hover:text-teal-600">Hibah Modul Ajar</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.sesi') }}" class="hover:text-teal-600">Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Buat Proposal</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Buat Proposal Modul Ajar</h1>
                    <p class="mt-2 text-gray-600">Sesi: <span class="font-semibold text-teal-600">{{ $sesi->nama_sesi }}</span></p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.sesi') }}" class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class='bx bx-arrow-back mr-2 text-lg'></i> Kembali
                </a>
            </div>
        </header>

        {{-- Alert Messages (Tidak Berubah) --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0"><i class='bx bx-error-circle text-red-400 text-xl'></i></div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Terdapat Kesalahan</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.store', $sesi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            @csrf
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center"><i class='bx bx-edit mr-3 text-2xl'></i> Formulir Proposal</h2>
            </div>

            <div class="p-6 lg:p-8 space-y-8">
                {{-- Informasi Modul Section --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center border-b pb-3"><i class='bx bx-book-content text-teal-600 mr-2 text-xl'></i> Informasi Modul</h3>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Modul <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_modul" value="{{ old('judul_modul') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Masukkan judul modul ajar">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan Modul <span class="text-red-500">*</span></label>
                        <textarea name="ringkasan_modul" rows="6" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" placeholder="Tuliskan ringkasan modul ajar Anda (maksimal 300 kata)">{{ old('ringkasan_modul') }}</textarea>
                    </div>

                    {{-- === INPUT KATA KUNCI BARU (TAGIFY) === --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Kunci</label>
                        <input name="kata_kunci" x-ref="keywords" value="{{ old('kata_kunci') }}" class="w-full" placeholder="Ketik kata kunci lalu tekan Enter">
                    </div>

                    {{-- === INPUT SDGS BARU (ALPINE.JS DROPDOWN) === --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SDGs Terkait</label>
                        <input type="hidden" name="sdgs" :value="JSON.stringify(selectedSdgs)">
                        <div class="relative">
                            <div class="w-full bg-white border-2 border-gray-300 rounded-xl p-2 min-h-[50px] flex flex-wrap gap-2 items-center cursor-pointer" @click="sdgDropdownOpen = !sdgDropdownOpen">
                                <template x-for="(sdg, index) in selectedSdgs" :key="index">
                                    <span class="flex items-center gap-1.5 bg-teal-100 text-teal-800 text-xs font-semibold px-2.5 py-1.5 rounded-md">
                                        <span x-text="sdg"></span>
                                        <button type="button" @click.stop="removeSdg(index)" class="text-teal-600 hover:text-teal-800 font-bold">&times;</button>
                                    </span>
                                </template>
                                <span x-show="selectedSdgs.length === 0" class="text-gray-400 text-sm px-2">Pilih SDG's...</span>
                            </div>
                            <div x-show="sdgDropdownOpen" @click.away="sdgDropdownOpen = false" x-transition class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" style="display: none;">
                                <template x-for="sdg in availableSdgs" :key="sdg">
                                    <a href="#" @click.prevent="selectSdg(sdg)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" x-text="sdg"></a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">File Proposal (PDF) <span class="text-red-500">*</span></label>
                        <input type="file" name="file_proposal" accept=".pdf" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-2"><i class='bx bx-info-circle mr-1'></i>Maksimal 10MB, format PDF</p>
                    </div>
                </div>

                {{-- Anggota Penyusun Section (BARU) --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center"><i class='bx bx-group text-teal-600 mr-2 text-xl'></i> Anggota Penyusun</h3>
                        <button type="button" @click="addAnggota" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all shadow-sm"><i class='bx bx-plus mr-2'></i>Tambah Anggota</button>
                    </div>
                    
                    <div class="space-y-6">
                        <template x-for="(item, index) in anggota" :key="item.id">
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 relative animate-fade-in">
                                <button type="button" @click="removeAnggota(index)" class="absolute top-4 right-4 z-10 w-10 h-10 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 flex items-center justify-center"><i class='bx bx-trash text-xl'></i></button>
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                                    <h3 class="text-lg font-bold text-blue-800 flex items-center" x-text="'Anggota ' + (index + 1)"></h3>
                                </div>
                                <div class="p-6 space-y-4" x-init="initAnggotaSearch(item.id, index)">
                                    <div>
                                        <label :for="'anggota-search-' + item.id" class="block text-sm font-semibold text-gray-700 mb-2">Cari Nama/NIP Dosen</label>
                                        <select :id="'anggota-search-' + item.id" placeholder="Ketik untuk mencari dosen..."></select>
                                        
                                        {{-- Hidden inputs to store data --}}
                                        <input type="hidden" :name="`anggota[${index}][nama_dosen]`" x-model="item.nama_dosen">
                                        <input type="hidden" :name="`anggota[${index}][nip]`" x-model="item.nip">
                                        <input type="hidden" :name="`anggota[${index}][fakultas]`" x-model="item.fakultas">
                                        <input type="hidden" :name="`anggota[${index}][prodi]`" x-model="item.prodi">
                                    </div>
                                    <div x-show="item.selected_dosen_details" x-transition class="mt-2 p-4 bg-teal-50 border border-teal-200 rounded-lg text-sm">
                                        <h5 class="font-semibold text-teal-800 mb-2">Informasi Dosen Terpilih:</h5>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 text-teal-700">
                                            <p><strong>NIP:</strong> <span x-text="item.selected_dosen_details?.identifier_number || 'N/A'"></span></p>
                                            <p><strong>Fakultas:</strong> <span x-text="item.selected_dosen_details?.fakultas || 'N/A'"></span></p>
                                            <p class="sm:col-span-2"><strong>Program Studi:</strong> <span x-text="item.selected_dosen_details?.prodi || 'N/A'"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                         <p x-show="anggota.length === 0" class="text-center text-gray-500 py-4">Belum ada anggota yang ditambahkan.</p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="px-6 lg:px-8 py-5 bg-gray-50 border-t-2 border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.sesi') }}" class="w-full sm:w-auto px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 text-center"><i class='bx bx-x mr-2'></i>Batal</a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all"><i class='bx bx-save mr-2'></i>Simpan Proposal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
function proposalFormData() {
    return {
        // --- Data untuk SDGs ---
        sdgOptions: [
            'SDG 1: Tanpa Kemiskinan', 'SDG 2: Tanpa Kelaparan', 'SDG 3: Kehidupan Sehat dan Sejahtera', 'SDG 4: Pendidikan Berkualitas',
            'SDG 5: Kesetaraan Gender', 'SDG 6: Air Bersih dan Sanitasi Layak', 'SDG 7: Energi Bersih dan Terjangkau',
            'SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi', 'SDG 9: Industri, Inovasi, dan Infrastruktur', 'SDG 10: Berkurangnya Kesenjangan',
            'SDG 11: Kota dan Pemukiman yang Berkelanjutan', 'SDG 12: Konsumsi dan Produksi yang Bertanggung Jawab', 'SDG 13: Penanganan Perubahan Iklim',
            'SDG 14: Ekosistem Lautan', 'SDG 15: Ekosistem Daratan', 'SDG 16: Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 'SDG 17: Kemitraan untuk Mencapai Tujuan'
        ],
        selectedSdgs: @json(old('sdgs') ? json_decode(old('sdgs')) : []),
        sdgDropdownOpen: false,
        get availableSdgs() { return this.sdgOptions.filter(opt => !this.selectedSdgs.includes(opt)); },
        selectSdg(sdg) { if (!this.selectedSdgs.includes(sdg)) this.selectedSdgs.push(sdg); this.sdgDropdownOpen = false; },
        removeSdg(index) { this.selectedSdgs.splice(index, 1); },

        // --- Data untuk Anggota ---
        anggotaCounter: 0,
        anggota: [],

        init() {
            // Inisialisasi Tagify untuk Kata Kunci
            new Tagify(this.$refs.keywords, {
                originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value))
            });

            // Inisialisasi anggota dari data lama (jika ada error validasi)
            let oldAnggota = @json(old('anggota', []));
            if (oldAnggota.length > 0) {
                oldAnggota.forEach(item => {
                    this.anggotaCounter++;
                    this.anggota.push({
                        id: this.anggotaCounter,
                        nama_dosen: item.nama_dosen || '',
                        nip: item.nip || '',
                        fakultas: item.fakultas || '',
                        prodi: item.prodi || '',
                        // Untuk menampilkan kembali detail, kita perlu membuat objek dummy
                        selected_dosen_details: {
                            text: item.nama_dosen,
                            identifier_number: item.nip,
                            fakultas: item.fakultas,
                            prodi: item.prodi
                        }
                    });
                });
            }
        },

        addAnggota() {
            this.anggotaCounter++;
            this.anggota.push({
                id: this.anggotaCounter,
                nama_dosen: '', nip: '', fakultas: '', prodi: '',
                selected_dosen_details: null
            });
        },
        removeAnggota(index) {
            this.anggota.splice(index, 1);
        },
        initAnggotaSearch(id, index) {
            this.$nextTick(() => {
                const el = document.getElementById(`anggota-search-${id}`);
                if (!el || el.tomselect) return;

                const tom = new TomSelect(el, {
                    valueField: 'id', labelField: 'text', searchField: ['text', 'identifier_number'],
                    maxItems: 1, create: false,
                    render: {
                        option: (data, escape) => `<div class="py-1"><div class="font-semibold">${escape(data.text)}</div><div class="text-xs text-gray-500">NIP: ${escape(data.identifier_number)}</div></div>`,
                        item: (data, escape) => `<div>${escape(data.text)}</div>`
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback();
                        const url = `{{ route('subdirektorat-inovasi.dosen.search-dosen') }}?q=${encodeURIComponent(query)}`;
                        fetch(url).then(res => res.json()).then(json => callback(json)).catch(() => callback());
                    },
                    onChange: (value) => {
                        const selectedData = tom.options[value];
                        if (this.anggota[index]) {
                            if (selectedData) {
                                this.anggota[index].nama_dosen = selectedData.text;
                                this.anggota[index].nip = selectedData.identifier_number;
                                this.anggota[index].fakultas = selectedData.fakultas;
                                this.anggota[index].prodi = selectedData.prodi;
                                this.anggota[index].selected_dosen_details = selectedData;
                            } else {
                                this.anggota[index].nama_dosen = ''; this.anggota[index].nip = ''; this.anggota[index].fakultas = ''; this.anggota[index].prodi = '';
                                this.anggota[index].selected_dosen_details = null;
                            }
                        }
                    }
                });
            });
        }
    }
}
</script>
@endpush