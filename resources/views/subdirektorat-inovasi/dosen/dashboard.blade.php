@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    {{-- Pastikan nama section 'contentdosen' sesuai dengan @yield di layout Anda --}}

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name ?? 'Dosen' }}!</p>
        </div>
        <div>
            <a href="#" class="inline-flex items-center px-4 py-2 bg-[#5D78D0] text-white rounded-lg shadow hover:bg-opacity-90 transition-colors duration-200">
                <i class="fa-solid fa-download mr-2"></i>
                <span>Download Laporan</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-[#5D78D0] p-5 rounded-lg shadow-md text-white relative overflow-hidden">
            <i class="fa-solid fa-chevron-right absolute -right-4 -top-2 text-8xl opacity-10"></i>
            <i class="fa-solid fa-chevron-right absolute -right-2 top-10 text-6xl opacity-10"></i>
            <p class="font-semibold text-sm">TAWARAN PENELITIAN</p>
            <h2 class="text-4xl font-bold mt-2">14</h2>
            <a href="#" class="text-xs mt-4 inline-block bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">Sesuai Unit Kerja</a>
        </div>
        <div class="bg-[#5D78D0] p-5 rounded-lg shadow-md text-white relative overflow-hidden">
            <i class="fa-solid fa-chevron-right absolute -right-4 -top-2 text-8xl opacity-10"></i>
            <i class="fa-solid fa-chevron-right absolute -right-2 top-10 text-6xl opacity-10"></i>
            <p class="font-semibold text-sm">TAWARAN PENGABDIAN</p>
            <h2 class="text-4xl font-bold mt-2">10</h2>
            <a href="#" class="text-xs mt-4 inline-block bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">Sesuai Unit Kerja</a>
        </div>
        <div class="bg-[#5D78D0] p-5 rounded-lg shadow-md text-white relative overflow-hidden">
            <i class="fa-solid fa-chevron-right absolute -right-4 -top-2 text-8xl opacity-10"></i>
            <i class="fa-solid fa-chevron-right absolute -right-2 top-10 text-6xl opacity-10"></i>
            <p class="font-semibold text-sm">PROPOSAL SAYA</p>
            <h2 class="text-4xl font-bold mt-2">5</h2>
            <a href="#" class="text-xs mt-4 inline-block bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">Lebih Lanjut</a>
        </div>
        <div class="bg-[#5D78D0] p-5 rounded-lg shadow-md text-white relative overflow-hidden">
            <i class="fa-solid fa-chevron-right absolute -right-4 -top-2 text-8xl opacity-10"></i>
            <i class="fa-solid fa-chevron-right absolute -right-2 top-10 text-6xl opacity-10"></i>
            <p class="font-semibold text-sm">PENILAIAN PENELITIAN</p>
            <h2 class="text-4xl font-bold mt-2">2</h2>
            <a href="#" class="text-xs mt-4 inline-block bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">Lihat</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-gray-800 text-lg border-b pb-3">Pengumuman Terbaru</h3>
            <div class="mt-4 space-y-4">
                <div class="border-t pt-4">
                    <a href="#" class="font-semibold text-blue-600 hover:underline">Perpanjangan Waktu Unggah Laporan Kemajuan Penelitian dan Pengabdian Kepada Masyarakat LPPM</a>
                    <p class="text-sm text-gray-500 mt-1">Perpanjangan Waktu Unggah Laporan Kemajuan Penelit...</p>
                </div>
                <div class="border-t pt-4">
                    <a href="#" class="font-semibold text-blue-600 hover:underline">Batas Waktu Pengunggahan Laporan Kemajuan Penelitian dan Pengabdian kepada Masyarakat BLU LPPM Tahun 2025</a>
                    <p class="text-sm text-gray-500 mt-1">Tautan Surat Pengumuman Batas Waktu Pengungga...</p>
                </div>
                <div class="border-t pt-4">
                     <a href="#" class="font-semibold text-blue-600 hover:underline">Pengumuman Penerima Hibah Pengabdian Kepada Masyarakat Sumber Dana BLU LPPM UNJ Tahun 2024</a>
                    <p class="text-sm text-gray-500 mt-1">Download : Dokumen Surat (PDF) Nomor : B/251/UN3...</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-gray-800 text-lg border-b pb-3">Notifikasi</h3>
            <div class="mt-4 flex items-center justify-center h-full text-center text-gray-500">
                <div class="text-center">
                    <i class="fa-regular fa-bell-slash text-4xl text-gray-300"></i>
                    <p class="mt-2">Tidak ada notifikasi.</p>
                </div>
            </div>
        </div>
    </div>
@endsection