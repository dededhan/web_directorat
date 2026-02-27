@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Submission Saya</h1>
                <p class="mt-1 text-sm text-gray-500">Daftar proposal Innovation Challenge Anda</p>
            </div>
            <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.sessions.index') }}"
               class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Sesi Aktif
            </a>
        </div>

        {{-- Submissions --}}
        <div class="space-y-4">
            @forelse ($submissions as $submission)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            {{-- Left: Info --}}
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $submission->session->nama_sesi }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Dibuat {{ $submission->created_at->format('d M Y H:i') }}
                                </p>

                                {{-- Overall status --}}
                                <div class="mt-2">
                                    @php
                                        $statusColors = [
                                            'draft' => 'bg-gray-100 text-gray-700',
                                            'diajukan' => 'bg-blue-100 text-blue-700',
                                            'menunggu_direview' => 'bg-yellow-100 text-yellow-700',
                                            'sedang_direview' => 'bg-purple-100 text-purple-700',
                                            'perbaikan_diperlukan' => 'bg-orange-100 text-orange-700',
                                            'proses_tahap_selanjutnya' => 'bg-cyan-100 text-cyan-700',
                                            'selesai' => 'bg-green-100 text-green-700',
                                        ];
                                        $statusLabel = str_replace('_', ' ', is_object($submission->status) ? $submission->status->value : $submission->status);
                                        $statusKey = is_object($submission->status) ? $submission->status->value : $submission->status;
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucwords($statusLabel) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Right: Tahap chips --}}
                            <div class="flex flex-col gap-1.5">
                                @foreach($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                                    @php
                                        $tahapColors = [
                                            'belum_diisi' => 'bg-gray-100 text-gray-500 border-gray-200',
                                            'draft' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                            'diajukan' => 'bg-green-50 text-green-700 border-green-200',
                                        ];
                                        $adminColors = [
                                            'menunggu' => '',
                                            'disetujui' => 'ring-2 ring-green-300',
                                            'perbaikan' => 'ring-2 ring-orange-300',
                                            'selesai' => 'ring-2 ring-blue-300',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $tahapColors[$st->status] ?? '' }} {{ $adminColors[$st->admin_status] ?? '' }}">
                                        <span class="w-5 font-bold">T{{ $st->tahap->tahap_ke }}</span>
                                        <span class="ml-1">{{ ucwords(str_replace('_', ' ', $st->status)) }}</span>
                                        @if($st->admin_status !== 'menunggu')
                                            <span class="ml-1 text-[10px] opacity-75">({{ $st->admin_status }})</span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>

                            {{-- Action --}}
                            <div class="flex-shrink-0">
                                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission) }}"
                                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-teal-600 hover:to-teal-700 transition shadow-sm">
                                    <i class="fas fa-eye mr-1.5"></i> Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-teal-100 to-teal-200 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-inbox text-3xl text-teal-500"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700">Belum ada submission</h3>
                        <p class="text-sm text-gray-400 mt-1 mb-4">Buat submission dari sesi yang tersedia</p>
                        <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.sessions.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-lg hover:bg-teal-600 transition">
                            <i class="fas fa-search mr-2"></i> Lihat Sesi Aktif
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($submissions->hasPages())
            <div class="mt-6">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
