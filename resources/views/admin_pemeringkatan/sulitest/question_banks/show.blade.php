@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
    activeTab: 'questions', 
    isImportModalOpen: false, 
    isImportExcelModalOpen: false,
    isCategoryModalOpen: false,
    isEditCategoryModalOpen: false,
    editingCategory: null
}">
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
            </ol>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $questionBank->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $questionBank->description }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="border-b border-gray-200">
            <div class="flex justify-between items-end">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a href="#" @click.prevent="activeTab = 'categories'" 
                       :class="{'border-teal-500 text-teal-600': activeTab === 'categories', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'categories'}" 
                       class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                       <i class="fas fa-folder mr-2"></i>Kategori Soal ({{ count($questionBank->categories) }})
                    </a>
                    <a href="#" @click.prevent="activeTab = 'questions'" 
                       :class="{'border-teal-500 text-teal-600': activeTab === 'questions', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'questions'}" 
                       class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                       Semua Soal ({{ count($questionBank->questions) }})
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
                <div class="flex items-center space-x-2 mb-2">
                    <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.download_template') }}" class="inline-flex items-center px-3 py-2 border border-teal-300 shadow-sm text-sm leading-4 font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <i class="fas fa-download mr-2"></i>
                        Download Template Excel
                    </a>
                    @if(count($questionBank->questions) > 0)
                    <button @click="confirmClearAll()" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Hapus Semua Soal
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div x-show="activeTab === 'categories'" x-cloak>
            <div class="mb-6">
                <button @click="isCategoryModalOpen = true" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">
                    <i class="fas fa-plus mr-2"></i>Buat Kategori Baru
                </button>
            </div>

            <div class="space-y-4">
                @forelse($questionBank->categories as $category)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
                        <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.categories.show', $category->id) }}" class="block p-5 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-folder text-teal-600 text-xl mr-3"></i>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h4>
                                            @if($category->description)
                                                <p class="text-sm text-gray-600 mt-1">{{ $category->description }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-2">
                                                <i class="fas fa-question-circle mr-1"></i>{{ $category->questions->count() }} Soal
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    <button @click.prevent="editingCategory = {{ $category->id }}; isEditCategoryModalOpen = true" class="text-gray-400 hover:text-blue-600" title="Edit Kategori">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Soal dalam kategori ini akan tetap ada.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" @click.prevent="$event.target.closest('form').submit()" class="text-gray-400 hover:text-red-600" title="Hapus Kategori">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
                        <i class="fas fa-folder-open fa-3x text-gray-400"></i>
                        <h3 class="mt-4 text-sm font-semibold text-gray-900">Belum ada kategori</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat kategori untuk mengorganisir soal Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="activeTab === 'questions'">
            @include('admin_pemeringkatan.sulitest.question_banks._question-list', ['questionBank' => $questionBank])
        </div>
    </div>
    
    <!-- Modal untuk Import Soal -->
    <div x-show="isImportModalOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>
    <div x-show="isImportModalOpen" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="isImportModalOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Import Soal dari DOCX</h3>
            </div>
            <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.import', $questionBank->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="import_category_docx" class="block text-sm font-medium text-gray-700">Kategori (Opsional)</label>
                        <select name="question_category_id" id="import_category_docx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            <option value="">-- Tanpa Kategori --</option>
                            @foreach($questionBank->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Jika dipilih, semua soal akan masuk ke kategori ini</p>
                    </div>
                    <div>
                        <label for="import_file" class="block text-sm font-medium text-gray-700">Pilih File (.docx)</label>
                        <input type="file" name="import_file" id="import_file" required accept=".docx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                               <i class="fas fa-info-circle text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Pastikan format file DOCX Anda sesuai dengan template. Setiap soal harus dipisahkan oleh satu baris kosong.
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
                <h3 class="text-lg font-medium text-gray-900">Import Soal dari Excel</h3>
            </div>
            <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.import_excel', $questionBank->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="import_category_excel" class="block text-sm font-medium text-gray-700">Kategori (Opsional)</label>
                        <select name="question_category_id" id="import_category_excel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            <option value="">-- Tanpa Kategori --</option>
                            @foreach($questionBank->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Jika dipilih, semua soal akan masuk ke kategori ini</p>
                    </div>
                    <div>
                        <label for="import_file_excel" class="block text-sm font-medium text-gray-700">Pilih File (.xlsx atau .xls)</label>
                        <input type="file" name="import_file" id="import_file_excel" required accept=".xlsx,.xls" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                               <i class="fas fa-info-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <strong>Format Excel:</strong><br>
                                    Kolom: Nomor | Pertanyaan | Opsi A | Skor A | Opsi B | Skor B | ... | Opsi E | Skor E<br>
                                    <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.download_template') }}" class="underline font-semibold">Download template Excel</a> untuk contoh format.
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

    <!-- Modal untuk Buat Kategori Baru -->
    <div x-show="isCategoryModalOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>
    <div x-show="isCategoryModalOpen" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="isCategoryModalOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Buat Kategori Soal Baru</h3>
            </div>
            <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.categories.store', $questionBank->id) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="name" id="category_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Contoh: Pengetahuan Umum">
                    </div>
                    <div>
                        <label for="category_description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                        <textarea name="description" id="category_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Deskripsi singkat mengenai kategori ini..."></textarea>
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" @click="isCategoryModalOpen = false" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Edit Kategori -->
    @foreach($questionBank->categories as $category)
    <div x-show="isEditCategoryModalOpen && editingCategory === {{ $category->id }}" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>
    <div x-show="isEditCategoryModalOpen && editingCategory === {{ $category->id }}" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="isEditCategoryModalOpen = false; editingCategory = null" class="bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Edit Kategori</h3>
            </div>
            <form action="{{ route('admin_pemeringkatan.sulitest_question_banks.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4">
                    <div>
                        <label for="edit_category_name_{{ $category->id }}" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="name" id="edit_category_name_{{ $category->id }}" value="{{ $category->name }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="edit_category_description_{{ $category->id }}" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                        <textarea name="description" id="edit_category_description_{{ $category->id }}" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">{{ $category->description }}</textarea>
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" @click="isEditCategoryModalOpen = false; editingCategory = null" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
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

    function confirmClearAll() {
        Swal.fire({
            title: 'Hapus Semua Soal?',
            html: '<p class="text-gray-600 mb-2">Tindakan ini akan menghapus <strong>SEMUA soal</strong> di bank soal ini.</p><p class="text-red-600 font-semibold">Data yang terhapus tidak dapat dikembalikan!</p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Semua!',
            cancelButtonText: 'Batal',
            input: 'checkbox',
            inputPlaceholder: 'Saya memahami konsekuensinya',
            inputValidator: (result) => {
                return !result && 'Anda harus mencentang untuk melanjutkan'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin_pemeringkatan.sulitest_question_banks.clear_all", $questionBank->id) }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection
