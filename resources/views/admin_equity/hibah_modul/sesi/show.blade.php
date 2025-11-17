@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.hibah_modul.sesi.index') }}" class="hover:text-teal-600">Hibah Modul</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $sesi->nama_sesi }}</h1>
                    <p class="mt-2 text-gray-600">{{ $sesi->deskripsi }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin_equity.hibah_modul.moduls.index', $sesi->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        <i class='bx bx-cog mr-2'></i>Kelola Modul
                    </a>
                    <a href="{{ route('admin_equity.hibah_modul.sesi.edit', $sesi->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        <i class='bx bx-edit mr-2'></i>Edit Sesi
                    </a>
                </div>
            </div>
        </header>

        <!-- Info Sesi -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Periode</p>
                        <p class="text-lg font-bold text-gray-800">{{ $sesi->periode_awal->format('d M Y') }} - {{ $sesi->periode_akhir->format('d M Y') }}</p>
                    </div>
                    <i class='bx bx-calendar text-4xl text-teal-500'></i>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Proposal</p>
                        <p class="text-lg font-bold text-gray-800">{{ $sesi->proposals->count() }}</p>
                    </div>
                    <i class='bx bx-file text-4xl text-blue-500'></i>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Nominal Usulan</p>
                        <p class="text-lg font-bold text-gray-800">Rp {{ number_format($sesi->nominal_usulan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <i class='bx bx-money text-4xl text-purple-500'></i>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-{{ $sesi->status === 'dibuka' ? 'green' : 'red' }}-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="text-lg font-bold text-gray-800">{{ ucfirst($sesi->status) }}</p>
                    </div>
                    <i class='bx bx-{{ $sesi->status === 'dibuka' ? 'lock-open' : 'lock' }} text-4xl text-{{ $sesi->status === 'dibuka' ? 'green' : 'red' }}-500'></i>
                </div>
            </div>
        </div>

        <!-- List Proposal -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Daftar Proposal</h2>
                <a href="{{ route('admin_equity.hibah_modul.proposals.index', $sesi->id) }}" class="text-teal-600 hover:text-teal-700 font-semibold">
                    Lihat Semua <i class='bx bx-chevron-right'></i>
                </a>
            </div>

            @if($sesi->proposals->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Judul Modul</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Pengusul</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($sesi->proposals->take(10) as $proposal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $proposal->judul_modul ?? 'Draft' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $proposal->user->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($proposal->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($proposal->status === 'diajukan') bg-blue-100 text-blue-800
                                    @elseif($proposal->status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                                    @elseif($proposal->status === 'diterima') bg-green-100 text-green-800
                                    @elseif($proposal->status === 'ditolak') bg-red-100 text-red-800
                                    @elseif($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800
                                    @elseif($proposal->status === 'lolos') bg-emerald-100 text-emerald-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin_equity.hibah_modul.proposals.show', [$sesi->id, $proposal->id]) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class='bx bx-show text-xl'></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                <p class="text-gray-500">Belum ada proposal untuk sesi ini</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
