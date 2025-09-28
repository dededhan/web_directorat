@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-5o to-gray-100 p-6" x-data="{ reviewModal: false, status: '', note: '' }">
    <div class="max-w-4xl mx-auto">
        
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                 <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.show', $submission->session->id) }}" class="hover:text-teal-600">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Laporan</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Laporan Kemajuan</h1>
                <p class="mt-2 text-gray-600">Judul Proposal: <strong class="text-teal-700">{{ $submission->judul_proposal }}</strong></p>
                <p class="mt-1 text-sm text-gray-500">Dosen Pengusul: {{ $submission->user->name }}</p>
            </div>
        </header>

        @php $report = $submission->report; @endphp

        <div class="space-y-8">

            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center"><i class='bx bx-file-blank text-xl mr-3'></i>Dokumen Utama</h2>
                <div class="space-y-4">
                    @include('admin_equity.matchresearch._report_file_item', ['label' => 'Proposal Final', 'path' => $report->proposal_path])
                    @include('admin_equity.matchresearch._report_file_item', ['label' => 'Artikel', 'path' => $report->article_path])
                </div>
            </div>


            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center"><i class='bx bx-paper-plane text-xl mr-3'></i>Detail Publikasi & Jurnal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Jurnal Q1 yang Dituju</h3>
                        <p class="mt-1 text-gray-800">{{ $report->journal_q1_name ?: '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Link ScimagoJR</h3>
                        <a href="{{ $report->scimagojr_link }}" target="_blank" class="mt-1 text-blue-600 hover:underline">{{ $report->scimagojr_link ?: '-' }}</a>
                    </div>
                    @include('admin_equity.matchresearch._report_file_item', ['label' => 'Bukti Submit', 'path' => $report->submit_proof_path])
                    @include('admin_equity.matchresearch._report_file_item', ['label' => 'Bukti Under Review', 'path' => $report->review_proof_path])
                </div>
            </div>


            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center"><i class='bx bx-map-alt text-xl mr-3'></i>Laporan Kunjungan & Responden</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Jumlah Hari Kunjungan</h3>
                        <p class="mt-1 text-gray-800">{{ $report->visit_days }} Hari</p>
                    </div>
                    
                    @include('admin_equity.matchresearch._report_file_item', ['label' => 'Bukti Perjalanan (Tiket, Visa, dll.)', 'path' => $report->travel_proof_path])


                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Responden QS</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-800">
                            @forelse($report->qs_respondents as $respondent)

                                <li>{{ $respondent }}</li>
                            @empty
                                <li>Tidak ada data responden.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>


            <div class="bg-white mt-8 rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Penilaian Laporan</h2>
                    @if($submission->status == 'menunggu_penilaian')
                        <p class="text-sm text-gray-600 mb-6">Berikan penilaian akhir untuk laporan ini. Dosen akan menerima notifikasi mengenai status terbaru beserta catatan (jika ada).</p>
                        <div class="flex items-center justify-end space-x-4">
                            <button @click="status = 'tolak'; reviewModal = true" type="button" class="px-6 py-2.5 bg-red-100 text-red-700 font-semibold rounded-xl hover:bg-red-200">
                                Tolak
                            </button>
                             <button @click="status = 'revisi'; reviewModal = true" type="button" class="px-6 py-2.5 bg-yellow-100 text-yellow-700 font-semibold rounded-xl hover:bg-yellow-200">
                                Revisi
                            </button>
                            <form action="{{ route('admin_equity.matchresearch.submission.report.updateStatus', $submission->id) }}" method="POST">
                                @csrf
                                <button type="submit" name="status" value="lolos" class="px-8 py-2.5 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700">
                                    Lolos
                                </button>
                            </form>
                        </div>
                    @else
                         <p class="text-gray-600">Laporan ini sudah dinilai dengan status: <strong class="font-semibold">{{ ucwords(str_replace('_', ' ', $submission->status)) }}</strong></p>
                         @if($submission->rejection_note)
                            <div class="mt-4 p-4 bg-gray-50 border rounded-lg">
                                <p class="text-sm font-bold text-gray-700">Catatan:</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $submission->rejection_note }}</p>
                            </div>
                         @endif
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end mt-8">
                <a href="{{ route('admin_equity.matchresearch.show', $submission->session->id) }}" class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">Kembali ke Detail Sesi</a>
            </div>
        </div>
    </div>


    <div x-show="reviewModal" @keydown.escape.window="reviewModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" style="display: none;">
        <div @click.outside="reviewModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Catatan <span x-text="status === 'revisi' ? 'Revisi' : 'Penolakan'"></span></h2>
            <p class="text-sm text-gray-600 mb-6">Berikan catatan yang jelas. Catatan ini wajib diisi untuk status Revisi atau Tolak.</p>
            <form action="{{ route('admin_equity.matchresearch.submission.report.updateStatus', $submission->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" :value="status">
                <div>
                    <label for="rejection_note" class="sr-only">Catatan</label>
                    <textarea name="rejection_note" id="rejection_note" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Tuliskan catatan di sini..." required x-model="note"></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="reviewModal = false" class="px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-5 py-2 font-semibold rounded-lg" :class="{ 'bg-yellow-500 hover:bg-yellow-600 text-white': status === 'revisi', 'bg-red-600 hover:bg-red-700 text-white': status === 'tolak' }">
                        Kirim Hasil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

