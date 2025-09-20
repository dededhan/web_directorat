@extends('admin_equity.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header dan Breadcrumbs --}}
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                {{-- Judul halaman dinamis berdasarkan nama sesi --}}
                <h1 class="text-2xl font-bold text-gray-800">Proposal Masuk: {{ $comdev->nama_sesi }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="flex items-center text-sm text-gray-500">
                        <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-sky-600">Dashboard</a></li>
                        <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                        <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-sky-600">Manajemen Sesi Comdev</a></li>
                        <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                        <li class="font-semibold text-gray-700" aria-current="page">Daftar Proposal Masuk</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin_equity.comdev.show', $comdev->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class='bx bx-arrow-back text-lg mr-2'></i> Kembali ke Detail Sesi
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel Daftar Proposal (Submission) --}}
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class='bx bx-file-find text-xl mr-2 text-sky-600'></i>Daftar Proposal yang Diajukan
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Judul Proposal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Ketua Pengusul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal Diajukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Loop data submissions dari controller --}}
                    @forelse ($submissions as $submission)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 max-w-sm truncate">{{ $submission->judul }}</td>
                            {{-- Mengambil nama ketua dari relasi 'user' --}}
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $submission->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $submission->updated_at->isoFormat('D MMMM YYYY') }}</td>
                            <td class="px-6 py-4">
                                {{-- Contoh tampilan status, bisa disesuaikan --}}
                                @if($submission->status == 'diajukan')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diajukan</span>
                                @elseif($submission->status == 'sedang review')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Review</span>
                                @elseif($submission->status == 'lolos')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lolos</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($submission->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                {{-- Tombol aksi untuk melihat detail dan me-manage proposal --}}
                                <a href="{{ route('admin_equity.comdev.submissions.show', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}" class="inline-flex items-center px-3 py-1 bg-sky-600 text-white text-xs font-medium rounded hover:bg-sky-700">
                                    <i class='bx bx-search-alt mr-1'></i> Detail & Kelola
                                </a>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada proposal yang diajukan --}}
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class='bx bx-data text-4xl mb-2'></i>
                                    <p>Belum ada proposal yang diajukan untuk sesi ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if ($submissions->hasPages())
        <div class="p-4 border-t bg-gray-50">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection