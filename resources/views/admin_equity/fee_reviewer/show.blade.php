@extends('admin_equity.index')

@php
if (!function_exists('getStatusInfoAdmin')) {
    function getStatusInfoAdmin($status) {
        switch ($status) {
            case 'diajukan': return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
            case 'verifikasi': return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Verifikasi'];
            case 'verifikasi pembayaran': return ['color' => 'purple', 'icon' => 'bx-credit-card', 'text' => 'Verifikasi Pembayaran'];
            case 'revisi': return ['color' => 'orange', 'icon' => 'bx-edit', 'text' => 'Revisi'];
            case 'disetujui': return ['color' => 'green', 'icon' => 'bx-check-circle', 'text' => 'Disetujui'];
            case 'selesai': return ['color' => 'teal', 'icon' => 'bx-award', 'text' => 'Selesai'];
            case 'ditolak': return ['color' => 'red', 'icon' => 'bx-x-circle', 'text' => 'Ditolak'];
            default: return ['color' => 'gray', 'icon' => 'bx-question-mark', 'text' => 'Unknown'];
        }
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.fee_reviewer.index') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi Fee Reviewer</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $session->nama_sesi }}</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua fee_reviewer Dalam Sesi ini</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="bg-teal-100 text-teal-800 px-4 py-2.5 rounded-xl border-2 border-teal-200">
                        <p class="text-xs font-bold uppercase tracking-wide">Total Laporan</p>
                        <p class="text-lg font-bold">{{ $reports->total() }} Laporan</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            {{-- Header Card with Filter --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-file-blank mr-3 text-2xl'></i>
                            Daftar Laporan
                        </h2>
                        <p class="mt-2 text-teal-100">Filter dan kelola semua laporan yang masuk</p>
                    </div>
                    
                    {{-- Filter Form --}}
                    <form method="GET" action="{{ route('admin_equity.fee_reviewer.show', $session->id) }}" class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                            <div class="lg:col-span-7">
                                <label for="search" class="block text-xs font-bold uppercase text-teal-100 mb-2">Cari Laporan</label>
                                <input type="text" name="search" id="search" 
                                       class="w-full rounded-xl border-0 bg-white bg-opacity-90 backdrop-blur-sm text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-white focus:bg-white px-4 py-2.5" 
                                       placeholder="Nama dosen, judul artikel, nama laporan..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="lg:col-span-3">
                                <label for="status" class="block text-xs font-bold uppercase text-teal-100 mb-2">Filter Status</label>
                                <select name="status" id="status" 
                                        class="w-full rounded-xl border-0 bg-white bg-opacity-90 backdrop-blur-sm text-gray-800 focus:ring-2 focus:ring-white focus:bg-white px-4 py-2.5">
                                    <option value="">Semua Status</option>
                                    <option value="diajukan" @if(request('status') == 'diajukan') selected @endif>Diajukan</option>
                                    <option value="verifikasi" @if(request('status') == 'verifikasi') selected @endif>Verifikasi</option>

  <option value="verifikasi pembayaran" @if(request('status') == 'verifikasi pembayaran') selected @endif>Verifikasi Pembayaran</option>
    <option value="revisi" @if(request('status') == 'revisi') selected @endif>Revisi</option>
                                    <option value="disetujui" @if(request('status') == 'disetujui') selected @endif>Disetujui</option>
                                                                        <option value="verifikasi pembayaran" @if(request('status') == 'verifikasi pembayaran') selected @endif>Verifikasi Pembayaran</option>
                                    <option value="selesai" @if(request('status') == 'selesai') selected @endif>Selesai</option>
                                    <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                </select>
                            </div>
                            <div class="lg:col-span-2 flex items-end gap-2">
                                <button type="submit" 
                                        class="flex-1 px-4 py-2.5 bg-white text-teal-600 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                    <i class='bx bx-search mr-2'></i>
                                    Filter
                                </button>
                                <a href="{{ route('admin_equity.fee_reviewer.show', $session->id) }}" 
                                   class="p-2.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-xl transition-all duration-200 backdrop-blur-sm flex items-center justify-center"
                                   title="Reset Filter">
                                    <i class='bx bx-refresh text-xl'></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-visible">
                <div class="w-full overflow-visible">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-5/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-file-blank text-base text-blue-500'></i>
                                        <span>Jurnal & Artikel</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-user text-base text-indigo-500'></i>
                                        <span>Dosen Pengusul</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class='bx bx-info-circle text-base text-yellow-500'></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class='bx bx-cog text-base text-teal-600'></i>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($reports as $report)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                    <i class='bx bx-book-content text-blue-500 text-xl'></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                    {{ $report->nama_jurnal }}
                                                </p>
                                                <p class="text-xs lg:text-sm text-gray-500 mt-1 line-clamp-2">
                                                    {{ $report->judul_artikel }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center">
                                                    <i class='bx bx-user text-indigo-500 text-lg'></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-semibold text-gray-900 text-sm">{{ $report->user->name ?? 'N/A' }}</p>
                                                <p class="text-xs text-gray-500">Dosen Pengusul</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @php $statusInfo = getStatusInfoAdmin($report->status); @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800 border-2 border-{{ $statusInfo['color'] }}-200">
                                            <i class='bx {{ $statusInfo['icon'] }} mr-1 text-xs'></i>
                                            {{ $statusInfo['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <a href="{{ route('admin_equity.fee_reviewer.report.show', $report->id) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg text-xs">
                                            <i class='bx bx-search-alt mr-1.5'></i>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-20">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                                <i class='bx bx-folder-open text-4xl text-gray-400'></i>
                                            </div>
                                            <h3 class="font-bold text-xl text-gray-800 mb-2">Data Tidak Ditemukan</h3>
                                            <p class="text-gray-500 max-w-md">Tidak ada laporan yang cocok dengan kriteria filter Anda. Coba ubah filter atau reset pencarian.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:hidden">
                @forelse ($reports as $report)
                    <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3 flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-book-content text-blue-500 text-lg'></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                        {{ $report->nama_jurnal }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-2">
                                        {{ $report->judul_artikel }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2">
                                @php $statusInfo = getStatusInfoAdmin($report->status); @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800 border border-{{ $statusInfo['color'] }}-200">
                                    <i class='bx {{ $statusInfo['icon'] }} mr-1 text-xs'></i>
                                    {{ $statusInfo['text'] }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4 space-y-3">
                            <div>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Dosen Pengusul</span>
                                <p class="text-gray-900 font-semibold flex items-center text-sm">
                                    <i class='bx bx-user text-indigo-500 text-xs mr-1'></i>
                                    {{ $report->user->name ?? 'N/A' }}
                                </p>
                            </div>

                        </div>

                        <div>
                            <a href="{{ route('admin_equity.fee_reviewer.report.show', $report->id) }}" 
                               class="w-full flex items-center justify-center px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                <i class='bx bx-search-alt mr-2'></i>
                                <span>Lihat Detail</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 px-6">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                <i class='bx bx-folder-open text-4xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 mb-2">Data Tidak Ditemukan</h3>
                            <p class="text-gray-500 max-w-md">Tidak ada laporan yang cocok dengan kriteria filter Anda. Coba ubah filter atau reset pencarian.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 pagination-wrapper">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .overflow-visible {
        overflow: visible !important;
    }

    .w-full.overflow-visible {
        width: 100%;
    }

    table {
        table-layout: fixed;
        width: 100%;
    }

    .break-words {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .bg-white.rounded-2xl {
        overflow: visible;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.25rem;
    }

    .pagination-wrapper .pagination a,
    .pagination-wrapper .pagination span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination-wrapper .pagination a:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    .pagination-wrapper .pagination .active span {
        background-color: #0d9488;
        color: white;
        border-color: #0d9488;
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush
