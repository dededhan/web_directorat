@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Form ' . $submissionTahap->tahap->nama_tahap . ' | Hackaton UNJ')

@section('content_hackaton')
    @php
        $tahap = $submissionTahap->tahap;
        $tk = $tahap->tahap_ke;
        $isEditable = ($isReadOnly ?? false) ? false : $submissionTahap->isEditable();
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.submissions.index') }}" class="hover:text-amber-600">Proposal Saya</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('hackaton.submissions.show', $submission) }}" class="hover:text-amber-600">{{ Str::limit($submission->identitas?->nama_produk ?? 'Detail', 25) }}</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-800 font-medium">Form Tahap {{ $tk }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">
                    Form Evaluasi: Tahap {{ $tk }} — {{ $tahap->nama_tahap }}
                </h1>
                <p class="mt-1 text-xs text-gray-500">Proposal: <strong>{{ $submission->identitas?->nama_produk ?? '-' }}</strong></p>
            </div>
            <a href="{{ route('hackaton.submissions.show', $submission) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Progres
            </a>
        </div>

        {{-- Status Notification --}}
        @if (!$isEditable)
            <div class="p-4 bg-gray-50 border border-gray-300 text-gray-700 rounded-2xl text-xs flex items-center gap-3">
                <i class="fas fa-lock text-base text-gray-500"></i>
                <div>
                    <p class="font-bold">Form Dalam Mode Read-Only (Terkunci)</p>
                    <p class="text-gray-500">
                        @if ($submissionTahap->status === 'diajukan')
                            Tahap ini sudah diajukan pada {{ $submissionTahap->submitted_at?->format('d M Y H:i') }} dan sedang menunggu telaah admin/reviewer.
                        @else
                            Tahap ini saat ini tidak dapat diedit.
                        @endif
                    </p>
                </div>
            </div>
        @elseif ($submissionTahap->admin_status === 'perbaikan')
            <div class="p-4 bg-amber-50 border border-amber-300 text-amber-900 rounded-2xl text-xs space-y-1">
                <p class="font-bold flex items-center gap-1.5">
                    <i class="fas fa-redo text-amber-600"></i> Tahap Ini Memerlukan Perbaikan
                </p>
                @if ($submissionTahap->catatan_admin)
                    <p class="text-gray-800">Catatan Admin: <em>{{ $submissionTahap->catatan_admin }}</em></p>
                @endif
                <p class="text-[11px] text-amber-800">Silakan perbarui isian form di bawah lalu tekan "Submit Tahap" kembali.</p>
            </div>
        @endif

        {{-- Main Form --}}
        <form method="POST" id="tahapForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if ($tahap->sections->isEmpty() && $tahap->unsectionedFields->isEmpty())
                <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                    <p class="text-sm text-gray-400 italic">Belum ada field yang dikonfigurasi oleh admin untuk tahap ini.</p>
                </div>
            @endif

            {{-- Sectioned Fields --}}
            @foreach ($tahap->sections as $section)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-gray-900 text-white text-xs font-black flex items-center justify-center">
                            {{ $loop->iteration }}
                        </span>
                        <div>
                            <h2 class="text-sm font-bold text-gray-900">{{ $section->judul }}</h2>
                            @if ($section->deskripsi)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $section->deskripsi }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        @foreach ($section->fields as $field)
                            @include('subdirektorat-inovasi.hackaton.pengusul.submissions._field_input', [
                                'field' => $field,
                                'fieldValues' => $fieldValues,
                                'isEditable' => $isEditable,
                            ])
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Unsectioned Fields --}}
            @if ($tahap->unsectionedFields->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-gray-900">Isian Tambahan</h2>
                    </div>

                    <div class="p-6 space-y-5">
                        @foreach ($tahap->unsectionedFields as $field)
                            @include('subdirektorat-inovasi.hackaton.pengusul.submissions._field_input', [
                                'field' => $field,
                                'fieldValues' => $fieldValues,
                                'isEditable' => $isEditable,
                            ])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            @if ($isEditable)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <button type="submit" formaction="{{ route('hackaton.submissions.tahap.save', [$submission, $submissionTahap->hackaton_tahap_id]) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-800 text-gray-900 font-bold rounded-xl text-xs uppercase tracking-wider hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-save mr-1.5"></i> Simpan Sebagai Draft
                    </button>

                    <button type="submit" formaction="{{ route('hackaton.submissions.tahap.submit', [$submission, $submissionTahap->hackaton_tahap_id]) }}"
                        onclick="return confirm('Apakah Anda yakin ingin mengajukan Tahap {{ $tk }}? Berkas yang disubmit akan dikunci untuk proses review.')"
                        class="inline-flex items-center justify-center px-8 py-3 bg-amber-500 hover:bg-amber-600 text-gray-900 font-black rounded-xl text-xs uppercase tracking-wider transition shadow">
                        <i class="fas fa-paper-plane mr-1.5"></i> Submit Tahap {{ $tk }}
                    </button>
                </div>
            @endif
        </form>
    </div>
@endsection
