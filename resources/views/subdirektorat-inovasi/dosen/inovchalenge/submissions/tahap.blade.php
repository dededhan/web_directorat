@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    @php
        $tahap = $submissionTahap->tahap;
        $isEditable = $submissionTahap->isEditable();
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tahap {{ $tahap->tahap_ke }}: {{ $tahap->judul }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $submission->session->nama_sesi }}</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission) }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Status banner --}}
            <div class="mb-6 flex flex-wrap gap-2 items-center text-sm">
                @php
                    $statusBadge = match ($submissionTahap->status) {
                        'belum_diisi' => 'bg-gray-100 text-gray-600',
                        'draft' => 'bg-yellow-100 text-yellow-700',
                        'diajukan' => 'bg-green-100 text-green-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold {{ $statusBadge }}">
                    <i class="fas fa-circle text-[8px] mr-1.5"></i>
                    {{ ucwords(str_replace('_', ' ', $submissionTahap->status)) }}
                </span>
                @if ($submissionTahap->admin_status !== 'menunggu')
                    @php
                        $adminBadge = match ($submissionTahap->admin_status) {
                            'disetujui' => 'bg-green-100 text-green-700',
                            'perbaikan' => 'bg-orange-100 text-orange-700',
                            'selesai' => 'bg-blue-100 text-blue-700',
                            default => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold {{ $adminBadge }}">
                        Admin: {{ ucfirst($submissionTahap->admin_status) }}
                    </span>
                @endif
                @if (!$isEditable)
                    <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-red-100 text-red-600">
                        <i class="fas fa-lock mr-1 text-[10px]"></i> Read-only
                    </span>
                @endif
            </div>

            {{-- Admin note --}}
            @if ($submissionTahap->catatan_admin)
                <div class="mb-6 bg-orange-50 border border-orange-200 rounded-xl p-4 text-sm text-orange-700">
                    <p class="font-semibold mb-1"><i class="fas fa-comment-alt mr-1"></i> Catatan dari Admin:</p>
                    <p>{{ $submissionTahap->catatan_admin }}</p>
                </div>
            @endif

            {{-- Description --}}
            @if ($tahap->deskripsi)
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-1"></i> {{ $tahap->deskripsi }}
                </div>
            @endif

            {{-- ═══════════════════ FORM FIELDS ═══════════════════ --}}
            <form id="tahapForm"
                action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap.save', [$submission, $tahap->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ══ SECTIONED FORM FIELDS ══ --}}
                @php $hasSections = $tahap->sections->isNotEmpty(); @endphp

                @if ($hasSections)
                    @foreach ($tahap->sections as $section)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                            <div class="px-6 py-3 border-b border-gray-100 bg-gradient-to-r from-indigo-500 to-indigo-600">
                                <h2 class="text-base font-bold text-white">
                                    <i class="fas fa-folder-open mr-2"></i>{{ $section->judul }}
                                </h2>
                                @if ($section->deskripsi)
                                    <p class="text-indigo-200 text-xs mt-0.5">{{ $section->deskripsi }}</p>
                                @endif
                            </div>
                            <div class="p-6 space-y-6">
                                @if ($section->fields->isEmpty())
                                    <p class="text-sm text-gray-400 text-center py-4">Belum ada field di seksi ini.</p>
                                @else
                                    @foreach ($section->fields as $field)
                                        @include('subdirektorat-inovasi.dosen.inovchalenge.submissions._field_input')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Unsectioned fields (if any) --}}
                    @if ($tahap->unsectionedFields->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                            <div class="px-6 py-3 border-b border-gray-100 bg-gradient-to-r from-gray-500 to-gray-600">
                                <h2 class="text-base font-bold text-white">
                                    <i class="fas fa-file-alt mr-2"></i>Informasi Tambahan
                                </h2>
                            </div>
                            <div class="p-6 space-y-6">
                                @foreach ($tahap->unsectionedFields as $field)
                                    @include('subdirektorat-inovasi.dosen.inovchalenge.submissions._field_input')
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    {{-- No sections → flat form --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-teal-500 to-teal-600">
                            <h2 class="text-lg font-bold text-white"><i class="fas fa-file-alt mr-2"></i>Formulir</h2>
                        </div>
                        <div class="p-6 space-y-6">
                            @if ($tahap->fields->isEmpty())
                                <p class="text-sm text-gray-400 text-center py-4">Belum ada field yang dikonfigurasi untuk tahap ini.</p>
                            @else
                                @foreach ($tahap->fields->sortBy('urutan') as $field)
                                    @include('subdirektorat-inovasi.dosen.inovchalenge.submissions._field_input')
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ═══════════════════ ACTION BUTTONS ═══════════════════ --}}
                @if ($isEditable && $tahap->fields->isNotEmpty())
                    <div class="flex flex-col sm:flex-row gap-3 mb-8">
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold text-sm rounded-xl hover:from-gray-600 hover:to-gray-700 transition shadow">
                            <i class="fas fa-save mr-2"></i> Simpan Draft
                        </button>
                        <button type="button" id="btnSubmit"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-sm rounded-xl hover:from-teal-600 hover:to-teal-700 transition shadow">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Tahap {{ $tahap->tahap_ke }}
                        </button>
                    </div>
                @endif
            </form>

            {{-- Hidden submit form --}}
            <form id="submitForm"
                action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap.submit', [$submission, $tahap->id]) }}"
                method="POST" class="hidden">
                @csrf
            </form>

            {{-- Anggota Tim: moved to identitas page --}}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Submit confirmation
        document.getElementById('btnSubmit')?.addEventListener('click', function() {
            Swal.fire({
                title: 'Submit Tahap?',
                text: 'Setelah disubmit, data tidak dapat diubah kecuali diminta perbaikan oleh admin.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#14b8a6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Submit',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Copy form field values to hidden submit form
                    const tahapForm = document.getElementById('tahapForm');
                    const submitForm = document.getElementById('submitForm');
                    const formData = new FormData(tahapForm);
                    for (const [key, value] of formData.entries()) {
                        if (key === '_token') continue;
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        submitForm.appendChild(input);
                    }
                    submitForm.submit();
                }
            });
        });

    </script>
@endpush
