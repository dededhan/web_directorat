@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="logbookForm({ respondens: {{ json_encode($respondents) }} })">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Judul Halaman --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="#" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Pengajuan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Laporan Kemajuan</h1>
                    <p class="mt-2 text-gray-600 text-base">Judul Proposal: <strong class="text-teal-700">{{ $submission->judul_proposal }}</strong></p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}"
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali
                    </a>
                </div>
            </div>
        </header>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-xl shadow-sm" role="alert">
                <div class="flex items-start">
                    <i class='bx bxs-error text-red-400 text-xl mr-3 mt-0.5'></i>
                    <div>
                        <p class="font-bold text-red-800 mb-2">Terjadi Kesalahan</p>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <i class='bx bx-x text-red-500 text-sm mr-1 mt-0.5'></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form id="reportForm" action="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.store', $submission->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            {{-- Dokumen Utama --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-file-blank mr-3 text-2xl'></i>
                            1. Dokumen Utama
                        </h2>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-teal-50 to-teal-100 rounded-xl p-4 sm:p-6 border border-teal-200">
                            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                <div class="flex-shrink-0">
                                    <i class='bx bx-file-pdf text-teal-600 text-2xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label for="proposal_path" class="block text-sm font-bold text-gray-700 mb-3">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                            <div class="flex items-center space-x-2">
                                                <i class='bx bx-file-blank text-base text-teal-500'></i>
                                                <span>Proposal Kegiatan</span>
                                            </div>
                                            <span class="text-xs text-gray-500 sm:ml-auto">(PDF/JPG/PNG, maks 5MB)</span>
                                        </div>
                                    </label>
                                    <input type="file" 
                                           name="proposal_path" 
                                           id="proposal_path" 
                                           class="w-full text-sm text-gray-500 file:mr-2 sm:file:mr-4 file:py-2 file:px-3 sm:file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-all">
                                    @if($report->proposal_path) 
                                        <a href="{{ Storage::url($report->proposal_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center text-sm text-teal-600 hover:text-teal-800 hover:underline mt-2 transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            <span class="break-all">Lihat file saat ini</span>
                                        </a> 
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-4 sm:p-6 border border-purple-200">
                            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                <div class="flex-shrink-0">
                                    <i class='bx bx-news text-purple-600 text-2xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label for="article_path" class="block text-sm font-bold text-gray-700 mb-3">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                            <span>Artikel Penelitian</span>
                                            <span class="text-xs text-gray-500 sm:ml-auto">(PDF/JPG/PNG, maks 5MB)</span>
                                        </div>
                                    </label>
                                    <input type="file" 
                                           name="article_path" 
                                           id="article_path" 
                                           class="w-full text-sm text-gray-500 file:mr-2 sm:file:mr-4 file:py-2 file:px-3 sm:file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all">
                                    @if($report->article_path) 
                                        <a href="{{ Storage::url($report->article_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center text-sm text-purple-600 hover:text-purple-800 hover:underline mt-2 transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            <span class="break-all">Lihat file saat ini</span>
                                        </a> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Publikasi --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-paper-plane mr-3 text-2xl'></i>
                            2. Detail Publikasi & Jurnal
                        </h2>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="space-y-6">
                        {{-- Journal Info --}}
                        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <i class='bx bx-book text-emerald-500 mr-2'></i>
                                Informasi Jurnal
                            </h5>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="journal_q1_name" class="block text-sm font-medium text-gray-700 mb-2">Jurnal Q1 yang Dituju</label>
                                    <input type="text" 
                                           name="journal_q1_name" 
                                           id="journal_q1_name" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" 
                                           placeholder="Nama Jurnal Internasional Q1" 
                                           value="{{ old('journal_q1_name', $report->journal_q1_name) }}">
                                </div>
                                <div>
                                    <label for="scimagojr_link" class="block text-sm font-medium text-gray-700 mb-2">Link ScimagoJR</label>
                                    <input type="url" 
                                           name="scimagojr_link" 
                                           id="scimagojr_link" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" 
                                           placeholder="https://www.scimagojr.com/..." 
                                           value="{{ old('scimagojr_link', $report->scimagojr_link) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Upload Proofs --}}
                        <div class="bg-gradient-to-r from-violet-50 to-violet-100 rounded-xl p-6 border border-violet-200">
                            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <i class='bx bx-upload text-violet-500 mr-2'></i>
                                Bukti Dokumen
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="submit_proof_path" class="block text-sm font-medium text-gray-700 mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span>Bukti Submit</span>
                                            <span class="text-xs text-gray-500">(PDF/Image, maks 5MB)</span>
                                        </div>
                                    </label>
                                    <input type="file" 
                                           name="submit_proof_path" 
                                           id="submit_proof_path" 
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-all">
                                    @if($report->submit_proof_path) 
                                        <a href="{{ Storage::url($report->submit_proof_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center text-sm text-violet-600 hover:text-violet-800 hover:underline mt-2 transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            Lihat file saat ini
                                        </a> 
                                    @endif
                                </div>
                                <div>
                                    <label for="review_proof_path" class="block text-sm font-medium text-gray-700 mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span>Bukti Under Review</span>
                                            <span class="text-xs text-gray-500">(PDF/Image, maks 5MB)</span>
                                        </div>
                                    </label>
                                    <input type="file" 
                                           name="review_proof_path" 
                                           id="review_proof_path" 
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-all">
                                    @if($report->review_proof_path) 
                                        <a href="{{ Storage::url($report->review_proof_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center text-sm text-violet-600 hover:text-violet-800 hover:underline mt-2 transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            Lihat file saat ini
                                        </a> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Laporan Kunjungan --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-map-alt mr-3 text-2xl'></i>
                            3. Laporan Kunjungan & Responden
                        </h2>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="space-y-6">
                        {{-- Visit Info --}}
                        <div class="bg-gradient-to-r from-sky-50 to-sky-100 rounded-xl p-6 border border-sky-200">
                            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <i class='bx bx-calendar text-sky-500 mr-2'></i>
                                Informasi Kunjungan
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="visit_days" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Hari Kunjungan ke Negara Mitra</label>
                                    <input type="number" 
                                           name="visit_days" 
                                           id="visit_days" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all" 
                                           placeholder="Contoh: 5" 
                                           value="{{ old('visit_days', $report->visit_days) }}"
                                           max="5"
                                           min="1">
                                </div>
                                <div>
                                    <label for="travel_proof_path" class="block text-sm font-medium text-gray-700 mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span>Bukti Perjalanan</span>
                                            <span class="text-xs text-gray-500">(Tiket, Visa, dll. Maks 5MB)</span>
                                        </div>
                                    </label>
                                    <input type="file" 
                                           name="travel_proof_path" 
                                           id="travel_proof_path" 
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition-all">
                                    @if($report->travel_proof_path) 
                                        <a href="{{ Storage::url($report->travel_proof_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center text-sm text-sky-600 hover:text-sky-800 hover:underline mt-2 transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            Lihat file saat ini
                                        </a> 
                                    @endif
                                </div>
                                {{-- Input baru ditambahkan di sini --}}
                                <div class="md:col-span-2">
                                    <label for="setneg_approval_path" class="block text-sm font-medium text-gray-700 mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span>Surat Persetujuan Sekretariat Negara</span>
                                            <span class="text-xs text-gray-500">(PDF, maks 5MB)</span>
                                        </div>
                                    </label>
                                    <input type="file" 
                                           name="setneg_approval_path" 
                                           id="setneg_approval_path" 
                                           accept=".pdf"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition-all">
                                    @if($report->setneg_approval_path) 
                                        <a href="{{ Storage::url($report->setneg_approval_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center text-sm text-sky-600 hover:text-sky-800 hover:underline mt-2 transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            Lihat file saat ini
                                        </a> 
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Responden Section --}}
                        <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="font-semibold text-gray-800 flex items-center">
                                    <i class='bx bx-group text-amber-500 mr-2'></i>
                                    Responden QS (Minimal 2)
                                </h5>
                                <button @click="addResponden" 
                                        type="button" 
                                        class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700 transform hover:scale-105 transition-all text-sm shadow-md hover:shadow-lg">
                                    <i class='bx bx-plus mr-2'></i> 
                                    Tambah Responden
                                </button>
                            </div>
                            <div class="space-y-4">
                                <template x-for="(responden, index) in respondens" :key="index">
                                    <div class="bg-white rounded-lg p-4 border-2 border-amber-200 hover:border-amber-300 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                                    <i class='bx bx-user text-amber-600 text-sm'></i>
                                                </div>
                                            </div>
                                            <input type="text" 
                                                   x-model="responden.name" 
                                                   :name="`respondens[${index}][name]`" 
                                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" 
                                                   placeholder="Nama Lengkap Responden">
                                            <button @click="removeResponden(index)" 
                                                    type="button" 
                                                    class="flex-shrink-0 p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                                <i class='bx bx-trash text-lg'></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 lg:p-8">
                <div class="flex flex-col sm:flex-row justify-end gap-4">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-arrow-back mr-2'></i>
                        Kembali
                    </a>
                    <button type="submit" 
                            name="action" 
                            value="save_draft" 
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-save mr-2'></i>
                        Simpan Draft
                    </button>
                    <button type="submit" 
                            name="action" 
                            value="submit_final" 
                            id="submitFinalBtn" 
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-paper-plane mr-2'></i>
                        Kirim Laporan Final
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('submitFinalBtn').addEventListener('click', function(event) {
    event.preventDefault(); 
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Laporan akan dikirim untuk dinilai dan tidak dapat diubah lagi.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#14b8a6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim Laporan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('reportForm');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'action';
            hiddenInput.value = 'submit_final';
            form.appendChild(hiddenInput);
            
            form.submit();
        }
    });
});

function logbookForm(initialData) {
    return {
        respondens: initialData.respondens && initialData.respondens.length > 0 ? initialData.respondens : [{ name: '' }, { name: '' }],
        addResponden() {
            this.respondens.push({ name: '' });
        },
        removeResponden(index) {
            if (this.respondens.length > 2) {
                this.respondens.splice(index, 1);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Minimal harus ada 2 responden.',
                });
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const visitDaysInput = document.getElementById('visit_days');
    if (visitDaysInput) {
        visitDaysInput.addEventListener('input', function() {
            const max = parseInt(this.getAttribute('max'), 10);
            if (parseInt(this.value, 10) > max) {
                this.value = max;
            }
        });
    }
});
</script>

@push('styles')
    <style>
        input:focus,
        select:focus,
        button:focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }

        button:hover {
            transform: translateY(-1px);
        }

        .bg-white:hover {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
        }
    </style>
@endpush
@endsection
