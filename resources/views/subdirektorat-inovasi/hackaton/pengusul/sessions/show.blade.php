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

            {{-- Action Registration Dual Category (D-FARM & D-TECH) --}}
            <div class="pt-6 border-t border-gray-100 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-bullseye text-amber-500"></i> Pendaftaran Kategori Proposal Inovasi
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Setiap peserta dapat mengajukan <strong>1 proposal pada kategori D-FARM</strong> dan <strong>1 proposal pada kategori D-TECH</strong>.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <span class="inline-flex items-center text-[11px] font-bold px-3 py-1 rounded-full border {{ $submissionDFarm ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-amber-50 text-amber-800 border-amber-200' }}">
                            <i class="fas {{ $submissionDFarm ? 'fa-check-circle text-emerald-600' : 'fa-circle text-amber-500' }} mr-1.5"></i>
                            D-FARM: {{ $submissionDFarm ? 'Terdaftar' : 'Belum' }}
                        </span>
                        <span class="inline-flex items-center text-[11px] font-bold px-3 py-1 rounded-full border {{ $submissionDTech ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-rose-50 text-rose-800 border-rose-200' }}">
                            <i class="fas {{ $submissionDTech ? 'fa-check-circle text-emerald-600' : 'fa-circle text-rose-500' }} mr-1.5"></i>
                            D-TECH: {{ $submissionDTech ? 'Terdaftar' : 'Belum' }}
                        </span>
                    </div>
                </div>

                @if ($submissionDFarm && $submissionDTech)
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50/70 p-4 text-xs font-semibold text-emerald-900 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                            <i class="fas fa-check-double text-sm"></i>
                        </span>
                        <span>Kuota proposal Anda untuk sesi ini telah lengkap (1 proposal D-FARM dan 1 proposal D-TECH). Silakan lanjutkan pengisian tahapan pada masing-masing proposal di bawah.</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- ── Card Kategori 1: D-FARM ── --}}
                    <div class="rounded-2xl border-2 {{ $submissionDFarm ? 'border-emerald-500 bg-white ring-2 ring-emerald-200' : 'border-amber-400 bg-amber-50/30' }} p-6 flex flex-col justify-between transition-all shadow-sm">
                        <div class="space-y-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-xl shadow-sm shrink-0">
                                        <i class="fas fa-wheat-awn"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5 mb-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-200 text-amber-900">
                                                KATEGORI 1
                                            </span>
                                            @if ($submissionDFarm)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                    <i class="fas fa-check mr-1 text-[8px]"></i> Terdaftar
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-black text-gray-900">D-FARM</h4>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-gray-800">DeepTech Food Acceleration Research to Market</p>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                    Akselerasi inovasi ketahanan pangan, smart agritech, nutrisi unggul, dan pengolahan hasil riset pangan berbasis teknologi mendalam (DeepTech) menuju komersialisasi industri.
                                </p>
                            </div>

                            @if ($submissionDFarm)
                                <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-200 space-y-1">
                                    <p class="text-[11px] font-semibold text-gray-500">Proposal Anda:</p>
                                    <p class="text-xs font-bold text-gray-900 line-clamp-1">
                                        {{ $submissionDFarm->identitas?->nama_produk ?? '— Belum mengisi nama produk —' }}
                                    </p>
                                    <p class="text-[11px] text-gray-500">
                                        Status: <span class="font-bold text-emerald-700 uppercase">{{ $submissionDFarm->status->value ?? $submissionDFarm->status }}</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="pt-5 mt-4 border-t border-gray-200">
                            @if ($submissionDFarm)
                                <a href="{{ route('hackaton.submissions.show', $submissionDFarm) }}"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow">
                                    <i class="fas fa-folder-open mr-2"></i> Buka / Lanjutkan Proposal D-FARM
                                </a>
                            @else
                                <form action="{{ route('hackaton.submissions.store', $session) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kategori" value="d-farm">
                                    <input type="hidden" name="tema" value="D-FARM (DeepTech Food Acceleration Research to Market)">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-5 py-3 bg-amber-500 hover:bg-amber-400 text-gray-950 font-black text-xs uppercase tracking-wider rounded-xl transition shadow">
                                        <i class="fas fa-plus mr-2"></i> Ajukan Proposal D-FARM →
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- ── Card Kategori 2: D-TECH ── --}}
                    <div class="rounded-2xl border-2 {{ $submissionDTech ? 'border-emerald-500 bg-white ring-2 ring-emerald-200' : 'border-rose-400 bg-rose-50/30' }} p-6 flex flex-col justify-between transition-all shadow-sm">
                        <div class="space-y-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center text-xl shadow-sm shrink-0">
                                        <i class="fas fa-heart-pulse"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5 mb-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-200 text-rose-900">
                                                KATEGORI 2
                                            </span>
                                            @if ($submissionDTech)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                    <i class="fas fa-check mr-1 text-[8px]"></i> Terdaftar
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-black text-gray-900">D-TECH</h4>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-gray-800">DeepTech Acceleration Research (MedTech &amp; Teknologi)</p>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                    Akselerasi riset inovasi teknologi medis, perangkat kesehatan preventif &amp; diagnostik, biomedika, biosensor, IoMT, serta implementasi teknologi mendalam (DeepTech).
                                </p>
                            </div>

                            @if ($submissionDTech)
                                <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-200 space-y-1">
                                    <p class="text-[11px] font-semibold text-gray-500">Proposal Anda:</p>
                                    <p class="text-xs font-bold text-gray-900 line-clamp-1">
                                        {{ $submissionDTech->identitas?->nama_produk ?? '— Belum mengisi nama produk —' }}
                                    </p>
                                    <p class="text-[11px] text-gray-500">
                                        Status: <span class="font-bold text-emerald-700 uppercase">{{ $submissionDTech->status->value ?? $submissionDTech->status }}</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="pt-5 mt-4 border-t border-gray-200">
                            @if ($submissionDTech)
                                <a href="{{ route('hackaton.submissions.show', $submissionDTech) }}"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow">
                                    <i class="fas fa-folder-open mr-2"></i> Buka / Lanjutkan Proposal D-TECH
                                </a>
                            @else
                                <form action="{{ route('hackaton.submissions.store', $session) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kategori" value="d-tech">
                                    <input type="hidden" name="tema" value="D-TECH (DeepTech Acceleration Research to Challenge)">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-5 py-3 bg-rose-600 hover:bg-rose-500 text-white font-black text-xs uppercase tracking-wider rounded-xl transition shadow">
                                        <i class="fas fa-plus mr-2"></i> Ajukan Proposal D-TECH →
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tahapan Overview --}}
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-stream text-amber-500"></i> Alur Tahapan Evaluasi ({{ $session->tahap->count() }} Tahap)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
