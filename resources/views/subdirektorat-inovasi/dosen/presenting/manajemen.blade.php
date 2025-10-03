@extends('subdirektorat-inovasi.dosen.index')

@php
    // Fungsi helper untuk status, bisa dipindahkan ke file helper jika digunakan di banyak tempat
    if (!function_exists('getStatusInfoDosen')) {
        function getStatusInfoDosen($status)
        {
            switch ($status) {
                case 'diajukan':
                    return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
                case 'diverifikasi':
                    return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Diverifikasi'];
                case 'disetujui':
                    return ['color' => 'green', 'icon' => 'bx-check-circle', 'text' => 'Disetujui'];
                case 'ditolak':
                    return ['color' => 'red', 'icon' => 'bx-x-circle', 'text' => 'Ditolak'];
                default:
                    return ['color' => 'gray', 'icon' => 'bx-question-mark', 'text' => 'Unknown'];
            }
        }
    }
@endphp

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb dan Header --}}
            <header class="mb-10">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                                class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.presenting.list-sesi') }}"
                                class="hover:text-teal-600 transition-colors duration-200">Presenting</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800">Manajemen Laporan</li>
                    </ol>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Laporan Presenting</h1>
                        <p class="mt-2 text-gray-600 text-base">Semua laporan Presenting yang telah Anda
                            ajukan.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('subdirektorat-inovasi.dosen.presenting.list-sesi') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-plus-circle mr-2 text-lg'></i>
                            Usulkan Laporan Baru
                        </a>
                    </div>
                </div>
            </header>

            {{-- Alert Messages --}}
            @if (session('success'))
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

            @if (session('error'))
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
            <div class="space-y-8">
                @forelse ($groupedReports as $sessionId => $reports)
                    @php
                        $session = $reports->first()->session;
                        $isSessionOpen = $session->computed_status === 'Buka';
                    @endphp

                    {{-- Session Card --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

                        {{-- Session Header --}}
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                                <div>
                                    <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                                        <i class='bx bx-calendar-event mr-3 text-2xl'></i>
                                        {{ $session->nama_sesi }}
                                    </h2>
                                    <p class="mt-2 text-teal-100">{{ $session->deskripsi }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    @if ($isSessionOpen)
                                        <div
                                            class="bg-green-100 text-green-800 px-4 py-2.5 rounded-xl border-2 border-green-200">
                                            <p class="text-xs font-bold uppercase tracking-wide">Batas Akhir</p>
                                            <p class="text-sm font-semibold">
                                                {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM YYYY') }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="bg-red-100 text-red-800 px-4 py-2.5 rounded-xl border-2 border-red-200">
                                            <p class="text-xs font-bold uppercase tracking-wide">Status</p>
                                            <p class="text-sm font-semibold">Sesi Ditutup</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Desktop Table View --}}
                        <div class="hidden lg:block overflow-visible">
                            <div class="w-full overflow-visible">
                                <table class="w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-8/12">
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bx-file-blank text-base text-blue-500'></i>
                                                    <span>Jurnal & Artikel</span>
                                                </div>
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                                <div class="flex items-center justify-center space-x-1">
                                                    <i class='bx bx-info-circle text-base text-indigo-500'></i>
                                                    <span>Status</span>
                                                </div>
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                                <div class="flex items-center justify-center space-x-1">
                                                    <i class='bx bx-cog text-base text-teal-600'></i>
                                                    <span>Aksi</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($reports as $report)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-5">
                                                    @if ($report->status == 'revisi' && !empty($report->catatan_revisi))
                                                        <div class="mb-2 p-3 bg-orange-50 border-l-4 border-orange-400 rounded-r-lg">
                                                            <p class="text-xs font-bold text-orange-800">Catatan Revisi dari Admin:</p>
                                                            <p class="text-xs text-orange-700 mt-1 whitespace-pre-wrap">{{ $report->catatan_revisi }}</p>
                                                        </div>
                                                    @endif

                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div
                                                                class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                                <i class='bx bx-book-content text-blue-500 text-xl'></i>
                                                            </div>
                                                        </div>
                                                        <div class="min-w-0 flex-1">
                                                            <p
                                                                class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                                {{ $report->nama_jurnal_q1 }}
                                                            </p>
                                                            <p class="text-xs lg:text-sm text-gray-500 mt-1 line-clamp-2">
                                                                {{ $report->judul_artikel }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    @php
                                                        $status = getStatusInfoDosen($report->status);
                                                    @endphp
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 border-2 border-{{ $status['color'] }}-200">
                                                        <i class='bx {{ $status['icon'] }} mr-1 text-xs'></i>
                                                        {{ $status['text'] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                                        <button @click="open = !open" x-ref="button" class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md"><i class='bx bx-dots-horizontal-rounded text-lg'></i></button>
                                                        <div x-show="open" 
                                                             @click.away="open = false" 
                                                             x-transition:enter="transition ease-out duration-100"
                                                             x-transition:enter-start="transform opacity-0 scale-95"
                                                             x-transition:enter-end="transform opacity-100 scale-100"
                                                             x-transition:leave="transition ease-in duration-75"
                                                             x-transition:leave-start="transform opacity-100 scale-100"
                                                             x-transition:leave-end="transform opacity-0 scale-95"
                                                             class="fixed bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 overflow-hidden border-2 border-gray-100 w-56"
                                                             style="display: none; z-index: 9999;"
                                                             x-init="
                                                                 $watch('open', value => {
                                                                     if (value) {
                                                                         $nextTick(() => {
                                                                             const rect = $refs.button.getBoundingClientRect();
                                                                             const dropdownWidth = $el.offsetWidth;
                                                                             const dropdownHeight = $el.offsetHeight;
                                                                             const viewportWidth = window.innerWidth;
                                                                             const viewportHeight = window.innerHeight;
                                                                             
                                                                             // Calculate top position
                                                                             let top = rect.bottom + window.scrollY + 8;
                                                                             
                                                                             // Check if dropdown goes beyond bottom of viewport
                                                                             if (rect.bottom + dropdownHeight + 8 > viewportHeight) {
                                                                                 // Open upwards
                                                                                 top = rect.top + window.scrollY - dropdownHeight - 8;
                                                                             }
                                                                             
                                                                             // Calculate left position
                                                                             let left = rect.right + window.scrollX - dropdownWidth;
                                                                             
                                                                             // Check if dropdown goes beyond left edge
                                                                             if (left < 0) {
                                                                                 left = rect.left + window.scrollX;
                                                                             }
                                                                             
                                                                             // Check if dropdown goes beyond right edge
                                                                             if (rect.right + dropdownWidth > viewportWidth) {
                                                                                 left = rect.right + window.scrollX - dropdownWidth;
                                                                             }
                                                                             
                                                                             $el.style.top = top + 'px';
                                                                             $el.style.left = left + 'px';
                                                                         });
                                                                     }
                                                                 })
                                                             ">
                                                            <div class="py-1" role="menu">
                                                                <a href="{{ route('subdirektorat-inovasi.dosen.presenting.details', $report) }}" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors"><i class='bx bx-show-alt mr-3 text-lg text-blue-500'></i>Lihat Detail</a>
                                                                @if ($isSessionOpen && in_array($report->status, ['diajukan', 'ditolak']))
                                                                    <a href="{{ route('subdirektorat-inovasi.dosen.presenting.edit', $report) }}" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors"><i class='bx bx-edit-alt mr-3 text-lg text-yellow-600'></i>Edit Laporan</a>
                                                                    <div class="border-t my-1 border-gray-100"></div>
                                                                    <button @click="showDeleteModal = true; deleteUrl = '{{ route('subdirektorat-inovasi.dosen.presenting.destroy', $report) }}'; open = false" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors"><i class='bx bx-trash mr-3 text-lg'></i>Hapus Laporan</button>
                                                                @elseif (!$isSessionOpen)
                                                                    <div class="flex items-center w-full px-4 py-3 text-sm text-gray-400 cursor-not-allowed"><i class='bx bx-lock mr-3 text-lg'></i>Sesi Ditutup</div>
                                                                @elseif (in_array($report->status, ['diverifikasi', 'disetujui']))
                                                                    <div class="flex items-center w-full px-4 py-3 text-sm text-gray-400 cursor-not-allowed"><i class='bx bx-lock mr-3 text-lg'></i>Sudah Diproses</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Mobile Card View --}}
                        <div class="lg:hidden">
                            @foreach ($reports as $report)
                                <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-start space-x-3 flex-1 min-w-0">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                                    <i class='bx bx-book-content text-blue-500 text-lg'></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                                    {{ $report->nama_jurnal_q1 }}
                                                </h3>
                                                <p class="text-xs text-gray-500 line-clamp-2">
                                                    {{ $report->judul_artikel }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-2">
                                            @php
                                                $displayStatus = $report->status;
                                                if (!$isSessionOpen && $report->status === 'diajukan') {
                                                    $displayStatus = 'verifikasi';
                                                }
                                                $status = getStatusInfoDosen($displayStatus);
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 border border-{{ $status['color'] }}-200">
                                                <i class='bx {{ $status['icon'] }} mr-1 text-xs'></i>
                                                {{ $status['text'] }}
                                            </span>
                                        </div>
                                    </div>


                                    
                                    {{-- Actions for mobile --}}
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('subdirektorat-inovasi.dosen.presenting.details', $report) }}" class="flex items-center justify-center w-full px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                            <i class='bx bx-show-alt mr-2'></i> Lihat Detail
                                        </a>
                                        @if ($isSessionOpen && in_array($report->status, ['diajukan', 'ditolak']))
                                            <a href="{{ route('subdirektorat-inovasi.dosen.presenting.edit', $report) }}" class="flex items-center justify-center w-full px-4 py-2 bg-yellow-50 border-2 border-yellow-200 rounded-xl text-sm font-medium text-yellow-700 hover:bg-yellow-100 hover:border-yellow-300 transition-all">
                                                <i class='bx bx-edit-alt mr-2'></i> Edit
                                            </a>
                                            <button @click="showDeleteModal = true; deleteUrl = '{{ route('subdirektorat-inovasi.dosen.presenting.destroy', $report) }}'" class="flex items-center justify-center w-full px-4 py-2 bg-red-50 border-2 border-red-200 rounded-xl text-sm font-medium text-red-700 hover:bg-red-100 hover:border-red-300 transition-all">
                                                <i class='bx bx-trash mr-2'></i> Hapus
                                            </button>
                                        @elseif (in_array($report->status, ['diverifikasi', 'disetujui']))
                                            <div class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-500 cursor-not-allowed">
                                                <i class='bx bx-lock mr-2'></i> Sudah Diproses
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="text-center py-20 px-6">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                    <i class='bx bx-data text-4xl text-gray-400'></i>
                                </div>
                                <h3 class="font-bold text-xl text-gray-800 mb-2">Anda Belum Memiliki Laporan Presenting</h3>
                                <p class="text-gray-500 mb-8 max-w-md">Mulailah dengan mengajukan laporan Article
                                    Processing Cost untuk publikasi jurnal internasional Anda.</p>
                                <a href="{{ route('subdirektorat-inovasi.dosen.presenting.list-sesi') }}"
                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                    Usulkan Laporan Baru
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Delete Confirmation Modal --}}
            <div x-show="showDeleteModal" x-cloak @keydown.escape.window="showDeleteModal = false"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div @click.away="showDeleteModal = false"
                    class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                            <i class='bx bx-trash text-red-500 text-2xl'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
                            <p class="text-sm text-gray-500">Tindakan tidak dapat dibatalkan</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-6">
                        Apakah Anda yakin ingin menghapus laporan ini? Semua data yang terkait akan dihapus secara
                        permanen.
                    </p>
                    <form :action="deleteUrl" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="showDeleteModal = false"
                            class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- DETAIL MODAL HAS BEEN REMOVED --}}

        </div>
    </div>
@endsection

@push('styles')
    <style>
        input:focus,
        select:focus,
        button:focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }

        button:hover {
            transform: translateY(-1px);
        }

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

        [x-cloak] {
            display: none !important;
        }

        /* Fix dropdown positioning */
        .bg-white.rounded-2xl {
            overflow: visible !important;
        }

        .bg-white.rounded-2xl .overflow-visible {
            overflow: visible !important;
        }

        .bg-white.rounded-2xl table {
            overflow: visible !important;
        }

        .fixed[x-show="open"] {
            position: fixed !important;
            z-index: 9999 !important;
        }

        [x-show="open"].fixed {
            top: auto !important;
            left: auto !important;
            transform: none !important;
        }

        .relative {
            position: relative;
            z-index: 1;
        }

        .relative .fixed[x-show="open"] {
            z-index: 9999 !important;
        }
    </style>
@endpush
