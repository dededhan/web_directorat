@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Tombol Kembali --}}
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Proposal Penelitian</h1>
                <nav class="text-sm" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                        <li class="flex items-center"><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                                class="hover:text-gray-700">Home</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                        </li>
                        <li class="flex items-center"><a
                                href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}"
                                class="hover:text-gray-700">Manajemen Proposal</a><i
                                class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                        <li class="flex items-center"><span class="font-medium text-gray-700">Detail Data Proposal</span>
                        </li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                <i class='bx bx-arrow-back mr-2'></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Kartu Detail Proposal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
            <div class="p-6 md:p-8">
                <div class="border-b border-slate-200 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Detail Proposal Penelitian Pengabdian</h2>
                    <p class="text-gray-500 mt-1">Detail data untuk: {{ $submission->judul ?? 'Proposal' }}</p>
                </div>

                <div class="space-y-6">
                    <!-- Bagian Info Umum -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-4 rounded-lg border">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tahun Pertama Usulan</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">{{ $submission->tahun_usulan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tahun Usulan Kegiatan</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">{{ $submission->tahun_usulan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tahun Pelaksanaan</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">
                                {{ $submission->tahun_pelaksanaan ?? ($submission->tahun_usulan ?? '-') }}</p>
                        </div>
                    </div>

                    <!-- Bagian Detail Utama -->
                    <div class="divide-y divide-gray-200">
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Tawaran</p>
                            <p class="text-sm text-gray-800 md:col-span-3 font-semibold">
                                {{ $submission->sesi->nama_sesi ?? 'Tidak ada skema' }}</p>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Judul Proposal</p>
                            <p class="text-sm text-gray-800 md:col-span-3 font-semibold">
                                {{ $submission->judul ?? 'Belum ada judul' }}</p>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Ringkasan / Abstrak</p>
                            <p class="text-sm text-gray-800 md:col-span-3 leading-relaxed">
                                {{ $submission->abstrak ?? 'Tidak ada abstrak.' }}</p>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Kata Kunci</p>
                            <div class="text-sm text-gray-800 md:col-span-3">
                                {{-- I've updated this section to correctly loop through the keyword array --}}
                                @if (!empty($submission->kata_kunci) && is_array($submission->kata_kunci))
                                    @foreach ($submission->kata_kunci as $keyword)
                                        <span
                                            class="bg-gray-100 text-gray-700 px-2 py-1 rounded-md text-xs inline-block mb-1">{{ trim($keyword) }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Lokasi</p>
                            <p class="text-sm text-gray-800 md:col-span-3">{{ $submission->tempat_pelaksanaan ?? '-' }}</p>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Fokus SDG's</p>
                            <div class="text-sm text-gray-800 md:col-span-3">
                                @if($submission->sdgs_fokus && is_array($submission->sdgs_fokus) && count($submission->sdgs_fokus) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($submission->sdgs_fokus as $sdg)
                                            <span class="inline-flex items-center px-3 py-1 bg-teal-100 text-teal-800 text-xs font-medium rounded-full">{{ $sdg }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">SDG's Pendukung</p>
                            <div class="text-sm text-gray-800 md:col-span-3">
                                @if($submission->sdgs_pendukung && is_array($submission->sdgs_pendukung) && count($submission->sdgs_pendukung) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($submission->sdgs_pendukung as $sdg)
                                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">{{ $sdg }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </div>
                         <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Mitra Nasional</p>
                            <p class="text-sm text-gray-800 md:col-span-3">
                                {{-- I've fixed this line to properly display the SDGs array as a string --}}{{ is_array($submission->mitra_nasional) ? implode(', ', $submission->mitra_nasional) : $submission->mitra_nasional ?? '-' }}
                            </p>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Mitra Internsional</p>
                            <p class="text-sm text-gray-800 md:col-span-3">
                                {{-- I've fixed this line to properly display the SDGs array as a string --}}{{ is_array($submission->mitra_internasional) ? implode(', ', $submission->mitra_internasional) : $submission->mitra_internasional ?? '-' }}
                            </p>
                        </div>

                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Nominal Usulan</p>
                            <p class="text-sm text-gray-800 md:col-span-3 font-bold">Rp
                                {{ number_format($submission->nominal_usulan ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <p class="text-sm font-medium text-gray-600 md:col-span-1">Nominal Disetujui</p>
                            @php
                                $firstModuleStatus = $submission->moduleStatuses->first();
                                $nominalDisetujui = $firstModuleStatus && $firstModuleStatus->nominal_evaluasi > 0 ? $firstModuleStatus->nominal_evaluasi : null;
                            @endphp
                            <p class="text-sm text-green-600 md:col-span-3 font-bold">
                                {{ $nominalDisetujui ? 'Rp ' . number_format($nominalDisetujui, 0, ',', '.') : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Tim Peneliti</h3>
                        <div class="space-y-4">
                            {{-- Menampilkan Ketua Tim --}}
                            @php
                                $ketua = $submission->members->firstWhere('peran', 'Ketua');
                            @endphp
                            @if ($ketua)
                                <div class="bg-teal-50 p-4 rounded-lg border border-teal-200">
                                    <p class="text-sm font-semibold text-teal-800 mb-2">Ketua Tim</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                        <div>
                                            <p class="font-medium text-gray-500">Nama</p>
                                            <p class="text-gray-800">{{ $ketua->nama_lengkap }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-500">NIK/NIM/NIP</p>
                                            <p class="text-gray-800">{{ $ketua->nik_nim_nip }}</p>
                                        </div>

                                        {{-- Alamat dipecah --}}
                                        <div class="mt-2">
                                            <p class="font-medium text-gray-500">Alamat Jalan</p>
                                            <p class="text-gray-800">{{ $ketua->alamat_jalan }}</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="font-medium text-gray-500">Kelurahan</p>
                                            <p class="text-gray-800">{{ $ketua->kelurahan }}</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="font-medium text-gray-500">Kecamatan</p>
                                            <p class="text-gray-800">{{ $ketua->kecamatan }}</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="font-medium text-gray-500">Kota/Kabupaten</p>
                                            <p class="text-gray-800">{{ $ketua->kota_kabupaten }}</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="font-medium text-gray-500">Provinsi</p>
                                            <p class="text-gray-800">{{ $ketua->provinsi }}</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="font-medium text-gray-500">Kode Pos</p>
                                            <p class="text-gray-800">{{ $ketua->kode_pos }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Menampilkan Anggota Tim --}}
                            @php
                                $anggota = $submission->members->where('peran', 'Anggota');
                            @endphp
                            @if ($anggota->isNotEmpty())
                                <div class="pt-4">
                                    <p class="text-sm font-semibold text-gray-800 mb-2">Anggota Tim</p>
                                    @foreach ($anggota as $item)
                                        <div class="bg-gray-50 p-4 rounded-lg border mb-3">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                                <div>
                                                    <p class="font-medium text-gray-500">Nama</p>
                                                    <p class="text-gray-800">{{ $item->nama_lengkap }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-500">NIK/NIM/NIP</p>
                                                    <p class="text-gray-800">{{ $item->nik_nim_nip }}</p>
                                                </div>

                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bagian Luaran -->
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Dokumen Luaran</h3>
                        <div class="divide-y divide-gray-200 border rounded-lg">

                            @if (!empty($submission->luaran_wajib) && is_array($submission->luaran_wajib))
                                @forelse ($submission->luaran_wajib as $item)
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                                        <p class="text-sm font-medium text-gray-600">
                                            @if ($item['type'] === 'file')
                                                <i class='bx bxs-file-pdf mr-1 text-red-500'></i> File Luaran Wajib
                                            @else
                                                <i class='bx bx-link mr-1 text-blue-500'></i> Link Luaran Wajib
                                            @endif
                                        </p>
                                        <div class="text-sm text-gray-800">
                                            @if ($item['type'] === 'file')
                                                <a href="{{ $item['value'] }}" target="_blank"
                                                    class="font-semibold text-teal-600 hover:underline">
                                                    {{ $item['nama_file'] ?? 'Unduh File' }}
                                                </a>
                                            @else
                                                <a href="{{ $item['value'] }}" target="_blank"
                                                    class="font-semibold text-teal-600 hover:underline break-all">
                                                    {{ $item['value'] }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-sm text-gray-500">
                                        Tidak ada dokumen luaran wajib yang diunggah.
                                    </div>
                                @endforelse
                            @else
                                <div class="p-4 text-center text-sm text-gray-500">
                                    Tidak ada dokumen luaran wajib yang diunggah.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Unduh Proposal -->

                </div>
            </div>
        </div>
    </div>
@endsection
