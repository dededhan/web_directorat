@extends('admin_inovchalenge.index')

@section('contentadmin_inovchalenge')
<div class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin_inovchalenge.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-700 font-medium">Innovation Challenge</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Innovation Challenge</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola sesi Innovation Challenge</p>
            </div>
            <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.create') }}"
               class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-medium rounded-xl shadow hover:from-teal-600 hover:to-teal-700 transition">
                <i class="fas fa-plus mr-2"></i> Buat Sesi Baru
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            {{-- Card header --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 rounded-t-2xl">
                <h2 class="text-white font-semibold text-lg">
                    <i class="fas fa-list mr-2"></i> Daftar Sesi
                    <span class="ml-2 bg-white/20 text-white text-sm px-3 py-0.5 rounded-full">{{ $sessions->total() }}</span>
                </h2>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Sesi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Submissions</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($sessions as $session)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $session->nama_sesi }}</div>
                                    @if($session->deskripsi)
                                        <div class="text-xs text-gray-400 mt-1 line-clamp-1">{{ $session->deskripsi }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $session->submissions_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($session->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <i class="fas fa-circle text-[6px] mr-1.5"></i> Active
                                        </span>
                                    @elseif($session->status === 'closed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                            <i class="fas fa-circle text-[6px] mr-1.5"></i> Closed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <i class="fas fa-circle text-[6px] mr-1.5"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        {{-- Lihat --}}
                                        <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.show', $session) }}"
                                           title="Lihat"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-teal-600 hover:bg-teal-50 transition">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.edit', $session) }}"
                                           title="Edit"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-blue-600 hover:bg-blue-50 transition">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        {{-- Activate / Close --}}
                                        @if($session->status === 'draft')
                                            <form method="POST" action="{{ route('admin_inovchalenge.inovchalenge.sessions.activate', $session) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" title="Aktifkan"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-green-600 hover:bg-green-50 transition">
                                                    <i class="fas fa-play text-sm"></i>
                                                </button>
                                            </form>
                                        @elseif($session->status === 'active')
                                            <form method="POST" action="{{ route('admin_inovchalenge.inovchalenge.sessions.close', $session) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" title="Tutup"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-orange-600 hover:bg-orange-50 transition">
                                                    <i class="fas fa-stop text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                        {{-- Hapus --}}
                                        <form method="POST" action="{{ route('admin_inovchalenge.inovchalenge.sessions.destroy', $session) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus sesi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 transition">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-teal-100 to-teal-200 rounded-2xl flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-3xl text-teal-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-700">Belum ada sesi</h3>
                                        <p class="text-sm text-gray-400 mt-1">Buat sesi baru untuk memulai Innovation Challenge</p>
                                        <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.create') }}"
                                           class="mt-4 inline-flex items-center px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-lg hover:bg-teal-600 transition">
                                            <i class="fas fa-plus mr-2"></i> Buat Sesi
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="lg:hidden divide-y divide-gray-100">
                @forelse ($sessions as $session)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $session->nama_sesi }}</h3>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}
                                </p>
                            </div>
                            @if($session->status === 'active')
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @elseif($session->status === 'closed')
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">Closed</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                            @endif
                        </div>
                        <div class="mt-3 flex items-center space-x-3">
                            <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.show', $session) }}"
                               class="text-sm text-teal-600 font-medium hover:underline">Lihat</a>
                            <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.edit', $session) }}"
                               class="text-sm text-blue-600 font-medium hover:underline">Edit</a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">Belum ada sesi.</div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($sessions->hasPages())
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 rounded-b-2xl">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
