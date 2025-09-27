@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Usulkan Proposal APC</h1>
            <p class="mt-2 text-gray-600">Pilih salah satu sesi pendanaan Article Processing Cost yang tersedia untuk mengajukan proposal Anda.</p>
        </header>

        {{-- Daftar Sesi --}}
        <div class="space-y-6">
            @forelse ($sessions as $session)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-teal-700">{{ $session->nama_sesi }}</h2>
                        <p class="text-gray-600 mt-2 text-sm">{{ $session->deskripsi }}</p>
                        
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center">
                                <i class='bx bx-money text-green-500 text-xl mr-2'></i>
                                <div>
                                    <p class="font-semibold text-gray-700">Rp {{ number_format($session->dana, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Total Dana</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class='bx bx-calendar-check text-blue-500 text-xl mr-2'></i>
                                <div>
                                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM Y') }}</p>
                                    <p class="text-xs text-gray-500">Batas Akhir Pengajuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4">
                        <a href="{{ route('subdirektorat-inovasi.dosen.apc.form', $session->id) }}" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors">
                            <i class='bx bx-plus-circle mr-2'></i>
                            Ajukan Proposal di Sesi Ini
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg border">
                    <i class='bx bx-folder-open text-6xl text-gray-300'></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-700">Tidak Ada Sesi Tersedia</h3>
                    <p class="mt-2 text-gray-500">Saat ini belum ada sesi pendanaan APC yang dibuka.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
