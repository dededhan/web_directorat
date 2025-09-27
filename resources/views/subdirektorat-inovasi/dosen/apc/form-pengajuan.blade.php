@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6" 
     x-data="apcFormData({{ $session->dana }})">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Formulir Pengajuan APC</h1>
            <p class="mt-2 text-gray-600">Anda mengajukan untuk sesi: <strong class="text-teal-700">{{ $session->nama_sesi }}</strong></p>
        </header>

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
        
        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Gagal</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.apc.store', $session->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    {{-- General Journal Info --}}
                    <div class="space-y-6">
                        <div>
                            <label for="nama_jurnal_q1" class="block text-sm font-medium text-gray-700 mb-1">Nama Jurnal Q1</label>
                            <input type="text" name="nama_jurnal_q1" id="nama_jurnal_q1" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('nama_jurnal_q1') }}">
                        </div>
                        <div>
                            <label for="link_scimagojr" class="block text-sm font-medium text-gray-700 mb-1">Link ScimagoJR</label>
                            <input type="url" name="link_scimagojr" id="link_scimagojr" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="https://www.scimagojr.com/..." value="{{ old('link_scimagojr') }}">
                        </div>
                        <div>
                            <label for="judul_artikel" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                            <input type="text" name="judul_artikel" id="judul_artikel" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('judul_artikel') }}">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="volume" class="block text-sm font-medium text-gray-700 mb-1">Volume</label>
                                <input type="text" name="volume" id="volume" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('volume') }}">
                            </div>
                            <div>
                                <label for="issue" class="block text-sm font-medium text-gray-700 mb-1">Issue</label>
                                <input type="text" name="issue" id="issue" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('issue') }}">
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
                                        <input type="hidden" :name="`penulis[${index}][id]`" x-model="author.id">
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
                             <div x-show="authors.length === 0" class="text-center py-6 text-gray-500">
                                <p>Belum ada penulis ditambahkan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Publication Cost --}}
                    <div class="border-t pt-6">
                         <label for="biaya_publikasi" class="block text-sm font-medium text-gray-700 mb-1">Biaya Publikasi Diajukan</label>
                         <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="text" name="biaya_publikasi_display" id="biaya_publikasi" required @input="formatCurrency($event)" class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="800.000" value="{{ old('biaya_publikasi') ? number_format(old('biaya_publikasi'), 0, ',', '.') : '' }}">
                            <input type="hidden" name="biaya_publikasi" x-model="publicationCost">
                         </div>

                         <p class="text-xs text-gray-500 mt-2">Dana maksimal yang didanai pada sesi ini: <strong class="text-green-600">Rp {{ number_format($session->dana, 0, ',', '.') }}</strong></p>
                         <div x-show="publicationCost > maxFund" x-transition class="mt-2 text-xs text-red-600 font-semibold flex items-center">
                             <i class='bx bx-error-circle mr-1'></i>
                             Peringatan: Dana yang Anda ajukan melebihi dana maksimal sesi.
                         </div>
                    </div>
                    
                    {{-- File Uploads --}}
                    <div class="border-t pt-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800">Lampiran</h3>
                        {{-- Article Upload --}}
                        <div x-data="{ fileName: '' }">
                            <label for="artikel" class="block text-sm font-medium text-gray-700 mb-1">Artikel (PDF)</label>
                            <div class="flex items-center space-x-3">
                                <label class="w-full flex items-center px-4 py-2 bg-white text-blue rounded-lg shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-teal-500 hover:text-white transition-colors">
                                    <i class='bx bx-upload text-xl mr-2'></i>
                                    <span class="text-sm" x-text="fileName || 'Pilih File...'"></span>
                                    <input type="file" name="artikel" id="artikel" required class="hidden" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" x-ref="artikelInput">
                                </label>
                                <button x-show="fileName" @click="fileName = ''; $refs.artikelInput.value = ''" type="button" class="p-2 text-red-500 hover:bg-red-100 rounded-full"><i class='bx bx-x text-xl'></i></button>
                            </div>
                        </div>
                        {{-- Invoice Upload --}}
                         <div x-data="{ fileName: '' }">
                            <label for="bukti_invoice" class="block text-sm font-medium text-gray-700 mb-1">Bukti Invoice (PDF/JPG)</label>
                             <div class="flex items-center space-x-3">
                                <label class="w-full flex items-center px-4 py-2 bg-white text-blue rounded-lg shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-teal-500 hover:text-white transition-colors">
                                    <i class='bx bx-upload text-xl mr-2'></i>
                                    <span class="text-sm" x-text="fileName || 'Pilih File...'"></span>
                                    <input type="file" name="bukti_invoice" id="bukti_invoice" required class="hidden" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" x-ref="invoiceInput">
                                </label>
                                 <button x-show="fileName" @click="fileName = ''; $refs.invoiceInput.value = ''" type="button" class="p-2 text-red-500 hover:bg-red-100 rounded-full"><i class='bx bx-x text-xl'></i></button>
                            </div>
                        </div>
                        {{-- Submission Proof Upload --}}
                        <div x-data="{ fileName: '' }">
                            <label for="bukti_submission_proses" class="block text-sm font-medium text-gray-700 mb-1">Bukti Proses Submission (PDF/JPG)</label>
                            <div class="flex items-center space-x-3">
                                <label class="w-full flex items-center px-4 py-2 bg-white text-blue rounded-lg shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-teal-500 hover:text-white transition-colors">
                                    <i class='bx bx-upload text-xl mr-2'></i>
                                    <span class="text-sm" x-text="fileName || 'Pilih File...'"></span>
                                    <input type="file" name="bukti_submission_proses" id="bukti_submission_proses" required class="hidden" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" x-ref="submissionInput">
                                </label>
                                <button x-show="fileName" @click="fileName = ''; $refs.submissionInput.value = ''" type="button" class="p-2 text-red-500 hover:bg-red-100 rounded-full"><i class='bx bx-x text-xl'></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-4 flex justify-end items-center gap-4 border-t">
                     <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}" class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">Batal</a>
                     <button type="submit" class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-md">
                         Ajukan Proposal
                     </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
{{-- PERUBAHAN 3: Menambahkan maxFund ke fungsi AlpineJS --}}
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

