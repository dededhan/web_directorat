@extends('admin_equity.index')

@php
if (!function_exists('getSubmissionStatusColor')) {
    function getSubmissionStatusColor($status) {
        switch ($status) {
            case 'diajukan':
                return 'bg-blue-100 text-blue-800 border-blue-200';
            case 'diterima':
                return 'bg-green-100 text-green-800 border-green-200';
            case 'ditolak_awal':
                return 'bg-red-100 text-red-800 border-red-200';
            case 'draft_laporan':
                return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'menunggu_penilaian':
                return 'bg-purple-100 text-purple-800 border-purple-200';
            case 'lolos':
                return 'bg-teal-100 text-teal-800 border-teal-200';
            case 'revisi':
                return 'bg-orange-100 text-orange-800 border-orange-200';
            case 'tolak':
                return 'bg-red-100 text-red-800 border-red-200';
            default:
                return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    }
}

if (!function_exists('getStatusIcon')) {
    function getStatusIcon($status) {
        switch ($status) {
            case 'diajukan':
                return 'bx-time-five';
            case 'diterima':
                return 'bx-check-circle';
            case 'ditolak_awal':
                return 'bx-x-circle';
            case 'draft_laporan':
                return 'bx-edit';
            case 'menunggu_penilaian':
                return 'bx-hourglass';
            case 'lolos':
                return 'bx-trophy';
            case 'revisi':
                return 'bx-refresh';
            case 'tolak':
                return 'bx-x-circle';
            default:
                return 'bx-info-circle';
        }
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="submissionDetail">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" 
                            class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.index') }}" 
                            class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.show', $submission->session->id) }}" 
                            class="hover:text-teal-600 transition-colors duration-200">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Proposal</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Pengajuan Proposal</h1>
                    <p class="mt-2 text-gray-600 text-base">Review detail proposal dan berikan status persetujuan atau lihat laporan akhir.</p>
                </div>
                <div class="flex items-center space-x-4 flex-shrink-0">
                    <a href="{{ route('admin_equity.matchresearch.show', $submission->session->id) }}" 
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali
                    </a>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border-2 {{ getSubmissionStatusColor($submission->status) }}">
                        <i class='bx {{ getStatusIcon($submission->status) }} mr-1 text-xs'></i>
                        {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                    </span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="xl:col-span-2 space-y-8">
                
                {{-- Detail Proposal --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bxs-file-doc text-xl mr-3'></i>
                            Informasi Proposal
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="p-4 bg-gradient-to-r from-teal-50 to-teal-100 rounded-xl border border-teal-200">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-bookmark text-teal-600 mr-2'></i>
                                <h3 class="text-xs font-bold uppercase text-teal-800 tracking-wide">Judul Proposal</h3>
                            </div>
                            <p class="text-gray-800 font-semibold text-base leading-relaxed">{{ $submission->judul_proposal }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <i class='bx bx-user text-blue-600 mr-2'></i>
                                    <h3 class="text-xs font-bold uppercase text-blue-800 tracking-wide">Dosen Ketua</h3>
                                </div>
                                <p class="text-gray-800 font-semibold">{{ $submission->user->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <i class='bx bx-calendar text-purple-600 mr-2'></i>
                                    <h3 class="text-xs font-bold uppercase text-purple-800 tracking-wide">Sesi</h3>
                                </div>
                                <p class="text-gray-800 font-semibold">{{ $submission->session->nama_sesi ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detail Anggota Tim --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-group text-xl mr-3'></i>
                            Anggota Tim Peneliti
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($submission->members as $index => $member)
                                <div class="border-2 border-gray-200 rounded-xl p-5 hover:border-gray-300 transition-colors">
                                    @if($member->type === 'unj')
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                    <i class='bx bx-user text-blue-500 text-xl'></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h3 class="font-semibold text-gray-800 text-lg">{{ $member->user->name ?? 'Dosen UNJ' }}</h3>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        <i class='bx bx-home mr-1 text-xs'></i>
                                                        Dosen UNJ
                                                    </span>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3 text-sm">
                                                    <div class="p-2 bg-gray-50 rounded-lg">
                                                        <span class="text-gray-500 font-medium">NIP/NIDN:</span>
                                                        <p class="text-gray-800 font-semibold">{{ $member->user->identifier_number ?? '-' }}</p>
                                                    </div>
                                                    <div class="p-2 bg-gray-50 rounded-lg">
                                                        <span class="text-gray-500 font-medium">Fakultas:</span>
                                                        <p class="text-gray-800 font-semibold">{{ $member->user->fakultas ?? '-' }}</p>
                                                    </div>
                                                    <div class="p-2 bg-gray-50 rounded-lg">
                                                        <span class="text-gray-500 font-medium">Program Studi:</span>
                                                        <p class="text-gray-800 font-semibold">{{ $member->user->prodi ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($member->type === 'international')
                                        @php $details = $member->details; @endphp
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl flex items-center justify-center">
                                                    <i class='bx bx-world text-teal-600 text-xl'></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h3 class="font-semibold text-teal-700 text-lg">{{ $details['name'] ?? 'Mitra Internasional' }}</h3>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800 border border-teal-200">
                                                        <i class='bx bx-world mr-1 text-xs'></i>
                                                        {{ $details['country'] ?? 'International' }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-3">{{ $details['institution'] ?? '' }}</p>
                                                
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                                    @if(isset($details['expertise']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Keahlian:</span>
                                                            <p class="text-gray-800 font-semibold">{{ $details['expertise'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['scopus_link']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Scopus:</span>
                                                            <a href="{{ $details['scopus_link'] }}" target="_blank" 
                                                                class="text-teal-600 hover:text-teal-800 hover:underline font-semibold inline-flex items-center">
                                                                Lihat Profil <i class='bx bx-external-link ml-1 text-xs'></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['journal_name']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Jurnal:</span>
                                                            <p class="text-gray-800 font-semibold">{{ $details['journal_name'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['scimago_link']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Scimago:</span>
                                                            <a href="{{ $details['scimago_link'] }}" target="_blank" 
                                                                class="text-teal-600 hover:text-teal-800 hover:underline font-semibold inline-flex items-center">
                                                                Lihat Jurnal <i class='bx bx-external-link ml-1 text-xs'></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['organization_name']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Organisasi:</span>
                                                            <p class="text-gray-800 font-semibold">{{ $details['organization_name'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['organization_link']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Link Organisasi:</span>
                                                            <a href="{{ $details['organization_link'] }}" target="_blank" 
                                                                class="text-teal-600 hover:text-teal-800 hover:underline font-semibold inline-flex items-center">
                                                                Lihat Organisasi <i class='bx bx-external-link ml-1 text-xs'></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['membership_id']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">ID Keanggotaan:</span>
                                                            <p class="text-gray-800 font-semibold">{{ $details['membership_id'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['academy_name']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Akademi:</span>
                                                            <p class="text-gray-800 font-semibold">{{ $details['academy_name'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['membership_year']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Tahun Keanggotaan:</span>
                                                            <p class="text-gray-800 font-semibold">{{ $details['membership_year'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(isset($details['membership_proof']))
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <span class="text-teal-700 font-medium">Bukti Keanggotaan:</span>
                                                            <a href="{{ Storage::url($details['membership_proof']) }}" target="_blank" 
                                                                class="text-teal-600 hover:text-teal-800 hover:underline font-semibold inline-flex items-center">
                                                                Unduh Bukti <i class='bx bx-download ml-1 text-xs'></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar - Action Panel --}}
            <div class="xl:col-span-1">
                <div class="sticky top-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                <i class='bx bx-cog text-xl mr-3'></i>
                                Panel Aksi
                            </h2>
                        </div>
                        <div class="p-6">
                            @if ($submission->status === 'diajukan')
                                <div class="mb-6">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full">
                                        <i class='bx bx-time-five text-2xl text-blue-600'></i>
                                    </div>
                                    <h3 class="text-center text-lg font-semibold text-gray-800 mb-2">Menunggu Review</h3>
                                    <p class="text-sm text-gray-600 text-center mb-6">
                                        Proposal ini membutuhkan persetujuan Anda untuk melanjutkan ke tahap berikutnya.
                                    </p>
                                </div>
                                
                                <div class="space-y-3">
                                    <form action="{{ route('admin_equity.matchresearch.submission.updateStatus', $submission->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" name="status" value="diterima" 
                                            class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                            <i class='bx bx-check-circle mr-2'></i>
                                            Terima Proposal
                                        </button>
                                    </form>
                                    
                                    <button @click="rejectionModal = true" type="button" 
                                        class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                        <i class='bx bx-x-circle mr-2'></i>
                                        Tolak Proposal
                                    </button>
                                </div>
                            @else
                                @php
                                    $statusIconMap = [
                                        'diterima' => ['icon' => 'bx-check-circle', 'color' => 'green', 'bg' => 'green-100'],
                                        'ditolak_awal' => ['icon' => 'bx-x-circle', 'color' => 'red', 'bg' => 'red-100'],
                                        'draft_laporan' => ['icon' => 'bx-edit', 'color' => 'yellow', 'bg' => 'yellow-100'],
                                        'menunggu_penilaian' => ['icon' => 'bx-hourglass', 'color' => 'purple', 'bg' => 'purple-100'],
                                        'lolos' => ['icon' => 'bx-trophy', 'color' => 'teal', 'bg' => 'teal-100'],
                                        'revisi' => ['icon' => 'bx-refresh', 'color' => 'orange', 'bg' => 'orange-100'],
                                        'tolak' => ['icon' => 'bx-x-circle', 'color' => 'red', 'bg' => 'red-100']
                                    ];
                                    $statusInfo = $statusIconMap[$submission->status] ?? ['icon' => 'bx-info-circle', 'color' => 'gray', 'bg' => 'gray-100'];
                                @endphp
                                <div class="text-center">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-{{ $statusInfo['bg'] }} rounded-full">
                                        <i class='bx {{ $statusInfo['icon'] }} text-2xl text-{{ $statusInfo['color'] }}-600'></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ ucwords(str_replace('_', ' ', $submission->status)) }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">
                                        Proposal ini sudah diproses dengan status: <strong class="font-semibold text-{{ $statusInfo['color'] }}-700">{{ ucwords(str_replace('_', ' ', $submission->status)) }}</strong>
                                    </p>
                                    
                                    @if(in_array($submission->status, ['menunggu_penilaian', 'lolos', 'revisi', 'tolak']))
                                        <a href="{{ route('admin_equity.matchresearch.submission.report.show', $submission->id) }}" 
                                            class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <i class='bx bx-file-blank mr-2'></i>
                                            Lihat Laporan Akhir
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rejection Modal --}}
    <div x-show="rejectionModal" @keydown.escape.window="rejectionModal = false" 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" 
        style="display: none;">
        <div @click.outside="rejectionModal = false" 
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class='bx bx-x-circle mr-2 text-red-600'></i>
                        Alasan Penolakan
                    </h2>
                    <button @click="rejectionModal = false" 
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
            </div>
            
            <form action="{{ route('admin_equity.matchresearch.submission.updateStatus', $submission->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="ditolak_awal">
                
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Berikan alasan mengapa proposal ini ditolak. Catatan ini akan dapat dilihat oleh dosen pengusul.
                    </p>
                    <div>
                        <label for="rejection_note" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_note" id="rejection_note" rows="4" 
                            class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 resize-none" 
                            placeholder="Tuliskan alasan penolakan yang jelas dan konstruktif..." 
                            required></textarea>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex justify-end space-x-3">
                    <button type="button" @click="rejectionModal = false" 
                        class="px-5 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all transform hover:scale-105">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('submissionDetail', () => ({
        rejectionModal: false
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