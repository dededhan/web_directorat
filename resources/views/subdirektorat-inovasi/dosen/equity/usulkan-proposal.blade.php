@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8">

    <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600">Home</a>
                <i class='bx bx-chevron-right text-lg mx-2'></i>
            </li>
            <li class="font-medium text-gray-700">Usulkan Proposal</li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Usulkan Proposal Penelitian/Pengabdian</h1>

    <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Tabel Usulan Proposal</h2>
            <p class="text-gray-500 text-sm mt-1">Daftar skema penelitian dan pengabdian yang tersedia.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
            {{-- Fitur Search & Filter bisa diimplementasikan nanti --}}
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
                
                <tbody class="space-y-4 md:space-y-0 md:border-t">
                    
                    @forelse ($sesiTersedia as $sesi)
                        <tr class="bg-white block md:table-row rounded-lg shadow md:shadow-none mb-4 md:mb-0 border md:border-none md:border-b">
                            <td data-label="Skema" class="block md:table-cell px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $sesi->nama_sesi }}</div>
                                <div class="text-xs text-gray-600">({{ $sesi->deskripsi }})</div>
                            </td>
                            <td data-label="Dana Maksimal" class="block md:table-cell px-6 py-4">Rp {{ number_format($sesi->dana_maksimal, 0, ',', '.') }}</td>
                            <td data-label="Periode Submit" class="block md:table-cell px-6 py-4">{{ \Carbon\Carbon::parse($sesi->periode_awal)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($sesi->periode_akhir)->isoFormat('D MMM Y') }}</td>
                            <td data-label="Anggota" class="block md:table-cell px-6 py-4">{{ $sesi->min_anggota }} - {{ $sesi->max_anggota }} Orang</td>
                            <td data-label="Aksi" class="block md:table-cell px-6 py-4 text-center">
                                
                                {{-- LOGIKA UTAMA: Cek tanggal periode akhir --}}
                                @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($sesi->periode_akhir)->endOfDay()))
                                    {{-- JIKA SUDAH LEWAT TANGGAL --}}
                                    <button class="bg-gray-400 text-white font-bold py-2 px-4 rounded-lg text-xs cursor-not-allowed" disabled>
                                        Sudah Ditutup
                                    </button>
                                @else
                                    {{-- JIKA MASIH BUKA --}}
                                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.form', $sesi->id) }}" class="inline-block bg-teal-500 text-white font-bold py-2 px-4 rounded-lg text-xs hover:bg-teal-600 transition duration-300">
                                        Usulkan
                                    </a>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white">
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                Saat ini belum ada sesi proposal yang dibuka.
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>

        {{-- TODO: Implementasi pagination jika diperlukan --}}
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
            {{-- ... Kode pagination statis ... --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- CSS Anda untuk mobile sudah bagus dan tidak perlu diubah --}}
<style>
    @media (max-width: 767px) {
        /* ... (CSS Anda di sini) ... */
    }
</style>
@endpush