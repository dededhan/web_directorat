@extends('subdirektorat-inovasi.dosen.index')

@php
function getStatusColor($status) {
    switch ($status) {
        case 'diajukan':
            return 'bg-green-100 text-green-800 border-2 border-green-200';
        case 'diterima':
            return 'bg-teal-100 text-teal-800 border-2 border-teal-200';
        case 'ditolak_awal':
        case 'tolak':
            return 'bg-red-100 text-red-800 border-2 border-red-200';
        case 'draft_laporan':
            return 'bg-amber-100 text-amber-800 border-2 border-amber-200';
        case 'menunggu_penilaian':
            return 'bg-purple-100 text-purple-800 border-2 border-purple-200';
        case 'lolos':
            return 'bg-emerald-100 text-emerald-800 border-2 border-emerald-200';
        case 'revisi':
            return 'bg-orange-100 text-orange-800 border-2 border-orange-200';
        default:
            return 'bg-gray-100 text-gray-800 border-2 border-gray-200';
    }
}

function getStatusIcon($status) {
    switch ($status) {
        case 'diajukan':
            return 'bxs-check-circle';
        case 'diterima':
            return 'bxs-like';
        case 'ditolak_awal':
        case 'tolak':
            return 'bxs-x-circle';
        case 'draft_laporan':
            return 'bxs-time-five';
        case 'menunggu_penilaian':
            return 'bxs-hourglass';
        case 'lolos':
            return 'bxs-trophy';
        case 'revisi':
            return 'bxs-edit';
        default:
            return 'bxs-info-circle';
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Judul Halaman --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="#" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Manajemen Proposal Matchmaking</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Portfolio Proposal Matchmaking</h1>
                    <p class="mt-2 text-gray-600 text-base">Semua proposal riset matchmaking yang telah Anda ajukan.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                        Usulkan Proposal Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-xl shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class='bx bxs-check-circle text-green-400 text-xl mr-3'></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-xl shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class='bx bxs-error text-red-400 text-xl mr-3'></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="space-y-8">
            @forelse ($groupedSubmissions as $sessionName => $submissions)
                <div x-data="{ openNoteId: null }" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    {{-- Session Header --}}
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                        <div class="flex items-center justify-between text-white">
                            <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                                <i class='bx bx-folder-open mr-3 text-2xl'></i>
                                {{ $sessionName ?: 'Sesi Lainnya' }}
                            </h2>
                            <div class="text-teal-100 text-sm">
                                Total: <span class="font-semibold text-white">{{ count($submissions) }} proposal</span>
                            </div>
                        </div>
                    </div>

                    {{-- Desktop Table View --}}
                    <div class="hidden lg:block overflow-visible">
                        <div class="w-full overflow-visible">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-6/12">
                                            <div class="flex items-center space-x-1">
                                                <i class='bx bx-file-blank text-base text-teal-500'></i>
                                                <span>Judul Proposal</span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">
                                            <div class="flex items-center justify-center space-x-1">
                                                <i class='bx bx-info-circle text-base text-indigo-500'></i>
                                                <span>Status</span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">
                                            <div class="flex items-center justify-center space-x-1">
                                                <i class='bx bx-cog text-base text-teal-600'></i>
                                                <span>Aksi</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($submissions as $submission)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-4 py-5">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl flex items-center justify-center">
                                                            <i class='bx bx-file-blank text-teal-500 text-xl'></i>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                            {{ $submission->judul_proposal }}
                                                        </p>
                                                        <p class="text-xs lg:text-sm text-gray-500 mt-1 flex items-center">
                                                            <i class='bx bx-time text-xs mr-1'></i>
                                                            <span>Matchmaking Research</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ getStatusColor($submission->status) }}">
                                                    <i class='bx {{ getStatusIcon($submission->status) }} mr-1 text-xs'></i>
                                                    {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    @if($submission->status === 'diajukan')
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.edit', $submission->id) }}" 
                                                           class="inline-flex items-center px-3 py-2 bg-yellow-100 text-yellow-800 rounded-xl hover:bg-yellow-200 transition-all duration-200 font-medium text-sm border-2 border-yellow-200 hover:border-yellow-300" 
                                                           title="Edit Pengajuan">
                                                            <i class='bx bxs-edit mr-1 text-sm'></i>
                                                            Edit
                                                        </a>
                                                    @elseif(in_array($submission->status, ['diterima', 'draft_laporan']))
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.form', $submission->id) }}" 
                                                           class="inline-flex items-center px-3 py-2 {{ $submission->status === 'diterima' ? 'bg-teal-600 hover:bg-teal-700' : 'bg-amber-500 hover:bg-amber-600' }} text-white rounded-xl transition-all duration-200 font-semibold text-sm shadow-md hover:shadow-lg transform hover:scale-105" 
                                                           title="{{ $submission->status === 'diterima' ? 'Lengkapi Laporan' : 'Lanjutkan Laporan' }}">
                                                            <i class='bx bx-file-plus mr-1'></i>
                                                            {{ $submission->status === 'diterima' ? 'Lengkapi Laporan' : 'Lanjutkan Laporan' }}
                                                        </a>
                                                    @else
                                                        @if (!in_array($submission->status, ['ditolak_awal', 'revisi', 'tolak']) || !$submission->rejection_note)
                                                            <span class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-500 rounded-xl text-sm font-medium border-2 border-gray-200" title="Tidak ada aksi yang tersedia">
                                                                <i class='bx bx-minus mr-1'></i>
                                                                Tidak ada aksi
                                                            </span>
                                                        @endif
                                                    @endif

                                                    @if (($submission->status == 'ditolak_awal' || $submission->status == 'revisi' || $submission->status == 'tolak') && $submission->rejection_note)
                                                        <button @click="openNoteId = (openNoteId === {{ $submission->id }} ? null : {{ $submission->id }})" 
                                                                class="inline-flex items-center px-3 py-2 bg-red-100 text-red-800 rounded-xl hover:bg-red-200 transition-all duration-200 font-medium text-sm border-2 border-red-200 hover:border-red-300" 
                                                                title="Lihat Catatan">
                                                            <i class='bx bxs-comment-detail mr-1 text-sm'></i>
                                                            Lihat Catatan
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @if (($submission->status == 'ditolak_awal' || $submission->status == 'revisi' || $submission->status == 'tolak') && $submission->rejection_note)
                                            <tr x-show="openNoteId === {{ $submission->id }}" 
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                x-transition:leave-end="opacity-0 transform scale-95"
                                                style="display: none;">
                                                <td colspan="3" class="px-4 py-4">
                                                    <div class="bg-red-50 border-l-4 border-red-400 rounded-xl p-4 mx-2">
                                                        <div class="flex items-start">
                                                            <i class='bx bxs-info-circle text-red-500 text-lg mr-3 mt-0.5'></i>
                                                            <div>
                                                                <h4 class="font-bold text-red-800 mb-2">Catatan dari Admin:</h4>
                                                                <p class="text-red-700 text-sm leading-relaxed">{{ $submission->rejection_note }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="lg:hidden">
                        @foreach ($submissions as $submission)
                            <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-start space-x-3 flex-1 min-w-0">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-gradient-to-br from-teal-100 to-teal-200 rounded-lg flex items-center justify-center">
                                                <i class='bx bx-file-blank text-teal-500 text-lg'></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                                {{ $submission->judul_proposal }}
                                            </h3>
                                            <p class="text-xs text-gray-500 flex items-center">
                                                <i class='bx bx-time text-xs mr-1'></i>
                                                Matchmaking Research
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ getStatusColor($submission->status) }}">
                                            <i class='bx {{ getStatusIcon($submission->status) }} mr-1 text-xs'></i>
                                            {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    @if($submission->status === 'diajukan')
                                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.edit', $submission->id) }}" 
                                           class="w-full flex items-center justify-center px-4 py-2 bg-yellow-50 border-2 border-yellow-200 rounded-xl text-sm font-medium text-yellow-700 hover:bg-yellow-100 hover:border-yellow-300 transition-all">
                                            <i class='bx bxs-edit mr-2'></i>
                                            Edit Pengajuan
                                        </a>
                                    @elseif(in_array($submission->status, ['diterima', 'draft_laporan']))
                                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.form', $submission->id) }}" 
                                           class="w-full flex items-center justify-center px-4 py-2 {{ $submission->status === 'diterima' ? 'bg-teal-600 hover:bg-teal-700' : 'bg-amber-500 hover:bg-amber-600' }} text-white rounded-xl text-sm font-semibold transition-all">
                                            <i class='bx bx-file-plus mr-2'></i>
                                            {{ $submission->status === 'diterima' ? 'Lengkapi Laporan' : 'Lanjutkan Laporan' }}
                                        </a>
                                    @else
                                        @if (!in_array($submission->status, ['ditolak_awal', 'revisi', 'tolak']) || !$submission->rejection_note)
                                            <div class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-500">
                                                <i class='bx bx-minus mr-2'></i>
                                                Tidak ada aksi tersedia
                                            </div>
                                        @endif
                                    @endif

                                    @if (($submission->status == 'ditolak_awal' || $submission->status == 'revisi' || $submission->status == 'tolak') && $submission->rejection_note)
                                        <div x-data="{ showNote: false }" class="w-full">
                                            <button @click="showNote = !showNote" 
                                                    class="w-full flex items-center justify-center px-4 py-2 bg-red-50 border-2 border-red-200 rounded-xl text-sm font-medium text-red-700 hover:bg-red-100 hover:border-red-300 transition-all">
                                                <i class='bx bxs-comment-detail mr-2'></i>
                                                <span>Lihat Catatan</span>
                                                <i class='bx bx-chevron-down ml-2 transform transition-transform' :class="showNote ? 'rotate-180' : ''"></i>
                                            </button>
                                            <div x-show="showNote" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 transform scale-95"
                                                 x-transition:enter-end="opacity-100 transform scale-100"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 transform scale-100"
                                                 x-transition:leave-end="opacity-0 transform scale-95"
                                                 class="mt-2 bg-red-50 border-l-4 border-red-400 rounded-xl p-3"
                                                 style="display: none;">
                                                <div class="flex items-start">
                                                    <i class='bx bxs-info-circle text-red-500 text-sm mr-2 mt-0.5'></i>
                                                    <div>
                                                        <h5 class="font-semibold text-red-800 text-sm mb-1">Catatan Admin:</h5>
                                                        <p class="text-red-700 text-xs leading-relaxed">{{ $submission->rejection_note }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="text-center py-20 px-6">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                <i class='bx bx-folder-open text-4xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 mb-2">Anda Belum Memiliki Proposal</h3>
                            <p class="text-gray-500 mb-8 max-w-md">Mulailah dengan mengajukan proposal matchmaking research untuk memulai kolaborasi penelitian.</p>
                            <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}"
                               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                Usulkan Proposal Baru
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

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

        .break-words {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        table {
            table-layout: fixed;
            width: 100%;
        }

        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush
@endsection