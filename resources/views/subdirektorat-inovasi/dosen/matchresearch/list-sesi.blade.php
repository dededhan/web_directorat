@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="#" class="hover:text-teal-600">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Pilih Sesi Matchmaking</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Usulkan Proposal Matchmaking</h1>
                <p class="mt-2 text-gray-600">Pilih salah satu sesi yang tersedia untuk mengajukan proposal Anda.</p>
            </div>
        </header>

        <div class="space-y-8">
            @forelse ($sessions as $session)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow overflow-hidden flex flex-col">
                <div class="p-6 lg:p-8 flex-grow">
                     <h2 class="text-xl lg:text-2xl font-bold text-gray-800 flex items-center">
                        <i class='bx bx-calendar-event mr-3 text-2xl text-teal-500'></i>
                        {{ $session->nama_sesi }}
                    </h2>
                    <div class="mt-6 border-t-2 border-gray-100 pt-6">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Periode Pengajuan</p>
                        <p class="font-semibold text-gray-800 text-base">
                            {{ \Carbon\Carbon::parse($session->tanggal_mulai)->isoFormat('D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($session->tanggal_selesai)->isoFormat('D MMMM YYYY') }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-gray-50/70 px-6 lg:px-8 py-5 border-t border-gray-100">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.form', $session->id) }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700">
                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                        Ajukan Proposal di Sesi Ini
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 text-center py-20 px-6">
                <i class='bx bx-folder-open text-5xl text-gray-300'></i>
                <h3 class="font-bold text-xl text-gray-800 mt-4">Tidak Ada Sesi Tersedia</h3>
                <p class="text-gray-500 max-w-md mx-auto mt-2">Saat ini belum ada sesi matchmaking riset yang dibuka. Silakan periksa kembali nanti.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

