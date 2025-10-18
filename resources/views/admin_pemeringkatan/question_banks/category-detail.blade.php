@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'questions', isImportModalOpen: false, isImportExcelModalOpen: false }">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <div class="flex">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Bank Soal</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $questionBank->name }}</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <span class="ml-4 text-sm font-medium text-gray-700">{{ $category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <div class="flex items-center">
                    <i class="fas fa-folder text-teal-600 text-2xl mr-3"></i>
                    <div>
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $category->name }}</h2>
                        @if($category->description)
                            <p class="mt-1 text-sm text-gray-500">{{ $category->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Bank Soal
                </a>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" @click.prevent="activeTab = 'questions'" 
                   :class="{'border-teal-500 text-teal-600': activeTab === 'questions', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'questions'}" 
                   class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                   <i class="fas fa-list mr-2"></i>Daftar Soal ({{ count($category->questions) }})
                </a>
                <a href="#" @click.prevent="activeTab = 'add_question'" 
                   :class="{'border-teal-500 text-teal-600': activeTab === 'add_question', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'add_question'}" 
                   class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                   <i class="fas fa-plus mr-2"></i>Tambah Soal Baru
                </a>
                <a href="#" @click.prevent="isImportModalOpen = true" 
                   class="whitespace-nowrap border-b-2 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                   <i class="fas fa-file-word mr-2"></i>Import DOCX
                </a>
                <a href="#" @click.prevent="isImportExcelModalOpen = true" 
                   class="whitespace-nowrap border-b-2 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                   <i class="fas fa-file-excel mr-2"></i>Import Excel
                </a>
            </nav>
        </div>
    </div>

    <div class="mt-8">
        <!-- Tab Daftar Soal -->
        <div x-show="activeTab === 'questions'">
            <div class="space-y-4">
                @forelse($category->questions as $question)
                    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-base text-gray-800 font-medium">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                            </div>
                            
                            <div class="flex items-center space-x-3 ml-4">
                                <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.edit', $question->id) }}" class="text-gray-400 hover:text-blue-600" title="Edit Soal">
                                    <i class="fas fa-pencil-alt fa-sm"></i>
                                </a>
                                
                                <form id="delete-form-{{ $question->id }}" action="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.destroy', $question->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $question->id }})" class="text-gray-400 hover:text-red-600" title="Hapus Soal">
                                        <i class="fas fa-trash-alt fa-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <ul class="mt-4 space-y-2 pl-6">
                            @foreach($question->options as $index => $option)
                                <li class="flex items-center justify-between text-sm text-gray-700">
                                    <span>{{ chr(65 + $index) }}. {{ $option->text }}</span>
                                    <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                        {{ $option->points }} Poin
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada soal di kategori ini</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai tambahkan soal baru melalui tab "Tambah Soal Baru".</p>
                        <div class="mt-6">
                            <button @click="activeTab = 'add_question'" class="inline-flex items-center rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Soal
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Tambah Soal Baru -->
        <div x-show="activeTab === 'add_question'" x-cloak>
            <div class="bg-white p-6 rounded-lg shadow-lg border">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Formulir Tambah Soal Baru di Kategori: {{ $category->name }}</h3>
                <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.store', $questionBank->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="question_category_id" value="{{ $category->id }}">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="question_text" class="block text-sm font-medium text-gray-700">Teks Pertanyaan</label>
                            <textarea id="question_text" name="question_text" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Tuliskan pertanyaan di sini...">{{ old('question_text') }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Opsi Jawaban & Poin (Bobot)</label>
                            
                            @for ($i = 0; $i < 5; $i++)
                            <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-md">
                                <span class="font-semibold text-gray-500">{{ chr(65 + $i) }}.</span>
                                
                                <div class="flex-grow">
                                    <input type="text" name="options[{{ $i }}][text]" placeholder="Teks Opsi {{ chr(65 + $i) }}" required 
                                           value="{{ old('options.'.$i.'.text') }}"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                </div>
                                
                                <div class="w-40">
                                    <select name="options[{{ $i }}][points]" required 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                        <option value="" disabled selected>Pilih Poin</option>
                                        @for($p = 1; $p <= 5; $p++)
                                            <option value="{{ $p }}" {{ old('options.'.$i.'.points') == $p ? 'selected' : '' }}>{{ $p }} Poin</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            @endfor
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-200 mt-6">
                            <button type="button" @click="activeTab = 'questions'" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 mr-3">
                                Batal
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Soal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Import DOCX -->
    <div x-show="isImportModalOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>
    <div x-show="isImportModalOpen" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="isImportModalOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Import Soal dari DOCX ke Kategori: {{ $category->name }}</h3>
            </div>
            <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.import', $questionBank->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="question_category_id" value="{{ $category->id }}">
                <div class="p-6 space-y-4">
                    <div>
                        <label for="import_file_category" class="block text-sm font-medium text-gray-700">Pilih File (.docx)</label>
                        <input type="file" name="import_file" id="import_file_category" required accept=".docx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                               <i class="fas fa-info-circle text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Semua soal yang diimport akan otomatis masuk ke kategori <strong>{{ $category->name }}</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" @click="isImportModalOpen = false" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                        <i class="fas fa-upload mr-2"></i>Upload dan Proses
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Import Excel -->
    <div x-show="isImportExcelModalOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>
    <div x-show="isImportExcelModalOpen" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="isImportExcelModalOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Import Soal dari Excel ke Kategori: {{ $category->name }}</h3>
            </div>
            <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.import_excel', $questionBank->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="question_category_id" value="{{ $category->id }}">
                <div class="p-6 space-y-4">
                    <div>
                        <label for="import_file_excel_category" class="block text-sm font-medium text-gray-700">Pilih File (.xlsx atau .xls)</label>
                        <input type="file" name="import_file" id="import_file_excel_category" required accept=".xlsx,.xls" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                               <i class="fas fa-info-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Semua soal yang diimport akan otomatis masuk ke kategori <strong>{{ $category->name }}</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" @click="isImportExcelModalOpen = false" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                        <i class="fas fa-upload mr-2"></i>Upload dan Proses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(questionId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Soal yang akan dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#14b8a6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + questionId).submit();
            }
        });
    }
</script>
@endpush
@endsection
