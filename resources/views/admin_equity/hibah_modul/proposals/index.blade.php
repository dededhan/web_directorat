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
                    <li class="font-medium text-gray-800">{{ $sesi->nama_sesi }}</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Daftar Proposal</h1>
                    <p class="mt-2 text-gray-600">{{ $sesi->nama_sesi }}</p>
                </div>
                <a href="{{ route('admin_equity.hibah_modul.moduls.index', $sesi->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i class='bx bx-cog mr-2'></i>Kelola Template Modul
                </a>
            </div>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold">Proposal yang Masuk</h2>
                    <span class="text-teal-100">Total: <span class="font-semibold text-white">{{ $proposals->total() }}</span></span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Modul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Pengusul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Anggota</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Reviewer</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proposals as $index => $proposal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $proposals->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $proposal->judul_modul ?? 'Draft' }}</div>
                                @if($proposal->ringkasan_modul)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($proposal->ringkasan_modul, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-gray-800">{{ $proposal->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $proposal->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    {{ $proposal->anggota->count() }} orang
                                </span>
                            </td>
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
                            <td class="px-6 py-4 text-sm">
                                @if($proposal->reviewer)
                                    <div class="text-gray-800">{{ $proposal->reviewer->name }}</div>
                                @else
                                    <span class="text-gray-400 italic">Belum ditugaskan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin_equity.hibah_modul.proposals.show', [$sesi->id, $proposal->id]) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                    <i class='bx bx-show mr-1'></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                                <p class="text-gray-500 text-lg">Belum ada proposal untuk sesi ini</p>
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
