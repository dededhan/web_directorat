@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Logbook Kegiatan | Hackaton UNJ')

@section('content_hackaton')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col gap-4 border-b border-black pb-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="mb-2 flex items-center gap-2 text-xs text-gray-500">
                    <a href="{{ route('hackaton.submissions.show', $submission) }}" class="hover:text-emerald-700">Progress Proposal</a>
                    <span aria-hidden="true">/</span>
                    <span class="font-semibold text-black">Logbook</span>
                </nav>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Catatan Perkembangan</p>
                <h1 class="mt-1 text-3xl font-bold text-gray-900">Logbook Kegiatan</h1>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $submission->identitas?->nama_produk ?? 'Proposal tanpa nama produk' }} · {{ $submission->session->nama_sesi }}
                </p>
            </div>
            <a href="{{ route('hackaton.submissions.show', $submission) }}" class="inline-flex items-center justify-center border border-black bg-white px-4 py-2 text-xs font-bold uppercase tracking-wider text-black transition hover:bg-black hover:text-white">
                ← Kembali ke Proposal
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.5fr)]">
            <section class="border border-black bg-white p-6">
                <div class="mb-5 border-b border-black pb-4">
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-700">Tambah Catatan</p>
                    <h2 class="mt-1 text-xl font-bold text-gray-900">Catat kegiatan baru</h2>
                </div>

                <form method="POST" action="{{ route('hackaton.submissions.progress_logs.store', $submission) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nama_kegiatan" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-700">Nama kegiatan</label>
                        <input id="nama_kegiatan" name="nama_kegiatan" type="text" value="{{ old('nama_kegiatan') }}" required maxlength="255"
                            class="w-full border border-gray-400 px-3 py-2.5 text-sm focus:border-black focus:outline-none" placeholder="Contoh: Uji coba prototipe">
                        @error('nama_kegiatan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-700">Tanggal kegiatan</label>
                        <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                            class="w-full border border-gray-400 px-3 py-2.5 text-sm focus:border-black focus:outline-none">
                        @error('tanggal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="capaian_persen" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-700">Capaian kegiatan (%)</label>
                        <input id="capaian_persen" name="capaian_persen" type="number" value="{{ old('capaian_persen', $submission->progressLogs->max('capaian_persen') ?? 1) }}" required min="{{ max(1, (int) ($submission->progressLogs->max('capaian_persen') ?? 0)) }}" max="100"
                            class="w-full border border-gray-400 px-3 py-2.5 text-sm focus:border-black focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500">Capaian hanya dapat tetap atau meningkat. Maksimal 100%.</p>
                        @error('capaian_persen') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-black px-4 py-3 text-xs font-bold uppercase tracking-wider text-white transition hover:bg-emerald-800">
                        Simpan Progress Log
                    </button>
                </form>
            </section>

            <section class="border border-black bg-white p-6">
                <div class="mb-5 flex items-end justify-between border-b border-black pb-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-700">Riwayat</p>
                        <h2 class="mt-1 text-xl font-bold text-gray-900">Progress kegiatan</h2>
                    </div>
                    <span class="border border-black px-2 py-1 text-xs font-bold">{{ $submission->progressLogs->count() }} log</span>
                </div>

                @if ($submission->progressLogs->isEmpty())
                    <div class="border border-dashed border-gray-400 px-6 py-12 text-center">
                        <p class="text-sm font-semibold text-gray-800">Belum ada progress log.</p>
                        <p class="mt-1 text-xs text-gray-500">Tambahkan kegiatan pertama untuk mulai mencatat perkembangan proposal.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[620px] border-collapse text-left text-sm">
                            <thead>
                                <tr class="border-b-2 border-black text-xs uppercase tracking-wider text-gray-600">
                                    <th class="px-3 py-3">No</th>
                                    <th class="px-3 py-3">Nama kegiatan</th>
                                    <th class="px-3 py-3">Tanggal</th>
                                    <th class="px-3 py-3">Capaian</th>
                                    <th class="px-3 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submission->progressLogs as $log)
                                    <tr class="border-b border-gray-200 align-top">
                                        <td class="px-3 py-4 font-bold">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-4">
                                            <p class="font-semibold text-gray-900">{{ $log->nama_kegiatan }}</p>
                                            <p class="mt-1 text-[11px] text-gray-500">Dicatat {{ $log->created_at->format('d M Y, H:i') }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-700">{{ $log->tanggal->format('d M Y') }}</td>
                                        <td class="px-3 py-4">
                                            <span class="inline-flex border border-emerald-700 bg-emerald-50 px-2 py-1 font-bold text-emerald-800">{{ $log->capaian_persen }}%</span>
                                        </td>
                                        <td class="px-3 py-4">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('hackaton.submissions.progress_logs.edit', [$submission, $log]) }}" class="border border-black px-2.5 py-1.5 text-xs font-bold text-black hover:bg-black hover:text-white">Edit</a>
                                                <form method="POST" action="{{ route('hackaton.submissions.progress_logs.destroy', [$submission, $log]) }}" onsubmit="return confirm('Hapus progress log ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border border-red-700 px-2.5 py-1.5 text-xs font-bold text-red-700 hover:bg-red-700 hover:text-white">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection