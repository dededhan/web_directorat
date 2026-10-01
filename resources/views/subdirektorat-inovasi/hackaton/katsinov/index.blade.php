@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'KATSINOV Self-Assessment Generator | Hackathon UNJ')

@section('content_hackaton')
    <div class="max-w-5xl mx-auto space-y-6">
        {{-- Header & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-300">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-900 font-bold">Generator KATSINOV</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Generator KATSINOV (Self-Assessment)
                </h1>
                <p class="mt-1 text-xs text-gray-600">
                    Alat ukur mandiri Tingkat Kesiapan Inovasi (Innovation Readiness Level) untuk dokumen proposal Hackathon UNJ.
                </p>
            </div>
            <a href="{{ route('hackaton.katsinov.create') }}" class="inline-flex items-center px-4 py-2.5 bg-black hover:bg-gray-800 text-xs font-bold rounded-xl text-white transition shadow-sm self-start sm:self-auto">
                <i class="fas fa-plus mr-2"></i> Buat Assessment Baru
            </a>
        </div>

        {{-- Guide Banner --}}
        <div class="bg-[#047857] border border-emerald-600 p-5 rounded-2xl flex items-start gap-4 text-white shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center text-lg shrink-0 mt-0.5 shadow-sm">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="text-xs leading-relaxed space-y-1 text-white">
                <strong class="font-bold text-white text-sm block">Konsep Penilaian Mandiri (Self-Assessment):</strong>
                <p class="text-white/95">
                    KATSINOV diukur menggunakan <strong class="text-white font-bold">6 fase tingkat kesiapan</strong> dan <strong class="text-white font-bold">7 aspek kunci</strong> (Teknologi, Pasar, Organisasi, Manufaktur, Investasi, Kemitraan, Risiko).
                </p>
                <p class="text-white/95">
                    Sistem ini berjalan <strong class="text-white font-bold">tanpa reviewer</strong>. Peserta mengisi indikator 1 s/d 6 secara bertahap (Passing grade minimal <strong class="text-white font-bold">80.0%</strong> per level). Setelah selesai, Anda dapat langsung mengunduh file <strong class="text-white font-bold">PDF resmi bertanda tangan peserta</strong> untuk diunggah ke form pendaftaran Hackathon Tahap 1 pada field <em class="text-white font-semibold underline decoration-white/40">Hasil Katsinov</em>.
                </p>
            </div>
        </div>

        {{-- Section 1: Proposal Tim Anda --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 inline-block"></span>
                    Proposal Tim Anda & Status KATSINOV
                </h2>
                <span class="text-xs text-gray-500">{{ $submissions->count() }} Proposal Terdaftar</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($submissions as $sub)
                    @php
                        $assessment = $sub->katsinovAssessment;
                        $isKetua = $sub->user_id === auth()->id();
                    @endphp
                    <div class="bg-white border border-gray-300 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                    {{ $sub->session->nama_sesi }}
                                </span>
                                @if($assessment)
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        Level {{ $assessment->achieved_level }} ({{ number_format($assessment->overall_percentage, 1) }}%)
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                        Belum Diisi
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-base font-bold text-gray-900">
                                {{ $sub->identitas?->nama_produk ?? $sub->tema_label ?? 'Proposal: ' . $sub->session->nama_sesi }}
                            </h3>

                            <div class="text-xs text-gray-500 space-y-0.5">
                                <p>Ketua Tim: <strong class="text-gray-700">{{ $sub->user->name }}</strong></p>
                                <p>Status Anda: <span class="font-semibold text-gray-700">{{ $isKetua ? 'Ketua Tim' : 'Anggota Tim' }}</span></p>
                                @if($sub->identitas?->bidang_utama_produk)
                                    <p>Bidang: <span class="text-gray-600">{{ $sub->identitas->bidang_utama_produk }}</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2 flex-wrap">
                            @if($assessment)
                                <a href="{{ route('hackaton.katsinov.download_pdf', $assessment->id) }}" class="inline-flex items-center px-3 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                    <i class="fas fa-file-pdf mr-1.5"></i> Unduh PDF
                                </a>
                                <a href="{{ route('hackaton.katsinov.edit', $assessment->id) }}" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition">
                                    <i class="fas fa-edit mr-1.5"></i> Edit Assessment
                                </a>
                            @else
                                <a href="{{ route('hackaton.katsinov.create', ['submission_id' => $sub->id]) }}" class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow-sm w-full justify-center">
                                    <i class="fas fa-play mr-1.5"></i> Mulai Self-Assessment KATSINOV
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 bg-white border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-500">
                        <i class="fas fa-folder-open text-3xl text-gray-400 mb-2"></i>
                        <p class="text-xs">Anda belum memiliki proposal terdaftar. Anda tetap dapat membuat assessment mandiri dengan tombol <strong>+ Buat Assessment Baru</strong> di atas.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Section 2: Riwayat Semua Assessment --}}
        @if($assessments->count() > 0)
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">
                        Daftar Riwayat Self-Assessment KATSINOV
                    </h2>
                    <span class="text-xs text-gray-500">{{ $assessments->count() }} Dokumen</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-[10px] font-bold uppercase tracking-wider text-gray-500 bg-gray-50">
                                <th class="p-3">Inovasi / Judul</th>
                                <th class="p-3">Proposal Tim</th>
                                <th class="p-3 text-center">Level Capaian</th>
                                <th class="p-3 text-center">Rata-rata Skor</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs">
                            @foreach($assessments as $item)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="p-3 font-semibold text-gray-900">
                                        {{ $item->judul_inovasi }}
                                        @if($item->fokus_bidang)
                                            <span class="block text-[10px] text-gray-500 font-normal">{{ $item->fokus_bidang }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-gray-600">
                                        {{ $item->submission ? ($item->submission->identitas?->nama_produk ?? $item->submission->session->nama_sesi) : 'Stand-alone' }}
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $item->achieved_level >= 3 ? 'bg-emerald-100 text-emerald-800' : ($item->achieved_level >= 1 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700') }}">
                                            Level {{ $item->achieved_level }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center font-bold text-gray-800">
                                        {{ number_format($item->overall_percentage, 1) }}%
                                    </td>
                                    <td class="p-3 text-gray-500 text-[11px]">
                                        {{ $item->assessment_date ? $item->assessment_date->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="p-3 text-right space-x-2">
                                        <a href="{{ route('hackaton.katsinov.download_pdf', $item->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-lg text-[11px] transition shadow-sm" title="Unduh PDF">
                                            <i class="fas fa-file-pdf mr-1"></i> Unduh PDF
                                        </a>
                                        <a href="{{ route('hackaton.katsinov.edit', $item->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-lg text-[11px] transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($item->user_id === auth()->id() || in_array(auth()->user()->role ?? '', ['admin_hackaton', 'superadmin']))
                                            <form action="{{ route('hackaton.katsinov.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus assessment ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-lg text-[11px] transition" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
