<?php
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Laporan Community Development</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola dan export laporan kegiatan Community Development</p>
                </div>
                <a href="{{ route('admin_equity.comdev.index') }}" 
                   class="inline-flex items-center rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Filter Laporan</h2>
            <form action="{{ route('admin_equity.comdev.laporan.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Tahun -->
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select name="tahun" id="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        <option value="">Semua Tahun</option>
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        <option value="">Semua Kategori</option>
                        <option value="pendidikan" {{ request('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="kesehatan" {{ request('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="lingkungan" {{ request('kategori') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                        <option value="ekonomi" {{ request('kategori') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                    </select>
                </div>

                <!-- Button Filter -->
                <div class="flex items-end">
                    <button type="submit" class="w-full rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        <i class='bx bx-filter-alt mr-2'></i>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Export Section -->
        <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Export Laporan</h2>
            <div class="flex flex-wrap gap-3">
                <button onclick="exportExcel()" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class='bx bxs-file-export mr-2'></i>
                    Export Excel
                </button>
                <button onclick="exportPDF()" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class='bx bxs-file-pdf mr-2'></i>
                    Export PDF
                </button>
                <button onclick="printReport()" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class='bx bx-printer mr-2'></i>
                    Print
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                        <i class='bx bxs-folder text-2xl text-blue-600'></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kegiatan</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalKegiatan ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                        <i class='bx bxs-check-circle text-2xl text-green-600'></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Selesai</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalCompleted ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100">
                        <i class='bx bxs-time text-2xl text-yellow-600'></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Dalam Proses</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalPending ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                        <i class='bx bxs-user-account text-2xl text-purple-600'></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Peserta</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalPeserta ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul Kegiatan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lokasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Peserta</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($kegiatan ?? [] as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->judul }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $item->tanggal }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->lokasi }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $item->jumlah_peserta }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                @if($item->status == 'completed')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Selesai</span>
                                @elseif($item->status == 'approved')
                                    <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">Disetujui</span>
                                @elseif($item->status == 'pending')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">Pending</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Ditolak</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                <a href="{{ route('admin_equity.comdev.show', $item->id) }}" 
                                   class="text-teal-600 hover:text-teal-900">
                                    <i class='bx bx-show text-xl'></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data kegiatan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($kegiatan) && $kegiatan->hasPages())
            <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                {{ $kegiatan->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function exportExcel() {
    // Get current filter parameters
    const params = new URLSearchParams(window.location.search);
    const url = "{{ route('admin_equity.comdev.laporan.export-excel') }}" + '?' + params.toString();
    window.location.href = url;
}

function exportPDF() {
    // Get current filter parameters
    const params = new URLSearchParams(window.location.search);
    const url = "{{ route('admin_equity.comdev.laporan.export-pdf') }}" + '?' + params.toString();
    window.open(url, '_blank');
}

function printReport() {
    window.print();
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection