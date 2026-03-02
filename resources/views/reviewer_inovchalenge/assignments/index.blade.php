@extends('reviewer_inovchalenge.layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tugas Review</h1>
                    <p class="mt-1 text-sm text-gray-500">Submission yang ditugaskan kepada Anda</p>
                </div>
                <a href="{{ route('reviewer_inovchalenge.dashboard') }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Dashboard
                </a>
            </div>

            {{-- Submissions list --}}
            <div class="space-y-4">
                @forelse($submissions as $sub)
                    @php
                        $hasReviewed = $reviewedSubmissionIds->contains($sub->id);
                    @endphp
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                {{-- Info --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $sub->session->nama_sesi }}</h3>
                                        @if ($hasReviewed)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-700">
                                                <i class="fas fa-check mr-1"></i> Reviewed
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-700">
                                                <i class="fas fa-clock mr-1"></i> Pending
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-user mr-1"></i> {{ $sub->user->name }}
                                    </p>
                                </div>

                                {{-- Tahap chips --}}
                                <div class="flex gap-1.5">
                                    @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                                        @php
                                            $tc = match ($st->status) {
                                                'belum_diisi' => 'bg-gray-200 text-gray-500',
                                                'draft' => 'bg-yellow-200 text-yellow-700',
                                                'diajukan' => 'bg-green-200 text-green-700',
                                                default => 'bg-gray-200 text-gray-500',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold {{ $tc }}"
                                            title="T{{ $st->tahap->tahap_ke }}: {{ $st->status }}">
                                            T{{ $st->tahap->tahap_ke }}
                                        </span>
                                    @endforeach
                                </div>

                                {{-- Action --}}
                                <div class="flex-shrink-0">
                                    <a href="{{ route('reviewer_inovchalenge.assignments.show', $sub) }}"
                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-sm font-medium rounded-xl hover:from-cyan-600 hover:to-cyan-700 transition shadow-sm">
                                        <i class="fas fa-eye mr-1.5"></i> Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-cyan-100 to-cyan-200 rounded-2xl flex items-center justify-center mb-4">
                                <i class="fas fa-clipboard-check text-3xl text-cyan-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Belum ada tugas review</h3>
                            <p class="text-sm text-gray-400 mt-1">Anda belum ditugaskan untuk mereview submission.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($submissions->hasPages())
                <div class="mt-6">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
