@extends('subdirektorat-inovasi.hackaton.public-layout')

@section('title', 'Verifikasi KATSINOV Self-Assessment | ' . $assessment->judul_inovasi)

@section('content_public_hackaton')
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi Sah
                </span>
                <h1 class="text-2xl font-bold text-gray-900 mt-2">
                    Laporan KATSINOV (Self-Assessment)
                </h1>
                <p class="text-xs text-gray-500 mt-0.5">
                    Pengukuran Tingkat Kesiapan Inovasi untuk Program Hackathon DeepTech UNJ {{ date('Y') }}
                </p>
            </div>
            <a href="{{ route('hackaton.katsinov.download_pdf', $assessment->id) }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow">
                <i class="fas fa-file-pdf mr-2 text-sm"></i> Unduh Laporan Resmi (PDF)
            </a>
        </div>

        {{-- Detail Inovasi & Hasil --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Left: Informasi Inovasi --}}
            <div class="md:col-span-2 bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-2">
                    Identitas Inovasi & Pengusul
                </h2>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-gray-500 block">Nama / Judul Inovasi:</span>
                        <strong class="text-gray-900 text-sm">{{ $assessment->judul_inovasi }}</strong>
                    </div>

                    @if($assessment->fokus_bidang)
                        <div>
                            <span class="text-gray-500 block">Fokus Bidang:</span>
                            <span class="text-gray-800 font-semibold">{{ $assessment->fokus_bidang }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-gray-100">
                        <div>
                            <span class="text-gray-500 block">Ketua Tim Pengusul:</span>
                            <strong class="text-gray-900">{{ $ketua ? $ketua->name : '-' }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Nama Tim:</span>
                            <span class="text-gray-800 font-semibold">{{ $assessment->nama_tim ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Lembaga / Institusi:</span>
                            <span class="text-gray-800">{{ $assessment->institusi ?: 'Universitas Negeri Jakarta' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Tanggal Pengukuran:</span>
                            <span class="text-gray-800 font-semibold">{{ $assessment->assessment_date ? $assessment->assessment_date->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                    </div>

                    @if($members && $members->count() > 0)
                        <div class="pt-2 border-t border-gray-100">
                            <span class="text-gray-500 block mb-1">Anggota Tim:</span>
                            <ul class="list-disc pl-4 text-gray-700 space-y-0.5">
                                @foreach($members as $m)
                                    <li>{{ $m->user?->name ?: $m->nama_lengkap }} ({{ $m->peran_ic ?: $m->peran }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- Tanda Tangan Section --}}
                <div class="pt-4 border-t border-gray-200 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-gray-500 block">Disahkan Oleh Ketua Tim:</span>
                        <strong class="text-gray-900 text-xs">{{ $ketua ? $ketua->name : 'Ketua Pengusul' }}</strong>
                        @if($assessment->signed_at)
                            <span class="text-[10px] text-gray-500 block">Pada: {{ $assessment->signed_at->translatedFormat('d M Y H:i') }} WIB</span>
                        @endif
                    </div>
                    @if($assessment->signature_image)
                        <div class="border border-gray-200 rounded-xl p-2 bg-gray-50">
                            <img src="{{ $assessment->signature_image }}" alt="Tanda Tangan" class="h-14 max-w-[150px] object-contain">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Skor & Level Capaian --}}
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white rounded-2xl p-6 shadow-md flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-amber-400">Hasil Capaian</span>
                    <div>
                        <span class="text-xs text-gray-400 block">Tingkat Kesiapan (IRL):</span>
                        <div class="text-3xl font-black text-amber-400 mt-1">
                            KATSINOV {{ $assessment->achieved_level }}
                        </div>
                        <span class="text-xs text-gray-300 mt-1 block">
                            Rata-rata: <strong>{{ number_format($assessment->overall_percentage, 1) }}%</strong>
                        </span>
                    </div>

                    <div class="pt-3 border-t border-gray-700 space-y-2 text-xs">
                        <span class="text-gray-400 text-[10px] uppercase tracking-wider block">Status Capaian Aspek:</span>
                        @foreach($aspects as $code => $asp)
                            @php
                                $pct = $assessment->aspect_scores[$code] ?? 0;
                            @endphp
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">{{ $asp['name'] }}</span>
                                <span class="font-bold text-amber-300">{{ number_format($pct, 1) }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('hackaton.katsinov.download_pdf', $assessment->id) }}" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition text-center shadow">
                    <i class="fas fa-file-pdf mr-1.5"></i> Unduh PDF Resmi
                </a>
            </div>
        </div>
    </div>
@endsection
