@extends('subdirektorat-inovasi.tendik.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Hero Header --}}
            <div
                class="relative bg-gradient-to-br from-teal-600 via-teal-500 to-emerald-500 rounded-3xl overflow-hidden mb-8 px-8 py-10">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="700" cy="50" r="150" fill="white" />
                        <circle cx="100" cy="350" r="120" fill="white" />
                        <circle cx="400" cy="200" r="80" fill="white" />
                    </svg>
                </div>
                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold mb-3">
                            <i class="fas fa-trophy mr-1.5"></i> INNOVATION CHALLENGE
                        </div>
                        <h1 class="text-3xl font-extrabold text-white">Sesi Challenge</h1>
                        <p class="mt-1.5 text-teal-100 text-sm max-w-lg">Pilih sesi yang sedang aktif dan mulai ajukan
                            proposal inovasi Anda.</p>
                    </div>
                    <a href="{{ route('subdirektorat-inovasi.tendik.inovchalenge.submissions.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-white text-teal-700 font-semibold text-sm rounded-xl hover:bg-teal-50 transition shadow-sm flex-shrink-0">
                        <i class="fas fa-folder-open mr-2"></i> Submission Saya
                    </a>
                </div>
            </div>

            {{-- Sessions --}}
            @if ($sessions->isNotEmpty())
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach ($sessions as $session)
                        @php
                            $now = now();
                            $totalDays = max(
                                (int) ceil($session->periode_awal->diffInDays($session->periode_akhir)),
                                1,
                            );
                            $elapsed = max((int) ceil($session->periode_awal->diffInDays($now)), 0);
                            $progress = min(round(($elapsed / $totalDays) * 100), 100);
                            $daysLeft = max((int) ceil($now->diffInDays($session->periode_akhir, false)), 0);

                            $openTahap = $session->tahap->filter(fn($t) => $t->getTimingStatus() === 'dibuka')->count();
                            $totalTahap = $session->tahap->count();
                        @endphp
                        <a href="{{ route('subdirektorat-inovasi.tendik.inovchalenge.sessions.show', $session) }}"
                            class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-teal-200 transition-all duration-300 overflow-hidden flex flex-col">

                            {{-- Top section --}}
                            <div class="p-6 flex-1">
                                {{-- Title row --}}
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div
                                            class="w-11 h-11 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                                            <i class="fas fa-trophy text-white text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <h3
                                                class="text-base font-bold text-gray-900 truncate group-hover:text-teal-700 transition-colors">
                                                {{ $session->nama_sesi }}</h3>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $session->periode_awal->format('d M Y') }} —
                                                {{ $session->periode_akhir->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if ($daysLeft > 0)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-teal-50 text-teal-700 text-xs font-bold flex-shrink-0">
                                            {{ $daysLeft }} hari lagi
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-bold flex-shrink-0">
                                            Berakhir
                                        </span>
                                    @endif
                                </div>

                                {{-- Description --}}
                                @if ($session->deskripsi)
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-4 leading-relaxed">
                                        {{ $session->deskripsi }}</p>
                                @endif

                                {{-- Stats chips --}}
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if ($session->dana_minimal || $session->dana_maksimal)
                                        <div
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-medium">
                                            <i class="fas fa-coins text-[10px]"></i>
                                            @if ($session->dana_minimal && $session->dana_maksimal)
                                                Rp {{ number_format($session->dana_minimal / 1000000, 0) }}jt —
                                                {{ number_format($session->dana_maksimal / 1000000, 0) }}jt
                                            @elseif ($session->dana_maksimal)
                                                Maks Rp {{ number_format($session->dana_maksimal / 1000000, 0) }}jt
                                            @else
                                                Min Rp {{ number_format($session->dana_minimal / 1000000, 0) }}jt
                                            @endif
                                        </div>
                                    @endif
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 text-xs font-medium">
                                        <i class="fas fa-users text-[10px]"></i>
                                        {{ $session->min_anggota ?? 1 }}–{{ $session->max_anggota ?? 4 }} anggota
                                    </div>
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">
                                        <i class="fas fa-layer-group text-[10px]"></i>
                                        {{ $totalTahap }} tahap
                                    </div>
                                </div>

                                {{-- Tahap timeline dots --}}
                                @if ($totalTahap > 0)
                                    <div class="flex items-center gap-1.5">
                                        @foreach ($session->tahap as $tahap)
                                            @php
                                                $ts = $tahap->getTimingStatus();
                                                $dotClass = match ($ts) {
                                                    'dibuka' => 'bg-green-500 ring-green-200',
                                                    'ditutup' => 'bg-gray-300 ring-gray-100',
                                                    default => 'bg-gray-200 ring-gray-100',
                                                };
                                                $lineClass = match ($ts) {
                                                    'dibuka' => 'bg-green-300',
                                                    'ditutup' => 'bg-gray-200',
                                                    default => 'bg-gray-100',
                                                };
                                            @endphp
                                            @if (!$loop->first)
                                                <div class="flex-1 h-0.5 {{ $lineClass }} rounded-full max-w-[40px]">
                                                </div>
                                            @endif
                                            <div class="flex items-center gap-1.5"
                                                title="T{{ $tahap->tahap_ke }}: {{ $tahap->judul ?? $tahap->nama_tahap }} ({{ ucfirst(str_replace('_', ' ', $ts)) }})">
                                                <div
                                                    class="w-5 h-5 rounded-full {{ $dotClass }} ring-2 flex items-center justify-center">
                                                    <span
                                                        class="text-[8px] font-bold text-white">{{ $tahap->tahap_ke }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                        <span class="text-[10px] text-gray-400 ml-1">
                                            {{ $openTahap }}/{{ $totalTahap }} dibuka
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Bottom bar --}}
                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                                
                                <div class="flex items-center gap-1.5">
                                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-teal-400 to-teal-600 rounded-full"
                                            style="width: {{ $progress }}%"></div>
                                    </div>
                                    <span class="text-[10px] text-gray-400">{{ $progress }}%</span>
                                    <i
                                        class="fas fa-chevron-right text-[10px] text-teal-400 ml-1 group-hover:translate-x-0.5 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-teal-100 to-emerald-200 rounded-3xl flex items-center justify-center mb-5">
                            <i class="fas fa-trophy text-3xl text-teal-500"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700">Belum Ada Sesi Aktif</h3>
                        <p class="text-sm text-gray-400 mt-1.5 max-w-sm">Silakan tunggu admin membuka sesi Innovation
                            Challenge baru.</p>
                    </div>
                </div>
            @endif

            @if ($sessions->hasPages())
                <div class="mt-6">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
