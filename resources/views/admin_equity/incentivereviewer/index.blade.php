@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Insentif Reviewer</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Insentif Reviewer</h1>
                    <p class="mt-2 text-gray-600">Kelola pengajuan insentif untuk reviewer.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.incentivereviewer.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700">
                        <i class='bx bxs-add-to-queue mr-2 text-lg'></i>
                        Buat Pengajuan Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-list-ul mr-3 text-2xl'></i>
                    Daftar Pengajuan
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Reviewer</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Judul Artikel</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($submissions as $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5 font-semibold text-gray-900">{{ $submission->nama_reviewer }}</td>
                                <td class="px-6 py-5 text-sm text-gray-900">{{ $submission->judul_artikel }}</td>
                                <td class="px-6 py-5 text-sm text-gray-900">{{ \Carbon\Carbon::parse($submission->tanggal_pengajuan)->isoFormat('D MMM Y') }}</td>
                                <td class="px-6 py-5 text-center">
                                    @if ($submission->status === 'Disetujui')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class='bx bxs-check-circle mr-1.5'></i> {{ $submission->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            <i class='bx bxs-time-five mr-1.5'></i> {{ $submission->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin_equity.incentivereviewer.show', $submission->id) }}" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200" title="Lihat Detail">
                                            <i class='bx bx-show text-lg'></i>
                                        </a>
                                        <a href="{{ route('admin_equity.incentivereviewer.edit', $submission->id) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200" title="Edit">
                                            <i class='bx bxs-edit text-lg'></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin_equity.incentivereviewer.destroy', $submission->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200" title="Hapus">
                                               <i class='bx bxs-trash text-lg'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-20 px-6">
                                    <h3 class="font-bold text-xl text-gray-800">Belum Ada Pengajuan</h3>
                                    <p class="text-gray-500 mb-8">Buat pengajuan baru untuk memulai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
