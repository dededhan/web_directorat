@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Tugas Penilaian Reviewer | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tugas Penilaian Reviewer</h1>
                <p class="text-sm text-gray-500 mt-0.5">Daftar proposal tim Hackaton yang ditugaskan kepada Anda untuk dievaluasi.</p>
            </div>
            <a href="{{ route('hackaton.reviewer.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- Submissions List --}}
        <div class="space-y-4">
            @forelse($submissions as $sub)
                @php
                    $hasReviewed = $reviewedSubmissionIds->contains($sub->id);
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        {{-- Main Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <h3 class="text-base font-bold text-gray-900 truncate">
                                    {{ $sub->identitas->nama_produk ?? $sub->session->nama_sesi }}
                                </h3>
                                @if ($hasReviewed)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check-circle mr-1 text-[9px]"></i> Sudah Dinilai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        <i class="fas fa-clock mr-1 text-[9px]"></i> Menunggu Review
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 flex items-center gap-2">
                                <span><i class="fas fa-layer-group text-gray-400 mr-1"></i> {{ $sub->session->nama_sesi }}</span>
                                <span>•</span>
                                <span><i class="fas fa-user text-gray-400 mr-1"></i> Ketua: <strong>{{ $sub->user->name ?? '—' }}</strong></span>
                                <span>•</span>
                                <span>ID: #{{ $sub->id }}</span>
                            </p>
                        </div>

                        {{-- Tahap status badge chips --}}
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                                @php
                                    $chipClass = match ($st->status) {
                                        'lolos', 'disetujui' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                        'diajukan' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                        'perbaikan' => 'bg-orange-100 text-orange-800 border border-orange-200',
                                        'draft' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                        default => 'bg-gray-100 text-gray-500 border border-gray-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-xs font-bold {{ $chipClass }}"
                                    title="Tahap {{ $st->tahap->tahap_ke }}: {{ ucfirst(str_replace('_', ' ', $st->status)) }}">
                                    T{{ $st->tahap->tahap_ke }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Action Button --}}
                        <div class="flex-shrink-0">
                            <a href="{{ route('hackaton.reviewer.assignments.show', $sub) }}"
                                class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow">
                                <i class="fas fa-edit mr-1.5"></i> Beri Nilai / Review
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Belum Ada Tugas Penilaian</h3>
                    <p class="text-xs text-gray-400 mt-1 max-w-md mx-auto">
                        Saat ini administrator belum mengalokasikan proposal Hackaton ke akun reviewer Anda.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($submissions->hasPages())
            <div class="mt-4">
                {{ $submissions->links() }}
            </div>
        @endif

    </div>
@endsection
