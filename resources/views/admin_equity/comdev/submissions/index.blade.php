@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header dan Breadcrumbs --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi Comdev</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800" aria-current="page">Proposal Masuk</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Proposal Masuk</h1>
                    <p class="mt-2 text-gray-600 text-base">Sesi: <span class="font-semibold text-teal-600">{{ $comdev->nama_sesi }}</span></p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.comdev.show', $comdev->id) }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                        <i class='bx bx-arrow-back text-lg mr-2'></i> Kembali
                    </a>
                </div>
            </div>
        </header>

        {{-- Daftar Proposal --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                        <i class='bx bx-file-find mr-3 text-2xl'></i>
                        Daftar Proposal Diajukan
                    </h2>
                    <div class="text-teal-100 text-sm">
                        Total: <span class="font-semibold text-white">{{ $submissions->total() }} proposal</span>
                    </div>
                </div>
            </div>

            {{-- Tampilan Tabel untuk Desktop --}}
            <div class="hidden lg:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Judul Proposal</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Ketua Pengusul</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal Diajukan</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($submissions as $submission)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5 text-sm text-gray-500">{{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}</td>
                                    <td class="px-6 py-5 text-sm font-semibold text-gray-900 max-w-md" title="{{ $submission->judul }}">
                                        <p class="truncate">{{ $submission->judul }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-600">{{ $submission->user->name }}</td>
                                    <td class="px-6 py-5 text-sm text-gray-600">{{ $submission->updated_at->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                                    <td class="px-6 py-5 text-center">
                                        @if($submission->status == 'diajukan')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Diajukan</span>
                                        @elseif($submission->status == 'sedang review')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">Review</span>
                                        @elseif($submission->status == 'lolos')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">Lolos</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">{{ ucfirst($submission->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <a href="{{ route('admin_equity.comdev.submissions.show', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-xs rounded-lg hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                                            <i class='bx bx-search-alt mr-1.5'></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-20 px-6">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mb-6">
                                                <i class='bx bx-data text-4xl text-gray-400'></i>
                                            </div>
                                            <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Proposal</h3>
                                            <p class="text-gray-500">Saat ini belum ada proposal yang diajukan untuk sesi ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tampilan Kartu untuk Mobile --}}
            <div class="lg:hidden">
                @forelse ($submissions as $submission)
                    <div class="p-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-semibold text-gray-900 text-sm leading-snug flex-1 mr-3">{{ $submission->judul }}</h3>
                            @if($submission->status == 'diajukan')
                                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">Diajukan</span>
                            @elseif($submission->status == 'sedang review')
                                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Review</span>
                            @elseif($submission->status == 'lolos')
                                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">Lolos</span>
                            @else
                                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">{{ ucfirst($submission->status) }}</span>
                            @endif
                        </div>
                        <div class="space-y-2 text-xs text-gray-600 mb-4">
                            <p class="flex items-center"><i class='bx bxs-user-circle mr-2 text-gray-400'></i>{{ $submission->user->name }}</p>
                            <p class="flex items-center"><i class='bx bxs-calendar mr-2 text-gray-400'></i>{{ $submission->updated_at->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        </div>
                        <a href="{{ route('admin_equity.comdev.submissions.show', ['comdev' => $comdev->id, 'submission' => $submission->id]) }}" class="w-full text-center inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-xs rounded-lg hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                            <i class='bx bx-search-alt mr-1.5'></i> Detail & Kelola
                        </a>
                    </div>
                @empty
                    <div class="text-center py-16 px-4">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <i class='bx bx-data text-3xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Belum Ada Proposal</h3>
                            <p class="text-gray-500 text-sm text-center max-w-xs">Saat ini belum ada proposal yang diajukan untuk sesi ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($submissions->hasPages())
                <div class="p-4 sm:p-6 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection