@extends('reviewer_inovchalenge.layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ activeTab: {{ $submittedTahap->first()?->tahap->tahap_ke ?? 1 }} }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $submission->session->nama_sesi }}</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-user mr-1"></i> {{ $submission->user->name }}
                        <span class="text-gray-300 mx-1">·</span>
                        Submission #{{ $submission->id }}
                    </p>
                </div>
                <a href="{{ route('reviewer_inovchalenge.assignments.index') }}"
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

            {{-- Tahap Tabs (only submitted Tahap) --}}
            @if ($submittedTahap->isNotEmpty())
                <div class="mb-6 flex gap-2 border-b border-gray-200">
                    @foreach ($submittedTahap as $st)
                        <button @click="activeTab = {{ $st->tahap->tahap_ke }}"
                            :class="activeTab === {{ $st->tahap->tahap_ke }} ? 'border-cyan-500 text-cyan-700 bg-cyan-50' :
                                'border-transparent text-gray-500 hover:text-gray-700'"
                            class="px-4 py-3 border-b-2 text-sm font-medium rounded-t-xl transition inline-flex items-center gap-2">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 rounded-lg text-[10px] font-bold bg-green-200 text-green-700">{{ $st->tahap->tahap_ke }}</span>
                            {{ $st->tahap->judul }}
                            @if (isset($myReviews[$st->inov_chalenge_tahap_id]))
                                <i class="fas fa-check-circle text-green-500 text-xs"></i>
                            @endif
                        </button>
                    @endforeach
                </div>

                {{-- Tahap Panels --}}
                @foreach ($submittedTahap as $st)
                    <div x-show="activeTab === {{ $st->tahap->tahap_ke }}" x-cloak class="space-y-6">

                        {{-- Field Values (read-only) --}}
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-3">
                                <h3 class="text-white font-semibold text-sm"><i class="fas fa-file-alt mr-1.5"></i> Data
                                    Formulir</h3>
                            </div>
                            <div class="p-6">
                                @if ($st->tahap->fields->isNotEmpty())
                                    <div class="space-y-4">
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
                                                    } elseif ($field->field_type === 'checkbox') {
                                                        $decoded = json_decode($fv->value_text ?? '', true);
                                                        $displayValue = is_array($decoded) && count($decoded) ? $decoded : null;
                                                    } else {
                                                        $displayValue = $fv->value_text;
                                                    }
                                                }
                                            @endphp
                                            <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                                <p
                                                    class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                                                    {{ $field->field_label }}
                                                </p>
                                                @if ($field->field_type === 'file' && $displayValue)
                                                    <a href="{{ asset('storage/' . $displayValue) }}" target="_blank"
                                                        class="inline-flex items-center text-sm text-teal-600 hover:underline">
                                                        <i class="fas fa-download mr-1.5"></i>
                                                        {{ $fv->original_filename ?? basename($displayValue) }}
                                                    </a>
                                                @elseif($field->field_type === 'url' && $displayValue)
                                                    <a href="{{ $displayValue }}" target="_blank"
                                                        class="text-sm text-teal-600 hover:underline break-all">
                                                        {{ $displayValue }}
                                                    </a>
                                                @elseif($field->field_type === 'checkbox')
                                                    @if($displayValue)
                                                        <ul class="list-none space-y-1">
                                                            @foreach($displayValue as $item)
                                                                <li class="flex items-center gap-1.5 text-sm text-gray-800">
                                                                    <i class="fas fa-check-square text-teal-500 text-xs"></i> {{ $item }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="text-sm text-gray-300 italic">Belum diisi</p>
                                                    @endif
                                                @elseif($displayValue)
                                                    <p class="text-sm text-gray-800 whitespace-pre-wrap">
                                                        {{ $displayValue }}</p>
                                                @else
                                                    <p class="text-sm text-gray-300 italic">Belum diisi</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 text-center py-4">Tidak ada field untuk tahap ini.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Anggota Tim (Tahap with has_anggota) --}}
                        @if ($st->tahap->has_anggota)
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-3">
                                    <h3 class="text-white font-semibold text-sm"><i class="fas fa-users mr-1.5"></i> Anggota
                                        Tim</h3>
                                </div>
                                <div class="p-6">
                                    @if ($submission->members->count())
                                        <div class="divide-y divide-gray-100">
                                            @foreach ($submission->members as $member)
                                                <div class="flex items-center justify-between py-2.5">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                                            {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $member->nama_lengkap }}</p>
                                                            <p class="text-xs text-gray-400">
                                                                {{ ucfirst($member->tipe_anggota) }}{{ $member->peran ? ' — ' . $member->peran : '' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if ($member->tipe_anggota === 'alumni')
                                                        @php
                                                            $apColors = [
                                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                                'approved' => 'bg-green-100 text-green-700',
                                                                'rejected' => 'bg-red-100 text-red-700',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $apColors[$member->approval_status] ?? '' }}">
                                                            {{ ucfirst($member->approval_status) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400 text-center py-2">Belum ada anggota</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Review Form --}}
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3">
                                <h3 class="text-white font-semibold text-sm">
                                    <i class="fas fa-star mr-1.5"></i>
                                    Review Tahap {{ $st->tahap->tahap_ke }}
                                    @if (isset($myReviews[$st->inov_chalenge_tahap_id]))
                                        <span class="ml-1 text-xs bg-white/20 px-2 py-0.5 rounded-full">Sudah diisi</span>
                                    @endif
                                </h3>
                            </div>
                            <div class="p-6">
                                @php $existingReview = $myReviews[$st->inov_chalenge_tahap_id] ?? null; @endphp
                                <form method="POST"
                                    action="{{ route('reviewer_inovchalenge.assignments.review', [$submission, $st->inov_chalenge_tahap_id]) }}">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                                Komentar <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="komentar" rows="4" required placeholder="Berikan komentar review Anda..."
                                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm px-4 py-2.5">{{ old('komentar', $existingReview->komentar ?? '') }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                                Penilaian <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <textarea name="penilaian" rows="3" placeholder="Berikan penilaian (nilai, komentar tambahan, rekomendasi)..."
                                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm px-4 py-2.5">{{ old('penilaian', $existingReview->penilaian ?? '') }}</textarea>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button type="submit"
                                                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold text-sm rounded-xl hover:from-amber-600 hover:to-amber-700 transition shadow">
                                                <i class="fas fa-paper-plane mr-1.5"></i>
                                                {{ $existingReview ? 'Update Review' : 'Simpan Review' }}
                                            </button>
                                            @if ($existingReview)
                                                <span class="text-xs text-gray-400">
                                                    <i class="fas fa-clock mr-1"></i> Terakhir:
                                                    {{ $existingReview->updated_at->format('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            @else
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-hourglass-half text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700">Belum ada tahap yang disubmit</h3>
                        <p class="text-sm text-gray-400 mt-1">Dosen belum mengajukan tahap apapun untuk submission ini.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
