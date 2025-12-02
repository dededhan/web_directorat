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
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.index') }}" class="hover:text-teal-600">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $sesi->nama_sesi }}</h1>
                    <p class="mt-2 text-gray-600">Detail dan proposal untuk sesi ini</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin_equity.student_exchange.sesi.edit', $sesi->id) }}" class="inline-flex items-center px-4 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all shadow-md">
                        <i class='bx bx-edit mr-2'></i>
                        Edit Sesi
                    </a>
                    <a href="{{ route('admin_equity.student_exchange.moduls.index', $sesi->id) }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all shadow-md">
                        <i class='bx bx-book mr-2'></i>
                        Kelola Modul
                    </a>
                </div>
            </div>
        </header>

        {{-- Session Info Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-info-circle mr-3 text-2xl'></i>
                    Informasi Sesi
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Sesi</label>
                        <p class="text-gray-800 text-lg font-medium">{{ $sesi->nama_sesi }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Status</label>
                        @if($sesi->status === 'dibuka')
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800 inline-flex items-center">
                            <i class='bx bx-check-circle mr-2'></i> Dibuka
                        </span>
                        @else
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800 inline-flex items-center">
                            <i class='bx bx-x-circle mr-2'></i> Ditutup
                        </span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Periode Awal</label>
                        <p class="text-gray-800 flex items-center">
                            <i class='bx bx-calendar text-orange-500 mr-2 text-xl'></i>
                            {{ $sesi->periode_awal->format('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Periode Akhir</label>
                        <p class="text-gray-800 flex items-center">
                            <i class='bx bx-calendar text-orange-500 mr-2 text-xl'></i>
                            {{ $sesi->periode_akhir->format('d F Y') }}
                        </p>
                    </div>
                    @if($sesi->deskripsi)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Deskripsi</label>
                        <p class="text-gray-700 leading-relaxed">{{ $sesi->deskripsi }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Total Proposal</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $sesi->proposals->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class='bx bx-file text-2xl text-blue-600'></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Menunggu Review</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $sesi->proposals->where('status', 'menunggu_direview')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class='bx bx-time text-2xl text-yellow-600'></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Lolos</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $sesi->proposals->where('status', 'lolos')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class='bx bx-check-circle text-2xl text-green-600'></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Tidak Lolos</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $sesi->proposals->where('status', 'tidak_lolos')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class='bx bx-x-circle text-2xl text-red-600'></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Proposals List --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class='bx bx-list-ul mr-3 text-2xl'></i>
                        Daftar Proposal
                    </h2>
                    <a href="{{ route('admin_equity.student_exchange.proposals.index', $sesi->id) }}" class="text-sm text-teal-100 hover:text-white underline">
                        Lihat Semua
                    </a>
                </div>
            </div>

            {{-- Desktop View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Pengusul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sesi->proposals->take(10) as $index => $proposal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ Str::limit($proposal->judul_kegiatan, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $proposal->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($proposal->jenis_kegiatan === 'inbound')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Inbound</span>
                                @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Outbound</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @include('admin_equity.student-exchange.partials.status-badge', ['status' => $proposal->status])
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin_equity.student_exchange.proposals.show', [$sesi->id, $proposal->id]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <i class='bx bx-inbox text-5xl text-gray-300 mb-2'></i>
                                <p class="text-gray-500">Belum ada proposal untuk sesi ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="lg:hidden space-y-4 p-4">
                @forelse($sesi->proposals->take(10) as $proposal)
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1">{{ Str::limit($proposal->judul_kegiatan, 40) }}</h3>
                                <p class="text-sm text-gray-500">{{ $proposal->user->name ?? 'N/A' }}</p>
                            </div>
                            @include('admin_equity.student-exchange.partials.status-badge', ['status' => $proposal->status])
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t">
                            @if($proposal->jenis_kegiatan === 'inbound')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Inbound</span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Outbound</span>
                            @endif
                            <a href="{{ route('admin_equity.student_exchange.proposals.show', [$sesi->id, $proposal->id]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class='bx bx-show text-xl'></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <i class='bx bx-inbox text-5xl text-gray-300 mb-2'></i>
                    <p class="text-gray-500">Belum ada proposal untuk sesi ini</p>
                </div>
                @endforelse
            </div>

            @if($sesi->proposals->count() > 10)
            <div class="bg-gray-50 px-6 py-4 border-t text-center">
                <a href="{{ route('admin_equity.student_exchange.proposals.index', $sesi->id) }}" class="text-teal-600 hover:text-teal-700 font-semibold">
                    Lihat {{ $sesi->proposals->count() - 10 }} Proposal Lainnya →
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
