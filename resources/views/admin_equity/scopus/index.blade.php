@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <header class="mb-10">
             <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base'></i></li>
                    <li class="font-medium text-gray-800">Jurnal Scopus/WOS</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Jurnal Scopus/WOS</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola daftar jurnal terindeks Scopus/WOS.</p>
                </div>
                <div>
                     <a href="#" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 shadow-md">
                        <i class='bx bxs-add-to-queue mr-2'></i>
                        Tambah Jurnal Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-list-ul mr-3'></i>
                    Daftar Jurnal
                </h2>
            </div>
            
            {{-- Desktop Table --}}
            <div class="hidden lg:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Artikel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Penulis Utama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nama Jurnal</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Quartile</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $journals = [
                                ['title' => 'Machine Learning for Predictive Analysis', 'author' => 'Dr. Adi Nugroho', 'journal' => 'IEEE Transactions', 'quartile' => 'Q1', 'status' => 'terverifikasi'],
                                ['title' => 'Marine Biodiversity in Indonesia', 'author' => 'Prof. Rina Amelia', 'journal' => 'Oceanography Letters', 'quartile' => 'Q2', 'status' => 'pending'],
                            ];
                        @endphp
                        @forelse ($journals as $journal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-5 text-sm font-semibold">{{ $journal['title'] }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $journal['author'] }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $journal['journal'] }}</td>
                                <td class="px-6 py-5 text-center text-sm font-bold text-teal-600">{{ $journal['quartile'] }}</td>
                                <td class="px-6 py-5 text-center">
                                     @if($journal['status'] == 'terverifikasi')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-green-100 text-green-800">Terverifikasi</span>
                                     @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-gray-100 text-gray-800">Pending</span>
                                     @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="#" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200" title="Detail"><i class='bx bx-show'></i></a>
                                        <a href="#" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200" title="Edit"><i class='bx bxs-edit'></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-10">Tidak ada data jurnal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
             <div class="lg:hidden">
                @forelse ($journals as $journal)
                    <div class="border-b p-4">
                       <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900 flex-1 mr-2">{{ $journal['title'] }}</h3>
                             <span class="text-sm font-bold text-teal-600">{{ $journal['quartile'] }}</span>
                       </div>
                        <p class="text-sm text-gray-600 mb-1">oleh: {{ $journal['author'] }}</p>
                        <p class="text-sm text-gray-500 italic mb-3">{{ $journal['journal'] }}</p>
                        @if($journal['status'] == 'terverifikasi')
                            <span class="text-xs font-medium rounded-full bg-green-100 text-green-800 px-2 py-1">Terverifikasi</span>
                        @else
                            <span class="text-xs font-medium rounded-full bg-gray-100 text-gray-800 px-2 py-1">Pending</span>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-16 px-4">Belum ada data jurnal.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection