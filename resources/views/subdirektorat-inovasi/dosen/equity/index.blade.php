{{-- index.blade.php --}}
@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8">

    <nav class="text-sm text-gray-500 mb-4">
        <span>Home</span>
        <span class="mx-2">&gt;</span>
        <span class="font-medium text-gray-700">Manajemen Proposal</span>
    </nav>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Proposal Penelitian Pengabdian</h1>

    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Data Proposal</h2>
            <p class="text-gray-500 text-sm mt-1">Tabel Proposal Penelitian Pengabdian yang telah diajukan.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-3 md:space-y-0">
            <div class="flex items-center space-x-2 text-sm">
                <span class="text-gray-600">Tampilkan</span>
                <select class="border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option>10</option> <option>25</option> <option>50</option>
                </select>
                <span class="text-gray-600">Data</span>
            </div>
            
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                <input type="text" placeholder="Search proposal..." class="pl-10 pr-4 py-2 w-full md:w-64 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Judul Proposal / Usulan</th>
                        <th scope="col" class="px-6 py-3 hidden lg:table-cell">Waktu</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Nominal Usulan</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Nominal Disetujui</th>
                        <th scope="col" class="px-6 py-3">Opsi</th>
                        <th scope="col" class="px-6 py-3 text-center hidden lg:table-cell">Submit</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Dummy 1 --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">Pengembangan Sistem Monitoring Kualitas Air</div>
                            <div class="text-xs text-gray-500">(Penelitian Terapan (FMIPA) 2025)</div>
                            <dl class="lg:hidden mt-2">
                                <dt class="font-medium text-gray-600">Waktu</dt>
                                <dd class="text-gray-800">12 bulan</dd>
                                <dt class="font-medium text-gray-600 mt-1 md:hidden">Nominal</dt>
                                <dd class="text-gray-800 md:hidden">Usulan: 45jt / Disetujui: 40jt</dd>
                            </dl>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">12 bulan</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 45.000.000</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 40.000.000</td>
                        <td class="px-6 py-4">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 bg-teal-500 text-white text-xs font-medium rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Opsi <i class='bx bx-chevron-down ml-1'></i>
                                </button>
                                <div x-show="open" @click.away="open = false" 
                                     x-transition
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                                    <div class="py-1">
                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.tahapan-proposal') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Tahapan Proposal
                                        </a>
                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.logbook') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Input Logbook
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center hidden lg:table-cell">
                            <i class='bx bxs-check-circle text-green-500 text-xl' title="Submitted"></i>
                        </td>
                    </tr>
                    {{-- Data Dummy 2 --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">Pemberdayaan Masyarakat Desa Melalui Kewirausahaan Digital</div>
                            <div class="text-xs text-gray-500">(Pengabdian Masyarakat (FEB) 2025)</div>
                            <dl class="lg:hidden mt-2">
                                <dt class="font-medium text-gray-600">Waktu</dt>
                                <dd class="text-gray-800">6 bulan</dd>
                                <dt class="font-medium text-gray-600 mt-1 md:hidden">Nominal</dt>
                                <dd class="text-gray-800 md:hidden">Usulan: 25jt / Disetujui: 25jt</dd>
                            </dl>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">6 bulan</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 25.000.000</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 25.000.000</td>
                        <td class="px-6 py-4">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 bg-teal-500 text-white text-xs font-medium rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Opsi <i class='bx bx-chevron-down ml-1'></i>
                                </button>
                                <div x-show="open" @click.away="open = false" 
                                     x-transition
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tahap Penelitian</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Input Logbook</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center hidden lg:table-cell">
                            <i class='bx bxs-check-circle text-green-500 text-xl' title="Submitted"></i>
                        </td>
                    </tr>
                    {{-- Data Dummy 3 --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">Analisis Big Data untuk Prediksi Tren Pasar Saham</div>
                            <div class="text-xs text-gray-500">(Penelitian Dasar (FASILKOM) 2024)</div>
                            <dl class="lg:hidden mt-2">
                                <dt class="font-medium text-gray-600">Waktu</dt>
                                <dd class="text-gray-800">18 bulan</dd>
                                <dt class="font-medium text-gray-600 mt-1 md:hidden">Nominal</dt>
                                <dd class="text-gray-800 md:hidden">Usulan: 70jt / Disetujui: 60jt</dd>
                            </dl>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">18 bulan</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 70.000.000</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 60.000.000</td>
                        <td class="px-6 py-4">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 bg-teal-500 text-white text-xs font-medium rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Opsi <i class='bx bx-chevron-down ml-1'></i>
                                </button>
                                <div x-show="open" @click.away="open = false" 
                                     x-transition
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tahap Penelitian</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Input Logbook</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center hidden lg:table-cell">
                            <i class='bx bxs-time-five text-yellow-500 text-xl' title="Draft"></i>
                        </td>
                    </tr>
                    {{-- Data Dummy 4 --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">Pengembangan Model Pembelajaran Adaptif Berbasis AI</div>
                            <div class="text-xs text-gray-500">(Penelitian Pengembangan (FKIP) 2024)</div>
                            <dl class="lg:hidden mt-2">
                                <dt class="font-medium text-gray-600">Waktu</dt>
                                <dd class="text-gray-800">24 bulan</dd>
                                <dt class="font-medium text-gray-600 mt-1 md:hidden">Nominal</dt>
                                <dd class="text-gray-800 md:hidden">Usulan: 150jt / Disetujui: 135jt</dd>
                            </dl>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">24 bulan</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 150.000.000</td>
                        <td class="px-6 py-4 hidden md:table-cell">Rp 135.000.000</td>
                        <td class="px-6 py-4">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 bg-teal-500 text-white text-xs font-medium rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Opsi <i class='bx bx-chevron-down ml-1'></i>
                                </button>
                                <div x-show="open" @click.away="open = false" 
                                     x-transition
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tahap Penelitian</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Input Logbook</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center hidden lg:table-cell">
                            <i class='bx bxs-check-circle text-green-500 text-xl' title="Submitted"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
            <div class="text-gray-600 mb-2 md:mb-0">
                Menampilkan 1 sampai 4 dari 25 data
            </div>
            <div class="inline-flex -space-x-px">
                <button class="px-3 py-1 border border-gray-300 rounded-l-md hover:bg-gray-100 disabled:opacity-50" disabled>&laquo;</button>
                <button class="px-3 py-1 border border-gray-300 bg-teal-50 text-teal-600">1</button>
                <button class="px-3 py-1 border border-gray-300 hover:bg-gray-100">2</button>
                <button class="px-3 py-1 border border-gray-300 hover:bg-gray-100">3</button>
                <button class="px-3 py-1 border border-gray-300 rounded-r-md hover:bg-gray-100">&raquo;</button>
            </div>
        </div>
    </div>
</div>
@endsection