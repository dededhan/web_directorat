@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Edit Progress Log | Hackaton UNJ')

@section('content_hackaton')
    <div class="mx-auto max-w-xl space-y-6">
        <div class="border-b border-black pb-5">
            <nav class="mb-2 flex items-center gap-2 text-xs text-gray-500">
                <a href="{{ route('hackaton.submissions.progress_logs.index', $submission) }}" class="hover:text-emerald-700">Logbook</a>
                <span aria-hidden="true">/</span>
                <span class="font-semibold text-black">Edit</span>
            </nav>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Perbarui Catatan</p>
            <h1 class="mt-1 text-3xl font-bold text-gray-900">Edit Progress Log</h1>
        </div>

        <section class="border border-black bg-white p-6">
            <form method="POST" action="{{ route('hackaton.submissions.progress_logs.update', [$submission, $progressLog]) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama_kegiatan" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-700">Nama kegiatan</label>
                    <input id="nama_kegiatan" name="nama_kegiatan" type="text" value="{{ old('nama_kegiatan', $progressLog->nama_kegiatan) }}" required maxlength="255"
                        class="w-full border border-gray-400 px-3 py-2.5 text-sm focus:border-black focus:outline-none">
                    @error('nama_kegiatan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tanggal" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-700">Tanggal kegiatan</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', $progressLog->tanggal?->format('Y-m-d')) }}" required
                        class="w-full border border-gray-400 px-3 py-2.5 text-sm focus:border-black focus:outline-none">
                    @error('tanggal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="capaian_persen" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-700">Capaian kegiatan (%)</label>
                    <input id="capaian_persen" name="capaian_persen" type="number" value="{{ old('capaian_persen', $progressLog->capaian_persen) }}" required min="{{ max(1, (int) $progressLog->capaian_persen) }}" max="100"
                        class="w-full border border-gray-400 px-3 py-2.5 text-sm focus:border-black focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500">Nilai tidak boleh diturunkan dari {{ $progressLog->capaian_persen }}% pada catatan ini.</p>
                    @error('capaian_persen') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-gray-200 pt-4 sm:flex-row sm:justify-end">
                    <a href="{{ route('hackaton.submissions.progress_logs.index', $submission) }}" class="border border-gray-400 px-4 py-2.5 text-center text-xs font-bold uppercase tracking-wider text-gray-700 hover:bg-gray-100">Batal</a>
                    <button type="submit" class="bg-black px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-emerald-800">Simpan Perubahan</button>
                </div>
            </form>
        </section>
    </div>
@endsection