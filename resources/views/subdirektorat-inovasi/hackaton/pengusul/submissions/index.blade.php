@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Proposal Saya | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6">
        <div class="border-b border-gray-200 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Pengajuan Saya</p>
                <h1 class="text-2xl font-bold text-gray-900">Proposal Hackaton Saya</h1>
                <p class="mt-1 text-sm text-gray-500">Daftar proposal di mana Anda terdaftar sebagai Ketua Tim pengusul.</p>
            </div>
            <a href="{{ route('hackaton.sessions.index') }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-gray-900 text-xs font-bold rounded-xl hover:bg-amber-600 transition shadow-sm">
                <i class="fas fa-plus mr-1.5"></i> Ajukan ke Sesi Baru
            </a>
        </div>

        <div class="space-y-4">
            @forelse ($submissions as $sub)
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                    {{ $sub->session->nama_sesi }}
                                </span>
                                @if ($sub->identitasIsComplete())
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check-circle mr-1"></i> Identitas Lengkap
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Identitas Belum Lengkap
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-lg font-bold text-gray-900">
                                <a href="{{ route('hackaton.submissions.show', $sub) }}" class="hover:text-amber-600 transition">
                                    {{ $sub->identitas?->nama_produk ?? '— Belum Mengisi Nama Produk —' }}
                                </a>
                            </h2>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                <span><i class="fas fa-users mr-1 text-amber-500"></i> {{ $sub->members->count() }} Anggota Tim</span>
                                @if ($sub->identitas?->skema_inovasi)
                                    <span><i class="fas fa-lightbulb mr-1 text-amber-500"></i> {{ $sub->identitas->skema_inovasi }}</span>
                                @endif
                                <span><i class="fas fa-clock mr-1 text-amber-500"></i> Dibuat: {{ $sub->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        {{-- Tahap Status Pills --}}
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="flex items-center gap-2">
                                @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                                    @php
                                        $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                                        $tracking = $st->getTrackingStatus($sub->reviewers->isNotEmpty());
                                        $pillBg = match ($tracking['key']) {
                                            'lolos' => 'bg-emerald-600 text-white',
                                            'perbaikan' => 'bg-amber-500 text-black',
                                            'sedang_direview' => 'bg-purple-600 text-white',
                                            'menunggu_review' => 'bg-blue-600 text-white',
                                            'draft' => 'bg-amber-200 text-amber-900',
                                            default => 'bg-gray-100 text-gray-500'
                                        };
                                    @endphp
                                    <div class="text-center">
                                        <span class="w-8 h-8 rounded-lg text-xs font-black flex items-center justify-center {{ $pillBg }}" title="Tahap {{ $tk }}: {{ $tracking['label'] }}">
                                            T{{ $tk }}
                                        </span>
                                        <span class="text-[9px] font-bold text-gray-400 block mt-1 uppercase">{{ $tracking['short'] ?? 'Belum' }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <a href="{{ route('hackaton.submissions.show', $sub) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow">
                                Buka Progress <i class="fas fa-arrow-right ml-1.5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                    <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center text-amber-500 text-2xl mx-auto mb-4">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Belum Ada Proposal yang Diajukan</h3>
                    <p class="mt-1 text-sm text-gray-500 max-w-md mx-auto">Anda belum mengajukan proposal pada sesi Hackaton manapun. Buka menu Sesi Hackaton untuk mulai mendaftar.</p>
                    <a href="{{ route('hackaton.sessions.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-amber-500 text-gray-900 text-xs font-bold rounded-xl hover:bg-amber-600 transition shadow-sm">
                        Lihat Sesi Aktif
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
