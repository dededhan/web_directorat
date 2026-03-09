@extends('admin_inovchalenge.index')

@section('contentadmin_inovchalenge')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="fieldBuilder()">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin_inovchalenge.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovchalenge.inovchalenge.sessions.index') }}" class="hover:text-teal-600">Innovation Challenge</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovchalenge.inovchalenge.sessions.show', $tahap->session) }}" class="hover:text-teal-600">{{ $tahap->session->nama_sesi }}</a></li>
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
            <form action="{{ route('admin_inovchalenge.inovchalenge.tahap.update', $tahap) }}" method="POST" class="p-6 space-y-4">
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

        {{-- Sectioned Field Builder --}}
        <div class="space-y-6">

            {{-- Top Bar: Add Section --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-white font-semibold text-lg">
                        <i class="fas fa-layer-group mr-2"></i> Seksi &amp; Field Builder
                        <span class="ml-2 bg-white/20 text-white text-sm px-3 py-0.5 rounded-full">{{ $tahap->sections->count() }} seksi</span>
                    </h2>
                    <button @click="showAddSection = !showAddSection" type="button"
                            class="inline-flex items-center px-3 py-1.5 bg-white/20 text-white text-sm rounded-lg hover:bg-white/30 transition">
                        <i class="fas fa-plus mr-1"></i> Tambah Seksi
                    </button>
                </div>
                {{-- Add Section Form --}}
                <div x-show="showAddSection" x-transition class="p-5 border-t border-gray-100 bg-gray-50">
                    <form action="{{ route('admin_inovchalenge.inovchalenge.tahap.sections.store', $tahap) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Seksi <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" required placeholder="Contoh: Informasi Dasar"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                                <input type="text" name="deskripsi" placeholder="Deskripsi singkat seksi"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showAddSection = false"
                                    class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Batal</button>
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 transition">
                                <i class="fas fa-plus mr-1"></i> Buat Seksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>{{-- /top bar --}}

            {{-- Section Cards --}}
            @forelse($tahap->sections as $section)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
                     x-data="{ editingSection: false, showAddField: false, newFieldType: 'text', newOptions: [''] }">

                    {{-- Section Header --}}
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-3">
                        <div x-show="!editingSection" class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-semibold text-[15px]">
                                    <i class="fas fa-folder-open mr-1.5"></i> {{ $section->judul }}
                                    <span class="ml-2 text-indigo-200 text-xs font-normal">({{ $section->fields->count() }} field)</span>
                                </h3>
                                @if($section->deskripsi)
                                    <p class="text-indigo-200 text-xs mt-0.5">{{ $section->deskripsi }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button @click="editingSection = true" type="button"
                                        class="inline-flex items-center px-2.5 py-1 bg-white/20 text-white text-xs rounded-lg hover:bg-white/30 transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <form method="POST"
                                      action="{{ route('admin_inovchalenge.inovchalenge.tahap.sections.destroy', $section) }}"
                                      onsubmit="return confirm('Hapus seksi ini? Field di dalamnya akan dipindah ke Umum.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1 bg-white/20 text-white text-xs rounded-lg hover:bg-red-500/60 transition">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        {{-- Inline section edit --}}
                        <div x-show="editingSection" x-transition>
                            <form method="POST" action="{{ route('admin_inovchalenge.inovchalenge.tahap.sections.update', $section) }}">
                                @csrf @method('PUT')
                                <div class="flex flex-col sm:flex-row gap-2 items-end">
                                    <div class="flex-1">
                                        <label class="block text-xs text-indigo-200 mb-1">Judul</label>
                                        <input type="text" name="judul" value="{{ $section->judul }}" required
                                               class="w-full rounded-lg text-sm px-3 py-1.5 bg-white/20 text-white border-0 placeholder-indigo-200 focus:ring-white focus:bg-white focus:text-gray-800">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs text-indigo-200 mb-1">Deskripsi</label>
                                        <input type="text" name="deskripsi" value="{{ $section->deskripsi }}"
                                               class="w-full rounded-lg text-sm px-3 py-1.5 bg-white/20 text-white border-0 placeholder-indigo-200 focus:ring-white focus:bg-white focus:text-gray-800">
                                    </div>
                                    <div class="flex gap-2 shrink-0">
                                        <button type="button" @click="editingSection = false"
                                                class="px-3 py-1.5 text-xs bg-white/20 text-white rounded-lg hover:bg-white/30 transition">Batal</button>
                                        <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium bg-white text-indigo-700 rounded-lg hover:bg-indigo-50 transition">
                                            <i class="fas fa-check mr-1"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>{{-- /section header --}}

                    {{-- Fields in section --}}
                    <div class="divide-y divide-gray-100">
                        @forelse($section->fields as $field)
                            <div class="p-4 hover:bg-gray-50 transition group"
                                 x-data="{ editing: false, editOptions: {{ json_encode($field->field_options ?? []) }}, editType: '{{ $field->field_type }}' }">
                                {{-- View mode --}}
                                <div x-show="!editing" class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-medium text-gray-500">{{ $field->urutan }}</span>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $field->field_label }}
                                                @if($field->is_required)<span class="text-red-500 text-xs">*</span>@endif
                                            </div>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    {{ $field->field_type === 'file' ? 'bg-purple-50 text-purple-700' :
                                                       ($field->field_type === 'dropdown' ? 'bg-orange-50 text-orange-700' :
                                                       ($field->field_type === 'checkbox' ? 'bg-indigo-50 text-indigo-700' :
                                                       ($field->field_type === 'url' ? 'bg-cyan-50 text-cyan-700' : 'bg-gray-100 text-gray-600'))) }}">
                                                    @if($field->field_type === 'checkbox')<i class="fas fa-check-square mr-1 text-xs"></i> Multiple
                                                    @elseif($field->field_type === 'dropdown')<i class="fas fa-caret-down mr-1 text-xs"></i> Dropdown
                                                    @else{{ ucfirst($field->field_type) }}
                                                    @endif
                                                </span>
                                                @if(in_array($field->field_type, ['dropdown', 'checkbox']) && $field->field_options)
                                                    <span class="text-xs text-gray-400">({{ count($field->field_options) }} opsi)</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition">
                                        <button @click="editing = true" type="button"
                                                class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <form method="POST"
                                              action="{{ route('admin_inovchalenge.inovchalenge.tahap.fields.destroy', $field) }}"
                                              onsubmit="return confirm('Hapus field ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                {{-- Edit mode --}}
                                <div x-show="editing" x-transition>
                                    <form action="{{ route('admin_inovchalenge.inovchalenge.tahap.fields.update', $field) }}" method="POST" class="space-y-3">
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
                                                    <option value="dropdown">Dropdown (pilih satu)</option>
                                                    <option value="checkbox">Checkbox / Multiple Choices</option>
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
                                        <div x-show="editType === 'dropdown' || editType === 'checkbox'" x-transition class="space-y-2">
                                            <label class="block text-xs font-medium text-gray-500">
                                                <span x-text="editType === 'checkbox' ? 'Opsi Multiple Choices' : 'Opsi Dropdown'"></span>
                                            </label>
                                            <template x-for="(opt, idx) in editOptions" :key="idx">
                                                <div class="flex gap-2 items-center">
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
                                                    class="px-3 py-1.5 text-xs text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Batal</button>
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                                                <i class="fas fa-check mr-1"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center text-sm text-gray-400">Belum ada field di seksi ini.</div>
                        @endforelse
                    </div>

                    {{-- Add field to this section --}}
                    <div class="border-t border-gray-100">
                        <div class="p-3 flex justify-center" x-show="!showAddField">
                            <button @click="showAddField = true" type="button"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                                <i class="fas fa-plus mr-1"></i> Tambah Field ke Seksi Ini
                            </button>
                        </div>
                        <div x-show="showAddField" x-transition class="bg-gray-50 p-5 border-t border-gray-100">
                            <form action="{{ route('admin_inovchalenge.inovchalenge.tahap.fields.store', $tahap) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="section_id" value="{{ $section->id }}">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
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
                                            <option value="dropdown">Dropdown (pilih satu)</option>
                                            <option value="checkbox">Checkbox / Multiple Choices</option>
                                            <option value="file">File Upload</option>
                                            <option value="url">URL</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Wajib?</label>
                                        <select name="is_required"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div x-show="newFieldType === 'dropdown' || newFieldType === 'checkbox'" x-transition class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <span x-text="newFieldType === 'checkbox' ? 'Opsi Multiple Choices' : 'Opsi Dropdown'"></span>
                                    </label>
                                    <template x-for="(opt, idx) in newOptions" :key="idx">
                                        <div class="flex gap-2 items-center">
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
                                    <button type="button" @click="showAddField = false; newOptions = ['']"
                                            class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Batal</button>
                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 transition">
                                        <i class="fas fa-plus mr-1"></i> Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>{{-- /section card --}}
            @empty
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 text-center text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    Belum ada seksi. Klik <strong>"Tambah Seksi"</strong> di atas untuk mulai mengelompokkan field ke dalam beberapa bagian, atau tambahkan langsung sebagai <strong>Field Umum</strong> di bawah.
                </div>
            @endforelse

            {{-- Unsectioned (General) Fields --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
                 x-data="{ showAddField: showAddUnsectionedField, newFieldType: newUnsectionedFieldType, newOptions: newUnsectionedOptions }">

                <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-3 flex items-center justify-between">
                    <h3 class="text-white font-semibold text-[15px]">
                        <i class="fas fa-list-ul mr-1.5"></i> Field Umum <span class="font-normal text-gray-300 text-xs">(tanpa seksi)</span>
                        <span class="ml-2 text-gray-400 text-xs">({{ $tahap->unsectionedFields->count() }} field)</span>
                    </h3>
                </div>

                @if($errors->has('field_label') || $errors->has('field_type'))
                    <div class="bg-red-50 border-b border-red-200 px-6 py-3">
                        @foreach($errors->all() as $error)
                            <p class="text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="divide-y divide-gray-100">
                    @forelse($tahap->unsectionedFields as $field)
                        <div class="p-4 hover:bg-gray-50 transition group"
                             x-data="{ editing: false, editOptions: {{ json_encode($field->field_options ?? []) }}, editType: '{{ $field->field_type }}' }">
                            <div x-show="!editing" class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-medium text-gray-500">{{ $field->urutan }}</span>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $field->field_label }}
                                            @if($field->is_required)<span class="text-red-500 text-xs">*</span>@endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                {{ $field->field_type === 'file' ? 'bg-purple-50 text-purple-700' :
                                                   ($field->field_type === 'dropdown' ? 'bg-orange-50 text-orange-700' :
                                                   ($field->field_type === 'checkbox' ? 'bg-indigo-50 text-indigo-700' :
                                                   ($field->field_type === 'url' ? 'bg-cyan-50 text-cyan-700' : 'bg-gray-100 text-gray-600'))) }}">
                                                @if($field->field_type === 'checkbox')<i class="fas fa-check-square mr-1 text-xs"></i> Multiple
                                                @elseif($field->field_type === 'dropdown')<i class="fas fa-caret-down mr-1 text-xs"></i> Dropdown
                                                @else{{ ucfirst($field->field_type) }}
                                                @endif
                                            </span>
                                            @if(in_array($field->field_type, ['dropdown', 'checkbox']) && $field->field_options)
                                                <span class="text-xs text-gray-400">({{ count($field->field_options) }} opsi)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition">
                                    <button @click="editing = true" type="button"
                                            class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <form method="POST"
                                          action="{{ route('admin_inovchalenge.inovchalenge.tahap.fields.destroy', $field) }}"
                                          onsubmit="return confirm('Hapus field ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div x-show="editing" x-transition>
                                <form action="{{ route('admin_inovchalenge.inovchalenge.tahap.fields.update', $field) }}" method="POST" class="space-y-3">
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
                                                <option value="dropdown">Dropdown (pilih satu)</option>
                                                <option value="checkbox">Checkbox / Multiple Choices</option>
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
                                    <div x-show="editType === 'dropdown' || editType === 'checkbox'" x-transition class="space-y-2">
                                        <label class="block text-xs font-medium text-gray-500">
                                            <span x-text="editType === 'checkbox' ? 'Opsi Multiple Choices' : 'Opsi Dropdown'"></span>
                                        </label>
                                        <template x-for="(opt, idx) in editOptions" :key="idx">
                                            <div class="flex gap-2 items-center">
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
                                                class="px-3 py-1.5 text-xs text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Batal</button>
                                        <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                                            <i class="fas fa-check mr-1"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-sm text-gray-400">Tidak ada field umum.</div>
                    @endforelse
                </div>

                {{-- Add Unsectioned Field --}}
                <div class="border-t border-gray-100">
                    <div class="p-3 flex justify-center" x-show="!showAddField">
                        <button @click="showAddField = true" type="button"
                                class="inline-flex items-center px-3 py-1.5 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-plus mr-1"></i> Tambah Field Umum (Tanpa Seksi)
                        </button>
                    </div>
                    <div x-show="showAddField" x-transition class="bg-gray-50 p-5 border-t border-gray-100">
                        <form action="{{ route('admin_inovchalenge.inovchalenge.tahap.fields.store', $tahap) }}" method="POST" class="space-y-4">
                            @csrf
                            {{-- no section_id = unsectioned --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
                                    <input type="text" name="field_label" required
                                           value="{{ old('field_label') }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm {{ $errors->has('field_label') ? 'border-red-400' : '' }}"
                                           placeholder="Contoh: Catatan Tambahan">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                                    <select name="field_type" x-model="newFieldType" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                        <option value="text">Text</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="dropdown">Dropdown (pilih satu)</option>
                                        <option value="checkbox">Checkbox / Multiple Choices</option>
                                        <option value="file">File Upload</option>
                                        <option value="url">URL</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Wajib?</label>
                                    <select name="is_required"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                                        <option value="1" {{ old('is_required', '1') === '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ old('is_required') === '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <div x-show="newFieldType === 'dropdown' || newFieldType === 'checkbox'" x-transition class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <span x-text="newFieldType === 'checkbox' ? 'Opsi Multiple Choices' : 'Opsi Dropdown'"></span>
                                </label>
                                <template x-for="(opt, idx) in newOptions" :key="idx">
                                    <div class="flex gap-2 items-center">
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
                                <button type="button" @click="showAddField = false; newOptions = ['']"
                                        class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Batal</button>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                                    <i class="fas fa-plus mr-1"></i> Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>{{-- /unsectioned fields --}}

        </div>{{-- /space-y-6 --}}

        {{-- Back --}}
        <div class="mt-6">
            <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.show', $tahap->session) }}"
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
            showAddSection: {{ $errors->has('judul') ? 'true' : 'false' }},
            showAddUnsectionedField: {{ $errors->has('field_label') || $errors->has('field_type') ? 'true' : 'false' }},
            newUnsectionedFieldType: '{{ old('field_type', 'text') }}',
            newUnsectionedOptions: @json(old('field_options') ? array_values(old('field_options')) : ['']),
        }
    }
</script>
@endpush