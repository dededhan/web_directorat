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

$statuses = ['diajukan', 'diterima', 'ditolak_awal', 'draft_laporan', 'menunggu_penilaian', 'lolos', 'revisi', 'tolak'];
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="sessionDetail">
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
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $session->nama_sesi }}</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua proposal yang masuk dalam sesi ini.</p>
                </div>
                <div class="flex items-center space-x-4 flex-shrink-0">
                    <a href="{{ route('admin_equity.matchresearch.index') }}" 
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali
                    </a>
                    <div class="bg-white bg-opacity-80 backdrop-blur-sm px-4 py-2.5 rounded-xl border-2 border-teal-200">
                        <p class="text-xs font-bold uppercase tracking-wide text-teal-700">Total Proposal</p>
                        <p class="text-lg font-bold text-teal-800">{{ $submissions->total() }} Proposal</p>
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
                <form action="{{ route('admin_equity.matchresearch.show', $session->id) }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Search Input --}}
                        <div class="md:col-span-2 space-y-3">
                            <label for="search" class="text-sm font-bold text-gray-700 flex items-center">
                                <i class='bx bx-search mr-2 text-teal-600'></i>
                                Cari Judul/Pengusul
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
                                Status Proposal
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
                                {{ !isset($request['fakultas_id']) ? 'disabled' : '' }}>
                                <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                            </select>
                        </div>

                        {{-- Empty column for alignment --}}
                        <div></div>
                    </div>
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin_equity.matchresearch.show', $session->id) }}" 
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
            
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bxs-file-doc mr-3 text-2xl'></i>
                            Daftar Proposal Masuk
                        </h2>
                        <p class="mt-2 text-teal-100">Monitor dan verifikasi semua proposal yang masuk</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2.5 rounded-xl border-2 border-white border-opacity-30">
                            <p class="text-xs font-bold uppercase tracking-wide text-teal-100">Hasil Filter</p>
                            <p class="text-lg font-bold">{{ $submissions->count() }} dari {{ $submissions->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-visible">
                <div class="w-full overflow-visible">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-hash text-base text-gray-500'></i>
                                        <span>No</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-user text-base text-blue-500'></i>
                                        <span>Dosen Pengusul</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-4/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-file-blank text-base text-purple-500'></i>
                                        <span>Judul Proposal</span>
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
                            @forelse ($submissions as $submission)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5 text-sm text-gray-500">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="font-bold text-xs">{{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                    <i class='bx bx-user text-blue-500 text-xl'></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed">
                                                    {{ $submission->user->name ?? 'N/A' }}
                                                </p>
                                                <p class="text-xs lg:text-sm text-gray-500 mt-1">
                                                    {{ $submission->user->fakultas ?? 'Fakultas tidak diketahui' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                {{ $submission->judul_proposal }}
                                            </p>
                                            <p class="text-xs lg:text-sm text-gray-500 mt-1">
                                                Proposal Matchmaking Riset
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border-2 {{ getSubmissionStatusColor($submission->status) }}">
                                            <i class='bx {{ getStatusIcon($submission->status) }} mr-1 text-xs'></i>
                                            {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <a href="{{ route('admin_equity.matchresearch.submission.show', $submission->id) }}" 
                                            class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-sm hover:shadow-md text-xs">
                                            @if($submission->status == 'diajukan')
                                                <i class='bx bx-check-shield mr-1'></i>
                                                Verifikasi
                                            @else
                                                <i class='bx bx-show mr-1'></i>
                                                Lihat Detail
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-20">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                                <i class='bx bx-search-alt text-4xl text-gray-400'></i>
                                            </div>
                                            <h3 class="font-bold text-xl text-gray-800 mb-2">Tidak Ada Proposal Ditemukan</h3>
                                            <p class="text-gray-500 mb-4 max-w-md">Tidak ada data proposal yang cocok dengan kriteria filter Anda.</p>
                                            <a href="{{ route('admin_equity.matchresearch.show', $session->id) }}" 
                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                <i class='bx bx-refresh mr-2 text-lg'></i>
                                                Reset Filter
                                            </a>
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
                @forelse ($submissions as $submission)
                    <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3 flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-user text-blue-500 text-lg'></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                        {{ $submission->user->name ?? 'N/A' }}
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        {{ $submission->user->fakultas ?? 'Fakultas tidak diketahui' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ getSubmissionStatusColor($submission->status) }}">
                                    <i class='bx {{ getStatusIcon($submission->status) }} mr-1 text-xs'></i>
                                    {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Judul Proposal</span>
                            <p class="text-gray-900 font-medium text-sm leading-relaxed mt-1">
                                {{ $submission->judul_proposal }}
                            </p>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('admin_equity.matchresearch.submission.show', $submission->id) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all text-sm">
                                @if($submission->status == 'diajukan')
                                    <i class='bx bx-check-shield mr-2'></i>
                                    Verifikasi
                                @else
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                @endif
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 px-6">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                <i class='bx bx-search-alt text-4xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 mb-2">Tidak Ada Proposal Ditemukan</h3>
                            <p class="text-gray-500 max-w-md">Tidak ada data proposal yang cocok dengan kriteria filter Anda.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($submissions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $submissions->firstItem() ?? 0 }} hingga {{ $submissions->lastItem() ?? 0 }} dari {{ $submissions->total() }} hasil
                        </div>
                        <div class="pagination-wrapper">
                            {{ $submissions->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('sessionDetail', () => ({}));
});

document.addEventListener('DOMContentLoaded', function () {
    const fakultasSelect = document.getElementById('fakultas_id');
    const prodiSelect = document.getElementById('prodi_id');

    const selectedProdiId = '{{ $request['prodi_id'] ?? '' }}';

    function fetchProdi(fakultasId, selectedId = null) {
        if (!fakultasId) {
            prodiSelect.innerHTML = '<option value="">Pilih Fakultas Dulu</option>';
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
@endsection

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

    .w-full {
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