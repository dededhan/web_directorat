@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.sesi') }}" class="hover:text-teal-600 transition-colors duration-200">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Manajemen Proposal</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Proposal Student Exchange</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua proposal pertukaran mahasiswa yang telah Anda ajukan.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.sesi') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                        Usulkan Proposal Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-check-circle text-green-400 text-xl'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-green-800">Sukses</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-error-circle text-red-400 text-xl'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Gagal</h3>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Main Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                        <i class='bx bx-globe mr-3 text-2xl'></i>
                        Daftar Proposal Student Exchange
                    </h2>
                    <div class="text-teal-100 text-sm">
                        Total: <span class="font-semibold text-white">{{ $proposals->total() }} proposal</span>
                    </div>
                </div>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-visible">
                <div class="w-full overflow-visible">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-4/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-book-content text-base text-blue-500'></i>
                                        <span>Judul Kegiatan</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-globe text-base text-orange-500'></i>
                                        <span>Jenis & Mitra</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-user text-base text-purple-500'></i>
                                        <span>Reviewer</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class='bx bx-info-circle text-base text-indigo-500'></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class='bx bx-cog text-base text-teal-600'></i>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proposals as $proposal)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-5">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                            <i class='bx bx-globe text-blue-500 text-xl'></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                            {{ $proposal->judul_kegiatan ?? 'Belum ada judul (Draft)' }}
                                        </p>
                                        <p class="text-xs lg:text-sm text-gray-500 mt-1 flex items-center">
                                            <i class='bx bx-tag text-xs mr-1'></i>
                                            <span class="truncate">{{ $proposal->sesi->nama_sesi }}</span>
                                        </p>
                                        @if($proposal->ringkasan_kegiatan)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($proposal->ringkasan_kegiatan, 80) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-sm">
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-700">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $proposal->jenis_kegiatan === 'inbound' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            <i class='bx {{ $proposal->jenis_kegiatan === 'inbound' ? 'bx-log-in' : 'bx-log-out' }} mr-1'></i>
                                            {{ ucfirst($proposal->jenis_kegiatan) }}
                                        </span>
                                    </div>
                                    @if($proposal->mitra)
                                    <div class="text-xs text-gray-600">
                                        <i class='bx bx-buildings mr-1'></i>
                                        {{ $proposal->mitra->nama_mitra }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class='bx bx-user-circle text-purple-500 mr-2'></i>
                                    <span class="font-medium">{{ $proposal->reviewer->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border-2
                                    @if($proposal->status === 'draft') bg-gray-100 text-gray-800 border-gray-200
                                    @elseif($proposal->status === 'diajukan') bg-blue-100 text-blue-800 border-blue-200
                                    @elseif($proposal->status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 border-yellow-200
                                    @elseif($proposal->status === 'diterima') bg-green-100 text-green-800 border-green-200
                                    @elseif($proposal->status === 'ditolak') bg-red-100 text-red-800 border-red-200
                                    @elseif($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800 border-purple-200
                                    @elseif($proposal->status === 'lolos') bg-emerald-100 text-emerald-800 border-emerald-200
                                    @else bg-orange-100 text-orange-800 border-orange-200 @endif">
                                    <i class='bx bx-info-circle mr-1 text-xs'></i>
                                    {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open" x-ref="button" class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                        <i class='bx bx-dots-horizontal-rounded text-lg'></i>
                                    </button>
                                    <div x-show="open" 
                                         @click.away="open = false" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         x-ref="dropdown"
                                         class="fixed bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border-2 border-gray-100 w-56 z-[9999]"
                                         style="display: none;"
                                         @click="open = false"
                                         x-init="
                                             $watch('open', value => {
                                                 if (value) {
                                                     $nextTick(() => {
                                                         const button = $refs.button;
                                                         const dropdown = $refs.dropdown;
                                                         const rect = button.getBoundingClientRect();
                                                         const dropdownHeight = dropdown.offsetHeight;
                                                         const dropdownWidth = dropdown.offsetWidth;
                                                         const viewportWidth = window.innerWidth;
                                                         const viewportHeight = window.innerHeight;
                                                         const scrollY = window.pageYOffset || document.documentElement.scrollTop;
                                                         const scrollX = window.pageXOffset || document.documentElement.scrollLeft;
                                                         
                                                         let top = rect.bottom + scrollY + 8;
                                                         let left = rect.right + scrollX - dropdownWidth;
                                                         
                                                         if (top + dropdownHeight > viewportHeight + scrollY) {
                                                             top = rect.top + scrollY - dropdownHeight - 8;
                                                         }
                                                         
                                                         if (left < scrollX) {
                                                             left = rect.left + scrollX;
                                                         }
                                                         
                                                         dropdown.style.top = top + 'px';
                                                         dropdown.style.left = left + 'px';
                                                     });
                                                 }
                                             })
                                         ">
                                        <div class="py-1" role="menu">
                                            <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id) }}" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class='bx bx-show-alt mr-3 text-lg text-blue-500'></i>Lihat Detail
                                            </a>
                                            
                                            @if(in_array($proposal->status, ['draft', 'diajukan']))
                                            <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.edit', $proposal->id) }}" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
                                                <i class='bx bx-edit-alt mr-3 text-lg text-yellow-600'></i>Edit Proposal
                                            </a>
                                            @endif

                                            @if($proposal->status === 'draft')
                                            <form action="{{ route('subdirektorat-inovasi.dosen.student_exchange.confirm', $proposal->id) }}" method="POST" class="w-full">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                                    <i class='bx bx-paper-plane mr-3 text-lg text-green-600'></i>Ajukan Proposal
                                                </button>
                                            </form>
                                            @endif

                                            @if($proposal->status === 'diterima')
                                            <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.laporanAkhir', $proposal->id) }}" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                                <i class='bx bx-file-blank mr-3 text-lg text-purple-600'></i>Laporan Akhir
                                            </a>
                                            @endif

                                            @if(in_array($proposal->status, ['draft', 'diajukan']))
                                            <div class="border-t my-1 border-gray-100"></div>
                                            <form action="{{ route('subdirektorat-inovasi.dosen.student_exchange.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Yakin hapus proposal ini?')" class="w-full">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                    <i class='bx bx-trash mr-3 text-lg'></i>Hapus Proposal
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                        <i class='bx bx-data text-4xl text-gray-400'></i>
                                    </div>
                                    <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Proposal</h3>
                                    <p class="text-gray-500 mb-8 max-w-md">Mulai buat proposal pertukaran mahasiswa untuk berbagi pengalaman dan pengetahuan.</p>
                                    <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.sesi') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                        Usulkan Proposal Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($proposals->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $proposals->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    table {
        table-layout: fixed;
        width: 100%;
    }

    .break-words {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    /* Ensure dropdown is on top of everything */
    .z-\[9999\] {
        z-index: 9999 !important;
    }
</style>
@endpush
@endsection
