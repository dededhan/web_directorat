@extends('reviewer_equity.index')

@section('content')
    {{-- Bagian Header Halaman --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail & Review Proposal</h1>
        <p class="text-gray-500 mt-1">Judul: <span class="font-semibold">{{ $submission->judul }}</span></p>
        <p class="text-gray-500">Diajukan oleh: <span class="font-semibold">{{ $submission->user->name }}</span></p>
    </div>

    {{-- Pre-processing collections untuk akses lebih mudah & efisien di dalam loop --}}
    @php
        $allModules = $submission->sesi->modules;
        $uploadedFiles = $submission->files->keyBy('comdev_sub_chapter_id');
        $allReviews = $submission->reviews;
        $currentReviewerId = auth()->id();
    @endphp

    {{-- Card Utama untuk Tahapan Proposal & Review --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="p-5 border-b bg-[#11A697] text-white">
            <h2 class="text-xl font-semibold flex items-center">
                <i class='bx bx-sitemap text-2xl mr-3'></i>Tahapan Proposal & Review
            </h2>
        </div>

        <div class="p-6 bg-gray-50/70 rounded-b-xl space-y-6">
            @forelse ($allModules as $module)
                {{-- Setiap modul adalah card accordion --}}
                <div class="border border-gray-200 rounded-lg bg-white" x-data="{ open: true }">
                    {{-- Header Modul (Bisa di-klik) --}}
                    <div class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-100 transition duration-200" @click="open = !open">
                        <h3 class="font-bold text-lg text-gray-800">{{ $module->urutan }}. {{ $module->nama_modul }}</h3>
                        <i class='bx bxs-chevron-down text-xl text-gray-500 transition-transform' :class="{'rotate-180': open}"></i>
                    </div>

                    {{-- Konten Modul (Sub-bab dan area review) --}}
                    <div x-show="open" x-transition class="pt-2 pb-4 px-5 border-t divide-y">
                        
                        @forelse ($module->subChapters as $subChapter)
                            <div class="py-4">
                                <p class="font-semibold text-gray-700 text-md mb-3">{{ $subChapter->nama_sub_bab }}</p>
                                
                                @php
                                    $file = $uploadedFiles->get($subChapter->id);
                                    $reviewsForThisSubChapter = $allReviews->where('comdev_sub_chapter_id', $subChapter->id);
                                    $myReview = $reviewsForThisSubChapter->where('reviewer_id', $currentReviewerId)->first();
                                @endphp

                                {{-- 1. Tampilkan File yang Diunggah Dosen --}}
                                <div class="pl-4 mb-4">
                                    <p class="text-sm text-gray-500 mb-2">Dokumen dari Dosen:</p>
                                    @if($file)
                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.files.download', $file->id) }}" target="_blank" class="inline-flex items-center text-[#11A697] hover:underline font-medium text-sm">
                                            <i class='bx bxs-download mr-2 text-lg'></i> {{ $file->original_filename }}
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400 italic">Belum ada file yang diunggah.</p>
                                    @endif
                                </div>

                                {{-- 2. Tampilkan Komentar dari Semua Reviewer --}}
                                <div class="pl-4 mb-4">
                                    <p class="text-sm text-gray-500 mb-2">Komentar Reviewer Lain:</p>
                                    <div class="space-y-3">
                                        @forelse ($reviewsForThisSubChapter->where('reviewer_id', '!=', $currentReviewerId) as $review)
                                            <div class="bg-gray-100 p-3 rounded-lg border border-gray-200">
                                                <p class="text-sm font-semibold text-gray-800">{{ $review->reviewer->name }}</p>
                                                <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap">{{ $review->komentar }}</p>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-400 italic">Belum ada komentar dari reviewer lain.</p>
                                        @endforelse
                                    </div>
                                </div>
                                
                                {{-- 3. Form untuk Komentar Anda --}}
                                <div class="pl-4">
                                    <form action="{{ route('reviewer_equity.comdev.assignments.storeReview', ['submission' => $submission->id, 'subChapter' => $subChapter->id]) }}" method="POST">
                                        @csrf
                                        <label for="komentar-{{ $subChapter->id }}" class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda:</label>
                                        <textarea 
                                            name="komentar" 
                                            id="komentar-{{ $subChapter->id }}" 
                                            rows="3" 
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring-[#11A697] text-sm" 
                                            placeholder="Tulis komentar atau masukan Anda di sini..."
                                        >{{ old('komentar', $myReview->komentar ?? '') }}</textarea>
                                        <div class="text-right mt-2">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] text-sm font-medium transition">
                                                Simpan Komentar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic py-4">Tidak ada sub-bab untuk modul ini.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <p class="text-gray-500 italic">Belum ada modul yang dikonfigurasi untuk sesi proposal ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection