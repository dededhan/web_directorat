@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> / Detail
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">{{ $session->nama_sesi }}</h1>
                <p class="mt-2 text-base text-gray-700">
                    Periode: <strong class="text-black">{{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}</strong>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($session->status === 'draft')
                    <form action="{{ route('admin_hackaton.sessions.activate', $session) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                            <i class="fas fa-play"></i> Aktifkan Sesi
                        </button>
                    </form>
                @elseif ($session->status === 'active')
                    <form action="{{ route('admin_hackaton.sessions.close', $session) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menutup sesi ini?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                            <i class="fas fa-stop"></i> Tutup Sesi
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin_hackaton.submissions.index', $session) }}" class="bg-amber-500 hover:bg-amber-600 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-file-alt"></i> Lihat Proposal ({{ $session->submissions->count() }})
                </a>

                <a href="{{ route('admin_hackaton.submissions.scores', $session) }}" class="bg-white hover:bg-gray-100 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-trophy"></i> Ranking Nilai
                </a>

                <a href="{{ route('admin_hackaton.sessions.edit', $session) }}" class="bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Sesi
                </a>
            </div>
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Status Sesi</p>
                <div class="mt-2 flex items-center gap-2">
                    @if ($session->status === 'active')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                            AKTIF (DIBUKA)
                        </span>
                    @elseif ($session->status === 'closed')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black bg-rose-100 text-rose-800 border border-rose-300">
                            DITUTUP
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black bg-gray-100 text-gray-700 border border-gray-300">
                            DRAFT
                        </span>
                    @endif
                </div>
            </div>

            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Anggota Tim</p>
                <p class="mt-2 text-2xl font-black text-gray-950">
                    {{ $session->min_anggota }} — {{ $session->max_anggota }} <span class="text-sm font-semibold text-gray-600">orang</span>
                </p>
            </div>

            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Plafon Pendanaan</p>
                <p class="mt-2 text-sm font-black text-gray-950">
                    @if ($session->dana_minimal || $session->dana_maksimal)
                        Rp {{ number_format($session->dana_minimal ?? 0, 0, ',', '.') }} — Rp {{ number_format($session->dana_maksimal ?? 0, 0, ',', '.') }}
                    @else
                        <span class="text-gray-400 italic">Tidak ditetapkan</span>
                    @endif
                </p>
            </div>

            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Proposal</p>
                <p class="mt-2 text-2xl font-black text-gray-950">{{ $session->submissions->count() }}</p>
            </div>
        </div>

        @if ($session->deskripsi)
            <div class="border-2 border-gray-950 bg-white p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Petunjuk & Deskripsi Sesi</h3>
                <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">{{ $session->deskripsi }}</p>
            </div>
        @endif

        {{-- 3 Tahap Cards & Form Builder Section --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b-2 border-gray-950 pb-3">
                <div>
                    <h2 class="text-2xl font-black text-gray-950">Tahapan Evaluasi Hackaton</h2>
                    <p class="text-sm text-gray-600">Sistem terstruktur menjadi 3 tahap evaluasi bertingkat. Atur isian form tiap tahap.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach ($session->tahap as $tahap)
                    <div class="border-2 border-gray-950 bg-white flex flex-col justify-between overflow-hidden">
                        <div>
                            {{-- Header Card --}}
                            <div class="border-b-2 border-gray-950 bg-gray-100 p-5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-none bg-gray-950 text-white font-black text-sm flex items-center justify-center">
                                        {{ $tahap->tahap_ke }}
                                    </span>
                                    <div>
                                        <h3 class="font-black text-gray-950 text-base leading-tight">{{ $tahap->nama_tahap }}</h3>
                                        <span class="text-[10px] uppercase tracking-wider font-bold text-gray-500">
                                            Tahap {{ $tahap->tahap_ke }} of 3
                                        </span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-bold border border-gray-400 bg-white">
                                    {{ $tahap->getTimingStatus() === 'dibuka' ? 'Buka' : ($tahap->getTimingStatus() === 'ditutup' ? 'Tutup' : 'Belum Buka') }}
                                </span>
                            </div>

                            {{-- Body Card --}}
                            <div class="p-5 space-y-4 text-xs">
                                <div>
                                    <p class="font-bold uppercase tracking-wider text-gray-500 text-[10px]">Jadwal Pelaksanaan</p>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        @if ($tahap->periode_awal && $tahap->periode_akhir)
                                            {{ $tahap->periode_awal->format('d M Y') }} — {{ $tahap->periode_akhir->format('d M Y') }}
                                        @else
                                            <span class="text-gray-400 italic">Mengikuti jadwal umum sesi</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="font-bold uppercase tracking-wider text-gray-500 text-[10px]">Form Builder</p>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $tahap->fields->count() }} Field Isian ({{ $tahap->sections->count() }} Section)
                                    </p>
                                </div>

                                @if ($tahap->deskripsi)
                                    <div>
                                        <p class="font-bold uppercase tracking-wider text-gray-500 text-[10px]">Deskripsi / Instruksi</p>
                                        <p class="mt-1 text-gray-600 line-clamp-3">{{ $tahap->deskripsi }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div class="border-t-2 border-gray-950 p-4 bg-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-500 font-semibold">Konfigurasi Form</span>
                            <a href="{{ route('admin_hackaton.tahap.edit', $tahap) }}"
                                class="inline-flex items-center gap-1 bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-3 py-2 hover:bg-gray-800 transition">
                                <i class="fas fa-sliders-h text-[10px]"></i> Edit Form Builder
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
