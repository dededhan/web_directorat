@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Sesi Hibah Modul Ajar</h1>
            <p class="mt-2 text-gray-600">Pilih sesi yang tersedia untuk mengajukan proposal modul ajar</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($sessions as $session)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">{{ $session->nama_sesi }}</h3>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-600 mb-4">{{ Str::limit($session->deskripsi, 100) }}</p>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class='bx bx-calendar text-orange-500 mr-2'></i>
                            <span>{{ $session->periode_awal->format('d M Y') }} - {{ $session->periode_akhir->format('d M Y') }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm">
                            @php
                                $today = now();
                                $daysLeft = $today->diffInDays($session->periode_akhir, false);
                            @endphp
                            @if($daysLeft > 0)
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <i class='bx bx-time-five mr-1'></i>{{ $daysLeft }} hari lagi
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                    <i class='bx bx-x-circle mr-1'></i>Sudah ditutup
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if($daysLeft > 0 && $session->status === 'dibuka')
                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.create', $session->id) }}" class="block w-full px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-center font-semibold rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all">
                        <i class='bx bx-plus-circle mr-2'></i>Usulkan Proposal
                    </a>
                    @else
                    <button disabled class="block w-full px-4 py-2 bg-gray-300 text-gray-500 text-center font-semibold rounded-lg cursor-not-allowed">
                        Sesi Ditutup
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-xl shadow-md p-12 text-center">
                <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                <p class="text-gray-500 text-lg font-medium">Belum ada sesi hibah modul yang dibuka</p>
                <p class="text-gray-400 text-sm mt-2">Silakan cek kembali nanti</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
