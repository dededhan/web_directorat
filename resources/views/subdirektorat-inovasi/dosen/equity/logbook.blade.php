@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showForm: false }">

    {{-- Breadcrumb dan Judul --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Logbook Kegiatan</h1>
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Home</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-gray-700">Manajemen Proposal</a><i class='bx bx-chevron-right text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium" x-text="showForm ? 'Tambah Logbook Proposal' : 'Logbook Kegiatan'"></span></li>
                </ol>
            </nav>
        </div>
        <button @click="showForm = !showForm" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
            <i class='bx' :class="showForm ? 'bx-arrow-back' : 'bx-plus'"></i>
            <span class="ml-2" x-text="showForm ? 'Kembali' : 'Tambah Logbook Kegiatan'"></span>
        </button>
    </div>

    <!-- Tampilan Tabel Logbook -->
    <div x-show="!showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Data Logbook Kegiatan</h2>
                <p class="text-gray-600 mt-1">Pengembangan Sistem Monitoring Kualitas Air</p>
                
                <div class="flex flex-col md:flex-row justify-between items-center mt-4">
                    <div class="flex items-center space-x-2 text-sm">
                        <span>Tampilkan</span>
                        <select class="border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>10</option><option>25</option><option>50</option>
                        </select>
                        <span>Data</span>
                    </div>
                    <div class="relative mt-4 md:mt-0">
                        <input type="text" placeholder="Search..." class="w-full md:w-64 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">No.</th>
                            <th class="px-6 py-3">Tgl Kegiatan</th>
                            <th class="px-6 py-3">Catatan</th>
                            <th class="px-6 py-3">Persen Capaian Fisik</th>
                            <th class="px-6 py-3">Opsi</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Data Row 1 -->
                        <tr class="bg-white border-b hover:bg-gray-50" x-data="{ open: false }">
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4 font-medium text-gray-900">14 Mei 2025</td>
                            <td class="px-6 py-4">Mulai pengembangan web based DFA Simulator dan text based NFA Simulator</td>
                            <td class="px-6 py-4">35%</td>
                            <td class="px-6 py-4 relative">
                                <button @click="open = !open" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs inline-flex items-center">Opsi <i class='bx bx-chevron-down ml-1'></i></button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10" style="display: none;">
                                    <div class="py-1"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Input Pengeluaran</a></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 space-x-2"><button class="font-medium text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md text-xs">Detail</button><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td>
                        </tr>
                        <!-- Contoh Data lainnya -->
                        <tr class="bg-white border-b hover:bg-gray-50"><td class="px-6 py-4">2</td><td class="px-6 py-4 font-medium text-gray-900">10 Mei 2025</td><td class="px-6 py-4">Selesai pengembangan Textbased DFA Simulator</td><td class="px-6 py-4">30%</td> <td class="px-6 py-4 relative">
                                <button @click="open = !open" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs inline-flex items-center">Opsi <i class='bx bx-chevron-down ml-1'></i></button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10" style="display: none;">
                                    <div class="py-1"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Input Pengeluaran</a></div>
                                </div>
                            </td><td class="px-6 py-4 space-x-2"><button class="font-medium text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md text-xs">Detail</button><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr>
                        <tr class="bg-white border-b hover:bg-gray-50"><td class="px-6 py-4">3</td><td class="px-6 py-4 font-medium text-gray-900">30 April 2025</td><td class="px-6 py-4">Mulai pengembangan modul textbased DFA Simulatoy</td><td class="px-6 py-4">10%</td> <td class="px-6 py-4 relative">
                                <button @click="open = !open" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs inline-flex items-center">Opsi <i class='bx bx-chevron-down ml-1'></i></button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10" style="display: none;">
                                    <div class="py-1"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Input Pengeluaran</a></div>
                                </div>
                            </td><td class="px-6 py-4 space-x-2"><button class="font-medium text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md text-xs">Detail</button><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
   
       

</div>
@endsection
