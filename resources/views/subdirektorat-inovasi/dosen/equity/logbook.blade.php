@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ showForm: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb dan Judul --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li class="flex items-center"><a href="#" class="hover:text-teal-600 transition-colors duration-200">Home</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium text-gray-800" x-text="showForm ? 'Tambah Logbook Kegiatan' : 'Logbook Kegiatan'"></span></li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Logbook Kegiatan</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola catatan kegiatan untuk proyek Anda.</p>
                </div>
                <div class="flex-shrink-0">
                    <button @click="showForm = !showForm" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx' :class="showForm ? 'bx-arrow-back' : 'bx-plus-circle'" class="mr-2 text-lg"></i>
                        <span x-text="showForm ? 'Kembali' : 'Tambah Logbook Kegiatan'"></span>
                    </button>
                </div>
            </div>
        </header>

        {{-- Tampilan Tabel Logbook (Desktop) --}}
        <div x-show="!showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-visible">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-list-ul mr-3 text-2xl'></i>
                            Manajemen Data Logbook Kegiatan
                        </h2>
                        <div class="text-teal-100 text-sm">
                            Total: <span class="font-semibold text-white">3 kegiatan</span>
                        </div>
                    </div>
                    <p class="text-teal-100 mt-1">Pengembangan Sistem Monitoring Kualitas Air</p>
                </div>

                {{-- Desktop Table View --}}
                <div class="hidden lg:block overflow-visible">
                    <div class="w-full overflow-visible">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[5%]">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-hash text-base text-blue-500'></i>
                                            <span>No.</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[15%]">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-calendar text-base text-orange-500'></i>
                                            <span>Tgl Kegiatan</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[35%]">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-note text-base text-indigo-500'></i>
                                            <span>Catatan</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[15%]">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-line-chart text-base text-teal-500'></i>
                                            <span>Persen Capaian</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-[10%]">
                                        <div class="flex items-center justify-center space-x-1">
                                            <i class='bx bx-cog text-base text-teal-600'></i>
                                            <span>Opsi</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-[20%]">
                                        <div class="flex items-center justify-center space-x-1">
                                            <i class='bx bx-cog text-base text-teal-600'></i>
                                            <span>Aksi</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors duration-150" x-data="{ open: false }">
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">1</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-time text-orange-500 mr-2'></i>
                                            14 Mei 2025
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-sm text-gray-900 break-words align-middle">Mulai pengembangan web based DFA Simulator dan text based NFA Simulator</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-line-chart text-teal-500 mr-2'></i>
                                            35%
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center align-middle">
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <i class='bx bx-dots-horizontal-rounded text-lg'></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border-2 border-gray-100" style="display: none;">
                                                <div class="py-1">
                                                    <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                                        <i class='bx bx-wallet mr-3 text-lg text-teal-600'></i>Input Pengeluaran
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center space-x-2 align-middle">
                                        <button class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 transition-colors">Detail</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600 transition-colors">Edit</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 transition-colors">Hapus</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-150" x-data="{ open: false }">
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">2</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-time text-orange-500 mr-2'></i>
                                            10 Mei 2025
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-sm text-gray-900 break-words align-middle">Selesai pengembangan Textbased DFA Simulator</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-line-chart text-teal-500 mr-2'></i>
                                            30%
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center align-middle">
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <i class='bx bx-dots-horizontal-rounded text-lg'></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border-2 border-gray-100" style="display: none;">
                                                <div class="py-1">
                                                    <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                                        <i class='bx bx-wallet mr-3 text-lg text-teal-600'></i>Input Pengeluaran
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center space-x-2 align-middle">
                                        <button class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 transition-colors">Detail</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600 transition-colors">Edit</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 transition-colors">Hapus</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-150" x-data="{ open: false }">
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">3</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-time text-orange-500 mr-2'></i>
                                            30 April 2025
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-sm text-gray-900 break-words align-middle">Mulai pengembangan modul textbased DFA Simulator</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-line-chart text-teal-500 mr-2'></i>
                                            10%
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center align-middle">
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <i class='bx bx-dots-horizontal-rounded text-lg'></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border-2 border-gray-100" style="display: none;">
                                                <div class="py-1">
                                                    <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                                        <i class='bx bx-wallet mr-3 text-lg text-teal-600'></i>Input Pengeluaran
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center space-x-2 align-middle">
                                        <button class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 transition-colors">Detail</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600 transition-colors">Edit</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 transition-colors">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile Card View --}}
                <div class="lg:hidden">
                    <div class="divide-y divide-gray-200">
                        {{-- Card 1 --}}
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-list-ul text-blue-500 text-lg'></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1 break-words">Mulai pengembangan web based DFA Simulator dan text based NFA Simulator</h3>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class='bx bx-calendar text-xs mr-1 text-orange-500'></i>
                                            14 Mei 2025
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Persen Capaian</span>
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <i class='bx bx-line-chart text-teal-500 text-xs mr-1'></i>
                                        35%
                                    </p>
                                </div>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="w-full flex items-center justify-center px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                    <i class='bx bx-cog mr-2'></i>
                                    <span>Opsi</span>
                                    <i class='bx bx-chevron-down ml-2 transform transition-transform' :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-2 w-full rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden border-2 border-gray-100" style="display: none;">
                                    <div class="py-1">
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                            <i class='bx bx-wallet mr-3 text-lg text-teal-600'></i>Input Pengeluaran
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-show mr-3 text-lg text-blue-500'></i>Lihat Detail
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-edit-alt mr-3 text-lg text-green-500'></i>Edit
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class='bx bx-trash mr-3 text-lg'></i>Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Card 2 --}}
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-list-ul text-blue-500 text-lg'></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1 break-words">Selesai pengembangan Textbased DFA Simulator</h3>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class='bx bx-calendar text-xs mr-1 text-orange-500'></i>
                                            10 Mei 2025
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Persen Capaian</span>
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <i class='bx bx-line-chart text-teal-500 text-xs mr-1'></i>
                                        30%
                                    </p>
                                </div>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="w-full flex items-center justify-center px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                    <i class='bx bx-cog mr-2'></i>
                                    <span>Opsi</span>
                                    <i class='bx bx-chevron-down ml-2 transform transition-transform' :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-2 w-full rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden border-2 border-gray-100" style="display: none;">
                                    <div class="py-1">
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                            <i class='bx bx-wallet mr-3 text-lg text-teal-600'></i>Input Pengeluaran
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-show mr-3 text-lg text-blue-500'></i>Lihat Detail
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-edit-alt mr-3 text-lg text-green-500'></i>Edit
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class='bx bx-trash mr-3 text-lg'></i>Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Card 3 --}}
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-list-ul text-blue-500 text-lg'></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1 break-words">Mulai pengembangan modul textbased DFA Simulator</h3>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class='bx bx-calendar text-xs mr-1 text-orange-500'></i>
                                            30 April 2025
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Persen Capaian</span>
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <i class='bx bx-line-chart text-teal-500 text-xs mr-1'></i>
                                        10%
                                    </p>
                                </div>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="w-full flex items-center justify-center px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                    <i class='bx bx-cog mr-2'></i>
                                    <span>Opsi</span>
                                    <i class='bx bx-chevron-down ml-2 transform transition-transform' :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-2 w-full rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden border-2 border-gray-100" style="display: none;">
                                    <div class="py-1">
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                            <i class='bx bx-wallet mr-3 text-lg text-teal-600'></i>Input Pengeluaran
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-show mr-3 text-lg text-blue-500'></i>Lihat Detail
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-edit-alt mr-3 text-lg text-green-500'></i>Edit
                                        </a>
                                        <a href="#" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class='bx bx-trash mr-3 text-lg'></i>Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Tambah Logbook --}}
        <div x-show="showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" style="display: none;">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                        <i class='bx bx-edit-alt mr-3 text-2xl'></i>
                        Form Logbook Kegiatan
                    </h2>
                    <p class="text-teal-100 mt-1">Isi semua form di bawah dengan benar</p>
                </div>
                <div class="p-6 lg:p-8">
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Judul</label>
                            <p class="w-full bg-gray-100 rounded-lg p-3 text-sm text-gray-800 font-semibold">Pengembangan Finite Automata Simulator Berbasis Web</p>
                        </div>

                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Kegiatan</label>
                            <div class="relative">
                                <i class='bx bxs-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                                <input type="date" id="tanggal" class="w-full md:w-1/2 bg-white border border-gray-200 rounded-lg shadow-sm py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-600 mb-1">Catatan</label>
                            <textarea id="catatan" rows="4" class="w-full bg-white border border-gray-200 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">File Lampiran <span class="text-gray-400">(Opsional)</span></label>
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                            <span>Upload file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOCX, XLSX, PNG, JPG hingga 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="persentase" class="block text-sm font-medium text-gray-600 mb-1">Persentase Capaian Fisik</label>
                            <div class="relative w-full md:w-1/2">
                                <input type="number" id="persentase" placeholder="0" class="w-full bg-white border border-gray-200 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">%</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                            <button @click="showForm = false" type="button" class="px-5 py-2 bg-white border border-gray-200 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-100 hover:border-gray-300 transition-all shadow-sm hover:shadow-md">Cancel</button>
                            <button type="button" class="px-5 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-sm font-semibold rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        input:focus,
        select:focus,
        textarea:focus,
        button:focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }

        button:hover {
            transform: translateY(-1px);
        }
        
        /* Removed redundant box-shadow hover for .bg-white to avoid conflict with row hover */

        .break-words {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        /* Use auto layout for better content adaptability */
        table {
            table-layout: auto;
            width: 100%;
        }

        [x-show][style*="display: none"] {
            display: none !important;
        }
        
        [x-show="open"] {
            z-index: 9999 !important;
        }

        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush
@endsection