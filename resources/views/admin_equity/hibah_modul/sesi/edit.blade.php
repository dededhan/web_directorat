@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.hibah_modul.sesi.index') }}" class="hover:text-teal-600">Hibah Modul</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Edit Sesi</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-800">Edit Sesi Hibah Modul</h1>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form action="{{ route('admin_equity.hibah_modul.sesi.update', $sesi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="nama_sesi" class="block text-sm font-semibold text-gray-700 mb-2">Nama Sesi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_sesi" id="nama_sesi" value="{{ old('nama_sesi', $sesi->nama_sesi) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('deskripsi', $sesi->deskripsi) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="periode_awal" class="block text-sm font-semibold text-gray-700 mb-2">Periode Awal <span class="text-red-500">*</span></label>
                            <input type="date" name="periode_awal" id="periode_awal" value="{{ old('periode_awal', $sesi->periode_awal->format('Y-m-d')) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <div>
                            <label for="periode_akhir" class="block text-sm font-semibold text-gray-700 mb-2">Periode Akhir <span class="text-red-500">*</span></label>
                            <input type="date" name="periode_akhir" id="periode_akhir" value="{{ old('periode_akhir', $sesi->periode_akhir->format('Y-m-d')) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            <option value="dibuka" {{ old('status', $sesi->status) === 'dibuka' ? 'selected' : '' }}>Dibuka</option>
                            <option value="ditutup" {{ old('status', $sesi->status) === 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t">
                    <a href="{{ route('admin_equity.hibah_modul.sesi.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-lg hover:from-teal-600 hover:to-teal-700 shadow-md">
                        <i class='bx bx-save mr-2'></i> Update Sesi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
