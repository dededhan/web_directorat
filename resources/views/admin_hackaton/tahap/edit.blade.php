@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8" x-data="fieldBuilder()">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> /
                    <a href="{{ route('admin_hackaton.sessions.show', $tahap->session) }}" class="hover:underline">{{ $tahap->session->nama_sesi }}</a> /
                    Form Builder
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Form Builder: {{ $tahap->nama_tahap }}</h1>
                <p class="mt-2 text-base text-gray-700">Atur seksi (sections) dan field isian yang wajib/opsional diisi pengusul pada Tahap {{ $tahap->tahap_ke }}.</p>
            </div>
            <a href="{{ route('admin_hackaton.sessions.show', $tahap->session) }}" class="inline-flex items-center px-4 py-2.5 text-xs font-bold uppercase tracking-wider bg-white border border-black hover:bg-gray-100">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Sesi
            </a>
        </div>

        {{-- Pengaturan Tahap Form --}}
        <div class="border-2 border-gray-950 bg-white p-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-3 mb-4 flex items-center gap-2">
                <i class="fas fa-cog"></i> Pengaturan Periode & Info Tahap
            </h2>

            <form action="{{ route('admin_hackaton.tahap.update', $tahap) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_tahap" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                            Nama Tahap <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" name="nama_tahap" id="nama_tahap" value="{{ old('nama_tahap', $tahap->nama_tahap) }}" required
                            class="w-full border-2 border-gray-950 px-4 py-2 text-sm focus:bg-amber-50 focus:outline-none">
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                            Petunjuk Singkat
                        </label>
                        <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi', $tahap->deskripsi) }}"
                            class="w-full border-2 border-gray-950 px-4 py-2 text-sm focus:bg-amber-50 focus:outline-none"
                            placeholder="Instruksi untuk pengusul pada tahap ini...">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="periode_awal" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                            Periode Mulai Tahap
                        </label>
                        <input type="datetime-local" name="periode_awal" id="periode_awal"
                            value="{{ old('periode_awal', $tahap->periode_awal ? $tahap->periode_awal->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border-2 border-gray-950 px-4 py-2 text-sm focus:bg-amber-50 focus:outline-none">
                    </div>
                    <div>
                        <label for="periode_akhir" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                            Periode Berakhir Tahap
                        </label>
                        <input type="datetime-local" name="periode_akhir" id="periode_akhir"
                            value="{{ old('periode_akhir', $tahap->periode_akhir ? $tahap->periode_akhir->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border-2 border-gray-950 px-4 py-2 text-sm focus:bg-amber-50 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                        <input type="checkbox" name="has_anggota" value="1" {{ old('has_anggota', $tahap->has_anggota) ? 'checked' : '' }} class="w-4 h-4 border-2 border-gray-950">
                        Aktifkan Pengisian Anggota
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                        <input type="checkbox" name="has_fakultas" value="1" {{ old('has_fakultas', $tahap->has_fakultas) ? 'checked' : '' }} class="w-4 h-4 border-2 border-gray-950">
                        Aktifkan Pilihan Fakultas
                    </label>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider px-5 py-2.5">
                        Simpan Pengaturan Tahap
                    </button>
                </div>
            </form>
        </div>

        {{-- Form Builder Sections & Fields --}}
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b-2 border-gray-950 pb-3">
                <div>
                    <h2 class="text-xl font-black text-gray-950">Daftar Seksi & Field Isian</h2>
                    <p class="text-xs text-gray-600">Susun struktur kuesioner/laporan form tahap ini.</p>
                </div>
                <button type="button" @click="showAddSection = !showAddSection"
                    class="bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5">
                    <i class="fas fa-folder-plus mr-1"></i> Tambah Seksi
                </button>
            </div>

            {{-- Form Tambah Seksi --}}
            <div x-show="showAddSection" x-cloak class="border-2 border-dashed border-gray-950 bg-amber-50 p-5">
                <form action="{{ route('admin_hackaton.tahap.sections.store', $tahap) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Judul Seksi *</label>
                            <input type="text" name="judul" required placeholder="Contoh: A. Profil Inovasi & Gagasan"
                                class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Deskripsi / Penjelasan</label>
                            <input type="text" name="deskripsi" placeholder="Petunjuk khusus seksi ini..."
                                class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showAddSection = false" class="px-3 py-2 text-xs font-bold uppercase text-gray-700 hover:text-black">Batal</button>
                        <button type="submit" class="bg-gray-950 text-white px-4 py-2 text-xs font-bold uppercase">Simpan Seksi</button>
                    </div>
                </form>
            </div>

            {{-- Sections Loop --}}
            @foreach ($tahap->sections as $section)
                <div class="border-2 border-gray-950 bg-white" x-data="{ showAddField: false }">
                    <div class="border-b-2 border-gray-950 bg-gray-100 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-gray-950 text-white text-xs font-black flex items-center justify-center">
                                {{ $loop->iteration }}
                            </span>
                            <div>
                                <h3 class="font-black text-gray-950 text-sm">{{ $section->judul }}</h3>
                                @if ($section->deskripsi)
                                    <p class="text-xs text-gray-500">{{ $section->deskripsi }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="showAddField = !showAddField"
                                class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-3 py-1.5 uppercase">
                                <i class="fas fa-plus text-[10px]"></i> Tambah Field
                            </button>

                            <form action="{{ route('admin_hackaton.tahap.sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Hapus seksi ini beserta semua field di dalamnya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="border border-rose-400 bg-white text-rose-700 hover:bg-rose-50 text-xs font-bold px-2 py-1.5" title="Hapus Seksi">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Form Tambah Field ke Seksi Ini --}}
                    <div x-show="showAddField" x-cloak class="border-b-2 border-gray-950 bg-amber-50 p-4">
                        <form action="{{ route('admin_hackaton.tahap.fields.store', $tahap) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $section->id }}">

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Label Field *</label>
                                    <input type="text" name="field_label" required placeholder="Contoh: Dokumen Proposal Lengkap (PDF)"
                                        class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Tipe Field *</label>
                                    <select name="field_type" x-model="newFieldType" class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                                        <option value="text">Teks Pendek (Text)</option>
                                        <option value="textarea">Teks Panjang (Textarea)</option>
                                        <option value="number">Angka (Number)</option>
                                        <option value="date">Tanggal (Date)</option>
                                        <option value="file">File Upload (PDF/Dokumen/ZIP)</option>
                                        <option value="url">Tautan / Link (URL)</option>
                                        <option value="dropdown">Pilihan Dropdown</option>
                                        <option value="checkbox">Pilihan Checkbox (Multi-select)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Options Builder for Dropdown / Checkbox --}}
                            <div x-show="['dropdown', 'checkbox'].includes(newFieldType)" class="space-y-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-900">Opsi Pilihan (Baris Baru)</label>
                                <textarea name="field_options_raw" rows="3" placeholder="Masukkan 1 opsi per baris..."
                                    class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none"></textarea>
                            </div>

                            {{-- Link & File Template dari Admin --}}
                            <div class="border-t border-amber-200 pt-3 space-y-3">
                                <div class="text-[11px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                                    <i class="fas fa-paperclip text-amber-700"></i>
                                    Link / File Dokumen Template (Opsional untuk Panduan Pengusul)
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Link Template / Teks</label>
                                        <input type="text" name="template_url" placeholder="https://drive.google.com/... atau tautan template"
                                            class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                                        <p class="text-[10px] text-gray-500 mt-0.5">Tautan URL atau petunjuk template untuk pengusul.</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Unggah File Template</label>
                                        <input type="file" name="template_file"
                                            class="w-full border-2 border-gray-950 px-3 py-1.5 text-xs bg-white focus:outline-none">
                                        <input type="text" name="template_file_name" placeholder="Nama/Judul Template (Opsional, cth: Template Proposal)"
                                            class="w-full border-2 border-gray-950 px-3 py-1.5 text-xs bg-white focus:outline-none mt-1.5">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2">
                                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                                    <input type="checkbox" name="is_required" value="1" checked class="w-4 h-4 border-2 border-gray-950">
                                    Wajib Diisi (Required)
                                </label>
                                <div class="flex gap-2">
                                    <button type="button" @click="showAddField = false" class="px-3 py-1.5 text-xs font-bold uppercase text-gray-700">Batal</button>
                                    <button type="submit" class="bg-gray-950 text-white px-4 py-1.5 text-xs font-bold uppercase">Tambah Field</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Fields Table --}}
                    <div class="divide-y divide-gray-200">
                        @forelse ($section->fields as $field)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-950 text-sm">{{ $field->field_label }}</span>
                                        @if ($field->is_required)
                                            <span class="text-[10px] font-black uppercase text-rose-700 bg-rose-50 px-1.5 py-0.5 border border-rose-200">Wajib</span>
                                        @else
                                            <span class="text-[10px] font-semibold text-gray-500 bg-gray-50 px-1.5 py-0.5 border border-gray-200">Opsional</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        <span><i class="fas fa-tag mr-1 text-[10px]"></i> Tipe: <strong>{{ strtoupper($field->field_type) }}</strong></span>
                                        @if ($field->field_options)
                                            <span>Opsi: {{ implode(', ', (array) $field->field_options) }}</span>
                                        @endif
                                        @if ($field->template_url)
                                            <a href="{{ $field->template_url }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 hover:underline">
                                                <i class="fas fa-link text-[10px]"></i> Link Template
                                            </a>
                                        @endif
                                        @if ($field->template_file)
                                            <a href="{{ route('hackaton.templates.download', $field) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 hover:underline">
                                                <i class="fas fa-file-download text-[10px]"></i> Template: {{ $field->template_file_name ?: basename($field->template_file) }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        @click="openEditModal({{ $field->id }}, {{ json_encode($field->field_label) }}, {{ json_encode($field->field_type) }}, {{ json_encode($field->field_options ?? []) }}, {{ $field->is_required ? 'true' : 'false' }}, {{ json_encode($field->template_url ?? '') }}, {{ json_encode($field->template_file ?? '') }}, {{ json_encode($field->template_file_name ?? '') }})"
                                        class="p-2 text-xs font-bold text-gray-700 hover:text-black border border-gray-300 bg-white" title="Edit Field">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin_hackaton.tahap.fields.destroy', $field) }}" method="POST" class="inline" onsubmit="return confirm('Hapus field ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 bg-white" title="Hapus Field">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-gray-400 italic">
                                Belum ada field pada seksi ini. Klik "+ Tambah Field" di atas.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

            {{-- Unsectioned Fields (Lainnya) --}}
            <div class="border-2 border-gray-950 bg-white" x-data="{ showAddUnsectioned: false }">
                <div class="border-b-2 border-gray-950 bg-gray-100 p-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-gray-950 text-sm">Field Tanpa Seksi (Umum)</h3>
                        <p class="text-xs text-gray-500">Field ini akan ditampilkan langsung di luar seksi.</p>
                    </div>
                    <button type="button" @click="showAddUnsectioned = !showAddUnsectioned"
                        class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-3 py-1.5 uppercase">
                        <i class="fas fa-plus text-[10px]"></i> Tambah Field Umum
                    </button>
                </div>

                <div x-show="showAddUnsectioned" x-cloak class="border-b-2 border-gray-950 bg-amber-50 p-4" x-data="{ addType: 'text' }">
                    <form action="{{ route('admin_hackaton.tahap.fields.store', $tahap) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Label Field *</label>
                                <input type="text" name="field_label" required placeholder="Contoh: Link Video Presentasi"
                                    class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Tipe Field *</label>
                                <select name="field_type" x-model="addType" class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                    <option value="file">File Upload</option>
                                    <option value="url">URL</option>
                                    <option value="dropdown">Dropdown</option>
                                    <option value="checkbox">Checkbox</option>
                                </select>
                            </div>
                        </div>

                        {{-- Options Builder for Dropdown / Checkbox --}}
                        <div x-show="['dropdown', 'checkbox'].includes(addType)" class="space-y-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900">Opsi Pilihan (Baris Baru)</label>
                            <textarea name="field_options_raw" rows="3" placeholder="Masukkan 1 opsi per baris..."
                                class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none"></textarea>
                        </div>

                        {{-- Link & File Template dari Admin --}}
                        <div class="border-t border-amber-200 pt-3 space-y-3">
                            <div class="text-[11px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                                <i class="fas fa-paperclip text-amber-700"></i>
                                Link / File Dokumen Template (Opsional untuk Panduan Pengusul)
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Link Template / Teks</label>
                                    <input type="text" name="template_url" placeholder="https://drive.google.com/... atau tautan template"
                                        class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                                    <p class="text-[10px] text-gray-500 mt-0.5">Tautan URL atau petunjuk template untuk pengusul.</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Unggah File Template</label>
                                    <input type="file" name="template_file"
                                        class="w-full border-2 border-gray-950 px-3 py-1.5 text-xs bg-white focus:outline-none">
                                    <input type="text" name="template_file_name" placeholder="Nama/Judul Template (Opsional, cth: Template Pitch Deck)"
                                        class="w-full border-2 border-gray-950 px-3 py-1.5 text-xs bg-white focus:outline-none mt-1.5">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                                <input type="checkbox" name="is_required" value="1" checked class="w-4 h-4 border-2 border-gray-950">
                                Wajib Diisi (Required)
                            </label>
                            <div class="flex gap-2">
                                <button type="button" @click="showAddUnsectioned = false" class="px-3 py-1.5 text-xs font-bold uppercase text-gray-700">Batal</button>
                                <button type="submit" class="bg-gray-950 text-white px-4 py-1.5 text-xs font-bold uppercase">Tambah Field</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($tahap->unsectionedFields as $field)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-950 text-sm">{{ $field->field_label }}</span>
                                    @if ($field->is_required)
                                        <span class="text-[10px] font-black uppercase text-rose-700 bg-rose-50 px-1.5 py-0.5 border border-rose-200">Wajib</span>
                                    @else
                                        <span class="text-[10px] font-semibold text-gray-500 bg-gray-50 px-1.5 py-0.5 border border-gray-200">Opsional</span>
                                    @endif
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                    <span><i class="fas fa-tag mr-1 text-[10px]"></i> Tipe: <strong>{{ strtoupper($field->field_type) }}</strong></span>
                                    @if ($field->field_options)
                                        <span>Opsi: {{ implode(', ', (array) $field->field_options) }}</span>
                                    @endif
                                    @if ($field->template_url)
                                        <a href="{{ $field->template_url }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 hover:underline">
                                            <i class="fas fa-link text-[10px]"></i> Link Template
                                        </a>
                                    @endif
                                    @if ($field->template_file)
                                        <a href="{{ route('hackaton.templates.download', $field) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 hover:underline">
                                            <i class="fas fa-file-download text-[10px]"></i> Template: {{ $field->template_file_name ?: basename($field->template_file) }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                    @click="openEditModal({{ $field->id }}, {{ json_encode($field->field_label) }}, {{ json_encode($field->field_type) }}, {{ json_encode($field->field_options ?? []) }}, {{ $field->is_required ? 'true' : 'false' }}, {{ json_encode($field->template_url ?? '') }}, {{ json_encode($field->template_file ?? '') }}, {{ json_encode($field->template_file_name ?? '') }})"
                                    class="p-2 text-xs font-bold text-gray-700 hover:text-black border border-gray-300 bg-white" title="Edit Field">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin_hackaton.tahap.fields.destroy', $field) }}" method="POST" class="inline" onsubmit="return confirm('Hapus field ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 bg-white" title="Hapus Field">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-gray-400 italic">
                            Tidak ada field umum.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Modal Edit Field --}}
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
            <div class="w-full max-w-lg border-4 border-gray-950 bg-white p-6 space-y-4 max-h-[90vh] overflow-y-auto" @click.away="editModalOpen = false">
                <div class="flex items-center justify-between border-b-2 border-gray-950 pb-3">
                    <h3 class="font-black text-gray-950 text-base uppercase tracking-wider">Edit Field</h3>
                    <button type="button" @click="editModalOpen = false" class="text-gray-500 hover:text-black text-lg">✕</button>
                </div>

                <form :action="'{{ url('admin-hackathon/fields') }}/' + editingField.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Label Field *</label>
                        <input type="text" name="field_label" x-model="editingField.field_label" required
                            class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Tipe Field *</label>
                        <select name="field_type" x-model="editingField.field_type" class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                            <option value="file">File Upload</option>
                            <option value="url">URL</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>

                    <div x-show="['dropdown', 'checkbox'].includes(editingField.field_type)" class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-900">Opsi Pilihan (1 opsi per baris)</label>
                        <textarea name="field_options_raw" rows="3" x-model="editingField.field_options_raw"
                            class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none"></textarea>
                    </div>

                    {{-- Template URL & File in Modal --}}
                    <div class="border-t-2 border-gray-200 pt-3 space-y-3">
                        <div class="text-xs font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                            <i class="fas fa-paperclip text-amber-700"></i>
                            Link / File Dokumen Template (Opsional)
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">Link Template / Teks</label>
                            <input type="text" name="template_url" x-model="editingField.template_url" placeholder="https://... atau petunjuk singkat"
                                class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">File Template</label>
                            <template x-if="editingField.template_file">
                                <div class="mb-2 p-2 bg-gray-50 border border-gray-300 flex items-center justify-between text-xs">
                                    <span class="text-gray-700 font-semibold flex items-center gap-1.5 truncate mr-2">
                                        <i class="fas fa-file text-amber-600"></i>
                                        <span x-text="editingField.template_file_name || 'File Template Saat Ini'"></span>
                                    </span>
                                    <label class="inline-flex items-center gap-1 text-[11px] text-rose-700 font-bold cursor-pointer shrink-0">
                                        <input type="checkbox" name="remove_template_file" value="1" class="w-3.5 h-3.5">
                                        Hapus File Template
                                    </label>
                                </div>
                            </template>
                            <input type="file" name="template_file"
                                class="w-full border-2 border-gray-950 px-3 py-1.5 text-xs bg-white focus:outline-none">
                            <input type="text" name="template_file_name" x-model="editingField.template_file_name" placeholder="Nama/Judul Template (Opsional)"
                                class="w-full border-2 border-gray-950 px-3 py-1.5 text-xs bg-white focus:outline-none mt-1.5">
                            <p class="text-[10px] text-gray-500 mt-0.5">Unggah file baru jika ingin mengganti file template yang ada.</p>
                        </div>
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                            <input type="checkbox" name="is_required" value="1" x-model="editingField.is_required" class="w-4 h-4 border-2 border-gray-950">
                            Wajib Diisi (Required)
                        </label>
                    </div>

                    <div class="border-t-2 border-gray-950 pt-4 flex justify-end gap-2">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs font-bold uppercase text-gray-700">Batal</button>
                        <button type="submit" class="bg-gray-950 text-white px-5 py-2 text-xs font-bold uppercase">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function fieldBuilder() {
            return {
                showAddSection: false,
                newFieldType: 'text',
                editModalOpen: false,
                editingField: {
                    id: '',
                    field_label: '',
                    field_type: 'text',
                    field_options_raw: '',
                    is_required: true,
                    template_url: '',
                    template_file: null,
                    template_file_name: '',
                },
                openEditModal(id, label, type, options, isRequired, templateUrl, templateFile, templateFileName) {
                    this.editingField.id = id;
                    this.editingField.field_label = label || '';
                    this.editingField.field_type = type || 'text';
                    this.editingField.is_required = Boolean(isRequired);
                    this.editingField.template_url = templateUrl || '';
                    this.editingField.template_file = templateFile || null;
                    this.editingField.template_file_name = templateFileName || '';
                    if (Array.isArray(options) && options.length > 0) {
                        this.editingField.field_options_raw = options.join('\n');
                    } else {
                        this.editingField.field_options_raw = '';
                    }
                    this.editModalOpen = true;
                }
            }
        }
    </script>
@endsection
