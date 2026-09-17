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
            <div class="pt-6 border-t border-gray-100">
                @if ($existingSubmission)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="text-xs font-bold text-gray-800">Anda sudah memiliki proposal pada sesi ini.</p>
                                @if ($existingSubmission->tema)
                                    <div class="mt-1 flex items-center gap-1.5">
                                        <span class="text-[10px] text-gray-500 font-semibold">Tema:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ str_contains($existingSubmission->tema, 'D-FARM') ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-rose-100 text-rose-900 border border-rose-300' }}">
                                            <i class="fas {{ str_contains($existingSubmission->tema, 'D-FARM') ? 'fa-wheat-awn' : 'fa-heart-pulse' }} mr-1 text-[10px]"></i>
                                            {{ $existingSubmission->tema_label ?? $existingSubmission->tema }}
                                        </span>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Status: <strong class="text-emerald-700 uppercase">{{ $existingSubmission->status->value ?? $existingSubmission->status }}</strong></p>
                            </div>
                        </div>
                        <a href="{{ route('hackaton.submissions.show', $existingSubmission) }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-gray-800 transition shadow">
                            Buka Detail Proposal <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @else
                    <div x-data="{ selectedTema: '{{ old('tema', '') }}' }" class="space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-bullseye text-amber-500"></i> Pilih Tema Proposal Inovasi
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">Silakan pilih salah satu fokus tema inovasi di bawah sebelum mendaftarkan proposal tim Anda.</p>
                            </div>
                            <span class="text-[11px] font-bold text-amber-800 bg-amber-100 px-3 py-1 rounded-full border border-amber-200 self-start sm:self-auto">
                                <i class="fas fa-hand-pointer mr-1"></i> Wajib Pilih 1 Tema
                            </span>
                        </div>

                        <form action="{{ route('hackaton.submissions.store', $session) }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                {{-- Card Tema D-FARM --}}
                                <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200"
                                    :class="selectedTema === 'D-FARM (DeepTech Food Acceleration Research to Market)' ? 'border-amber-500 bg-amber-50/70 ring-2 ring-amber-400 shadow-md' : 'border-gray-200 hover:border-amber-300 bg-white'">
                                    <input type="radio" name="tema" value="D-FARM (DeepTech Food Acceleration Research to Market)" class="sr-only" x-model="selectedTema" required>
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-xl shadow-sm shrink-0">
                                                <i class="fas fa-wheat-awn"></i>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-200/80 text-amber-900 mb-1">
                                                    TEMA 1
                                                </span>
                                                <h4 class="text-base font-bold text-gray-900">D-FARM</h4>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 mt-1"
                                            :class="selectedTema === 'D-FARM (DeepTech Food Acceleration Research to Market)' ? 'border-amber-600 bg-amber-600 text-white' : 'border-gray-300'">
                                            <i class="fas fa-check text-[10px]" x-show="selectedTema === 'D-FARM (DeepTech Food Acceleration Research to Market)'"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-xs font-bold text-gray-800">DeepTech Food Acceleration Research to Market</p>
                                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                            Akselerasi inovasi ketahanan pangan, agritech, dan pengolahan hasil riset pangan berbasis teknologi mendalam (DeepTech) menuju komersialisasi pasar industri.
                                        </p>
                                    </div>
                                </label>

                                {{-- Card Tema D-MARC --}}
                                <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200"
                                    :class="selectedTema === 'D-MARC (DeepTack Medical Acceleraton Research to Challenge)' ? 'border-rose-500 bg-rose-50/70 ring-2 ring-rose-400 shadow-md' : 'border-gray-200 hover:border-rose-300 bg-white'">
                                    <input type="radio" name="tema" value="D-MARC (DeepTack Medical Acceleraton Research to Challenge)" class="sr-only" x-model="selectedTema" required>
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center text-xl shadow-sm shrink-0">
                                                <i class="fas fa-heart-pulse"></i>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-200/80 text-rose-900 mb-1">
                                                    TEMA 2
                                                </span>
                                                <h4 class="text-base font-bold text-gray-900">D-MARC</h4>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 mt-1"
                                            :class="selectedTema === 'D-MARC (DeepTack Medical Acceleraton Research to Challenge)' ? 'border-rose-600 bg-rose-600 text-white' : 'border-gray-300'">
                                            <i class="fas fa-check text-[10px]" x-show="selectedTema === 'D-MARC (DeepTack Medical Acceleraton Research to Challenge)'"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-xs font-bold text-gray-800">DeepTack Medical Acceleraton Research to Challenge</p>
                                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                            Akselerasi riset inovasi teknologi medis, perangkat kesehatan preventif &amp; diagnostik, biomedika, serta penanganan tantangan klinis nyata.
                                        </p>
                                    </div>
                                </label>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2">
                                <p class="text-xs text-gray-500" x-show="!selectedTema">
                                    <i class="fas fa-info-circle text-amber-500 mr-1"></i> Klik salah satu tema di atas untuk mengaktifkan tombol pendaftaran.
                                </p>
                                <p class="text-xs font-semibold text-emerald-700" x-show="selectedTema" x-cloak>
                                    <i class="fas fa-check-circle mr-1"></i> Tema dipilih: <span x-text="selectedTema" class="font-bold"></span>
                                </p>

                                <button type="submit" :disabled="!selectedTema"
                                    :class="selectedTema ? 'bg-amber-500 hover:bg-amber-400 text-gray-900 shadow-md cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                    class="inline-flex items-center justify-center px-7 py-3 font-bold text-xs uppercase tracking-wider rounded-xl transition ml-auto">
                                    <i class="fas fa-plus mr-2"></i> Daftarkan Proposal &amp; Masuk ke Detail
                                </button>
                            </div>
                        </form>
                    </div>
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
