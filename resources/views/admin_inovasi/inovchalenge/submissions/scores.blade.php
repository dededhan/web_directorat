@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}"
                            class="hover:text-teal-600">Innovation Challenge</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.show', $session) }}"
                            class="hover:text-teal-600">{{ Str::limit($session->nama_sesi, 30) }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.submissions.index', $session) }}"
                            class="hover:text-teal-600">Submissions</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-700 font-medium">Peringkat Skor</li>
                </ol>
            </nav>

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-trophy text-yellow-500"></i> Peringkat Skor Reviewer
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $session->nama_sesi }} &mdash; diurutkan berdasarkan rata-rata
                        skor reviewer</p>
                </div>
                <a href="{{ route('admin_inovasi.inovchalenge.submissions.index', $session) }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Submissions
                </a>
            </div>

            @php
                $ranked = $submissions->filter(fn($s) => $scoreMap[$s->id]['total'] !== null);
                $unranked = $submissions->filter(fn($s) => $scoreMap[$s->id]['total'] === null);
            @endphp

            {{-- Stats Summary --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total Submission</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-teal-600">{{ $ranked->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Sudah Dinilai</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-orange-500">{{ $unranked->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Belum Dinilai</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    @php $topScore = $ranked->first() ? $scoreMap[$ranked->first()->id]['total'] : null; @endphp
                    <p class="text-2xl font-bold text-yellow-600">{{ $topScore !== null ? $topScore : '—' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Skor Tertinggi</p>
                </div>
            </div>

            {{-- Ranking Table --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg">
                        <i class="fas fa-medal mr-2"></i> Peringkat Submission Dinilai
                        <span
                            class="ml-2 bg-white/20 text-white text-sm px-3 py-0.5 rounded-full">{{ $ranked->count() }}</span>
                    </h2>
                </div>

                @if ($ranked->isEmpty())
                    <div class="p-12 text-center text-gray-400">
                        <i class="fas fa-star text-4xl mb-3 opacity-30"></i>
                        <p class="text-sm">Belum ada submission yang mendapat skor dari reviewer.</p>
                    </div>
                @else
                    {{-- Desktop --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">
                                        Rank</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Dosen / Produk</th>
                                    @foreach ($tahapList as $tahap)
                                        <th
                                            class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ $tahap->nama_tahap }}
                                        </th>
                                    @endforeach
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Reviewer</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Total Avg</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($ranked as $i => $sub)
                                    @php
                                        $sm = $scoreMap[$sub->id];
                                        $total = $sm['total'];
                                        $rank = $i + 1;
                                        $rankBg = match ($rank) {
                                            1 => 'bg-yellow-400 text-white shadow-yellow-200',
                                            2 => 'bg-gray-400 text-white shadow-gray-200',
                                            3 => 'bg-orange-400 text-white shadow-orange-200',
                                            default => 'bg-gray-100 text-gray-500',
                                        };
                                        $scoreBg =
                                            $total >= 80
                                                ? 'text-green-700 bg-green-50 border-green-200'
                                                : ($total >= 60
                                                    ? 'text-cyan-700 bg-cyan-50 border-cyan-200'
                                                    : ($total >= 40
                                                        ? 'text-yellow-700 bg-yellow-50 border-yellow-200'
                                                        : 'text-red-700 bg-red-50 border-red-200'));
                                        $barColor =
                                            $total >= 80
                                                ? 'from-green-400 to-green-600'
                                                : ($total >= 60
                                                    ? 'from-cyan-400 to-cyan-600'
                                                    : ($total >= 40
                                                        ? 'from-yellow-400 to-yellow-600'
                                                        : 'from-red-400 to-red-600'));
                                    @endphp
                                    <tr
                                        class="hover:bg-gray-50 {{ $rank <= 3 ? 'bg-gradient-to-r from-yellow-50/40 to-transparent' : '' }}">
                                        <td class="px-4 py-4 text-center">
                                            <span
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-full font-bold text-sm shadow {{ $rankBg }}">
                                                @if ($rank === 1)
                                                    <i class="fas fa-crown"></i>
                                                @elseif($rank === 2)
                                                    <i class="fas fa-medal"></i>
                                                @elseif($rank === 3)
                                                    <i class="fas fa-award"></i>
                                                    @else{{ $rank }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-gray-900">{{ $sub->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $sub->user->email }}</p>
                                            @if ($sub->identitas?->nama_produk)
                                                <p class="text-xs text-teal-600 mt-0.5"><i
                                                        class="fas fa-lightbulb mr-1 text-[9px]"></i>{{ $sub->identitas->nama_produk }}
                                                </p>
                                            @endif
                                        </td>
                                        @foreach ($tahapList as $tahap)
                                            @php $ts = $sm['per_tahap'][$tahap->id] ?? null; @endphp
                                            <td class="px-4 py-4 text-center">
                                                @if ($ts !== null)
                                                    @php
                                                        $tsBg =
                                                            $ts >= 80
                                                                ? 'text-green-700 bg-green-50 border-green-200'
                                                                : ($ts >= 60
                                                                    ? 'text-cyan-700 bg-cyan-50 border-cyan-200'
                                                                    : ($ts >= 40
                                                                        ? 'text-yellow-700 bg-yellow-50 border-yellow-200'
                                                                        : 'text-red-700 bg-red-50 border-red-200'));
                                                    @endphp
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold border {{ $tsBg }}">
                                                        {{ $ts }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-300">—</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="px-4 py-4 text-center text-sm text-gray-500">
                                            {{ $sub->reviewers_count }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex flex-col items-center gap-1">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-bold border {{ $scoreBg }}">
                                                    {{ $total }}
                                                </span>
                                                <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r {{ $barColor }} rounded-full"
                                                        style="width: {{ $total }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <a href="{{ route('admin_inovasi.inovchalenge.submissions.show', [$session, $sub]) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition">
                                                <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile --}}
                    <div class="lg:hidden divide-y divide-gray-100">
                        @foreach ($ranked as $i => $sub)
                            @php
                                $sm = $scoreMap[$sub->id];
                                $total = $sm['total'];
                                $rank = $i + 1;
                                $rankBg = match ($rank) {
                                    1 => 'bg-yellow-400 text-white',
                                    2 => 'bg-gray-400 text-white',
                                    3 => 'bg-orange-400 text-white',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                                $barColor =
                                    $total >= 80
                                        ? 'from-green-400 to-green-600'
                                        : ($total >= 60
                                            ? 'from-cyan-400 to-cyan-600'
                                            : ($total >= 40
                                                ? 'from-yellow-400 to-yellow-600'
                                                : 'from-red-400 to-red-600'));
                            @endphp
                            <div class="p-4 {{ $rank <= 3 ? 'bg-yellow-50/40' : '' }}">
                                <div class="flex items-center gap-3 mb-2">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm {{ $rankBg }}">{{ $rank }}</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $sub->user->name }}</p>
                                        @if ($sub->identitas?->nama_produk)
                                            <p class="text-xs text-teal-600 truncate">{{ $sub->identitas->nama_produk }}
                                            </p>
                                        @endif
                                    </div>
                                    <span
                                        class="text-xl font-bold {{ $total >= 80 ? 'text-green-600' : ($total >= 60 ? 'text-cyan-600' : ($total >= 40 ? 'text-yellow-600' : 'text-red-600')) }}">
                                        {{ $total }}
                                    </span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden mb-3">
                                    <div class="h-full bg-gradient-to-r {{ $barColor }} rounded-full"
                                        style="width: {{ $total }}%"></div>
                                </div>
                                <div class="flex flex-wrap gap-1.5 mb-2">
                                    @foreach ($tahapList as $tahap)
                                        @php $ts = $sm['per_tahap'][$tahap->id] ?? null; @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">
                                            {{ $tahap->nama_tahap }}: {{ $ts !== null ? $ts : '—' }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('admin_inovasi.inovchalenge.submissions.show', [$session, $sub]) }}"
                                        class="text-teal-600 text-xs font-medium hover:underline">Detail →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Unranked (no reviews yet) --}}
            @if ($unranked->isNotEmpty())
                <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-400 to-gray-500 px-6 py-3">
                        <h2 class="text-white font-semibold">
                            <i class="fas fa-hourglass-half mr-2"></i> Belum Dinilai
                            <span
                                class="ml-2 bg-white/20 text-white text-sm px-2 py-0.5 rounded-full">{{ $unranked->count() }}</span>
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach ($unranked as $sub)
                            <div class="px-6 py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $sub->user->name }}</p>
                                    @if ($sub->identitas?->nama_produk)
                                        <p class="text-xs text-gray-400">{{ $sub->identitas->nama_produk }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-400"><i
                                            class="fas fa-user-check mr-1"></i>{{ $sub->reviewers_count }} reviewer</span>
                                    <a href="{{ route('admin_inovasi.inovchalenge.submissions.show', [$session, $sub]) }}"
                                        class="text-teal-600 text-xs font-medium hover:underline">Detail →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
