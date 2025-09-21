@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb dan Judul Halaman --}}
            <header class="mb-10">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                                class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800">Manajemen Proposal</li>
                    </ol>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Portofolio Proposal Anda</h1>
                        <p class="mt-2 text-gray-600 text-base">Semua proposal penelitian & pengabdian yang telah Anda buat
                            atau ajukan.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-plus-circle mr-2 text-lg'></i>
                            Usulkan Proposal Baru
                        </a>
                    </div>
                </div>
            </header>

            {{-- Konten Utama - Daftar Proposal --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-folder-open mr-3 text-2xl'></i>
                            Daftar Proposal Diajukan
                        </h2>
                        <div class="text-teal-100 text-sm">
                            Total: <span class="font-semibold text-white">{{ $submissions->total() }} proposal</span>
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
                                        class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-5/12">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-file-blank text-base text-blue-500'></i>
                                            <span>Proposal & Skema</span>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/12">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-calendar text-base text-orange-500'></i>
                                            <span>Tahun</span>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-money text-base text-red-500'></i>
                                            <span>Nominal</span>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                        <div class="flex items-center justify-center space-x-1">
                                            <i class='bx bx-info-circle text-base text-indigo-500'></i>
                                            <span>Status</span>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                        <div class="flex items-center justify-center space-x-1">
                                            <i class='bx bx-cog text-base text-teal-600'></i>
                                            <span>Aksi</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($submissions as $submission)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-4 py-5">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                        <i class='bx bx-file-blank text-blue-500 text-xl'></i>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                        {{ $submission->judul ?? 'Belum ada judul (Draft)' }}
                                                    </p>
                                                    <p class="text-xs lg:text-sm text-gray-500 mt-1 flex items-center">
                                                        <i class='bx bx-tag text-xs mr-1'></i>
                                                        <span
                                                            class="truncate">{{ $submission->sesi->nama_sesi ?? 'Sesi tidak ditemukan' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class='bx bx-time text-orange-500 mr-2'></i>
                                                {{ $submission->tahun_usulan ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class='bx bx-wallet text-red-500 mr-2'></i>
                                                @if ($submission->nominal_usulan)
                                                    <span class="font-semibold text-xs lg:text-sm">Rp
                                                        {{ number_format($submission->nominal_usulan, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 text-center">
                                            @if ($submission->status == 'diajukan')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border-2 border-green-200">
                                                    <i class='bx bxs-check-circle mr-1 text-xs'></i> Diajukan
                                                </span>
                                            @elseif ($submission->status == 'draft')
                                        
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border-2 border-amber-200">
                                                    <i class='bx bxs-time-five mr-1 text-xs'></i> Draft
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border-2 border-gray-200">
                                                    {{ ucfirst(str_replace('_', ' ', $submission->status->value)) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-5 text-center">
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
                                                        @if ($submission->status->value == 'draft')
                                                            <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.createPengajuan', $submission->id) }}"
                                                                class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors"
                                                                role="menuitem">
                                                                <i class='bx bx-edit-alt mr-3 text-lg text-teal-600'></i>
                                                                Lanjutkan Pengisian
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.tahapan', $submission->id) }}"
                                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                                            role="menuitem">
                                                            <i
                                                                class='bx bx-line-chart mr-3 text-lg text-purple-500'></i>Tahapan
                                                            Proposal
                                                        </a>
                                                        
                                                         <a href="{{ route('subdirektorat-inovasi.dosen.equity.logbook', ['submission' => $submission->id]) }}" 
                                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                                            role="menuitem">
                                                            <i class='bx bx-list-ul mr-3 text-lg text-green-300'></i>Logbook 
                                                        </a>
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.detail', $submission) }}"
                                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                                            role="menuitem">
                                                            <i class='bx bx-show mr-3 text-lg text-blue-500'></i>Lihat Detail
                                                        </a>
                                                        
                                                        @if ($submission->status->value  == 'draft')
                                                            <div class="border-t my-1 border-gray-100"></div>
                                                            <form
                                                                action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.destroyDraft', $submission->id) }}"
                                                                method="POST"
                                                                @submit.prevent="
                                                            Swal.fire({
                                                                title: 'Hapus Draft?',
                                                                text: 'Anda yakin ingin menghapus draft proposal ini? Tindakan ini tidak dapat dibatalkan.',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#dc2626',
                                                                cancelButtonColor: '#6b7280',
                                                                confirmButtonText: 'Ya, Hapus Saja!',
                                                                cancelButtonText: 'Batal'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    $event.target.submit();
                                                                }
                                                            })
                                                          ">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                                                    role="menuitem">
                                                                    <i class='bx bx-trash mr-3 text-lg'></i> Hapus Draft
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
                                        <td colspan="5">
                                            <div class="text-center py-20 px-6">
                                                <div class="flex flex-col items-center">
                                                    <div
                                                        class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                                        <i class='bx bx-data text-4xl text-gray-400'></i>
                                                    </div>
                                                    <h3 class="font-bold text-xl text-gray-800 mb-2">Anda Belum Memiliki
                                                        Proposal</h3>
                                                    <p class="text-gray-500 mb-8 max-w-md">Mulailah dengan mengajukan
                                                        proposal penelitian atau pengabdian baru untuk memulai perjalanan
                                                        akademik Anda.</p>
                                                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}"
                                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                                        Usulkan Proposal Baru
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile Card View --}}
                <div class="lg:hidden">
                    @forelse ($submissions as $submission)
                        <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-file-blank text-blue-500 text-lg'></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                            {{ $submission->judul ?? 'Belum ada judul (Draft)' }}
                                        </h3>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class='bx bx-tag text-xs mr-1'></i>
                                            {{ $submission->sesi->nama_sesi ?? 'Sesi tidak ditemukan' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-2">
                                    @if ($submission->status == 'diajukan')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <i class='bx bxs-check-circle mr-1 text-xs'></i> Diajukan
                                        </span>
                                    @elseif ($submission->status->value  == 'draft')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                            <i class='bx bxs-time-five mr-1 text-xs'></i> Draft
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ ucfirst(str_replace('_', ' ', $submission->status->value)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tahun</span>
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <i class='bx bx-time text-orange-500 text-xs mr-1'></i>
                                        {{ $submission->tahun_usulan ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nominal</span>
                                    <p class="text-gray-900 font-medium flex items-center text-xs">
                                        <i class='bx bx-wallet text-red-500 text-xs mr-1'></i>
                                        @if ($submission->nominal_usulan)
                                            Rp {{ number_format($submission->nominal_usulan, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-teal-50 border-2 border-teal-200 rounded-xl text-sm font-medium text-teal-700 hover:bg-teal-100 hover:border-teal-300 transition-all">
                                    <i class='bx bx-cog mr-2'></i>
                                    <span>Opsi</span>
                                    <i class='bx bx-chevron-down ml-2 transform transition-transform'
                                        :class="open ? 'rotate-180' : ''"'></i>
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
                                        @if ($submission->status->value  == 'draft')
                                            <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.createPengajuan', $submission->id) }}"
                                                class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                                <i class='bx bx-edit-alt mr-3 text-lg text-teal-600'></i> Lanjutkan
                                                Pengisian
                                            </a>
                                        @endif
                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.detail', $submission) }}"
                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-show mr-3 text-lg text-blue-500'></i>Lihat Detail
                                        </a>
                                        <a href="#"
                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-list-ul mr-3 text-lg text-green-500'></i>Logbook
                                        </a>
                                        <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.tahapan', $submission->id) }}"
                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class='bx bx-line-chart mr-3 text-lg text-purple-500'></i>Tahapan Proposal
                                        </a>
                                        @if ($submission->status->value == 'draft')
                                            <div class="border-t my-1 border-gray-100"></div>
                                            <form
                                                action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.destroyDraft', $submission->id) }}"
                                                method="POST"
                                                @submit.prevent="
                                            Swal.fire({
                                                title: 'Hapus Draft?',
                                                text: 'Anda yakin ingin menghapus draft proposal ini? Tindakan ini tidak dapat dibatalkan.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#dc2626',
                                                cancelButtonColor: '#6b7280',
                                                confirmButtonText: 'Ya, Hapus Saja!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $event.target.submit();
                                                }
                                            })
                                          ">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                    <i class='bx bx-trash mr-3 text-lg'></i> Hapus Draft
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 px-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                    <i class='bx bx-data text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="font-bold text-lg text-gray-800 mb-2">Anda Belum Memiliki Proposal</h3>
                                <p class="text-gray-500 text-sm mb-6 text-center max-w-xs">Mulailah dengan mengajukan
                                    proposal penelitian atau pengabdian baru.</p>
                                <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}"
                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                    Usulkan Proposal Baru
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($submissions->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $submissions->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

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

        /* Prevent horizontal scroll and ensure proper text wrapping */
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

        /* Fix dropdown overflow issues */
        .bg-white.rounded-2xl {
            overflow: visible;
        }

        /* Ensure dropdown appears above other elements */
        [x-show="open"] {
            z-index: 9999 !important;
        }

        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush
