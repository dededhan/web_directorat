@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Dashboard Reviewer | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6">

        {{-- Header Banner --}}
        <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg border border-gray-800 relative overflow-hidden">
            <div class="absolute right-0 top-0 translate-x-8 -translate-y-8 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                <div>
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 mb-2 border border-amber-500/30">
                        <i class="fas fa-star mr-1.5 text-[10px]"></i> PANEL REVIEWER HACKATON
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h1>
                    <p class="text-gray-300 text-sm mt-1">Kelola dan berikan evaluasi serta penilaian objektif untuk proposal tim Hackaton.</p>
                </div>
                <a href="{{ route('hackaton.reviewer.assignments.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold text-sm rounded-xl transition shadow">
                    <i class="fas fa-clipboard-check mr-2"></i> Mulai Penilaian
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            {{-- Assigned --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Proposal Ditugaskan</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $assigned }}</p>
                    <p class="text-xs text-gray-500 mt-1">Proposal yang dialokasikan ke Anda</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>

            {{-- Reviewed --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sudah Dinilai</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $reviewed }}</p>
                    <p class="text-xs text-gray-500 mt-1">Proposal selesai dinilai</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu Penilaian</p>
                    <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $pending }}</p>
                    <p class="text-xs text-gray-500 mt-1">Perlu ditindaklanjuti</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        {{-- Guide & Action --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle text-amber-500"></i> Panduan Singkat Reviewer
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-gray-600">
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-800 font-bold mb-2">1</span>
                    <h3 class="font-bold text-gray-800 mb-1">Periksa Berkas &amp; Tahapan</h3>
                    <p>Buka detail proposal dan tinjau berkas serta isian form per tahapan (Tahap 1 Ideation, Tahap 2 MVP, dan Tahap 3 Final).</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-800 font-bold mb-2">2</span>
                    <h3 class="font-bold text-gray-800 mb-1">Beri Skor &amp; Masukan</h3>
                    <p>Masukkan nilai 0 – 100 beserta catatan masukan/evaluasi konstruktif untuk setiap tahapan yang diajukan.</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-800 font-bold mb-2">3</span>
                    <h3 class="font-bold text-gray-800 mb-1">Simpan Penilaian</h3>
                    <p>Nilai akan otomatis terekap ke dalam peringkat skor sesi Hackaton untuk diputuskan kelolosannya oleh administrator.</p>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-500">Ingin melihat daftar proposal yang ditugaskan sekarang?</p>
                <a href="{{ route('hackaton.reviewer.assignments.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition">
                    Lihat Semua Penugasan <i class="fas fa-arrow-right ml-1.5"></i>
                </a>
            </div>
        </div>

    </div>
@endsection
