@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="comdev">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Judul Halaman --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Community Development</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Sesi Comdev</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua sesi Community Development yang tersedia dalam sistem.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.comdev.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bxs-add-to-queue mr-2 text-lg'></i>
                        Buat Sesi Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Konten Utama - Daftar Sesi --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                        <i class='bx bx-list-ul mr-3 text-2xl'></i>
                        Daftar Sesi Tersedia
                    </h2>
                    <div class="text-teal-100 text-sm">
                        Total: <span class="font-semibold text-white">{{ $sessions->total() }} sesi</span>
                    </div>
                </div>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class='bx bx-hash text-base text-blue-500'></i>
                                    <span>No</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class='bx bx-file-blank text-base text-blue-500'></i>
                                    <span>Nama Sesi</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class='bx bx-calendar text-base text-orange-500'></i>
                                    <span>Periode</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class='bx bx-money text-base text-red-500'></i>
                                    <span>Dana</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class='bx bx-group text-base text-purple-500'></i>
                                    <span>Anggota</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center space-x-1">
                                    <i class='bx bx-info-circle text-base text-indigo-500'></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
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
                                    <div class="flex items-center">
                                        <i class='bx bx-hash text-blue-500 mr-2'></i>
                                        {{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                                <i class='bx bx-file-blank text-blue-500 text-xl'></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-gray-900 text-base leading-snug">
                                                {{ $session->nama_sesi }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class='bx bx-time text-orange-500 mr-2'></i>
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }}</span>
                                            <span class="text-xs text-gray-500">sampai {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class='bx bx-wallet text-red-500 mr-2'></i>
                                        <span class="font-semibold">Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class='bx bx-group text-purple-500 mr-2'></i>
                                        <span class="font-medium">{{ $session->min_anggota }} - {{ $session->max_anggota }} orang</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border-2 border-red-200">
                                            <i class='bx bxs-x-circle mr-1.5 text-sm'></i> Tutup
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border-2 border-green-200">
                                            <i class='bx bxs-check-circle mr-1.5 text-sm'></i> Buka
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
                                                <a href="{{ route('admin_equity.comdev.submissions.index', $session->id) }}"
                                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                                    role="menuitem">
                                                    <i class='bx bx-show mr-3 text-lg text-blue-500'></i>
                                                    Lihat Proposal Masuk
                                                </a>
                                                <a href="{{ route('admin_equity.comdev.modules.index', $session->id) }}"
                                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors"
                                                    role="menuitem">
                                                    <i class='bx bx-cog mr-3 text-lg text-purple-500'></i>
                                                    Manajemen Modul
                                                </a>
                                                <a href="{{ route('admin_equity.comdev.edit', $session->id) }}"
                                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors"
                                                    role="menuitem">
                                                    <i class='bx bxs-edit mr-3 text-lg text-yellow-500'></i>
                                                    Edit Sesi
                                                </a>
                                                <form method="POST" action="{{ route('admin_equity.comdev.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}" class="block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" @click="confirmDelete({{ $session->id }})"
                                                        class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors text-left"
                                                        role="menuitem">
                                                        <i class='bx bxs-trash mr-3 text-lg'></i>
                                                        Hapus Sesi
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-20 px-6">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                                <i class='bx bx-data text-4xl text-gray-400'></i>
                                            </div>
                                            <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Sesi Comdev</h3>
                                            <p class="text-gray-500 mb-8 max-w-md">Mulailah dengan membuat sesi Community Development baru untuk memulai program pengabdian masyarakat.</p>
                                            <a href="{{ route('admin_equity.comdev.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                <i class='bx bxs-add-to-queue mr-2 text-lg'></i>
                                                Buat Sesi Baru
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:hidden">
                @forelse ($sessions as $session)
                    <div class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3 flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-file-blank text-blue-500 text-lg'></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1">
                                        {{ $session->nama_sesi }}
                                    </h3>
                                    <p class="text-xs text-gray-500 flex items-center">
                                        <i class='bx bx-hash text-xs mr-1'></i>
                                        Sesi #{{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2">
                                @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <i class='bx bxs-x-circle mr-1 text-xs'></i> Tutup
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <i class='bx bxs-check-circle mr-1 text-xs'></i> Buka
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Periode</span>
                                <p class="text-gray-900 font-medium flex items-start">
                                    <i class='bx bx-time text-orange-500 text-xs mr-1 mt-0.5'></i>
                                    <span class="text-xs leading-tight">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}</span>
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Dana</span>
                                <p class="text-gray-900 font-medium flex items-center">
                                    <i class='bx bx-wallet text-red-500 text-xs mr-1'></i>
                                    <span class="text-xs">Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Anggota</span>
                            <p class="text-gray-900 font-medium flex items-center text-sm">
                                <i class='bx bx-group text-purple-500 text-xs mr-1'></i>
                                {{ $session->min_anggota }} - {{ $session->max_anggota }} orang
                            </p>
                        </div>

                        <div x-data="{ open: false }" class="relative inline-block text-left w-full">
                            <button @click="open = !open" x-ref="buttonMobile{{$session->id}}"
                                class="w-full flex items-center justify-center px-4 py-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class='bx bx-dots-horizontal-rounded text-xl mr-2'></i>
                                <span>Aksi</span>
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
                                                const rect = $refs.buttonMobile{{$session->id}}.getBoundingClientRect();
                                                $el.style.top = (rect.bottom + window.scrollY + 8) + 'px';
                                                $el.style.left = (rect.left + window.scrollX) + 'px';
                                            });
                                        }
                                    })
                                ">
                                <div class="py-1" role="menu" aria-orientation="vertical">
                                    <a href="{{ route('admin_equity.comdev.submissions.index', $session->id) }}"
                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                        role="menuitem">
                                        <i class='bx bx-show mr-3 text-lg text-blue-500'></i>
                                        Lihat Proposal Masuk
                                    </a>
                                    <a href="{{ route('admin_equity.comdev.modules.index', $session->id) }}"
                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors"
                                        role="menuitem">
                                        <i class='bx bx-cog mr-3 text-lg text-purple-500'></i>
                                        Manajemen Modul
                                    </a>
                                    <a href="{{ route('admin_equity.comdev.edit', $session->id) }}"
                                        class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors"
                                        role="menuitem">
                                        <i class='bx bxs-edit mr-3 text-lg text-yellow-500'></i>
                                        Edit Sesi
                                    </a>
                                    <form method="POST" action="{{ route('admin_equity.comdev.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="confirmDelete({{ $session->id }})"
                                            class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors text-left"
                                            role="menuitem">
                                            <i class='bx bxs-trash mr-3 text-lg'></i>
                                            Hapus Sesi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 px-4">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                <i class='bx bx-data text-3xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Belum Ada Sesi Comdev</h3>
                            <p class="text-gray-500 text-sm mb-6 text-center max-w-xs">Mulailah dengan membuat sesi Community Development baru.</p>
                            <a href="{{ route('admin_equity.comdev.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class='bx bxs-add-to-queue mr-2 text-lg'></i>
                                Buat Sesi Baru
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($sessions->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $sessions->links() }}
            </div>
            @endif

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('comdev', () => ({
        confirmDelete(sessionId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
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

@stack('scripts')

@push('styles')
<style>
    input:focus, select:focus, button:focus {
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }
    
    button:hover, a:hover {
        transform: translateY(-1px);
    }
    
    tr.hover\:bg-gray-50:hover {
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.07), 0 4px 6px -2px rgb(0 0 0 / 0.05);
    }
    
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush
@endsection
