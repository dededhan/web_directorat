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
$statuses = ['diajukan', 'verifikasi', 'disetujui', 'ditolak', 'revisi', 'verifikasi pembayaran', 'selesai'];
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
                            class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi Insentif Reviewer</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $session->nama_sesi }}</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua laporan Insentif Reviewer dalam sesi ini.</p>
                </div>
                 <div class="flex items-center space-x-4 flex-shrink-0">
                    <a href="{{ route('admin_equity.fee_reviewer.index') }}" 
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali
                    </a>
                    <div class="bg-white bg-opacity-80 backdrop-blur-sm px-4 py-2.5 rounded-xl border-2 border-teal-200">
                        <p class="text-xs font-bold uppercase tracking-wide text-teal-700">Total Laporan</p>
                        <p class="text-lg font-bold text-teal-800">{{ $reports->total() }} Laporan</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Filter Section --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class='bx bx-filter-alt text-xl mr-3'></i>
                    Filter & Pencarian
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('admin_equity.fee_reviewer.show', $session->id) }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Search Input --}}
                        <div class="lg:col-span-3 space-y-3">
                            <label for="search" class="text-sm font-bold text-gray-700 flex items-center">
                                <i class='bx bx-search mr-2 text-teal-600'></i>
                                Cari Judul/Jurnal/Pengusul
                            </label>
                            <input type="text" name="search" id="search" 
                                placeholder="Masukkan kata kunci pencarian..." 
                                value="{{ $request['search'] ?? '' }}" 
                                class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-all duration-200 bg-white hover:border-gray-400">
                        </div>

                        {{-- Filter Status --}}
                        <div class="space-y-3">
                            <label for="status" class="text-sm font-bold text-gray-700 flex items-center">
                                <i class='bx bx-info-circle mr-2 text-teal-600'></i>
                                Status Laporan
                            </label>
                            <select name="status" id="status" 
                                class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-all duration-200 bg-white hover:border-gray-400">
                                <option value="">-- Pilih Status --</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ ($request['status'] ?? '') == $status ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Fakultas --}}
                        <div class="space-y-3">
                            <label for="fakultas_id" class="text-sm font-bold text-gray-700 flex items-center">
                                <i class='bx bx-building mr-2 text-teal-600'></i>
                                Fakultas
                            </label>
                            <select name="fakultas_id" id="fakultas_id" 
                                class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-all duration-200 bg-white hover:border-gray-400">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultas as $fak)
                                    <option value="{{ $fak->id }}" {{ ($request['fakultas_id'] ?? '') == $fak->id ? 'selected' : '' }}>
                                        {{ $fak->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Prodi --}}
                        <div class="space-y-3">
                            <label for="prodi_id" class="text-sm font-bold text-gray-700 flex items-center">
                                <i class='bx bx-graduation mr-2 text-teal-600'></i>
                                Program Studi
                            </label>
                            <select name="prodi_id" id="prodi_id" 
                                class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-all duration-200 bg-white hover:border-gray-400 disabled:bg-gray-100 disabled:cursor-not-allowed" 
                                {{ !isset($request['fakultas_id']) || empty($request['fakultas_id']) ? 'disabled' : '' }}>
                                <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin_equity.fee_reviewer.show', $session->id) }}" 
                            class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-base font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class='bx bx-refresh mr-2 text-lg'></i>
                            Reset Filter
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-base font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-filter-alt mr-2 text-lg'></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
             <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bxs-file-doc mr-3 text-2xl'></i>
                            Daftar Laporan Masuk
                        </h2>
                        <p class="mt-2 text-teal-100">Monitor dan verifikasi semua laporan yang masuk</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2.5 rounded-xl border-2 border-white border-opacity-30">
                            <p class="text-xs font-bold uppercase tracking-wide text-teal-100">Hasil Filter</p>
                            <p class="text-lg font-bold">{{ $reports->count() }} dari {{ $reports->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[35%]">Jurnal & Artikel</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[20%]">Fakultas</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[20%]">Dosen Pengusul</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-[15%]">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-[10%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 align-top">
                                    <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                        {{ $report->nama_jurnal }}
                                    </p>
                                    <p class="text-xs lg:text-sm text-gray-500 mt-1 line-clamp-2">
                                        {{ $report->judul_artikel }}
                                    </p>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <p class="text-sm text-gray-900 break-words">
                                        {{ $report->user->profile?->prodi?->fakultas?->name ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-900 align-top">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $report->user->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $report->user->profile?->prodi?->name ?? 'Prodi tidak diketahui' }}</p>
                                </td>

                                <td class="px-6 py-5 text-center align-top">
                                    @php $statusInfo = getStatusInfoAdmin($report->status); @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800 border-2 border-{{ $statusInfo['color'] }}-200">
                                        <i class='bx {{ $statusInfo['icon'] }} mr-1 text-xs'></i>
                                        {{ $statusInfo['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center align-top">
                                    <a href="{{ route('admin_equity.fee_reviewer.report.show', $report->id) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg text-xs">
                                        <i class='bx bx-search-alt mr-1.5'></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-20">
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

            {{-- Mobile Card View --}}
            <div class="lg:hidden">
                @forelse ($reports as $report)
                    <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                             <div class="min-w-0 flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                    {{ $report->user->name ?? 'N/A' }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    {{ $report->user->profile?->prodi?->fakultas?->name ?? 'Fakultas tidak diketahui' }}
                                </p>
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
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Judul Artikel</span>
                                <p class="text-gray-900 font-medium text-sm leading-relaxed mt-1">
                                    {{ $report->judul_artikel }}
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
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fakultasSelect = document.getElementById('fakultas_id');
    const prodiSelect = document.getElementById('prodi_id');

    const selectedProdiId = '{{ $request['prodi_id'] ?? '' }}';

    function fetchProdi(fakultasId, selectedId = null) {
        if (!fakultasId) {
            prodiSelect.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
            prodiSelect.disabled = true;
            return;
        }

        fetch(`/api/prodi/${fakultasId}`)
            .then(response => response.json())
            .then(data => {
                prodiSelect.innerHTML = '<option value="">Semua Prodi</option>';
                data.forEach(prodi => {
                    const option = new Option(prodi.name, prodi.id);
                    if (selectedId && prodi.id == selectedId) {
                        option.selected = true;
                    }
                    prodiSelect.add(option);
                });
                prodiSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching prodi:', error);
                prodiSelect.innerHTML = '<option value="">Gagal memuat prodi</option>';
                prodiSelect.disabled = true;
            });
    }

    fakultasSelect.addEventListener('change', function () {
        fetchProdi(this.value);
    });

    if (fakultasSelect.value) {
        fetchProdi(fakultasSelect.value, selectedProdiId);
    }
});
</script>
@endpush


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
