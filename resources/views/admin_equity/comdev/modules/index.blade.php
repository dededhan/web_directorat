@extends('admin_equity.index')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
    openModuleForm: false, 
    openSubChapterForm: null, 
    editingSubChapterId: null,
    editingModuleId: null,
    formPenilaian: [],
    addKriteria() {
        this.formPenilaian.push({
            label: '',
            type: 'number',
            bobot: 0,
            keterangan: ''
        });
    },
    removeKriteria(index) {
        this.formPenilaian.splice(index, 1);
    },
    initEditModule(moduleId, existingForm) {
        this.editingModuleId = moduleId;
        this.formPenilaian = existingForm && existingForm.length > 0 ? JSON.parse(JSON.stringify(existingForm)) : [];
    }
}">
    {{-- Header dan Breadcrumbs --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Modul: {{ $sesi->nama_sesi }}</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-[#11A697]">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-[#11A697]">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Manajemen Modul</li>
            </ol>
        </nav>
    </div>

    {{-- Daftar Modul --}}
    <div class="space-y-8">
        @forelse($modules as $module)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-[#11A697] text-white flex justify-between items-center">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class='bx bxs-collection text-2xl mr-3'></i>
                        {{ $module->urutan }}. {{ $module->nama_modul }}
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button @click="initEditModule({{ $module->id }}, {{ json_encode($module->form_penilaian ?? []) }})" class="text-white hover:text-yellow-200 transition duration-200" title="Edit Modul & Form Penilaian">
                            <i class='bx bxs-edit text-xl'></i>
                        </button>
                        <button type="button" 
                                onclick="confirmDeleteModule({{ $module->id }}, '{{ addslashes($module->nama_modul) }}')" 
                                class="text-white hover:text-red-200 transition duration-200" 
                                title="Hapus Modul">
                            <i class='bx bxs-trash text-xl'></i>
                        </button>
                        <form id="delete-module-form-{{ $module->id }}" 
                              action="{{ route('admin_equity.comdev.modules.destroy', $module->id) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>

                {{-- [NEW] Edit Modul & Form Penilaian --}}
                <div x-show="editingModuleId === {{ $module->id }}" x-cloak x-transition class="p-6 border-b bg-gray-50">
                    <form action="{{ route('admin_equity.comdev.modules.update', $module->id) }}" method="POST" class="space-y-6" 
                          x-ref="editForm{{ $module->id }}"
                          @submit.prevent="
                              const form = $refs.editForm{{ $module->id }};
                              const existingInputs = form.querySelectorAll('input[name^=form_penilaian], select[name^=form_penilaian], textarea[name^=form_penilaian]');
                              existingInputs.forEach(input => input.remove());
                              
                              formPenilaian.forEach((kriteria, idx) => {
                                  ['label', 'type', 'bobot', 'keterangan'].forEach(field => {
                                      const input = document.createElement('input');
                                      input.type = 'hidden';
                                      input.name = `form_penilaian[${idx}][${field}]`;
                                      input.value = kriteria[field] || '';
                                      form.appendChild(input);
                                  });
                              });
                              
                              form.submit();
                          ">
                        @csrf
                        @method('PUT')
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Modul & Form Penilaian</h3>
                        
                        {{-- Basic Module Info --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                <input type="number" name="urutan" value="{{ $module->urutan }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Modul</label>
                                <input type="text" name="nama_modul" value="{{ $module->nama_modul }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="deskripsi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" rows="2">{{ $module->deskripsi }}</textarea>
                        </div>

                        {{-- Form Penilaian Section --}}
                        <div class="border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-md font-bold text-gray-800">Form Penilaian Reviewer</h4>
                                <button type="button" @click="addKriteria()" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                                    <i class='bx bx-plus text-lg mr-1'></i> Tambah Kriteria
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(kriteria, index) in formPenilaian" :key="index">
                                    <div class="bg-white border border-gray-300 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-3">
                                            <h5 class="text-sm font-semibold text-gray-700">Kriteria <span x-text="index + 1"></span></h5>
                                            <button type="button" @click="removeKriteria(index)" class="text-red-500 hover:text-red-700">
                                                <i class='bx bx-trash text-lg'></i>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Label/Nama Kriteria</label>
                                                <input type="text" 
                                                       x-model="kriteria.label" 
                                                       class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                       placeholder="Contoh: Kesesuaian dengan Tujuan" 
                                                       required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Tipe Input</label>
                                                <select x-model="kriteria.type" 
                                                        class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                        required>
                                                    <option value="number">Angka (Number)</option>
                                                    <option value="text">Teks Singkat</option>
                                                    <option value="textarea">Teks Panjang</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Bobot (%)</label>
                                                <input type="number" 
                                                       x-model="kriteria.bobot" 
                                                       class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                       placeholder="0-100" 
                                                       min="0" 
                                                       max="100">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan/Instruksi</label>
                                                <textarea x-model="kriteria.keterangan" 
                                                          class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                          rows="2" 
                                                          placeholder="Instruksi untuk reviewer"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div x-show="formPenilaian.length === 0" class="text-center py-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                                    <i class='bx bx-info-circle text-3xl text-gray-400'></i>
                                    <p class="text-sm text-gray-500 mt-2">Belum ada kriteria penilaian. Klik "Tambah Kriteria" untuk menambahkan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 border-t pt-4">
                            <button type="button" @click="editingModuleId = null; formPenilaian = []" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition">Update Modul</button>
                        </div>
                    </form>
                </div>

                {{-- Daftar Sub-Bab --}}
                <div class="p-6">
                    <ul class="space-y-3">
                        @forelse($module->subChapters as $subChapter)
                            <li class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $subChapter->urutan }}. {{ $subChapter->nama_sub_bab }} 
                                            @if($subChapter->is_wajib)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 bg-red-100 text-red-800 text-xs font-semibold rounded">Wajib</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Periode: 
                                            {{ $subChapter->periode_awal ? \Carbon\Carbon::parse($subChapter->periode_awal)->isoFormat('D MMM YYYY, HH:mm') : 'N/A' }} - 
                                            {{ $subChapter->periode_akhir ? \Carbon\Carbon::parse($subChapter->periode_akhir)->isoFormat('D MMM YYYY, HH:mm') : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button @click="editingSubChapterId = {{ $subChapter->id }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit Sub-Bab"><i class='bx bxs-edit text-lg'></i></button>
                                        <button type="button" 
                                                onclick="confirmDeleteSubChapter({{ $subChapter->id }}, '{{ addslashes($subChapter->nama_sub_bab) }}')" 
                                                class="text-red-500 hover:text-red-700 transition" 
                                                title="Hapus Sub-Bab">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                        <form id="delete-subchapter-form-{{ $subChapter->id }}" 
                                              action="{{ route('admin_equity.comdev.subchapters.destroy', $subChapter->id) }}" 
                                              method="POST" 
                                              class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>

                                {{-- [NEW] Edit Sub-Bab Form --}}
                                <div x-show="editingSubChapterId === {{ $subChapter->id }}" x-cloak x-transition class="mt-4 pt-4 border-t border-gray-200">
                                    <form action="{{ route('admin_equity.comdev.subchapters.update', $subChapter->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <h4 class="font-semibold text-gray-700">Edit Sub-Bab</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="edit_sub_urutan_{{ $subChapter->id }}" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                                <input type="number" id="edit_sub_urutan_{{ $subChapter->id }}" name="urutan" value="{{ $subChapter->urutan }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                                            </div>
                                            <div>
                                                <label for="edit_sub_nama_{{ $subChapter->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Sub-Bab</label>
                                                <input type="text" id="edit_sub_nama_{{ $subChapter->id }}" name="nama_sub_bab" value="{{ $subChapter->nama_sub_bab }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="edit_sub_deskripsi_{{ $subChapter->id }}" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi/Instruksi (Opsional)</label>
                                            <textarea id="edit_sub_deskripsi_{{ $subChapter->id }}" name="deskripsi_instruksi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" rows="3">{{ $subChapter->deskripsi_instruksi }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="edit_sub_periode_awal_{{ $subChapter->id }}" class="block text-sm font-medium text-gray-700 mb-1">Periode Awal</label>
                                                <input type="datetime-local" id="edit_sub_periode_awal_{{ $subChapter->id }}" name="periode_awal" value="{{ $subChapter->periode_awal ? \Carbon\Carbon::parse($subChapter->periode_awal)->format('Y-m-d\TH:i') : '' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="edit_sub_periode_akhir_{{ $subChapter->id }}" class="block text-sm font-medium text-gray-700 mb-1">Periode Akhir</label>
                                                <input type="datetime-local" id="edit_sub_periode_akhir_{{ $subChapter->id }}" name="periode_akhir" value="{{ $subChapter->periode_akhir ? \Carbon\Carbon::parse($subChapter->periode_akhir)->format('Y-m-d\TH:i') : '' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="edit_sub_is_wajib_{{ $subChapter->id }}" name="is_wajib" value="1" {{ $subChapter->is_wajib ? 'checked' : '' }} class="h-4 w-4 text-[#11A697] border-gray-300 rounded focus:ring-[#11A697]">
                                            <label for="edit_sub_is_wajib_{{ $subChapter->id }}" class="ml-2 text-sm text-gray-700">Status Wajib</label>
                                        </div>
                                        <div class="flex justify-end space-x-2 pt-2">
                                            <button type="button" @click="editingSubChapterId = null" class="px-4 py-2 text-sm bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</button>
                                            <button type="submit" class="px-4 py-2 text-sm bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <p class="text-sm text-center text-gray-500 py-4">Belum ada sub-bab untuk modul ini.</p>
                        @endforelse
                    </ul>

                    {{-- Tombol & Form Tambah Sub-Bab --}}
                    <div class="mt-6 border-t pt-5">
                        <button @click="openSubChapterForm = (openSubChapterForm === {{ $module->id }} ? null : {{ $module->id }})" class="inline-flex items-center text-sm text-[#11A697] hover:text-[#0e8a7c] font-semibold transition">
                            <i class='bx bx-plus-circle mr-2 text-lg'></i> Tambah Sub-Bab
                        </button>
                        <div x-show="openSubChapterForm === {{ $module->id }}" x-cloak x-transition class="mt-4 bg-gray-50/70 p-4 rounded-lg border">
                            <form action="{{ route('admin_equity.comdev.subchapters.store', $module->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <h4 class="font-semibold text-gray-700">Form Sub-Bab Baru</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sub_urutan_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                        <input type="number" id="sub_urutan_{{ $module->id }}" name="urutan" placeholder="Cth: 1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                                    </div>
                                    <div>
                                        <label for="sub_nama_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Sub-Bab</label>
                                        <input type="text" id="sub_nama_{{ $module->id }}" name="nama_sub_bab" placeholder="Masukkan nama sub-bab" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="sub_deskripsi_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi/Instruksi (Opsional)</label>
                                    <textarea id="sub_deskripsi_{{ $module->id }}" name="deskripsi_instruksi" placeholder="Jelaskan instruksi singkat untuk sub-bab ini" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" rows="3"></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sub_periode_awal_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Periode Awal</label>
                                        <input type="datetime-local" id="sub_periode_awal_{{ $module->id }}" name="periode_awal" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="sub_periode_akhir_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Periode Akhir</label>
                                        <input type="datetime-local" id="sub_periode_akhir_{{ $module->id }}" name="periode_akhir" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="sub_is_wajib_{{ $module->id }}" name="is_wajib" value="1" class="h-4 w-4 text-[#11A697] border-gray-300 rounded focus:ring-[#11A697]">
                                    <label for="sub_is_wajib_{{ $module->id }}" class="ml-2 text-sm text-gray-700">Status Wajib</label>
                                </div>
                                <div class="flex justify-end space-x-2 pt-2">
                                    <button type="button" @click="openSubChapterForm = null" class="px-4 py-2 text-sm bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center bg-white border border-dashed rounded-lg py-12 px-6">
                <i class='bx bx-info-circle text-5xl text-gray-400'></i>
                <p class="mt-4 text-gray-600 font-semibold">Belum ada modul yang dibuat untuk sesi ini.</p>
                <p class="text-sm text-gray-500 mt-1">Anda dapat membuat modul secara manual atau menggunakan template standar.</p>
                
                <div class="mt-6">
                    <form id="create-template-form" action="{{ route('admin_equity.comdev.modules.storeTemplate', $sesi->id) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <button type="button" 
                            onclick="confirmCreateTemplate()" 
                            class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 shadow-sm transition">
                        <i class='bx bxs-file-plus text-lg mr-2'></i> Buat Modul Standar
                    </button>
                </div>

            </div>
        @endforelse
    </div>

    {{-- Tombol & Form Tambah Modul (Manual) --}}
    <div class="mt-8" x-data="{ 
        newModuleForm: [],
        addNewKriteria() {
            this.newModuleForm.push({
                label: '',
                type: 'number',
                bobot: 0,
                keterangan: ''
            });
        },
        removeNewKriteria(index) {
            this.newModuleForm.splice(index, 1);
        }
    }">
        <button @click="openModuleForm = !openModuleForm; newModuleForm = []" class="inline-flex items-center px-5 py-2.5 bg-[#11A697] text-white rounded-lg font-semibold hover:bg-[#0e8a7c] shadow-sm transition">
            <i class='bx bxs-add-to-queue text-lg mr-2'></i> Buat Modul Baru (Manual)
        </button>
        <div x-show="openModuleForm" x-cloak x-transition class="mt-4">
             <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-gray-800 text-white">
                    <h3 class="text-xl font-semibold">Form Modul Baru</h3>
                </div>
                <form action="{{ route('admin_equity.comdev.modules.storeModule', $sesi->id) }}" method="POST" class="p-6 space-y-6"
                      x-ref="newModuleFormElement"
                      @submit.prevent="
                          const form = $refs.newModuleFormElement;
                          const existingInputs = form.querySelectorAll('input[name^=form_penilaian]');
                          existingInputs.forEach(input => input.remove());
                          
                          newModuleForm.forEach((kriteria, idx) => {
                              ['label', 'type', 'bobot', 'keterangan'].forEach(field => {
                                  const input = document.createElement('input');
                                  input.type = 'hidden';
                                  input.name = `form_penilaian[${idx}][${field}]`;
                                  input.value = kriteria[field] || '';
                                  form.appendChild(input);
                              });
                          });
                          
                          form.submit();
                      ">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="modul_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                            <input type="number" id="modul_urutan" name="urutan" placeholder="Cth: 1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="modul_nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Modul</label>
                            <input type="text" id="modul_nama" name="nama_modul" placeholder="Masukkan nama modul" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                        </div>
                    </div>
                    <div>
                        <label for="modul_deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea id="modul_deskripsi" name="deskripsi" placeholder="Jelaskan deskripsi singkat tentang modul ini" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" rows="3"></textarea>
                    </div>

                    {{-- Form Penilaian Section --}}
                    <div class="border-t pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-bold text-gray-800">Form Penilaian Reviewer</h4>
                            <button type="button" @click="addNewKriteria()" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                                <i class='bx bx-plus text-lg mr-1'></i> Tambah Kriteria
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(kriteria, index) in newModuleForm" :key="index">
                                <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <h5 class="text-sm font-semibold text-gray-700">Kriteria <span x-text="index + 1"></span></h5>
                                        <button type="button" @click="removeNewKriteria(index)" class="text-red-500 hover:text-red-700">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Label/Nama Kriteria</label>
                                            <input type="text" 
                                                   x-model="kriteria.label" 
                                                   :name="'form_penilaian[' + index + '][label]'"
                                                   class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                   placeholder="Contoh: Kesesuaian dengan Tujuan" 
                                                   required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Tipe Input</label>
                                            <select x-model="kriteria.type" 
                                                    :name="'form_penilaian[' + index + '][type]'"
                                                    class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                    required>
                                                <option value="number">Angka (Number)</option>
                                                <option value="text">Teks Singkat</option>
                                                <option value="textarea">Teks Panjang</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Bobot (%)</label>
                                            <input type="number" 
                                                   x-model="kriteria.bobot" 
                                                   :name="'form_penilaian[' + index + '][bobot]'"
                                                   class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                   placeholder="0-100" 
                                                   min="0" 
                                                   max="100">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan/Instruksi</label>
                                            <textarea x-model="kriteria.keterangan" 
                                                      :name="'form_penilaian[' + index + '][keterangan]'"
                                                      class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" 
                                                      rows="2" 
                                                      placeholder="Instruksi untuk reviewer"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="newModuleForm.length === 0" class="text-center py-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                                <i class='bx bx-info-circle text-3xl text-gray-400'></i>
                                <p class="text-sm text-gray-500 mt-2">Belum ada kriteria penilaian. Klik "Tambah Kriteria" untuk menambahkan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 border-t pt-4">
                        <button type="button" @click="openModuleForm = false; newModuleForm = []" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition">Simpan Modul</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmCreateTemplate() {
        Swal.fire({
            title: 'Buat Modul Standar?',
            html: `<p class="text-gray-600">Ini akan membuat set modul standar untuk sesi ini.</p>
                   <p class="text-sm text-blue-600 mt-2">ℹ️ Modul standar hanya dapat dibuat jika sesi belum memiliki modul.</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="bx bx-check mr-2"></i>Ya, Buat!',
            cancelButtonText: '<i class="bx bx-x mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-semibold',
                cancelButton: 'px-6 py-2.5 rounded-lg font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Membuat Modul...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                document.getElementById('create-template-form').submit();
            }
        });
    }

    function confirmDeleteModule(moduleId, moduleName) {
        Swal.fire({
            title: 'Hapus Modul?',
            html: `<p class="text-gray-600">Anda yakin ingin menghapus modul <strong>"${moduleName}"</strong>?</p>
                   <p class="text-sm text-red-600 mt-2">⚠️ Semua sub-bab di dalam modul ini juga akan terhapus!</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="bx bx-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="bx bx-x mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-semibold',
                cancelButton: 'px-6 py-2.5 rounded-lg font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                document.getElementById('delete-module-form-' + moduleId).submit();
            }
        });
    }

    function confirmDeleteSubChapter(subChapterId, subChapterName) {
        Swal.fire({
            title: 'Hapus Sub-Bab?',
            html: `<p class="text-gray-600">Anda yakin ingin menghapus sub-bab <strong>"${subChapterName}"</strong>?</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="bx bx-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="bx bx-x mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-semibold',
                cancelButton: 'px-6 py-2.5 rounded-lg font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                document.getElementById('delete-subchapter-form-' + subChapterId).submit();
            }
        });
    }

    // Show success message if redirected after delete
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#11A697',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-semibold'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-semibold'
            }
        });
    @endif
</script>
@endpush

