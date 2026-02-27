@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Innovation Challenge</h1>
                    <p class="mt-1 text-sm text-gray-500">Daftar sesi yang sedang aktif</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.index') }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-folder-open mr-2"></i> Submission Saya
                </a>
            </div>

            {{-- Sessions Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($sessions as $session)
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition group">
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-5 py-3">
                            <h3 class="text-white font-semibold truncate">{{ $session->nama_sesi }}</h3>
                        </div>
                        <div class="p-5">
                            @if ($session->deskripsi)
                                <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $session->deskripsi }}</p>
                            @endif

                            <div class="space-y-2 text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                                    {{ $session->periode_awal->format('d M Y') }} —
                                    {{ $session->periode_akhir->format('d M Y') }}
                                </div>
                                @if ($session->dana_minimal || $session->dana_maksimal)
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-money-bill-wave w-5 text-gray-400"></i>
                                        @if($session->dana_minimal)
                                            Rp {{ number_format($session->dana_minimal, 0, ',', '.') }}
                                            @if($session->dana_maksimal) — @endif
                                        @endif
                                        @if($session->dana_maksimal)
                                            Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}
                                        @endif
                                    </div>
                                @endif
                                <div class="flex items-center">
                                    <i class="fas fa-users w-5 text-gray-400"></i>
                                    {{ $session->submissions_count }} submission(s)
                                </div>
                            </div>

                            <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.sessions.show', $session) }}"
                                class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-teal-600 hover:to-teal-700 transition">
                                <i class="fas fa-arrow-right mr-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-teal-100 to-teal-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-3xl text-teal-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Belum ada sesi aktif</h3>
                            <p class="text-sm text-gray-400 mt-1">Silakan tunggu admin membuka sesi Innovation Challenge.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($sessions->hasPages())
                <div class="mt-6">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
