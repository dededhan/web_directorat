@extends('subdirektorat-inovasi.dosen.index')

@php
function getStatusColor($status) {
    switch ($status) {
        case 'diajukan':
            return 'bg-blue-100 text-blue-800';
        case 'diterima':
            return 'bg-green-100 text-green-800';
        case 'ditolak_awal':
        case 'tolak':
            return 'bg-red-100 text-red-800';
        case 'draft_laporan':
            return 'bg-yellow-100 text-yellow-800';
        case 'menunggu_penilaian':
            return 'bg-purple-100 text-purple-800';
        case 'lolos':
            return 'bg-teal-100 text-teal-800';
        case 'revisi':
            return 'bg-orange-100 text-orange-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                 <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="#" class="hover:text-teal-600">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Manajemen Proposal Matchmaking</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Proposal Matchmaking</h1>
                    <p class="mt-2 text-gray-600">Semua proposal riset yang telah Anda ajukan.</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}"
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all">
                    <i class='bx bx-plus-circle mr-2 text-lg'></i>
                    Usulkan Proposal Baru
                </a>
            </div>
        </header>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                 <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="space-y-8">
            @forelse ($groupedSubmissions as $sessionName => $submissions)
                <div x-data="{ openNoteId: null }" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-5 bg-gray-50 border-b">
                        <h2 class="text-lg font-bold text-gray-700">{{ $sessionName ?: 'Sesi Lainnya' }}</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase w-7/12">Judul Proposal</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase w-2/12">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase w-3/12">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($submissions as $submission)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-900 text-sm">{{ $submission->judul_proposal }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ getStatusColor($submission->status) }}">
                                                {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                @if($submission->status === 'diajukan')
                                                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.edit', $submission->id) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200" title="Edit Pengajuan">
                                                        <i class='bx bxs-edit text-lg'></i>
                                                    </a>
                                                @elseif(in_array($submission->status, ['diterima', 'draft_laporan']))
                                                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.form', $submission->id) }}" class="px-3 py-2 text-sm text-white {{ $submission->status === 'diterima' ? 'bg-teal-600 hover:bg-teal-700' : 'bg-yellow-500 hover:bg-yellow-600' }} rounded-lg font-semibold" title="{{ $submission->status === 'diterima' ? 'Lengkapi Laporan' : 'Lanjutkan Laporan' }}">
                                                        {{ $submission->status === 'diterima' ? 'Lengkapi Laporan' : 'Lanjutkan Laporan' }}
                                                    </a>
                                                @else
                                                     @if (!in_array($submission->status, ['ditolak_awal', 'revisi', 'tolak']) || !$submission->rejection_note)
                                                        <span class="p-2 text-gray-400" title="Tidak ada aksi yang tersedia">-</span>
                                                     @endif
                                                @endif

                                                @if (($submission->status == 'ditolak_awal' || $submission->status == 'revisi' || $submission->status == 'tolak') && $submission->rejection_note)
                                                <button @click="openNoteId = (openNoteId === {{ $submission->id }} ? null : {{ $submission->id }})" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200" title="Lihat Catatan">
                                                    <i class='bx bxs-comment-detail text-lg'></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @if (($submission->status == 'ditolak_awal' || $submission->status == 'revisi' || $submission->status == 'tolak') && $submission->rejection_note)
                                    <tr x-show="openNoteId === {{ $submission->id }}" x-transition>
                                        <td colspan="3" class="px-6 py-3 text-sm bg-red-50">
                                            <div class="flex items-start">
                                                <i class='bx bxs-info-circle text-red-500 text-lg mr-2 mt-0.5'></i>
                                                <div>
                                                    <strong class="font-semibold text-red-800">Catatan dari Admin:</strong>
                                                    <p class="text-red-700">{{ $submission->rejection_note }}</p>
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
            @empty
                <div class="text-center py-20 px-6 bg-white rounded-2xl shadow-lg border">
                    <div class="flex flex-col items-center">
                        <i class='bx bx-folder-open text-6xl text-gray-300'></i>
                        <h3 class="font-semibold text-lg text-gray-700 mt-4">Anda Belum Memiliki Proposal</h3>
                        <p class="text-sm text-gray-500">Silakan usulkan proposal baru untuk memulai.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection

