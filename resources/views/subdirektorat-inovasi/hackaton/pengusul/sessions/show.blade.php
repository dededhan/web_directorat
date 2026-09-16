@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', $session->nama_sesi . ' | Hackaton UNJ')

@section('content_hackaton')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.sessions.index') }}" class="hover:text-amber-600">Sesi Hackaton</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-800 font-medium">Detail Sesi</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">{{ $session->nama_sesi }}</h1>
            </div>
            <a href="{{ route('hackaton.sessions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali
            </a>
        </div>

        {{-- Sesi Info Banner --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-6">
            @if ($session->deskripsi)
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Deskripsi & Petunjuk</h2>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $session->deskripsi }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-gray-100 text-xs">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <span class="text-gray-400 font-bold uppercase text-[10px] block">Jadwal Sesi</span>
                    <span class="font-bold text-gray-900 mt-1 block">
                        {{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}
                    </span>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <span class="text-gray-400 font-bold uppercase text-[10px] block">Jumlah Anggota</span>
                    <span class="font-bold text-gray-900 mt-1 block">
                        {{ $session->min_anggota }} - {{ $session->max_anggota }} Orang per Tim
                    </span>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <span class="text-gray-400 font-bold uppercase text-[10px] block">Plafon Pendanaan</span>
                    <span class="font-bold text-gray-900 mt-1 block">
                        @if ($session->dana_maksimal)
                            Hingga Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}
                        @else
                            Sesuai Ketentuan
                        @endif
                    </span>
                </div>
            </div>

            {{-- Action Registration --}}
            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                @if ($existingSubmission)
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                            <i class="fas fa-check"></i>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Anda sudah memiliki proposal pada sesi ini.</p>
                            <p class="text-xs text-gray-500">Status: <strong class="text-emerald-700 uppercase">{{ $existingSubmission->status->value ?? $existingSubmission->status }}</strong></p>
                        </div>
                    </div>
                    <a href="{{ route('hackaton.submissions.show', $existingSubmission) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-gray-800 transition shadow">
                        Buka Proposal Saya <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @else
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Siap mengajukan proposal inovasi?</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Sistem akan menginisiasi 3 tahapan pengajuan yang perlu Anda lengkapi bersama tim.</p>
                    </div>
                    <form action="{{ route('hackaton.submissions.store', $session) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-amber-500 text-gray-900 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-amber-600 transition shadow">
                            <i class="fas fa-plus mr-2"></i> Buat Proposal Baru
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- 3 Tahapan Overview --}}
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-stream text-amber-500"></i> Alur 3 Tahapan Evaluasi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($session->tahap as $thp)
                    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-gray-900 text-white font-black text-xs flex items-center justify-center">
                                {{ $thp->tahap_ke }}
                            </span>
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                {{ $thp->fields->count() }} Field
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">{{ $thp->nama_tahap }}</h3>
                            @if ($thp->deskripsi)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $thp->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
