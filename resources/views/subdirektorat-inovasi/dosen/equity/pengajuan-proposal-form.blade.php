@extends('subdirektorat-inovasi.dosen.index')

@push('styles')
{{-- CDN untuk Tagify (plugin untuk input tag) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<style>
    .tagify {
        --tags-border-color: #d1d5db;
        --tag-bg: #e0f2f1; /* bg-teal-50 */
        --tag-text-color: #0f766e; /* text-teal-800 */
        border-radius: 0.5rem;
    }
    .tagify:hover { --tags-border-color: #0d9488; }
    .tagify.tagify--focus { --tags-border-color: #0d9488; }
    .form-label { @apply block text-sm font-medium text-gray-700 mb-1; }
    .form-input { @apply w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all; }
    .form-error { @apply text-red-500 text-xs mt-1; }
    .btn-primary { @apply inline-flex items-center px-5 py-2.5 bg-sky-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-sky-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500; }
    .btn-secondary { @apply px-5 py-2.5 bg-white border border-gray-300 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-sm; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{
        sdgOptions: ['SDG 1: Tanpa Kemiskinan', 'SDG 2: Tanpa Kelaparan', 'SDG 3: Kehidupan Sehat dan Sejahtera', 'SDG 4: Pendidikan Berkualitas', 'SDG 5: Kesetaraan Gender', 'SDG 6: Air Bersih dan Sanitasi Layak', 'SDG 7: Energi Bersih dan Terjangkau', 'SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi', 'SDG 9: Industri, Inovasi, dan Infrastruktur', 'SDG 10: Berkurangnya Kesenjangan', 'SDG 11: Kota dan Pemukiman yang Berkelanjutan', 'SDG 12: Konsumsi dan Produksi yang Bertanggung Jawab', 'SDG 13: Penanganan Perubahan Iklim', 'SDG 14: Ekosistem Lautan', 'SDG 15: Ekosistem Daratan', 'SDG 16: Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 'SDG 17: Kemitraan untuk Mencapai Tujuan'],
        selectedSdgs: {{ json_encode(old('sdgs', $submission->sdgs ?? [])) }},
        sdgDropdownOpen: false,
        get availableSdgs() { return this.sdgOptions.filter(opt => !this.selectedSdgs.includes(opt)); },
        selectSdg(sdg) { if (!this.selectedSdgs.includes(sdg)) this.selectedSdgs.push(sdg); this.sdgDropdownOpen = false; },
        removeSdg(index) { this.selectedSdgs.splice(index, 1); },
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
    }" x-init="
        new Tagify($refs.keywords, { maxTags: 5, whitelist: [], originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)) });
        new Tagify($refs.mitra_nasional, { whitelist: [], originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)) });
        new Tagify($refs.mitra_internasional, { whitelist: [], originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)) });
    ">

    {{-- Header dan Breadcrumb --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Formulir Usulan: Detail Proposal</h1>
        <p class="text-gray-600 mt-1">Lengkapi informasi detail untuk proposal Anda.</p>
    </div>

    {{-- Menampilkan pesan error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
            <p class="font-bold">Terjadi Kesalahan</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <form class="p-6 md:p-8" method="POST" action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.storePengajuan', $submission->id) }}">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Detail Usulan Proposal</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label for="judul" class="form-label">Judul Proposal</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $submission->judul) }}" class="form-input @error('judul') border-red-500 @enderror" placeholder="Masukkan judul proposal Anda">
                    @error('judul') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                {{-- Tahun & Tempat --}}
                <div>
                    <label for="tahun" class="form-label">Tahun Usulan</label>
                    <input type="number" id="tahun" name="tahun_usulan" value="{{ old('tahun_usulan', $submission->tahun_usulan ?? date('Y')) }}" class="form-input @error('tahun_usulan') border-red-500 @enderror" placeholder="Contoh: {{ date('Y') }}">
                    @error('tahun_usulan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="tempat" class="form-label">Tempat Pelaksanaan</label>
                    <input type="text" id="tempat" name="tempat_pelaksanaan" value="{{ old('tempat_pelaksanaan', $submission->tempat_pelaksanaan) }}" class="form-input @error('tempat_pelaksanaan') border-red-500 @enderror" placeholder="Contoh: Jakarta, Indonesia">
                     @error('tempat_pelaksanaan') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                {{-- Abstrak --}}
                <div class="md:col-span-2">
                    <label for="abstrak" class="form-label">Abstrak (Min. 50 kata)</label>
                    <textarea id="abstrak" name="abstrak" rows="5" class="form-input @error('abstrak') border-red-500 @enderror" placeholder="Tuliskan abstrak proposal Anda di sini...">{{ old('abstrak', $submission->abstrak) }}</textarea>
                    @error('abstrak') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                {{-- Kata Kunci (dengan Tagify) --}}
                <div class="md:col-span-2">
                    <label for="kata_kunci" class="form-label">Kata Kunci (Maksimal 5)</label>
                    <input type="text" id="kata_kunci" name="kata_kunci" x-ref="keywords" value="{{ json_encode(old('kata_kunci', $submission->kata_kunci ?? [])) }}" class="form-input">
                    @error('kata_kunci') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                
                {{-- SDGs --}}
                <div class="md:col-span-2">
                    <label class="form-label mb-2">Tujuan Pembangunan Berkelanjutan (SDGs)</label>
                    <input type="hidden" name="sdgs" :value="JSON.stringify(selectedSdgs)">
                    <div class="relative">
                        <div class="w-full border border-gray-300 rounded-lg p-2 min-h-[42px] flex flex-wrap gap-2 items-center cursor-pointer @error('sdgs') border-red-500 @enderror" @click="sdgDropdownOpen = !sdgDropdownOpen">
                            <template x-for="(sdg, index) in selectedSdgs" :key="index"><span class="flex items-center gap-1.5 bg-teal-100 text-teal-800 text-xs font-medium px-2 py-1 rounded-full"><span x-text="sdg"></span><button type="button" @click.stop="removeSdg(index)" class="text-teal-600 hover:text-teal-800">&times;</button></span></template>
                            <span x-show="selectedSdgs.length === 0" class="text-gray-400 text-sm">Pilih satu atau lebih SDGs...</span>
                        </div>
                        <div x-show="sdgDropdownOpen" @click.away="sdgDropdownOpen = false" x-transition class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" style="display: none;">
                            <template x-for="sdg in availableSdgs" :key="sdg"><a href="#" @click.prevent="selectSdg(sdg)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" x-text="sdg"></a></template>
                             <div x-show="availableSdgs.length === 0" class="px-4 py-2 text-sm text-gray-500">Semua SDGs telah dipilih.</div>
                        </div>
                    </div>
                    @error('sdgs') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                {{-- Mitra Nasional (dengan Tagify) --}}
                <div class="md:col-span-1">
                    <label for="mitra_nasional" class="form-label">Mitra Nasional (Opsional)</label>
                    <input type="text" id="mitra_nasional" name="mitra_nasional" x-ref="mitra_nasional" value="{{ json_encode(old('mitra_nasional', $submission->mitra_nasional ?? [])) }}" class="form-input" placeholder="Ketik nama mitra lalu tekan Enter">
                </div>

                {{-- Mitra Internasional (dengan Tagify) --}}
                 <div class="md:col-span-1">
                    <label for="mitra_internasional" class="form-label">Mitra Internasional (Opsional)</label>
                    <input type="text" id="mitra_internasional" name="mitra_internasional" x-ref="mitra_internasional" value="{{ json_encode(old('mitra_internasional', $submission->mitra_internasional ?? [])) }}" class="form-input" placeholder="Ketik nama mitra lalu tekan Enter">
                </div>
                
                {{-- Nominal Usulan --}}
                <div class="md:col-span-2">
                    <label for="nominal" class="form-label">Nominal Usulan</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500 sm:text-sm">Rp</span></div>
                        <input type="text" name="nominal_usulan" id="nominal" @input="formatNominal($event)" value="{{ old('nominal_usulan', number_format($submission->nominal_usulan ?? 0, 0, ',', '.')) }}" class="form-input pl-8 @error('nominal_usulan') border-red-500 @enderror" placeholder="0">
                    </div>
                    @error('nominal_usulan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" class="btn-secondary">Kembali ke Daftar Skema</a>
                <button type="submit" class="btn-primary">
                    <i class='bx bxs-send mr-2'></i> Ajukan Proposal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
{{-- CDN untuk Tagify --}}
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
@endpush

{{-- PERBAIKAN: Ganti @endpush menjadi @endsection --}}
@endsection

