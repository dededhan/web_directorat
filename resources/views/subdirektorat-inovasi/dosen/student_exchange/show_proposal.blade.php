@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header & Breadcrumb --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.manage') }}" class="hover:text-teal-600 transition-colors duration-200">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Proposal</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Proposal Student Exchange</h1>
                    <p class="mt-2 text-gray-600 text-base">Sesi: <span class="font-semibold text-teal-600">{{ $proposal->sesi->nama_sesi }}</span></p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.manage') }}" class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali
                    </a>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-check-circle text-green-400 text-xl'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-green-800">Sukses</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Status Timeline --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class='bx bx-time-five text-teal-600 mr-2 text-2xl'></i>
                Status Proposal
            </h2>
            <div class="relative">
                @php
                $statuses = ['draft', 'diajukan', 'menunggu_verifikasi', 'diterima', 'menunggu_direview', 'sedang_direview', 'lolos'];
                $currentIndex = array_search($proposal->status, $statuses);
                $statusLabels = ['Draft', 'Diajukan', 'Verifikasi', 'Diterima', 'Menunggu Review', 'Sedang Review', 'Lolos'];
                @endphp
                
                <div class="flex items-center justify-between mb-4">
                    @foreach($statusLabels as $index => $label)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all
                            @if($index <= $currentIndex) bg-teal-600 text-white shadow-lg
                            @else bg-gray-200 text-gray-600
                            @endif">
                            @if($index < $currentIndex)
                            <i class='bx bx-check text-lg'></i>
                            @else
                            {{ $index + 1 }}
                            @endif
                        </div>
                        <p class="text-xs mt-2 text-center font-medium {{ $index <= $currentIndex ? 'text-teal-600' : 'text-gray-500' }}">{{ $label }}</p>
                    </div>
                    @if($index < count($statusLabels) - 1)
                    <div class="flex-1 h-1 mx-2 {{ $index < $currentIndex ? 'bg-teal-600' : 'bg-gray-200' }}"></div>
                    @endif
                    @endforeach
                </div>
                
                <div class="text-center mt-6">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold border-2
                        @if($proposal->status === 'draft') bg-gray-100 text-gray-800 border-gray-200
                        @elseif($proposal->status === 'diajukan') bg-blue-100 text-blue-800 border-blue-200
                        @elseif($proposal->status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 border-yellow-200
                        @elseif($proposal->status === 'diterima') bg-green-100 text-green-800 border-green-200
                        @elseif($proposal->status === 'ditolak') bg-red-100 text-red-800 border-red-200
                        @elseif($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800 border-purple-200
                        @elseif($proposal->status === 'lolos') bg-emerald-100 text-emerald-800 border-emerald-200
                        @else bg-orange-100 text-orange-800 border-orange-200
                        @endif">
                        {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-3 mb-6">
            @if(in_array($proposal->status, ['draft', 'diajukan']))
            <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.edit', $proposal->id) }}" class="inline-flex items-center px-4 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all shadow-md">
                <i class='bx bx-edit-alt mr-2 text-lg'></i>
                Edit Proposal
            </a>
            @endif

            @if($proposal->status === 'draft')
            <form action="{{ route('subdirektorat-inovasi.dosen.student_exchange.confirm', $proposal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengajukan proposal ini?')">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-all shadow-md">
                    <i class='bx bx-paper-plane mr-2 text-lg'></i>
                    Ajukan Proposal
                </button>
            </form>
            @endif

            @if($proposal->status === 'diterima')
            <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.laporanAkhir', $proposal->id) }}" class="inline-flex items-center px-4 py-2.5 bg-purple-500 text-white font-semibold rounded-xl hover:bg-purple-600 transition-all shadow-md">
                <i class='bx bx-file-blank mr-2 text-lg'></i>
                Laporan Akhir
            </a>
            @endif

            @if(in_array($proposal->status, ['draft', 'diajukan']))
            <form action="{{ route('subdirektorat-inovasi.dosen.student_exchange.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Yakin hapus proposal ini? Aksi ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all shadow-md">
                    <i class='bx bx-trash mr-2 text-lg'></i>
                    Hapus Proposal
                </button>
            </form>
            @endif
        </div>

        {{-- Informasi Dasar --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-info-circle mr-3 text-2xl'></i>
                    Informasi Dasar Kegiatan
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Judul Kegiatan</label>
                        <p class="text-base text-gray-900 mt-1 font-medium">{{ $proposal->judul_kegiatan }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Jenis Kegiatan</label>
                        <p class="text-base text-gray-900 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $proposal->jenis_kegiatan === 'inbound' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                <i class='bx {{ $proposal->jenis_kegiatan === 'inbound' ? 'bx-log-in' : 'bx-log-out' }} mr-1'></i>
                                {{ ucfirst($proposal->jenis_kegiatan) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600">Ringkasan Kegiatan</label>
                    <p class="text-base text-gray-900 mt-1 leading-relaxed">{{ $proposal->ringkasan_kegiatan }}</p>
                </div>

                @if($proposal->sdgs_fokus)
                <div>
                    <label class="text-sm font-semibold text-gray-600">SDGs Fokus</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($proposal->sdgs_fokus as $sdg)
                        <span class="px-3 py-1 bg-teal-100 text-teal-800 text-sm font-semibold rounded-full">SDG {{ $sdg }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($proposal->sdgs_pendukung)
                <div>
                    <label class="text-sm font-semibold text-gray-600">SDGs Pendukung</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($proposal->sdgs_pendukung as $sdg)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">SDG {{ $sdg }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Jumlah Peserta</label>
                        <p class="text-base text-gray-900 mt-1 font-medium">{{ $proposal->jumlah_peserta }} mahasiswa</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">SKS</label>
                        <p class="text-base text-gray-900 mt-1 font-medium">{{ $proposal->sks }} SKS</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tanggal Online</label>
                        <p class="text-base text-gray-900 mt-1">{{ $proposal->tanggal_online ? $proposal->tanggal_online->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tanggal Onsite</label>
                        <p class="text-base text-gray-900 mt-1">{{ $proposal->tanggal_onsite ? $proposal->tanggal_onsite->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi Mitra --}}
        @if($proposal->mitra)
        @php $mitra = $proposal->mitra; @endphp
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-buildings mr-3 text-2xl'></i>
                    Informasi Institusi Mitra
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Mitra</label>
                        <p class="text-base text-gray-900 mt-1 font-medium">{{ $mitra->nama_mitra }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Negara</label>
                        <p class="text-base text-gray-900 mt-1 font-medium">{{ $mitra->negara }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Person In Charge (PIC)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Nama PIC</label>
                            <p class="text-base text-gray-900 mt-1">{{ $mitra->nama_pic }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Nomor Kontak</label>
                            <p class="text-base text-gray-900 mt-1">{{ $mitra->nomor_kontak_pic }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Email</label>
                            <p class="text-base text-gray-900 mt-1">{{ $mitra->email_pic }}</p>
                        </div>
                    </div>
                </div>

                @if($mitra->kesediaan_mitra_path)
                <div class="border-t pt-4">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Dokumen Kesediaan Mitra</label>
                    <a href="{{ Storage::url($mitra->kesediaan_mitra_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-50 border-2 border-red-200 text-red-700 font-semibold rounded-lg hover:bg-red-100 transition-all">
                        <i class='bx bxs-file-pdf text-xl mr-2'></i>
                        Unduh Dokumen
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Anggota Tim --}}
        @if($proposal->anggota->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-group mr-3 text-2xl'></i>
                    Anggota Tim Pelaksana ({{ $proposal->anggota->count() }})
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($proposal->anggota as $anggota)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-gray-600">Nama Dosen</label>
                                <p class="text-sm text-gray-900 mt-1 font-medium">{{ $anggota->nama_dosen }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-600">NIP</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $anggota->nip ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-600">Fakultas</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $anggota->fakultas ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-600">Program Studi</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $anggota->prodi ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Dokumen Pendukung --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-file mr-3 text-2xl'></i>
                    Dokumen Pendukung
                </h2>
            </div>
            <div class="p-6 space-y-3">
                @if($proposal->nama_mahasiswa_path)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class='bx bxs-file-pdf text-red-500 text-2xl mr-3'></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Daftar Nama Mahasiswa</p>
                            <p class="text-xs text-gray-500">{{ basename($proposal->nama_mahasiswa_path) }}</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($proposal->nama_mahasiswa_path) }}" target="_blank" class="px-3 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition-all">
                        <i class='bx bx-download mr-1'></i>Unduh
                    </a>
                </div>
                @endif

                @if($proposal->mata_kuliah_path)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class='bx bxs-file-pdf text-red-500 text-2xl mr-3'></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Daftar Mata Kuliah</p>
                            <p class="text-xs text-gray-500">{{ basename($proposal->mata_kuliah_path) }}</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($proposal->mata_kuliah_path) }}" target="_blank" class="px-3 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition-all">
                        <i class='bx bx-download mr-1'></i>Unduh
                    </a>
                </div>
                @endif

                @if($proposal->rab_path)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class='bx bxs-file-pdf text-red-500 text-2xl mr-3'></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Rencana Anggaran Biaya (RAB)</p>
                            <p class="text-xs text-gray-500">{{ basename($proposal->rab_path) }}</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($proposal->rab_path) }}" target="_blank" class="px-3 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition-all">
                        <i class='bx bx-download mr-1'></i>Unduh
                    </a>
                </div>
                @endif

                @if(!$proposal->nama_mahasiswa_path && !$proposal->mata_kuliah_path && !$proposal->rab_path)
                <div class="text-center py-8">
                    <i class='bx bx-file text-4xl text-gray-300 mb-2'></i>
                    <p class="text-gray-500">Belum ada dokumen pendukung yang diupload</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Komentar Admin/Reviewer --}}
        @if($proposal->komentar_admin || $proposal->komentar_reviewer || $proposal->alasan_penolakan)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-message-square-detail mr-3 text-2xl'></i>
                    Komentar & Catatan
                </h2>
            </div>
            <div class="p-6 space-y-4">
                @if($proposal->komentar_admin)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <h3 class="text-sm font-bold text-yellow-800 mb-2">Komentar Admin</h3>
                    <p class="text-sm text-yellow-700">{{ $proposal->komentar_admin }}</p>
                </div>
                @endif

                @if($proposal->komentar_reviewer)
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <h3 class="text-sm font-bold text-blue-800 mb-2">Komentar Reviewer</h3>
                    <p class="text-sm text-blue-700">{{ $proposal->komentar_reviewer }}</p>
                </div>
                @endif

                @if($proposal->alasan_penolakan)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <h3 class="text-sm font-bold text-red-800 mb-2">Alasan Penolakan</h3>
                    <p class="text-sm text-red-700">{{ $proposal->alasan_penolakan }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
