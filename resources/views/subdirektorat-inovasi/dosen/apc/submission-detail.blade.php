@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <header class="mb-8">
             <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.index') }}" class="hover:text-teal-600">Manajemen Sesi APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.show', $submission->session_id) }}" class="hover:text-teal-600">Detail Sesi</a></li>
                     <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Pengajuan</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pengajuan Jurnal</h1>
            <p class="mt-2 text-gray-600">Verifikasi kelengkapan data dan dokumen pengajuan.</p>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8 space-y-6">
                {{-- Detail Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Judul Artikel</h3>
                        <p class="mt-1 text-gray-800 font-semibold">{{ $submission->judul_artikel }}</p>
                    </div>
                     <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Nama Jurnal (Q1)</h3>
                        <p class="mt-1 text-gray-800">{{ $submission->nama_jurnal }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Link ScimagoJR</h3>
                        <a href="{{$submission->link_scimagojr}}" target="_blank" class="mt-1 text-teal-600 hover:underline break-all">{{ $submission->link_scimagojr }}</a>
                    </div>
                     <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Penulis</h3>
                        <p class="mt-1 text-gray-800">{{ $submission->nama_penulis }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Volume & Issue</h3>
                        <p class="mt-1 text-gray-800">Volume {{ $submission->volume }}, Issue {{ $submission->issue }}</p>
                    </div>
                     <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500">Biaya Publikasi Diajukan</h3>
                        <p class="mt-1 text-lg font-bold text-red-600">Rp {{ number_format($submission->biaya_publikasi, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Dokumen --}}
                <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500 mb-2">Dokumen Pendukung</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="#" class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bxs-file-pdf text-red-500 text-xl mr-3'></i>
                            <span class="font-medium">Artikel.pdf</span>
                        </a>
                        <a href="#" class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bxs-file-jpg text-yellow-500 text-xl mr-3'></i>
                            <span class="font-medium">Bukti_Invoice.jpg</span>
                        </a>
                         <a href="#" class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bxs-file-pdf text-red-500 text-xl mr-3'></i>
                            <span class="font-medium">Submission_Proses.pdf</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Aksi Admin --}}
            <div class="bg-gray-50 px-8 py-4 flex flex-col sm:flex-row justify-end items-center gap-4 border-t">
                 <form action="#" method="POST">
                     @csrf
                     <input type="hidden" name="status" value="verifikasi">
                     <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition-colors">Ubah Status ke Verifikasi</button>
                 </form>
                 <form action="#" method="POST">
                     @csrf
                     <input type="hidden" name="status" value="disetujui">
                     <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors">Setujui Pengajuan</button>
                 </form>
            </div>
        </div>
    </div>
</div>
@endsection
