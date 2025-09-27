@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6" 
     x-data="apcFormData({
        authors: {{ old('penulis') ? collect(old('penulis'))->toJson() : $submission->authors->toJson() }},
        cost: {{ old('biaya_publikasi', $submission->biaya_publikasi) }},
        maxCost: {{ $submission->session->dana }}
     })">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Pengajuan APC</h1>
            <p class="mt-2 text-gray-600">Anda mengedit proposal untuk sesi: <strong class="text-teal-700">{{ $submission->session->nama_sesi }}</strong></p>
        </header>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.apc.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    {{-- General Journal Info --}}
                    <div class="space-y-6">

                        <div>
                            <label for="nama_jurnal_q1" class="block text-sm font-medium text-gray-700 mb-1">Nama Jurnal Q1</label>
                            <input type="text" name="nama_jurnal_q1" id="nama_jurnal_q1" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('nama_jurnal_q1', $submission->nama_jurnal_q1) }}">
                        </div>
                        <div>
                            <label for="link_scimagojr" class="block text-sm font-medium text-gray-700 mb-1">Link ScimagoJR</label>
                            <input type="url" name="link_scimagojr" id="link_scimagojr" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="https://www.scimagojr.com/..." value="{{ old('link_scimagojr', $submission->link_scimagojr) }}">
                        </div>
                        <div>
                            <label for="judul_artikel" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                            <input type="text" name="judul_artikel" id="judul_artikel" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('judul_artikel', $submission->judul_artikel) }}">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="volume" class="block text-sm font-medium text-gray-700 mb-1">Volume</label>
                                <input type="text" name="volume" id="volume" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('volume', $submission->volume) }}">
                            </div>
                            <div>
                                <label for="issue" class="block text-sm font-medium text-gray-700 mb-1">Issue</label>
                                <input type="text" name="issue" id="issue" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('issue', $submission->issue) }}">
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Authors Section --}}
                    <div class="border-t pt-6">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Penulis</h3>
                            <button @click="addAuthor()" type="button" class="px-4 py-2 bg-teal-500 text-white text-sm font-semibold rounded-lg hover:bg-teal-600 transition-colors flex items-center">
                                <i class='bx bx-plus mr-1'></i> Tambah Penulis
                            </button>
                        </div>
                        <div class="space-y-4">
                            <template x-for="(author, index) in authors" :key="index">
                                <div class="bg-gray-50 p-4 rounded-lg border flex items-start space-x-4">
                                    <div class="flex-grow grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="text-xs text-gray-600">Urutan</label>
                                            <input type="number" :name="`penulis[${index}][urutan]`" x-model="author.urutan" class="w-full text-sm rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="1">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">Nama Penulis</label>
                                            <input type="text" :name="`penulis[${index}][nama]`" x-model="author.nama" class="w-full text-sm rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Nama Lengkap">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">Afiliasi</label>
                                            <input type="text" :name="`penulis[${index}][afiliasi]`" x-model="author.afiliasi" class="w-full text-sm rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Institusi">
                                        </div>
                                    </div>
                                    <button @click="removeAuthor(index)" type="button" class="mt-5 p-2 text-red-500 hover:bg-red-100 rounded-full transition-colors">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Publication Cost --}}
                    <div class="border-t pt-6">

                        <label for="biaya_publikasi" class="block text-sm font-medium text-gray-700 mb-1">Biaya Publikasi</label>
                         <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="text" name="biaya_publikasi_display" id="biaya_publikasi" required @input="formatAndUpdateCost($event)" x-init="$el.value = new Intl.NumberFormat('id-ID').format(publicationCost)" class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="800.000">
                            <input type="hidden" name="biaya_publikasi" x-model="publicationCost">
                         </div>
                         <p class="text-xs text-gray-500 mt-2">Dana maksimal yang didanai pada sesi ini: <strong class="text-gray-700">Rp {{ number_format($submission->session->dana, 0, ',', '.') }}</strong></p>
                         <div x-show="costExceedsMax" class="mt-2 text-sm text-red-600 font-semibold" x-transition>
                            Peringatan: Biaya yang diajukan melebihi dana maksimal sesi.
                         </div>
                    </div>
    
                    <div class="border-t pt-6 space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800">Ubah Lampiran</h3>
                        <p class="text-sm text-gray-500">Kosongkan jika Anda tidak ingin mengubah file. Centang "Hapus file" untuk menghapus lampiran yang sudah ada.</p>
                        

                        @foreach ([
                            'artikel' => ['label' => 'Artikel (PDF)', 'path' => $submission->artikel_path],
                            'bukti_invoice' => ['label' => 'Bukti Invoice (PDF/JPG)', 'path' => $submission->invoice_path],
                            'bukti_submission_proses' => ['label' => 'Bukti Proses Submission (PDF/JPG)', 'path' => $submission->submission_process_path]
                        ] as $key => $file)
                        <div x-data="{ deleteFile: false, fileName: '' }">
                            <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $file['label'] }}</label>
                            @if($file['path'])
                                <div class="text-xs text-gray-500 mb-2 flex justify-between items-center">
                                    <span>File saat ini: <a href="{{ Storage::url($file['path']) }}" target="_blank" class="text-teal-600 hover:underline">{{ basename($file['path']) }}</a></span>
                                    <label class="flex items-center space-x-2 text-red-600 cursor-pointer">
                                        <input type="checkbox" name="delete_{{ $key }}" value="1" x-model="deleteFile" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                        <span>Hapus file</span>
                                    </label>
                                </div>
                            @else
                                <p class="text-xs text-gray-500 mb-2 italic">Belum ada file yang diunggah.</p>
                            @endif
                            <div class="flex items-center space-x-3">
                                <label class="w-full flex items-center px-4 py-2 bg-white text-blue rounded-lg shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-teal-500 hover:text-white transition-colors" :class="{'opacity-50 cursor-not-allowed': deleteFile}">
                                    <i class='bx bx-upload text-xl mr-2'></i>
                                    <span class="text-sm" x-text="fileName || 'Pilih File Baru...'"></span>
                                    <input type="file" name="{{ $key }}" id="{{ $key }}" class="hidden" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" :disabled="deleteFile">
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-4 flex justify-end items-center gap-4 border-t">
                     <a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}" class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">Batal</a>
                     <button type="submit" class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-md">
                         Simpan Perubahan
                     </button>
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

