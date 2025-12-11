@extends('reviewer_equity.index')

@section('content')
    {{-- Header Section with Gradient --}}
    <div class="mb-6 md:mb-8">
        <div class="bg-gradient-to-r from-[#11A697] to-[#0e8a7c] rounded-xl shadow-lg p-6 md:p-8 text-white">
            <div class="flex items-start space-x-4">
                <div class="hidden md:flex items-center justify-center w-16 h-16 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class='bx bxs-plane-alt text-4xl'></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3">Detail & Review Proposal Student Exchange</h1>
                    <div class="space-y-2">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="text-white/80 text-sm md:text-base">Judul Kegiatan:</span>
                            <span class="font-semibold text-base md:text-lg">{{ $proposal->judul_kegiatan }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="text-white/80 text-sm md:text-base">Diajukan oleh:</span>
                            <span class="font-medium text-sm md:text-base bg-white/20 px-3 py-1 rounded-full inline-flex items-center">
                                <i class='bx bx-user-circle text-lg mr-1'></i>
                                {{ $proposal->user->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Proposal Section --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-6 md:mb-8">
        <div class="p-5 border-b bg-[#11A697] text-white">
            <h2 class="text-xl font-semibold flex items-center">
                <i class='bx bx-detail text-2xl mr-2'></i>
                Detail Proposal Student Exchange
            </h2>
        </div>
        <div class="p-6 space-y-5">
            {{-- Judul Kegiatan --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Judul Kegiatan</h3>
                <p class="text-base text-gray-800">{{ $proposal->judul_kegiatan }}</p>
            </div>
            
            {{-- Ringkasan Kegiatan --}}
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Ringkasan Kegiatan</h3>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proposal->ringkasan_kegiatan }}</p>
            </div>
            
            {{-- Ketua Tim --}}
            @php
                $ketua = $proposal->anggota()->where('peran', 'Ketua')->first();
                $anggota = $proposal->anggota()->where('peran', 'Anggota')->get();
            @endphp
            
            @if($ketua)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Ketua Tim</h3>
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg p-4 border border-blue-100">
                    <p class="text-base font-bold text-gray-800 mb-1">{{ $ketua->nama_lengkap }}</p>
                    @if($ketua->nim)
                        <p class="text-sm text-gray-600">NIM: {{ $ketua->nim }}</p>
                    @endif
                    @if($ketua->email)
                        <p class="text-sm text-gray-600">Email: {{ $ketua->email }}</p>
                    @endif
                </div>
            </div>
            @endif
            
            {{-- Anggota Tim --}}
            @if($anggota->count() > 0)
            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Anggota Tim</h3>
                <div class="space-y-2">
                    @foreach($anggota as $member)
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <p class="text-base font-semibold text-gray-800">{{ $member->nama_lengkap }}</p>
                            @if($member->nim)
                                <p class="text-sm text-gray-600">NIM: {{ $member->nim }}</p>
                            @endif
                            @if($member->email)
                                <p class="text-sm text-gray-600">Email: {{ $member->email }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            {{-- SDG's --}}
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
            
            {{-- Info Lainnya --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 pt-4 border-t border-gray-200">
                @if($proposal->jenis_kegiatan)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Jenis Kegiatan</h3>
                    <p class="text-base text-gray-800">{{ ucwords(str_replace('_', ' ', $proposal->jenis_kegiatan)) }}</p>
                </div>
                @endif
                @if($proposal->jumlah_peserta)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Jumlah Peserta</h3>
                    <p class="text-base text-gray-800">{{ $proposal->jumlah_peserta }} orang</p>
                </div>
                @endif
                @if($proposal->sks)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">SKS</h3>
                    <p class="text-base text-gray-800">{{ $proposal->sks }} SKS</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $allModules = $proposal->sesi->moduls;
        $uploadedFiles = $proposal->files->keyBy('student_exchange_sub_chapter_id');
        $allReviews = $proposal->reviews;
        $currentReviewerId = auth()->id();
    @endphp

    {{-- Main Content Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-[#11A697] to-[#0d9587] p-4 md:p-6 text-white">
            <h2 class="text-lg md:text-xl font-bold flex items-center">
                <i class='bx bx-sitemap text-2xl md:text-3xl mr-2 md:mr-3'></i>
                <span>Tahapan Proposal & Review</span>
            </h2>
        </div>

        <div class="p-4 md:p-6 lg:p-8 bg-gradient-to-br from-gray-50 to-gray-100/50 space-y-4 md:space-y-6">
            @forelse ($allModules as $module)
                {{-- Module Card with Enhanced Design --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200" x-data="{ open: true }">
                    {{-- Module Header --}}
                    <div class="flex justify-between items-center p-4 md:p-5 cursor-pointer bg-gradient-to-r from-gray-50 to-white hover:from-gray-100 hover:to-gray-50 transition-all duration-200" @click="open = !open">
                        <div class="flex items-center space-x-3 flex-1">
                            <div class="flex items-center justify-center w-8 h-8 md:w-10 md:h-10 bg-[#11A697] text-white rounded-lg font-bold text-sm md:text-base shrink-0">
                                {{ $module->urutan }}
                            </div>
                            <h3 class="font-bold text-base md:text-lg lg:text-xl text-gray-800 break-words">{{ $module->judul_modul }}</h3>
                        </div>
                        <button type="button" class="ml-3 flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 transition-colors duration-200 shrink-0">
                            <i class='bx bxs-chevron-down text-xl md:text-2xl text-gray-600 transition-transform duration-300' :class="{'rotate-180': open}"></i>
                        </button>
                    </div>

                    {{-- Module Content --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="border-t border-gray-200">
                        @php
                            $reviewsForThisModule = $allReviews->where('student_exchange_modul_id', $module->id);
                            $myReview = $reviewsForThisModule->where('reviewer_id', $currentReviewerId)->first();
                        @endphp

                        <div class="p-4 md:p-6 space-y-6">
                            {{-- 1. Documents Section --}}
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg p-4 md:p-5 border border-blue-100">
                                <div class="flex items-center mb-4">
                                    <div class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-lg mr-3">
                                        <i class='bx bx-file-blank text-xl'></i>
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-base md:text-lg">Dokumen Sub-bab</h4>
                                </div>
                                
                                @forelse ($module->subChapters as $subChapter)
                                    @php
                                        $file = $uploadedFiles->get($subChapter->id);
                                    @endphp
                                    <div class="bg-white rounded-lg p-3 md:p-4 mb-3 last:mb-0 shadow-sm border border-blue-100/50 hover:shadow-md transition-shadow duration-200">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                            <div class="flex-1">
                                                <p class="text-sm md:text-base font-semibold text-gray-700 mb-2">{{ $subChapter->judul_sub_bab }}</p>
                                                @if($file)
                                                    @if($file->tipe_file === 'pdf' && $file->file_path)
                                                        {{-- Untuk file PDF --}}
                                                        <div class="flex flex-wrap items-center gap-2">
                                                            <a href="{{ Storage::url($file->file_path) }}" 
                                                               target="_blank"
                                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors group">
                                                                <span class="flex items-center justify-center w-5 h-5 mr-1.5">
                                                                    <i class='bx bx-show text-base'></i>
                                                                </span>
                                                                Lihat
                                                            </a>
                                                            <a href="{{ Storage::url($file->file_path) }}" 
                                                               download
                                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#11A697] bg-[#11A697]/10 hover:bg-[#11A697]/20 rounded-lg transition-colors group">
                                                                <span class="flex items-center justify-center w-5 h-5 mr-1.5">
                                                                    <i class='bx bxs-download text-base'></i>
                                                                </span>
                                                                Unduh
                                                            </a>
                                                            <span class="text-xs text-gray-600 break-all">{{ basename($file->file_path) }}</span>
                                                        </div>
                                                    @elseif($file->tipe_file === 'link' && $file->link_url)
                                                        {{-- Untuk URL/Link --}}
                                                        <div class="flex flex-wrap items-center gap-2">
                                                            <a href="{{ $file->link_url }}" 
                                                               target="_blank"
                                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition-colors group">
                                                                <span class="flex items-center justify-center w-5 h-5 mr-1.5">
                                                                    <i class='bx bx-link-external text-base'></i>
                                                                </span>
                                                                Buka Link
                                                            </a>
                                                            <span class="text-xs text-gray-600 break-all">{{ Str::limit($file->link_url, 50) }}</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center text-gray-400 text-sm">
                                                            <i class='bx bx-error-circle mr-2 text-lg'></i>
                                                            <span class="italic">Data file tidak valid</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="flex items-center text-gray-400 text-sm">
                                                        <i class='bx bx-info-circle mr-2 text-lg'></i>
                                                        <span class="italic">Belum ada file yang diunggah</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-white rounded-lg p-4 text-center border border-blue-100/50">
                                        <i class='bx bx-folder-open text-4xl text-gray-300 mb-2'></i>
                                        <p class="text-sm text-gray-500 italic">Tidak ada sub-bab untuk modul ini</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- 2. Reviews from Other Reviewers --}}
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4 md:p-5 border border-purple-100">
                                <div class="flex items-center mb-4">
                                    <div class="flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-lg mr-3">
                                        <i class='bx bx-user-voice text-xl'></i>
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-base md:text-lg">Review dari Reviewer Lain</h4>
                                </div>
                                
                                <div class="space-y-3">
                                    @forelse ($reviewsForThisModule->where('reviewer_id', '!=', $currentReviewerId) as $review)
                                        <div class="bg-white rounded-lg p-4 md:p-5 shadow-sm border border-purple-100/50 hover:shadow-md transition-all duration-200" x-data="{ expanded: false }">
                                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-full font-bold text-sm shrink-0">
                                                        {{ substr($review->reviewer->name, 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm md:text-base font-bold text-gray-800">{{ $review->reviewer->name }}</p>
                                                        <p class="text-xs text-gray-500">Reviewer</p>
                                                    </div>
                                                </div>
                                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md text-center">
                                                    <p class="text-xs font-semibold mb-1">Nilai</p>
                                                    <p class="text-2xl font-bold">{{ number_format($review->nilai, 2) }}</p>
                                                </div>
                                            </div>

                                            <div class="bg-gray-50 rounded-lg p-3 md:p-4 border-l-4 border-purple-400">
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
                                                    <p class="text-sm md:text-base text-gray-700 whitespace-pre-wrap break-words overflow-wrap-anywhere leading-relaxed">{{ $komentar }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-white rounded-lg p-6 text-center border border-purple-100/50">
                                            <i class='bx bx-message-square-dots text-4xl text-gray-300 mb-2'></i>
                                            <p class="text-sm text-gray-500 italic">Belum ada review dari reviewer lain</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        
                            {{-- 3. Your Review Form --}}
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 md:p-6 border border-green-100">
                                <div class="flex items-center mb-5">
                                    <div class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-lg mr-3">
                                        <i class='bx bx-edit-alt text-xl'></i>
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-base md:text-lg">Review Anda</h4>
                                </div>
                                
                                <form action="{{ route('reviewer_equity.student_exchange.storeReview', ['proposal' => $proposal->id, 'modul' => $module->id]) }}" method="POST" class="space-y-5">
                                    @csrf
                                    
                                    {{-- Nilai Input (0-100) --}}
                                    <div class="bg-white rounded-lg p-4 md:p-5 shadow-sm border border-green-100/50">
                                        <label for="nilai-{{ $module->id }}" class="flex items-center text-sm md:text-base font-bold text-gray-800 mb-3">
                                            <i class='bx bx-bar-chart-alt text-[#11A697] text-xl mr-2'></i>
                                            Nilai (0 - 100)
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            step="0.01"
                                            name="nilai" 
                                            id="nilai-{{ $module->id }}"
                                            min="0"
                                            max="100"
                                            value="{{ old('nilai', $myReview->nilai ?? '') }}"
                                            class="w-full rounded-lg border-2 border-gray-200 focus:border-[#11A697] focus:ring-2 focus:ring-[#11A697]/20 text-sm md:text-base p-3 transition-all duration-200" 
                                            placeholder="Masukkan nilai (0-100)"
                                            required
                                        >
                                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                                            <i class='bx bx-info-circle mr-1'></i>
                                            Berikan nilai objektif berdasarkan kualitas modul ini
                                        </p>
                                    </div>

                                    {{-- Komentar Input --}}
                                    <div class="bg-white rounded-lg p-4 md:p-5 shadow-sm border border-green-100/50">
                                        <label for="komentar-{{ $module->id }}" class="flex items-center text-sm md:text-base font-bold text-gray-800 mb-3">
                                            <i class='bx bx-message-square-detail text-[#11A697] text-xl mr-2'></i>
                                            Komentar & Masukan
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <textarea 
                                            name="komentar" 
                                            id="komentar-{{ $module->id }}" 
                                            rows="6" 
                                            class="w-full rounded-lg border-2 border-gray-200 focus:border-[#11A697] focus:ring-2 focus:ring-[#11A697]/20 text-sm md:text-base p-3 transition-all duration-200" 
                                            placeholder="Tulis komentar detail, kritik, saran, atau masukan Anda untuk modul ini..."
                                            required
                                        >{{ old('komentar', $myReview->komentar ?? '') }}</textarea>
                                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                                            <i class='bx bx-info-circle mr-1'></i>
                                            Berikan komentar yang konstruktif dan detail untuk membantu perbaikan proposal
                                        </p>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                                        <button type="submit" class="flex-1 sm:flex-initial inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-[#11A697] to-[#0e8a7c] text-white rounded-lg hover:from-[#0e8a7c] hover:to-[#0c7567] font-semibold text-sm md:text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                            <i class='bx bx-save text-xl mr-2'></i>
                                            Simpan Review
                                        </button>
                                        @if($myReview)
                                            <div class="flex items-center text-xs md:text-sm text-gray-600 bg-white px-4 py-2 rounded-lg border border-gray-200">
                                                <i class='bx bx-check-circle text-green-500 text-lg mr-2'></i>
                                                <span>Review terakhir diperbarui</span>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border-2 border-dashed border-gray-300 p-8 md:p-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class='bx bx-folder-open text-5xl md:text-6xl text-gray-400'></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-700 mb-2">Belum Ada Modul</h3>
                        <p class="text-sm md:text-base text-gray-500 max-w-md">Belum ada modul yang dikonfigurasi untuk sesi proposal ini. Silakan hubungi administrator.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Submit Final Review Section --}}
    @php
        $totalModuls = $allModules->count();
        $reviewedModuls = $allReviews->where('reviewer_id', $currentReviewerId)->pluck('student_exchange_modul_id')->unique()->count();
        $allModulsReviewed = $totalModuls > 0 && $reviewedModuls === $totalModuls;
        $finalReviewSubmitted = $proposal->nilai_reviewer !== null;
    @endphp

    @if($totalModuls > 0)
    <div class="mt-6 md:mt-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 {{ $allModulsReviewed ? 'border-green-300' : 'border-gray-200' }}">
            <div class="p-5 border-b {{ $allModulsReviewed ? 'bg-gradient-to-r from-green-500 to-emerald-500' : 'bg-gray-100' }}">
                <h2 class="text-xl font-semibold flex items-center {{ $allModulsReviewed ? 'text-white' : 'text-gray-700' }}">
                    <i class='bx {{ $allModulsReviewed ? "bx-check-circle" : "bx-info-circle" }} text-2xl mr-2'></i>
                    Submit Review Final
                </h2>
            </div>
            <div class="p-6">
                {{-- Progress Indicator --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-700">Progress Review</span>
                        <span class="text-sm font-bold {{ $allModulsReviewed ? 'text-green-600' : 'text-gray-600' }}">
                            {{ $reviewedModuls }} / {{ $totalModuls }} Modul
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-500" 
                             style="width: {{ $totalModuls > 0 ? ($reviewedModuls / $totalModuls * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                @if($finalReviewSubmitted)
                    <div class="bg-green-50 border-2 border-green-300 rounded-lg p-6 text-center">
                        <i class='bx bx-check-circle text-6xl text-green-500 mb-3'></i>
                        <h3 class="text-xl font-bold text-green-700 mb-2">Review Final Sudah Disubmit</h3>
                        <p class="text-gray-600 mb-3">Nilai Akhir: <span class="text-2xl font-bold text-green-600">{{ number_format($proposal->nilai_reviewer, 2) }}</span></p>
                        <p class="text-sm text-gray-500">Direview pada: {{ $proposal->tanggal_review->format('d M Y H:i') }}</p>
                    </div>
                @elseif($allModulsReviewed)
                    <div class="space-y-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class='bx bx-check-circle text-2xl text-green-500 mr-3 mt-0.5'></i>
                                <div>
                                    <h4 class="font-bold text-green-800 mb-1">Semua Modul Sudah Direview</h4>
                                    <p class="text-sm text-gray-700">Anda sudah menyelesaikan review untuk semua modul. Klik tombol di bawah untuk submit review final.</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('reviewer_equity.student_exchange.submitFinal', $proposal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin submit review final? Nilai akan dihitung otomatis sebagai rata-rata dari semua modul yang telah direview.')">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg hover:from-green-600 hover:to-emerald-600 font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                <i class='bx bx-send text-2xl mr-2'></i>
                                Submit Review Final
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class='bx bx-info-circle text-2xl text-yellow-500 mr-3 mt-0.5'></i>
                            <div>
                                <h4 class="font-bold text-yellow-800 mb-1">Review Belum Lengkap</h4>
                                <p class="text-sm text-gray-700">Anda harus menyelesaikan review untuk semua modul sebelum dapat submit review final. Progress saat ini: {{ $reviewedModuls }}/{{ $totalModuls }} modul.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
@endsection
