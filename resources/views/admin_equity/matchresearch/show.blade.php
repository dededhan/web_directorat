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
$statuses = ['diajukan', 'diterima', 'ditolak_awal', 'draft_laporan', 'menunggu_penilaian', 'lolos', 'revisi', 'tolak'];
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

        <!-- Form Filter -->
        <div class="mb-6 bg-white p-4 rounded-xl shadow-md border border-gray-100">
            <form action="{{ route('admin_equity.matchresearch.show', $session->id) }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="text-sm font-medium text-gray-700">Cari Judul/Pengusul</label>
                        <input type="text" name="search" id="search" placeholder="Masukkan kata kunci..." value="{{ $request['search'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ ($request['status'] ?? '') == $status ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Fakultas -->
                    <div>
                        <label for="fakultas_id" class="text-sm font-medium text-gray-700">Fakultas</label>
                        <select name="fakultas_id" id="fakultas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            <option value="">Semua Fakultas</option>
                            @foreach ($fakultas as $fak)
                                <option value="{{ $fak->id }}" {{ ($request['fakultas_id'] ?? '') == $fak->id ? 'selected' : '' }}>
                                    {{ $fak->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Prodi -->
                    <div>
                        <label for="prodi_id" class="text-sm font-medium text-gray-700">Program Studi</label>
                        <select name="prodi_id" id="prodi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" {{ !isset($request['fakultas_id']) ? 'disabled' : '' }}>
                            <option value="">Pilih Fakultas Dulu</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin_equity.matchresearch.show', $session->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Reset
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <i class='bx bx-filter-alt mr-2'></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>


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
                        @forelse ($submissions as $submission)
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
                                    <i class='bx bx-search-alt text-6xl text-gray-300'></i>
                                    <h3 class="font-semibold text-lg text-gray-700 mt-4">Tidak Ada Proposal Ditemukan</h3>
                                    <p class="text-sm">Tidak ada data proposal yang cocok dengan kriteria filter Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($submissions->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $submissions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
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
@endpush
@endsection
