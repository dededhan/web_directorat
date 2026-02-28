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
                <div class="mb-6 p-4 bg-orange-50 border border-orange-200 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-start gap-3 text-orange-700">
                        <i class="fas fa-exclamation-triangle text-lg mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-sm">Identitas Tim belum lengkap</p>
                            <p class="text-xs mt-0.5 text-orange-600">Lengkapi Identitas Tim &amp; tambahkan minimal 1 anggota non-Ketua sebelum mengisi tahap.</p>
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

            {{-- Overall Status --}}
            @php
                $overallColors = [
                    'draft' => 'from-gray-400 to-gray-500',
                    'diajukan' => 'from-blue-400 to-blue-500',
                    'menunggu_direview' => 'from-yellow-400 to-yellow-500',
                    'sedang_direview' => 'from-purple-400 to-purple-500',
                    'perbaikan_diperlukan' => 'from-orange-400 to-orange-500',
                    'proses_tahap_selanjutnya' => 'from-cyan-400 to-cyan-500',
                    'selesai' => 'from-green-400 to-green-500',
                ];
                $statusKey = is_object($submission->status) ? $submission->status->value : $submission->status;
            @endphp
            <div
                class="bg-gradient-to-r {{ $overallColors[$statusKey] ?? 'from-gray-400 to-gray-500' }} rounded-2xl p-5 mb-8 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-xs font-medium uppercase tracking-wider">Status Keseluruhan</p>
                        <p class="text-lg font-bold mt-0.5">{{ ucwords(str_replace('_', ' ', $statusKey)) }}</p>
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
            </div>

            {{-- 3-Tahap Progress Tracker --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                    @php
                        $tahap = $st->tahap;
                        $isEditable = $st->isEditable();
                        $statusMap = [
                            'belum_diisi' => ['icon' => 'fa-circle', 'color' => 'gray', 'label' => 'Belum Diisi'],
                            'draft' => ['icon' => 'fa-edit', 'color' => 'yellow', 'label' => 'Draft'],
                            'diajukan' => ['icon' => 'fa-check-circle', 'color' => 'green', 'label' => 'Diajukan'],
                        ];
                        $adminMap = [
                            'menunggu' => ['icon' => 'fa-clock', 'color' => 'gray', 'label' => 'Menunggu'],
                            'disetujui' => ['icon' => 'fa-thumbs-up', 'color' => 'green', 'label' => 'Disetujui'],
                            'perbaikan' => ['icon' => 'fa-redo', 'color' => 'orange', 'label' => 'Perbaikan'],
                            'selesai' => ['icon' => 'fa-flag-checkered', 'color' => 'blue', 'label' => 'Selesai'],
                        ];
                        $s = $statusMap[$st->status] ?? $statusMap['belum_diisi'];
                        $a = $adminMap[$st->admin_status] ?? $adminMap['menunggu'];
                    @endphp
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">
                        {{-- Tahap Header --}}
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-5 py-4 text-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-lg font-bold">
                                        {{ $tahap->tahap_ke }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-sm">{{ $tahap->judul }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 space-y-4">
                            {{-- Description --}}
                            @if ($tahap->deskripsi)
                                <p class="text-xs text-gray-500">{{ Str::limit($tahap->deskripsi, 80) }}</p>
                            @endif

                            {{-- Period --}}
                            @if ($tahap->periode_awal && $tahap->periode_akhir)
                                <div class="flex items-center text-xs text-gray-400">
                                    <i class="fas fa-calendar-alt mr-1.5"></i>
                                    {{ $tahap->periode_awal->format('d M Y') }} –
                                    {{ $tahap->periode_akhir->format('d M Y') }}
                                </div>
                            @endif

                            {{-- Submission Status --}}
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400 w-16">Dosen:</span>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-{{ $s['color'] }}-100 text-{{ $s['color'] }}-700">
                                        <i class="fas {{ $s['icon'] }} mr-1 text-[10px]"></i>{{ $s['label'] }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400 w-16">Admin:</span>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-{{ $a['color'] }}-100 text-{{ $a['color'] }}-700">
                                        <i class="fas {{ $a['icon'] }} mr-1 text-[10px]"></i>{{ $a['label'] }}
                                    </span>
                                </div>
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

            {{-- Members --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900"><i class="fas fa-users mr-2 text-teal-500"></i>Anggota Tim
                    </h2>
                </div>
                <div class="p-6">
                    @if ($submission->members->count())
                        <div class="divide-y divide-gray-100">
                            @foreach ($submission->members as $member)
                                <div class="flex items-center justify-between py-3 {{ $loop->first ? '' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $member->nama_lengkap }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ ucfirst($member->tipe_anggota) }}{{ $member->peran ? ' — ' . $member->peran : '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($member->tipe_anggota === 'alumni')
                                            @php
                                                $apColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'approved' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $apColors[$member->approval_status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($member->approval_status) }}
                                            </span>
                                        @elseif($member->peran === 'Ketua')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-teal-100 text-teal-700">
                                                <i class="fas fa-crown mr-1 text-[9px]"></i> Ketua
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada anggota tim</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
