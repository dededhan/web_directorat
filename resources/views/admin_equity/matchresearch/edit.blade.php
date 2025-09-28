@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">

        <header class="mb-6 sm:mb-8">
            <!-- Mobile-optimized breadcrumb -->
            <nav class="text-xs sm:text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-1 sm:space-x-2 flex-wrap">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-sm sm:text-base text-gray-400'></i></li>
                    <li class="hidden sm:inline"><a href="{{ route('admin_equity.matchresearch.index') }}" class="hover:text-teal-600">Manajemen Sesi</a></li>
                    <li class="sm:hidden"><a href="{{ route('admin_equity.matchresearch.index') }}" class="hover:text-teal-600">Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-sm sm:text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Edit Sesi</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 leading-tight">Edit Sesi Matchmaking</h1>
                <p class="mt-2 text-sm sm:text-base text-gray-600">Lakukan perubahan pada detail sesi.</p>
            </div>
        </header>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Mobile-optimized header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                <h2 class="text-lg sm:text-xl font-bold text-white flex items-center">
                    <i class='bx bxs-edit text-xl sm:text-2xl mr-2 sm:mr-3'></i>
                    <span class="hidden sm:inline">Formulir Edit Sesi</span>
                    <span class="sm:hidden">Edit Sesi</span>
                </h2>
            </div>
            
            <form method="POST" action="{{ route('admin_equity.matchresearch.update', $session->id) }}">
                @csrf
                @method('PUT')
                <div class="p-4 sm:p-6 lg:p-8 space-y-6">
                    
                    <!-- Nama Sesi -->
                    <div>
                        <label for="nama_sesi" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Sesi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_sesi" 
                            id="nama_sesi" 
                            class="w-full text-sm sm:text-base text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200" 
                            value="{{ old('nama_sesi', $session->nama_sesi) }}" 
                            required
                        >
                        @error('nama_sesi')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Date inputs - Stack on mobile, side by side on larger screens -->
                    <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-1 md:grid-cols-2 sm:gap-4">
                        <div>
                            <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="date" 
                                    name="periode_awal" 
                                    id="periode_awal" 
                                    class="w-full text-sm sm:text-base text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200" 
                                    value="{{ old('periode_awal', $session->periode_awal ? \Carbon\Carbon::parse($session->periode_awal)->format('Y-m-d') : '') }}" 
                                    required
                                >
                                <i class='bx bx-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none'></i>
                            </div>
                            @error('periode_awal')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="date" 
                                    name="periode_akhir" 
                                    id="periode_akhir" 
                                    class="w-full text-sm sm:text-base text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200" 
                                    value="{{ old('periode_akhir', $session->periode_akhir ? \Carbon\Carbon::parse($session->periode_akhir)->format('Y-m-d') : '') }}" 
                                    required
                                >
                                <i class='bx bx-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none'></i>
                            </div>
                            @error('periode_akhir')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Status Sesi -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Sesi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select 
                                name="status" 
                                id="status" 
                                class="w-full text-sm sm:text-base text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 appearance-none" 
                                required
                            >
                                <option value="Buka" {{ old('status', $session->status) == 'Buka' ? 'selected' : '' }}>
                                    Buka
                                </option>
                                <option value="Tutup" {{ old('status', $session->status) == 'Tutup' ? 'selected' : '' }}>
                                    Tutup
                                </option>
                            </select>
                            <i class='bx bx-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none'></i>
                        </div>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Mobile-optimized action buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end p-4 sm:p-6 bg-gray-50/50 border-t space-y-3 sm:space-y-0 sm:space-x-3">
                    <a 
                        href="{{ route('admin_equity.matchresearch.index') }}" 
                        class="w-full sm:w-auto px-6 py-3 sm:py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 text-center transition-colors duration-200 order-2 sm:order-1"
                    >
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 sm:py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-colors duration-200 order-1 sm:order-2"
                    >
                        <i class='bx bx-save text-lg mr-2'></i> 
                        <span class="hidden sm:inline">Simpan Perubahan</span>
                        <span class="sm:hidden">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mobile-specific JavaScript for better UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date input validation
    const startDate = document.getElementById('periode_awal');
    const endDate = document.getElementById('periode_akhir');
    
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = '';
        }
    });
    
    endDate.addEventListener('change', function() {
        if (startDate.value && this.value < startDate.value) {
            alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai');
            this.value = '';
        }
    });
    
    // Mobile-friendly form submission feedback
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function() {
        if (window.innerWidth < 640) {
            submitBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin text-lg mr-2"></i> Menyimpan...';
            submitBtn.disabled = true;
        }
    });
});
</script>
@endsection