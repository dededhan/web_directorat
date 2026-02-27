@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}" class="hover:text-teal-600">Innovation Challenge</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-700 font-medium">{{ $session->nama_sesi }}</li>
            </ol>
        </nav>

        {{-- Session Header --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-white font-semibold text-lg">
                    <i class="fas fa-info-circle mr-2"></i> Detail Sesi
                </h2>
                <a href="{{ route('admin_inovasi.inovchalenge.sessions.edit', $session) }}"
                   class="inline-flex items-center px-3 py-1.5 bg-white/20 text-white text-sm rounded-lg hover:bg-white/30 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Sesi</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $session->nama_sesi }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Periode</dt>
                        <dd class="mt-1 text-sm text-gray-700">{{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Status</dt>
                        <dd class="mt-1">
                            @if($session->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                            @elseif($session->status === 'closed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Closed</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Draft</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Submissions</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $session->submissions->count() }}</dd>
                    </div>
                </div>
                @if($session->deskripsi)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Deskripsi</dt>
                        <dd class="text-sm text-gray-600">{{ $session->deskripsi }}</dd>
                    </div>
                @endif
                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Dana Maksimal</dt>
                        <dd class="mt-1 text-sm text-gray-700">
                            {{ $session->dana_maksimal ? 'Rp ' . number_format($session->dana_maksimal, 0, ',', '.') : '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Min Anggota</dt>
                        <dd class="mt-1 text-sm text-gray-700">{{ $session->min_anggota ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Max Anggota</dt>
                        <dd class="mt-1 text-sm text-gray-700">{{ $session->max_anggota ?? '-' }}</dd>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3-Tahap Grid --}}
        <h3 class="text-lg font-bold text-gray-900 mb-4">
            <i class="fas fa-layer-group mr-2 text-teal-500"></i> Tahap Konfigurasi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($session->tahap as $tahap)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">
                    <div class="px-5 py-3 {{ $tahap->tahap_ke === 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600' : ($tahap->tahap_ke === 2 ? 'bg-gradient-to-r from-purple-500 to-purple-600' : 'bg-gradient-to-r from-orange-500 to-orange-600') }}">
                        <h4 class="text-white font-semibold">
                            <i class="fas fa-flag mr-1.5"></i> {{ $tahap->nama_tahap }}
                        </h4>
                    </div>
                    <div class="p-5">
                        <p class="text-sm text-gray-500 mb-3">
                            {{ $tahap->deskripsi ?: 'Belum ada deskripsi.' }}
                        </p>

                        {{-- Flags --}}
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if($tahap->has_anggota)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="fas fa-users mr-1"></i> Anggota Tim
                                </span>
                            @endif
                            @if($tahap->has_fakultas)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    <i class="fas fa-university mr-1"></i> Fakultas
                                </span>
                            @endif
                        </div>

                        {{-- Periode --}}
                        @if($tahap->periode_awal && $tahap->periode_akhir)
                            <p class="text-xs text-gray-400 mb-3">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $tahap->periode_awal->format('d M Y H:i') }} — {{ $tahap->periode_akhir->format('d M Y H:i') }}
                            </p>
                        @endif

                        {{-- Fields count --}}
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-list-ul mr-1"></i> {{ $tahap->fields->count() }} field(s)
                            </span>
                            <a href="{{ route('admin_inovasi.inovchalenge.tahap.edit', $tahap) }}"
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-teal-700 bg-teal-50 rounded-lg hover:bg-teal-100 border border-teal-200 transition">
                                <i class="fas fa-cog mr-1"></i> Konfigurasi
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
