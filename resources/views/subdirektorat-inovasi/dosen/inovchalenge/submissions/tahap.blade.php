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

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-teal-500 to-teal-600">
                        <h2 class="text-lg font-bold text-white"><i class="fas fa-file-alt mr-2"></i>Formulir</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach ($tahap->fields->sortBy('urutan') as $field)
                            @php
                                $fieldKey = 'field_' . $field->id;
                                $fv = $fieldValues[$field->id] ?? null;
                                $currentValue = null;
                                if ($fv) {
                                    if ($field->field_type === 'file') {
                                        $currentValue = $fv->value_file_path;
                                    } elseif ($field->field_type === 'url') {
                                        $currentValue = $fv->value_url;
                                    } else {
                                        $currentValue = $fv->value_text;
                                    }
                                }
                            @endphp
                            <div>
                                <label for="{{ $fieldKey }}" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    {{ $field->field_label }}
                                    @if ($field->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>

                                @if ($field->field_placeholder)
                                    <p class="text-xs text-gray-400 mb-1">{{ $field->field_placeholder }}</p>
                                @endif

                                @switch($field->field_type)
                                    @case('text')
                                        <input type="text" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                                            value="{{ old($fieldKey, $currentValue) }}"
                                            placeholder="{{ $field->field_placeholder ?? '' }}"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                                            {{ !$isEditable ? 'disabled' : '' }}>
                                    @break

                                    @case('textarea')
                                        <textarea name="{{ $fieldKey }}" id="{{ $fieldKey }}" rows="4"
                                            placeholder="{{ $field->field_placeholder ?? '' }}"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                                            {{ !$isEditable ? 'disabled' : '' }}>{{ old($fieldKey, $currentValue) }}</textarea>
                                    @break

                                    @case('number')
                                        <input type="number" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                                            value="{{ old($fieldKey, $currentValue) }}"
                                            placeholder="{{ $field->field_placeholder ?? '' }}"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                                            {{ !$isEditable ? 'disabled' : '' }}>
                                    @break

                                    @case('date')
                                        <input type="date" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                                            value="{{ old($fieldKey, $currentValue) }}"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                                            {{ !$isEditable ? 'disabled' : '' }}>
                                    @break

                                    @case('dropdown')
                                        <select name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                                            {{ !$isEditable ? 'disabled' : '' }}>
                                            <option value="">-- Pilih --</option>
                                            @if ($field->field_options)
                                                @foreach ($field->field_options as $opt)
                                                    <option value="{{ $opt }}"
                                                        {{ old($fieldKey, $currentValue) == $opt ? 'selected' : '' }}>
                                                        {{ $opt }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    @break

                                    @case('file')
                                        @if ($currentValue)
                                            <div class="mb-2 flex items-center gap-2 text-sm">
                                                <i class="fas fa-paperclip text-teal-500"></i>
                                                <a href="{{ asset('storage/' . $currentValue) }}" target="_blank"
                                                    class="text-teal-600 hover:underline">
                                                    {{ $fv->original_filename ?? basename($currentValue) }}
                                                </a>
                                                <span class="text-gray-400 text-xs">(sudah diunggah)</span>
                                            </div>
                                        @endif
                                        @if ($isEditable)
                                            <input type="file" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                            @if ($currentValue)
                                                <p class="text-[11px] text-gray-400 mt-1">Upload file baru untuk mengganti file yang
                                                    sudah ada</p>
                                            @endif
                                        @endif
                                    @break

                                    @case('url')
                                        <input type="url" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                                            value="{{ old($fieldKey, $currentValue) }}"
                                            placeholder="{{ $field->field_placeholder ?? 'https://...' }}"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                                            {{ !$isEditable ? 'disabled' : '' }}>
                                    @break
                                @endswitch
                            </div>
                        @endforeach

                        @if ($tahap->fields->isEmpty())
                            <p class="text-sm text-gray-400 text-center py-4">Belum ada field yang dikonfigurasi untuk tahap
                                ini.</p>
                        @endif
                    </div>
                </div>

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

            {{-- ═══════════════════ ANGGOTA TIM (only if tahap has_anggota) ═══════════════════ --}}
            @if ($tahap->has_anggota && $members !== null)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6"
                    x-data="memberManager()">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-500 to-indigo-600">
                        <h2 class="text-lg font-bold text-white"><i class="fas fa-users mr-2"></i>Anggota Tim</h2>
                    </div>
                    <div class="p-6">
                        {{-- Member list --}}
                        <div class="divide-y divide-gray-100 mb-6">
                            @forelse($members as $member)
                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $member->nama_lengkap }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ ucfirst($member->tipe_anggota) }}
                                                @if ($member->nik_nim_nip)
                                                    · {{ $member->nik_nim_nip }}
                                                @endif
                                                @if ($member->institusi_fakultas)
                                                    · {{ $member->institusi_fakultas }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if ($member->peran === 'Ketua')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-100 text-indigo-700">
                                                <i class="fas fa-crown mr-1 text-[9px]"></i> Ketua
                                            </span>
                                        @else
                                            @if ($member->tipe_anggota === 'alumni')
                                                @php
                                                    $apColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                                        'approved' => 'bg-green-100 text-green-700',
                                                        'rejected' => 'bg-red-100 text-red-700',
                                                    ];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $apColors[$member->approval_status] ?? 'bg-gray-100 text-gray-600' }}">
                                                    {{ ucfirst($member->approval_status) }}
                                                </span>
                                            @endif
                                            @if ($isEditable)
                                                <form method="POST"
                                                    action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.members.destroy', [$submission, $member]) }}"
                                                    onsubmit="return confirm('Hapus anggota ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-400 hover:text-red-600 text-xs p-1"
                                                        title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 py-4 text-center">Belum ada anggota selain ketua.</p>
                            @endforelse
                        </div>

                        {{-- Add member form --}}
                        @if ($isEditable)
                            <div class="border-t border-gray-100 pt-6">
                                <h3 class="text-sm font-bold text-gray-700 mb-4"><i
                                        class="fas fa-user-plus mr-1.5 text-indigo-500"></i>Tambah Anggota</h3>
                                <form method="POST"
                                    action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.members.store', $submission) }}">
                                    @csrf
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe Anggota
                                                <span class="text-red-500">*</span></label>
                                            <select name="tipe_anggota" x-model="tipeAnggota" @change="onTipeChange()"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required>
                                                <option value="">-- Pilih --</option>
                                                <option value="dosen">Dosen</option>
                                                <option value="alumni">Alumni</option>
                                                <option value="eksternal">Eksternal</option>
                                            </select>
                                        </div>

                                        {{-- User search for dosen/alumni --}}
                                        <div x-show="tipeAnggota === 'dosen' || tipeAnggota === 'alumni'">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari User</label>
                                            <div class="relative">
                                                <input type="text" x-model="searchQuery"
                                                    @input.debounce.300ms="searchUser()"
                                                    placeholder="Ketik nama atau email..."
                                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                {{-- Dropdown results --}}
                                                <div x-show="searchResults.length > 0"
                                                    class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-40 overflow-auto">
                                                    <template x-for="user in searchResults" :key="user.id">
                                                        <div @click="selectUser(user)"
                                                            class="px-3 py-2 hover:bg-indigo-50 cursor-pointer text-sm border-b border-gray-50">
                                                            <p class="font-medium text-gray-800" x-text="user.name"></p>
                                                            <p class="text-xs text-gray-400" x-text="user.email"></p>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                            <input type="hidden" name="user_id" x-model="selectedUserId">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="nama_lengkap" x-model="namaLengkap" required
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-600 mb-1">NIK/NIM/NIP</label>
                                            <input type="text" name="nik_nim_nip"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-600 mb-1">Institusi/Fakultas</label>
                                            <input type="text" name="institusi_fakultas"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-lg hover:bg-indigo-600 transition">
                                            <i class="fas fa-plus mr-1.5"></i> Tambah Anggota
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
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

        // Alpine member manager
        function memberManager() {
            return {
                tipeAnggota: '',
                searchQuery: '',
                searchResults: [],
                selectedUserId: '',
                namaLengkap: '',

                onTipeChange() {
                    this.searchQuery = '';
                    this.searchResults = [];
                    this.selectedUserId = '';
                    this.namaLengkap = '';
                },

                async searchUser() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    try {
                        const res = await fetch(
                            `{{ route('subdirektorat-inovasi.dosen.inovchalenge.members.search') }}?q=${encodeURIComponent(this.searchQuery)}&type=${this.tipeAnggota}`
                        );
                        this.searchResults = await res.json();
                    } catch (e) {
                        this.searchResults = [];
                    }
                },

                selectUser(user) {
                    this.selectedUserId = user.id;
                    this.namaLengkap = user.name;
                    this.searchQuery = user.name + ' (' + user.email + ')';
                    this.searchResults = [];
                }
            };
        }
    </script>
@endpush
