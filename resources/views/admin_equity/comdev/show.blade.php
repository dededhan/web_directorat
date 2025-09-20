@extends('admin_equity.index')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Breadcrumbs --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Sesi Proposal</h1>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-sky-600">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-sky-600">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Detail Sesi</li>
            </ol>
        </nav>
    </div>

    {{-- Session Details --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $session->nama_sesi }}
            </h2>
            <div>
                 @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tutup</span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buka</span>
                @endif
            </div>
        </div>
        <div class="p-8 space-y-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                <p class="mt-1 text-md text-gray-900">{{ $session->deskripsi ?: '-' }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Dana Maksimal</h3>
                    <p class="mt-1 text-md text-gray-900">Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Periode Submit</h3>
                    <p class="mt-1 text-md text-gray-900">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMMM Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM Y') }}</p>
                </div>
                 <div>
                    <h3 class="text-sm font-medium text-gray-500">Jumlah Anggota Tim</h3>
                    <p class="mt-1 text-md text-gray-900">{{ $session->min_anggota }} - {{ $session->max_anggota }} orang</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="bg-gray-50 px-8 py-4 border-t flex items-center justify-end space-x-4">
             <a href="{{ route('admin_equity.comdev.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class='bx bx-arrow-back text-lg mr-2'></i> Kembali ke Daftar
            </a>
            <a href="{{ route('admin_equity.comdev.edit', $session->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                <i class='bx bxs-edit text-lg mr-2'></i> Edit Sesi
            </a>
        </div>
    </div>
</div>
@endsection
