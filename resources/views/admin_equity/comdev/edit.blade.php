@extends('admin_equity.index')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Breadcrumbs --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Sesi Proposal</h1>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-sky-600">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-sky-600">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Edit Sesi</li>
            </ol>
        </nav>
    </div>

    {{-- Edit Form --}}
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class='bx bxs-edit text-xl mr-2 text-sky-600'></i>Formulir Edit Sesi
            </h2>
        </div>
        <div class="p-8">
            <form method="POST" action="{{ route('admin_equity.comdev.update', $session->id) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    {{-- Left Column --}}
                    <div class="space-y-6">
                        <div>
                            <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi / Skema</label>
                            <input type="text" name="nama_sesi" id="nama_sesi" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="{{ old('nama_sesi', $session->nama_sesi) }}" required>
                             @error('nama_sesi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea name="deskripsi" id="deskripsi" rows="8" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">{{ old('deskripsi', $session->deskripsi) }}</textarea>
                             @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    {{-- Right Column --}}
                    <div class="space-y-6">
                        <div>
                            <label for="dana_maksimal" class="block text-sm font-medium text-gray-700">Dana Maksimal</label>
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500">Rp</span></div>
                                <input type="number" name="dana_maksimal" id="dana_maksimal" class="bg-gray-100 pl-8 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="{{ old('dana_maksimal', $session->dana_maksimal) }}" required>
                            </div>
                             @error('dana_maksimal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Periode Submit</label>
                            <div class="flex items-center mt-1 space-x-2">
                                <input type="date" name="periode_awal" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="{{ old('periode_awal', \Carbon\Carbon::parse($session->periode_awal)->format('Y-m-d')) }}" required>
                                <span class="text-gray-500">s/d</span>
                                <input type="date" name="periode_akhir" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="{{ old('periode_akhir', \Carbon\Carbon::parse($session->periode_akhir)->format('Y-m-d')) }}" required>
                            </div>
                            @error('periode_awal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            @error('periode_akhir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Anggota Tim</label>
                            <div class="flex items-center mt-1 space-x-2">
                                <input type="number" name="min_anggota" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Min" value="{{ old('min_anggota', $session->min_anggota) }}" required>
                                <span class="text-gray-500">-</span>
                                <input type="number" name="max_anggota" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Max" value="{{ old('max_anggota', $session->max_anggota) }}" required>
                            </div>
                             @error('min_anggota')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                             @error('max_anggota')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                {{-- Form Actions --}}
                <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200 space-x-4">
                    <a href="{{ route('admin_equity.comdev.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-sky-600 border border-transparent rounded-md font-semibold text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
