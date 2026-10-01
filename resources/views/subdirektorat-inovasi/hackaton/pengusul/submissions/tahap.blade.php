

@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Form ' . $submissionTahap->tahap->nama_tahap . ' | Hackaton UNJ')

@section('content_hackaton')
    @php
        $tahap = $submissionTahap->tahap;
        $tk = $tahap->tahap_ke;
        $isEditable = ($isReadOnly ?? false) ? false : $submissionTahap->isEditable();

        // Hitung kelengkapan kolom wajib
        $allTahapFields = $tahap->sections->flatMap->fields->concat($tahap->unsectionedFields);
        $totalRequired = 0;
        $filledRequired = 0;
        $missingRequiredLabels = [];

        foreach ($allTahapFields as $f) {
            if ($f->is_required) {
                $totalRequired++;
                $fv = $fieldValues[$f->id] ?? null;
                $val = $fv?->value;
                $hasVal = false;
                if ($val !== null) {
                    $trimmed = is_string($val) ? trim($val) : $val;
                    if ($trimmed !== '' && $trimmed !== '[]' && $trimmed !== '{}' && $trimmed !== 'null') {
                        $hasVal = true;
                    }
                }
                if ($hasVal) {
                    $filledRequired++;
                } else {
                    $missingRequiredLabels[] = $f->field_label;
                }
            }
        }
        $isFormComplete = ($totalRequired === 0) || ($filledRequired >= $totalRequired);
        $percentRequired = $totalRequired > 0 ? (int) round(($filledRequired / $totalRequired) * 100) : 100;
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
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-300 text-rose-900 rounded-2xl text-xs flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-base text-rose-600 mt-0.5 shrink-0"></i>
                <div>
                    <p class="font-bold">Pengajuan Belum Dapat Diproses</p>
                    <p class="mt-0.5 text-rose-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-300 text-rose-900 rounded-2xl text-xs space-y-1.5">
                <p class="font-bold flex items-center gap-1.5 text-rose-700">
                    <i class="fas fa-exclamation-triangle text-base"></i> Mohon lengkapi seluruh persyaratan wajib berikut sebelum melakukan submit:
                </p>
                <ul class="list-disc list-inside space-y-0.5 mt-1 text-rose-800">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-900 rounded-2xl text-xs flex items-center gap-2">
                <i class="fas fa-check-circle text-base text-emerald-600"></i>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Live Validation Alert Container for Client-Side Check --}}
        <div id="validationAlert" class="hidden p-4 bg-rose-50 border-2 border-rose-400 text-rose-900 rounded-2xl text-xs space-y-2">
            <p class="font-bold flex items-center gap-1.5 text-rose-700 text-sm">
                <i class="fas fa-exclamation-circle text-base"></i> Pengajuan Belum Dapat Disubmit!
            </p>
            <p class="text-rose-800">Terdapat kolom/dokumen wajib yang masih kosong. Mohon lengkapi isian bertanda bintang (*) berikut sebelum melakukan submit:</p>
            <ul id="missingList" class="list-disc list-inside space-y-1 font-semibold text-rose-900 mt-1"></ul>
        </div>

        {{-- Status Card Kelengkapan Form --}}
        @if ($isEditable)
            <div class="bg-white rounded-2xl border {{ $isFormComplete ? 'border-emerald-300 bg-emerald-50/20' : 'border-amber-300 bg-amber-50/20' }} p-5 shadow-sm space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $isFormComplete ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} flex items-center justify-center text-lg shrink-0">
                            <i class="fas {{ $isFormComplete ? 'fa-check-circle' : 'fa-clipboard-list' }}"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-gray-900 text-sm">Status Kelengkapan Form Tahap {{ $tk }}</h3>
                                @if ($isFormComplete)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <i class="fas fa-check mr-1 text-[9px]"></i> Siap Disubmit
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300">
                                        <i class="fas fa-clock mr-1 text-[9px]"></i> Belum Lengkap
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $filledRequired }} dari {{ $totalRequired }} isian wajib telah terisi ({{ $percentRequired }}%).
                                @if (!$isFormComplete)
                                    <span class="text-amber-800 font-semibold">Tersisa {{ count($missingRequiredLabels) }} isian wajib yang harus dilengkapi.</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="w-full sm:w-44">
                        <div class="flex items-center justify-between text-[11px] font-bold text-gray-600 mb-1">
                            <span>Progres Wajib</span>
                            <span class="{{ $isFormComplete ? 'text-emerald-700 font-black' : 'text-amber-700' }}">{{ $percentRequired }}%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full {{ $isFormComplete ? 'bg-emerald-500' : 'bg-amber-500' }} rounded-full transition-all"
                                style="width: {{ $percentRequired }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                        <h2 class="text-sm font-bold text-gray-900">Isian Tambahan (Umum)</h2>
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
                    <button type="submit" formnovalidate formaction="{{ route('hackaton.submissions.tahap.save', [$submission, $submissionTahap->hackaton_tahap_id]) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-800 text-gray-900 font-bold rounded-xl text-xs uppercase tracking-wider hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-save mr-1.5"></i> Simpan Sebagai Draft
                    </button>

                    <button type="submit" id="btnSubmitTahap" formaction="{{ route('hackaton.submissions.tahap.submit', [$submission, $submissionTahap->hackaton_tahap_id]) }}"
                        onclick="return validateTahapSubmission(event)"
                        class="inline-flex items-center justify-center px-8 py-3 bg-amber-500 hover:bg-amber-600 text-gray-900 font-black rounded-xl text-xs uppercase tracking-wider transition shadow">
                        <i class="fas fa-paper-plane mr-1.5"></i> Submit Tahap {{ $tk }}
                    </button>
                </div>
            @endif
        </form>
    </div>

    @if ($isEditable)
        <script>
            function validateTahapSubmission(e) {
                const wrappers = document.querySelectorAll('.field-item-wrapper[data-required="1"]');
                const missing = [];
                let firstMissingElem = null;

                // Reset error highlights
                document.querySelectorAll('.field-item-wrapper').forEach(w => {
                    w.classList.remove('p-3', 'rounded-xl', 'border-2', 'border-rose-500', 'bg-rose-50/20');
                });

                wrappers.forEach(w => {
                    const type = w.dataset.fieldType;
                    const label = w.dataset.fieldLabel;
                    const hasUploaded = w.dataset.hasUploaded === '1';
                    let isFilled = false;

                    if (type === 'file') {
                        const fileInput = w.querySelector('input[type="file"]');
                        if (hasUploaded || (fileInput && fileInput.files && fileInput.files.length > 0)) {
                            isFilled = true;
                        }
                    } else if (type === 'checkbox') {
                        const checked = w.querySelectorAll('input[type="checkbox"]:checked');
                        if (checked.length > 0) {
                            isFilled = true;
                        }
                    } else {
                        const input = w.querySelector('input:not([type="checkbox"]):not([type="file"]), textarea, select');
                        if (input && input.value && input.value.trim() !== '') {
                            isFilled = true;
                        }
                    }

                    if (!isFilled) {
                        missing.push(label);
                        w.classList.add('p-3', 'rounded-xl', 'border-2', 'border-rose-500', 'bg-rose-50/20');
                        if (!firstMissingElem) {
                            firstMissingElem = w;
                        }
                    }
                });

                if (missing.length > 0) {
                    e.preventDefault();
                    const alertBox = document.getElementById('validationAlert');
                    const listElem = document.getElementById('missingList');
                    if (alertBox && listElem) {
                        listElem.innerHTML = '';
                        missing.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = item;
                            listElem.appendChild(li);
                        });
                        alertBox.classList.remove('hidden');
                        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else if (firstMissingElem) {
                        firstMissingElem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }

                return confirm('Apakah Anda yakin ingin mengajukan Tahap ' + @json($tk) + '? Seluruh isian formulir dan dokumen persyaratan telah lengkap. Berkas yang disubmit akan dikunci untuk proses review.');
            }
        </script>
    @endif
@endsection
