@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8">
        
        <!-- Header Section -->
        <header class="mb-6 sm:mb-8 lg:mb-10">
            <!-- Breadcrumb Navigation -->
            <nav class="text-xs sm:text-sm text-gray-500 mb-3 sm:mb-4" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center space-x-1 sm:space-x-2">
                    <li>
                        <a href="#" class="hover:text-teal-600 transition-colors duration-200 flex items-center">
                            <i class='bx bx-home text-sm sm:text-base mr-1'></i>
                            <span class="hidden xs:inline">Home</span>
                        </a>
                    </li>
                    <li><i class='bx bx-chevron-right text-sm text-gray-400'></i></li>
                    <li class="font-medium text-gray-800 text-xs sm:text-sm">Pilih Sesi Matchmaking</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-white/20 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">
                            <i class='bx bx-network-chart text-teal-600 mr-2 sm:mr-3'></i>
                            Usulkan Proposal Matchmaking
                        </h1>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            Pilih salah satu sesi yang tersedia untuk mengajukan proposal penelitian Anda.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <div class="flex items-center text-xs sm:text-sm text-teal-600 bg-teal-50 px-3 py-2 rounded-full">
                            <i class='bx bx-info-circle mr-1'></i>
                            <span class="font-medium">{{ count($sessions) }} Sesi Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sessions List -->
        <div class="space-y-4 sm:space-y-6">
            @forelse ($sessions as $index => $session)
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-sm hover:shadow-xl border border-white/40 hover:border-teal-200/60 transition-all duration-300 overflow-hidden">
                <!-- Session Card Content -->
                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Session Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 sm:mb-6">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl mr-3 flex-shrink-0">
                                    <span class="text-white font-bold text-sm sm:text-base">{{ $index + 1 }}</span>
                                </div>
                                <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 group-hover:text-teal-700 transition-colors duration-300">
                                    {{ $session->nama_sesi }}
                                </h2>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="mt-2 sm:mt-0 sm:ml-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                <i class='bx bx-check-circle mr-1'></i>
                                Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Session Details -->
                    <div class="bg-gradient-to-r from-gray-50 to-teal-50/30 rounded-xl sm:rounded-2xl p-4 sm:p-5 border border-gray-100/60">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Date Range -->
                            <div class="space-y-2">
                                <div class="flex items-center text-xs sm:text-sm text-gray-500 font-semibold uppercase tracking-wider">
                                    <i class='bx bx-calendar mr-2 text-teal-500'></i>
                                    Periode Pengajuan
                                </div>
                                <div class="text-sm sm:text-base font-semibold text-gray-800">
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <span>{{ \Carbon\Carbon::parse($session->tanggal_mulai)->isoFormat('D MMM YYYY') }}</span>
                                        <span class="hidden sm:inline mx-2 text-gray-400">—</span>
                                        <span class="sm:hidden text-gray-400 text-xs">sampai</span>
                                        <span>{{ \Carbon\Carbon::parse($session->tanggal_selesai)->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Duration Info -->
                            <div class="space-y-2">
                                <div class="flex items-center text-xs sm:text-sm text-gray-500 font-semibold uppercase tracking-wider">
                                    <i class='bx bx-time mr-2 text-teal-500'></i>
                                    Durasi
                                </div>
                                <div class="text-sm sm:text-base font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($session->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($session->tanggal_selesai)) + 1 }} Hari
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Section -->
                <div class="bg-gradient-to-r from-gray-50/80 to-teal-50/80 backdrop-blur-sm px-4 sm:px-6 lg:px-8 py-4 sm:py-5 border-t border-gray-100/60">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs sm:text-sm text-gray-600">
                            <i class='bx bx-lightbulb mr-1 text-yellow-500'></i>
                            Klik tombol untuk memulai pengajuan proposal
                        </div>
                        
                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.form', $session->id) }}" 
                           class="group/btn inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold rounded-xl sm:rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-teal-200">
                            <i class='bx bx-plus-circle mr-2 text-lg group-hover/btn:rotate-90 transition-transform duration-300'></i>
                            <span class="text-sm sm:text-base">Ajukan Proposal di Sesi Ini</span>
                            <i class='bx bx-right-arrow-alt ml-2 text-lg group-hover/btn:translate-x-1 transition-transform duration-300'></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-sm border border-gray-100/60 text-center py-12 sm:py-16 lg:py-20 px-4 sm:px-6">
                <div class="max-w-md mx-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                        <i class='bx bx-folder-open text-3xl sm:text-4xl text-gray-400'></i>
                    </div>
                    <h3 class="font-bold text-lg sm:text-xl text-gray-800 mb-2 sm:mb-3">
                        Tidak Ada Sesi Tersedia
                    </h3>
                    <p class="text-sm sm:text-base text-gray-500 leading-relaxed mb-6">
                        Saat ini belum ada sesi matchmaking riset yang dibuka. Silakan periksa kembali nanti atau hubungi administrator.
                    </p>
                    <button class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class='bx bx-refresh mr-2'></i>
                        Refresh Halaman
                    </button>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Footer Info -->
        @if(count($sessions) > 0)
        <div class="mt-8 sm:mt-10 lg:mt-12">
            <div class="bg-teal-50/60 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-teal-100/60">
                <div class="flex flex-col sm:flex-row sm:items-center">
                    <div class="flex items-center mb-2 sm:mb-0 sm:mr-4">
                        <i class='bx bx-info-circle text-teal-600 text-xl mr-2'></i>
                        <span class="font-semibold text-teal-800 text-sm sm:text-base">Informasi Penting</span>
                    </div>
                    <p class="text-xs sm:text-sm text-teal-700 leading-relaxed">
                        Pastikan untuk membaca panduan pengajuan proposal sebelum melanjutkan proses submit.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Custom Styles for Better Mobile Experience -->
<style>
@media (max-width: 475px) {
    .xs\:inline {
        display: inline;
    }
}

@media (max-width: 640px) {
    .group/btn:hover {
        transform: none;
    }
    
    .group/btn:active {
        transform: scale(0.98);
    }
}

/* Smooth animations for better UX */
* {
    scroll-behavior: smooth;
}

.group:hover .group-hover\:rotate-90 {
    transform: rotate(90deg);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}
</style>
@endsection