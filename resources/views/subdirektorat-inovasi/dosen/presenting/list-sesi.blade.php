@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Pilih Sesi Presenting</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Usulkan Laporan Presenting</h1>
                    <p class="mt-2 text-gray-600 text-base">Pilih salah satu sesi yang tersedia untuk mengajukan laporan Anda.</p>
                </div>
            </div>
        </header>

        {{-- Daftar Sesi --}}
        <div class="space-y-8">
            @forelse ($sessions as $session)
                @php
                    $isSessionOpen = \Carbon\Carbon::now()->isBefore(\Carbon\Carbon::parse($session->periode_akhir));
                @endphp
                
                {{-- Session Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all duration-300 overflow-hidden flex flex-col">
                    
                    {{-- Session Content --}}
                    <div class="p-6 lg:p-8 flex-grow">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                            <div class="flex-1">
                                <h2 class="text-xl lg:text-2xl font-bold text-gray-800 flex items-center">
                                    <i class='bx bx-calendar-event mr-3 text-2xl text-teal-500'></i>
                                    {{ $session->nama_sesi }}
                                </h2>
                                <p class="text-gray-600 mt-2 text-sm leading-relaxed">{{ $session->deskripsi }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                @if ($isSessionOpen)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border-2 border-green-200">
                                        <i class='bx bx-check-circle mr-1.5 text-sm'></i>
                                        Sesi Buka
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border-2 border-red-200">
                                        <i class='bx bx-x-circle mr-1.5 text-sm'></i>
                                        Sesi Ditutup
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-6 border-t-2 border-gray-100 pt-6 text-sm">
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200 max-w-md">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-4">
                                    <i class='bx bx-calendar-check text-blue-500 text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Batas Akhir Pelaporan</p>
                                    <p class="font-semibold text-gray-800 text-base">{{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM YYYY') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Session Footer/Action --}}
                    <div class="bg-gray-50/70 px-6 lg:px-8 py-5 border-t border-gray-100">
                        @if ($isSessionOpen)
                            <a href="{{ route('subdirektorat-inovasi.dosen.presenting.form', $session->id) }}" 
                               class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                Ajukan Laporan di Sesi Ini
                            </a>
                        @else
                            <button disabled 
                                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-xl cursor-not-allowed">
                                <i class='bx bx-lock mr-2 text-lg'></i>
                                Pelaporan Ditutup
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="text-center py-20 px-6">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                                <i class='bx bx-folder-open text-4xl text-gray-400'></i>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 mb-2">Tidak Ada Sesi Tersedia</h3>
                            <p class="text-gray-500 max-w-md">Saat ini belum ada sesi Presenting yang dibuka. Silakan periksa kembali nanti.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-white:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }
</style>
@endpush