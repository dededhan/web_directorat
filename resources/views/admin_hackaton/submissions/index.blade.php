@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> /
                    <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="hover:underline">{{ $session->nama_sesi }}</a> /
                    Proposal
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Daftar Proposal Hackaton</h1>
                <p class="mt-2 text-base text-gray-700">Proposal pengusul untuk sesi: <strong>{{ $session->nama_sesi }}</strong></p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin_hackaton.submissions.scores', $session) }}" class="bg-amber-500 hover:bg-amber-600 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-trophy"></i> Ranking Nilai
                </a>
                <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="bg-white hover:bg-gray-100 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-arrow-left"></i> Kembali ke Sesi
                </a>
            </div>
        </div>

        {{-- Filter & Search --}}
        <div class="border-2 border-gray-950 bg-white p-5">
            <form method="GET" action="{{ route('admin_hackaton.submissions.index', $session) }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengusul atau ketua..."
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-gray-950 text-white px-5 py-2.5 text-xs font-bold uppercase tracking-wider hover:bg-gray-800">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin_hackaton.submissions.index', $session) }}" class="border-2 border-gray-950 bg-white px-4 py-2.5 text-xs font-bold uppercase text-gray-700 hover:bg-gray-100">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Submissions Table --}}
        <div class="border-2 border-gray-950 bg-white overflow-hidden">
            <div class="border-b-2 border-gray-950 bg-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 uppercase tracking-wider text-sm flex items-center gap-2">
                    <i class="fas fa-file-alt"></i> Semua Proposal Masuk
                </h2>
                <span class="bg-gray-950 text-white text-xs font-bold px-2.5 py-1">{{ $submissions->total() }} Proposal</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-950 bg-white text-xs uppercase tracking-wider text-gray-700">
                            <th class="p-4 w-12 text-center">#</th>
                            <th class="p-4">Ketua Tim / Pengusul</th>
                            <th class="p-4">Produk & Skema</th>
                            <th class="p-4 text-center">Anggota</th>
                            <th class="p-4 text-center">Progress Tahapan</th>
                            <th class="p-4 text-center">Reviewer</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($submissions as $sub)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center text-gray-500 font-semibold">
                                    {{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-950">{{ $sub->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $sub->user->email ?? '-' }}</div>
                                    <span class="inline-block mt-1 text-[10px] font-bold uppercase px-2 py-0.5 border border-gray-300 bg-gray-100 text-gray-700">
                                        {{ ucfirst(str_replace('hackaton_', '', $sub->user->role ?? 'pengusul')) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $sub->identitas?->nama_produk ?? '— Belum Diisi —' }}</div>
                                    @if ($sub->identitas?->bidang_utama_produk)
                                        <div class="text-[11px] text-gray-400 mt-0.5">Bidang: {{ $sub->identitas->bidang_utama_produk }}</div>
                                    @endif
                                    @if ($sub->tema)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold {{ str_contains($sub->tema, 'D-FARM') ? 'bg-amber-100 text-amber-950 border border-amber-300' : 'bg-rose-100 text-rose-950 border border-rose-300' }}">
                                                <i class="fas {{ str_contains($sub->tema, 'D-FARM') ? 'fa-wheat-awn' : 'fa-heart-pulse' }} mr-1"></i>
                                                {{ str_contains($sub->tema, 'D-FARM') ? 'D-FARM' : 'D-MARC' }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-bold bg-purple-100 text-purple-900 border border-purple-300">
                                        <i class="fas fa-users mr-1 text-[10px]"></i> {{ $sub->members->count() }} orang
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                                            @php
                                                $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                                                $tracking = $st->getTrackingStatus($hasReviewerMap[$sub->id] ?? false);
                                                $badgeBg = match ($tracking['key']) {
                                                    'lolos' => 'bg-emerald-600 text-white',
                                                    'perbaikan' => 'bg-amber-500 text-black',
                                                    'sedang_direview' => 'bg-purple-600 text-white',
                                                    'menunggu_review' => 'bg-blue-600 text-white',
                                                    'draft' => 'bg-amber-200 text-amber-900',
                                                    default => 'bg-gray-200 text-gray-600'
                                                };
                                            @endphp
                                            <span class="w-6 h-6 text-xs font-black flex items-center justify-center {{ $badgeBg }}" title="Tahap {{ $tk }}: {{ $tracking['label'] }}">
                                                T{{ $tk }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-4 text-center text-xs">
                                    @if ($sub->reviewers->isNotEmpty())
                                        <span class="inline-flex items-center px-2 py-1 font-bold bg-blue-100 text-blue-900 border border-blue-300">
                                            {{ $sub->reviewers->count() }} Reviewer
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic text-[11px]">Belum diassign</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin_hackaton.submissions.show', [$session, $sub]) }}" class="bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-3 py-2 hover:bg-gray-800 transition">
                                            Detail & Review
                                        </a>

                                        <form action="{{ route('admin_hackaton.submissions.destroy', [$session, $sub]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus submission ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="border border-rose-300 bg-white text-rose-600 p-2 text-xs hover:bg-rose-50" title="Hapus Proposal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 italic">
                                    Belum ada proposal yang diajukan pada sesi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($submissions->hasPages())
                <div class="p-4 border-t-2 border-gray-950 bg-gray-50">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
