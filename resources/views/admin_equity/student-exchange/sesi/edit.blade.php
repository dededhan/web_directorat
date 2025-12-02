@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.index') }}" class="hover:text-teal-600">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Edit Sesi</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Sesi Student Exchange</h1>
                <p class="mt-2 text-gray-600">Perbarui informasi sesi pertukaran mahasiswa</p>
            </div>
        </header>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-edit mr-3 text-2xl'></i>
                    Form Edit Sesi
                </h2>
            </div>

            <form action="{{ route('admin_equity.student_exchange.sesi.update', $sesi->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Sesi --}}
                <div class="space-y-2">
                    <label for="nama_sesi" class="block text-sm font-semibold text-gray-700">
                        Nama Sesi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_sesi" 
                           name="nama_sesi"
                           value="{{ old('nama_sesi', $sesi->nama_sesi) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('nama_sesi') border-red-500 @enderror"
                           placeholder="Contoh: Student Exchange 2025 Semester 1"
                           required>
                    @error('nama_sesi')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('deskripsi') border-red-500 @enderror"
                              placeholder="Deskripsi singkat tentang sesi student exchange ini...">{{ old('deskripsi', $sesi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Periode --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Periode Awal --}}
                    <div class="space-y-2">
                        <label for="periode_awal" class="block text-sm font-semibold text-gray-700">
                            Periode Awal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="periode_awal" 
                               name="periode_awal"
                               value="{{ old('periode_awal', $sesi->periode_awal->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('periode_awal') border-red-500 @enderror"
                               required>
                        @error('periode_awal')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Periode Akhir --}}
                    <div class="space-y-2">
                        <label for="periode_akhir" class="block text-sm font-semibold text-gray-700">
                            Periode Akhir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="periode_akhir" 
                               name="periode_akhir"
                               value="{{ old('periode_akhir', $sesi->periode_akhir->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('periode_akhir') border-red-500 @enderror"
                               required>
                        @error('periode_akhir')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('status') border-red-500 @enderror"
                            required>
                        <option value="dibuka" {{ old('status', $sesi->status) == 'dibuka' ? 'selected' : '' }}>Dibuka</option>
                        <option value="ditutup" {{ old('status', $sesi->status) == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('admin_equity.student_exchange.sesi.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 focus:ring-4 focus:ring-teal-200 transition-all shadow-lg">
                        <i class='bx bx-save mr-2 text-lg'></i>
                        Update
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodeAwal = document.getElementById('periode_awal');
    const periodeAkhir = document.getElementById('periode_akhir');
    
    periodeAwal.addEventListener('change', function() {
        periodeAkhir.min = this.value;
    });
    
    periodeAkhir.addEventListener('change', function() {
        if (periodeAwal.value && this.value < periodeAwal.value) {
            alert('Periode akhir tidak boleh lebih awal dari periode awal');
            this.value = '';
        }
    });
});
</script>
@endpush
@endsection
