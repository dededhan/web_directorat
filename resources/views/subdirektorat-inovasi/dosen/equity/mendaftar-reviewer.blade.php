@extends('subdirektorat-inovasi.dosen.index') 

@section('content')
<div class="bg-slate-50 min-h-screen p-4 sm:p-6 lg:p-8">

    <header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Rekrutmen Reviewer</h1>
        <nav class="text-sm text-slate-500 mt-1" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="#" class="hover:text-teal-600">Home</a>
                    <i class='bx bx-chevron-right text-lg mx-2'></i>
                </li>
                <li class="font-medium text-slate-700">
                    Mendaftar Reviewer
                </li>
            </ol>
        </nav>
    </header>

    <div class="bg-white rounded-xl shadow-md">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Manajemen Data Rekrutmen Reviewer</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar rekrutmen reviewer yang tersedia.</p>
        </div>

        <div class="p-6 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <label for="fakultas-filter" class="sr-only">Filter Fakultas</label>
                <select id="fakultas-filter" class="w-full pl-3 pr-10 py-2 border-slate-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option>Semua Fakultas dan Unit</option>
                    <option>Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                    <option>Fakultas Ilmu Pendidikan</option>
                    <option>LPPM UNJ</option>
                </select>
            </div>
            <div class="relative flex-grow">
                <label for="search-filter" class="sr-only">Cari</label>
                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400'></i>
                <input type="text" id="search-filter" placeholder="Cari rekrutmen..." class="w-full pl-10 pr-4 py-2 border-slate-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-100 hidden md:table-header-group">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Uraian Seleksi</th>
                        <th scope="col" class="px-6 py-3 font-medium">Status</th>
                        <th scope="col" class="px-6 py-3 font-medium">Waktu Buka</th>
                        <th scope="col" class="px-6 py-3 font-medium">Waktu Tutup</th>
                        <th scope="col" class="px-6 py-3 font-medium">Unit</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="space-y-4 md:space-y-0 md:border-t">

                    {{-- Data Dummy Row 1 (Dibuka) --}}
                    <tr class="block md:table-row rounded-lg shadow-md md:shadow-none mb-4 md:mb-0 border md:border-none md:border-b bg-white">
                        <td data-label="Uraian Seleksi" class="block md:table-cell px-6 py-4 font-semibold text-slate-800">
                            Reviewer Penelitian Dana Internal UNJ 2026
                        </td>
                        <td data-label="Status" class="block md:table-cell px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Dibuka
                            </span>
                        </td>
                        <td data-label="Waktu Buka" class="block md:table-cell px-6 py-4">15 Sep 2025</td>
                        <td data-label="Waktu Tutup" class="block md:table-cell px-6 py-4">15 Okt 2025</td>
                        <td data-label="Unit" class="block md:table-cell px-6 py-4">LPPM UNJ</td>
                        <td data-label="Opsi" class="block md:table-cell px-6 py-4 text-center">
                            <a href="#" class="inline-block bg-teal-500 text-white font-bold py-2 px-4 rounded-lg text-xs hover:bg-teal-600 transition duration-300">
                                Daftar
                            </a>
                        </td>
                    </tr>
                    
                    {{-- Data Dummy Row 2 (Tutup) --}}
                    <tr class="block md:table-row rounded-lg shadow-md md:shadow-none mb-4 md:mb-0 border md:border-none md:border-b bg-white">
                        <td data-label="Uraian Seleksi" class="block md:table-cell px-6 py-4 font-semibold text-slate-800">
                            Reviewer Jurnal Inovasi Pendidikan Vol. 5
                        </td>
                         <td data-label="Status" class="block md:table-cell px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Tutup
                            </span>
                        </td>
                        <td data-label="Waktu Buka" class="block md:table-cell px-6 py-4">01 Jun 2025</td>
                        <td data-label="Waktu Tutup" class="block md:table-cell px-6 py-4">01 Jul 2025</td>
                        <td data-label="Unit" class="block md:table-cell px-6 py-4">Fakultas Ilmu Pendidikan</td>
                        <td data-label="Opsi" class="block md:table-cell px-6 py-4 text-center">
                            <button class="bg-slate-300 text-slate-500 font-bold py-2 px-4 rounded-lg text-xs cursor-not-allowed" disabled>
                                Tutup
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            <div class="flex justify-between items-center text-sm">
               <div class="text-slate-600">
                   Menampilkan <span class="font-semibold">1</span> sampai <span class="font-semibold">2</span> dari <span class="font-semibold">2</span> data
               </div>
               <div class="inline-flex -space-x-px">
                   <button class="px-3 py-1 border border-slate-300 rounded-l-lg hover:bg-slate-100 disabled:opacity-50" disabled>&laquo;</button>
                   <button class="px-3 py-1 border border-slate-300 bg-teal-50 text-teal-600">1</button>
                   <button class="px-3 py-1 border border-slate-300 rounded-r-lg hover:bg-slate-100">&raquo;</button>
               </div>
           </div>
       </div>
    </div>
</div>
@endsection

@push('styles')
{{-- CSS untuk membuat tabel responsif menjadi card --}}
<style>
    @media (max-width: 767px) {
        tbody, tr, td {
            display: block;
            width: 100%;
        }
        tr {
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        td {
            padding-left: 50%;
            position: relative;
            text-align: right; 
            border-bottom: 1px solid #f1f5f9;
        }
        td:last-child {
            border-bottom: none;
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: #f8fafc;
        }
        td[data-label]::before {
            content: attr(data-label);
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #475569; 
            text-align: left;
            white-space: nowrap;
        }
        td[data-label="Uraian Seleksi"] {
            text-align: left;
        }
    }
</style>
@endpush