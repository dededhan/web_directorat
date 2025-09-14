@extends('subdirektorat-inovasi.dosen.index') 

@section('content')
@php
$tahapan = [
    ['nama' => 'Desk Evaluasi Proposal', 'skema' => 'Penelitian Calon Guru Besar', 'unit' => 'UNIVERSITAS', 'urutan' => 1],
    ['nama' => 'Laporan Kemajuan', 'skema' => 'Penelitian Calon Guru Besar', 'unit' => 'UNIVERSITAS', 'urutan' => 2],
    ['nama' => 'Monitoring dan Evaluasi', 'skema' => 'Penelitian Calon Guru Besar', 'unit' => 'UNIVERSITAS', 'urutan' => 3],
    ['nama' => 'Laporan Akhir Penelitian', 'skema' => 'Penelitian Calon Guru Besar', 'unit' => 'UNIVERSITAS', 'urutan' => 4],
    ['nama' => 'Penilaian Luaran/ Seminar Hasil', 'skema' => 'Penelitian Calon Guru Besar', 'unit' => 'UNIVERSITAS', 'urutan' => 5],
];
@endphp

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2">
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Home</a>
                <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
            </li>
            <li class="flex items-center">
                <span class="text-gray-700 font-medium">Tahap Penilaian</span>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Manajemen Data Tahap Penilaian</h2>
                    <p class="text-sm text-gray-500 mt-1">Tabel Tahap Penilaian</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button class="flex items-center bg-teal-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-opacity-75 transition duration-200">
                        <i class='bx bx-plus mr-2'></i>
                        Tambah Tahap
                    </button>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center py-4 space-y-3 md:space-y-0">
                <div class="flex items-center space-x-2">
                    <label for="show-entries" class="text-sm text-gray-600">Tampilkan</label>
                    <select id="show-entries" name="show-entries" class="border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-600">data</span>
                </div>
                <div class="w-full md:w-auto">
                    <label for="filter-skema" class="sr-only">Filter Skema</label>
                    <select id="filter-skema" name="filter-skema" class="w-full md:w-72 border border-gray-300 rounded-md py-2 px-4 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="all">Semua Skema</option>
                        <option value="penelitian" selected>Penelitian Calon Guru Besar</option>
                        <option value="pengabdian">Pengabdian Masyarakat</option>
                    </select>
                </div>
            </div>

            <div class="hidden lg:block mt-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Nilai Tahap</th>
                                <th scope="col" class="px-6 py-3">Skema</th>
                                <th scope="col" class="px-6 py-3">Unit</th>
                                <th scope="col" class="px-6 py-3 text-center">Urutan</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tahapan as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $item['nama'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item['skema'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item['unit'] }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item['urutan'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="#" class="font-medium text-teal-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-500">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden mt-4">
                @foreach ($tahapan as $item)
                <div class="bg-white p-4 rounded-lg border">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-gray-800 pr-2">{{ $item['nama'] }}</h3>
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded flex-shrink-0">{{ $item['urutan'] }}</span>
                    </div>
                    <div class="mt-3 space-y-2 text-sm text-gray-600">
                        <p><strong class="font-semibold text-gray-700">Skema:</strong> {{ $item['skema'] }}</p>
                        <p><strong class="font-semibold text-gray-700">Unit:</strong> {{ $item['unit'] }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t">
                        <a href="#" class="w-full text-center block font-medium text-teal-600 hover:text-teal-700">Lihat Detail</a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        <div class="p-6 sm:p-8 border-t border-gray-200">
             <div class="flex flex-col sm:flex-row justify-between items-center">
                <p class="text-sm text-gray-600 mb-3 sm:mb-0">
                    Menampilkan <span class="font-semibold">1</span> sampai <span class="font-semibold">{{ count($tahapan) }}</span> dari <span class="font-semibold">{{ count($tahapan) }}</span> data
                </p>
                <nav aria-label="Pagination">
                    <ul class="inline-flex items-center -space-x-px text-sm">
                        <li>
                            <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">
                                <span class="sr-only">Previous</span>
                                <i class='bx bx-chevron-left'></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-teal-600 border border-gray-300 bg-teal-50 hover:bg-teal-100 hover:text-teal-700">1</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">
                                <span class="sr-only">Next</span>
                                <i class='bx bx-chevron-right'></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</div>
@endsection