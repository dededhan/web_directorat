@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="logbookForm({ respondens: {{ json_encode($respondents) }} })">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                 <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="#" class="hover:text-teal-600">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="hover:text-teal-600">Manajemen Proposal</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Logbook Pelaporan</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Logbook & Pelaporan Kemajuan</h1>
                <p class="mt-2 text-gray-600">Judul Proposal: <strong class="text-teal-700">{{ $submission->judul_proposal }}</strong></p>
            </div>
        </header>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="reportForm" action="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.store', $submission->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            {{-- Dokumen Utama --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6"><i class='bx bx-file-blank mr-3'></i>Dokumen Utama</h2>
                <div class="space-y-4">
                    <div>
                        <label for="proposal_path" class="block text-sm font-medium text-gray-700 mb-2">Proposal Final (Unggah PDF/JPG/PNG, maks 5MB)</label>
                        <input type="file" name="proposal_path" id="proposal_path" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        @if($report->proposal_path) <a href="{{ Storage::url($report->proposal_path) }}" target="_blank" class="text-xs text-teal-600 hover:underline">Lihat file saat ini</a> @endif
                    </div>
                    <div>
                        <label for="article_path" class="block text-sm font-medium text-gray-700 mb-2">Artikel (Unggah PDF/JPG/PNG, maks 5MB)</label>
                        <input type="file" name="article_path" id="article_path" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        @if($report->article_path) <a href="{{ Storage::url($report->article_path) }}" target="_blank" class="text-xs text-teal-600 hover:underline">Lihat file saat ini</a> @endif
                    </div>
                </div>
            </div>

            {{-- Detail Publikasi --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6"><i class='bx bx-paper-plane mr-3'></i>Detail Publikasi & Jurnal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="journal_q1_name" class="block text-sm font-medium text-gray-700 mb-2">Jurnal Q1 yang Dituju</label>
                        <input type="text" name="journal_q1_name" id="journal_q1_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Nama Jurnal Internasional Q1" value="{{ old('journal_q1_name', $report->journal_q1_name) }}">
                    </div>
                     <div class="md:col-span-2">
                        <label for="scimagojr_link" class="block text-sm font-medium text-gray-700 mb-2">Link ScimagoJR</label>
                        <input type="url" name="scimagojr_link" id="scimagojr_link" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="https://www.scimagojr.com/..." value="{{ old('scimagojr_link', $report->scimagojr_link) }}">
                    </div>
                    <div>
                        <label for="submit_proof_path" class="block text-sm font-medium text-gray-700 mb-2">Bukti Submit (PDF/Image, maks 5MB)</label>
                        <input type="file" name="submit_proof_path" id="submit_proof_path" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                        @if($report->submit_proof_path) <a href="{{ Storage::url($report->submit_proof_path) }}" target="_blank" class="text-xs text-violet-600 hover:underline">Lihat file saat ini</a> @endif
                    </div>
                     <div>
                        <label for="review_proof_path" class="block text-sm font-medium text-gray-700 mb-2">Bukti Under Review (PDF/Image, maks 5MB)</label>
                        <input type="file" name="review_proof_path" id="review_proof_path" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                        @if($report->review_proof_path) <a href="{{ Storage::url($report->review_proof_path) }}" target="_blank" class="text-xs text-violet-600 hover:underline">Lihat file saat ini</a> @endif
                    </div>
                </div>
            </div>

             {{-- Laporan Kunjungan --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6"><i class='bx bx-map-alt mr-3'></i>Laporan Kunjungan & Responden</h2>
                <div class="space-y-6">
                    <div>
                        <label for="visit_days" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Hari Kunjungan ke Negara Mitra</label>
                        <input type="number" name="visit_days" id="visit_days" class="w-full max-w-xs px-4 py-3 border border-gray-300 rounded-lg" placeholder="Contoh: 14" value="{{ old('visit_days', $report->visit_days) }}">
                    </div>
                    <div>
                        <label for="travel_proof_path" class="block text-sm font-medium text-gray-700 mb-2">Bukti Perjalanan (Tiket, Visa, dll. Maks 5MB)</label>
                        <input type="file" name="travel_proof_path" id="travel_proof_path" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                        @if($report->travel_proof_path) <a href="{{ Storage::url($report->travel_proof_path) }}" target="_blank" class="text-xs text-sky-600 hover:underline">Lihat file saat ini</a> @endif
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-medium text-gray-700">Responden QS (Minimal 2)</label>
                             <button @click="addResponden" type="button" class="px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 text-sm flex items-center">
                                <i class='bx bx-plus mr-1'></i> Tambah Responden
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(responden, index) in respondens" :key="index">
                                <div class="flex items-center gap-3">
                                    <input type="text" x-model="responden.name" :name="`respondens[${index}][name]`" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Nama Lengkap Responden">
                                    <button @click="removeResponden(index)" type="button" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">Kembali</a>
                <button type="submit" name="action" value="save_draft" class="px-8 py-3 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600">Simpan Draft</button>
                <button type="submit" name="action" value="submit_final" id="submitFinalBtn" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">Kirim Laporan Final</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('submitFinalBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah form submit secara langsung
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Laporan akan dikirim untuk dinilai dan tidak dapat diubah lagi.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#14b8a6', // teal-600
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim Laporan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika dikonfirmasi, submit form
            document.getElementById('reportForm').submit();
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
</script>
@endsection

