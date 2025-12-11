@extends('reviewer_equity.index')

@section('content')
    {{-- Header Section with Gradient --}}
    <div class="mb-6 md:mb-8">
        <div class="bg-gradient-to-r from-[#11A697] to-[#0e8a7c] rounded-xl shadow-lg p-6 md:p-8 text-white">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4 flex-1">
                    <div class="hidden md:flex items-center justify-center w-16 h-16 bg-white/20 rounded-lg backdrop-blur-sm">
                        <i class='bx bxs-book-content text-4xl'></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">Detail Proposal Hibah Modul</h1>
                        <p class="text-white/90 text-sm md:text-base">Review dan berikan penilaian terhadap proposal modul ajar</p>
                    </div>
                </div>
                <div class="ml-4">
                    <a href="{{ route('reviewer_equity.hibah_modul.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm transition-colors">
                        <i class='bx bx-arrow-back mr-2'></i>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-2xl text-green-500 mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class='bx bx-error-circle text-2xl text-red-500 mr-3'></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Detail Proposal Section --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-6 md:mb-8">
        <div class="p-5 border-b bg-[#11A697] text-white">
            <h2 class="text-xl font-semibold flex items-center">
                <i class='bx bx-detail text-2xl mr-2'></i>
                Informasi Proposal
            </h2>
        </div>
        <div class="p-6 space-y-5">
            {{-- Judul Modul --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Judul Modul Ajar</h3>
                <p class="text-base text-gray-800 font-medium">{{ $proposal->judul_modul }}</p>
            </div>

            {{-- Ringkasan Modul --}}
            @if($proposal->ringkasan_modul)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Ringkasan Modul</h3>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proposal->ringkasan_modul }}</p>
            </div>
            @endif
            
            {{-- Informasi Dosen Pengaju --}}
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Informasi Pengaju</h3>
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-4 border border-purple-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nama Dosen</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $proposal->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">NIDN</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $proposal->user->nidn ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $proposal->user->email }}</p>
                        </div>
                        @if($proposal->user->prodi)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Program Studi</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $proposal->user->prodi->name }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Anggota Penyusun --}}
            @if($proposal->anggota && $proposal->anggota->count() > 0)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Anggota Penyusun</h3>
                <div class="space-y-2">
                    @foreach($proposal->anggota as $anggota)
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                        <p class="text-sm font-semibold text-gray-800">{{ $anggota->nama_dosen }}</p>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <p class="text-xs text-gray-600">NIP: {{ $anggota->nip ?? '-' }}</p>
                            <p class="text-xs text-gray-600">{{ $anggota->fakultas }}</p>
                        </div>
                        <p class="text-xs text-gray-600">{{ $anggota->prodi }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Kata Kunci --}}
            @if($proposal->kata_kunci)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Kata Kunci</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($proposal->kata_kunci, true) ?? [] as $keyword)
                        <span class="px-3 py-1 bg-teal-100 text-teal-800 text-xs font-medium rounded-full">{{ $keyword }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- SDGs --}}
            @if($proposal->sdgs_fokus || $proposal->sdgs_pendukung)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Sustainable Development Goals (SDGs)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($proposal->sdgs_fokus)
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <p class="text-sm font-bold text-green-800 mb-2">SDGs Fokus</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($proposal->sdgs_fokus as $sdg)
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">{{ $sdg }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($proposal->sdgs_pendukung)
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <p class="text-sm font-bold text-blue-800 mb-2">SDGs Pendukung</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($proposal->sdgs_pendukung as $sdg)
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-medium">{{ $sdg }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            {{-- Detail Informasi Lainnya --}}
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tempat Pelaksanaan</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->tempat_pelaksanaan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Anggaran Usulan</p>
                        <p class="text-sm text-gray-800 font-medium">Rp {{ number_format($proposal->anggaran_usulan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Platform Digital</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->platform_digital ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Mitra</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->mitra ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Publikasi Media Massa</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->publikasi_media_massa ?? '-' }}</p>
                    </div>
                    @if($proposal->publikasi_media_massa === 'Ada' || $proposal->publikasi_media_massa === 'Draft')
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nama Media Massa</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->nama_media_massa ?? '-' }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-500 mb-1">HKI</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->hki ?? '-' }}</p>
                    </div>
                    @if($proposal->hki === 'Ada' || $proposal->hki === 'Draft')
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">Jenis HKI dan Judul</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $proposal->jenis_hki_dan_judul ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- File Proposal --}}
            @if($proposal->file_proposal)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">File Proposal</h3>
                <a href="{{ Storage::url($proposal->file_proposal) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class='bx bxs-file-pdf text-xl mr-2'></i>
                    Lihat Proposal (PDF)
                </a>
            </div>
            @endif
            
            {{-- Status & Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 pt-4 border-t border-gray-200">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tanggal Submit</p>
                    <p class="text-sm text-gray-800 font-medium">{{ $proposal->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status Review</p>
                    @if($proposal->komentar_reviewer)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class='bx bx-check-circle mr-1'></i>
                            Sudah Direview
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class='bx bx-time-five mr-1'></i>
                            Menunggu Review
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @php
        // Get all moduls for this sesi
        $allModuls = \App\Models\HibahModulAkhir::where('sesi_id', $proposal->sesi_id)
                        ->with('subChapters')
                        ->orderBy('urutan')
                        ->get();
        $currentReviewerId = auth()->id();
        
        // Group uploaded files and reviews by modul
        $uploadedFilesByModul = [];
        $reviewsByModul = [];
        
        foreach($allModuls as $modul) {
            foreach($modul->subChapters as $subChapter) {
                $file = $proposal->modulAkhirFiles->where('hibah_modul_akhir_sub_chapter_id', $subChapter->id)->first();
                $review = $proposal->modulAkhirReviews
                    ->where('hibah_modul_akhir_sub_chapter_id', $subChapter->id)
                    ->where('reviewer_id', $currentReviewerId)
                    ->first();
                
                if($file) {
                    $uploadedFilesByModul[$modul->id][$subChapter->id] = $file;
                }
                if($review) {
                    $reviewsByModul[$modul->id][$subChapter->id] = $review;
                }
            }
        }
    @endphp

    {{-- Main Content Card - Documents & Review Per Modul --}}
    <div class="space-y-6 md:space-y-8">
        @forelse($allModuls as $modul)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            {{-- Modul Header --}}
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-sm font-bold">
                                {{ $modul->urutan }}
                            </span>
                            <h2 class="text-xl font-bold">{{ $modul->judul_modul }}</h2>
                        </div>
                        @if($modul->deskripsi)
                            <p class="text-purple-100 text-sm ml-10">{{ $modul->deskripsi }}</p>
                        @endif
                        @if($modul->periode_awal && $modul->periode_akhir)
                            <p class="text-purple-100 text-sm ml-10 mt-1">
                                Periode: {{ $modul->periode_awal->format('d M Y') }} - {{ $modul->periode_akhir->format('d M Y') }}
                            </p>
                        @endif
                    </div>
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                        {{ $modul->subChapters->count() }} Sub Bab
                    </span>
                </div>
            </div>

            {{-- Sub Chapters List --}}
            <div class="p-4 md:p-6 lg:p-8 bg-gradient-to-br from-gray-50 to-gray-100/50 space-y-4 md:space-y-6">
                @forelse($modul->subChapters as $subChapter)
                    @php
                        $file = $uploadedFilesByModul[$modul->id][$subChapter->id] ?? null;
                        $myReview = $reviewsByModul[$modul->id][$subChapter->id] ?? null;
                    @endphp

                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200">
                        {{-- Sub Chapter Header --}}
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-4 md:px-6 py-4 border-b border-indigo-100">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-indigo-500 text-white text-xs font-bold">
                                            {{ $subChapter->urutan }}
                                        </span>
                                        <h3 class="text-base md:text-lg font-bold text-gray-800">
                                            {{ $subChapter->judul_sub_chapter }}
                                        </h3>
                                        @if($subChapter->is_wajib)
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Wajib</span>
                                        @endif
                                    </div>
                                    @if($subChapter->deskripsi)
                                        <p class="text-sm text-gray-600 ml-9">{{ $subChapter->deskripsi }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 ml-9 mt-1">
                                        Tipe Input: 
                                        @if($subChapter->tipe_input === 'pdf') <strong>PDF</strong>
                                        @elseif($subChapter->tipe_input === 'link') <strong>Link</strong>
                                        @else <strong>PDF atau Link</strong>
                                        @endif
                                    </p>
                                </div>
                                
                                {{-- File/Review Status Indicator --}}
                                <div class="flex-shrink-0 flex flex-col items-end space-y-1">
                                    @if($file)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <i class='bx bx-check-circle mr-1'></i>
                                            File Uploaded
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <i class='bx bx-x-circle mr-1'></i>
                                            No File
                                        </span>
                                    @endif
                                    
                                    @if($myReview)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-700">
                                            <i class='bx bx-check mr-1'></i>
                                            Reviewed
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-4 md:p-6">
                            @if($file)
                                {{-- Uploaded File/Link Info --}}
                                @if($file->file_path)
                                    <div class="bg-blue-50 rounded-lg p-4 mb-4 border border-blue-100">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <i class='bx bxs-file-pdf text-3xl text-red-500'></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">{{ basename($file->file_path) }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Upload: {{ $file->created_at->format('d M Y, H:i') }}
                                                </p>
                                                <a href="{{ Storage::url($file->file_path) }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center mt-2 text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                    <i class='bx bx-download mr-1'></i>
                                                    Download File
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($file->link_url)
                                    <div class="bg-purple-50 rounded-lg p-4 mb-4 border border-purple-100">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <i class='bx bx-link text-3xl text-purple-500'></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800">Link URL</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Upload: {{ $file->created_at->format('d M Y, H:i') }}
                                                </p>
                                                <a href="{{ $file->link_url }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center mt-2 text-xs text-purple-600 hover:text-purple-700 font-medium break-all">
                                                    <i class='bx bx-link-external mr-1'></i>
                                                    {{ $file->link_url }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Review Section --}}
                                @if($myReview)
                                    {{-- Show My Review --}}
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                        <div class="flex items-start justify-between mb-3">
                                            <h4 class="font-semibold text-green-800 flex items-center">
                                                <i class='bx bx-check-circle text-xl mr-2'></i>
                                                Review Anda
                                            </h4>
                                            <span class="text-xs text-green-600">{{ $myReview->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        
                                        <div class="space-y-3">
                                            <div>
                                                <p class="text-xs font-semibold text-gray-600 mb-1">Nilai:</p>
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                                        {{ $myReview->nilai }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <p class="text-xs font-semibold text-gray-600 mb-1">Komentar:</p>
                                                <p class="text-sm text-gray-700 bg-white rounded p-3 border border-green-200">
                                                    {{ $myReview->komentar ?: 'Tidak ada komentar' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Review Form --}}
                                    <form action="{{ route('reviewer_equity.hibah_modul.storeReview', ['proposal' => $proposal->id, 'modul' => $modul->id, 'subChapter' => $subChapter->id]) }}" 
                                          method="POST" 
                                          x-data="{ nilai: 0 }"
                                          class="bg-yellow-50 rounded-lg p-4 md:p-6 border border-yellow-200">
                                        @csrf
                                        
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class='bx bx-edit-alt text-xl mr-2 text-yellow-600'></i>
                                            Berikan Penilaian
                                        </h4>

                                        <div class="space-y-4">
                                            {{-- Nilai Input --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Nilai (0-100)
                                                    <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" 
                                                       name="nilai" 
                                                       x-model="nilai"
                                                       min="0" 
                                                       max="100" 
                                                       required
                                                       class="w-full md:w-40 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                       placeholder="0-100">
                                                <p class="text-xs text-gray-500 mt-1">Masukkan nilai antara 0 sampai 100</p>
                                            </div>

                                            {{-- Komentar --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Komentar/Saran
                                                </label>
                                                <textarea name="komentar" 
                                                          rows="4"
                                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                                          placeholder="Berikan komentar atau saran perbaikan (opsional)"></textarea>
                                            </div>

                                            {{-- Submit Button --}}
                                            <div class="flex justify-end">
                                                <button type="submit" 
                                                        class="inline-flex items-center px-6 py-2.5 bg-[#11A697] hover:bg-[#0e8a7c] text-white font-semibold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                                    <i class='bx bx-save mr-2'></i>
                                                    Simpan Review
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                            @else
                                {{-- No File Uploaded --}}
                                <div class="bg-gray-50 rounded-lg p-8 text-center border-2 border-dashed border-gray-300">
                                    <i class='bx bx-file text-4xl text-gray-400 mb-2'></i>
                                    <p class="text-sm text-gray-600">Belum ada file yang diupload untuk sub bab ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-lg p-8 text-center border-2 border-dashed border-gray-300">
                        <i class='bx bx-folder-open text-4xl text-gray-400 mb-2'></i>
                        <p class="text-sm text-gray-600">Belum ada sub bab untuk modul ini</p>
                    </div>
                @endforelse
            </div>

            {{-- Modul Progress Summary --}}
            @php
                $totalSubChaptersInModul = $modul->subChapters->count();
                $reviewedInModul = isset($reviewsByModul[$modul->id]) ? count($reviewsByModul[$modul->id]) : 0;
                $progressPercentage = $totalSubChaptersInModul > 0 ? ($reviewedInModul / $totalSubChaptersInModul * 100) : 0;
            @endphp
            
            <div class="px-6 py-4 bg-gray-50 border-t">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class='bx bx-bar-chart-alt-2 text-2xl text-gray-400'></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Progress Review</p>
                            <p class="text-xs text-gray-500">{{ $reviewedInModul }} dari {{ $totalSubChaptersInModul }} sub bab</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-teal-600 h-2 rounded-full transition-all" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ number_format($progressPercentage, 0) }}%</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
            <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">Belum ada template modul akhir untuk sesi ini</p>
        </div>
        @endforelse
    </div>

    {{-- Overall Review Summary --}}
    @php
        $totalAllSubChapters = $allModuls->sum(function($modul) {
            return $modul->subChapters->count();
        });
        $totalReviewed = array_sum(array_map('count', $reviewsByModul));
        $allReviewed = ($totalAllSubChapters > 0 && $totalReviewed === $totalAllSubChapters);
    @endphp

    @if($allReviewed)
    <div class="mt-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                    <i class='bx bx-check-double text-2xl text-white'></i>
                </div>
                <div>
                    <h3 class="font-bold text-green-800 text-lg">Review Selesai</h3>
                    <p class="text-sm text-green-600">Anda telah menyelesaikan review untuk semua modul proposal ini</p>
                </div>
            </div>
            
            @php
                $allMyReviews = collect($reviewsByModul)->flatten();
                $averageScore = $allMyReviews->isNotEmpty() ? $allMyReviews->avg('nilai') : 0;
            @endphp
            
            <div class="text-center">
                <p class="text-xs text-green-600 mb-1">Rata-rata Nilai Keseluruhan</p>
                <p class="text-3xl font-bold text-green-700">{{ number_format($averageScore, 1) }}</p>
            </div>
        </div>
    </div>
    @endif

@endsection

@push('scripts')
<script>
    // Auto scroll to first unreviewed section
    document.addEventListener('DOMContentLoaded', function() {
        const firstUnreviewed = document.querySelector('form[action*="storeReview"]');
        if (firstUnreviewed) {
            firstUnreviewed.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endpush
