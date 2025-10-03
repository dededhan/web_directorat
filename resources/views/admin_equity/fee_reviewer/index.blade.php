@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="feeReviewer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Fee Reviewer</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Sesi Fee Reviewer</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua sesi program Fee Reviewer yang tersedia.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.fee_reviewer.create') }}"
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                        Buat Sesi Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-calendar-event mr-3 text-2xl'></i>
                            Daftar Sesi Fee Reviewer
                        </h2>
                        <p class="mt-2 text-teal-100">Kelola dan monitor semua sesi program Fee Reviewer</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2.5 rounded-xl border-2 border-white border-opacity-30">
                            <p class="text-xs font-bold uppercase tracking-wide text-teal-100">Total Sesi</p>
                            <p class="text-lg font-bold">{{ $sessions->total() }} Sesi</p>
                        </div>
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
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-hash text-base text-gray-500'></i>
                                        <span>No</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-folder text-base text-blue-500'></i>
                                        <span>Nama Sesi</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-calendar text-base text-purple-500'></i>
                                        <span>Periode Pengajuan</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">
                                    <div class="flex items-center space-x-1">
                                        <i class='bx bx-file text-base text-blue-500'></i>
                                        <span>Total Laporan</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-1/12">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class='bx bx-info-circle text-base text-yellow-500'></i>
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
                            @forelse ($sessions as $session)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5 text-sm text-gray-500">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="font-bold text-xs">{{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                    <i class='bx bx-folder text-blue-500 text-xl'></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="font-semibold text-gray-900 text-sm lg:text-base leading-relaxed break-words">
                                                    {{ $session->nama_sesi }}
                                                </p>
                                                <p class="text-xs lg:text-sm text-gray-500 mt-1">
                                                    Sesi Program Fee Reviewer
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-900">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-calendar-check text-purple-500'></i>
                                            <div>
                                                <p class="font-semibold text-sm">
                                                    {{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }}
                                                </p>
                                                <p class="text-xs text-gray-500">sampai {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <i class='bx bx-file text-blue-500 mr-2'></i>
                                            <div>
                                                <p class="font-semibold text-sm">
                                                    {{ $session->reports()->count() }} Laporan
                                                </p>
                                                <p class="text-xs text-gray-500">Total Laporan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($session->computed_status === 'Tutup')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border-2 border-red-200">
                                                <i class='bx bx-x-circle mr-1 text-xs'></i>
                                                Tutup
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border-2 border-green-200">
                                                <i class='bx bx-check-circle mr-1 text-xs'></i>
                                                Buka
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <button @click="open = !open" x-ref="button"
                                                class="inline-flex items-center justify-center p-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <i class='bx bx-dots-horizontal-rounded text-lg'></i>
                                            </button>
                                            
                                            <!-- Dropdown positioned outside card -->
                                            <div x-show="open" @click.away="open = false"
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
                                                                $el.style.top = (rect.bottom + window.scrollY + 8) + 'px';
                                                                $el.style.left = (rect.right + window.scrollX - $el.offsetWidth) + 'px';
                                                            });
                                                        }
                                                    })
                                                ">
                                                <div class="py-1" role="menu" aria-orientation="vertical">
                                                    <a href="{{ route('admin_equity.fee_reviewer.show', $session->id) }}"
                                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                                        role="menuitem">
                                                        <i class='bx bx-show mr-3 text-lg text-blue-500'></i>
                                                        Lihat Pengajuan
                                                    </a>
                                                    <a href="{{ route('admin_equity.fee_reviewer.edit', $session->id) }}"
                                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors"
                                                        role="menuitem">
                                                        <i class='bx bx-edit-alt mr-3 text-lg text-yellow-600'></i>
                                                        Edit Sesi
                                                    </a>
                                                    <div class="border-t my-1 border-gray-100"></div>
                                                    <button @click="confirmDelete({{ $session->id }}); open = false"
                                                        class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                                        role="menuitem">
                                                        <i class='bx bx-trash mr-3 text-lg'></i>
                                                        Hapus Sesi
                                                    </button>
                                                    <form method="POST" action="{{ route('admin_equity.fee_reviewer.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-20">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                                <i class='bx bx-calendar-plus text-4xl text-gray-400'></i>
                                            </div>
                                            <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Sesi Fee Reviewer</h3>
                                            <p class="text-gray-500 mb-8 max-w-md">Buat sesi baru untuk memulai program penlaporanan Article Processing Cost.</p>
                                            <a href="{{ route('admin_equity.fee_reviewer.create') }}"
                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                                Buat Sesi Baru
                                            </a>
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
                @forelse ($sessions as $session)
                    <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3 flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-folder text-blue-500 text-lg'></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                        {{ $session->nama_sesi }}
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        Sesi {{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2">
                                @if ($session->computed_status === 'Tutup')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <i class='bx bx-x-circle mr-1 text-xs'></i>
                                        Tutup
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <i class='bx bx-check-circle mr-1 text-xs'></i>
                                        Buka
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4 space-y-3">
                            <div>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Periode Pengajuan</span>
                                <p class="text-gray-900 font-semibold flex items-center text-sm">
                                    <i class='bx bx-calendar text-purple-500 text-xs mr-1'></i>
                                    {{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Laporan</span>
                                <p class="text-gray-900 font-semibold flex items-center text-sm">
                                    <i class='bx bx-wallet text-green-500 text-xs mr-1'></i>
                                    {{ $session->reports()->count() }} Laporan
                                </p>
                            </div>
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
                                    <a href="{{ route('admin_equity.fee_reviewer.show', $session->id) }}"
                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        <i class='bx bx-show mr-3 text-lg text-blue-500'></i>
                                        Lihat Pengajuan
                                    </a>
                                    <a href="{{ route('admin_equity.fee_reviewer.edit', $session->id) }}"
                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
                                        <i class='bx bx-edit-alt mr-3 text-lg text-yellow-600'></i>
                                        Edit Sesi
                                    </a>
                                    <div class="border-t my-1 border-gray-100"></div>
                                    <button @click="confirmDelete({{ $session->id }}); open = false"
                                        class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class='bx bx-trash mr-3 text-lg'></i>
                                        Hapus Sesi
                                    </button>
                                    <form method="POST" action="{{ route('admin_equity.fee_reviewer.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 px-6">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                <i class='bx bx-calendar-plus text-4xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Sesi Fee Reviewer</h3>
                            <p class="text-gray-500 max-w-md">Buat sesi baru untuk memulai program penlaporanan Article Processing Cost.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($sessions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $sessions->firstItem() ?? 0 }} hingga {{ $sessions->lastItem() ?? 0 }} dari {{ $sessions->total() }} hasil
                        </div>
                        <div class="pagination-wrapper">
                            {{ $sessions->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('feeReviewer', () => ({
        confirmDelete(sessionId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Sesi ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs['deleteForm' + sessionId].submit();
                }
            })
        }
    }));
});
</script>
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

    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.25rem;
    }

    .pagination-wrapper .pagination a,
    .pagination-wrapper .pagination span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination-wrapper .pagination a:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    .pagination-wrapper .pagination .active span {
        background-color: #0d9488;
        color: white;
        border-color: #0d9488;
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush