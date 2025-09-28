@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.incentivereviewer.index') }}" class="hover:text-teal-600">Insentif Reviewer</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Pengajuan</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Pengajuan Insentif</h1>
                    <p class="mt-2 text-gray-600">Rincian lengkap dari pengajuan insentif.</p>
                </div>
                <a href="{{ route('admin_equity.incentivereviewer.edit', $submission->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600">
                    <i class='bx bxs-edit mr-2'></i> Edit
                </a>
            </div>
        </header>

        {{-- Details --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Left Column --}}
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase">Nama Reviewer</h3>
                            <p class="text-gray-800 font-semibold">{{ $submission->nama_reviewer }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase">Judul Artikel</h3>
                            <p class="text-gray-800">{{ $submission->judul_artikel }}</p>
                        </div>
                    </div>
                    {{-- Right Column --}}
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase">Tanggal Pengajuan</h3>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($submission->tanggal_pengajuan)->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase">Status</h3>
                            @if ($submission->status === 'Disetujui')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class='bx bxs-check-circle mr-1.5'></i> {{ $submission->status }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                    <i class='bx bxs-time-five mr-1.5'></i> {{ $submission->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Abstrak/Catatan --}}
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase">Abstrak/Catatan</h3>
                    <p class="text-gray-700 mt-2 text-justify">{{ $submission->abstrak ?? 'Tidak ada catatan atau abstrak yang diberikan.' }}</p>
                </div>
            </div>
            <div class="p-6 bg-gray-50/50 border-t text-right">
                <a href="{{ route('admin_equity.incentivereviewer.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">
                    <i class='bx bx-arrow-back mr-2'></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
