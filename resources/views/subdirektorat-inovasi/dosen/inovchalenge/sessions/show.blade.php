@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    @php
        $now = now();
        $totalDays = max((int) ceil($session->periode_awal->diffInDays($session->periode_akhir)), 1);
        $elapsed = max((int) ceil($session->periode_awal->diffInDays($now)), 0);
        $progress = min(round(($elapsed / $totalDays) * 100), 100);
        $daysLeft = max((int) ceil($now->diffInDays($session->periode_akhir, false)), 0);
        $totalTahap = $session->tahap->count();
        $openTahap = $session->tahap->filter(fn($t) => $t->getTimingStatus() === 'dibuka')->count();
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.sessions.index') }}"
                            class="text-gray-400 hover:text-teal-600 transition">
                            <i class="fas fa-trophy mr-1 text-xs"></i> Innovation Challenge
                        </a></li>
                    <li><i class="fas fa-chevron-right text-[10px] text-gray-300"></i></li>
                    <li class="text-gray-700 font-semibold">{{ $session->nama_sesi }}</li>
                </ol>
            </nav>

            {{-- Hero Card --}}
            <div
                class="relative bg-gradient-to-br from-teal-600 via-teal-500 to-emerald-500 rounded-3xl overflow-hidden mb-8">
                {{-- Decorative --}}
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="680" cy="30" r="120" fill="white" />
                        <circle cx="80" cy="280" r="100" fill="white" />
                    </svg>
                </div>

                <div class="relative px-8 pt-8 pb-6">
                    {{-- Title + CTA --}}
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <div>
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold mb-3">
                                <i class="fas fa-trophy mr-1.5"></i> INNOVATION CHALLENGE
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                                {{ $session->nama_sesi }}</h1>
                            @if ($session->deskripsi)
                                <p class="mt-2 text-teal-100 text-sm leading-relaxed max-w-2xl">{{ $session->deskripsi }}
                                </p>
                            @endif
                        </div>
                        <div class="flex-shrink-0">
                            @if ($existingSubmission)
                                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $existingSubmission) }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-white text-teal-700 font-bold text-sm rounded-xl hover:bg-teal-50 transition shadow-sm">
                                    <i class="fas fa-folder-open mr-2"></i> Lihat Submission
                                </a>
                            @elseif(isset($existingMembership) && $existingMembership)
                                <div class="text-right">
                                    <div
                                        class="inline-flex items-center px-4 py-2 bg-white/20 text-white text-sm font-semibold rounded-xl mb-2">
                                        <i class="fas fa-users mr-2"></i> Anda sudah menjadi anggota tim
                                    </div>
                                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.team.show', $existingMembership->submission) }}"
                                        class="block inline-flex items-center px-5 py-2.5 bg-white text-teal-700 font-bold text-sm rounded-xl hover:bg-teal-50 transition shadow-sm">
                                        <i class="fas fa-eye mr-2"></i> Lihat Tim Saya
                                    </a>
                                </div>
                            @else
                                <form
                                    action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.store', $session) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-white text-teal-700 font-bold text-sm rounded-xl hover:bg-teal-50 transition shadow-sm"
                                        onclick="return confirm('Mulai proposal untuk sesi ini?')">
                                        <i class="fas fa-plus mr-2"></i> Mulai Proposal
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Stats row --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3">
                            <p class="text-teal-200 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Periode</p>
                            <p class="text-white text-sm font-bold">{{ $session->periode_awal->format('d M') }} —
                                {{ $session->periode_akhir->format('d M Y') }}</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3">
                            <p class="text-teal-200 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Dana</p>
                            <p class="text-white text-sm font-bold">
                                @if ($session->dana_minimal && $session->dana_maksimal)
                                    Rp {{ number_format($session->dana_minimal / 1000000, 0) }}jt —
                                    {{ number_format($session->dana_maksimal / 1000000, 0) }}jt
                                @elseif ($session->dana_maksimal)
                                    Maks Rp {{ number_format($session->dana_maksimal / 1000000, 0) }}jt
                                @elseif ($session->dana_minimal)
                                    Min Rp {{ number_format($session->dana_minimal / 1000000, 0) }}jt
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3">
                            <p class="text-teal-200 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Tim</p>
                            <p class="text-white text-sm font-bold">{{ $session->min_anggota ?? 1 }} –
                                {{ $session->max_anggota ?? 4 }} orang</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3">
                            <p class="text-teal-200 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Sisa Waktu
                            </p>
                            <p class="text-white text-sm font-bold">
                                @if ($daysLeft > 0)
                                    {{ $daysLeft }} hari lagi
                                @else
                                    Berakhir
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div class="px-8 pb-4">
                    <div class="flex items-center justify-between text-[10px] text-teal-200 mb-1">
                        <span>Progress Periode</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="h-1.5 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-white rounded-full transition-all" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Tahapan Section --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-layer-group text-teal-500"></i> Tahapan
                    </h3>
                    <span class="text-xs text-gray-400 font-medium">{{ $openTahap }}/{{ $totalTahap }} tahap
                        dibuka</span>
                </div>

                {{-- Vertical timeline --}}
                <div class="space-y-4">
                    @foreach ($session->tahap as $tahap)
                        @php
                            $ts = $tahap->getTimingStatus();
                            $isOpen = $ts === 'dibuka';
                            $isClosed = $ts === 'ditutup';
                            $isLocked = $ts === 'belum_dibuka';

                            $stepColors = [
                                1 => [
                                    'bg' => 'from-blue-500 to-blue-600',
                                    'light' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'ring' => 'ring-blue-200',
                                ],
                                2 => [
                                    'bg' => 'from-purple-500 to-purple-600',
                                    'light' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'ring' => 'ring-purple-200',
                                ],
                                3 => [
                                    'bg' => 'from-orange-500 to-orange-600',
                                    'light' => 'bg-orange-50 text-orange-700 border-orange-200',
                                    'ring' => 'ring-orange-200',
                                ],
                            ];
                            $sc = $stepColors[$tahap->tahap_ke] ?? $stepColors[1];

                            $statusConfig = match ($ts) {
                                'dibuka' => [
                                    'label' => 'Dibuka',
                                    'color' => 'bg-green-100 text-green-700',
                                    'icon' => 'fa-unlock',
                                    'dot' => 'bg-green-500',
                                ],
                                'ditutup' => [
                                    'label' => 'Ditutup',
                                    'color' => 'bg-gray-100 text-gray-500',
                                    'icon' => 'fa-ban',
                                    'dot' => 'bg-gray-400',
                                ],
                                default => [
                                    'label' => 'Belum Dibuka',
                                    'color' => 'bg-red-50 text-red-500',
                                    'icon' => 'fa-lock',
                                    'dot' => 'bg-red-400',
                                ],
                            };

                            $daysLeftTahap = null;
                            if ($tahap->periode_akhir && $isOpen) {
                                $daysLeftTahap = max((int) ceil($now->diffInDays($tahap->periode_akhir, false)), 0);
                            }
                        @endphp

                        <div class="flex gap-4 {{ $isLocked ? 'opacity-50' : '' }}">
                            {{-- Timeline connector --}}
                            <div class="flex flex-col items-center flex-shrink-0 w-10">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-gradient-to-br {{ $sc['bg'] }} flex items-center justify-center text-white font-bold text-sm shadow-sm {{ $isOpen ? 'ring-4 ' . $sc['ring'] : '' }}">
                                    @if ($isClosed)
                                        <i class="fas fa-check text-sm"></i>
                                    @else
                                        {{ $tahap->tahap_ke }}
                                    @endif
                                </div>
                                @if (!$loop->last)
                                    <div
                                        class="w-0.5 flex-1 mt-2 {{ $isOpen || $isClosed ? 'bg-gray-300' : 'bg-gray-200' }} rounded-full">
                                    </div>
                                @endif
                            </div>

                            {{-- Card --}}
                            <div
                                class="flex-1 bg-white rounded-2xl border {{ $isOpen ? 'border-gray-200 shadow-sm' : 'border-gray-100' }} p-5 mb-1">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div>
                                        <h4 class="text-base font-bold text-gray-900">
                                            {{ $tahap->judul ?? $tahap->nama_tahap }}</h4>
                                        @if ($tahap->deskripsi)
                                            <p class="text-sm text-gray-500 mt-0.5 leading-relaxed">{{ $tahap->deskripsi }}
                                            </p>
                                        @endif
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold flex-shrink-0 {{ $statusConfig['color'] }}">
                                        <i class="fas {{ $statusConfig['icon'] }} mr-1 text-[8px]"></i>
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </div>

                                {{-- Meta row --}}
                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    @if ($tahap->periode_awal && $tahap->periode_akhir)
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                            <i class="far fa-calendar text-[10px]"></i>
                                            {{ $tahap->periode_awal->format('d M') }} —
                                            {{ $tahap->periode_akhir->format('d M Y') }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                        <i class="fas fa-list text-[10px]"></i>
                                        {{ $tahap->fields->count() }} field
                                    </span>
                                    @if ($daysLeftTahap !== null)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold {{ $daysLeftTahap <= 3 ? 'bg-red-50 text-red-600' : 'bg-teal-50 text-teal-700' }}">
                                            <i class="fas fa-clock text-[8px]"></i>
                                            {{ $daysLeftTahap }} hari lagi
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bottom CTA --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                @if ($existingSubmission)
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Anda sudah memiliki submission</p>
                            <p class="text-xs text-gray-400 mt-0.5">Lanjutkan mengisi tahapan proposal Anda</p>
                        </div>
                        <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $existingSubmission) }}"
                            class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold text-sm rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-sm">
                            <i class="fas fa-folder-open mr-2"></i> Lihat Submission Saya
                        </a>
                    </div>
                @else
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center">
                            <i class="fas fa-rocket text-teal-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Siap mengajukan proposal?</p>
                            <p class="text-xs text-gray-400 mt-0.5">Klik tombol di bawah untuk memulai</p>
                        </div>
                        <form action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.store', $session) }}"
                            method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-sm rounded-xl hover:from-teal-600 hover:to-teal-700 transition shadow-sm"
                                onclick="return confirm('Mulai proposal untuk sesi ini?')">
                                <i class="fas fa-plus mr-2"></i> Mulai Proposal
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
