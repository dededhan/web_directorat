@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="fieldBuilder()">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}" class="hover:text-teal-600">Innovation Challenge</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.show', $tahap->session) }}" class="hover:text-teal-600">{{ $tahap->session->nama_sesi }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-700 font-medium">{{ $tahap->nama_tahap }}</li>
            </ol>
        </nav>

        {{-- Tahap Meta Edit --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r {{ $tahap->tahap_ke === 1 ? 'from-blue-500 to-blue-600' : ($tahap->tahap_ke === 2 ? 'from-purple-500 to-purple-600' : 'from-orange-500 to-orange-600') }} px-6 py-4">
                <h2 class="text-white font-semibold text-lg">
                    <i class="fas fa-flag mr-2"></i> {{ $tahap->nama_tahap }} — Pengaturan
                </h2>
            </div>
            <form action="{{ route('admin_inovasi.inovchalenge.tahap.update', $tahap) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_tahap" class="block text-sm font-medium text-gray-700 mb-1">Nama Tahap</label>
                        <input type="text" name="nama_tahap" id="nama_tahap"
                               value="{{ old('nama_tahap', $tahap->nama_tahap) }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('nama_tahap') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ old('deskripsi', $tahap->deskripsi) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                               placeholder="Deskripsi tahap (opsional)">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-1">Periode Awal</label>
                        <input type="datetime-local" name="periode_awal" id="periode_awal"
                               value="{{ old('periode_awal', $tahap->periode_awal?->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-1">Periode Akhir</label>
                        <input type="datetime-local" name="periode_akhir" id="periode_akhir"
                               value="{{ old('periode_akhir', $tahap->periode_akhir?->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    </div>
                </div>

                {{-- Flags (read-only info) --}}
                @if($tahap->has_anggota || $tahap->has_fakultas)
                    <div class="flex gap-3 text-xs text-gray-500">
                        @if($tahap->has_anggota)
                            <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded border border-blue-200">
                                <i class="fas fa-users mr-1"></i> Anggota Tim (aktif)
                            </span>
                        @endif
                        @if($tahap->has_fakultas)
                            <span class="inline-flex items-center px-2 py-1 bg-green-50 text-green-700 rounded border border-green-200">
                                <i class="fas fa-university mr-1"></i> Fakultas (aktif)
                            </span>
                        @endif
                    </div>
                @endif

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl hover:from-teal-600 hover:to-teal-700 shadow transition">
                        <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- Dynamic Field Builder --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex items-center justify-between">
                <h2 class="text-white font-semibold text-lg">
                    <i class="fas fa-list-ul mr-2"></i> Form Fields
                    <span class="ml-2 bg-white/20 text-white text-sm px-3 py-0.5 rounded-full">{{ $tahap->fields->count() }}</span>
                </h2>
                <button @click="showAddForm = !showAddForm" type="button"
                        class="inline-flex items-center px-3 py-1.5 bg-white/20 text-white text-sm rounded-lg hover:bg-white/30 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Field
                </button>
            </div>

            {{-- Add Field Form (toggle) --}}
            <div x-show="showAddForm" x-transition class="border-b border-gray-200 bg-gray-50 p-6">
                <form action="{{ route('admin_inovasi.inovchalenge.tahap.fields.store', $tahap) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Label Field <span class="text-red-500">*</span></label>
                            <input type="text" name="field_label" required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                                   placeholder="Contoh: Judul Inovasi">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                            <select name="field_type" x-model="newFieldType" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                                <option value="dropdown">Dropdown</option>
                                <option value="file">File Upload</option>
                                <option value="url">URL</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Wajib diisi?</label>
                            <select name="is_required"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>

                    {{-- Dropdown Options --}}
                    <div x-show="newFieldType === 'dropdown'" x-transition class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Opsi Dropdown</label>
                        <template x-for="(opt, idx) in newOptions" :key="idx">
                            <div class="flex gap-2">
                                <input type="text" :name="'field_options[' + idx + ']'" x-model="newOptions[idx]"
                                       class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                                       placeholder="Nama opsi">
                                <button type="button" @click="newOptions.splice(idx, 1)"
                                        class="px-2 py-1 text-red-500 hover:text-red-700 text-sm">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="newOptions.push('')"
                                class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                            <i class="fas fa-plus mr-1"></i> Tambah Opsi
                        </button>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showAddForm = false"
                                class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                            <i class="fas fa-plus mr-1"></i> Tambah
                        </button>
                    </div>
                </form>
            </div>

            {{-- Field List --}}
            <div class="divide-y divide-gray-100" id="field-list">
                @forelse($tahap->fields as $field)
                    <div class="p-4 hover:bg-gray-50 transition group" x-data="{ editing: false, editOptions: {{ json_encode($field->field_options ?? []) }}, editType: '{{ $field->field_type }}' }">
                        {{-- View Mode --}}
                        <div x-show="!editing" class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-medium text-gray-500">
                                    {{ $field->urutan }}
                                </span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $field->field_label }}
                                        @if($field->is_required)
                                            <span class="text-red-500 text-xs">*</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            {{ $field->field_type === 'file' ? 'bg-purple-50 text-purple-700' :
                                               ($field->field_type === 'dropdown' ? 'bg-orange-50 text-orange-700' :
                                               ($field->field_type === 'url' ? 'bg-cyan-50 text-cyan-700' : 'bg-gray-100 text-gray-600')) }}">
                                            {{ ucfirst($field->field_type) }}
                                        </span>
                                        @if($field->field_type === 'dropdown' && $field->field_options)
                                            <span class="text-xs text-gray-400">
                                                ({{ count($field->field_options) }} opsi)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition">
                                <button @click="editing = true" type="button"
                                        class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <form method="POST" action="{{ route('admin_inovasi.inovchalenge.tahap.fields.destroy', $field) }}"
                                      onsubmit="return confirm('Hapus field ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Mode --}}
                        <div x-show="editing" x-transition>
                            <form action="{{ route('admin_inovasi.inovchalenge.tahap.fields.update', $field) }}" method="POST" class="space-y-3">
                                @csrf @method('PUT')
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Label</label>
                                        <input type="text" name="field_label" value="{{ $field->field_label }}" required
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
                                        <select name="field_type" x-model="editType"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                            <option value="text">Text</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="number">Number</option>
                                            <option value="date">Date</option>
                                            <option value="dropdown">Dropdown</option>
                                            <option value="file">File Upload</option>
                                            <option value="url">URL</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Wajib?</label>
                                        <select name="is_required"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                            <option value="1" {{ $field->is_required ? 'selected' : '' }}>Ya</option>
                                            <option value="0" {{ !$field->is_required ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Dropdown options editor --}}
                                <div x-show="editType === 'dropdown'" x-transition class="space-y-2">
                                    <label class="block text-xs font-medium text-gray-500">Opsi Dropdown</label>
                                    <template x-for="(opt, idx) in editOptions" :key="idx">
                                        <div class="flex gap-2">
                                            <input type="text" :name="'field_options[' + idx + ']'" x-model="editOptions[idx]"
                                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                            <button type="button" @click="editOptions.splice(idx, 1)"
                                                    class="px-2 py-1 text-red-500 hover:text-red-700 text-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </template>
                                    <button type="button" @click="editOptions.push('')"
                                            class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                                        <i class="fas fa-plus mr-1"></i> Tambah Opsi
                                    </button>
                                </div>

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="editing = false"
                                            class="px-3 py-1.5 text-xs text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                                        <i class="fas fa-check mr-1"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-3">
                                <i class="fas fa-th-list text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm">Belum ada field. Klik "Tambah Field" untuk memulai.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Back --}}
        <div class="mt-6">
            <a href="{{ route('admin_inovasi.inovchalenge.sessions.show', $tahap->session) }}"
               class="inline-flex items-center text-sm text-gray-500 hover:text-teal-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail Sesi
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function fieldBuilder() {
        return {
            showAddForm: false,
            newFieldType: 'text',
            newOptions: [''],
        }
    }
</script>
@endpush
