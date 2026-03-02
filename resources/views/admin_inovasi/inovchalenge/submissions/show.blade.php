@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ activeTab: 1 }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}"
                            class="hover:text-teal-600">Innovation Challenge</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.show', $session) }}"
                            class="hover:text-teal-600">{{ Str::limit($session->nama_sesi, 25) }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.submissions.index', $session) }}"
                            class="hover:text-teal-600">Submissions</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-700 font-medium">Detail #{{ $submission->id }}</li>
                </ol>
            </nav>

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

            {{-- Header / Summary --}}
            <div class="grid grid-cols-1 gap-6 mb-8">
                {{-- Info Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h1 class="text-xl font-bold text-gray-900 mb-4">{{ $submission->session->nama_sesi }}</h1>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs uppercase font-semibold">Dosen</p>
                            <p class="font-medium text-gray-800">{{ $submission->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $submission->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase font-semibold">Dibuat</p>
                            <p class="font-medium text-gray-800">{{ $submission->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ Tracking Progress Per Tahap ═══ --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-tasks text-teal-500"></i> Tracking Progress
                </h2>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center justify-between relative">
                            @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $idx => $st)
                                @php
                                    $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                                    $stepColors = [
                                        'belum_diisi' => 'bg-gray-200 text-gray-500',
                                        'draft' => 'bg-yellow-400 text-white',
                                        'diajukan' => 'bg-blue-500 text-white',
                                        'sedang_direview' => 'bg-purple-500 text-white',
                                        'perbaikan' => 'bg-orange-500 text-white',
                                        'lolos' => 'bg-green-500 text-white',
                                    ];
                                @endphp
                                <div class="flex flex-col items-center flex-1 relative z-10">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center text-sm font-bold shadow-md {{ $stepColors[$tracking['key']] ?? 'bg-gray-200 text-gray-500' }}">
                                        <i class="fas {{ $tracking['icon'] }}"></i>
                                    </div>
                                    <p class="mt-2 text-xs font-bold text-gray-700 text-center">Tahap
                                        {{ $st->tahap->tahap_ke }}</p>
                                    <p
                                        class="text-[11px] text-center font-semibold mt-0.5 {{ $tracking['key'] === 'lolos' ? 'text-green-600' : ($tracking['key'] === 'perbaikan' ? 'text-orange-600' : 'text-gray-500') }}">
                                        {{ $tracking['short'] }}
                                    </p>
                                </div>
                                @if (!$loop->last)
                                    <div
                                        class="flex-1 h-1 rounded {{ $tracking['key'] === 'lolos' ? 'bg-green-400' : 'bg-gray-200' }} -mt-6 mx-1">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Identitas Tim & Produk (read-only) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-id-card text-teal-500"></i> Identitas Tim &amp; Produk
                    </h2>
                    @if ($submission->identitasIsComplete())
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700">
                            <i class="fas fa-check-circle mr-1 text-[9px]"></i> Lengkap
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-orange-100 text-orange-700">
                            <i class="fas fa-exclamation-triangle mr-1 text-[9px]"></i> Belum Lengkap
                        </span>
                    @endif
                </div>
                <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Nama Produk</p>
                        <p class="text-gray-800 font-semibold">{{ $submission->identitas?->nama_produk ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Skema Inovasi</p>
                        <p class="text-gray-700 text-xs">{{ $submission->identitas?->skema_inovasi ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Bidang Utama</p>
                        <p class="text-gray-700 text-xs">{{ $submission->identitas?->bidang_utama_produk ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- ═══ Anggota Tim (top level) ═══ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-users text-purple-500"></i> Anggota Tim
                        <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $submission->members->count() }} orang
                        </span>
                    </h2>
                    @php
                        $pendingCount = $submission->members->where('approval_status', 'pending')->count();
                    @endphp
                    @if ($pendingCount > 0)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">
                            <i class="fas fa-clock mr-1 text-[8px]"></i> {{ $pendingCount }} Menunggu Approval
                        </span>
                    @endif
                </div>
                <div class="px-5 py-3">
                    @if ($submission->members->count())
                        <div class="flex flex-wrap gap-3">
                            @foreach ($submission->members as $member)
                                @php $badge = $member->getApprovalBadge(); @endphp
                                <div
                                    class="flex items-center gap-2.5 bg-gray-50 rounded-xl px-3 py-2 border border-gray-100">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $member->nama_lengkap }}
                                        </p>
                                        <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                            <span class="text-[10px] text-gray-400">{{ $member->getTipeLabel() }}</span>
                                            @if ($member->peran === 'Ketua')
                                                <span
                                                    class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold bg-purple-100 text-purple-700">
                                                    <i class="fas fa-crown mr-0.5 text-[7px]"></i> Ketua
                                                </span>
                                            @endif
                                            <span
                                                class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold {{ $badge['color'] }}">
                                                <i class="{{ $badge['icon'] }} mr-0.5 text-[7px]"></i>
                                                {{ $badge['label'] }}
                                            </span>
                                        </div>
                                    </div>
                                    {{-- Admin approve/reject for pending --}}
                                    @if ($member->peran !== 'Ketua' && $member->approval_status === 'pending')
                                        <div class="flex gap-1 ml-auto flex-shrink-0">
                                            <form method="POST"
                                                action="{{ route('admin_inovasi.inovchalenge.submissions.members.approve', [$session, $submission, $member]) }}"
                                                class="inline">@csrf @method('PATCH')
                                                <button type="submit"
                                                    class="w-6 h-6 rounded-md bg-green-500 text-white text-[10px] hover:bg-green-600 transition flex items-center justify-center"
                                                    title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST"
                                                action="{{ route('admin_inovasi.inovchalenge.submissions.members.reject', [$session, $submission, $member]) }}"
                                                class="inline">@csrf @method('PATCH')
                                                <button type="submit"
                                                    class="w-6 h-6 rounded-md bg-red-500 text-white text-[10px] hover:bg-red-600 transition flex items-center justify-center"
                                                    title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 text-center py-2">Belum ada anggota</p>
                    @endif
                </div>
            </div>

            {{-- Per-Tahap Tabs --}}
            <div class="mb-6 flex gap-2 border-b border-gray-200 pb-0">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                    @php
                        $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                        $tcMap = [
                            'gray' => 'bg-gray-200 text-gray-500',
                            'yellow' => 'bg-yellow-200 text-yellow-700',
                            'blue' => 'bg-blue-200 text-blue-700',
                            'purple' => 'bg-purple-200 text-purple-700',
                            'orange' => 'bg-orange-200 text-orange-700',
                            'green' => 'bg-green-200 text-green-700',
                        ];
                        $tc = $tcMap[$tracking['color']] ?? 'bg-gray-200 text-gray-500';
                    @endphp
                    <button @click="activeTab = {{ $st->tahap->tahap_ke }}"
                        :class="activeTab === {{ $st->tahap->tahap_ke }} ? 'border-teal-500 text-teal-700 bg-teal-50' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-4 py-3 border-b-2 text-sm font-medium rounded-t-xl transition inline-flex items-center gap-2">
                        <span
                            class="inline-flex items-center justify-center w-6 h-6 rounded-lg text-[10px] font-bold {{ $tc }}">{{ $st->tahap->tahap_ke }}</span>
                        {{ $st->tahap->judul }}
                    </button>
                @endforeach
            </div>

            {{-- Tahap Panels --}}
            @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                <div x-show="activeTab === {{ $st->tahap->tahap_ke }}" x-cloak class="space-y-6">

                    {{-- Tahap Admin Controls --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-3">
                            <h3 class="text-white font-semibold text-sm"><i class="fas fa-cog mr-1.5"></i> Kontrol Tahap
                                {{ $st->tahap->tahap_ke }}</h3>
                        </div>
                        <div class="p-5">
                            <form method="POST"
                                action="{{ route('admin_inovasi.inovchalenge.submissions.updateTahapStatus', $st) }}"
                                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Admin Status</label>
                                    <select name="admin_status"
                                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach (['menunggu', 'disetujui', 'perbaikan', 'selesai'] as $as)
                                            <option value="{{ $as }}"
                                                {{ $st->admin_status === $as ? 'selected' : '' }}>
                                                {{ ucfirst($as) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nominal Evaluasi
                                        (Rp)
                                    </label>
                                    <input type="number" name="nominal_evaluasi" value="{{ $st->nominal_evaluasi }}"
                                        step="0.01" min="0"
                                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Admin</label>
                                    <input type="text" name="catatan_admin" value="{{ $st->catatan_admin }}"
                                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Opsional...">
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-lg hover:bg-indigo-600 transition">
                                        <i class="fas fa-save mr-1.5"></i> Simpan
                                    </button>
                                </div>
                            </form>
                            <div class="flex gap-3 mt-3 text-xs text-gray-400">
                                <span>Dosen: <strong
                                        class="text-gray-600">{{ ucwords(str_replace('_', ' ', $st->status)) }}</strong></span>
                                @if ($st->submitted_at)
                                    <span>· Submit: {{ $st->submitted_at->format('d M Y H:i') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ═══ Data Formulir (with Sections) ═══ --}}
                    @php
                        $hasSections = $st->tahap->sections->isNotEmpty();
                    @endphp

                    @if ($hasSections)
                        {{-- Sectioned display --}}
                        @foreach ($st->tahap->sections as $sIdx => $section)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                {{-- Section header --}}
                                <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-3">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                        {{ $sIdx + 1 }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-800">{{ $section->judul }}</h4>
                                        @if ($section->deskripsi)
                                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $section->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <span
                                        class="ml-auto text-[10px] text-gray-300 font-medium">{{ $section->fields->count() }}
                                        field</span>
                                </div>
                                {{-- Section fields --}}
                                <div class="divide-y divide-gray-50">
                                    @forelse ($section->fields as $field)
                                        @php
                                            $fv = isset($st->loadedFieldValues)
                                                ? $st->loadedFieldValues[$field->id] ?? null
                                                : null;
                                            $displayValue = null;
                                            if ($fv) {
                                                if ($field->field_type === 'file') {
                                                    $displayValue = $fv->value_file_path;
                                                } elseif ($field->field_type === 'url') {
                                                    $displayValue = $fv->value_url;
                                                } else {
                                                    $displayValue = $fv->value_text;
                                                }
                                            }
                                            $isFilled = !is_null($displayValue) && $displayValue !== '';
                                        @endphp
                                        <div
                                            class="px-5 py-3 flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-6 {{ !$isFilled ? 'opacity-50' : '' }}">
                                            <div class="sm:w-1/3 flex-shrink-0">
                                                <p class="text-xs font-semibold text-gray-500 flex items-center gap-1">
                                                    {{ $field->field_label }}
                                                    @if ($field->is_required)
                                                        <span class="text-red-400">*</span>
                                                    @endif
                                                </p>
                                                <p class="text-[10px] text-gray-300 mt-0.5">{{ $field->field_type }}</p>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                @if ($field->field_type === 'file' && $isFilled)
                                                    <a href="{{ asset('storage/' . $displayValue) }}" target="_blank"
                                                        class="inline-flex items-center gap-1.5 text-sm text-teal-600 hover:text-teal-800 bg-teal-50 px-3 py-1.5 rounded-lg transition">
                                                        <i class="fas fa-download text-[10px]"></i>
                                                        {{ $fv->original_filename ?? basename($displayValue) }}
                                                    </a>
                                                @elseif ($field->field_type === 'url' && $isFilled)
                                                    <a href="{{ $displayValue }}" target="_blank"
                                                        class="text-sm text-teal-600 hover:underline break-all">
                                                        <i
                                                            class="fas fa-external-link-alt text-[10px] mr-1"></i>{{ $displayValue }}
                                                    </a>
                                                @elseif ($isFilled)
                                                    <p class="text-sm text-gray-800 whitespace-pre-wrap leading-relaxed">
                                                        {{ $displayValue }}</p>
                                                @else
                                                    <p class="text-sm text-gray-300 italic flex items-center gap-1">
                                                        <i class="fas fa-minus-circle text-[10px]"></i> Belum diisi
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-5 py-4 text-center text-sm text-gray-400">Belum ada field</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                        {{-- Unsectioned fields --}}
                        @if ($st->tahap->unsectionedFields->isNotEmpty())
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-3">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-gray-400 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Lainnya</h4>
                                </div>
                                <div class="divide-y divide-gray-50">
                                    @foreach ($st->tahap->unsectionedFields as $field)
                                        @php
                                            $fv = isset($st->loadedFieldValues)
                                                ? $st->loadedFieldValues[$field->id] ?? null
                                                : null;
                                            $displayValue = null;
                                            if ($fv) {
                                                if ($field->field_type === 'file') {
                                                    $displayValue = $fv->value_file_path;
                                                } elseif ($field->field_type === 'url') {
                                                    $displayValue = $fv->value_url;
                                                } else {
                                                    $displayValue = $fv->value_text;
                                                }
                                            }
                                            $isFilled = !is_null($displayValue) && $displayValue !== '';
                                        @endphp
                                        <div
                                            class="px-5 py-3 flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-6 {{ !$isFilled ? 'opacity-50' : '' }}">
                                            <div class="sm:w-1/3 flex-shrink-0">
                                                <p class="text-xs font-semibold text-gray-500">{{ $field->field_label }}
                                                </p>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                @if ($field->field_type === 'file' && $isFilled)
                                                    <a href="{{ asset('storage/' . $displayValue) }}" target="_blank"
                                                        class="inline-flex items-center gap-1.5 text-sm text-teal-600 hover:text-teal-800 bg-teal-50 px-3 py-1.5 rounded-lg transition">
                                                        <i class="fas fa-download text-[10px]"></i>
                                                        {{ $fv->original_filename ?? basename($displayValue) }}
                                                    </a>
                                                @elseif ($field->field_type === 'url' && $isFilled)
                                                    <a href="{{ $displayValue }}" target="_blank"
                                                        class="text-sm text-teal-600 hover:underline break-all">{{ $displayValue }}</a>
                                                @elseif ($isFilled)
                                                    <p class="text-sm text-gray-800 whitespace-pre-wrap">
                                                        {{ $displayValue }}</p>
                                                @else
                                                    <p class="text-sm text-gray-300 italic"><i
                                                            class="fas fa-minus-circle text-[10px] mr-1"></i>Belum diisi
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        {{-- No sections: flat display --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-2">
                                <i class="fas fa-file-alt text-teal-500 text-sm"></i>
                                <h4 class="text-sm font-bold text-gray-700">Data Formulir</h4>
                            </div>
                            @if ($st->tahap->fields->isNotEmpty())
                                <div class="divide-y divide-gray-50">
                                    @foreach ($st->tahap->fields->sortBy('urutan') as $field)
                                        @php
                                            $fv = isset($st->loadedFieldValues)
                                                ? $st->loadedFieldValues[$field->id] ?? null
                                                : null;
                                            $displayValue = null;
                                            if ($fv) {
                                                if ($field->field_type === 'file') {
                                                    $displayValue = $fv->value_file_path;
                                                } elseif ($field->field_type === 'url') {
                                                    $displayValue = $fv->value_url;
                                                } else {
                                                    $displayValue = $fv->value_text;
                                                }
                                            }
                                            $isFilled = !is_null($displayValue) && $displayValue !== '';
                                        @endphp
                                        <div
                                            class="px-5 py-3 flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-6 {{ !$isFilled ? 'opacity-50' : '' }}">
                                            <div class="sm:w-1/3 flex-shrink-0">
                                                <p class="text-xs font-semibold text-gray-500">
                                                    {{ $field->field_label }}
                                                    @if ($field->is_required)
                                                        <span class="text-red-400">*</span>
                                                    @endif
                                                </p>
                                                <p class="text-[10px] text-gray-300 mt-0.5">{{ $field->field_type }}</p>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                @if ($field->field_type === 'file' && $isFilled)
                                                    <a href="{{ asset('storage/' . $displayValue) }}" target="_blank"
                                                        class="inline-flex items-center gap-1.5 text-sm text-teal-600 hover:text-teal-800 bg-teal-50 px-3 py-1.5 rounded-lg transition">
                                                        <i class="fas fa-download text-[10px]"></i>
                                                        {{ $fv->original_filename ?? basename($displayValue) }}
                                                    </a>
                                                @elseif ($field->field_type === 'url' && $isFilled)
                                                    <a href="{{ $displayValue }}" target="_blank"
                                                        class="text-sm text-teal-600 hover:underline break-all">{{ $displayValue }}</a>
                                                @elseif ($isFilled)
                                                    <p class="text-sm text-gray-800 whitespace-pre-wrap">
                                                        {{ $displayValue }}</p>
                                                @else
                                                    <p class="text-sm text-gray-300 italic"><i
                                                            class="fas fa-minus-circle text-[10px] mr-1"></i>Belum diisi
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-6 text-center text-sm text-gray-400">Tidak ada field untuk tahap ini.</div>
                            @endif
                        </div>
                    @endif

                    {{-- Reviews for this Tahap --}}
                    @php
                        $tahapReviews = $submission->reviews->where(
                            'inov_chalenge_tahap_id',
                            $st->inov_chalenge_tahap_id,
                        );
                    @endphp
                    @if ($tahapReviews->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3">
                                <h3 class="text-white font-semibold text-sm"><i class="fas fa-star mr-1.5"></i> Reviews
                                    ({{ $tahapReviews->count() }})</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                @foreach ($tahapReviews as $review)
                                    <div class="border border-gray-100 rounded-xl p-4">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div
                                                class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-bold">
                                                {{ strtoupper(substr($review->reviewer->name ?? 'R', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">
                                                    {{ $review->reviewer->name ?? 'Reviewer' }}</p>
                                                <p class="text-[10px] text-gray-400">
                                                    {{ $review->updated_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="ml-9 space-y-1">
                                            <p class="text-sm text-gray-700"><strong
                                                    class="text-xs text-gray-400">Komentar:</strong><br>{{ $review->komentar }}
                                            </p>
                                            @if ($review->penilaian)
                                                <p class="text-sm text-gray-700"><strong
                                                        class="text-xs text-gray-400">Penilaian:</strong><br>{{ $review->penilaian }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            @endforeach

            {{-- Reviewer Assignment Panel --}}
            <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-6 py-3">
                    <h3 class="text-white font-semibold text-sm"><i class="fas fa-user-check mr-1.5"></i> Reviewer
                        Assignment</h3>
                </div>
                <div class="p-6">
                    <form method="POST"
                        action="{{ route('admin_inovasi.inovchalenge.submissions.assignReviewer', [$session, $submission]) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-2">Pilih Reviewer</label>
                            @php $assignedIds = $submission->reviewers->pluck('id')->toArray(); @endphp
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                @forelse($availableReviewers as $rev)
                                    <label
                                        class="flex items-center gap-2 p-2 rounded-lg border border-gray-100 hover:bg-cyan-50 cursor-pointer transition">
                                        <input type="checkbox" name="reviewer_ids[]" value="{{ $rev->id }}"
                                            {{ in_array($rev->id, $assignedIds) ? 'checked' : '' }}
                                            class="rounded text-cyan-500 focus:ring-cyan-500">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $rev->name }}</p>
                                            <p class="text-[10px] text-gray-400">{{ $rev->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-400 col-span-3">Belum ada user dengan role
                                        reviewer_inovchalenge.</p>
                                @endforelse
                            </div>
                        </div>
                        @if ($availableReviewers->isNotEmpty())
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-cyan-500 text-white text-sm font-medium rounded-lg hover:bg-cyan-600 transition">
                                <i class="fas fa-save mr-1.5"></i> Simpan Reviewer
                            </button>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
