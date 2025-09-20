@extends('admin_equity.index')

@push('styles')
{{-- Jika Anda menggunakan library seperti Select2, tambahkan CSS-nya di sini --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endpush


@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header dan Breadcrumbs --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail & Kelola Proposal</h1>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-sky-600">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-sky-600">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.submissions.index', $comdev->id) }}" class="hover:text-sky-600">Daftar Proposal Masuk</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Kelola Proposal</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Proposal & Penugasan Reviewer --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Card Detail Proposal --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bxs-file-doc text-xl mr-2 text-sky-600'></i>Informasi Proposal
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Judul</h3>
                        <p class="mt-1 text-md font-semibold text-gray-900">{{ $submission->judul }}</p>
                    </div>
                     <div>
                        <h3 class="text-sm font-medium text-gray-500">Ketua Tim Pengusul</h3>
                        <p class="mt-1 text-md text-gray-900">{{ $submission->user->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Abstrak</h3>
                        <p class="mt-1 text-md text-gray-700 leading-relaxed">{{ $submission->abstrak }}</p>
                    </div>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Tahun Usulan</h3>
                            <p class="mt-1 text-md text-gray-900">{{ $submission->tahun_usulan }}</p>
                        </div>
                         <div>
                            <h3 class="text-sm font-medium text-gray-500">Nominal Usulan</h3>
                            <p class="mt-1 text-md text-gray-900">Rp {{ number_format($submission->nominal_usulan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Tahapan Review (MODUL & SUB-BAB) --}}
            {{-- INI ADALAH BAGIAN DINAMIS YANG PERLU DATA DARI DATABASE (comdev_modules, comdev_sub_chapters, dll) --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                 <div class="p-4 border-b bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-sitemap text-xl mr-2 text-sky-600'></i>Tahapan Proposal & Review
                    </h2>
                </div>
                <div class="p-6">
                    {{-- CONTOH STRUKTUR LOOPING MODUL --}}
                    {{-- Anda perlu mengirim data $modules dari controller --}}
                    {{-- @foreach($modules as $module) --}}
                    <div class="mb-6 pb-4 border-b last:border-b-0">
                        <h3 class="text-md font-bold text-gray-800 mb-3">Modul A: Laporan Kemajuan Awal</h3>
                        
                        {{-- CONTOH STRUKTUR LOOPING SUB-BAB --}}
                        {{-- @foreach($module->subChapters as $subChapter) --}}
                        <div class="mb-4">
                            <p class="font-semibold text-gray-700">1.1 Bukti Kegiatan</p>
                             <div class="mt-2 pl-4">
                                <p class="text-sm text-gray-500 mb-2">File yang diunggah dosen:</p>
                                <a href="#" class="inline-flex items-center text-sky-600 hover:text-sky-800 text-sm">
                                    <i class='bx bxs-file-pdf mr-1'></i> Laporan_Kegiatan_Awal.pdf
                                </a>
                            </div>
                            <div class="mt-3 pl-4">
                                <p class="text-sm text-gray-500 mb-2">Komentar Reviewer:</p>
                                <div class="space-y-3">
                                    {{-- CONTOH TAMPILAN KOMENTAR --}}
                                    <div class="bg-gray-50 p-3 rounded-md">
                                        <p class="text-sm font-semibold text-gray-800">Dr. Budi Santoso (Reviewer)</p>
                                        <p class="text-sm text-gray-600 mt-1">"Mohon diperjelas pada bagian metodologi pelaksanaan. Bukti foto kegiatan sudah cukup baik."</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-md">
                                        <p class="text-sm font-semibold text-gray-800">Prof. Retno Wulandari (Reviewer)</p>
                                        <p class="text-sm text-gray-600 mt-1">"Laporan sudah sesuai, tidak ada komentar."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @endforeach --}}
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi & Penugasan --}}
        <div class="space-y-6">
            {{-- Card Aksi Administrator --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Aksi</h2>
                </div>
                <div class="p-6 space-y-3">
                    <p class="text-sm text-gray-600">Ubah status proposal ini. Status saat ini: <span class="font-bold text-blue-700">{{ ucfirst($submission->status) }}</span></p>
                     <form action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50">
                            <option value="sedang review">Setujui untuk Direview</option>
                            <option value="lolos">Loloskan Proposal</option>
                            <option value="revisi">Minta Revisi</option>
                            <option value="ditolak">Tolak Proposal</option>
                        </select>
                        <button type="submit" class="w-full mt-3 inline-flex items-center justify-center px-4 py-2 bg-sky-600 text-white rounded-md font-semibold hover:bg-sky-700">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- Card Penugasan Reviewer --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Tugaskan Reviewer</h2>
                </div>
                 <form action="{{ route('admin_equity.comdev.submissions.assignReviewer', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="reviewers" class="block text-sm font-medium text-gray-700 mb-1">Pilih Reviewer</label>
                        {{-- 
                            - 'reviewers[]' akan mengirim data sebagai array
                            - 'multiple' memungkinkan pemilihan lebih dari satu
                            - Logic di dalam option akan membuat reviewer yang sudah ditugaskan terpilih (selected)
                        --}}
                        <select name="reviewers[]" id="reviewers" multiple class="block w-full h-48 rounded-md border-gray-300 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50">
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" {{ in_array($reviewer->id, $assignedReviewers) ? 'selected' : '' }}>
                                    {{ $reviewer->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2">Gunakan Ctrl + Klik (atau Cmd + Klik di Mac) untuk memilih lebih dari satu.</p>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold hover:bg-yellow-600">
                        <i class='bx bx-save mr-2'></i> Simpan Penugasan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
{{-- Jika Anda menggunakan Select2, aktifkan dengan JS ini --}}
{{-- 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reviewers').select2({
            placeholder: "Pilih reviewer",
            allowClear: true
        });
    });
</script>
--}}
@endpush