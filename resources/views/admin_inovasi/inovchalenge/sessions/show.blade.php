@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}"
                            class="hover:text-teal-600">Innovation Challenge</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-700 font-medium">{{ $session->nama_sesi }}</li>
                </ol>
            </nav>

            {{-- Session Header --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-white font-semibold text-lg">
                        <i class="fas fa-info-circle mr-2"></i> Detail Sesi
                    </h2>
                    <a href="{{ route('admin_inovasi.inovchalenge.sessions.edit', $session) }}"
                        class="inline-flex items-center px-3 py-1.5 bg-white/20 text-white text-sm rounded-lg hover:bg-white/30 transition">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Sesi</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $session->nama_sesi }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Periode</dt>
                            <dd class="mt-1 text-sm text-gray-700">{{ $session->periode_awal->format('d M Y') }} —
                                {{ $session->periode_akhir->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Status</dt>
                            <dd class="mt-1">
                                @if ($session->status === 'active')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                                @elseif($session->status === 'closed')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Closed</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Draft</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Submissions</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                <a href="{{ route('admin_inovasi.inovchalenge.submissions.index', $session) }}"
                                    class="inline-flex items-center gap-1.5 text-teal-600 hover:text-teal-800 hover:underline transition">
                                    {{ $session->submissions->count() }}
                                    <i class="fas fa-external-link-alt text-[10px]"></i>
                                </a>
                            </dd>
                        </div>
                    </div>
                    @if ($session->deskripsi)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Deskripsi</dt>
                            <dd class="text-sm text-gray-600">{{ $session->deskripsi }}</dd>
                        </div>
                    @endif
                    <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Dana Minimal</dt>
                            <dd class="mt-1 text-sm text-gray-700">
                                {{ $session->dana_minimal ? 'Rp ' . number_format($session->dana_minimal, 0, ',', '.') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Dana Maksimal</dt>
                            <dd class="mt-1 text-sm text-gray-700">
                                {{ $session->dana_maksimal ? 'Rp ' . number_format($session->dana_maksimal, 0, ',', '.') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Min Anggota</dt>
                            <dd class="mt-1 text-sm text-gray-700">{{ $session->min_anggota ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Max Anggota</dt>
                            <dd class="mt-1 text-sm text-gray-700">{{ $session->max_anggota ?? '-' }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3-Tahap Grid --}}
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-layer-group mr-2 text-teal-500"></i> Tahap Konfigurasi
                </h3>
                <span class="text-xs text-gray-400 bg-white border border-gray-200 rounded-full px-3 py-1 shadow-sm">
                    {{ $session->tahap->count() }} tahap &bull;
                    {{ $session->tahap->sum(fn($t) => $t->fields->count()) }} total fields
                </span>
            </div>

            {{-- Connector layout wrapper --}}
            <div class="relative">
                {{-- Horizontal connector line (desktop only) --}}
                <div
                    class="hidden md:block absolute top-[72px] left-[calc(33.33%+8px)] right-[calc(33.33%+8px)] h-0.5 bg-gradient-to-r from-blue-200 via-purple-200 to-orange-200 z-0">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                    @foreach ($session->tahap->sortBy('tahap_ke') as $tahap)
                        @php
                            $colors = match ($tahap->tahap_ke) {
                                1 => [
                                    'from' => 'from-blue-500',
                                    'to' => 'to-blue-600',
                                    'ring' => 'ring-blue-200',
                                    'badge' => 'bg-blue-600',
                                    'light' => 'bg-blue-50',
                                    'text' => 'text-blue-700',
                                    'border' => 'border-blue-100',
                                    'dot' => 'bg-blue-500',
                                ],
                                2 => [
                                    'from' => 'from-purple-500',
                                    'to' => 'to-purple-600',
                                    'ring' => 'ring-purple-200',
                                    'badge' => 'bg-purple-600',
                                    'light' => 'bg-purple-50',
                                    'text' => 'text-purple-700',
                                    'border' => 'border-purple-100',
                                    'dot' => 'bg-purple-500',
                                ],
                                default => [
                                    'from' => 'from-orange-500',
                                    'to' => 'to-orange-600',
                                    'ring' => 'ring-orange-200',
                                    'badge' => 'bg-orange-600',
                                    'light' => 'bg-orange-50',
                                    'text' => 'text-orange-700',
                                    'border' => 'border-orange-100',
                                    'dot' => 'bg-orange-500',
                                ],
                            };

                            $now = now();
                            $periodStatus = null;
                            if ($tahap->periode_awal && $tahap->periode_akhir) {
                                if ($now < $tahap->periode_awal) {
                                    $periodStatus = 'upcoming';
                                } elseif ($now > $tahap->periode_akhir) {
                                    $periodStatus = 'ended';
                                } else {
                                    $periodStatus = 'active';
                                }
                            }

                            $totalFields = $tahap->fields->count();
                            $requiredFields = $tahap->fields->where('is_required', true)->count();
                            $fieldTypeCounts = $tahap->fields->groupBy('field_type')->map->count();
                            $typeIcons = [
                                'text' => ['icon' => 'fa-font', 'color' => 'text-gray-500'],
                                'textarea' => ['icon' => 'fa-align-left', 'color' => 'text-gray-500'],
                                'number' => ['icon' => 'fa-hashtag', 'color' => 'text-blue-500'],
                                'date' => ['icon' => 'fa-calendar', 'color' => 'text-teal-500'],
                                'dropdown' => ['icon' => 'fa-caret-square-down', 'color' => 'text-orange-500'],
                                'checkbox' => ['icon' => 'fa-check-square', 'color' => 'text-indigo-500'],
                                'file' => ['icon' => 'fa-paperclip', 'color' => 'text-purple-500'],
                                'url' => ['icon' => 'fa-link', 'color' => 'text-cyan-500'],
                            ];
                        @endphp

                        <div
                            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex flex-col">

                            {{-- Card Header --}}
                            <div
                                class="bg-gradient-to-r {{ $colors['from'] }} {{ $colors['to'] }} px-5 py-4 flex items-center gap-4">
                                {{-- Big number badge --}}
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-white/20 ring-2 {{ $colors['ring'] }} rounded-xl flex items-center justify-center">
                                    <span class="text-white font-black text-xl leading-none">{{ $tahap->tahap_ke }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-white/70 text-[10px] uppercase tracking-widest font-semibold">Tahap
                                        {{ $tahap->tahap_ke }}</p>
                                    <h4 class="text-white font-bold text-base leading-tight truncate">
                                        {{ $tahap->nama_tahap }}</h4>
                                </div>
                            </div>

                            <div class="flex flex-col flex-1 divide-y divide-gray-100">

                                {{-- Description + Period --}}
                                <div class="px-5 pt-4 pb-3 space-y-3">
                                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 min-h-[2.5rem]">
                                        {{ $tahap->deskripsi ?: 'Belum ada deskripsi.' }}
                                    </p>

                                    {{-- Period block --}}
                                    @if ($tahap->periode_awal && $tahap->periode_akhir)
                                        <div
                                            class="rounded-xl border {{ $colors['border'] }} {{ $colors['light'] }} px-3 py-2.5">
                                            <div class="flex items-center justify-between mb-1.5">
                                                <span class="text-xs font-semibold {{ $colors['text'] }}">
                                                    <i class="fas fa-calendar-alt mr-1"></i> Periode
                                                </span>
                                                @if ($periodStatus === 'active')
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-green-100 text-green-700 border border-green-200">
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>
                                                        Berjalan
                                                    </span>
                                                @elseif($periodStatus === 'upcoming')
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                        <i class="fas fa-clock text-[8px]"></i> Akan Datang
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                                        <i class="fas fa-check text-[8px]"></i> Selesai
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-600 space-y-0.5">
                                                <div class="flex items-center gap-1.5">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full {{ $colors['dot'] }} inline-block flex-shrink-0"></span>
                                                    <span>{{ $tahap->periode_awal->format('d M Y, H:i') }}</span>
                                                </div>
                                                <div class="flex items-center gap-1.5">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-gray-300 inline-block flex-shrink-0"></span>
                                                    <span>{{ $tahap->periode_akhir->format('d M Y, H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="rounded-xl border border-dashed border-gray-200 px-3 py-2.5 text-center">
                                            <p class="text-xs text-gray-400"><i class="fas fa-calendar-times mr-1"></i>
                                                Periode belum diatur</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Feature Flags --}}
                                <div class="px-5 py-3 flex flex-wrap gap-2">
                                    @if ($tahap->has_anggota)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            <i class="fas fa-users mr-1.5"></i> Anggota Tim
                                        </span>
                                    @endif
                                    @if ($tahap->has_fakultas)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                            <i class="fas fa-university mr-1.5"></i> Fakultas
                                        </span>
                                    @endif
                                    @if (!$tahap->has_anggota && !$tahap->has_fakultas)
                                        <span class="text-xs text-gray-300 italic">Tidak ada fitur tambahan</span>
                                    @endif
                                </div>

                                {{-- Fields Stats --}}
                                <div class="px-5 py-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Form
                                            Fields</span>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-xs font-bold {{ $colors['text'] }}">{{ $totalFields }}</span>
                                            <span class="text-xs text-gray-400">total</span>
                                            @if ($totalFields > 0)
                                                <span class="text-xs text-gray-300">·</span>
                                                <span class="text-xs text-red-500">{{ $requiredFields }}</span>
                                                <span class="text-xs text-gray-400">wajib</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($totalFields > 0)
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach ($fieldTypeCounts as $type => $count)
                                                @php $ti = $typeIcons[$type] ?? ['icon' => 'fa-circle', 'color' => 'text-gray-400']; @endphp
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600">
                                                    <i
                                                        class="fas {{ $ti['icon'] }} {{ $ti['color'] }} text-[10px]"></i>
                                                    <span class="font-medium">{{ $count }}</span>
                                                    <span class="text-gray-400">{{ ucfirst($type) }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="rounded-lg border border-dashed border-gray-200 px-3 py-2 text-center">
                                            <p class="text-xs text-gray-400"><i
                                                    class="fas fa-exclamation-triangle text-yellow-400 mr-1"></i> Belum ada
                                                field</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Footer Action --}}
                                <div class="px-5 py-3 bg-gray-50 mt-auto">
                                    <a href="{{ route('admin_inovasi.inovchalenge.tahap.edit', $tahap) }}"
                                        class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-semibold {{ $colors['text'] }} {{ $colors['light'] }} rounded-xl hover:brightness-95 border {{ $colors['border'] }} transition">
                                        <i class="fas fa-cog"></i> Konfigurasi Tahap {{ $tahap->tahap_ke }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Back --}}
            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-teal-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Sesi
                </a>
                <a href="{{ route('admin_inovasi.inovchalenge.submissions.index', $session) }}"
                    class="inline-flex items-center px-5 py-2.5 bg-teal-500 text-white text-sm font-semibold rounded-xl hover:bg-teal-600 transition shadow-sm">
                    <i class="fas fa-file-alt mr-2"></i> Lihat Submissions ({{ $session->submissions->count() }})
                </a>
            </div>
        </div>
    </div>
@endsection
