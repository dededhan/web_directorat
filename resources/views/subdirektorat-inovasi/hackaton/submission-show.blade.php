<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Submission | Hackaton</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        :root {
            --ink: #000000;
            --paper: #ffffff;
            --wash: #f4f4f2;
            --line: #000000;
            --muted: #666666;
            --hackaton-green: #047857;
            --hackaton-green-dark: #065f46;
        }
        * { box-shadow: none !important; border-radius: 0 !important; }
        body { background: var(--wash); color: var(--ink); font-family: 'Inter', Helvetica, Arial, sans-serif; }
        h1, h2, h3, .editorial-serif { font-family: 'Playfair Display', Georgia, serif; }
        a, button, input, select, textarea { font: inherit; }
        button:focus-visible, a:focus-visible, input:focus-visible, textarea:focus-visible { outline: 2px solid var(--ink); outline-offset: 3px; }
        .text-amber-300, .text-amber-400, .text-amber-500, .text-amber-600, .text-amber-700, .text-amber-800, .text-amber-900, .text-amber-950 { color: var(--hackaton-green) !important; }
        .bg-amber-50 { background-color: #ecfdf5 !important; } .bg-amber-100 { background-color: #d1fae5 !important; } .bg-amber-200 { background-color: #a7f3d0 !important; } .bg-amber-300 { background-color: #6ee7b7 !important; } .bg-amber-400 { background-color: #34d399 !important; } .bg-amber-500 { background-color: var(--hackaton-green) !important; } .bg-amber-600 { background-color: var(--hackaton-green-dark) !important; }
        .border-amber-200, .border-amber-300, .border-amber-400, .border-amber-500 { border-color: #6ee7b7 !important; }
        .hover\:bg-amber-600:hover { background-color: var(--hackaton-green-dark) !important; } .hover\:bg-amber-100:hover { background-color: #d1fae5 !important; } .hover\:border-amber-300:hover { border-color: #6ee7b7 !important; }
        .focus\:border-amber-500:focus { border-color: var(--hackaton-green) !important; } .focus\:ring-amber-500:focus { --tw-ring-color: var(--hackaton-green) !important; } .ring-amber-400 { --tw-ring-color: #34d399 !important; }
        a.bg-amber-500, button.bg-amber-500 { background-color: var(--hackaton-green) !important; color: #fff !important; }
        [class*="bg-gradient"][class*="from-gray-50"] { background-image: none !important; background-color: var(--wash) !important; }
        [class*="bg-gradient"][class*="from-amber"], [class*="bg-gradient"][class*="from-orange"] { background-image: none !important; background-color: var(--hackaton-green) !important; }
        [class*="bg-gradient"][class*="from-rose"], [class*="bg-gradient"][class*="from-red"] { background-image: none !important; background-color: #e11d48 !important; }
        [class*="bg-gradient"][class*="from-gray-900"], [class*="bg-gradient"][class*="via-gray-800"] { background-image: none !important; background-color: #111827 !important; }
    </style>
</head>

<body class="bg-[#f4f4f2] min-h-screen">
    @php
        $roleLabel = $roleLabel ?? (match(auth()->user()->role) {
            'hackaton_mahasiswa' => 'Mahasiswa',
            'hackaton_dosen' => 'Dosen',
            'hackaton_tendik' => 'Tenaga Kependidikan',
            'hackaton_alumni' => 'Alumni',
            'hackaton_dudi' => 'Mitra DUDI',
            'hackaton_pppk' => 'PPPK',
            'hackaton_peneliti' => 'Peneliti',
            default => auth()->user()->role,
        });
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $submission->session->nama_sesi }}</h1>
                <div class="flex items-center gap-2 mt-1">
                    <p class="text-sm text-gray-500">Submission #{{ $submission->id }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        <i class="fas fa-eye mr-1 text-[9px]"></i> Read-Only ({{ $roleLabel }})
                    </span>
                </div>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center gap-2">
                <a href="{{ route('hackaton.submissions.lembar_pengesahan', $submission) }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white font-medium text-sm rounded-xl hover:bg-emerald-800 transition shadow-sm">
                    <i class="fas fa-file-signature mr-2"></i> Lembar Pengesahan
                </a>
                <a href="{{ route('hackaton.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Read-Only Notice --}}
        <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 text-amber-800">
            <i class="fas fa-info-circle text-lg flex-shrink-0"></i>
            <div>
                <p class="font-semibold text-sm">Mode Read-Only</p>
                <p class="text-xs mt-0.5 text-amber-700">Anda tergabung sebagai anggota tim ({{ $roleLabel }}). Anda dapat melihat semua informasi tim dan dokumen formulir tahapan, namun hanya Ketua Tim yang memiliki hak akses untuk mengubah atau mengajukan berkas.</p>
            </div>
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

        {{-- ═══ Identitas Tim (Read-Only) ═══ --}}
        @if ($submission->identitas)
            <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-id-card text-amber-500"></i> Identitas Tim &amp; Produk
                    </h2>
                    <span class="text-xs text-gray-400">Ketua: <strong class="text-gray-700">{{ $submission->user->name ?? '—' }}</strong></span>
                </div>
                <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-4 gap-4 text-sm">
                    @if ($submission->tema)
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Tema Inovasi</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ str_contains($submission->tema, 'D-FARM') ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-rose-100 text-rose-900 border border-rose-300' }}">
                                <i class="fas {{ str_contains($submission->tema, 'D-FARM') ? 'fa-wheat-awn' : 'fa-heart-pulse' }} mr-1 text-[10px]"></i>
                                {{ $submission->tema_label ?? $submission->tema }}
                            </span>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Nama Produk / Karya</p>
                        <p class="text-gray-800 font-semibold">{{ $submission->identitas->nama_produk ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Skema Inovasi</p>
                        <p class="text-gray-700 text-xs">{{ $submission->identitas->skema_inovasi ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Bidang Utama</p>
                        <p class="text-gray-700 text-xs">{{ $submission->identitas->bidang_utama_produk ?? '—' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1"></i> Identitas Tim belum diisi oleh Ketua Tim.
            </div>
        @endif

        {{-- ═══ Anggota Tim (Read-Only) ═══ --}}
        <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-users text-amber-500"></i> Anggota Tim
                    <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                        {{ $submission->members->count() }} orang
                    </span>
                </h2>
            </div>
            <div class="px-5 py-3">
                @if ($submission->members->count())
                    <div class="flex flex-wrap gap-3">
                        @foreach ($submission->members as $member)
                            @php $badge = $member->getApprovalBadge(); @endphp
                            <div class="flex items-center gap-2.5 bg-gray-50 rounded-xl px-3 py-2 border border-gray-100">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $member->nama_lengkap }}
                                        @if ($member->user_id === auth()->id())
                                            <span class="text-[10px] text-amber-600 font-bold">(Anda)</span>
                                        @endif
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-[10px] text-gray-500">{{ $member->getTipeLabel() }}</span>
                                        @if ($member->peran === 'Ketua')
                                            <span class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold bg-amber-100 text-amber-800">
                                                <i class="fas fa-crown mr-0.5 text-[7px]"></i> Ketua
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold {{ $badge['color'] }}">
                                            <i class="{{ $badge['icon'] }} mr-0.5 text-[7px]"></i>
                                            {{ $badge['label'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-2">Belum ada anggota tim</p>
                @endif
            </div>
        </div>

        {{-- ═══ Tracking Progress Per Tahap ═══ --}}
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-tasks text-amber-500"></i> Tracking Progress
            </h2>

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
                            @endphp
                            <div class="flex flex-col items-center flex-1 relative z-10">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-sm font-bold shadow-md {{ $stepColors[$tracking['key']] ?? 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas {{ $tracking['icon'] }}"></i>
                                </div>
                                <p class="mt-2 text-xs font-bold text-gray-700 text-center">Tahap {{ $st->tahap->tahap_ke }}</p>
                                <p class="text-[11px] text-center font-semibold mt-0.5 {{ $tracking['key'] === 'lolos' ? 'text-green-600' : ($tracking['key'] === 'perbaikan' ? 'text-orange-600' : 'text-gray-500') }}">
                                    {{ $tracking['short'] }}
                                </p>
                            </div>
                            @if (!$loop->last)
                                <div class="flex-1 h-1 rounded {{ $tracking['key'] === 'lolos' ? 'bg-green-400' : 'bg-gray-200' }} -mt-6 mx-1"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- 3-Tahap Cards (Read-Only) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                @php
                    $tahap = $st->tahap;
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
                        'belum_dibuka' => ['label' => 'Belum Dibuka', 'color' => 'bg-red-100 text-red-600', 'icon' => 'fa-lock'],
                        'ditutup' => ['label' => 'Ditutup', 'color' => 'bg-gray-200 text-gray-500', 'icon' => 'fa-ban'],
                        default => ['label' => 'Dibuka', 'color' => 'bg-green-100 text-green-600', 'icon' => 'fa-unlock'],
                    };

                    $headerGradient = match ($tracking['key']) {
                        'lolos' => 'from-green-500 to-green-600',
                        'perbaikan' => 'from-orange-500 to-orange-600',
                        'sedang_direview' => 'from-purple-500 to-purple-600',
                        'diajukan' => 'from-blue-500 to-blue-600',
                        'draft' => 'from-yellow-500 to-yellow-600',
                        default => 'from-amber-500 to-amber-600',
                    };
                @endphp
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">
                    {{-- Tahap Header --}}
                    <div class="bg-gradient-to-r {{ $headerGradient }} px-5 py-4 text-white">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-lg font-bold">
                                {{ $tahap->tahap_ke }}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-sm">{{ $tahap->nama_tahap }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded-full text-[10px] font-bold bg-white/20 text-white/90">
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
                                    {{ $tahap->periode_awal->format('d M Y') }} – {{ $tahap->periode_akhir->format('d M Y') }}
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $timingBadge['color'] }}">
                                    <i class="fas {{ $timingBadge['icon'] }} mr-1 text-[8px]"></i>{{ $timingBadge['label'] }}
                                </span>
                            </div>
                        @endif

                        {{-- Tracking Status Badge --}}
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $trackingBadgeColors[$tracking['key']] ?? 'bg-gray-100 text-gray-600' }}">
                                <i class="fas {{ $tracking['icon'] }} mr-1.5 text-[10px]"></i>{{ $tracking['label'] }}
                            </span>
                        </div>

                        {{-- Submitted at --}}
                        @if ($st->submitted_at)
                            <p class="text-[11px] text-gray-400">
                                <i class="fas fa-paper-plane mr-1"></i> Diajukan {{ $st->submitted_at->format('d M Y H:i') }}
                            </p>
                        @endif

                        {{-- Admin note --}}
                        @if ($st->catatan_admin)
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-xs text-orange-700">
                                <i class="fas fa-comment-alt mr-1"></i> <strong>Catatan Admin:</strong><br>{{ $st->catatan_admin }}
                            </div>
                        @endif

                        {{-- Action --}}
                        <div class="pt-2">
                            @if ($st->status !== 'belum_diisi')
                                <a href="{{ route('hackaton.team.tahap', [$submission, $tahap->id]) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                                    <i class="fas fa-eye mr-1.5"></i> Lihat Detail Dokumen
                                </a>
                            @else
                                <button disabled
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-400 text-sm font-medium rounded-xl cursor-not-allowed">
                                    <i class="fas fa-minus-circle mr-1.5"></i> Belum Diisi
                                </button>
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
                    <i class="fas fa-bell mr-2 text-amber-500"></i>Notifikasi &amp; Riwayat Status
                </h2>
                @if ($submission->statusLogs->count() > 5)
                    <span class="text-xs text-gray-400">{{ $submission->statusLogs->count() }} aktivitas</span>
                @endif
            </div>
            <div class="p-6">
                @if ($submission->statusLogs->count())
                    <div class="relative">
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
                                    $roleBadge = match ($log->causer_role) {
                                        'admin' => 'bg-indigo-100 text-indigo-700',
                                        'dosen', 'ketua' => 'bg-amber-100 text-amber-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <div class="relative pl-10 pb-5">
                                    <div class="absolute left-2.5 top-1 w-3 h-3 rounded-full {{ $dotColor }} ring-2 ring-white shadow-sm z-10"></div>
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-1">
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800 font-medium leading-snug">
                                                @if ($log->tipe === 'tahap' && $log->tahap)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 mr-1">
                                                        T{{ $log->tahap->tahap_ke }}
                                                    </span>
                                                @endif
                                                {{ $log->keterangan ?? $log->getStatusLabel($log->status_ke) }}
                                            </p>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-700">
                                                    <i class="fas {{ $log->getStatusIcon() }} mr-1 text-[8px]"></i>
                                                    {{ $log->getStatusLabel($log->status_ke) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 flex-shrink-0 mt-1 sm:mt-0">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $roleBadge }}">
                                                {{ ucfirst($log->causer_role ?? 'system') }}
                                            </span>
                                            <span class="text-[11px] text-gray-400 whitespace-nowrap">
                                                <i class="far fa-clock mr-0.5"></i>
                                                {{ $log->created_at->format('d M Y') }}
                                                <span class="font-semibold">{{ $log->created_at->format('H:i') }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
</body>

</html>
