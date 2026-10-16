@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Detail KATSINOV (View Only) | ' . $katsinov->judul_inovasi)

@section('content_hackaton')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $aspectScores = $katsinov->aspect_scores ?? [];
        $signedFormatted = $katsinov->signed_at ? $katsinov->signed_at->translatedFormat('d F Y H:i') : null;
        $dateFormatted = $katsinov->assessment_date ? $katsinov->assessment_date->translatedFormat('d F Y') : '-';
        $internalUrl = route('hackaton.katsinov.show', $katsinov->id);
    @endphp

    <div class="max-w-5xl mx-auto space-y-6 pb-24" x-data="{ activeIndicator: 1 }">
        {{-- Breadcrumb & Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-300">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    @if(in_array(auth()->user()?->role ?? '', ['reviewer_hackaton', 'reviewer_inovchalenge']))
                        <a href="{{ route('hackaton.reviewer.dashboard') }}" class="hover:text-black">Reviewer</a>
                    @else
                        <a href="{{ route('hackaton.katsinov.index') }}" class="hover:text-black">Generator KATSINOV</a>
                    @endif
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-900 font-bold">Detail Assessment</span>
                </nav>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                        Self-Assessment KATSINOV
                    </h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-800 border border-gray-300">
                        <i class="fas fa-eye mr-1"></i> Mode View-Only
                    </span>
                    @if($katsinov->signature_image)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            <i class="fas fa-check-circle mr-1"></i> Terverifikasi & Disahkan
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            <i class="fas fa-clock mr-1"></i> Belum Disahkan
                        </span>
                    @endif
                </div>
                <p class="mt-1 text-xs text-gray-600">
                    @if($submission)
                        Terkait Proposal Tim: <strong>{{ $submission->identitas?->nama_produk ?? $submission->session->nama_sesi }}</strong>
                    @else
                        Pengukuran Kesiapan Inovasi Mandiri
                    @endif
                    • Status Akses: <strong class="text-emerald-700">Internal Dashboard</strong>
                </p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('hackaton.katsinov.download_pdf', $katsinov->id) }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow">
                    <i class="fas fa-file-pdf mr-1.5 text-sm"></i> Unduh PDF Resmi
                </a>
                @if($canEdit)
                    <a href="{{ route('hackaton.katsinov.edit', $katsinov->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-800 text-xs font-bold rounded-xl transition shadow-sm">
                        <i class="fas fa-edit mr-1.5"></i> Ubah Isian / Edit
                    </a>
                @endif
                @if($submission)
                    <a href="{{ route('hackaton.submissions.show', $submission->id) }}" class="inline-flex items-center px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition">
                        <i class="fas fa-arrow-left mr-1.5"></i> Proposal
                    </a>
                @else
                    <a href="{{ route('hackaton.katsinov.index') }}" class="inline-flex items-center px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition">
                        <i class="fas fa-arrow-left mr-1.5"></i> Kembali
                    </a>
                @endif
            </div>
        </div>

        {{-- PRIVACY & ROLE NOTICE --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="text-xs">
                    <span class="font-bold text-gray-900 block">Akses Dashboard Terlindungi</span>
                    <span class="text-gray-500">
                        Dokumen ini hanya dapat diakses oleh Pengusul Tim, Reviewer yang ditugaskan, dan Admin Hackathon.
                    </span>
                </div>
            </div>
            <button type="button" onclick="navigator.clipboard.writeText('{{ $internalUrl }}'); Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Tautan KATSINOV berhasil disalin!', showConfirmButton: false, timer: 2000});" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow shrink-0 self-start sm:self-auto">
                <i class="fas fa-copy"></i>
                <span>Salin Tautan Dashboard</span>
            </button>
        </div>

        {{-- 1. INFORMASI DASAR INOVASI (VIEW ONLY) --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Dasar Inovasi</h2>
                </div>
                <span class="text-[11px] text-gray-500 italic">*Dicetak pada lembar pengesahan resmi</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Nama / Judul Inovasi
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm font-bold text-gray-900">
                        {{ $katsinov->judul_inovasi }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Fokus Bidang Inovasi
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold text-gray-800">
                        {{ $katsinov->fokus_bidang ?: '-' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Nama Tim Pengusul
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold text-gray-800">
                        {{ $katsinov->nama_tim ?: ($submission?->identitas?->nama_tim ?? '-') }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Ketua Tim Pengusul
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold text-gray-800">
                        {{ $ketua ? $ketua->name : '-' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Nama Lembaga / Institusi
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold text-gray-800">
                        {{ $katsinov->institusi ?: 'Universitas Negeri Jakarta' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Kontak (No HP / Email)
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold text-gray-800">
                        {{ $katsinov->kontak ?: '-' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Tanggal Pengukuran
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold text-gray-800">
                        {{ $dateFormatted }}
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                        Alamat Lembaga
                    </label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs text-gray-700">
                        {{ $katsinov->alamat ?: '-' }}
                    </div>
                </div>

                @if($members && $members->count() > 0)
                    <div class="md:col-span-2 pt-2 border-t border-gray-100">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                            Anggota Tim Terdaftar ({{ $members->count() }} Orang)
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($members as $m)
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs">
                                    <div class="font-bold text-gray-900">{{ $m->user?->name ?: $m->nama_lengkap }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $m->peran_ic ?: $m->peran }} • {{ $m->getTipeLabel() }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- 2. DASHBOARD CAPAIAN & ATURAN 80% --}}
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white rounded-2xl p-6 shadow-md space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-700 pb-4">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-amber-400">Hasil Pengukuran Kesiapan</span>
                    <h3 class="text-xl font-bold">Tingkat Capaian KATSINOV (IRL)</h3>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Level Resmi:</span>
                        <span class="text-3xl font-black text-amber-400">KATSINOV {{ $katsinov->achieved_level }}</span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-400/20 border border-amber-400/40 flex items-center justify-center text-2xl text-amber-300">
                        <i class="fas fa-award"></i>
                    </div>
                </div>
            </div>

            {{-- Mini Status per Indicator 1..6 --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2 pt-1">
                @for($lvl = 1; $lvl <= 6; $lvl++)
                    @php
                        $st = $indicatorStats[$lvl] ?? ['percentage' => 0.0, 'isPassed' => false, 'earned' => 0, 'max' => 0];
                    @endphp
                    <div class="rounded-xl p-3 border transition cursor-pointer"
                        :class="activeIndicator === {{ $lvl }} ? 'bg-white/10 border-white/30 ring-2 ring-amber-400' : 'bg-black/30 border-white/5 opacity-80'"
                        @click="activeIndicator = {{ $lvl }}">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] font-bold uppercase">Level {{ $lvl }}</span>
                            <i class="fas text-[10px] {{ $st['isPassed'] ? 'fa-check-circle text-emerald-400' : 'fa-circle text-amber-400' }}"></i>
                        </div>
                        <div class="text-base font-bold">{{ number_format($st['percentage'], 1) }}%</div>
                        <div class="text-[9px] text-gray-300">
                            {{ $st['isPassed'] ? 'Terpenuhi (≥80%)' : 'Tersimpan (<80%)' }}
                        </div>
                    </div>
                @endfor
            </div>

            {{-- 7 Aspek Kunci Breakdown --}}
            <div class="pt-3 border-t border-gray-700">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-3">
                    Capaian 7 Aspek Kunci Inovasi:
                </span>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2">
                    @foreach($aspects as $code => $asp)
                        @php
                            $pct = $aspectScores[$code] ?? 0;
                        @endphp
                        <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-center">
                            <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold text-white mb-1 shadow-sm" style="background-color: {{ $asp['color'] }};">
                                {{ $code }}
                            </span>
                            <div class="text-[11px] font-medium text-gray-300 truncate" title="{{ $asp['name'] }}">
                                {{ $asp['name'] }}
                            </div>
                            <div class="text-xs font-bold text-amber-300 mt-0.5">
                                {{ number_format($pct, 1) }}%
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 3. KUESIONER INDIKATOR 1 s/d 6 (ISIAN INPUT VIEW ONLY) --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-6">
            <div class="border-b border-gray-200 pb-3 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">
                        Isian Kuesioner Indikator 1 s/d 6
                    </h2>
                </div>
                <span class="text-[11px] font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                    <i class="fas fa-check-double mr-1"></i> Nilai Terpilih Tersimpan Sesuai Isian Formulir
                </span>
            </div>

            {{-- Tabs Navigation --}}
            <div class="flex items-center gap-1.5 border-b border-gray-200 pb-3 overflow-x-auto">
                @for($lvl = 1; $lvl <= 6; $lvl++)
                    @php
                        $st = $indicatorStats[$lvl] ?? ['percentage' => 0.0, 'isPassed' => false];
                    @endphp
                    <button type="button"
                        @click="activeIndicator = {{ $lvl }}"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 shrink-0"
                        :class="activeIndicator === {{ $lvl }} ? 'bg-black text-white shadow' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                        <span>Indikator {{ $lvl }}</span>
                        <span class="text-[10px] px-1.5 py-0.2 rounded" :class="activeIndicator === {{ $lvl }} ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">
                            {{ number_format($st['percentage'], 1) }}%
                        </span>
                        @if($st['isPassed'])
                            <i class="fas fa-check text-[10px] text-emerald-400"></i>
                        @endif
                    </button>
                @endfor
            </div>

            {{-- Indicator Panes --}}
            @foreach($questions as $lvl => $qList)
                @php
                    $st = $indicatorStats[$lvl] ?? ['percentage' => 0.0, 'earned' => 0, 'max' => 0, 'isPassed' => false, 'answeredCount' => 0, 'totalCount' => count($qList)];
                @endphp
                <div x-show="activeIndicator === {{ $lvl }}" class="space-y-4">
                    {{-- Indicator Header Summary --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">
                                Indikator KATSINOV {{ $lvl }} (Total {{ count($qList) }} Butir Pertanyaan)
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Skor tercapai: <strong>{{ $st['earned'] }}</strong> dari skor maksimal <strong>{{ $st['max'] }}</strong> poin
                                ({{ $st['answeredCount'] }} butir terjawab).
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-600">Status Capaian:</span>
                            @if($st['isPassed'])
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-700 text-white text-xs font-bold shadow-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Terpenuhi ({{ number_format($st['percentage'], 1) }}%)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-gray-900 text-amber-400 text-xs font-bold shadow-sm">
                                    <i class="fas fa-info-circle mr-1"></i> Tersimpan ({{ number_format($st['percentage'], 1) }}%)
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Table of Questions (View Only Mode) --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100/90 text-[10px] font-bold uppercase tracking-wider text-gray-700 border-b border-gray-200">
                                    <th class="p-3 text-center w-12">No</th>
                                    <th class="p-3 text-center w-16">Aspek</th>
                                    <th class="p-3">Pernyataan Indikator</th>
                                    <th class="p-3 text-center w-72">Penilaian Terpilih (0 - 5)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-xs">
                                @foreach($qList as $q)
                                    @php
                                        $aspectInfo = $aspects[$q['aspect']] ?? ['name' => $q['aspect'], 'color' => '#6b7280'];
                                        $key = "i{$lvl}_q{$q['no']}";
                                        $chosenVal = isset($responses[$key]) && $responses[$key] !== '' && $responses[$key] !== null ? (int) $responses[$key] : null;
                                        $noteVal = $notes[$key] ?? null;
                                    @endphp
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="p-3 text-center font-bold text-gray-500">
                                            {{ $q['no'] }}
                                        </td>
                                        <td class="p-3 text-center">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold text-white shadow-sm" style="background-color: {{ $aspectInfo['color'] }};" title="{{ $aspectInfo['name'] }}">
                                                {{ $q['aspect'] }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-gray-800 leading-relaxed font-medium">
                                            <div>{{ $q['desc'] }}</div>
                                            @if($noteVal)
                                                <div class="mt-2 text-xs text-gray-600 bg-amber-50/80 p-2.5 rounded-xl border border-amber-200 flex items-start gap-2">
                                                    <i class="fas fa-sticky-note text-amber-600 mt-0.5"></i>
                                                    <div>
                                                        <strong class="text-amber-900">Catatan Pengusul:</strong>
                                                        <span>{{ $noteVal }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            <div class="flex flex-col items-center justify-center gap-1.5">
                                                <div class="flex items-center justify-center gap-1">
                                                    @for($val = 0; $val <= 5; $val++)
                                                        @php
                                                            $isSelected = ($chosenVal !== null && $chosenVal === $val);
                                                        @endphp
                                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold border transition select-none {{ $isSelected ? 'bg-black text-white border-black shadow-md ring-2 ring-emerald-500' : 'bg-gray-50 text-gray-300 border-gray-200 opacity-60' }}"
                                                            title="{{ $isSelected ? 'Nilai yang dipilih: ' . $val : '' }}">
                                                            {{ $val }}
                                                        </div>
                                                    @endfor
                                                </div>
                                                @if($chosenVal !== null)
                                                    <span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                                        Nilai: <strong>{{ $chosenVal }}</strong> / 5
                                                    </span>
                                                @else
                                                    <span class="text-[11px] font-medium text-gray-400 italic">
                                                        Belum diisi
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Next / Prev Indicator Controls --}}
                    <div class="flex items-center justify-between pt-2">
                        <div>
                            @if($lvl > 1)
                                <button type="button" @click="activeIndicator = {{ $lvl - 1 }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-xs font-bold rounded-lg text-gray-700">
                                    &larr; Indikator {{ $lvl - 1 }}
                                </button>
                            @endif
                        </div>
                        <div>
                            @if($lvl < 6)
                                <button type="button" @click="activeIndicator = {{ $lvl + 1 }}" class="px-3.5 py-2 bg-black text-white hover:bg-gray-800 text-xs font-bold rounded-lg transition">
                                    Lihat Indikator {{ $lvl + 1 }} &rarr;
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 4. LEMBAR PENGESAHAN & TANDA TANGAN (DAN TTD NYA) --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">
                        Lembar Pengesahan &amp; Tanda Tangan
                    </h2>
                </div>
                <span class="text-[11px] font-semibold text-gray-500">
                    Pengesahan Resmi Laporan KATSINOV
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                {{-- Left: Informasi Pengesahan --}}
                <div class="space-y-3 text-xs">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 space-y-2">
                        <div>
                            <span class="text-gray-500 block text-[11px] uppercase tracking-wider">Disahkan Oleh:</span>
                            <strong class="text-gray-900 text-sm block mt-0.5">{{ $ketua ? $ketua->name : ($katsinov->nama_tim ?: 'Ketua Tim Pengusul') }}</strong>
                            <span class="text-gray-600 block">{{ $katsinov->institusi ?: 'Universitas Negeri Jakarta' }}</span>
                        </div>

                        <div class="pt-2 border-t border-gray-200 flex items-center justify-between">
                            <span class="text-gray-500">Tanggal Pengukuran:</span>
                            <strong class="text-gray-800">{{ $dateFormatted }}</strong>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Status Pengesahan:</span>
                            @if($katsinov->signature_image)
                                <span class="text-emerald-700 font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Sah Bertanda Tangan
                                </span>
                            @else
                                <span class="text-amber-700 font-bold flex items-center gap-1">
                                    <i class="fas fa-clock"></i> Belum Ditandatangani
                                </span>
                            @endif
                        </div>

                        @if($signedFormatted)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Waktu Tanda Tangan:</span>
                                <strong class="text-gray-800">{{ $signedFormatted }} WIB</strong>
                            </div>
                        @endif
                    </div>

                    <p class="text-[11px] text-gray-500 italic leading-relaxed">
                        *Laporan KATSINOV ini merupakan dokumen hasil self-assessment mandiri tingkat kesiapan inovasi peserta untuk seleksi Program Hackathon DeepTech UNJ {{ date('Y') }}.
                    </p>
                </div>

                {{-- Right: Kotak Gambar TTD --}}
                <div class="flex flex-col items-center justify-center p-4 bg-gray-50 border border-gray-200 rounded-2xl">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2">
                        Tanda Tangan Pengusul:
                    </span>

                    @if($katsinov->signature_image)
                        <div class="bg-white border-2 border-gray-200 rounded-2xl p-4 shadow-sm w-full max-w-xs flex flex-col items-center justify-center space-y-2">
                            <img src="{{ $katsinov->signature_image }}" alt="Tanda Tangan Ketua Tim" class="h-28 max-w-[240px] object-contain">
                            <div class="border-t border-gray-100 pt-2 w-full text-center">
                                <strong class="text-xs text-gray-900 block">{{ $ketua ? $ketua->name : 'Ketua Pengusul' }}</strong>
                                <span class="text-[10px] text-emerald-700 font-semibold block">
                                    <i class="fas fa-check-circle mr-0.5"></i> TTD Digital Terverifikasi
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center w-full max-w-xs space-y-2">
                            <i class="fas fa-signature text-3xl text-gray-300"></i>
                            <p class="text-xs text-gray-500 font-medium">Tanda tangan belum dibubuhkan oleh Ketua Pengusul.</p>
                            @if($canEdit)
                                <a href="{{ route('hackaton.katsinov.edit', $katsinov->id) }}" class="inline-flex items-center px-3 py-1.5 bg-black hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow">
                                    <i class="fas fa-pen mr-1.5"></i> Bubuhkan TTD Sekarang
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 5. SHAREABLE INTERNAL LINK BOX --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-800">
                <i class="fas fa-link text-emerald-600 mr-1.5"></i> Tautan Bukti KATSINOV untuk Pengajuan Proposal Hackathon:
            </label>
            <div class="flex items-center gap-2">
                <input type="text" value="{{ $internalUrl }}" readonly class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-xs text-gray-800 font-mono select-all">
                <button type="button" onclick="navigator.clipboard.writeText('{{ $internalUrl }}'); Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Tautan berhasil disalin!', showConfirmButton: false, timer: 2000});" class="px-5 py-3 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shrink-0 flex items-center gap-1.5 shadow">
                    <i class="fas fa-copy"></i>
                    <span>Salin Link</span>
                </button>
            </div>
            <p class="text-[11px] text-gray-500 italic">
                *Tautan ini mengarah langsung ke dalam dashboard internal sistem. Akses hanya dibuka untuk Pengusul, Reviewer, dan Administrator.
            </p>
        </div>

        {{-- STICKY FLOATING BOTTOM BAR --}}
        <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-gray-300 py-3.5 px-6 shadow-2xl z-30">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-black text-amber-400 flex items-center justify-center text-lg font-black shrink-0">
                        {{ $katsinov->achieved_level }}
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500 block">Status Capaian:</span>
                        <div class="text-sm font-bold text-gray-900">
                            KATSINOV Level {{ $katsinov->achieved_level }}
                            <span class="text-xs font-normal text-gray-500">(Rata-rata: {{ number_format($katsinov->overall_percentage, 1) }}%)</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('hackaton.katsinov.download_pdf', $katsinov->id) }}" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow flex items-center gap-2 border border-emerald-800">
                        <i class="fas fa-file-pdf"></i>
                        <span>Unduh PDF Resmi</span>
                    </a>

                    @if($canEdit)
                        <a href="{{ route('hackaton.katsinov.edit', $katsinov->id) }}" class="px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-800 text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            <span>Ubah Isian</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
