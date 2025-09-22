@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Judul Halaman --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base'></i></li>
                    <li class="font-medium text-gray-800">Article Processing Cost</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen APC</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua pengajuan Article Processing Cost (APC).</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="#" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 shadow-md">
                        <i class='bx bxs-add-to-queue mr-2'></i>
                        Buat Pengajuan Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Konten Utama - Daftar Pengajuan APC --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-list-ul mr-3'></i>
                    Daftar Pengajuan APC
                </h2>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Artikel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Jurnal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nominal</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $apc_submissions = [
                                ['title' => 'The Impact of AI on Modern Education', 'journal' => 'Journal of Technology', 'date' => '2025-09-15', 'amount' => 1500000, 'status' => 'disetujui'],
                                ['title' => 'Sustainable Urban Development', 'journal' => 'Urban Studies Review', 'date' => '2025-09-12', 'amount' => 2200000, 'status' => 'direview'],
                                ['title' => 'Advancements in Renewable Energy', 'journal' => 'Energy Science', 'date' => '2025-09-10', 'amount' => 1800000, 'status' => 'ditolak'],
                            ];
                        @endphp
                        @forelse ($apc_submissions as $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-900">{{ $submission['title'] }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $submission['journal'] }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ \Carbon\Carbon::parse($submission['date'])->isoFormat('D MMM Y') }}</td>
                                <td class="px-6 py-5 text-sm font-medium text-gray-800">Rp {{ number_format($submission['amount'], 0, ',', '.') }}</td>
                                <td class="px-6 py-5 text-center text-sm">
                                    @if($submission['status'] == 'disetujui')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-green-100 text-green-800">Disetujui</span>
                                    @elseif($submission['status'] == 'direview')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-yellow-100 text-yellow-800">Verifikasi</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-gray-100 text-gray-800">Diajukan</span>
                                  
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="#" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200" title="Detail"><i class='bx bx-show'></i></a>
                                        <a href="#" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200" title="Edit"><i class='bx bxs-edit'></i></a>
                                        <button class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200" title="Hapus"><i class='bx bxs-trash'></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-10">Tidak ada data pengajuan APC.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:hidden">
                @forelse ($apc_submissions as $submission)
                    <div class="border-b p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900 flex-1 mr-2">{{ $submission['title'] }}</h3>
                            @if($submission['status'] == 'disetujui')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @elseif($submission['status'] == 'direview')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Direview</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ $submission['journal'] }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <span class="text-xs text-gray-500">Tanggal</span>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($submission['date'])->isoFormat('D MMM Y') }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500">Nominal</span>
                                <p class="font-medium">Rp {{ number_format($submission['amount'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <a href="#" class="px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-lg">Detail</a>
                            <a href="#" class="px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-lg">Edit</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 px-4">Belum ada pengajuan APC.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection