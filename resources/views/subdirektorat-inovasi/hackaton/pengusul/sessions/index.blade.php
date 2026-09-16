@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Sesi Hackaton Aktif | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6">
        <div class="border-b border-gray-200 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Pendaftaran Kegiatan</p>
                <h1 class="text-2xl font-bold text-gray-900">Sesi Hackaton Aktif</h1>
                <p class="mt-1 text-sm text-gray-500">Pilih sesi Hackaton yang dibuka untuk mendaftarkan proposal dan inovasi tim Anda.</p>
            </div>
            <a href="{{ route('hackaton.submissions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-file-alt mr-2 text-amber-500"></i> Proposal Saya
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($sessions as $session)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif
                            </span>
                            <span class="text-xs font-medium text-gray-500">
                                {{ $session->tahap->count() }} Tahapan
                            </span>
                        </div>

                        <h2 class="text-lg font-bold text-gray-900 leading-snug hover:text-amber-600 transition">
                            <a href="{{ route('hackaton.sessions.show', $session) }}">{{ $session->nama_sesi }}</a>
                        </h2>

                        @if ($session->deskripsi)
                            <p class="mt-2 text-xs text-gray-600 line-clamp-3 leading-relaxed">{{ $session->deskripsi }}</p>
                        @endif

                        <div class="mt-4 pt-4 border-t border-gray-100 space-y-2 text-xs text-gray-500">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt w-4 text-amber-500"></i>
                                <span>{{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-users w-4 text-amber-500"></i>
                                <span>Tim: {{ $session->min_anggota }} - {{ $session->max_anggota }} Orang</span>
                            </div>
                            @if ($session->dana_maksimal)
                                <div class="flex items-center gap-2 font-medium text-gray-700">
                                    <i class="fas fa-coins w-4 text-amber-500"></i>
                                    <span>Plafon: Hingga Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">
                            {{ $session->submissions_count }} Pendaftar
                        </span>
                        <a href="{{ route('hackaton.sessions.show', $session) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-gray-900 text-xs font-bold rounded-xl hover:bg-amber-600 transition shadow-sm">
                            Lihat & Daftar <i class="fas fa-arrow-right ml-1.5"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                    <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center text-amber-500 text-2xl mx-auto mb-4">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Belum Ada Sesi Hackaton Aktif</h3>
                    <p class="mt-1 text-sm text-gray-500 max-w-md mx-auto">Saat ini belum ada periode kegiatan Hackaton yang sedang dibuka oleh admin. Silakan cek kembali secara berkala.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
