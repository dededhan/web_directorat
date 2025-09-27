@extends('subdirektorat-inovasi.dosen.index')

@php
function getStatusColor($status) {
    switch ($status) {
        case 'diajukan':
            return 'bg-blue-100 text-blue-800';
        case 'diterima':
            return 'bg-green-100 text-green-800';
        case 'ditolak_awal':
            return 'bg-red-100 text-red-800';
        case 'draft_laporan':
            return 'bg-yellow-100 text-yellow-800';
        case 'menunggu_penilaian':
            return 'bg-purple-100 text-purple-800';
        case 'lolos':
            return 'bg-teal-100 text-teal-800';
        case 'revisi':
            return 'bg-orange-100 text-orange-800';
        case 'tolak':
             return 'bg-red-100 text-red-800';
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

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase w-5/12">Judul Proposal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase w-3/12">Sesi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase w-2/12">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase w-2/12">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($submissions as $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $submission->judul_proposal }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-700">{{ $submission->session->nama_sesi ?? 'Sesi Dihapus' }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ getStatusColor($submission->status) }}">
                                        {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @if($submission->status === 'diajukan')
                                            <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.edit', $submission->id) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200" title="Edit Pengajuan">
                                                <i class='bx bxs-edit text-lg'></i>
                                            </a>
                                        @elseif($submission->status === 'diterima')
                                            <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.form', $submission->id) }}" class="px-3 py-2 text-sm text-white bg-teal-600 rounded-lg hover:bg-teal-700 font-semibold" title="Lengkapi Laporan">
                                                Lengkapi Laporan
                                            </a>
                                        @elseif($submission->status === 'draft_laporan')
                                             <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.report.form', $submission->id) }}" class="px-3 py-2 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 font-semibold" title="Lanjutkan Laporan">
                                                Lanjutkan Laporan
                                            </a>
                                        @else
                                            <button class="p-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed" title="Tidak ada aksi">
                                                <i class='bx bx-show-alt text-lg'></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-20 px-6">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-folder-open text-6xl text-gray-300'></i>
                                        <h3 class="font-semibold text-lg text-gray-700 mt-4">Anda Belum Memiliki Proposal</h3>
                                        <p class="text-sm text-gray-500">Silakan usulkan proposal baru untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($submissions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

