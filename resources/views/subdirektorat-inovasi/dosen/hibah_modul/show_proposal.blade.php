@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Detail Proposal</h1>
                    <p class="mt-2 text-gray-600">{{ $proposal->sesi->nama_sesi }}</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.manage') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    <i class='bx bx-arrow-back mr-2'></i>Kembali
                </a>
            </div>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Timeline Status -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Status Proposal</h2>
            <div class="flex items-center justify-between">
                @php
                $statuses = ['draft', 'diajukan', 'menunggu_verifikasi', 'diterima', 'sedang_direview', 'lolos'];
                $currentIndex = array_search($proposal->status, $statuses);
                @endphp
                @foreach(['Draft', 'Diajukan', 'Verifikasi', 'Diterima', 'Review', 'Lolos'] as $index => $label)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm
                        @if($index <= $currentIndex) bg-teal-600 text-white
                        @else bg-gray-200 text-gray-600
                        @endif">
                        {{ $index + 1 }}
                    </div>
                    <p class="text-xs mt-2 text-center {{ $index <= $currentIndex ? 'text-teal-600 font-semibold' : 'text-gray-500' }}">{{ $label }}</p>
                </div>
                @if($index < 5)
                <div class="flex-1 h-1 {{ $index < $currentIndex ? 'bg-teal-600' : 'bg-gray-200' }}"></div>
                @endif
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($proposal->status === 'draft') bg-gray-100 text-gray-800
                    @elseif($proposal->status === 'diajukan') bg-blue-100 text-blue-800
                    @elseif($proposal->status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                    @elseif($proposal->status === 'diterima') bg-green-100 text-green-800
                    @elseif($proposal->status === 'ditolak') bg-red-100 text-red-800
                    @elseif($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800
                    @elseif($proposal->status === 'lolos') bg-emerald-100 text-emerald-800
                    @else bg-orange-100 text-orange-800
                    @endif">
                    Status: {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
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
                        @if($proposal->kata_kunci && is_array($proposal->kata_kunci))
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Kata Kunci</label>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($proposal->kata_kunci as $keyword)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if($proposal->sdgs && is_array($proposal->sdgs))
                        <div>
                            <label class="text-sm font-semibold text-gray-600">SDGs</label>
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
                                <i class='bx bxs-file-pdf mr-2'></i>Lihat PDF
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Anggota -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Anggota Penyusun</h2>
                    @foreach($proposal->anggota as $anggota)
                    <div class="border rounded-lg p-4 mb-3">
                        <p class="font-semibold">{{ $anggota->nama_dosen }}</p>
                        <p class="text-sm text-gray-600">NIP: {{ $anggota->nip ?? '-' }}</p>
                        <p class="text-sm text-gray-600">{{ $anggota->fakultas }} - {{ $anggota->prodi }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Review -->
                @if($proposal->reviews->count() > 0)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Review dari Reviewer</h2>
                    @foreach($proposal->reviews as $review)
                    <div class="border-l-4 border-purple-500 bg-purple-50 p-4 rounded-r-lg mb-3">
                        <p class="font-semibold">{{ $review->subChapter->judul_sub_chapter }}</p>
                        <p class="text-gray-700 mt-2">{{ $review->komentar }}</p>
                        @if($review->nilai)
                        <p class="text-sm text-purple-600 mt-2 font-semibold">Nilai: {{ $review->nilai }}/100</p>
                        @endif
                    </div>
                    @endforeach
                    @if($proposal->komentar_reviewer)
                    <div class="mt-4 p-4 bg-purple-100 rounded-lg">
                        <p class="font-semibold text-purple-800">Komentar Reviewer:</p>
                        <p class="text-purple-900 mt-1">{{ $proposal->komentar_reviewer }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Komentar Admin -->
                @if($proposal->komentar_admin)
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                    <p class="font-semibold text-yellow-800">Komentar Admin:</p>
                    <p class="text-yellow-900 mt-1">{{ $proposal->komentar_admin }}</p>
                </div>
                @endif

                @if($proposal->alasan_penolakan)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <p class="font-semibold text-red-800">Alasan Penolakan:</p>
                    <p class="text-red-900 mt-1">{{ $proposal->alasan_penolakan }}</p>
                </div>
                @endif

                @if($proposal->status === 'lolos' && $proposal->nominal_hibah)
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <p class="font-semibold text-green-800">Nominal Hibah Disetujui:</p>
                    <p class="text-green-900 text-2xl font-bold mt-1">Rp {{ number_format($proposal->nominal_hibah, 0, ',', '.') }}</p>
                </div>
                @endif
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-4">
                @if(in_array($proposal->status, ['draft', 'diajukan']))
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.edit', $proposal->id) }}" class="block w-full px-4 py-2 bg-yellow-600 text-white text-center rounded-lg hover:bg-yellow-700">
                    <i class='bx bx-edit mr-2'></i>Edit Proposal
                </a>
                @endif

                @if($proposal->status === 'draft')
                <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.confirm', $proposal->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class='bx bx-paper-plane mr-2'></i>Ajukan Proposal
                    </button>
                </form>
                @endif

                @if($proposal->status === 'diajukan')
                <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.confirmVerifikasi', $proposal->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class='bx bx-check-circle mr-2'></i>Konfirmasi ke Verifikasi
                    </button>
                </form>
                @endif

                @if($proposal->status === 'diterima')
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.laporanAkhir', $proposal->id) }}" class="block w-full px-4 py-2 bg-purple-600 text-white text-center rounded-lg hover:bg-purple-700">
                    <i class='bx bx-file-blank mr-2'></i>Isi Laporan Akhir
                </a>
                @endif

                @if(in_array($proposal->status, ['draft', 'diajukan']))
                <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Yakin hapus proposal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <i class='bx bx-trash mr-2'></i>Hapus Proposal
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
