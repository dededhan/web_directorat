@extends('admin_equity.index')

@php
    $statuses = \App\Enums\ComdevStatusEnum::cases();
@endphp

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header dan Breadcrumbs --}}
            <header class="mb-8">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="{{ route('admin_equity.dashboard') }}"
                                class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li><a href="{{ route('admin_equity.comdev.index') }}"
                                class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi Comdev</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800" aria-current="page">Proposal Masuk</li>
                    </ol>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Proposal Masuk</h1>
                        <p class="mt-2 text-gray-600 text-base">Sesi: <span
                                class="font-semibold text-teal-600">{{ $comdev->nama_sesi }}</span></p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin_equity.comdev.show', $comdev->id) }}"
                            class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                            <i class='bx bx-arrow-back text-lg mr-2'></i> Kembali
                        </a>
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
                    <form action="{{ route('admin_equity.comdev.submissions.index', $comdev->id) }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-3">
                                <label for="search" class="text-sm font-bold text-gray-700 block mb-2">Cari Judul /
                                    Pengusul</label>
                                <input type="text" name="search" id="search" placeholder="Masukkan kata kunci..."
                                    value="{{ $request['search'] ?? '' }}"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition">
                            </div>

                            <div>
                                <label for="status" class="text-sm font-bold text-gray-700 block mb-2">Status
                                    Proposal</label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition">
                                    <option value="">-- Semua Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }}"
                                            {{ ($request['status'] ?? '') == $status->value ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', Str::title($status->value)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="fakultas_id" class="text-sm font-bold text-gray-700 block mb-2">Fakultas</label>
                                <select name="fakultas_id" id="fakultas_id"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition">
                                    <option value="">-- Semua Fakultas --</option>
                                    @foreach ($fakultas as $fak)
                                        <option value="{{ $fak->id }}"
                                            {{ ($request['fakultas_id'] ?? '') == $fak->id ? 'selected' : '' }}>
                                            {{ $fak->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="prodi_id" class="text-sm font-bold text-gray-700 block mb-2">Program
                                    Studi</label>
                                <select name="prodi_id" id="prodi_id"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition disabled:bg-gray-100"
                                    {{ !isset($request['fakultas_id']) || empty($request['fakultas_id']) ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Fakultas Dulu --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-x-4">
                            <a href="{{ route('admin_equity.comdev.submissions.index', $comdev->id) }}"
                                class="px-6 py-3 border-2 border-gray-300 text-sm font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition">
                                Reset Filter
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-teal-600 text-white text-sm font-semibold rounded-xl hover:bg-teal-700 transition">
                                Terapkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            {{-- Daftar Proposal --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5">
                    <div class="flex items-center justify-between text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-file-find mr-3 text-2xl'></i>
                            Daftar Proposal Diajukan
                        </h2>
                        <div class="text-teal-100 text-sm">
                            Total: <span class="font-semibold text-white">{{ $submissions->total() }} proposal</span>
                        </div>
                    </div>
                </div>

                {{-- Tampilan Tabel untuk Desktop --}}
                <div class="hidden lg:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        No</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Judul Proposal</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Fakultas</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Ketua Pengusul</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Tanggal Diajukan</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($submissions as $submission)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-5 text-sm text-gray-500">
                                            {{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}
                                        </td>
                                        <td class="px-6 py-5 text-sm font-semibold text-gray-900 max-w-md"
                                            title="{{ $submission->judul }}">
                                            <p class="truncate">{{ $submission->judul }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            {{ $submission->user->profile?->prodi?->fakultas?->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            <p class="font-semibold">{{ $submission->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $submission->user->profile?->prodi?->name ?? '' }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            {{ $submission->updated_at->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                                        <td class="px-6 py-5 text-s text-center text-gray-600">
                                            @if ($submission->status)
                                                <span class="font-semibold">
                                                    {{ str_replace('_', ' ', Str::title($submission->status->value)) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 italic">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <a href="{{ route('admin_equity.comdev.submissions.show', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-xs rounded-lg hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                                                <i class='bx bx-search-alt mr-1.5'></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-20 px-6">
                                            <div class="flex flex-col items-center">
                                                <div
                                                    class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mb-6">
                                                    <i class='bx bx-data text-4xl text-gray-400'></i>
                                                </div>
                                                <h3 class="font-bold text-xl text-gray-800 mb-2">Data Tidak Ditemukan</h3>
                                                <p class="text-gray-500 max-w-md">Tidak ada proposal yang cocok dengan kriteria filter Anda. Silakan coba reset filter.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tampilan Kartu untuk Mobile --}}
                <div class="lg:hidden">
                    @forelse ($submissions as $submission)
                        <div class="p-4 border-b border-gray-100 last:border-b-0">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-semibold text-gray-900 text-sm leading-snug flex-1 mr-3">
                                    {{ $submission->judul }}</h3>
                                @if ($submission->status)
                                    <span
                                        class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ str_replace('_', ' ', Str::title($submission->status->value)) }}
                                    </span>
                                @endif
                            </div>
                            <div class="space-y-2 text-xs text-gray-600 mb-4">
                                <p class="flex items-center"><i
                                        class='bx bxs-user-circle mr-2 text-gray-400'></i>{{ $submission->user->name }}
                                </p>
                                <p class="flex items-center"><i
                                        class='bx bxs-buildings mr-2 text-gray-400'></i>{{ $submission->user->profile?->prodi?->fakultas?->name ?? 'N/A' }}
                                </p>
                                <p class="flex items-center"><i
                                        class='bx bxs-calendar mr-2 text-gray-400'></i>{{ $submission->updated_at->isoFormat('D MMMM YYYY, HH:mm') }}
                                </p>
                            </div>
                            <a href="{{ route('admin_equity.comdev.submissions.show', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}"
                                class="w-full text-center inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-xs rounded-lg hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                                <i class='bx bx-search-alt mr-1.5'></i> Detail & Kelola
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-16 px-4">
                             <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mb-6">
                                    <i class='bx bx-data text-4xl text-gray-400'></i>
                                </div>
                                <h3 class="font-bold text-xl text-gray-800 mb-2">Data Tidak Ditemukan</h3>
                                <p class="text-gray-500 max-w-md text-center">Tidak ada proposal yang cocok dengan kriteria filter Anda. Silakan coba reset filter.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($submissions->hasPages())
                    <div class="p-4 sm:p-6 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
                        {{ $submissions->links() }}
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

