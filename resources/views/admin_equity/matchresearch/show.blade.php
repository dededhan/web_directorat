@extends('admin_equity.index')

@php

if (!function_exists('getSubmissionStatusColor')) {
    function getSubmissionStatusColor($status) {
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
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">


        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.index') }}" class="hover:text-teal-600">Manajemen Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $session->nama_sesi }}</h1>
                <p class="mt-2 text-gray-600">Kelola semua proposal yang masuk dalam sesi ini.</p>
            </div>
        </header>


        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 bg-gray-50 border-b">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class='bx bxs-file-doc mr-3 text-teal-600'></i>
                    Daftar Proposal Masuk
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dosen Pengusul</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Judul Proposal</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($session->submissions as $submission)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $submission->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $submission->judul_proposal }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ getSubmissionStatusColor($submission->status) }}">
                                    {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin_equity.matchresearch.submission.show', $submission->id) }}" class="text-teal-600 hover:text-teal-800 font-semibold">
      
                                    @if($submission->status == 'diajukan')
                                        Verifikasi
                                    @else
                                        Lihat Detail
                                    @endif
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-16 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class='bx bx-folder-open text-6xl text-gray-300'></i>
                                    <h3 class="font-semibold text-lg text-gray-700 mt-4">Belum Ada Proposal</h3>
                                    <p class="text-sm">Belum ada proposal yang diajukan untuk sesi ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

