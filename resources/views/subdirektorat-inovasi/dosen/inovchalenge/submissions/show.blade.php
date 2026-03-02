@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $submission->session->nama_sesi }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Submission #{{ $submission->id }}</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.index') }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif

            {{-- ═══ Identitas Tim Banner ═══ --}}
            @if (!$submission->identitasIsComplete())
                <div
                    class="mb-6 p-4 bg-orange-50 border border-orange-200 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-start gap-3 text-orange-700">
                        <i class="fas fa-exclamation-triangle text-lg mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-sm">Identitas Tim belum lengkap</p>
                            <p class="text-xs mt-0.5 text-orange-600">Lengkapi Identitas Tim &amp; tambahkan minimal 1
                                anggota non-Ketua sebelum mengisi tahap.</p>
                        </div>
                    </div>
                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission) }}"
                        class="flex-shrink-0 inline-flex items-center px-4 py-2 bg-orange-500 text-white text-xs font-semibold rounded-xl hover:bg-orange-600 transition shadow-sm">
                        <i class="fas fa-id-card mr-1.5"></i> Lengkapi Identitas
                    </a>
                </div>
            @else
                {{-- Identitas summary card --}}
                <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-id-card text-teal-500"></i> Identitas Tim &amp; Produk
                        </h2>
                        <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission) }}"
                            class="text-xs text-teal-600 hover:text-teal-800 font-medium flex items-center gap-1">
                            <i class="fas fa-edit text-[11px]"></i> Edit
                        </a>
                    </div>
                    <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Nama Produk</p>
                            <p class="text-gray-800 font-semibold">{{ $submission->identitas?->nama_produk ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Skema Inovasi</p>
                            <p class="text-gray-700 text-xs">{{ $submission->identitas?->skema_inovasi ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Bidang Utama</p>
                            <p class="text-gray-700 text-xs">{{ $submission->identitas?->bidang_utama_produk ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ═══ Anggota Tim ═══ --}}
            <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-users text-indigo-500"></i> Anggota Tim
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $submission->members->count() }} orang
                        </span>
                    </h2>
                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission) }}"
                        class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                        <i class="fas fa-user-plus text-[11px]"></i> Kelola
                    </a>
                </div>
                <div class="px-5 py-3">
                    @if ($submission->members->count())
                        <div class="flex flex-wrap gap-3">
                            @foreach ($submission->members as $member)
                                @php $badge = $member->getApprovalBadge(); @endphp
                                <div
                                    class="flex items-center gap-2.5 bg-gray-50 rounded-xl px-3 py-2 border border-gray-100">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $member->nama_lengkap }}
                                        </p>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-[10px] text-gray-400">{{ $member->getTipeLabel() }}</span>
                                            @if ($member->peran === 'Ketua')
                                                <span
                                                    class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold bg-indigo-100 text-indigo-700">
                                                    <i class="fas fa-crown mr-0.5 text-[7px]"></i> Ketua
                                                </span>
                                            @endif
                                            <span
                                                class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold {{ $badge['color'] }}">
                                                <i class="{{ $badge['icon'] }} mr-0.5 text-[7px]"></i>
                                                {{ $badge['label'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @php
                            $pendingCount = $submission->members->where('approval_status', 'pending')->count();
                        @endphp
                        @if ($pendingCount > 0)
                            <div
                                class="mt-3 flex items-center gap-2 text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                                <i class="fas fa-clock"></i>
                                <span><strong>{{ $pendingCount }}</strong> anggota menunggu approval</span>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-400 text-center py-2">Belum ada anggota tim</p>
                    @endif
                </div>
            </div>

            {{-- ═══ Tracking Progress Per Tahap ═══ --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-tasks text-teal-500"></i> Tracking Progress
                </h2>

                {{-- Progress Steps (horizontal tracker) --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                    <div class="p-5">
                        <div class="flex items-center justify-between relative">
                            @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $idx => $st)
                                @php
                                    $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                                    $stepColors = [
                                        'belum_diisi' => 'bg-gray-200 text-gray-500',
                                        'draft' => 'bg-yellow-400 text-white',
                                        'diajukan' => 'bg-blue-500 text-white',
                                        'sedang_direview' => 'bg-purple-500 text-white',
                                        'perbaikan' => 'bg-orange-500 text-white',
                                        'lolos' => 'bg-green-500 text-white',
                                    ];
                                    $lineColors = [
                                        'lolos' => 'bg-green-400',
                                        'default' => 'bg-gray-200',
                                    ];
                                @endphp
                                <div class="flex flex-col items-center flex-1 relative z-10">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center text-sm font-bold shadow-md {{ $stepColors[$tracking['key']] ?? 'bg-gray-200 text-gray-500' }}">
                                        <i class="fas {{ $tracking['icon'] }}"></i>
                                    </div>
                                    <p class="mt-2 text-xs font-bold text-gray-700 text-center">Tahap
                                        {{ $st->tahap->tahap_ke }}</p>
                                    <p
                                        class="text-[11px] text-center font-semibold mt-0.5 {{ $tracking['key'] === 'lolos' ? 'text-green-600' : ($tracking['key'] === 'perbaikan' ? 'text-orange-600' : 'text-gray-500') }}">
                                        {{ $tracking['short'] }}
                                    </p>
                                </div>
                                @if (!$loop->last)
                                    <div
                                        class="flex-1 h-1 rounded {{ $tracking['key'] === 'lolos' ? 'bg-green-400' : 'bg-gray-200' }} -mt-6 mx-1">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3-Tahap Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                    @php
                        $tahap = $st->tahap;
                        $isEditable = $st->isEditable();
                        $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                        $timingStatus = $tahap->getTimingStatus();

                        $trackingBadgeColors = [
                            'belum_diisi' => 'bg-gray-100 text-gray-600',
                            'draft' => 'bg-yellow-100 text-yellow-700',
                            'diajukan' => 'bg-blue-100 text-blue-700',
                            'sedang_direview' => 'bg-purple-100 text-purple-700',
                            'perbaikan' => 'bg-orange-100 text-orange-700',
                            'lolos' => 'bg-green-100 text-green-700',
                        ];

                        $timingBadge = match ($timingStatus) {
                            'belum_dibuka' => [
                                'label' => 'Belum Dibuka',
                                'color' => 'bg-red-100 text-red-600',
                                'icon' => 'fa-lock',
                            ],
                            'ditutup' => [
                                'label' => 'Ditutup',
                                'color' => 'bg-gray-200 text-gray-500',
                                'icon' => 'fa-ban',
                            ],
                            default => [
                                'label' => 'Dibuka',
                                'color' => 'bg-green-100 text-green-600',
                                'icon' => 'fa-unlock',
                            ],
                        };

                        $headerGradient = match ($tracking['key']) {
                            'lolos' => 'from-green-500 to-green-600',
                            'perbaikan' => 'from-orange-500 to-orange-600',
                            'sedang_direview' => 'from-purple-500 to-purple-600',
                            'diajukan' => 'from-blue-500 to-blue-600',
                            'draft' => 'from-yellow-500 to-yellow-600',
                            default => 'from-teal-500 to-teal-600',
                        };
                    @endphp
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition {{ $timingStatus === 'belum_dibuka' ? 'opacity-60' : '' }}">
                        {{-- Tahap Header --}}
                        <div class="bg-gradient-to-r {{ $headerGradient }} px-5 py-4 text-white">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-lg font-bold">
                                    {{ $tahap->tahap_ke }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-sm">{{ $tahap->nama_tahap }}</h3>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 mt-1 rounded-full text-[10px] font-bold bg-white/20 text-white/90">
                                        <i class="fas {{ $tracking['icon'] }} mr-1"></i>{{ $tracking['short'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 space-y-3">
                            {{-- Timing badge --}}
                            @if ($tahap->periode_awal && $tahap->periode_akhir)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-xs text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                        {{ $tahap->periode_awal->format('d M Y') }} –
                                        {{ $tahap->periode_akhir->format('d M Y') }}
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $timingBadge['color'] }}">
                                        <i
                                            class="fas {{ $timingBadge['icon'] }} mr-1 text-[8px]"></i>{{ $timingBadge['label'] }}
                                    </span>
                                </div>
                            @endif

                            {{-- Tracking Status Badge --}}
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $trackingBadgeColors[$tracking['key']] ?? 'bg-gray-100 text-gray-600' }}">
                                    <i class="fas {{ $tracking['icon'] }} mr-1.5 text-[10px]"></i>{{ $tracking['label'] }}
                                </span>
                            </div>

                            {{-- Submitted at --}}
                            @if ($st->submitted_at)
                                <p class="text-[11px] text-gray-400">
                                    <i class="fas fa-paper-plane mr-1"></i> Diajukan
                                    {{ $st->submitted_at->format('d M Y H:i') }}
                                </p>
                            @endif

                            {{-- Admin note --}}
                            @if ($st->catatan_admin)
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-xs text-orange-700">
                                    <i class="fas fa-comment-alt mr-1"></i> <strong>Catatan
                                        Admin:</strong><br>{{ $st->catatan_admin }}
                                </div>
                            @endif

                            {{-- Action button --}}
                            <div class="pt-2">
                                @if (!$submission->identitasIsComplete())
                                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-orange-100 text-orange-600 text-sm font-medium rounded-xl hover:bg-orange-200 transition">
                                        <i class="fas fa-lock mr-1.5"></i> Lengkapi Identitas Dulu
                                    </a>
                                @elseif ($timingStatus === 'belum_dibuka')
                                    <button disabled
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-400 text-sm font-medium rounded-xl cursor-not-allowed">
                                        <i class="fas fa-lock mr-1.5"></i> Belum Dibuka
                                    </button>
                                @elseif ($isEditable)
                                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap', [$submission, $tahap->id]) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-teal-600 hover:to-teal-700 transition shadow-sm">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        {{ $st->status === 'belum_diisi' ? 'Isi Formulir' : 'Edit Formulir' }}
                                    </a>
                                @else
                                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap', [$submission, $tahap->id]) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                                        <i class="fas fa-eye mr-1.5"></i> Lihat Detail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ═══ Riwayat Perubahan Status ═══ --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">
                        <i class="fas fa-bell mr-2 text-teal-500"></i>Notifikasi &amp; Riwayat Status
                    </h2>
                    @if ($submission->statusLogs->count() > 5)
                        <span class="text-xs text-gray-400">{{ $submission->statusLogs->count() }} aktivitas</span>
                    @endif
                </div>
                <div class="p-6">
                    @if ($submission->statusLogs->count())
                        <div class="relative">
                            {{-- Timeline line --}}
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                            <div class="space-y-0">
                                @foreach ($submission->statusLogs->take(20) as $log)
                                    @php
                                        $dotColors = [
                                            'draft' => 'bg-yellow-400',
                                            'diajukan' => 'bg-blue-500',
                                            'menunggu' => 'bg-gray-400',
                                            'menunggu_direview' => 'bg-yellow-500',
                                            'sedang_direview' => 'bg-purple-500',
                                            'disetujui' => 'bg-green-500',
                                            'perbaikan' => 'bg-orange-500',
                                            'perbaikan_diperlukan' => 'bg-orange-500',
                                            'selesai' => 'bg-teal-500',
                                            'proses_tahap_selanjutnya' => 'bg-cyan-500',
                                            'belum_diisi' => 'bg-gray-300',
                                        ];
                                        $dotColor = $dotColors[$log->status_ke] ?? 'bg-gray-400';

                                        $roleColors = [
                                            'dosen' => 'text-teal-600',
                                            'admin' => 'text-indigo-600',
                                            'system' => 'text-gray-500',
                                        ];
                                        $roleColor = $roleColors[$log->causer_role] ?? 'text-gray-500';

                                        $roleBadge = match ($log->causer_role) {
                                            'admin' => 'bg-indigo-100 text-indigo-700',
                                            'dosen' => 'bg-teal-100 text-teal-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <div class="relative pl-10 pb-5">
                                        {{-- Dot --}}
                                        <div
                                            class="absolute left-2.5 top-1 w-3 h-3 rounded-full {{ $dotColor }} ring-2 ring-white shadow-sm z-10">
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-1">
                                            <div class="flex-1">
                                                {{-- Status change text --}}
                                                <p class="text-sm text-gray-800 font-medium leading-snug">
                                                    @if ($log->tipe === 'tahap' && $log->tahap)
                                                        <span
                                                            class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 mr-1">
                                                            T{{ $log->tahap->tahap_ke }}
                                                        </span>
                                                    @endif
                                                    {{ $log->keterangan ?? $log->getStatusLabel($log->status_ke) }}
                                                </p>

                                                {{-- From → To badges --}}
                                                <div class="flex items-center gap-1.5 mt-1">
                                                    @if ($log->status_dari)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-500">
                                                            {{ $log->getStatusLabel($log->status_dari) }}
                                                        </span>
                                                        <i class="fas fa-arrow-right text-[8px] text-gray-300"></i>
                                                    @endif
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ str_replace('bg-', 'bg-', $dotColor) }} bg-opacity-20 {{ $roleColor }}">
                                                        <i class="fas {{ $log->getStatusIcon() }} mr-1 text-[8px]"></i>
                                                        {{ $log->getStatusLabel($log->status_ke) }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Timestamp + role --}}
                                            <div class="flex items-center gap-2 flex-shrink-0 mt-1 sm:mt-0">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $roleBadge }}">
                                                    {{ ucfirst($log->causer_role ?? 'system') }}
                                                </span>
                                                <span class="text-[11px] text-gray-400 whitespace-nowrap">
                                                    <i class="far fa-clock mr-0.5"></i>
                                                    {{ $log->created_at->format('d M Y') }}
                                                    <span
                                                        class="font-semibold">{{ $log->created_at->format('H:i') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($submission->statusLogs->count() > 20)
                                <div class="pl-10 pt-2 text-xs text-gray-400">
                                    <i class="fas fa-ellipsis-h mr-1"></i> +{{ $submission->statusLogs->count() - 20 }}
                                    aktivitas lainnya
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-bell-slash text-xl text-gray-300"></i>
                            </div>
                            <p class="text-sm text-gray-400">Belum ada riwayat perubahan status</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
