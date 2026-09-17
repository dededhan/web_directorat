@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', ($submission->identitas?->nama_produk ?? 'Detail Proposal') . ' | Hackaton UNJ')

@section('content_hackaton')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.submissions.index') }}" class="hover:text-amber-600">Proposal Saya</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-800 font-medium">{{ Str::limit($submission->identitas?->nama_produk ?? 'Detail', 30) }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $submission->identitas?->nama_produk ?? 'Proposal: ' . $submission->session->nama_sesi }}
                </h1>
                <p class="mt-1 text-xs text-gray-500">Sesi: <strong>{{ $submission->session->nama_sesi }}</strong></p>
            </div>
            <a href="{{ route('hackaton.submissions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali
            </a>
        </div>

        {{-- Tema Inovasi Terpilih --}}
        @if ($submission->tema)
            <div class="bg-gradient-to-r {{ str_contains($submission->tema, 'D-FARM') ? 'from-amber-500/10 via-amber-500/5 to-transparent border-amber-300' : 'from-rose-500/10 via-rose-500/5 to-transparent border-rose-300' }} rounded-2xl border p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm bg-white">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl {{ str_contains($submission->tema, 'D-FARM') ? 'bg-gradient-to-br from-amber-500 to-orange-600 text-white' : 'bg-gradient-to-br from-rose-500 to-red-600 text-white' }} flex items-center justify-center text-xl shadow-sm shrink-0">
                        <i class="fas {{ str_contains($submission->tema, 'D-FARM') ? 'fa-wheat-awn' : 'fa-heart-pulse' }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded {{ str_contains($submission->tema, 'D-FARM') ? 'bg-amber-100 text-amber-900' : 'bg-rose-100 text-rose-900' }}">
                                FOKUS TEMA TERPILIH
                            </span>
                        </div>
                        <h2 class="text-sm font-bold text-gray-900 mt-1">{{ $submission->tema_label ?? $submission->tema }}</h2>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ str_contains($submission->tema, 'D-FARM') ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-rose-100 text-rose-900 border border-rose-300' }} self-start sm:self-auto">
                    <i class="fas fa-tag mr-1.5 text-[10px]"></i> {{ str_contains($submission->tema, 'D-FARM') ? 'Kategori D-FARM' : 'Kategori D-MARC' }}
                </span>
            </div>
        @endif

        {{-- Gatekeeper: Identitas Tim & Anggota --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl {{ $submission->identitasIsComplete() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} flex items-center justify-center text-xl shrink-0">
                    <i class="fas {{ $submission->identitasIsComplete() ? 'fa-id-card' : 'fa-exclamation-triangle' }}"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold text-gray-900">Identitas Tim & Produk</h2>
                        @if ($submission->identitasIsComplete())
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Lengkap</span>
                        @else
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">Wajib Dilengkapi</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $submission->members->count() }} Anggota Tim terdaftar (Termasuk Ketua).
                        @if (!$submission->identitasIsComplete())
                            Lengkapi identitas produk & minimal 1 anggota tim untuk membuka pengisian Tahap 1.
                        @endif
                    </p>
                </div>
            </div>

            <a href="{{ route('hackaton.submissions.identitas', $submission) }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow">
                <i class="fas fa-edit mr-1.5"></i> Kelola Identitas & Anggota
            </a>
        </div>

        {{-- Tahap Cards --}}
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-tasks text-amber-500"></i> Progres Pengisian & Evaluasi Tahapan ({{ $submission->submissionTahap->count() }} Tahap)
            </h2>

            <div class="space-y-4">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                    @php
                        $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                        $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                        $isPrevLolos = $st->isPreviousTahapLolos();
                        $identitasReady = $submission->identitasIsComplete();
                        $isLocked = !$identitasReady || ($tk > 1 && !$isPrevLolos) || $st->tahap->isUpcoming();
                    @endphp

                    <div class="bg-white rounded-2xl border {{ $isLocked ? 'border-gray-200 opacity-80' : 'border-gray-300' }} p-6 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl {{ $isLocked ? 'bg-gray-200 text-gray-500' : 'bg-gray-900 text-white' }} font-black text-sm flex items-center justify-center">
                                    {{ $tk }}
                                </span>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base">Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }}</h3>
                                    <p class="text-xs text-gray-500">{{ $st->tahap->fields->count() }} Isian Form</p>
                                </div>
                            </div>

                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                    @if ($tracking['key'] === 'lolos') bg-emerald-100 text-emerald-800
                                    @elseif ($tracking['key'] === 'perbaikan') bg-amber-100 text-amber-800
                                    @elseif ($tracking['key'] === 'sedang_direview') bg-purple-100 text-purple-800
                                    @elseif ($tracking['key'] === 'menunggu_review') bg-blue-100 text-blue-800
                                    @elseif ($tracking['key'] === 'draft') bg-amber-100 text-amber-800
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $tracking['label'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Locked Warning or Admin Notes --}}
                        @if ($isLocked)
                            <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-200 text-xs text-gray-600 flex items-center gap-2">
                                <i class="fas fa-lock text-gray-400"></i>
                                @if (!$identitasReady)
                                    <span>Tahap ini terkunci. Harap lengkapi <strong>Identitas Tim & Anggota</strong> terlebih dahulu.</span>
                                @elseif ($st->tahap->isUpcoming())
                                    <span>Tahap ini belum dibuka. Periode dimulai pada {{ $st->tahap->periode_awal?->format('d M Y H:i') }}.</span>
                                @else
                                    <span>Tahap ini terkunci. Anda harus dinyatakan <strong>Lolos Tahap {{ $tk - 1 }}</strong> terlebih dahulu oleh admin.</span>
                                @endif
                            </div>
                        @endif

                        @if ($st->admin_status === 'perbaikan' && $st->catatan_admin)
                            <div class="p-4 bg-amber-50 rounded-xl border border-amber-300 text-xs text-amber-900 space-y-1">
                                <p class="font-bold flex items-center gap-1.5">
                                    <i class="fas fa-redo text-amber-600"></i> Catatan Perbaikan dari Admin:
                                </p>
                                <p class="text-gray-800 whitespace-pre-line">{{ $st->catatan_admin }}</p>
                            </div>
                        @elseif (in_array($st->admin_status, ['disetujui', 'selesai']) && $st->catatan_admin)
                            <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-300 text-xs text-emerald-900 space-y-1">
                                <p class="font-bold flex items-center gap-1.5">
                                    <i class="fas fa-check-circle text-emerald-600"></i> Catatan Evaluasi Admin:
                                </p>
                                <p class="text-gray-800 whitespace-pre-line">{{ $st->catatan_admin }}</p>
                            </div>
                        @endif

                        @if ($st->nominal_evaluasi)
                            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-xs text-emerald-800 font-bold flex items-center gap-2">
                                <i class="fas fa-coins text-emerald-600"></i>
                                <span>Pencairan Dana Tahap {{ $tk }}: Rp {{ number_format($st->nominal_evaluasi, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        {{-- Action Button --}}
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                @if ($st->submitted_at)
                                    Disubmit: {{ $st->submitted_at->format('d M Y, H:i') }}
                                @else
                                    Status: Belum disubmit
                                @endif
                            </span>

                            @if (!$isLocked)
                                @if ($st->isEditable())
                                    <a href="{{ route('hackaton.submissions.tahap', [$submission, $st->hackaton_tahap_id]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-gray-900 text-xs font-bold rounded-xl transition shadow-sm">
                                        <i class="fas fa-edit mr-1.5"></i> {{ $st->status === 'draft' ? 'Lanjutkan Pengisian' : 'Isi Form Tahap' }}
                                    </a>
                                @else
                                    <a href="{{ route('hackaton.submissions.tahap', [$submission, $st->hackaton_tahap_id]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                                        <i class="fas fa-eye mr-1.5"></i> Lihat Isian (Terkunci)
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Activity Timeline / Logs --}}
        @if ($submission->statusLogs->isNotEmpty())
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-history text-amber-500"></i> Riwayat Aktivitas & Catatan
                </h3>
                <div class="divide-y divide-gray-100 text-xs">
                    @foreach ($submission->statusLogs as $log)
                        <div class="py-3 flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                            <div class="space-y-0.5 flex-1">
                                <p class="font-bold text-gray-900">{{ $log->keterangan }}</p>
                                <p class="text-gray-400 text-[11px]">
                                    {{ $log->created_at->format('d M Y, H:i') }} • Oleh: {{ $log->causer->name ?? 'Sistem' }} ({{ ucfirst($log->causer_role ?? 'user') }})
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
