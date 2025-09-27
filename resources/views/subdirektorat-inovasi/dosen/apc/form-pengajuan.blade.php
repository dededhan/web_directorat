@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="apcFormData({{ $session->dana }})">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}"
                            class="hover:text-teal-600 transition-colors duration-200">APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Formulir Pengajuan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Pengajuan APC</h1>
                    <p class="mt-2 text-gray-600 text-base">Anda mengajukan untuk sesi: <strong class="text-teal-700">{{ $session->nama_sesi }}</strong></p>
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
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
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
        
        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Gagal</h3>
                        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Form --}}
        <form action="{{ route('subdirektorat-inovasi.dosen.apc.store', $session->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                
                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-file-plus text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Informasi Artikel & Jurnal</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-8">
                    {{-- General Journal Information --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label for="nama_jurnal_q1" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-book-content text-blue-500 mr-2'></i>
                                Nama Jurnal Q1
                            </label>
                            <input type="text" 
                                   name="nama_jurnal_q1" 
                                   id="nama_jurnal_q1" 
                                   required 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Masukkan nama jurnal Q1"
                                   value="{{ old('nama_jurnal_q1') }}">
                        </div>

                        <div class="lg:col-span-2">
                            <label for="link_scimagojr" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-link text-purple-500 mr-2'></i>
                                Link ScimagoJR
                            </label>
                            <input type="url" 
                                   name="link_scimagojr" 
                                   id="link_scimagojr" 
                                   required 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="https://www.scimagojr.com/..."
                                   value="{{ old('link_scimagojr') }}">
                        </div>

                        <div class="lg:col-span-2">
                            <label for="judul_artikel" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-file-blank text-green-500 mr-2'></i>
                                Judul Artikel
                            </label>
                            <textarea name="judul_artikel" 
                                      id="judul_artikel" 
                                      required 
                                      rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm resize-none" 
                                      placeholder="Masukkan judul artikel lengkap">{{ old('judul_artikel') }}</textarea>
                        </div>

                        <div>
                            <label for="volume" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-bookmark text-orange-500 mr-2'></i>
                                Volume
                            </label>
                            <input type="text" 
                                   name="volume" 
                                   id="volume" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Contoh: Vol. 12"
                                   value="{{ old('volume') }}">
                        </div>

                        <div>
                            <label for="issue" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-hash text-red-500 mr-2'></i>
                                Issue
                            </label>
                            <input type="text" 
                                   name="issue" 
                                   id="issue" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Contoh: Issue 3"
                                   value="{{ old('issue') }}">
                        </div>
                    </div>

                    {{-- Authors Section --}}
                    <div class="border-t-2 border-gray-100 pt-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                <i class='bx bx-group text-indigo-500 mr-3 text-xl'></i>
                                Daftar Penulis
                            </h3>
                            <button @click="addAuthor()" 
                                    type="button" 
                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                Tambah Penulis
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(author, index) in authors" :key="index">
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 lg:p-6 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-colors duration-200">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 mt-2">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl flex items-center justify-center">
                                                <i class='bx bx-user text-indigo-500 text-xl'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <input type="hidden" :name="`penulis[${index}][id]`" x-model="author.id">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Urutan</label>
                                                <input type="number" 
                                                       :name="`penulis[${index}][urutan]`" 
                                                       x-model="author.urutan" 
                                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm" 
                                                       placeholder="1">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Nama Penulis</label>
                                                <input type="text" 
                                                       :name="`penulis[${index}][nama]`" 
                                                       x-model="author.nama" 
                                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm" 
                                                       placeholder="Nama Lengkap">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Afiliasi</label>
                                                <input type="text" 
                                                       :name="`penulis[${index}][afiliasi]`" 
                                                       x-model="author.afiliasi" 
                                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm" 
                                                       placeholder="Institusi">
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button @click="removeAuthor(index)" 
                                                    type="button" 
                                                    class="p-2.5 text-red-500 hover:bg-red-100 rounded-xl transition-colors duration-200 border-2 border-transparent hover:border-red-200">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="authors.length === 0" 
                                 x-transition
                                 class="text-center py-12 px-6 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class='bx bx-user-plus text-2xl text-gray-400'></i>
                                </div>
                                <h3 class="font-semibold text-gray-600 mb-2">Belum ada penulis ditambahkan</h3>
                                <p class="text-sm text-gray-500">Klik tombol "Tambah Penulis" untuk menambahkan penulis artikel</p>
                            </div>
                        </div>
                    </div>

                    {{-- Publication Cost --}}
                    <div class="border-t-2 border-gray-100 pt-8">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-200">
                            <label for="biaya_publikasi" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-money text-green-500 mr-2 text-xl'></i>
                                Biaya Publikasi Diajukan
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 font-semibold">Rp</span>
                                </div>
                                <input type="text" 
                                       name="biaya_publikasi_display" 
                                       id="biaya_publikasi" 
                                       required 
                                       @input="formatCurrency($event)" 
                                       class="w-full pl-12 pr-4 py-4 text-lg font-semibold border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm bg-white" 
                                       placeholder="800.000"
                                       value="{{ old('biaya_publikasi') ? number_format(old('biaya_publikasi'), 0, ',', '.') : '' }}">
                                <input type="hidden" name="biaya_publikasi" x-model="publicationCost">
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-sm text-gray-600">
                                    Dana maksimal sesi: <strong class="text-green-600">Rp {{ number_format($session->dana, 0, ',', '.') }}</strong>
                                </p>
                                <div x-show="publicationCost > maxFund" 
                                     x-transition 
                                     class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    Melebihi dana maksimal
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- File Uploads --}}
                    <div class="border-t-2 border-gray-100 pt-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                            <i class='bx bx-cloud-upload text-blue-500 mr-3 text-xl'></i>
                            Lampiran Dokumen
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {{-- Article Upload --}}
                            <div x-data="{ fileName: '' }" class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border-2 border-blue-200">
                                <label for="artikel" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                    <i class='bx bx-file-blank text-blue-500 mr-2'></i>
                                    Artikel (PDF)
                                </label>
                                <div class="space-y-3">
                                    <label class="group relative w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-xl shadow-sm tracking-wide border-2 border-dashed border-blue-300 cursor-pointer hover:bg-blue-50 hover:border-blue-400 transition-all duration-200">
                                        <div class="flex flex-col items-center">
                                            <i class='bx bx-upload text-2xl text-blue-500 mb-2 group-hover:scale-110 transition-transform'></i>
                                            <span class="text-sm font-medium text-gray-600" x-text="fileName || 'Pilih File PDF'"></span>
                                            <span class="text-xs text-gray-400 mt-1">Maksimal 10MB</span>
                                        </div>
                                        <input type="file" 
                                               name="artikel" 
                                               id="artikel" 
                                               required 
                                               accept=".pdf"
                                               class="hidden" 
                                               @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" 
                                               x-ref="artikelInput">
                                    </label>
                                    <button x-show="fileName" 
                                            @click="fileName = ''; $refs.artikelInput.value = ''" 
                                            type="button" 
                                            class="w-full py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors border border-red-200">
                                        <i class='bx bx-x mr-1'></i>Hapus File
                                    </button>
                                </div>
                            </div>

                            {{-- Invoice Upload --}}
                            <div x-data="{ fileName: '' }" class="bg-gradient-to-br from-yellow-50 to-amber-100 p-6 rounded-xl border-2 border-yellow-200">
                                <label for="bukti_invoice" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                    <i class='bx bx-receipt text-yellow-600 mr-2'></i>
                                    Bukti Invoice
                                </label>
                                <div class="space-y-3">
                                    <label class="group relative w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-xl shadow-sm tracking-wide border-2 border-dashed border-yellow-300 cursor-pointer hover:bg-yellow-50 hover:border-yellow-400 transition-all duration-200">
                                        <div class="flex flex-col items-center">
                                            <i class='bx bx-upload text-2xl text-yellow-600 mb-2 group-hover:scale-110 transition-transform'></i>
                                            <span class="text-sm font-medium text-gray-600" x-text="fileName || 'Pilih File'"></span>
                                            <span class="text-xs text-gray-400 mt-1">PDF/JPG, Maks 10MB</span>
                                        </div>
                                        <input type="file" 
                                               name="bukti_invoice" 
                                               id="bukti_invoice" 
                                               required 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               class="hidden" 
                                               @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" 
                                               x-ref="invoiceInput">
                                    </label>
                                    <button x-show="fileName" 
                                            @click="fileName = ''; $refs.invoiceInput.value = ''" 
                                            type="button" 
                                            class="w-full py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors border border-red-200">
                                        <i class='bx bx-x mr-1'></i>Hapus File
                                    </button>
                                </div>
                            </div>

                            {{-- Submission Proof Upload --}}
                            <div x-data="{ fileName: '' }" class="bg-gradient-to-br from-green-50 to-emerald-100 p-6 rounded-xl border-2 border-green-200">
                                <label for="bukti_submission_proses" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                    <i class='bx bx-check-shield text-green-600 mr-2'></i>
                                    Bukti Submission
                                </label>
                                <div class="space-y-3">
                                    <label class="group relative w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-xl shadow-sm tracking-wide border-2 border-dashed border-green-300 cursor-pointer hover:bg-green-50 hover:border-green-400 transition-all duration-200">
                                        <div class="flex flex-col items-center">
                                            <i class='bx bx-upload text-2xl text-green-600 mb-2 group-hover:scale-110 transition-transform'></i>
                                            <span class="text-sm font-medium text-gray-600" x-text="fileName || 'Pilih File'"></span>
                                            <span class="text-xs text-gray-400 mt-1">PDF/JPG, Maks 10MB</span>
                                        </div>
                                        <input type="file" 
                                               name="bukti_submission_proses" 
                                               id="bukti_submission_proses" 
                                               required 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               class="hidden" 
                                               @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" 
                                               x-ref="submissionInput">
                                    </label>
                                    <button x-show="fileName" 
                                            @click="fileName = ''; $refs.submissionInput.value = ''" 
                                            type="button" 
                                            class="w-full py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors border border-red-200">
                                        <i class='bx bx-x mr-1'></i>Hapus File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="bg-gray-50 px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t-2 border-gray-100">
                    <div class="text-sm text-gray-600">
                        <i class='bx bx-info-circle mr-1'></i>
                        Pastikan semua data telah terisi dengan benar sebelum mengajukan
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                            <i class='bx bx-arrow-back mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-send mr-2'></i>
                            Ajukan Proposal
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function apcFormData(maxFund = 0) {
    const oldPenulis = @json(old('penulis'));
    const initialAuthors = oldPenulis && oldPenulis.length > 0
        ? oldPenulis.map((p, i) => ({ id: Date.now() + i, urutan: p.urutan, nama: p.nama, afiliasi: p.afiliasi }))
        : [{ id: Date.now(), urutan: 1, nama: '', afiliasi: '' }];

    return {
        authors: initialAuthors,
        publicationCost: @json(old('biaya_publikasi', 0)),
        maxFund: maxFund, 
        addAuthor() {
            this.authors.push({
                id: Date.now(),
                urutan: this.authors.length + 1,
                nama: '',
                afiliasi: ''
            });
        },
        removeAuthor(index) {
            if (this.authors.length > 1) {
                this.authors.splice(index, 1);
            }
        },
        formatCurrency(event) {
            let value = event.target.value.replace(/[^0-9]/g, '');
            this.publicationCost = value;
            if (value) {
                event.target.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                event.target.value = '';
            }
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
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }

    .bg-white:hover {
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.05);
    }

    .group:hover .bx-upload {
        animation: bounce 0.6s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .grid-cols-1.sm\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
    }

    .form-input {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
    }

    .form-input:focus {
        background: #ffffff;
        transform: translateY(-1px);
    }
</style>
@endpush