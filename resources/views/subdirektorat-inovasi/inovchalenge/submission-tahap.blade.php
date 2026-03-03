<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tahap | Innovation Challenge</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    @php
        $tahap = $submissionTahap->tahap;
        $isReadOnly = $isReadOnly ?? true;
        $isEditable = false;
        $hasSections = $tahap->sections->isNotEmpty();
        $tracking = $submissionTahap->getTrackingStatus();
        $trackingBadgeColors = [
            'belum_diisi' => 'bg-gray-100 text-gray-600 border-gray-200',
            'draft' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'diajukan' => 'bg-blue-100 text-blue-700 border-blue-200',
            'sedang_direview' => 'bg-purple-100 text-purple-700 border-purple-200',
            'perbaikan' => 'bg-orange-100 text-orange-700 border-orange-200',
            'lolos' => 'bg-green-100 text-green-700 border-green-200',
        ];

        $sectionList = [];
        if ($hasSections) {
            foreach ($tahap->sections as $i => $sec) {
                $sectionList[] = [
                    'id' => 'section-' . $sec->id,
                    'label' => $sec->judul,
                    'count' => $sec->fields->count(),
                ];
            }
            if ($tahap->unsectionedFields->isNotEmpty()) {
                $sectionList[] = [
                    'id' => 'section-other',
                    'label' => 'Lainnya',
                    'count' => $tahap->unsectionedFields->count(),
                ];
            }
        }
    @endphp

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Top Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('inovchalenge.role.submissions.show', $submission) }}"
                    class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:border-gray-300 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-teal-100 text-teal-700 text-xs font-bold">{{ $tahap->tahap_ke }}</span>
                        <h1 class="text-lg font-bold text-gray-900">{{ $tahap->nama_tahap }}</h1>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $submission->session->nama_sesi }}</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $trackingBadgeColors[$tracking['key']] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                    <i class="fas {{ $tracking['icon'] }} text-[8px] mr-1.5"></i>
                    {{ $tracking['label'] }}
                </span>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">
                    <i class="fas fa-lock mr-1 text-[10px]"></i> Read-only
                </span>
            </div>
        </div>

        {{-- Read-Only Notice --}}
        <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center gap-3 text-indigo-700">
            <i class="fas fa-info-circle text-lg flex-shrink-0"></i>
            <div>
                <p class="font-semibold text-sm">Mode Read-Only (Anggota)</p>
                <p class="text-xs mt-0.5 text-indigo-600">Anda melihat formulir ini sebagai anggota tim. Data tidak
                    dapat diubah.</p>
            </div>
        </div>

        {{-- Admin note --}}
        @if ($submissionTahap->catatan_admin)
            <div class="mb-6 bg-orange-50 border border-orange-200 rounded-xl p-4 text-sm text-orange-700">
                <p class="font-semibold mb-1"><i class="fas fa-comment-alt mr-1"></i> Catatan dari Admin:</p>
                <p>{{ $submissionTahap->catatan_admin }}</p>
            </div>
        @endif

        {{-- ═══ MAIN LAYOUT: Section Nav + Form ═══ --}}
        <div class="flex gap-6">
            {{-- Section Navigation Sidebar (desktop) --}}
            @if ($hasSections && count($sectionList) > 1)
                <div class="hidden lg:block w-56 flex-shrink-0">
                    <div class="sticky top-8">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Bagian Formulir
                        </p>
                        <nav class="space-y-1">
                            @foreach ($sectionList as $i => $sec)
                                <a href="#{{ $sec['id'] }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition group">
                                    <span
                                        class="w-5 h-5 rounded-md bg-gray-100 group-hover:bg-teal-100 flex items-center justify-center text-[10px] font-bold text-gray-400 group-hover:text-teal-600">{{ $i + 1 }}</span>
                                    <span class="truncate">{{ $sec['label'] }}</span>
                                    <span class="ml-auto text-[10px] text-gray-300">{{ $sec['count'] }}</span>
                                </a>
                            @endforeach
                        </nav>

                        <div class="mt-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-semibold uppercase">Total Fields</p>
                            <p class="text-lg font-bold text-gray-700">{{ $tahap->fields->count() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Content (Read-Only) --}}
            <div class="flex-1 min-w-0">
                @if ($hasSections)
                    @foreach ($tahap->sections as $sIdx => $section)
                        <div id="section-{{ $section->id }}" class="mb-6 scroll-mt-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                    {{ $sIdx + 1 }}
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-gray-900">{{ $section->judul }}</h2>
                                    @if ($section->deskripsi)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $section->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="divide-y divide-gray-50">
                                    @if ($section->fields->isEmpty())
                                        <div class="p-6 text-center text-sm text-gray-400">Belum ada field di bagian
                                            ini.</div>
                                    @else
                                        @foreach ($section->fields as $field)
                                            <div class="p-5">
                                                @include('subdirektorat-inovasi.dosen.inovchalenge.submissions._field_input')
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($tahap->unsectionedFields->isNotEmpty())
                        <div id="section-other" class="mb-6 scroll-mt-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-8 h-8 rounded-xl bg-gray-400 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                    <i class="fas fa-ellipsis-h text-sm"></i>
                                </div>
                                <h2 class="text-base font-bold text-gray-900">Informasi Tambahan</h2>
                            </div>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="divide-y divide-gray-50">
                                    @foreach ($tahap->unsectionedFields as $field)
                                        <div class="p-5">
                                            @include('subdirektorat-inovasi.dosen.inovchalenge.submissions._field_input')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-8 h-8 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                <i class="fas fa-file-alt text-sm"></i>
                            </div>
                            <h2 class="text-base font-bold text-gray-900">Formulir</h2>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            @if ($tahap->fields->isEmpty())
                                <div class="p-6 text-center text-sm text-gray-400">Belum ada field yang dikonfigurasi
                                    untuk tahap ini.</div>
                            @else
                                <div class="divide-y divide-gray-50">
                                    @foreach ($tahap->fields->sortBy('urutan') as $field)
                                        <div class="p-5">
                                            @include('subdirektorat-inovasi.dosen.inovchalenge.submissions._field_input')
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</body>

</html>
