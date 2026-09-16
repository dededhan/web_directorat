@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Detail Proposal Tim | Hackaton UNJ')

@section('content_hackaton')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.members.team_index') }}" class="hover:text-amber-600">Proposal Tim Lain</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-800 font-medium">Lihat Berkas</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $submission->identitas?->nama_produk ?? 'Proposal: ' . $submission->session->nama_sesi }}
                </h1>
                <p class="mt-1 text-xs text-gray-500">Ketua Tim: <strong>{{ $submission->user->name }}</strong> ({{ $submission->user->email }})</p>
            </div>
            <a href="{{ route('hackaton.members.team_index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali
            </a>
        </div>

        {{-- Read-only Notice --}}
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl text-xs flex items-center gap-3">
            <i class="fas fa-eye text-lg text-amber-600"></i>
            <div>
                <p class="font-bold">Mode Anggota Tim (Read-Only)</p>
                <p class="text-amber-800">Anda dapat memantau linimasa progres dan berkas isian tiap tahap yang diisi oleh Ketua Tim.</p>
            </div>
        </div>

        {{-- Identitas Produk --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-id-card text-amber-500"></i> Data Produk & Inovasi
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <span class="text-gray-400 font-bold uppercase text-[10px] block">Nama Produk</span>
                    <span class="font-bold text-gray-900 mt-1 block">{{ $submission->identitas?->nama_produk ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase text-[10px] block">Skema</span>
                    <span class="font-medium text-gray-800 mt-1 block">{{ $submission->identitas?->skema_inovasi ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase text-[10px] block">Bidang Utama</span>
                    <span class="font-medium text-gray-800 mt-1 block">{{ $submission->identitas?->bidang_utama_produk ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Anggota Tim --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-users text-amber-500"></i> Komposisi Tim ({{ $submission->members->count() }} Orang)
            </h2>
            <div class="divide-y divide-gray-100 text-xs">
                @foreach ($submission->members as $member)
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <span class="font-bold text-gray-900">{{ $member->nama_lengkap }}</span>
                            <span class="ml-2 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $member->peran === 'Ketua' ? 'bg-amber-100 text-amber-900' : 'bg-gray-100 text-gray-700' }}">
                                {{ $member->peran }}
                            </span>
                            <span class="ml-1 text-[10px] font-black px-2 py-0.5 rounded-full bg-purple-100 text-purple-900">
                                {{ $member->peran_ic }}
                            </span>
                            <p class="text-gray-500 text-[11px] mt-0.5">{{ $member->institusi_fakultas ?? '-' }}</p>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                            {{ $member->getTipeLabel() }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 3 Tahap Status --}}
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-gray-900">Progres 3 Tahap Evaluasi</h2>
            <div class="space-y-3">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                    @php
                        $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                        $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-gray-900 text-white font-black text-xs flex items-center justify-center">
                                {{ $tk }}
                            </span>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }}</h3>
                                <span class="text-xs font-bold text-gray-500">{{ $tracking['label'] }}</span>
                            </div>
                        </div>

                        <a href="{{ route('hackaton.team.tahap', [$submission, $st->hackaton_tahap_id]) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition">
                            <i class="fas fa-eye mr-1.5"></i> Lihat Berkas
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
