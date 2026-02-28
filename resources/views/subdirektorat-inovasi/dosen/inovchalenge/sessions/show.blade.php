@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.sessions.index') }}"
                            class="hover:text-teal-600">Innovation Challenge</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-700 font-medium">{{ $session->nama_sesi }}</li>
                </ol>
            </nav>

            {{-- Session Info --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg">{{ $session->nama_sesi }}</h2>
                </div>
                <div class="p-6">
                    @if ($session->deskripsi)
                        <p class="text-sm text-gray-600 mb-4">{{ $session->deskripsi }}</p>
                    @endif
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase">Periode</dt>
                            <dd class="mt-1 text-gray-700">{{ $session->periode_awal->format('d M Y') }} —
                                {{ $session->periode_akhir->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase">Dana Minimal</dt>
                            <dd class="mt-1 text-gray-700">
                                {{ $session->dana_minimal ? 'Rp ' . number_format($session->dana_minimal, 0, ',', '.') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase">Dana Maksimal</dt>
                            <dd class="mt-1 text-gray-700">
                                {{ $session->dana_maksimal ? 'Rp ' . number_format($session->dana_maksimal, 0, ',', '.') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase">Anggota Tim</dt>
                            <dd class="mt-1 text-gray-700">{{ $session->min_anggota ?? '?' }} —
                                {{ $session->max_anggota ?? '?' }} orang</dd>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3-Tahap Overview --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="fas fa-layer-group mr-2 text-teal-500"></i> Tahapan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                @foreach ($session->tahap as $tahap)
                    @php
                        $timingStatus = $tahap->getTimingStatus();
                        $timingBadge = match ($timingStatus) {
                            'belum_dibuka' => [
                                'label' => 'Belum Dibuka',
                                'color' => 'bg-red-100 text-red-600',
                                'icon' => 'fa-lock',
                            ],
                            'ditutup' => [
                                'label' => 'Ditutup',
                                'color' => 'bg-gray-200 text-gray-500',
                                'icon' => 'fa-ban',
                            ],
                            default => [
                                'label' => 'Dibuka',
                                'color' => 'bg-green-100 text-green-600',
                                'icon' => 'fa-unlock',
                            ],
                        };
                    @endphp
                    <div
                        class="bg-white rounded-xl shadow border border-gray-100 p-5 {{ $timingStatus === 'belum_dibuka' ? 'opacity-60' : '' }}">
                        <div class="flex items-center mb-2">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-lg text-white text-sm font-bold
                            {{ $tahap->tahap_ke === 1 ? 'bg-blue-500' : ($tahap->tahap_ke === 2 ? 'bg-purple-500' : 'bg-orange-500') }}">
                                {{ $tahap->tahap_ke }}
                            </span>
                            <h4 class="ml-3 font-semibold text-gray-900">{{ $tahap->nama_tahap }}</h4>
                        </div>
                        @if ($tahap->deskripsi)
                            <p class="text-xs text-gray-500 mb-2">{{ $tahap->deskripsi }}</p>
                        @endif
                        <div class="flex flex-wrap gap-1.5">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $timingBadge['color'] }}">
                                <i class="fas {{ $timingBadge['icon'] }} mr-1"></i> {{ $timingBadge['label'] }}
                            </span>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">
                                {{ $tahap->fields->count() }} field(s)
                            </span>
                        </div>
                        @if ($tahap->periode_awal && $tahap->periode_akhir)
                            <p class="text-[10px] text-gray-400 mt-2">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $tahap->periode_awal->format('d M Y') }} — {{ $tahap->periode_akhir->format('d M Y') }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- CTA --}}
            <div class="text-center">
                @if ($existingSubmission)
                    <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $existingSubmission) }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-xl shadow hover:from-blue-600 hover:to-blue-700 transition">
                        <i class="fas fa-folder-open mr-2"></i> Lihat Submission Saya
                    </a>
                @else
                    <form action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.store', $session) }}"
                        method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-medium rounded-xl shadow hover:from-teal-600 hover:to-teal-700 transition"
                            onclick="return confirm('Mulai proposal untuk sesi ini?')">
                            <i class="fas fa-plus mr-2"></i> Mulai Proposal
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
