@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> /
                    <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="hover:underline">{{ $session->nama_sesi }}</a> /
                    Ranking
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Ranking Nilai Proposal</h1>
                <p class="mt-2 text-base text-gray-700">Urutan peringkat berdasarkan akumulasi rata-rata skor dari dewan penilai / reviewer.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin_hackaton.submissions.scores.export', $session) }}" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="bg-white hover:bg-gray-100 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-arrow-left"></i> Kembali ke Sesi
                </a>
            </div>
        </div>

        {{-- Table Ranking --}}
        <div class="border-2 border-gray-950 bg-white overflow-hidden">
            <div class="border-b-2 border-gray-950 bg-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 uppercase tracking-wider text-sm flex items-center gap-2">
                    <i class="fas fa-trophy text-amber-500"></i> Peringkat Penilaian Reviewer
                </h2>
                <span class="bg-gray-950 text-white text-xs font-bold px-2.5 py-1">{{ $submissions->count() }} Proposal</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-950 bg-white text-xs uppercase tracking-wider text-gray-700">
                            <th class="p-4 w-12 text-center">Rank</th>
                            <th class="p-4">Pengusul / Ketua</th>
                            <th class="p-4">Nama Produk & Skema</th>
                            @foreach ($tahapList as $thp)
                                <th class="p-4 text-center">Skor T{{ $thp->tahap_ke }}</th>
                            @endforeach
                            <th class="p-4 text-center">Total Skor</th>
                            <th class="p-4 text-center">Reviewer</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($submissions as $sub)
                            @php
                                $sm = $scoreMap[$sub->id] ?? null;
                                $total = $sm['total'] ?? null;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center font-black text-gray-950">
                                    @if ($loop->iteration === 1 && $total)
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-amber-400 text-gray-950 font-black text-xs border border-black">1</span>
                                    @elseif ($loop->iteration === 2 && $total)
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-300 text-gray-950 font-black text-xs border border-black">2</span>
                                    @elseif ($loop->iteration === 3 && $total)
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-amber-700 text-white font-black text-xs border border-black">3</span>
                                    @else
                                        {{ $loop->iteration }}
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-950">{{ $sub->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $sub->user->email ?? '-' }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $sub->identitas?->nama_produk ?? '— Belum Diisi —' }}</div>
                                    <div class="text-xs text-gray-500">{{ $sub->identitas?->skema_inovasi ?? '-' }}</div>
                                </td>
                                @foreach ($tahapList as $thp)
                                    @php
                                        $tScore = $sm['per_tahap'][$thp->id] ?? null;
                                    @endphp
                                    <td class="p-4 text-center text-xs font-bold">
                                        @if (!is_null($tScore))
                                            <span class="px-2 py-1 bg-gray-100 border border-gray-300">{{ $tScore }}</span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="p-4 text-center">
                                    @if (!is_null($total))
                                        <span class="inline-flex items-center px-3 py-1 font-black text-sm bg-gray-950 text-white">
                                            {{ $total }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum dinilai</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center text-xs text-gray-600">
                                    {{ $sub->reviewers->count() }} Ditugaskan
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin_hackaton.submissions.show', [$session, $sub]) }}" class="bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-3 py-2 hover:bg-gray-800 transition">
                                        Lihat Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 6 + count($tahapList) }}" class="p-8 text-center text-gray-500 italic">
                                    Belum ada data proposal untuk dinilai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
