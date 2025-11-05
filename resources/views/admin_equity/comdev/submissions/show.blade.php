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
                    <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-[#11A697]">Manajemen Sesi
                            Comdev</a></li>
                    <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                    <li><a href="{{ route('admin_equity.comdev.submissions.index', $comdev->id) }}"
                            class="hover:text-[#11A697]">Daftar Proposal Masuk</a></li>
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
                        
                        {{-- Ketua Tim --}}
                        @php
                            $ketua = $submission->members()->where('peran', 'Ketua')->first();
                            $anggota = $submission->members()->where('peran', 'Anggota')->get();
                        @endphp
                        
                        @if($ketua)
                        <div class="border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-3">Ketua Tim Pengusul</h3>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <p class="text-md font-semibold text-gray-900">{{ $ketua->nama_lengkap }}</p>
                                @if($ketua->nik_nim_nip)
                                    <p class="text-sm text-gray-600"><span class="font-medium">NIP:</span> {{ $ketua->nik_nim_nip }}</p>
                                @endif
                                <p class="text-sm text-gray-600"><span class="font-medium">Alamat:</span> {{ $ketua->alamat_jalan }}, {{ $ketua->kelurahan }}, {{ $ketua->kecamatan }}, {{ $ketua->kota_kabupaten }}, {{ $ketua->provinsi }}</p>
                            </div>
                        </div>
                        @endif
                        
                        {{-- Anggota Tim --}}
                        @if($anggota->count() > 0)
                        <div class="border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-3">Anggota Tim ({{ $anggota->count() }})</h3>
                            <div class="space-y-2">
                                @foreach($anggota as $member)
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-900">{{ $member->nama_lengkap }}</p>
                                    @if($member->nik_nim_nip)
                                        <p class="text-xs text-gray-600">NIP: {{ $member->nik_nim_nip }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Abstrak</h3>
                            <p class="mt-1 text-md text-gray-700 leading-relaxed text-justify">{{ $submission->abstrak }}
                            </p>
                        </div>
                        
                        {{-- SDG's --}}
                        @if($submission->sdgs_fokus || $submission->sdgs_pendukung)
                        <div class="border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">SDG's</h3>
                            @if($submission->sdgs_fokus && is_array($submission->sdgs_fokus) && count($submission->sdgs_fokus) > 0)
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 mb-1 font-medium">Fokus:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($submission->sdgs_fokus as $sdg)
                                        <span class="inline-flex items-center px-2 py-1 bg-teal-100 text-teal-800 text-xs font-medium rounded">{{ $sdg }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if($submission->sdgs_pendukung && is_array($submission->sdgs_pendukung) && count($submission->sdgs_pendukung) > 0)
                            <div>
                                <p class="text-xs text-gray-600 mb-1 font-medium">Pendukung:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($submission->sdgs_pendukung as $sdg)
                                        <span class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded">{{ $sdg }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        {{-- Mitra --}}
                        @if($submission->mitra_nasional || $submission->mitra_internasional)
                        <div class="border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Mitra Kerjasama</h3>
                            @if($submission->mitra_nasional && is_array($submission->mitra_nasional) && count($submission->mitra_nasional) > 0)
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 mb-1 font-medium">Nasional:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($submission->mitra_nasional as $mitra)
                                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">{{ $mitra }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if($submission->mitra_internasional && is_array($submission->mitra_internasional) && count($submission->mitra_internasional) > 0)
                            <div>
                                <p class="text-xs text-gray-600 mb-1 font-medium">Internasional:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($submission->mitra_internasional as $mitra)
                                        <span class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded">{{ $mitra }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 pt-4 border-t border-gray-200">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tahun Usulan</h3>
                                <p class="mt-1 text-md font-semibold text-gray-900">{{ $submission->tahun_usulan }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tempat Pelaksanaan</h3>
                                <p class="mt-1 text-md font-semibold text-gray-900">{{ $submission->tempat_pelaksanaan }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nominal Usulan</h3>
                                <p class="mt-1 text-md font-semibold text-gray-900">Rp
                                    {{ number_format($submission->nominal_usulan, 0, ',', '.') }}</p>
                            </div>
                            @php
                                $firstModuleStatus = $submission->moduleStatuses->first();
                            @endphp
                            @if($firstModuleStatus && $firstModuleStatus->nominal_evaluasi > 0)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nominal Disetujui</h3>
                                <p class="mt-1 text-md font-semibold text-green-600">Rp
                                    {{ number_format($firstModuleStatus->nominal_evaluasi, 0, ',', '.') }}</p>
                            </div>
                            @endif
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
                                <div class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-100 transition duration-200"
                                    @click="open = !open">
                                    <h3 class="font-bold text-gray-700">{{ $module->urutan }}. {{ $module->nama_modul }}
                                    </h3>
                                    <div class="flex items-center space-x-4">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full 
                                            @if ($currentStatus && $currentStatus->status == 'lolos') bg-green-100 text-green-800
                                            @elseif($currentStatus && $currentStatus->status == 'tidaklolos') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            Status: {{ $currentStatus ? ucfirst($currentStatus->status) : 'Terkunci' }}
                                        </span>
                                        <i class='bx bxs-chevron-down text-xl text-gray-500 transition-transform'
                                            :class="{ 'rotate-180': open }"></i>
                                    </div>
                                </div>
                                <div x-show="open" x-transition class="mt-4 pt-4 border-t p-5">
                                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Dokumen Terunggah:</h4>
                                    <ul class="list-disc pl-5 space-y-2 text-sm mb-6">
                                        @forelse($module->subChapters as $subChapter)
                                            @php $file = $uploadedFiles->get($subChapter->id); @endphp
                                            <li>
                                                <span class="text-gray-800">{{ $subChapter->nama_sub_bab }}:</span>
                                                @if ($file)
                                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.files.preview', $file->id) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-md transition">
                                                            <i class='bx bx-show mr-1'></i> Lihat
                                                        </a>
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.files.download', $file->id) }}"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-[#11A697] bg-teal-50 hover:bg-teal-100 rounded-md transition">
                                                            <i class='bx bxs-download mr-1'></i> Unduh
                                                        </a>
                                                        <span class="text-gray-600">{{ $file->original_filename }}</span>
                                                    </div>
                                                    @if ($file->status_luaran)
                                                        <div class="text-xs text-gray-500 pl-4 mt-1">
                                                            Status Luaran: <strong
                                                                class="font-medium">{{ $file->status_luaran }}</strong>
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 italic ml-2">Belum diunggah</span>
                                                @endif
                                            </li>
                                        @empty
                                            <li class="text-gray-400 italic">Tidak ada syarat dokumen untuk modul ini.</li>
                                        @endforelse
                                    </ul>
                                    <form
                                        action="{{ route('admin_equity.comdev.submissions.updateModuleStatus', ['submission' => $submission->id, 'module' => $module->id]) }}"
                                        method="POST" class="mt-4 space-y-3" x-data="{ status: '{{ $currentStatus->status ?? 'proses' }}' }">
                                        @csrf @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Ubah Status</label>
                                                <select name="status" x-model="status"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697]">
                                                    <option value="proses">Proses</option>
                                                    <option value="tidaklolos">Tidak Lolos</option>
                                                    <option value="lolos">Lolos</option>
                                                </select>
                                            </div>
                                           <div x-show="status === 'lolos' && {{ $loop->first ? 'true' : 'false' }}" x-transition>
                                                <label class="block text-sm font-medium text-gray-700">Nominal Evaluasi
                                                    (jika lolos)
                                                </label>
                                                <input type="number" name="nominal_evaluasi"
                                                    value="{{ $currentStatus->nominal_evaluasi ?? '' }}"
                                                    placeholder="Contoh: 15000000"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697]">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Catatan Admin
                                                (Opsional)</label>
                                            <textarea name="catatan_admin" rows="2"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697]">{{ $currentStatus->catatan_admin ?? '' }}</textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] text-sm font-medium transition">Simpan
                                                Status</button>
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
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                        <div class="p-5 border-b bg-[#11A697] text-white">
                            <h2 class="text-xl font-semibold flex items-center"><i class='bx bxs-chat mr-3'></i>Hasil Review & Penilaian</h2>
                        </div>

                        <div class="p-6">
                            @forelse ($submission->sesi->modules as $module)
                                @php
                                    $reviewsForModule = $submission->reviews->where('comdev_module_id', $module->id);
                                @endphp
                                
                                <div class="bg-gray-50 border border-gray-200 rounded-lg overflow-hidden mb-4 last:mb-0" x-data="{ open: true }">
                                    <div class="p-4 cursor-pointer flex justify-between items-center" @click="open = !open">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex items-center justify-center w-10 h-10 bg-[#11A697] text-white rounded-lg font-bold">
                                                {{ $module->urutan }}
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-800 text-lg">{{ $module->nama_modul }}</h3>
                                                <p class="text-xs text-gray-500">{{ $reviewsForModule->count() }} Review</p>
                                            </div>
                                        </div>
                                        <i class='bx bxs-chevron-down text-xl text-gray-500 transition-transform' :class="{ 'rotate-180': open }"></i>
                                    </div>

                                    <div x-show="open" x-transition class="bg-white p-4 md:p-6 border-t space-y-4">
                                        @forelse ($reviewsForModule as $review)
                                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4 md:p-5 border border-purple-100" x-data="{ expanded: false }">
                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-full font-bold text-sm shrink-0">
                                                            {{ substr($review->reviewer->name, 0, 2) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm md:text-base font-bold text-gray-800">{{ $review->reviewer->name }}</p>
                                                            <p class="text-xs text-gray-500" title="{{ $review->created_at->format('d M Y, H:i:s') }}">
                                                                {{ $review->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if($review->penilaian)
                                                        <div class="flex items-center space-x-2 bg-gradient-to-r from-[#11A697] to-[#0e8a7c] text-white px-3 py-2 rounded-lg shadow-sm">
                                                            <i class='bx bx-star text-lg'></i>
                                                            <div class="text-left">
                                                                <p class="text-xs font-medium opacity-90">Penilaian</p>
                                                                <p class="text-sm font-bold">{{ $review->penilaian }}</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="bg-white rounded-lg p-3 md:p-4 border-l-4 border-purple-400">
                                                    <p class="text-xs font-semibold text-purple-600 mb-2 uppercase tracking-wide">Komentar</p>
                                                    @php
                                                        $komentar = $review->komentar;
                                                        $wordCount = str_word_count($komentar);
                                                        $charCount = strlen($komentar);
                                                        $isLong = $wordCount > 100 || $charCount > 500;
                                                        $preview = $isLong ? substr($komentar, 0, 500) : $komentar;
                                                    @endphp
                                                    
                                                    @if($isLong)
                                                        <div class="text-sm md:text-base text-gray-700 leading-relaxed">
                                                            <p x-show="!expanded" class="whitespace-pre-wrap break-words overflow-wrap-anywhere">{{ $preview }}...</p>
                                                            <p x-show="expanded" class="whitespace-pre-wrap break-words overflow-wrap-anywhere">{{ $komentar }}</p>
                                                            <button @click="expanded = !expanded" class="mt-2 text-[#11A697] hover:text-[#0e8a7c] font-semibold text-sm flex items-center gap-1">
                                                                <span x-text="expanded ? 'Tampilkan Lebih Sedikit' : 'Selengkapnya'"></span>
                                                                <i class='bx' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <p class="text-sm md:text-base text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $komentar }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="bg-white rounded-lg p-6 text-center border border-purple-100/50">
                                                <i class='bx bx-message-square-dots text-4xl text-gray-300 mb-2'></i>
                                                <p class="text-sm text-gray-500 italic">Belum ada review untuk modul ini</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 italic py-4">Belum ada modul yang dikonfigurasi untuk sesi ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

        </div>

        {{-- Kolom Kanan: Aksi & Penugasan --}}
        <div class="lg:col-span-1 space-y-8">
            {{-- Card Aksi Administrator --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-[#11A697] text-white">
                    <h2 class="text-xl font-semibold">Aksi Administrator</h2>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600">
                        Proposal status saat ini:
                        <span class="font-bold text-[#11A697]">
                            {{ str_replace('_', ' ', Str::title($submission->status->value)) }}
                        </span>
                    </p>

                    {{-- Form untuk update status manual --}}
                    <form action="{{ route('admin_equity.comdev.submissions.updateStatus', [$comdev->id, $submission->id]) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Manual</label>
                            <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                <option value="">-- Pilih Status --</option>
                                @foreach(\App\Enums\ComdevStatusEnum::cases() as $statusEnum)
                                    <option value="{{ $statusEnum->value }}" {{ $submission->status->value === $statusEnum->value ? 'selected' : '' }}>
                                        {{ str_replace('_', ' ', Str::title($statusEnum->value)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition font-semibold">
                            <i class='bx bx-save mr-2'></i>Update Status
                        </button>
                    </form>

                </div>
            </div>

            {{-- Card Penugasan Reviewer --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-[#11A697] text-white">
                    <h2 class="text-xl font-semibold">Tugaskan Reviewer</h2>
                </div>
                <form id="assignReviewerForm"
                    action="{{ route('admin_equity.comdev.submissions.assignReviewer', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}"
                    method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    @php
                        $assignedReviewersList = $reviewers->whereIn('id', $assignedReviewers);
                        $unassignedReviewersList = $reviewers->whereNotIn('id', $assignedReviewers);
                    @endphp
                    
                    @if($assignedReviewersList->count() > 0)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-user-check mr-1'></i>Reviewer yang Ditugaskan ({{ $assignedReviewersList->count() }})
                        </label>
                        <div class="space-y-2">
                            @foreach ($assignedReviewersList as $reviewer)
                                @php
                                    $hasComments = in_array($reviewer->id, $reviewerIdsWithComments);
                                @endphp
                                <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-200 text-green-700">
                                            <i class='bx bxs-user'></i>
                                        </span>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $reviewer->name }}</p>
                                            @if($hasComments)
                                                <p class="text-xs text-green-600">
                                                    <i class='bx bxs-message-check'></i> Sudah memberikan komentar
                                                </p>
                                            @else
                                                <p class="text-xs text-gray-500">
                                                    <i class='bx bx-time'></i> Belum memberikan komentar
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" 
                                        onclick="removeReviewer({{ $reviewer->id }}, '{{ $reviewer->name }}', {{ $hasComments ? 'true' : 'false' }})"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md {{ $hasComments ? 'bg-red-100 text-red-700 hover:bg-red-200 cursor-not-allowed opacity-60' : 'bg-red-500 text-white hover:bg-red-600' }} transition">
                                        <i class='bx bx-x mr-1'></i> Batalkan
                                    </button>
                                </div>
                                <input type="hidden" name="reviewers[]" value="{{ $reviewer->id }}" id="reviewer_{{ $reviewer->id }}">
                            @endforeach
                        </div>
                        <p class="text-xs text-green-600 mt-2">
                            <i class='bx bx-info-circle'></i> Klik tombol <strong>"Batalkan"</strong> untuk menghapus penugasan reviewer
                        </p>
                    </div>
                    @endif
                    
                    @if($unassignedReviewersList->count() > 0)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-user-plus mr-1'></i>Reviewer Tersedia ({{ $unassignedReviewersList->count() }})
                        </label>
                        <select name="reviewers[]" id="availableReviewers" multiple
                            class="block w-full h-32 rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50 bg-gray-50">
                            @foreach ($unassignedReviewersList as $reviewer)
                                <option value="{{ $reviewer->id }}" class="py-1">
                                    {{ $reviewer->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class='bx bx-info-circle'></i> Gunakan <strong>Ctrl + Klik</strong> untuk memilih lebih dari satu reviewer
                        </p>
                    </div>
                    @endif
                    
                    <div class="text-xs text-gray-500 bg-blue-50 p-3 rounded border border-blue-200 space-y-1">
                        <p><i class='bx bx-info-circle mr-1'></i><strong>Cara Penggunaan:</strong></p>
                        <ul class="list-disc list-inside pl-3 space-y-1">
                            <li>Pilih reviewer dari daftar <strong>"Reviewer Tersedia"</strong> untuk menugaskan</li>
                            <li>Klik tombol <strong>"Batalkan"</strong> pada reviewer yang sudah ditugaskan untuk menghapus penugasan</li>
                            <li>Reviewer yang sudah berkomentar <strong>tidak dapat dibatalkan</strong></li>
                        </ul>
                    </div>
                    
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#11A697] text-white rounded-md font-semibold hover:bg-[#0e8a7c] transition">
                        <i class='bx bx-save mr-2'></i> Simpan Penugasan
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Ambil data dari PHP Controller
        const reviewersWithComments = @json($reviewerIdsWithComments);
        const initialAssignedReviewers = @json($assignedReviewers);
        const form = document.getElementById('assignReviewerForm');

        // Fungsi untuk membatalkan reviewer
        function removeReviewer(reviewerId, reviewerName, hasComments) {
            // Jika reviewer sudah berkomentar, tampilkan peringatan dan blokir
            if (hasComments) {
                Swal.fire({
                    title: 'Tidak Dapat Dibatalkan!',
                    html: `Reviewer <strong>${reviewerName}</strong> sudah memberikan komentar pada proposal ini.<br><br>Penugasan reviewer yang sudah berkomentar <strong>tidak dapat dibatalkan</strong> untuk menjaga integritas data review.`,
                    icon: 'error',
                    confirmButtonColor: '#11A697',
                    confirmButtonText: '<i class="bx bx-check"></i> Mengerti',
                    allowOutsideClick: false
                });
                return;
            }

            // Jika belum berkomentar, tampilkan konfirmasi
            Swal.fire({
                title: 'Batalkan Penugasan?',
                html: `Apakah Anda yakin ingin membatalkan penugasan reviewer <strong>${reviewerName}</strong>?<br><br>Tindakan ini akan menghapus reviewer dari daftar penugasan proposal ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="bx bx-check"></i> Ya, Batalkan!',
                cancelButtonText: '<i class="bx bx-x"></i> Batal',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hapus hidden input untuk reviewer ini
                    const hiddenInput = document.getElementById(`reviewer_${reviewerId}`);
                    if (hiddenInput) {
                        hiddenInput.remove();
                    }

                    // Tampilkan notifikasi sukses dan reload halaman
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Penugasan reviewer akan dihapus setelah Anda menyimpan perubahan.',
                        icon: 'success',
                        confirmButtonColor: '#11A697',
                        confirmButtonText: '<i class="bx bx-check"></i> OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        // Submit form untuk menyimpan perubahan
                        form.submit();
                    });
                }
            });
        }

        // Event listener untuk form submit
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Hentikan submit form sementara

            // Ambil semua reviewer yang dipilih dari hidden inputs dan select box
            const hiddenInputs = document.querySelectorAll('input[name="reviewers[]"]');
            const availableSelect = document.getElementById('availableReviewers');
            
            let selectedIds = [];
            
            // Ambil dari hidden inputs (assigned reviewers yang tidak dihapus)
            hiddenInputs.forEach(input => {
                selectedIds.push(parseInt(input.value));
            });
            
            // Ambil dari available reviewers (jika ada yang dipilih)
            if (availableSelect) {
                Array.from(availableSelect.selectedOptions).forEach(option => {
                    selectedIds.push(parseInt(option.value));
                });
            }

            // Cari reviewer yang sebelumnya ditugaskan & sudah berkomentar, tapi sekarang tidak dipilih
            const removedReviewers = initialAssignedReviewers.filter(id =>
                !selectedIds.includes(id) && reviewersWithComments.includes(id)
            );

            // Jika ada reviewer dengan komentar yang akan dihapus, tampilkan warning
            if (removedReviewers.length > 0) {
                Swal.fire({
                    title: 'Perhatian!',
                    html: "Anda mencoba menghapus penugasan dari reviewer yang <strong>sudah memberikan komentar</strong>.<br><br>Tindakan ini akan <strong>diblokir oleh sistem</strong>.<br><br>Apakah Anda ingin melanjutkan untuk memperbarui penugasan reviewer lain?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#11A697',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="bx bx-check"></i> Ya, lanjutkan!',
                    cancelButtonText: '<i class="bx bx-x"></i> Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Lanjutkan submit jika dikonfirmasi
                    }
                });
            } else {
                // Jika tidak ada konflik, tampilkan konfirmasi normal
                Swal.fire({
                    title: 'Simpan Penugasan?',
                    text: "Apakah Anda yakin ingin menyimpan perubahan pada penugasan reviewer?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#11A697',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="bx bx-save"></i> Ya, Simpan!',
                    cancelButtonText: '<i class="bx bx-x"></i> Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Lanjutkan submit form
                    }
                });
            }
        });
    </script>
@endpush
