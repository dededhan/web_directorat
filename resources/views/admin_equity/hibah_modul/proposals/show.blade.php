@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.hibah_modul.sesi.index') }}" class="hover:text-teal-600">Hibah Modul</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.hibah_modul.proposals.index', $sesi->id) }}" class="hover:text-teal-600">Proposal</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Detail</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-800">Detail Proposal</h1>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <ul class="list-disc list-inside text-red-800">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Info Proposal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Proposal -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Proposal</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Judul Modul</label>
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
                                <p class="text-sm text-gray-500">{{ $proposal->user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Status</label>
                                <div class="mt-1">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($proposal->status === 'draft') bg-gray-100 text-gray-800
                                        @elseif($proposal->status === 'diajukan') bg-blue-100 text-blue-800
                                        @elseif($proposal->status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                                        @elseif($proposal->status === 'diterima') bg-green-100 text-green-800
                                        @elseif($proposal->status === 'ditolak') bg-red-100 text-red-800
                                        @elseif($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800
                                        @elseif($proposal->status === 'lolos') bg-emerald-100 text-emerald-800
                                        @else bg-orange-100 text-orange-800
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($proposal->kata_kunci)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Kata Kunci</label>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($proposal->kata_kunci as $keyword)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($proposal->sdgs)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">SDGs Terkait</label>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($proposal->sdgs as $sdg)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">SDG {{ $sdg }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($proposal->file_proposal)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">File Proposal</label>
                            <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="mt-2 inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class='bx bxs-file-pdf mr-2'></i> Lihat PDF
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Anggota Penyusun -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Anggota Penyusun</h2>
                    <div class="space-y-3">
                        @foreach($proposal->anggota as $anggota)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $anggota->nama_dosen }}</p>
                                    <p class="text-sm text-gray-600">NIP: {{ $anggota->nip ?? '-' }}</p>
                                    <p class="text-sm text-gray-600">{{ $anggota->fakultas }} - {{ $anggota->prodi }}</p>
                                </div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $anggota->urutan }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Laporan Akhir (jika ada) -->
                @if(in_array($proposal->status, ['diterima', 'menunggu_direview', 'sedang_direview', 'lolos', 'tidak_lolos']))
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Laporan Akhir</h2>
                    @if($proposal->files->count() > 0)
                    <div class="space-y-3">
                        @foreach($proposal->files as $file)
                        <div class="border rounded-lg p-4 flex items-center justify-between">
                            <div>
                                <p class="font-semibold">{{ $file->subChapter->judul_sub_chapter }}</p>
                                <p class="text-sm text-gray-600">
                                    @if($file->tipe_file === 'pdf')
                                        File PDF
                                    @else
                                        Link URL
                                    @endif
                                </p>
                            </div>
                            @if($file->tipe_file === 'pdf')
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                <i class='bx bx-download text-2xl'></i>
                            </a>
                            @else
                            <a href="{{ $file->link_url }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                <i class='bx bx-link-external text-2xl'></i>
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">Belum ada file yang diupload</p>
                    @endif
                </div>
                @endif

                <!-- Review dari Reviewer -->
                @if($proposal->reviews->count() > 0)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Review dari Reviewer</h2>
                    <div class="space-y-4">
                        @foreach($proposal->reviews as $review)
                        <div class="border-l-4 border-purple-500 bg-purple-50 p-4 rounded-r-lg">
                            <div class="flex items-start justify-between mb-2">
                                <p class="font-semibold text-gray-800">{{ $review->subChapter->judul_sub_chapter }}</p>
                                @if($review->nilai)
                                <span class="px-3 py-1 bg-purple-600 text-white text-sm font-semibold rounded-full">{{ $review->nilai }}/100</span>
                                @endif
                            </div>
                            <p class="text-gray-700">{{ $review->komentar }}</p>
                            <p class="text-sm text-gray-500 mt-2">Oleh: {{ $review->reviewer->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <!-- Assign Reviewer -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Assign Reviewer</h3>
                    <form action="{{ route('admin_equity.hibah_modul.proposals.assignReviewer', [$sesi->id, $proposal->id]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Reviewer</label>
                            <select name="reviewer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Reviewer --</option>
                                @foreach($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" {{ $proposal->reviewer_id == $reviewer->id ? 'selected' : '' }}>
                                    {{ $reviewer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            <i class='bx bx-user-check mr-2'></i>Assign Reviewer
                        </button>
                    </form>
                </div>

                <!-- Update Status -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Update Status</h3>
                    <form action="{{ route('admin_equity.hibah_modul.proposals.updateStatus', [$sesi->id, $proposal->id]) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                    <option value="menunggu_verifikasi" {{ $proposal->status == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diterima" {{ $proposal->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="ditolak" {{ $proposal->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="menunggu_direview" {{ $proposal->status == 'menunggu_direview' ? 'selected' : '' }}>Menunggu Direview</option>
                                    <option value="sedang_direview" {{ $proposal->status == 'sedang_direview' ? 'selected' : '' }}>Sedang Direview</option>
                                    <option value="lolos" {{ $proposal->status == 'lolos' ? 'selected' : '' }}>Lolos</option>
                                    <option value="tidak_lolos" {{ $proposal->status == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nominal Hibah (Rp)</label>
                                <input type="number" name="nominal_hibah" value="{{ old('nominal_hibah', $proposal->nominal_hibah) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Komentar Admin</label>
                                <textarea name="komentar_admin" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('komentar_admin', $proposal->komentar_admin) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('alasan_penolakan', $proposal->alasan_penolakan) }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-4 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                            <i class='bx bx-save mr-2'></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
