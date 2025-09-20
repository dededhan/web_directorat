@extends('admin_equity.index')

@section('content')
<div x-data="comdev">
    {{-- Header and Breadcrumbs --}}
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Sesi Comdev</h1>
                <nav aria-label="breadcrumb">
                    <ol class="flex items-center text-sm text-gray-500">
                        <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-sky-600">Dashboard</a></li>
                        <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                        <li class="font-semibold text-gray-700" aria-current="page">Community Development</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin_equity.comdev.create') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 border border-transparent rounded-md font-semibold text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    <i class='bx bxs-add-to-queue text-lg mr-2'></i> Buat Sesi Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Session List Table --}}
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class='bx bx-list-ul text-xl mr-2 text-sky-600'></i>Daftar Sesi Tersedia
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nama Sesi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Dana</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Anggota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sessions as $session)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $session->nama_sesi }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $session->min_anggota }} - {{ $session->max_anggota }} orang</td>
                            <td class="px-6 py-4">
                                @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tutup</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buka</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin_equity.comdev.show', $session->id) }}" class="text-sky-600 hover:text-sky-900" title="Lihat">
                                        <i class='bx bx-show text-lg'></i>
                                    </a>
                                    <a href="{{ route('admin_equity.comdev.edit', $session->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class='bx bxs-edit text-lg'></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin_equity.comdev.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="confirmDelete({{ $session->id }})" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class='bx bxs-trash text-lg'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class='bx bx-data text-4xl mb-2'></i>
                                    <p>Belum ada sesi proposal yang dibuat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if ($sessions->hasPages())
        <div class="p-4 border-t bg-gray-50">
            {{ $sessions->links() }}
        </div>
        @endif
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
@endsection
