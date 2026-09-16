@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Evaluasi Proposal Hackaton | ' . ($submission->identitas->nama_produk ?? $submission->session->nama_sesi))

@section('content_hackaton')
    <div class="space-y-6" x-data="{ activeTab: {{ $submittedTahap->first()?->tahap->tahap_ke ?? 1 }} }">

        {{-- Top Navigation & Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                        PENILAIAN REVIEWER
                    </span>
                    <span class="text-xs text-gray-400">Submission #{{ $submission->id }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $submission->identitas->nama_produk ?? $submission->session->nama_sesi }}</h1>
                <p class="text-xs text-gray-500 mt-0.5">
                    Sesi: <strong class="text-gray-700">{{ $submission->session->nama_sesi }}</strong>
                    <span class="mx-1.5">•</span>
                    Ketua Tim: <strong class="text-gray-700">{{ $submission->user->name ?? '—' }}</strong> ({{ $submission->user->email ?? '—' }})
                </p>
            </div>
            <a href="{{ route('hackaton.reviewer.assignments.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
        </div>

        {{-- Identitas & Team Summary Card --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-gray-400 font-medium uppercase tracking-wider block mb-1">Nama Produk / Inovasi</span>
                <p class="text-gray-900 font-bold text-sm">{{ $submission->identitas->nama_produk ?? '—' }}</p>
            </div>
            <div>
                <span class="text-gray-400 font-medium uppercase tracking-wider block mb-1">Skema &amp; Bidang</span>
                <p class="text-gray-800 font-semibold">{{ $submission->identitas->skema_inovasi ?? '—' }}</p>
                <p class="text-gray-500 mt-0.5">{{ $submission->identitas->bidang_utama_produk ?? '—' }}</p>
            </div>
            <div>
                <span class="text-gray-400 font-medium uppercase tracking-wider block mb-1">Total Anggota Tim</span>
                <p class="text-gray-800 font-semibold text-sm">{{ $submission->members->count() }} Orang</p>
                <div class="flex -space-x-1.5 mt-1.5 overflow-hidden">
                    @foreach($submission->members->take(5) as $m)
                        <span class="inline-block h-6 w-6 rounded-full bg-amber-500 text-white font-bold text-[10px] flex items-center justify-center ring-2 ring-white" title="{{ $m->nama_lengkap }} ({{ $m->role_tim ?? $m->peran }})">
                            {{ strtoupper(substr($m->nama_lengkap, 0, 1)) }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div>
                <span class="text-gray-400 font-medium uppercase tracking-wider block mb-1">Status Tim</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                    <i class="fas fa-check-circle mr-1"></i> Tim Terverifikasi
                </span>
            </div>
        </div>

        {{-- Tahap Tabs --}}
        @if ($submittedTahap->isNotEmpty())
            <div class="flex gap-2 border-b border-gray-200">
                @foreach ($submittedTahap as $st)
                    @php
                        $hasReview = isset($myReviews[$st->hackaton_tahap_id]);
                    @endphp
                    <button @click="activeTab = {{ $st->tahap->tahap_ke }}"
                        :class="activeTab === {{ $st->tahap->tahap_ke }} ? 'border-amber-500 text-amber-800 bg-amber-50 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-medium'"
                        class="px-5 py-3 border-b-2 text-sm rounded-t-xl transition inline-flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg text-xs font-bold {{ $hasReview ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $st->tahap->tahap_ke }}
                        </span>
                        <span>Tahap {{ $st->tahap->tahap_ke }}: {{ $st->tahap->nama_tahap }}</span>
                        @if ($hasReview)
                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Skor: {{ $myReviews[$st->hackaton_tahap_id]->skor }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                Belum Dinilai
                            </span>
                        @endif
                    </button>
                @endforeach
            </div>

            {{-- Tahap Tab Panels --}}
            @foreach ($submittedTahap as $st)
                @php
                    $existingReview = $myReviews[$st->hackaton_tahap_id] ?? null;
                    $hasSections = $st->tahap->sections->isNotEmpty();
                @endphp
                <div x-show="activeTab === {{ $st->tahap->tahap_ke }}" x-cloak class="space-y-6">

                    {{-- Tahap Form Responses --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-file-alt text-amber-500"></i> Dokumen &amp; Isian Formulir Tahap {{ $st->tahap->tahap_ke }}
                            </h2>
                            <span class="text-xs text-gray-500">
                                Diajukan: {{ $st->submitted_at ? $st->submitted_at->format('d M Y H:i') : '—' }}
                            </span>
                        </div>

                        <div class="p-6 space-y-6">
                            @if ($hasSections)
                                @foreach ($st->tahap->sections as $section)
                                    <div class="border border-gray-100 rounded-xl p-4 bg-gray-50/50">
                                        <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-1">{{ $section->judul }}</h3>
                                        @if($section->deskripsi)
                                            <p class="text-[11px] text-gray-400 mb-3">{{ $section->deskripsi }}</p>
                                        @endif
                                        <div class="space-y-4">
                                            @foreach ($section->fields as $field)
                                                @php
                                                    $valObj = $st->loadedFieldValues[$field->id] ?? null;
                                                    $rawVal = $valObj ? $valObj->value : null;
                                                @endphp
                                                <div class="bg-white rounded-lg p-3 border border-gray-100">
                                                    <p class="text-xs font-semibold text-gray-600 mb-1">{{ $field->field_label }}</p>
                                                    @if($field->field_type === 'file' && $rawVal)
                                                        <a href="{{ asset('storage/' . $rawVal) }}" target="_blank"
                                                            class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-800 text-xs font-bold rounded-lg hover:bg-amber-100 transition border border-amber-200">
                                                            <i class="fas fa-download mr-1.5"></i> Unduh Berkas Lampiran
                                                        </a>
                                                    @elseif($field->field_type === 'url' && $rawVal)
                                                        <a href="{{ $rawVal }}" target="_blank" rel="noopener noreferrer"
                                                            class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 font-medium">
                                                            <i class="fas fa-external-link-alt text-[10px]"></i> {{ $rawVal }}
                                                        </a>
                                                    @elseif($rawVal)
                                                        <p class="text-xs text-gray-800 whitespace-pre-line">{{ $rawVal }}</p>
                                                    @else
                                                        <p class="text-xs text-gray-400 italic">Tidak ada data diisi</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="space-y-4">
                                    @foreach ($st->tahap->fields->sortBy('urutan') as $field)
                                        @php
                                            $valObj = $st->loadedFieldValues[$field->id] ?? null;
                                            $rawVal = $valObj ? $valObj->value : null;
                                        @endphp
                                        <div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100">
                                            <p class="text-xs font-semibold text-gray-600 mb-1.5">{{ $field->field_label }}</p>
                                            @if($field->field_type === 'file' && $rawVal)
                                                <a href="{{ asset('storage/' . $rawVal) }}" target="_blank"
                                                    class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-800 text-xs font-bold rounded-lg hover:bg-amber-100 transition border border-amber-200">
                                                    <i class="fas fa-download mr-1.5"></i> Unduh Berkas Lampiran
                                                </a>
                                            @elseif($field->field_type === 'url' && $rawVal)
                                                <a href="{{ $rawVal }}" target="_blank" rel="noopener noreferrer"
                                                    class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 font-medium">
                                                    <i class="fas fa-external-link-alt text-[10px]"></i> {{ $rawVal }}
                                                </a>
                                            @elseif($rawVal)
                                                <p class="text-xs text-gray-800 whitespace-pre-line">{{ $rawVal }}</p>
                                            @else
                                                <p class="text-xs text-gray-400 italic">Tidak ada data diisi</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Review Evaluation Form --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-amber-50/50 flex items-center justify-between">
                            <h2 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-star text-amber-500"></i> Formulir Evaluasi &amp; Nilai Reviewer — Tahap {{ $st->tahap->tahap_ke }}
                            </h2>
                            @if ($existingReview)
                                <span class="text-xs text-emerald-700 font-semibold flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Terakhir disimpan: {{ $existingReview->updated_at->format('d M Y H:i') }}
                                </span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('hackaton.reviewer.assignments.storeReview', [$submission, $st->hackaton_tahap_id]) }}" class="p-6 space-y-5">
                            @csrf

                            {{-- Skor 0 - 100 --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Skor Penilaian (0 - 100) <span class="text-red-500">*</span>
                                </label>
                                <div class="max-w-xs">
                                    <input type="number" name="skor" min="0" max="100" step="1" required
                                        value="{{ old('skor', $existingReview->skor ?? '') }}"
                                        placeholder="Contoh: 85"
                                        class="w-full text-base font-bold text-gray-900 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1">Rentang penilaian resmi: 0 (Terendah) sampai 100 (Sempurna).</p>
                            </div>

                            {{-- Komentar Review --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Komentar Evaluasi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="komentar" rows="4" required
                                    placeholder="Tuliskan analisis, kelebihan karya, dan aspek yang perlu diperhatikan..."
                                    class="w-full text-xs text-gray-900 px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('komentar', $existingReview->komentar ?? '') }}</textarea>
                            </div>

                            {{-- Penilaian Tambahan / Catatan --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Rekomendasi &amp; Catatan Khusus <span class="text-gray-400 font-normal">(Opsional)</span>
                                </label>
                                <textarea name="penilaian" rows="3"
                                    placeholder="Rekomendasi tindak lanjut atau saran penyempurnaan karya..."
                                    class="w-full text-xs text-gray-900 px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('penilaian', $existingReview->penilaian ?? '') }}</textarea>
                            </div>

                            {{-- Submit button --}}
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold text-xs rounded-xl transition shadow">
                                    <i class="fas fa-save mr-2"></i> {{ $existingReview ? 'Perbarui Nilai & Review' : 'Simpan Nilai & Review' }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            @endforeach
        @else
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-hourglass-start"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800">Belum Ada Tahap yang Diajukan</h3>
                <p class="text-xs text-gray-500 mt-1">
                    Ketua tim belum mengajukan berkas formulir untuk dinilai.
                </p>
            </div>
        @endif

        {{-- Status Logs Timeline --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-history text-amber-500"></i> Riwayat Aktivitas &amp; Status Proposal
                </h2>
                <span class="text-xs text-gray-400">{{ $submission->statusLogs->count() }} catatan</span>
            </div>
            <div class="p-6">
                @if ($submission->statusLogs->count())
                    <div class="relative pl-6 space-y-4 border-l-2 border-gray-200">
                        @foreach ($submission->statusLogs->take(10) as $log)
                            <div class="relative">
                                <span class="absolute -left-[31px] top-1 w-3.5 h-3.5 rounded-full bg-amber-500 ring-4 ring-white"></span>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs">
                                    <p class="font-bold text-gray-800">
                                        {{ $log->keterangan ?? $log->getStatusLabel($log->status_ke) }}
                                    </p>
                                    <span class="text-gray-400 text-[11px] mt-0.5 sm:mt-0">
                                        {{ $log->created_at->format('d M Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada aktivitas tercatat.</p>
                @endif
            </div>
        </div>

    </div>
@endsection
