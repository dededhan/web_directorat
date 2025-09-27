@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.matchresearch.index') }}" class="hover:text-teal-600">Manajemen Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Edit Sesi</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Sesi Matchmaking</h1>
                <p class="mt-2 text-gray-600">Lakukan perubahan pada detail sesi.</p>
            </div>
        </header>


        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
             <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 sm:px-8 py-5">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bxs-edit text-2xl mr-3'></i>
                    Formulir Edit Sesi
                </h2>
            </div>
            
            <form method="POST" action="{{ route('admin_equity.matchresearch.update', $session->id) }}">
                @csrf
                @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <label for="nama_sesi" class="block text-sm font-medium text-gray-700 mb-2">Nama Sesi</label>
                        <input type="text" name="nama_sesi" id="nama_sesi" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" value="{{ old('nama_sesi', $session->nama_sesi) }}" required>
                        @error('nama_sesi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
             
                            <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="periode_awal" id="periode_awal" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" value="{{ old('periode_awal', $session->periode_awal ? \Carbon\Carbon::parse($session->periode_awal)->format('Y-m-d') : '') }}" required>
                             @error('periode_awal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>

                            <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" name="periode_akhir" id="periode_akhir" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" value="{{ old('periode_akhir', $session->periode_akhir ? \Carbon\Carbon::parse($session->periode_akhir)->format('Y-m-d') : '') }}" required>
                             @error('periode_akhir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                     <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Sesi</label>
                        <select name="status" id="status" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" required>
                            <option value="Buka" {{ old('status', $session->status) == 'Buka' ? 'selected' : '' }}>Buka</option>
                            <option value="Tutup" {{ old('status', $session->status) == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                        </select>
                         @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>


                <div class="flex items-center justify-end p-6 bg-gray-50/50 border-t">
                    <a href="{{ route('admin_equity.matchresearch.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="ml-3 inline-flex items-center px-6 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
