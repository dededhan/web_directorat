{{-- 
    =================================================================
    File: show.blade.php
    Deskripsi: Halaman detail dan kelola proposal untuk Admin Equity.
    Versi Desain: Final v2 - Konsisten
    Pembaruan: Menyeragamkan semua warna header kartu dan tombol
               berdasarkan feedback visual.
    Skema Warna: Dominan #11A697 (Teal).
    =================================================================
--}}

@extends('admin_equity.index')

@push('styles')
    {{-- Jika Anda menggunakan library seperti Select2, tambahkan CSS-nya di sini --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endpush


@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header dan Breadcrumbs --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Detail & Kelola Proposal</h1>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="flex items-center text-sm text-gray-500">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-[#11A697]">Dashboard</a></li>
                    <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                    <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-[#11A697]">Manajemen Sesi Comdev</a></li>
                    <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                    <li><a href="{{ route('admin_equity.comdev.submissions.index', $comdev->id) }}" class="hover:text-[#11A697]">Daftar Proposal Masuk</a></li>
                    <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                    <li class="font-semibold text-gray-700" aria-current="page">Kelola Proposal</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Detail Proposal & Manajemen --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Card Detail Proposal --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-5 border-b bg-[#11A697] text-white">
                        <h2 class="text-xl font-semibold flex items-center">
                            <i class='bx bxs-file-doc text-2xl mr-3'></i>Informasi Proposal
                        </h2>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Judul</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $submission->judul }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Ketua Tim Pengusul</h3>
                            <p class="mt-1 text-md text-gray-800">{{ $submission->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Abstrak</h3>
                            <p class="mt-1 text-md text-gray-700 leading-relaxed text-justify">{{ $submission->abstrak }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 pt-4 border-t border-gray-200">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tahun Usulan</h3>
                                <p class="mt-1 text-md font-semibold text-gray-900">{{ $submission->tahun_usulan }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nominal Usulan</h3>
                                <p class="mt-1 text-md font-semibold text-gray-900">Rp {{ number_format($submission->nominal_usulan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Manajemen Status Modul --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-5 border-b bg-[#11A697] text-white">
                        <h2 class="text-xl font-semibold flex items-center">
                            <i class='bx bx-toggle-right text-2xl mr-3'></i>Manajemen Status Modul
                        </h2>
                    </div>
                    <div class="p-6 bg-gray-50/70 rounded-b-xl space-y-4">
                        @php
                            $allModules = $submission->sesi->modules()->with('subChapters')->orderBy('urutan')->get();
                            $statuses = $submission->moduleStatuses->keyBy('comdev_module_id');
                            $uploadedFiles = $submission->files->keyBy('comdev_sub_chapter_id');
                        @endphp

                        @forelse ($allModules as $module)
                            @php $currentStatus = $statuses->get($module->id); @endphp
                            <div class="border border-gray-200 rounded-lg bg-white" x-data="{ open: false }">
                                <div class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-100 transition duration-200" @click="open = !open">
                                    <h3 class="font-bold text-gray-700">{{ $module->urutan }}. {{ $module->nama_modul }}</h3>
                                    <div class="flex items-center space-x-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            @if ($currentStatus && $currentStatus->status == 'lolos') bg-green-100 text-green-800
                                            @elseif($currentStatus && $currentStatus->status == 'tidaklolos') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            Status: {{ $currentStatus ? ucfirst($currentStatus->status) : 'Terkunci' }}
                                        </span>
                                        <i class='bx bxs-chevron-down text-xl text-gray-500 transition-transform' :class="{'rotate-180': open}"></i>
                                    </div>
                                </div>
                                <div x-show="open" x-transition class="mt-4 pt-4 border-t p-5">
                                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Dokumen Terunggah:</h4>
                                    <ul class="list-disc pl-5 space-y-1 text-sm mb-6">
                                        @forelse($module->subChapters as $subChapter)
                                            @php $file = $uploadedFiles->get($subChapter->id); @endphp
                                            <li>
                                                <span class="text-gray-800">{{ $subChapter->nama_sub_bab }}:</span>
                                                @if ($file)
                                                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.files.download', $file->id) }}" class="text-[#11A697] hover:underline ml-2">
                                                        <i class='bx bxs-download'></i> {{ $file->original_filename }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 italic ml-2">Belum diunggah</span>
                                                @endif
                                            </li>
                                        @empty
                                            <li class="text-gray-400 italic">Tidak ada syarat dokumen untuk modul ini.</li>
                                        @endforelse
                                    </ul>
                                    <form action="{{ route('admin_equity.comdev.submissions.updateModuleStatus', ['submission' => $submission->id, 'module' => $module->id]) }}" method="POST" class="mt-4 space-y-3" x-data="{ status: '{{ $currentStatus->status ?? 'proses' }}' }">
                                        @csrf @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Ubah Status</label>
                                                <select name="status" x-model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697]">
                                                    <option value="proses">Proses</option>
                                                    <option value="tidaklolos">Tidak Lolos</option>
                                                    <option value="lolos">Lolos</option>
                                                </select>
                                            </div>
                                            <div x-show="status === 'lolos'" x-transition>
                                                <label class="block text-sm font-medium text-gray-700">Nominal Evaluasi (jika lolos)</label>
                                                <input type="number" name="nominal_evaluasi" value="{{ $currentStatus->nominal_evaluasi ?? '' }}" placeholder="Contoh: 15000000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697]">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Catatan Admin (Opsional)</label>
                                            <textarea name="catatan_admin" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697]">{{ $currentStatus->catatan_admin ?? '' }}</textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] text-sm font-medium transition">Simpan Status</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">
                               <p class="text-gray-500 italic">Belum ada modul yang dikonfigurasi untuk sesi ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                {{-- Card Reviewer --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-5 border-b bg-[#11A697] text-white">
                        <h2 class="text-xl font-semibold flex items-center">
                            <i class='bx bx-sitemap text-2xl mr-3'></i>Tahapan Proposal & Review
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-6 pb-4 border-b last:border-b-0">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Modul A: Laporan Kemajuan Awal</h3>
                            <div class="mb-4 space-y-4">
                                <p class="font-semibold text-gray-700 text-md">1.1 Bukti Kegiatan</p>
                                <div class="mt-2 pl-4">
                                    <p class="text-sm text-gray-500 mb-2">File yang diunggah dosen:</p>
                                    <a href="#" class="inline-flex items-center text-[#11A697] hover:text-[#0e8a7c] text-sm font-medium">
                                        <i class='bx bxs-file-pdf mr-2 text-xl'></i> Laporan_Kegiatan_Awal.pdf
                                    </a>
                                </div>
                                <div class="mt-3 pl-4">
                                    <p class="text-sm text-gray-500 mb-2">Komentar Reviewer:</p>
                                    <div class="space-y-3">
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                            <p class="text-sm font-semibold text-gray-800">Dr. Budi Santoso (Reviewer)</p>
                                            <p class="text-sm text-gray-600 mt-1">"Mohon diperjelas pada bagian metodologi pelaksanaan. Bukti foto kegiatan sudah cukup baik."</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                            <p class="text-sm font-semibold text-gray-800">Prof. Retno Wulandari (Reviewer)</p>
                                            <p class="text-sm text-gray-600 mt-1">"Laporan sudah sesuai, tidak ada komentar."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Aksi & Penugasan --}}
            <div class="space-y-8">
                {{-- Card Aksi Administrator --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-5 border-b bg-[#11A697] text-white">
                        <h2 class="text-xl font-semibold">Aksi Administrator</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <p class="text-sm text-gray-600">Ubah status proposal. Status saat ini: <span class="font-bold text-[#11A697]">{{ str_replace('_', ' ', Str::title($submission->status)) }}</span></p>
                        
                        {{-- Form untuk update status manual --}}
                        <form action="{{ route('admin_equity.comdev.submissions.updateStatus', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status Manual</label>
                            <select name="status" id="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                @php
                                    $statuses = [
                                        'diajukan' => 'Diajukan',
                                        'sedang_direview' => 'Sedang Direview',
                                        'menunggu_verifikasi_admin' => 'Menunggu Verifikasi Admin',
                                        'perbaikan_diperlukan' => 'Perbaikan Diperlukan',
                                        'proses_tahap_selanjutnya' => 'Proses Tahap Selanjutnya',
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak'
                                    ];
                                @endphp
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $submission->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full mt-3 inline-flex items-center justify-center px-4 py-2 bg-[#11A697] text-white rounded-md font-semibold hover:bg-[#0e8a7c] transition">
                                Update Status
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 mt-1">Gunakan dengan hati-hati. Perubahan manual akan mengabaikan alur otomatis.</p>
                    </div>
                </div>

                {{-- Card Penugasan Reviewer --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-5 border-b bg-[#11A697] text-white">
                        <h2 class="text-xl font-semibold">Tugaskan Reviewer</h2>
                    </div>
                    <form action="{{ route('admin_equity.comdev.submissions.assignReviewer', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}" method="POST" class="p-6">
                        @csrf
                        <div class="mb-4">
                            <label for="reviewers" class="block text-sm font-medium text-gray-700 mb-1">Pilih Reviewer</label>
                            <select name="reviewers[]" id="reviewers" multiple class="block w-full h-48 rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                @foreach ($reviewers as $reviewer)
                                    <option value="{{ $reviewer->id }}" {{ in_array($reviewer->id, $assignedReviewers) ? 'selected' : '' }}>
                                        {{ $reviewer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2">Gunakan Ctrl + Klik (atau Cmd + Klik di Mac) untuk memilih lebih dari satu.</p>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#11A697] text-white rounded-md font-semibold hover:bg-[#0e8a7c] transition">
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
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    --}}
@endpush