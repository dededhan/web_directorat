@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="reportDetail">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" 
                            class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.show', $submission->session->id) }}" 
                            class="hover:text-teal-600 transition-colors duration-200">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Laporan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Laporan Kemajuan</h1>
                    <div class="mt-3 space-y-1">
                        <p class="text-gray-600 flex items-center">
                            <i class='bx bx-file-blank mr-2 text-teal-600'></i>
                            <span class="font-medium">Judul Proposal:</span>
                            <span class="ml-2 font-semibold text-teal-700">{{ $submission->judul_proposal }}</span>
                        </p>
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class='bx bx-user mr-2 text-blue-500'></i>
                            <span class="font-medium">Dosen Pengusul:</span>
                            <span class="ml-2">{{ $submission->user->name }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.matchresearch.show', $submission->session->id) }}" 
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali ke Detail Sesi
                    </a>
                </div>
            </div>
        </header>

        @php $report = $submission->report; @endphp

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="xl:col-span-2 space-y-8">
                
                {{-- Dokumen Utama --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-file-blank text-xl mr-3'></i>
                            Dokumen Utama
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @include('admin_equity.matchresearch._report_file_item', ['label' => 'Proposal Final', 'path' => $report->proposal_path, 'icon' => 'bx-file', 'color' => 'blue'])
                        @include('admin_equity.matchresearch._report_file_item', ['label' => 'Artikel', 'path' => $report->article_path, 'icon' => 'bx-news', 'color' => 'green'])
                    </div>
                </div>

                {{-- Detail Publikasi & Jurnal --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-paper-plane text-xl mr-3'></i>
                            Detail Publikasi & Jurnal
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <i class='bx bx-journal text-purple-600 mr-2'></i>
                                    <h3 class="text-sm font-bold text-purple-800 uppercase tracking-wide">Jurnal Q1 yang Dituju</h3>
                                </div>
                                <p class="text-gray-800 font-semibold">{{ $report->journal_q1_name ?: '-' }}</p>
                            </div>
                            <div class="md:col-span-2 p-4 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200">
                                <div class="flex items-center mb-2">
                                    <i class='bx bx-link text-indigo-600 mr-2'></i>
                                    <h3 class="text-sm font-bold text-indigo-800 uppercase tracking-wide">Link ScimagoJR</h3>
                                </div>
                                @if($report->scimagojr_link)
                                    <a href="{{ $report->scimagojr_link }}" target="_blank" 
                                        class="text-blue-600 hover:text-blue-800 hover:underline font-medium inline-flex items-center">
                                        {{ $report->scimagojr_link }}
                                        <i class='bx bx-external-link ml-1'></i>
                                    </a>
                                @else
                                    <p class="text-gray-500">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6 space-y-4">
                            @include('admin_equity.matchresearch._report_file_item', ['label' => 'Bukti Submit', 'path' => $report->submit_proof_path, 'icon' => 'bx-upload', 'color' => 'yellow'])
                            @include('admin_equity.matchresearch._report_file_item', ['label' => 'Bukti Under Review', 'path' => $report->review_proof_path, 'icon' => 'bx-time-five', 'color' => 'orange'])
                        </div>
                    </div>
                </div>

                {{-- Laporan Kunjungan & Responden --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-map-alt text-xl mr-3'></i>
                            Laporan Kunjungan & Responden
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-calendar text-green-600 mr-2'></i>
                                <h3 class="text-sm font-bold text-green-800 uppercase tracking-wide">Jumlah Hari Kunjungan</h3>
                            </div>
                            <p class="text-gray-800 font-semibold text-lg">{{ $report->visit_days }} Hari</p>
                        </div>
                        
                        @include('admin_equity.matchresearch._report_file_item', ['label' => 'Bukti Perjalanan (Tiket, Visa, dll.)', 'path' => $report->travel_proof_path, 'icon' => 'bx-trip', 'color' => 'teal'])

                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center mb-3">
                                <i class='bx bx-group text-amber-600 mr-2'></i>
                                <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wide">Responden QS</h3>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <ul class="space-y-2">
                                    @forelse($report->qs_respondents as $respondent)
                                        <li class="flex items-center text-gray-800">
                                            <i class='bx bx-user-circle text-amber-600 mr-2 text-sm'></i>
{{ $respondent['name'] ?? 'Nama tidak valid' }}
                                        </li>
                                    @empty
                                        <li class="flex items-center text-gray-500">
                                            <i class='bx bx-info-circle text-gray-400 mr-2 text-sm'></i>
                                            Tidak ada data responden.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar - Status Panel --}}
            <div class="xl:col-span-1">
                <div class="sticky top-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                <i class='bx bx-clipboard-check text-xl mr-3'></i>
                                Status Penilaian
                            </h2>
                        </div>
                        <div class="p-6">
                            @if($submission->status == 'menunggu_penilaian')
                                <div class="mb-6">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-yellow-100 rounded-full">
                                        <i class='bx bx-time text-2xl text-yellow-600'></i>
                                    </div>
                                    <h3 class="text-center text-lg font-semibold text-gray-800 mb-2">Menunggu Penilaian</h3>
                                    <p class="text-sm text-gray-600 text-center mb-6">
                                        Berikan penilaian akhir untuk laporan ini. Dosen akan menerima notifikasi mengenai status terbaru beserta catatan (jika ada).
                                    </p>
                                </div>
                                
                                <div class="space-y-3">
                                    <form action="{{ route('admin_equity.matchresearch.submission.report.updateStatus', $submission->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" name="status" value="lolos" 
                                            class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                            <i class='bx bx-check-circle mr-2'></i>
                                            Lolos
                                        </button>
                                    </form>
                                    
                                    <button @click="status = 'revisi'; reviewModal = true" type="button" 
                                        class="w-full px-4 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                        <i class='bx bx-edit mr-2'></i>
                                        Revisi
                                    </button>
                                    
                                    <button @click="status = 'tolak'; reviewModal = true" type="button" 
                                        class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                        <i class='bx bx-x-circle mr-2'></i>
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <div class="text-center">
                                    @php
                                        $statusConfig = [
                                            'lolos' => ['icon' => 'bx-check-circle', 'color' => 'green', 'label' => 'Lolos'],
                                            'revisi' => ['icon' => 'bx-edit', 'color' => 'yellow', 'label' => 'Revisi'],
                                            'tolak' => ['icon' => 'bx-x-circle', 'color' => 'red', 'label' => 'Ditolak']
                                        ];
                                        $config = $statusConfig[$submission->status] ?? ['icon' => 'bx-info-circle', 'color' => 'gray', 'label' => ucwords(str_replace('_', ' ', $submission->status))];
                                    @endphp
                                    
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-{{ $config['color'] }}-100 rounded-full">
                                        <i class='bx {{ $config['icon'] }} text-2xl text-{{ $config['color'] }}-600'></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $config['label'] }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">
                                        Laporan ini sudah dinilai dengan status: <strong class="font-semibold text-{{ $config['color'] }}-700">{{ $config['label'] }}</strong>
                                    </p>
                                    
                                    @if($submission->rejection_note)
                                        <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-xl text-left">
                                            <div class="flex items-center mb-2">
                                                <i class='bx bx-note text-gray-600 mr-2'></i>
                                                <p class="text-sm font-bold text-gray-700">Catatan:</p>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $submission->rejection_note }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Review Modal --}}
    <div x-show="reviewModal" @keydown.escape.window="reviewModal = false" 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" 
        style="display: none;">
        <div @click.outside="reviewModal = false" 
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class='bx bx-note mr-2 text-teal-600'></i>
                        Catatan <span x-text="status === 'revisi' ? 'Revisi' : 'Penolakan'"></span>
                    </h2>
                    <button @click="reviewModal = false" 
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
            </div>
            
            <form action="{{ route('admin_equity.matchresearch.submission.report.updateStatus', $submission->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" :value="status">
                
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Berikan catatan yang jelas. Catatan ini wajib diisi untuk status Revisi atau Tolak.
                    </p>
                    <div>
                        <label for="rejection_note" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_note" id="rejection_note" rows="4" 
                            class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 resize-none" 
                            placeholder="Tuliskan catatan yang detail dan konstruktif..." 
                            required x-model="note"></textarea>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex justify-end space-x-3">
                    <button type="button" @click="reviewModal = false; note = ''" 
                        class="px-5 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-5 py-2.5 font-semibold rounded-xl transition-all transform hover:scale-105" 
                        :class="{ 
                            'bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white': status === 'revisi', 
                            'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white': status === 'tolak' 
                        }">
                        <span x-text="status === 'revisi' ? 'Kirim Revisi' : 'Kirim Penolakan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('reportDetail', () => ({
        reviewModal: false,
        status: '',
        note: ''
    }));
});
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

    button:hover {
        transform: translateY(-1px);
    }

    .bg-white:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }

    .sticky {
        position: -webkit-sticky;
        position: sticky;
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush