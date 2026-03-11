@extends('subdirektorat-inovasi.tendik.index')

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
                <a href="{{ route('subdirektorat-inovasi.tendik.inovchalenge.submissions.index') }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Submission Saya
                </a>
            </div>

            @php
                $pending = $memberOf->getCollection()->where('approval_status', 'pending');
                $approved = $memberOf->getCollection()->where('approval_status', 'approved');
                $notReq = $memberOf->getCollection()->where('approval_status', 'not_required');
                $rejected = $memberOf->getCollection()->where('approval_status', 'rejected');
                $active = $approved->merge($notReq);
            @endphp

            {{-- ═══ Pending Invitations ═══ --}}
            @if ($pending->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-amber-200 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-amber-100 bg-amber-50">
                        <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-envelope text-amber-500"></i> Undangan Menunggu Respon
                            <span
                                class="bg-amber-200 text-amber-800 text-xs rounded-full px-2.5 py-0.5 font-bold">{{ $pending->count() }}</span>
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @foreach ($pending as $membership)
                            @php $submission = $membership->submission; @endphp
                            <div class="p-4 rounded-xl border-2 border-amber-200 bg-amber-50/50">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-gray-800">
                                            {{ $submission->session->nama_sesi ?? '-' }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            <i class="fas fa-user mr-1"></i> Diundang oleh: <span
                                                class="font-semibold">{{ $submission->user->name ?? '-' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            Sebagai: <span
                                                class="font-semibold">{{ ucfirst($membership->tipe_anggota) }}</span>
                                            &middot; {{ $membership->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2 flex-shrink-0">
                                        <form method="POST"
                                            action="{{ route('subdirektorat-inovasi.tendik.inovchalenge.invitations.approve', $membership) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition shadow-sm">
                                                <i class="fas fa-check mr-1.5"></i> Terima
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('subdirektorat-inovasi.tendik.inovchalenge.invitations.reject', $membership) }}"
                                            onsubmit="return confirm('Tolak undangan ini?')">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition shadow-sm">
                                                <i class="fas fa-times mr-1.5"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ═══ Active Team Submissions ═══ --}}
            <div class="space-y-4">
                @if ($active->count() > 0)
                    @foreach ($active as $membership)
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
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle mr-1 text-[8px]"></i> Anggota Aktif
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
                                                    <strong
                                                        class="text-gray-600">{{ $submission->members->count() }}</strong>
                                                    anggota
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Action --}}
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('subdirektorat-inovasi.tendik.inovchalenge.team.show', $submission) }}"
                                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-medium rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition shadow-sm">
                                            <i class="fas fa-eye mr-1.5"></i> Lihat (Read-Only)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @elseif ($pending->count() === 0)
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
                @endif
            </div>

            {{-- ═══ Rejected Invitations ═══ --}}
            @if ($rejected->count() > 0)
                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-3 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-gray-500 flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-400"></i> Undangan Ditolak
                        </h2>
                    </div>
                    <div class="p-4 space-y-2">
                        @foreach ($rejected as $membership)
                            @php $submission = $membership->submission; @endphp
                            <div class="flex items-center justify-between p-3 rounded-lg border border-red-100 bg-red-50">
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-800">
                                        {{ $submission->session->nama_sesi ?? '-' }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Ketua: {{ $submission->user->name ?? '-' }}</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Pagination --}}
            @if ($memberOf->hasPages())
                <div class="mt-6">
                    {{ $memberOf->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
