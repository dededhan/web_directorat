@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb dan Tombol Kembali --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Proposal Penelitian</h1>
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Home</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Manajemen Proposal</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium text-gray-700">Detail Data Proposal</span></li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('subdirektorat-inovasi.dosen.equity.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
            <i class='bx bx-arrow-back mr-2'></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Kartu Detail Proposal --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <div class="p-6 md:p-8">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h2 class="text-xl font-bold text-gray-800">Detail Proposal Penelitian Pengabdian</h2>
                <p class="text-gray-500 mt-1">Detail data</p>
            </div>
            
            <div class="space-y-6">
                <!-- Bagian Info Umum -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-4 rounded-lg border">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tahun Pertama Usulan</p>
                        <p class="text-base font-semibold text-gray-800 mt-1">2025</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tahun Usulan Kegiatan</p>
                        <p class="text-base font-semibold text-gray-800 mt-1">2025</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tahun Pelaksanaan</p>
                        <p class="text-base font-semibold text-gray-800 mt-1">2025</p>
                    </div>
                </div>

                <!-- Bagian Detail Utama -->
                <div class="divide-y divide-gray-200">
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Tawaran</p><p class="text-sm text-gray-800 md:col-span-3 font-semibold">Penelitian Terapan (RMIPA) 2025</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Judul Proposal</p><p class="text-sm text-gray-800 md:col-span-3 font-semibold">Pengembangan Sistem Monitoring Kualitas Air</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Ringkasan / Abstrak</p><p class="text-sm text-gray-800 md:col-span-3 leading-relaxed">Penelitian ini bertujuan untuk mengembangkan sebuah aplikasi simulasi finite automata yang nantinya diharapkan dapat digunakan sebagai alat bantu dalam kegiatan belajar mengajar di bidang ilmu komputer...</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Kata Kunci</p><p class="text-sm text-gray-800 md:col-span-3"><span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-md text-xs">finite automata</span> <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-md text-xs">simulasi</span> <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-md text-xs">aplikasi web</span></p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Lokasi</p><p class="text-sm text-gray-800 md:col-span-3">Jakarta</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Bidang Fokus Riset Unggulan</p><p class="text-sm text-gray-800 md:col-span-3">Sains dan Teknologi</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Bidang Fokus (RIRN)</p><p class="text-sm text-gray-800 md:col-span-3">Rekayasa Keteknikan</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Tingkat Kesiapan Teknologi (TKT)</p><p class="text-sm text-gray-800 md:col-span-3">(6) Demonstrasi model atau prototipe sistem/subsistem dalam suatu lingkungan yang relevan (Terapan)</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Tujuan SGDs</p><p class="text-sm text-gray-800 md:col-span-3">(4) Pendidikan Berkualitas (Quality education)</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Jangka Waktu</p><p class="text-sm text-gray-800 md:col-span-3">10 bulan</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Nominal Usulan</p><p class="text-sm text-gray-800 md:col-span-3 font-bold">Rp 30.000.000</p></div>
                    <div class="py-4 grid grid-cols-1 md:grid-cols-4 gap-4"><p class="text-sm font-medium text-gray-600 md:col-span-1">Nominal Disetujui</p><p class="text-sm text-green-600 md:col-span-3 font-bold">Rp 15.250.000</p></div>
                </div>

                <!-- Bagian Luaran -->
                <div class="pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Dokumen Luaran</h3>
                    <div class="divide-y divide-gray-200 border rounded-lg">
                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center"><p class="text-sm font-medium text-gray-600">Jenis Dokumen Luaran Wajib 1</p><p class="text-sm text-gray-800 font-semibold">Hak Cipta / Paten / Paten Sederhana/ Desain Industri</p><p class="text-sm text-gray-800"><span class="bg-blue-100 text-blue-800 font-medium px-3 py-1 rounded-full text-xs">Hak Cipta (Bersertifikat)</span></p></div>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center bg-gray-50"><p class="text-sm font-medium text-gray-600">Jenis Dokumen Luaran Wajib 2</p><p class="text-sm text-gray-800 font-semibold">Prosiding Internasional Bereputasi</p><p class="text-sm text-gray-800"><span class="bg-green-100 text-green-800 font-medium px-3 py-1 rounded-full text-xs">Accepted</span></p></div>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center"><p class="text-sm font-medium text-gray-600">Jenis Dokumen Luaran Tambahan 1</p><p class="text-sm text-gray-800 font-semibold">Video Profil Hasil Penelitian</p><p class="text-sm text-gray-800"><span class="bg-green-100 text-green-800 font-medium px-3 py-1 rounded-full text-xs">Ada/Tersedia</span></p></div>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center bg-gray-50"><p class="text-sm font-medium text-gray-600">Jenis Dokumen Luaran Tambahan 2</p><p class="text-sm text-gray-800 font-semibold">Poster</p><p class="text-sm text-gray-800"><span class="bg-green-100 text-green-800 font-medium px-3 py-1 rounded-full text-xs">Ada/Tersedia</span></p></div>
                    </div>
                </div>

                <!-- Tombol Unduh Proposal -->
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <p class="text-sm font-medium text-gray-600 mb-2">Proposal</p>
                    <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class='bx bxs-download mr-2'></i>
                        <span>Unduh</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
