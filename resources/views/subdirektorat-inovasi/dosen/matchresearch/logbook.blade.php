@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- ... Bagian Header (tidak berubah) ... --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Logbook Proposal</li>
                </ol>
            </nav>
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                <h1 class="text-2xl font-bold text-gray-800">Riwayat dan Logbook Proposal</h1>
                <p class="mt-2 text-gray-600 text-base leading-relaxed break-words">{{ $submission->judul_proposal }}</p>
                <div class="mt-4 pt-4 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
                    <span class="text-gray-500">Sesi: <strong class="text-gray-700">{{ $submission->session->nama_sesi }}</strong></span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-teal-100 text-teal-800 border-2 border-teal-200">
                        Status Saat Ini: {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                    </span>
                </div>
            </div>
        </header>

        {{-- ... Bagian Detail Proposal (tidak berubah) ... --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
            <h2 class="text-xl font-bold text-gray-800 border-b pb-4 mb-4">Detail Proposal</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                {{-- Kolom Kiri --}}
                <div>
                    <dl class="space-y-4">
                        <div>
                            <dt class="font-semibold text-gray-700">Ketua Tim</dt>
                            <dd class="text-gray-600 mt-1">{{ $submission->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Anggota Tim</dt>
                            <dd class="text-gray-600 mt-1">
                                <ul class="list-disc list-inside">
                                    @forelse ($submission->members as $member)
                                        <li>{{ $member->user->name ?? 'Anggota Internasional' }}</li>
                                    @empty
                                        <li>Tidak ada anggota.</li>
                                    @endforelse
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
                {{-- Kolom Kanan --}}
                <div>
                    <dl class="space-y-4">
                        <div>
                            <dt class="font-semibold text-gray-700">Laporan & Dokumen</dt>
                            <dd class="text-gray-600 mt-1">
                                @if($submission->report)
                                <ul class="space-y-2">
                                    @if($submission->report->proposal_path)
                                    <li><a href="#" class="text-teal-600 hover:underline">Unduh Proposal</a></li>
                                    @endif
                                    @if($submission->report->article_path)
                                    <li><a href="#" class="text-teal-600 hover:underline">Unduh Artikel</a></li>
                                    @endif
                                    @if($submission->report->submit_proof_path)
                                    <li><a href="#" class="text-teal-600 hover:underline">Unduh Bukti Submit</a></li>
                                    @endif
                                     @if($submission->report->setneg_approval_path)
                                    <li><a href="#" class="text-teal-600 hover:underline">Unduh Persetujuan Setneg</a></li>
                                    @endif
                                </ul>
                                @else
                                <p>Belum ada laporan yang diunggah.</p>
                                @endif
                            </dd>
                        </div>
                         @if($submission->rejection_note)
                        <div>
                             <dt class="font-semibold text-red-700">Catatan Penolakan</dt>
                             <dd class="text-red-600 mt-1 bg-red-50 p-3 rounded-lg">{{ $submission->rejection_note }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        {{-- --- UPDATE DI SINI --- --}}
        {{-- Timeline Riwayat --}}
        <h2 class="text-xl font-bold text-gray-800 mb-4">Riwayat Perubahan Status</h2>
        <div class="flow-root">
            @forelse (array_reverse($submission->status_history ?? []) as $log)
                <div class="relative pb-8">
                    @if (!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    @endif
                    <div class="relative flex items-start space-x-4">
                        <div>
                            <div class="h-8 w-8 rounded-full bg-teal-500 flex items-center justify-center ring-8 ring-white">
                                <i class='bx bxs-check-circle text-white text-lg'></i>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5">
                            <p class="text-sm font-semibold text-gray-800">
                                Status berubah menjadi '<span class="text-teal-700">{{ ucwords(str_replace('_', ' ', $log['status'])) }}</span>'
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($log['timestamp'])->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                            </p>
                            @if (!empty($log['notes']))
                            <div class="mt-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg p-4">
                                <p class="text-sm text-yellow-800 leading-relaxed">{{ $log['notes'] }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 text-center py-16 px-6">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-5">
                            <i class='bx bx-history text-4xl text-gray-400'></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800">Belum Ada Riwayat</h3>
                        <p class="text-gray-500 mt-2">Belum ada perubahan status atau catatan yang tercatat untuk proposal ini.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

