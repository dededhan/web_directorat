@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8" x-data>

    <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600">Home</a><i class='bx bx-chevron-right text-lg mx-2'></i></li>
            <li class="font-medium text-gray-700">Manajemen Proposal</li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Portofolio Proposal Anda</h1>

    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 border border-slate-200">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Daftar Proposal Diajukan</h2>
            <p class="text-gray-500 text-sm mt-1">Semua proposal penelitian & pengabdian yang telah Anda buat atau ajukan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Judul Proposal / Skema</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Tahun</th>
                        <th scope="col" class="px-6 py-3 hidden lg:table-cell">Nominal Usulan</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $submission)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $submission->judul ?? 'Belum ada judul (Draft)' }}</div>
                                <div class="text-xs text-gray-500">({{ $submission->sesi->nama_sesi ?? 'Sesi tidak ditemukan' }})</div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell align-middle">{{ $submission->tahun_usulan ?? '-' }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell align-middle">
                                @if($submission->nominal_usulan)
                                    Rp {{ number_format($submission->nominal_usulan, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if ($submission->status == 'diajukan')
                                    <span class="status-badge bg-green-100 text-green-800"><i class='bx bxs-check-circle mr-1'></i> Diajukan</span>
                                @elseif ($submission->status == 'draft')
                                    <span class="status-badge bg-yellow-100 text-yellow-800"><i class='bx bxs-time-five mr-1'></i> Draft</span>
                                @else
                                    <span class="status-badge bg-gray-100 text-gray-800">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-1.5 bg-sky-500 text-white text-xs font-medium rounded-md hover:bg-sky-600">
                                        Opsi <i class='bx bx-chevron-down ml-1'></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10 text-left" style="display: none;">
                                        <div class="py-1">
                                            @if ($submission->status == 'draft')
                                            {{-- MENGGUNAKAN NAMA ROUTE BARU --}}
                                            <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.createPengajuan', $submission->id) }}" class="menu-item">
                                                <i class='bx bx-edit-alt mr-2'></i> Lanjutkan Pengisian
                                            </a>
                                            @endif
                                            <a href="#" class="menu-item"><i class='bx bx-show mr-2'></i>Lihat Detail</a>
                                            <a href="#" class="menu-item"><i class='bx bx-list-ul mr-2'></i>Logbook</a>
                                            <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.tahapan', $submission->id) }}" class="menu-item"><i class='bx bx-line-chart mr-2'></i>Tahapan Proposal</a>
                                            
                                            @if ($submission->status == 'draft')
                                            <div class="border-t my-1"></div>
                                            {{-- MENGGUNAKAN NAMA ROUTE BARU --}}
                                            <form action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.destroyDraft', $submission->id) }}" method="POST"
                                                  @submit.prevent="
                                                    Swal.fire({
                                                        title: 'Hapus Draft?',
                                                        text: 'Anda yakin ingin menghapus draft proposal ini?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#d33',
                                                        cancelButtonColor: '#3085d6',
                                                        confirmButtonText: 'Ya, hapus!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $event.target.submit();
                                                        }
                                                    })
                                                  ">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="menu-item text-red-600 w-full">
                                                   <i class='bx bx-trash mr-2'></i> Hapus Draft
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
                            <td colspan="5" class="text-center py-16 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class='bx bx-data text-5xl text-gray-400 mb-2'></i>
                                    <p class="font-semibold text-base">Anda belum memiliki proposal apapun.</p>
                                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" class="mt-4 inline-block bg-sky-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-sky-700 text-sm">
                                        + Usulkan Proposal Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-badge { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium; }
    .menu-item { @apply flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100; }
</style>
@endpush

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
