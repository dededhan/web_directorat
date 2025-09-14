{{-- resources/views/subdirektorat-inovasi/dosen/equity/usulkan-proposal.blade.php --}}
@extends('subdirektorat-inovasi.dosen.index') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8">

    <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600">Home</a>
                <i class='bx bx-chevron-right text-lg mx-2'></i>
            </li>
            <li class="font-medium text-gray-700">
                Usulkan Proposal
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Usulkan Proposal Penelitian/Pengabdian</h1>

    <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Tabel Usulan Proposal</h2>
            <p class="text-gray-500 text-sm mt-1">Daftar skema penelitian dan pengabdian yang tersedia.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
            <div class="flex items-center space-x-2 text-sm">
                <span class="text-gray-600">Tampilkan</span>
                <select class="border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span class="text-gray-600">Data</span>
            </div>
            
            <div class="relative w-full md:w-auto">
                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                <input type="text" placeholder="Cari skema proposal..." class="pl-10 pr-4 py-2 w-full md:w-64 border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 hidden md:table-header-group">
                    <tr>
                        <th scope="col" class="px-6 py-3 rounded-l-lg">Uraian Tawaran / Skema</th>
                        <th scope="col" class="px-6 py-3">Dana Maksimal</th>
                        <th scope="col" class="px-6 py-3">Periode Submit</th>
                        <th scope="col" class="px-6 py-3">Anggota</th>
                        <th scope="col" class="px-6 py-3 text-center rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                
                {{-- Data Grouping by Faculty --}}
                <tbody class="space-y-4 md:space-y-0 md:border-t">
                    
                    <tr class="bg-gray-200 md:bg-gray-100">
                        <td colspan="5" class="px-6 py-2 text-sm font-bold text-gray-700 text-center md:text-left">
                            Fakultas Ilmu Sosial dan Hukum
                        </td>
                    </tr>

                    <tr class="bg-white block md:table-row rounded-lg shadow md:shadow-none mb-4 md:mb-0 border md:border-none md:border-b">
                        <td data-label="Skema" class="block md:table-cell px-6 py-4">
                            <div class="font-bold text-gray-900">Penelitian Dasar Fakultas (FISH) 2025</div>
                            <div class="text-xs text-gray-600">(Penelitian Dasar Fakultas/Sekolah Pascasarjana 2025)</div>
                        </td>
                        <td data-label="Dana Maksimal" class="block md:table-cell px-6 py-4">Rp 30.000.000</td>
                        <td data-label="Periode Submit" class="block md:table-cell px-6 py-4">20 Jan 2025 - 14 Feb 2025</td>
                        <td data-label="Anggota" class="block md:table-cell px-6 py-4">2 - 4 Orang</td>
                        <td data-label="Aksi" class="block md:table-cell px-6 py-4 text-center">
                            <button class="bg-gray-400 text-white font-bold py-2 px-4 rounded-lg text-xs cursor-not-allowed" disabled>
                                Sudah Ditutup
                            </button>
                        </td>
                    </tr>

                    <tr class="bg-white block md:table-row rounded-lg shadow md:shadow-none mb-4 md:mb-0 border md:border-none md:border-b">
                        <td data-label="Skema" class="block md:table-cell px-6 py-4">
                            <div class="font-bold text-gray-900">Penelitian Kolaboratif Fakultas (FISH) 2025</div>
                            <div class="text-xs text-gray-600">(Penelitian Kolaboratif Fakultas/Sekolah Pascasarjana 2025)</div>
                        </td>
                        <td data-label="Dana Maksimal" class="block md:table-cell px-6 py-4">Rp 40.000.000</td>
                        <td data-label="Periode Submit" class="block md:table-cell px-6 py-4">15 Sep 2025 - 15 Okt 2025</td>
                        <td data-label="Anggota" class="block md:table-cell px-6 py-4">1 - 4 Orang</td>
                        <td data-label="Aksi" class="block md:table-cell px-6 py-4 text-center">
                             <a href="#" class="inline-block bg-teal-500 text-white font-bold py-2 px-4 rounded-lg text-xs hover:bg-teal-600 transition duration-300">
                                Usulkan
                            </a>
                        </td>
                    </tr>

                    <tr class="bg-gray-200 md:bg-gray-100">
                        <td colspan="5" class="px-6 py-2 text-sm font-bold text-gray-700 text-center md:text-left">
                            Fakultas Matematika dan Ilmu Pengetahuan Alam
                        </td>
                    </tr>

                    <tr class="bg-white block md:table-row rounded-lg shadow md:shadow-none mb-4 md:mb-0 border md:border-none md:border-b">
                        <td data-label="Skema" class="block md:table-cell px-6 py-4">
                            <div class="font-bold text-gray-900">Penelitian Terapan (FMIPA) 2025</div>
                            <div class="text-xs text-gray-600">(Penelitian Terapan Fakultas/Sekolah Pascasarjana 2025)</div>
                        </td>
                        <td data-label="Dana Maksimal" class="block md:table-cell px-6 py-4">Rp 30.000.000</td>
                        <td data-label="Periode Submit" class="block md:table-cell px-6 py-4">20 Jan 2025 - 14 Feb 2025</td>
                        <td data-label="Anggota" class="block md:table-cell px-6 py-4">2 - 4 Orang</td>
                        <td data-label="Aksi" class="block md:table-cell px-6 py-4 text-center">
                            <button class="bg-gray-400 text-white font-bold py-2 px-4 rounded-lg text-xs cursor-not-allowed" disabled>
                                Sudah Ditutup
                            </button>
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
                <button class="px-3 py-1 border border-gray-300 rounded-l-lg hover:bg-gray-100 disabled:opacity-50" disabled>&laquo;</button>
                <button class="px-3 py-1 border border-gray-300 bg-teal-50 text-teal-600">1</button>
                <button class="px-3 py-1 border border-gray-300 hover:bg-gray-100">2</button>
                <button class="px-3 py-1 border border-gray-300 hover:bg-gray-100">3</button>
                <button class="px-3 py-1 border border-gray-300 rounded-r-lg hover:bg-gray-100">&raquo;</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- CSS ini untuk menampilkan label kolom pada tampilan mobile --}}
<style>
    @media (max-width: 767px) {
        /* Sembunyikan header tabel default */
        thead {
            display: none;
        }
        /* Ubah setiap baris menjadi card */
        tbody, tr, td {
            display: block;
            width: 100%;
        }
        tr {
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        td {
            padding-left: 50%; /* Beri ruang untuk label */
            position: relative;
            text-align: right; /* Ratakan konten ke kanan */
            border-bottom: 1px solid #e2e8f0;
        }
        td:last-child {
            border-bottom: none;
        }
        /* Buat label dari atribut data-label */
        td[data-label]::before {
            content: attr(data-label);
            position: absolute;
            left: 1.5rem; /* Sesuai dengan padding px-6 */
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #4a5568; /* gray-700 */
            text-align: left;
            white-space: nowrap;
        }
        /* Penyesuaian khusus untuk kolom pertama (Skema) */
        td[data-label="Skema"] {
            padding-left: 1.5rem; /* Hapus padding kiri agar full-width */
            text-align: left;
        }
        td[data-label="Skema"]::before {
            display: none; /* Sembunyikan label karena sudah jelas */
        }
        /* Penyesuaian untuk tombol aksi agar di tengah */
        td[data-label="Aksi"] {
            text-align: center;
        }
    }
</style>
@endpush