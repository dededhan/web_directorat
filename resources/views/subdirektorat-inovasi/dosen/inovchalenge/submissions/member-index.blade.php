@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tim Saya</h1>
                    <p class="mt-1 text-sm text-gray-500">Submission Innovation Challenge di mana Anda tergabung sebagai
                        anggota tim</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.index') }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Submission Saya
                </a>
            </div>

            {{-- Team Submissions --}}
            <div class="space-y-4">
                @forelse ($memberOf as $membership)
                    @php $submission = $membership->submission; @endphp
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                {{-- Left: Info --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $submission->session->nama_sesi ?? '-' }}</h3>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700">
                                            <i class="fas fa-user-friends mr-1 text-[8px]"></i> Anggota
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-user mr-1"></i>
                                        Ketua: <strong>{{ $submission->user->name ?? '-' }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Dibuat {{ $submission->created_at->format('d M Y H:i') }}
                                    </p>

                                    {{-- Tracking per Tahap --}}
                                    <div class="mt-3 flex flex-wrap gap-1.5">
                                        @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                                            @php
                                                $hasReviewer = $submission->reviewers->isNotEmpty() ?? false;
                                                $tracking = $st->getTrackingStatus($hasReviewer);
                                                $chipColors = [
                                                    'belum_diisi' => 'bg-gray-100 text-gray-500 border-gray-200',
                                                    'draft' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                    'diajukan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                    'sedang_direview' =>
                                                        'bg-purple-50 text-purple-700 border-purple-200',
                                                    'perbaikan' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                    'lolos' => 'bg-green-50 text-green-700 border-green-200',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $chipColors[$tracking['key']] ?? 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                                <i class="fas {{ $tracking['icon'] }} mr-1 text-[9px]"></i>
                                                T{{ $st->tahap->tahap_ke }}: {{ $tracking['short'] }}
                                            </span>
                                        @endforeach
                                    </div>

                                    {{-- Members count --}}
                                    @if ($submission->members && $submission->members->count())
                                        <div class="mt-2 flex items-center gap-3 text-xs text-gray-400">
                                            <span class="inline-flex items-center gap-1">
                                                <i class="fas fa-users text-indigo-400"></i>
                                                <strong class="text-gray-600">{{ $submission->members->count() }}</strong>
                                                anggota
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Action --}}
                                <div class="flex-shrink-0">
                                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.team.show', $submission) }}"
                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-medium rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition shadow-sm">
                                        <i class="fas fa-eye mr-1.5"></i> Lihat (Read-Only)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center mb-4">
                                <i class="fas fa-user-friends text-3xl text-indigo-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Belum tergabung di tim manapun</h3>
                            <p class="text-sm text-gray-400 mt-1">Anda belum diundang sebagai anggota submission manapun</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($memberOf->hasPages())
                <div class="mt-6">
                    {{ $memberOf->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
