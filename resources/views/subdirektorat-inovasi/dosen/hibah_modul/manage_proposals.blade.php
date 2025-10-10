@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Proposal Saya</h1>
                    <p class="mt-2 text-gray-600">Kelola semua proposal hibah modul ajar Anda</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.sesi') }}" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    <i class='bx bx-plus mr-2'></i>Proposal Baru
                </a>
            </div>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Modul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Sesi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Reviewer</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($proposals as $proposal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $proposal->judul_modul ?? 'Draft' }}</div>
                                @if($proposal->ringkasan_modul)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($proposal->ringkasan_modul, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $proposal->sesi->nama_sesi }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($proposal->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($proposal->status === 'diajukan') bg-blue-100 text-blue-800
                                    @elseif($proposal->status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                                    @elseif($proposal->status === 'diterima') bg-green-100 text-green-800
                                    @elseif($proposal->status === 'ditolak') bg-red-100 text-red-800
                                    @elseif($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800
                                    @elseif($proposal->status === 'lolos') bg-emerald-100 text-emerald-800
                                    @else bg-orange-100 text-orange-800 @endif">
                                    {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $proposal->reviewer->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.show', $proposal->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Detail">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                    
                                    @if(in_array($proposal->status, ['draft', 'diajukan']))
                                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.edit', $proposal->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg" title="Edit">
                                        <i class='bx bx-edit text-xl'></i>
                                    </a>
                                    @endif

                                    @if($proposal->status === 'draft')
                                    <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.confirm', $proposal->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Ajukan">
                                            <i class='bx bx-paper-plane text-xl'></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if(in_array($proposal->status, ['draft', 'diajukan']))
                                    <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.destroy', $proposal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus proposal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if($proposal->status === 'diterima')
                                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.laporanAkhir', $proposal->id) }}" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg" title="Laporan Akhir">
                                        <i class='bx bx-file-blank text-xl'></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                                <p class="text-gray-500 text-lg">Belum ada proposal</p>
                                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.sesi') }}" class="mt-4 inline-block text-teal-600 hover:text-teal-700 font-semibold">
                                    Buat proposal baru <i class='bx bx-right-arrow-alt'></i>
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($proposals->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $proposals->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
