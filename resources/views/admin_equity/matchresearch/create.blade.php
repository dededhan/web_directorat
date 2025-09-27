@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.index') }}" class="hover:text-teal-600">Manajemen Sesi Matchmaking</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Buat Sesi Baru</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Buat Sesi Matchmaking Baru</h1>
                <p class="mt-2 text-gray-600">Isi formulir untuk menambahkan sesi baru.</p>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <form method="POST" action="{{ route('admin_equity.matchresearch.store') }}">
                @csrf
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <div class="md:col-span-2">
                            <label for="nama_sesi" class="block text-sm font-medium text-gray-700 mb-2">Nama Sesi</label>
                            <input type="text" name="nama_sesi" id="nama_sesi" value="{{ old('nama_sesi') }}" class="py-3 px-4 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500" placeholder="Contoh: Matchmaking Gelombang 1 2025" required>
                            @error('nama_sesi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
 
                            <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="periode_awal" id="periode_awal" value="{{ old('periode_awal') }}" class="py-3 px-4 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500" required>
                            @error('periode_awal')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>

                            <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" name="periode_akhir" id="periode_akhir" value="{{ old('periode_akhir') }}" class="py-3 px-4 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500" required>
                            @error('periode_akhir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="p-4 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500" placeholder="Jelaskan tujuan sesi ini...">{{ old('deskripsi') }}</textarea>
                             @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end p-6 bg-gray-50 rounded-b-2xl space-x-3">
                    <a href="{{ route('admin_equity.matchresearch.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Sesi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
