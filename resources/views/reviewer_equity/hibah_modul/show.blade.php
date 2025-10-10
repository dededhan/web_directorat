@extends('reviewer_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Review Proposal</h1>
            <p class="mt-2 text-gray-600">{{ $proposal->judul_modul }}</p>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Proposal -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Proposal</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Judul</label>
                            <p class="text-gray-800 text-lg">{{ $proposal->judul_modul }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Ringkasan</label>
                            <p class="text-gray-800">{{ $proposal->ringkasan_modul }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Pengusul</label>
                                <p class="text-gray-800">{{ $proposal->user->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Sesi</label>
                                <p class="text-gray-800">{{ $proposal->sesi->nama_sesi }}</p>
                            </div>
                        </div>
                        @if($proposal->file_proposal)
                        <div>
                            <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class='bx bxs-file-pdf mr-2'></i>Lihat Proposal (PDF)
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Anggota Penyusun -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Anggota Penyusun</h2>
                    @foreach($proposal->anggota as $anggota)
                    <div class="border rounded-lg p-3 mb-2">
                        <p class="font-semibold">{{ $anggota->nama_dosen }}</p>
                        <p class="text-sm text-gray-600">NIP: {{ $anggota->nip ?? '-' }} | {{ $anggota->fakultas }} - {{ $anggota->prodi }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Laporan Akhir & Review -->
                @foreach($proposal->sesi->moduls as $modul)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">{{ $modul->judul_modul }}</h3>
                    </div>

                    <div class="p-6 space-y-4">
                        @foreach($modul->subChapters as $subChapter)
                        @php
                            $file = $proposal->files->where('modul_sub_chapter_id', $subChapter->id)->first();
                            $existingReview = $proposal->reviews->where('modul_sub_chapter_id', $subChapter->id)->where('reviewer_id', auth()->id())->first();
                        @endphp
                        <div class="border rounded-lg p-4 {{ $existingReview ? 'bg-green-50' : 'bg-white' }}">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">{{ $subChapter->judul_sub_chapter }}</h4>
                                    <p class="text-sm text-gray-600">{{ $subChapter->deskripsi }}</p>
                                </div>
                                @if($subChapter->is_wajib)
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Wajib</span>
                                @endif
                            </div>

                            @if($file)
                            <div class="bg-blue-50 p-3 rounded-lg mb-3">
                                <p class="text-sm font-semibold text-blue-800 mb-2">File yang diupload:</p>
                                @if($file->tipe_file === 'pdf')
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                                    <i class='bx bxs-file-pdf mr-1'></i>Lihat PDF
                                </a>
                                @else
                                <a href="{{ $file->link_url }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                                    <i class='bx bx-link-external mr-1'></i>{{ $file->link_url }}
                                </a>
                                @endif
                            </div>
                            @endif

                            <!-- Form Review -->
                            <form action="{{ route('reviewer_hibah.hibah_modul.storeReview', [$proposal->id, $subChapter->id]) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Komentar Review</label>
                                    <textarea name="komentar" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ $existingReview->komentar ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nilai (0-100)</label>
                                    <input type="number" name="nilai" min="0" max="100" value="{{ $existingReview->nilai ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    <i class='bx bx-save mr-2'></i>{{ $existingReview ? 'Update Review' : 'Simpan Review' }}
                                </button>
                            </form>

                            @if($existingReview)
                            <div class="mt-3 p-3 bg-green-100 rounded-lg">
                                <p class="text-sm text-green-800">
                                    <i class='bx bx-check-circle mr-1'></i>Review sudah disimpan
                                </p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Sidebar - Review Final -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Komentar Final</h3>
                    <form action="{{ route('reviewer_hibah.hibah_modul.submitFinal', $proposal->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kesimpulan Review</label>
                            <textarea name="komentar_reviewer" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ $proposal->komentar_reviewer ?? '' }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Berikan kesimpulan umum dari review Anda</p>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-purple-800 shadow-md">
                            <i class='bx bx-send mr-2'></i>Kirim ke Admin
                        </button>
                    </form>
                </div>

                <!-- Status Info -->
                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-r-lg">
                    <p class="text-sm font-semibold text-purple-800 mb-2">Status Proposal</p>
                    <span class="px-3 py-1 bg-purple-600 text-white text-xs font-semibold rounded-full">
                        {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                    </span>
                </div>

                <!-- Info -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class='bx bx-info-circle mr-1'></i>
                        Pastikan semua sub chapter sudah direview sebelum mengirim komentar final ke admin.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
