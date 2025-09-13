@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-4">
    <nav class="text-sm text-gray-500">
        <span>Home</span>
        <span class="mx-2">></span>
        <span class="text-gray-700">Manajemen Proposal</span>
    </nav>
</div>

<!-- Page Title -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-blue-600">Proposal Penelitian Pengabdian</h1>
</div>

<!-- Main Content Card -->
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Card Header -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Manajemen Data Proposal Penelitian Pengabdian</h2>
        <p class="text-gray-600">Tabel Proposal Penelitian Pengabdian</p>
    </div>

    <!-- Table Controls -->
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-2">
            <span class="text-gray-600">Tampilkan</span>
            <select class="bg-blue-600 text-white px-3 py-1 rounded-md border-0 focus:ring-2 focus:ring-blue-500">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-gray-600">Data</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="relative">
                <input type="text" placeholder="Search" 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                <i class='bx bx-search'></i>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Judul Proposal / Usulan</th>
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Waktu</th>
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Nominal Usulan</th>
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Nominal Disetujui</th>
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Opsi</th>
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Submit Proposal</th>
                    <th class="border border-gray-200 px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-200 px-4 py-3">
                        <div>
                            <div class="font-medium text-gray-900">Pengembangan Sistem Monitoring Kualitas Air Berbasis IoT untuk Wilayah Pesisir</div>
                            <div class="text-sm text-gray-500">(Penelitian Terapan (FMIPA) 2025)</div>
                        </div>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">12 bulan</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 45.000.000</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 40.000.000</td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Opsi <i class='bx bx-chevron-down'></i>
                        </button>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-center">
                        <i class='bx bx-check text-green-600 text-xl'></i>
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 focus:ring-2 focus:ring-gray-500">
                            Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 bg-gray-50">
                    <td class="border border-gray-200 px-4 py-3">
                        <div>
                            <div class="font-medium text-gray-900">Pemberdayaan Masyarakat Desa Melalui Program Literasi Digital</div>
                            <div class="text-sm text-gray-500">(Pengabdian Masyarakat (FIP) 2025)</div>
                        </div>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">10 bulan</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 30.000.000</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 25.000.000</td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Opsi <i class='bx bx-chevron-down'></i>
                        </button>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-center">
                        <i class='bx bx-check text-green-600 text-xl'></i>
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 focus:ring-2 focus:ring-gray-500">
                            Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-200 px-4 py-3">
                        <div>
                            <div class="font-medium text-gray-900">Analisis Dampak Pembelajaran Daring Terhadap Prestasi Akademik Mahasiswa</div>
                            <div class="text-sm text-gray-500">(Penelitian Dasar (FE) 2025)</div>
                        </div>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">8 bulan</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 20.000.000</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 18.000.000</td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Opsi <i class='bx bx-chevron-down'></i>
                        </button>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-center">
                        <i class='bx bx-check text-green-600 text-xl'></i>
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 focus:ring-2 focus:ring-gray-500">
                            Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 bg-gray-50">
                    <td class="border border-gray-200 px-4 py-3">
                        <div>
                            <div class="font-medium text-gray-900">Implementasi Teknologi Blockchain untuk Transparansi Keuangan Desa</div>
                            <div class="text-sm text-gray-500">(Penelitian Terapan (FT) 2025)</div>
                        </div>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">15 bulan</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 60.000.000</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 55.000.000</td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Opsi <i class='bx bx-chevron-down'></i>
                        </button>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-center">
                        <i class='bx bx-check text-green-600 text-xl'></i>
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 focus:ring-2 focus:ring-gray-500">
                            Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-200 px-4 py-3">
                        <div>
                            <div class="font-medium text-gray-900">Pengembangan Model Pembelajaran Berbasis Proyek untuk Meningkatkan Kreativitas Siswa</div>
                            <div class="text-sm text-gray-500">(Penelitian Dasar (FIP) 2025)</div>
                        </div>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">12 bulan</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 35.000.000</td>
                    <td class="border border-gray-200 px-4 py-3 text-gray-700">Rp 32.000.000</td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Opsi <i class='bx bx-chevron-down'></i>
                        </button>
                    </td>
                    <td class="border border-gray-200 px-4 py-3 text-center">
                        <i class='bx bx-check text-green-600 text-xl'></i>
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 focus:ring-2 focus:ring-gray-500">
                            Detail
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Menampilkan 1 sampai 5 dari 25 data
        </div>
        <div class="flex space-x-2">
            <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50" disabled>
                <i class='bx bx-chevron-left'></i>
            </button>
            <button class="px-3 py-1 bg-blue-600 text-white rounded-md">1</button>
            <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">3</button>
            <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">
                <i class='bx bx-chevron-right'></i>
            </button>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="mt-8 text-center text-sm text-gray-500">
    © 2025 SIPP
</div>
@endsection
