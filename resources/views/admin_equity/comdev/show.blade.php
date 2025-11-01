@extends('admin_equity.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumbs --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Detail Sesi Proposal</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-[#11A697]">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-[#11A697]">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Detail Sesi</li>
            </ol>
        </nav>
    </div>

    {{-- Session Details Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="p-5 border-b bg-[#11A697] text-white flex justify-between items-center">
            <h2 class="text-xl font-semibold">
                {{ $session->nama_sesi }}
            </h2>
            <div>
                 @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                    {{-- Status badge ini sengaja tidak diubah warnanya karena sudah universal (merah=berhenti/tutup) --}}
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tutup</span>
                @else
                    {{-- Status badge ini sengaja tidak diubah warnanya karena sudah universal (hijau=aktif/buka) --}}
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buka</span>
                @endif
            </div>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                <p class="mt-1 text-md text-gray-800 leading-relaxed">{{ $session->deskripsi ?: '-' }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Dana Maksimal</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Periode Submit</h3>
                    <p class="mt-1 text-md font-semibold text-gray-900">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMMM Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM Y') }}</p>
                </div>
                 <div>
                    <h3 class="text-sm font-medium text-gray-500">Jumlah Anggota Tim</h3>
                    <p class="mt-1 text-md font-semibold text-gray-900">{{ $session->min_anggota }} - {{ $session->max_anggota }} orang</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="bg-gray-50 px-6 py-4 border-t flex items-center justify-end space-x-3">
             <a href="{{ route('admin_equity.comdev.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition">
                <i class='bx bx-arrow-back text-lg mr-2'></i> Kembali
            </a>
                                        @if(auth()->user()->role !== 'sub_admin_equity')
            <a href="{{ route('admin_equity.comdev.edit', $session->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                <i class='bx bxs-edit text-lg mr-2'></i> Edit Sesi
            </a>
                @endif

            <a href="{{ route('admin_equity.comdev.submissions.index', $session->id) }}" class="inline-flex items-center px-4 py-2 bg-[#11A697] border border-transparent rounded-md font-semibold text-sm text-white hover:bg-[#0e8a7c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#11A697] transition">
                <i class='bx bx-file-find text-lg mr-2'></i> Lihat Proposal Masuk
            </a>
        </div>
    </div>
</div>
@endsection