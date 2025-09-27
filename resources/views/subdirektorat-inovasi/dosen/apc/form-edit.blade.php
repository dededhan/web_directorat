@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" 
     x-data="apcFormData({
        authors: {{ old('penulis') ? collect(old('penulis'))->toJson() : $submission->authors->toJson() }},
        cost: {{ old('biaya_publikasi', $submission->biaya_publikasi) }},
        maxCost: {{ $submission->session->dana }}
     })">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-slate-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}"
                            class="hover:text-slate-600 transition-colors duration-200">APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Edit Pengajuan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-semibold text-gray-800">Edit Pengajuan APC</h1>
                    <p class="mt-2 text-gray-600 text-base">Anda mengedit proposal untuk sesi: <strong class="text-slate-700">{{ $submission->session->nama_sesi }}</strong></p>
                </div>
                <div class="flex-shrink-0">
                    <div class="bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                        <p class="text-xs font-medium text-slate-600 uppercase tracking-wide">Dana Maksimal</p>
                        <p class="text-sm font-medium text-slate-700">Rp {{ number_format($submission->session->dana, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
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
        <form action="{{ route('subdirektorat-inovasi.dosen.apc.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                
                {{-- Form Header --}}
                <div class="bg-slate-100 px-6 lg:px-8 py-6 border-b border-slate-200">
                    <div class="flex items-center">
                        <i class='bx bx-edit-alt text-2xl mr-3 text-slate-600'></i>
                        <h2 class="text-xl lg:text-2xl font-semibold text-slate-800">Edit Informasi Artikel & Jurnal</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-8">
                    {{-- General Journal Information --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label for="nama_jurnal_q1" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-book-content text-blue-500 mr-2'></i>
                                Nama Jurnal Q1
                            </label>
                            <input type="text" 
                                   name="nama_jurnal_q1" 
                                   id="nama_jurnal_q1" 
                                   required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Masukkan nama jurnal Q1"
                                   value="{{ old('nama_jurnal_q1', $submission->nama_jurnal_q1) }}">
                        </div>

                        <div class="lg:col-span-2">
                            <label for="link_scimagojr" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-link text-purple-500 mr-2'></i>
                                Link ScimagoJR
                            </label>
                            <input type="url" 
                                   name="link_scimagojr" 
                                   id="link_scimagojr" 
                                   required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="https://www.scimagojr.com/..."
                                   value="{{ old('link_scimagojr', $submission->link_scimagojr) }}">
                        </div>

                        <div class="lg:col-span-2">
                            <label for="judul_artikel" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-file-blank text-green-500 mr-2'></i>
                                Judul Artikel
                            </label>
                            <textarea name="judul_artikel" 
                                      id="judul_artikel" 
                                      required 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm resize-none" 
                                      placeholder="Masukkan judul artikel lengkap">{{ old('judul_artikel', $submission->judul_artikel) }}</textarea>
                        </div>

                        <div>
                            <label for="volume" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-bookmark text-orange-500 mr-2'></i>
                                Volume
                            </label>
                            <input type="text" 
                                   name="volume" 
                                   id="volume" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Contoh: Vol. 12"
                                   value="{{ old('volume', $submission->volume) }}">
                        </div>

                        <div>
                            <label for="issue" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-hash text-red-500 mr-2'></i>
                                Issue
                            </label>
                            <input type="text" 
                                   name="issue" 
                                   id="issue" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Contoh: Issue 3"
                                   value="{{ old('issue', $submission->issue) }}">
                        </div>
                    </div>

                    {{-- Authors Section --}}
                    <div class="border-t border-gray-200 pt-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class='bx bx-group text-indigo-500 mr-3 text-xl'></i>
                                Daftar Penulis
                            </h3>
                            <button @click="addAuthor()" 
                                    type="button" 
                                    class="inline-flex items-center px-4 py-2.5 bg-slate-600 text-white font-medium rounded-lg hover:bg-slate-700 transition-all duration-200 shadow-sm">
                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                Tambah Penulis
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(author, index) in authors" :key="index">
                                <div class="bg-gray-50 p-4 lg:p-6 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 mt-2">
                                            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                                <i class='bx bx-user text-indigo-500 text-xl'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide mb-1">Urutan</label>
                                                <input type="number" 
                                                       :name="`penulis[${index}][urutan]`" 
                                                       x-model="author.urutan" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-sm" 
                                                       placeholder="1">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide mb-1">Nama Penulis</label>
                                                <input type="text" 
                                                       :name="`penulis[${index}][nama]`" 
                                                       x-model="author.nama" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-sm" 
                                                       placeholder="Nama Lengkap">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide mb-1">Afiliasi</label>
                                                <input type="text" 
                                                       :name="`penulis[${index}][afiliasi]`" 
                                                       x-model="author.afiliasi" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-sm" 
                                                       placeholder="Institusi">
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button @click="removeAuthor(index)" 
                                                    type="button" 
                                                    class="p-2.5 text-red-500 hover:bg-red-100 rounded-lg transition-colors duration-200 border border-transparent hover:border-red-200">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Publication Cost --}}
                    <div class="border-t border-gray-200 pt-8">
                        <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-200">
                            <label for="biaya_publikasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-money text-green-500 mr-2 text-xl'></i>
                                Biaya Publikasi Diajukan
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 font-medium">Rp</span>
                                </div>
                                <input type="text" 
                                       name="biaya_publikasi_display" 
                                       id="biaya_publikasi" 
                                       required 
                                       @input="formatAndUpdateCost($event)" 
                                       x-init="$el.value = new Intl.NumberFormat('id-ID').format(publicationCost)"
                                       class="w-full pl-12 pr-4 py-4 text-lg font-medium border border-gray-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm bg-white" 
                                       placeholder="800.000">
                                <input type="hidden" name="biaya_publikasi" x-model="publicationCost">
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-sm text-gray-600">
                                    Dana maksimal sesi: <strong class="text-emerald-600">Rp {{ number_format($submission->session->dana, 0, ',', '.') }}</strong>
                                </p>
                                <div x-show="costExceedsMax" 
                                     x-transition 
                                     class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-medium rounded-md border border-red-200">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    Melebihi dana maksimal
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- File Uploads --}}
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <i class='bx bx-cloud-upload text-blue-500 mr-3 text-xl'></i>
                            Ubah Lampiran Dokumen
                        </h3>
                        <p class="text-sm text-gray-600 mb-6 bg-blue-50 p-3 rounded-lg border border-blue-200">
                            <i class='bx bx-info-circle mr-1 text-blue-500'></i>
                            Kosongkan jika Anda tidak ingin mengubah file. Centang "Hapus file" untuk menghapus lampiran yang sudah ada.
                        </p>
                        
                        <div class="grid grid-cols-1 gap-6">
                            @foreach ([
                                'artikel' => ['label' => 'Artikel (PDF)', 'path' => $submission->artikel_path, 'color' => 'red'],
                                'bukti_invoice' => ['label' => 'Bukti Invoice (PDF/JPG)', 'path' => $submission->invoice_path, 'color' => 'yellow'],
                                'bukti_submission_proses' => ['label' => 'Bukti Proses Submission (PDF/JPG)', 'path' => $submission->submission_process_path, 'color' => 'blue']
                            ] as $key => $file)
                            <div x-data="{ deleteFile: false, fileName: '' }" class="bg-{{ $file['color'] }}-50 border border-{{ $file['color'] }}-200 rounded-lg p-6">
                                <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    @if($file['color'] === 'red')
                                        <i class='bx bx-file-pdf text-red-500 mr-2'></i>
                                    @elseif($file['color'] === 'yellow') 
                                        <i class='bx bx-receipt text-yellow-600 mr-2'></i>
                                    @else
                                        <i class='bx bx-check-shield text-blue-500 mr-2'></i>
                                    @endif
                                    {{ $file['label'] }}
                                </label>
                                
                                @if($file['path'])
                                    <div class="flex items-center justify-between mb-4 p-3 bg-white rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <i class='bx bx-file text-gray-400 mr-2'></i>
                                            <span class="text-sm text-gray-700">File saat ini: </span>
                                            <a href="{{ Storage::url($file['path']) }}" 
                                               target="_blank" 
                                               class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium ml-1">
                                                {{ basename($file['path']) }}
                                            </a>
                                        </div>
                                        <label class="flex items-center space-x-2 text-red-600 cursor-pointer">
                                            <input type="checkbox" 
                                                   name="delete_{{ $key }}" 
                                                   value="1" 
                                                   x-model="deleteFile" 
                                                   class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                            <span class="text-sm font-medium">Hapus file</span>
                                        </label>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 mb-4 italic bg-white p-3 rounded-lg border border-gray-200">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        Belum ada file yang diunggah.
                                    </p>
                                @endif
                                
                                <label class="group relative w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-sm border-2 border-dashed border-{{ $file['color'] }}-300 cursor-pointer hover:bg-{{ $file['color'] }}-50 hover:border-{{ $file['color'] }}-400 transition-all duration-200"
                                       :class="{'opacity-50 cursor-not-allowed': deleteFile}">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-upload text-2xl text-{{ $file['color'] }}-500 mb-2 group-hover:scale-110 transition-transform'></i>
                                        <span class="text-sm font-medium text-gray-600" x-text="fileName || 'Pilih File Baru...'"></span>
                                        <span class="text-xs text-gray-400 mt-1">Atau drag & drop file di sini</span>
                                    </div>
                                    <input type="file" 
                                           name="{{ $key }}" 
                                           id="{{ $key }}" 
                                           class="hidden" 
                                           @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" 
                                           :disabled="deleteFile">
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="bg-gray-50 px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        <i class='bx bx-info-circle mr-1'></i>
                        Pastikan semua perubahan telah sesuai sebelum menyimpan
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                            <i class='bx bx-arrow-back mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-8 py-3 bg-slate-600 text-white font-medium rounded-lg hover:bg-slate-700 transition-all duration-200 shadow-sm">
                            <i class='bx bx-save mr-2'></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function apcFormData(config) {
    return {
        authors: config.authors.length > 0 ? config.authors.map(author => ({ ...author })) : [{ urutan: 1, nama: '', afiliasi: '' }],
        publicationCost: config.cost || 0,
        maxPublicationCost: config.maxCost || 0,
        get costExceedsMax() {
            return this.publicationCost > this.maxPublicationCost;
        },
        addAuthor() {
            this.authors.push({ urutan: this.authors.length + 1, nama: '', afiliasi: '' });
        },
        removeAuthor(index) {
            if (this.authors.length > 1) this.authors.splice(index, 1);
        },
        formatAndUpdateCost(event) {
            let value = event.target.value.replace(/[^0-9]/g, '');
            this.publicationCost = Number(value) || 0;
            event.target.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
        }
    }
}
</script>
@endsection

@push('styles')
<style>
    input:focus,
    select:focus,
    textarea:focus,
    button:focus {
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.1);
    }

    .bg-white:hover {
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -1px rgb(0 0 0 / 0.06);
    }

    /* Custom file upload hover effects */
    .group:hover .bx-upload {
        animation: gentle-bounce 0.6s ease-in-out;
    }

    @keyframes gentle-bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0) scale(1);
        }
        40% {
            transform: translateY(-5px) scale(1.05);
        }
        60% {
            transform: translateY(-2px) scale(1.02);
        }
    }

    /* Smooth transitions for all interactive elements */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Responsive improvements */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .grid-cols-1.sm\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
    }

    /* Enhanced form styling */
    .form-input {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
    }

    .form-input:focus {
        background: #ffffff;
    }
</style>
@endpush