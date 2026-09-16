@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Proposal Tim Lain | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6">
        <div class="border-b border-gray-200 pb-5">
            <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Partisipasi Kolaborasi</p>
            <h1 class="text-2xl font-bold text-gray-900">Proposal Tim Lain</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar proposal di mana Anda terdaftar sebagai Anggota Tim (bukan Ketua).</p>
        </div>

        <div class="space-y-4">
            @forelse ($memberOf as $memberRow)
                @php
                    $sub = $memberRow->submission;
                @endphp
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="space-y-2 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                {{ $sub->session->nama_sesi }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-purple-100 text-purple-900">
                                Peran Anda: {{ $memberRow->peran_ic }} ({{ $memberRow->getTipeLabel() }})
                            </span>
                        </div>

                        <h2 class="text-lg font-bold text-gray-900">
                            {{ $sub->identitas?->nama_produk ?? 'Proposal: ' . $sub->session->nama_sesi }}
                        </h2>

                        <p class="text-xs text-gray-500">
                            Ketua Tim: <strong>{{ $sub->user->name }}</strong> ({{ $sub->user->email }})
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        @php
                            $badge = $memberRow->getApprovalBadge();
                        @endphp
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $badge['color'] }}">
                            <i class="{{ $badge['icon'] }} mr-1"></i> {{ $badge['label'] }}
                        </span>

                        <a href="{{ route('hackaton.team.show', $sub) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow">
                            Lihat Berkas Tim <i class="fas fa-arrow-right ml-1.5"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                    <p class="text-sm text-gray-400 italic">Anda belum terdaftar sebagai anggota pada proposal tim manapun.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
