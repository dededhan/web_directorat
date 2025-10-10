@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Hibah Modul Ajar</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Sesi Hibah Modul</h1>
                    <p class="mt-2 text-gray-600">Kelola sesi hibah modul ajar untuk dosen</p>
                </div>
                <a href="{{ route('admin_equity.hibah_modul.sesi.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                    <i class='bx bx-plus mr-2'></i>
                    Buat Sesi Baru
                </a>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class='bx bx-list-ul mr-3 text-2xl'></i>
                        Daftar Sesi
                    </h2>
                    <span class="text-teal-100 text-sm">Total: <span class="font-semibold text-white">{{ $sessions->total() }}</span></span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nama Sesi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Jumlah Proposal</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $sessions->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $session->nama_sesi }}</div>
                                @if($session->deskripsi)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($session->deskripsi, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class='bx bx-calendar text-orange-500'></i>
                                    <span>{{ $session->periode_awal->format('d M Y') }} - {{ $session->periode_akhir->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($session->status === 'dibuka')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dibuka</span>
                                @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditutup</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    <i class='bx bx-file mr-1'></i>
                                    {{ $session->proposals_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin_equity.hibah_modul.sesi.show', $session->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                    <a href="{{ route('admin_equity.hibah_modul.sesi.edit', $session->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                        <i class='bx bx-edit text-xl'></i>
                                    </a>
                                    <form action="{{ route('admin_equity.hibah_modul.sesi.destroy', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus sesi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada sesi hibah modul</p>
                                    <p class="text-gray-400 text-sm mt-2">Klik tombol "Buat Sesi Baru" untuk menambahkan sesi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($sessions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $sessions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
