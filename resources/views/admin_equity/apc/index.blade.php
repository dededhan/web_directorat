@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="apc">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Judul Halaman --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Article Processing Cost (APC)</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Sesi APC</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua sesi pendanaan Article Processing Cost yang tersedia.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.apc.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
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
                        Daftar Sesi APC
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
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Sesi</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Periode Pengajuan</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total Dana</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($sessions as $session)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 text-sm text-gray-500">{{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}</td>
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-900 text-base leading-snug">{{ $session->nama_sesi }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-900">
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }}</span> - 
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-900">
                                    <span class="font-semibold">Rp {{ number_format($session->dana, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    {{-- DIUBAH: Menggunakan accessor getComputedStatusAttribute --}}
                                    @if ($session->computed_status === 'Tutup')
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
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin_equity.apc.show', $session->id) }}" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors" title="Lihat Pengajuan">
                                            <i class='bx bx-show text-lg'></i>
                                        </a>
                                        <a href="{{ route('admin_equity.apc.edit', $session->id) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition-colors" title="Edit Sesi">
                                            <i class='bx bxs-edit text-lg'></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin_equity.apc.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="confirmDelete({{ $session->id }})" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition-colors" title="Hapus Sesi">
                                               <i class='bx bxs-trash text-lg'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center py-20 px-6">
                                        <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Sesi APC</h3>
                                        <p class="text-gray-500 mb-8 max-w-md mx-auto">Buat sesi baru untuk memulai program pendanaan Article Processing Cost.</p>
                                        <a href="{{ route('admin_equity.apc.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <i class='bx bxs-add-to-queue mr-2 text-lg'></i>
                                            Buat Sesi Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
    Alpine.data('apc', () => ({
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
