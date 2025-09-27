@extends('subdirektorat-inovasi.dosen.index')

@php
    // Fungsi helper untuk status, bisa dipindahkan ke file helper jika digunakan di banyak tempat
    if (!function_exists('getStatusInfoDosen')) {
        function getStatusInfoDosen($status)
        {
            switch ($status) {
                case 'diajukan':
                    return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
                case 'verifikasi':
                    return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Verifikasi'];
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
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" 
         x-data="{ showDeleteModal: false, deleteUrl: '', showDetailModal: false, detailSubmission: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            {{-- Breadcrumb dan Header --}}
            <header class="mb-10">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                                class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}"
                                class="hover:text-teal-600 transition-colors duration-200">APC</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800">Manajemen Proposal</li>
                    </ol>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Proposal APC</h1>
                        <p class="mt-2 text-gray-600 text-base">Semua proposal Article Processing Cost yang telah Anda ajukan.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-plus-circle mr-2 text-lg'></i>
                            Usulkan Proposal Baru
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
                @forelse ($groupedSubmissions as $sessionId => $submissions)
                    @php
                        $session = $submissions->first()->session;
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
                                        <div class="bg-green-100 text-green-800 px-4 py-2.5 rounded-xl border-2 border-green-200">
                                            <p class="text-xs font-bold uppercase tracking-wide">Batas Akhir</p>
                                            <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM YYYY') }}</p>
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
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-7/12">
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bx-file-blank text-base text-blue-500'></i>
                                                    <span>Jurnal & Artikel</span>
                                                </div>
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bx-money text-base text-green-500'></i>
                                                    <span>Biaya</span>
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
                                                class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-1/12">
                                                <div class="flex items-center justify-center space-x-1">
                                                    <i class='bx bx-cog text-base text-teal-600'></i>
                                                    <span>Aksi</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($submissions as $submission)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-5">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                                <i class='bx bx-book-content text-blue-500 text-xl'></i>
                                                            </div>
                                                        </div>
                                                        <div class="min-w-0 flex-1">
                                                            <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                                {{ $submission->nama_jurnal_q1 }}
                                                            </p>
                                                            <p class="text-xs lg:text-sm text-gray-500 mt-1 line-clamp-2">
                                                                {{ $submission->judul_artikel }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-sm text-gray-900">
                                                    <div class="flex items-center">
                                                        <i class='bx bx-wallet text-green-500 mr-2'></i>
                                                        <span class="font-semibold text-xs lg:text-sm">
                                                            Rp {{ number_format($submission->biaya_publikasi, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    @php
                                                        $displayStatus = $submission->status;
                                                        if (!$isSessionOpen && $submission->status === 'diajukan') {
                                                            $displayStatus = 'verifikasi';
                                                        }
                                                        $status = getStatusInfoDosen($displayStatus);
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 border-2 border-{{ $status['color'] }}-200">
                                                        <i class='bx {{ $status['icon'] }} mr-1 text-xs'></i>
                                                        {{ $status['text'] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                                        <button @click="open = !open"
                                                            class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                            <i class='bx bx-dots-horizontal-rounded text-lg'></i>
                                                        </button>
                                                        <div x-show="open" @click.away="open = false"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="transform opacity-0 scale-95"
                                                            x-transition:enter-end="transform opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-75"
                                                            x-transition:leave-start="transform opacity-100 scale-100"
                                                            x-transition:leave-end="transform opacity-0 scale-95"
                                                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border-2 border-gray-100"
                                                            style="display: none;">
                                                            <div class="py-1" role="menu" aria-orientation="vertical">
                                                                <button @click="showDetailModal = true; detailSubmission = {{ $submission->toJson() }}; open = false"
                                                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                                                    role="menuitem">
                                                                    <i class='bx bx-show-alt mr-3 text-lg text-blue-500'></i>
                                                                    Lihat Detail
                                                                </button>
                                                                
                                                                @if ($isSessionOpen && $submission->status === 'diajukan')
                                                                    <a href="{{ route('subdirektorat-inovasi.dosen.apc.edit', $submission->id) }}"
                                                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                                                        role="menuitem">
                                                                        <i class='bx bx-edit-alt mr-3 text-lg text-blue-600'></i>
                                                                        Edit Proposal
                                                                    </a>
                                                                    
                                                                    <div class="border-t my-1 border-gray-100"></div>
                                                                    <button @click="showDeleteModal = true; deleteUrl = '{{ route('subdirektorat-inovasi.dosen.apc.destroy', $submission->id) }}'; open = false"
                                                                        class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                                                        role="menuitem">
                                                                        <i class='bx bx-trash mr-3 text-lg'></i>
                                                                        Hapus Proposal
                                                                    </button>
                                                                @else
                                                                    <div class="flex items-center w-full px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                                                                        <i class='bx bx-lock mr-3 text-lg'></i>
                                                                        Sesi Ditutup
                                                                    </div>
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
                            @foreach ($submissions as $submission)
                                <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-start space-x-3 flex-1 min-w-0">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                                    <i class='bx bx-book-content text-blue-500 text-lg'></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                                    {{ $submission->nama_jurnal_q1 }}
                                                </h3>
                                                <p class="text-xs text-gray-500 line-clamp-2">
                                                    {{ $submission->judul_artikel }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-2">
                                            @php
                                                $displayStatus = $submission->status;
                                                if (!$isSessionOpen && $submission->status === 'diajukan') {
                                                    $displayStatus = 'verifikasi';
                                                }
                                                $status = getStatusInfoDosen($displayStatus);
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 border border-{{ $status['color'] }}-200">
                                                <i class='bx {{ $status['icon'] }} mr-1 text-xs'></i>
                                                {{ $status['text'] }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Biaya Publikasi</span>
                                        <p class="text-gray-900 font-semibold flex items-center text-sm">
                                            <i class='bx bx-wallet text-green-500 text-xs mr-1'></i>
                                            Rp {{ number_format($submission->biaya_publikasi, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open"
                                            class="w-full flex items-center justify-center px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                            <i class='bx bx-cog mr-2'></i>
                                            <span>Opsi</span>
                                            <i class='bx bx-chevron-down ml-2 transform transition-transform'
                                                :class="open ? 'rotate-180' : ''"></i>
                                        </button>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 transform scale-95"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-95"
                                            class="mt-2 w-full rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden border-2 border-gray-100"
                                            style="display: none;">
                                            <div class="py-1">
                                                <button @click="showDetailModal = true; detailSubmission = {{ $submission->toJson() }}; open = false"
                                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                    <i class='bx bx-show-alt mr-3 text-lg text-blue-500'></i>
                                                    Lihat Detail
                                                </button>
                                                
                                                @if ($isSessionOpen && $submission->status === 'diajukan')
                                                    <a href="{{ route('subdirektorat-inovasi.dosen.apc.edit', $submission->id) }}"
                                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                                        <i class='bx bx-edit-alt mr-3 text-lg text-blue-600'></i>
                                                        Edit Proposal
                                                    </a>
                                                    
                                                    <div class="border-t my-1 border-gray-100"></div>
                                                    <button @click="showDeleteModal = true; deleteUrl = '{{ route('subdirektorat-inovasi.dosen.apc.destroy', $submission->id) }}'; open = false"
                                                        class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                        <i class='bx bx-trash mr-3 text-lg'></i>
                                                        Hapus Proposal
                                                    </button>
                                                @else
                                                    <div class="flex items-center w-full px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                                                        <i class='bx bx-lock mr-3 text-lg'></i>
                                                        Sesi Ditutup
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
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
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                    <i class='bx bx-data text-4xl text-gray-400'></i>
                                </div>
                                <h3 class="font-bold text-xl text-gray-800 mb-2">Anda Belum Memiliki Proposal APC</h3>
                                <p class="text-gray-500 mb-8 max-w-md">Mulailah dengan mengajukan proposal Article Processing Cost untuk publikasi jurnal internasional Anda.</p>
                                <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}"
                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                    Usulkan Proposal Baru
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Delete Confirmation Modal --}}
            <div x-show="showDeleteModal" 
                 x-cloak 
                 @keydown.escape.window="showDeleteModal = false"
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
                        Apakah Anda yakin ingin menghapus proposal ini? Semua data yang terkait akan dihapus secara permanen.
                    </p>
                    <form :action="deleteUrl" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                @click="showDeleteModal = false"
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

            {{-- Detail Modal --}}
            <div x-show="showDetailModal" 
                 x-cloak 
                 @keydown.escape.window="showDetailModal = false"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div @click.away="showDetailModal = false"
                     class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-gray-200">
                    
                    {{-- Modal Header --}}
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center">
                            <i class='bx bx-file-blank text-2xl mr-3'></i>
                            <h3 class="text-xl font-bold">Detail Proposal APC</h3>
                        </div>
                        <button @click="showDetailModal = false" 
                                class="p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-colors">
                            <i class='bx bx-x text-xl'></i>
                        </button>
                    </div>
                    
                    {{-- Modal Content --}}
                    <div class="p-6 space-y-6 overflow-y-auto flex-1">
                        {{-- Basic Info --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
                            <div class="lg:col-span-2">
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Judul Artikel</label>
                                <p class="text-gray-800 font-semibold leading-relaxed" x-text="detailSubmission?.judul_artikel"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Jurnal (Q1)</label>
                                <p class="text-gray-800 font-medium" x-text="detailSubmission?.nama_jurnal_q1"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Biaya Publikasi</label>
                                <p class="text-lg font-bold text-green-600" x-text="`Rp ${new Intl.NumberFormat('id-ID').format(detailSubmission?.biaya_publikasi)}`"></p>
                            </div>
                            <div class="lg:col-span-2">
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Link ScimagoJR</label>
                                <a :href="detailSubmission?.link_scimagojr" 
                                   target="_blank"
                                   class="text-teal-600 hover:text-teal-800 hover:underline break-all text-sm"
                                   x-text="detailSubmission?.link_scimagojr"></a>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Volume</label>
                                <p class="text-gray-800" x-text="detailSubmission?.volume || '-'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Issue</label>
                                <p class="text-gray-800" x-text="detailSubmission?.issue || '-'"></p>
                            </div>
                        </div>
                        
                        {{-- Authors Section --}}
                        <div class="border-t-2 border-gray-100 pt-6">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                                <i class='bx bx-group text-indigo-500 mr-2'></i>
                                Daftar Penulis
                            </h4>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <template x-if="detailSubmission && detailSubmission.authors && detailSubmission.authors.length > 0">
                                    <div class="space-y-3">
                                        <template x-for="author in detailSubmission.authors.sort((a, b) => a.urutan - b.urutan)" :key="author.id">
                                            <div class="flex items-start bg-white p-3 rounded-lg border border-gray-200">
                                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center mr-3">
                                                    <span class="text-indigo-600 font-bold text-sm" x-text="author.urutan"></span>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-800 text-sm" x-text="author.nama"></p>
                                                    <p class="text-xs text-gray-500" x-text="author.afiliasi"></p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="!detailSubmission || !detailSubmission.authors || detailSubmission.authors.length === 0">
                                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada data penulis</p>
                                </template>
                            </div>
                        </div>
                        
                        {{-- Documents Section --}}
                        <div class="border-t-2 border-gray-100 pt-6">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                                <i class='bx bx-cloud-download text-blue-500 mr-2'></i>
                                Dokumen Pendukung
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <a :href="`/storage/${detailSubmission?.artikel_path}`" 
                                   target="_blank"
                                   class="flex items-center p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 group">
                                    <i class='bx bx-file-pdf text-red-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Artikel</p>
                                        <p class="text-xs text-gray-500">Dokumen PDF</p>
                                    </div>
                                </a>
                                <a :href="`/storage/${detailSubmission?.invoice_path}`" 
                                   target="_blank"
                                   class="flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 group">
                                    <i class='bx bx-receipt text-yellow-600 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Invoice</p>
                                        <p class="text-xs text-gray-500">Bukti Tagihan</p>
                                    </div>
                                </a>
                                <a :href="`/storage/${detailSubmission?.submission_process_path}`" 
                                   target="_blank"
                                   class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                                    <i class='bx bx-check-shield text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Bukti Proses</p>
                                        <p class="text-xs text-gray-500">Submission</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Status History --}}
                        <div class="border-t-2 border-gray-100 pt-6">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                                <i class='bx bx-history text-purple-500 mr-2'></i>
                                Riwayat Status
                            </h4>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <template x-if="detailSubmission && detailSubmission.status_history && detailSubmission.status_history.length > 0">
                                    <div class="space-y-4">
                                        <template x-for="(log, index) in detailSubmission.status_history.slice().reverse()" :key="index">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center">
                                                        <i class='bx bx-time text-purple-500 text-sm'></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 bg-white p-3 rounded-lg border border-gray-200">
                                                    <p class="font-semibold text-gray-800 text-sm" x-text="`Status berubah menjadi '${log.status}'`"></p>
                                                    <p class="text-xs text-gray-500 mt-1" x-text="new Date(log.timestamp).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' })"></p>
                                                    <p class="text-xs text-gray-600 italic mt-1" x-text="log.notes" x-show="log.notes"></p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="!detailSubmission || !detailSubmission.status_history || detailSubmission.status_history.length === 0">
                                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada riwayat status</p>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Modal Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-200">
                        <button @click="showDetailModal = false"
                                class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
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

    .bg-white:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .w-full {
        width: 100%;
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

    .bg-white.rounded-2xl {
        overflow: visible;
    }

    [x-show="open"] {
        z-index: 9999 !important;
    }

    [x-cloak] { 
        display: none !important; 
    }

    .group:hover i {
        animation: bounce 0.6s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-5px);
        }
        60% {
            transform: translateY(-2px);
        }
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush