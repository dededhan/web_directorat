@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.index') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800" aria-current="page">Buat Sesi Baru</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Buat Sesi APC Baru</h1>
                <p class="mt-2 text-gray-600 text-base">Isi formulir di bawah ini untuk menambahkan sesi pendanaan APC baru.</p>
            </div>
        </header>

        {{-- Form Container --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 sm:px-8 py-5">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bxs-add-to-queue text-2xl mr-3'></i>
                    Formulir Sesi APC Baru
                </h2>
            </div>

            <form method="POST" action="{{ route('admin_equity.apc.store') }}">
                @csrf
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- Left Column --}}
                        <div class="space-y-6">
                            <div>
                                <label for="nama_sesi" class="block text-sm font-medium text-gray-700 mb-2">Nama Sesi</label>
                                <div class="relative">
                                    <i class='bx bx-file-blank absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                                    <input type="text" name="nama_sesi" id="nama_sesi" class="pl-10 pr-4 py-3 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition" placeholder="Contoh: APC Gelombang 1 2025" value="{{ old('nama_sesi') }}" required>
                                </div>
                                @error('nama_sesi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat (Opsional)</label>
                                <textarea name="deskripsi" id="deskripsi" rows="8" class="p-4 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition" placeholder="Jelaskan tujuan dan ruang lingkup sesi ini...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-6">
                            <div>
                                <label for="dana_display" class="block text-sm font-medium text-gray-700 mb-2">Total Dana Sesi</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="text" id="dana_display" class="pl-9 pr-4 py-3 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition" placeholder="50.000.000" value="{{ old('dana') ? number_format(old('dana'), 0, ',', '.') : '' }}" required>
                                    <input type="hidden" name="dana" id="dana" value="{{ old('dana') }}">
                                </div>
                                @error('dana')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Periode Pengajuan</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <i class='bx bx-calendar-play absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                                        <input type="date" name="periode_awal" class="pl-10 pr-4 py-3 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition" value="{{ old('periode_awal') }}" required>
                                    </div>
                                    <div class="relative">
                                        <i class='bx bx-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                                        <input type="date" name="periode_akhir" class="pl-10 pr-4 py-3 w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition" value="{{ old('periode_akhir') }}" required>
                                    </div>
                                </div>
                                @error('periode_awal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                @error('periode_akhir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4 p-6 sm:p-8 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl space-x-3">
                    <a href="{{ route('admin_equity.apc.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Sesi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const displayInput = document.getElementById('dana_display');
    const hiddenInput = document.getElementById('dana');
    if (displayInput && hiddenInput) {
        function formatNumber(value) {
            return String(value).replace(/[^,\d]/g, '').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        function unformatNumber(value) {
            return String(value).replace(/\./g, '');
        }
        displayInput.addEventListener('input', function(e) {
            let formattedValue = formatNumber(e.target.value);
            e.target.value = formattedValue;
            hiddenInput.value = unformatNumber(formattedValue);
        });
        if (displayInput.value) {
            displayInput.value = formatNumber(displayInput.value);
        }
    }
});
</script>
@endpush
