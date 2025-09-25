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
                    <li class="font-medium text-gray-800">Insentif Reviewer</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Insentif Reviewer</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua data insentif untuk reviewer.</p>
                </div>
                <div>
                    <a href="#" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 shadow-md">
                        <i class='bx bxs-add-to-queue mr-2'></i>
                        Tambah Data Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
             <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-list-ul mr-3'></i>
                    Daftar Insentif
                </h2>
            </div>
            {{-- Desktop Table --}}
            <div class="hidden lg:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nama Reviewer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Artikel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Tanggal Review</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nominal Insentif</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $incentives = [
                                ['reviewer' => 'Dr. Budi Santoso', 'article' => 'Quantum Computing Applications', 'date' => '2025-08-20', 'amount' => 750000, 'status' => 'dibayar'],
                                ['reviewer' => 'Prof. Citra Lestari', 'article' => 'Genetic Engineering Ethics', 'date' => '2025-08-25', 'amount' => 850000, 'status' => 'belum_dibayar'],
                            ];
                        @endphp
                        @forelse ($incentives as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-5 text-sm font-semibold">{{ $item['reviewer'] }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $item['article'] }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ \Carbon\Carbon::parse($item['date'])->isoFormat('D MMM Y') }}</td>
                                <td class="px-6 py-5 text-sm font-medium">Rp {{ number_format($item['amount'], 0, ',', '.') }}</td>
                                <td class="px-6 py-5 text-center">
                                    @if($item['status'] == 'dibayar')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-blue-100 text-blue-800">Dibayar</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-orange-100 text-orange-800">Belum Dibayar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="#" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200" title="Detail"><i class='bx bx-show'></i></a>
                                        <button class="p-2 text-green-600 bg-green-100 rounded-lg hover:bg-green-200" title="Tandai Dibayar"><i class='bx bx-check-circle'></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                             <tr><td colspan="7" class="text-center py-10">Tidak ada data insentif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Mobile Cards --}}
            <div class="lg:hidden">
                @forelse ($incentives as $item)
                    <div class="border-b p-4">
                        <h3 class="font-semibold text-gray-900">{{ $item['reviewer'] }}</h3>
                        <p class="text-sm text-gray-600 italic mb-2">"{{ $item['article'] }}"</p>
                        <div class="flex justify-between items-center">
                             <p class="text-sm font-medium">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                             @if($item['status'] == 'dibayar')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Dibayar</span>
                             @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">Belum Dibayar</span>
                             @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 px-4">Belum ada data insentif.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection