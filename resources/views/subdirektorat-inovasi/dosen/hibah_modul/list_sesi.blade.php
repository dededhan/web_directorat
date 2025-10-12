@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.manage') }}" class="hover:text-teal-600 transition-colors duration-200">Hibah Modul Ajar</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Sesi Hibah</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Sesi Hibah Modul Ajar</h1>
                    <p class="mt-2 text-gray-600 text-base">Pilih sesi yang tersedia untuk mengajukan proposal modul ajar Anda.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.manage') }}" class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i>
                        Kembali
                    </a>
                </div>
            </div>
        </header>

        {{-- Sessions List --}}
        <div class="space-y-8">
            @forelse($sessions as $session)
            @php
                $today = now();
                $daysLeft = $today->diffInDays($session->periode_akhir, false);
                $isOpen = $daysLeft > 0 && $session->status === 'dibuka';
            @endphp

            {{-- Session Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                
                {{-- Session Header --}}
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                                <i class='bx bx-calendar-event mr-3 text-2xl'></i>
                                {{ $session->nama_sesi }}
                            </h2>
                            <p class="mt-2 text-teal-100">{{ $session->deskripsi }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            @if($isOpen)
                            <div class="bg-green-100 text-green-800 px-4 py-2.5 rounded-xl border-2 border-green-200">
                                <p class="text-xs font-bold uppercase tracking-wide">Status</p>
                                <p class="text-sm font-semibold flex items-center">
                                    <i class='bx bxs-circle text-green-500 mr-1 text-xs animate-pulse'></i>
                                    Sedang Dibuka
                                </p>
                            </div>
                            @else
                            <div class="bg-red-100 text-red-800 px-4 py-2.5 rounded-xl border-2 border-red-200">
                                <p class="text-xs font-bold uppercase tracking-wide">Status</p>
                                <p class="text-sm font-semibold">Ditutup</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Session Details --}}
                <div class="px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class='bx bx-calendar text-orange-500 mr-2 text-lg'></i>
                                <span class="font-medium">Periode Pendaftaran:</span>
                                <span class="ml-2 font-semibold text-gray-800">
                                    {{ $session->periode_awal->format('d M Y') }} - {{ $session->periode_akhir->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class='bx bx-time-five text-blue-500 mr-2 text-lg'></i>
                                <span class="font-medium">Waktu Tersisa:</span>
                                @if($daysLeft > 0)
                                    <span class="ml-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                                        {{ $daysLeft }} hari lagi
                                    </span>
                                @else
                                    <span class="ml-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                        Sudah ditutup
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            @if($isOpen)
                            <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.create', $session->id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                Usulkan Proposal
                            </a>
                            @else
                            <button disabled class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-500 font-semibold rounded-xl cursor-not-allowed">
                                <i class='bx bx-lock mr-2 text-lg'></i>
                                Sesi Ditutup
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="text-center py-20 px-6">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                            <i class='bx bx-calendar-x text-4xl text-gray-400'></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Sesi Tersedia</h3>
                        <p class="text-gray-500 mb-2">Saat ini belum ada sesi hibah modul ajar yang dibuka.</p>
                        <p class="text-gray-400 text-sm">Silakan cek kembali nanti atau hubungi admin.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
