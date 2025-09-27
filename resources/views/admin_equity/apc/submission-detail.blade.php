@extends('admin_equity.index')

@php
if (!function_exists('getStatusInfoAdmin')) {
    function getStatusInfoAdmin($status) {
        switch ($status) {
            case 'diajukan': return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
            case 'verifikasi': return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Verifikasi'];
            case 'disetujui': return ['color' => 'green', 'icon' => 'bx-check-circle', 'text' => 'Disetujui'];
            case 'ditolak': return ['color' => 'red', 'icon' => 'bx-x-circle', 'text' => 'Ditolak'];
            default: return ['color' => 'gray', 'icon' => 'bx-question-mark', 'text' => 'Unknown'];
        }
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header & Breadcrumb --}}
        <header class="mb-8">
             <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.index') }}" class="hover:text-teal-600">Manajemen Sesi APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.show', $submission->session->id) }}" class="hover:text-teal-600">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Pengajuan</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pengajuan Jurnal</h1>
            <p class="mt-2 text-gray-600">Verifikasi kelengkapan data dan dokumen pengajuan dari <strong class="text-gray-800">{{ $submission->user->name }}</strong>.</p>
        </header>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Sukses</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8 space-y-8">
                {{-- Detail Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Judul Artikel</h3>
                        <p class="mt-1 text-gray-800 font-semibold">{{ $submission->judul_artikel }}</p>
                    </div>
                     <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Nama Jurnal (Q1)</h3>
                        <p class="mt-1 text-gray-800">{{ $submission->nama_jurnal_q1 }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Link ScimagoJR</h3>
                        <a href="{{ $submission->link_scimagojr }}" target="_blank" class="mt-1 text-teal-600 hover:underline break-all">{{ $submission->link_scimagojr }}</a>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Volume & Issue</h3>
                        <p class="mt-1 text-gray-800">Volume {{ $submission->volume ?? '-' }}, Issue {{ $submission->issue ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Biaya Diajukan</h3>
                        <p class="mt-1 text-lg font-bold text-red-600">Rp {{ number_format($submission->biaya_publikasi, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Status Saat Ini</h3>
                        @php $statusInfo = getStatusInfoAdmin($submission->status); @endphp
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{$statusInfo['color']}}-100 text-{{$statusInfo['color']}}-800">
                            <i class='bx {{$statusInfo['icon']}} mr-1.5'></i>
                            {{ $statusInfo['text'] }}
                        </span>
                    </div>
                </div>

                {{-- Daftar Penulis --}}
                <div class="border-t pt-6">
                    <h3 class="text-xs font-bold uppercase text-gray-500 mb-3">Daftar Penulis</h3>
                    <ul class="space-y-2">
                        @foreach ($submission->authors->sortBy('urutan') as $author)
                            <li class="flex items-start bg-gray-50 p-3 rounded-lg">
                                <span class="text-sm font-bold text-gray-600 mr-3">{{ $author->urutan }}.</span>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $author->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $author->afiliasi }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Dokumen --}}
                <div class="border-t pt-6">
                    <h3 class="text-xs font-bold uppercase text-gray-500 mb-3">Dokumen Pendukung</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="{{ Storage::url($submission->artikel_path) }}" target="_blank" class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bxs-file-pdf text-red-500 text-xl mr-3'></i>
                            <span class="font-medium">Artikel.pdf</span>
                        </a>
                        <a href="{{ Storage::url($submission->invoice_path) }}" target="_blank" class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bxs-file-image text-yellow-500 text-xl mr-3'></i>
                            <span class="font-medium">Bukti_Invoice</span>
                        </a>
                         <a href="{{ Storage::url($submission->submission_process_path) }}" target="_blank" class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bxs-file-archive text-blue-500 text-xl mr-3'></i>
                            <span class="font-medium">Proses_Submission</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Aksi Admin --}}
            <div class="bg-gray-50 px-8 py-6 border-t" x-data="{ open: false }">
                <button @click="open = !open" class="text-lg font-bold text-gray-800 flex justify-between items-center w-full">
                    <span>Ubah Status Pengajuan</span>
                    <i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': open}"></i>
                </button>
                <div x-show="open" x-collapse class="mt-4">
                    <form action="{{ route('admin_equity.apc.submission.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Pilih Status Baru</label>
                                <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <option value="diajukan" @if($submission->status == 'diajukan') selected @endif>Diajukan</option>
                                    <option value="verifikasi" @if($submission->status == 'verifikasi') selected @endif>Verifikasi</option>
                                    <option value="disetujui" @if($submission->status == 'disetujui') selected @endif>Disetujui</option>
                                    <option value="ditolak" @if($submission->status == 'ditolak') selected @endif>Ditolak</option>
                                </select>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-5 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow">Simpan Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
