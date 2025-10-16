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
                    <a href="#" @click.prevent="activeTab = 'questions'" 
                       :class="{'border-teal-500 text-teal-600': activeTab === 'questions', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'questions'}" 
                       class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                       Daftar Soal ({{ count($questionBank->questions) }})
                    </a>
                    <a href="#" @click.prevent="activeTab = 'add_question'" 
                       :class="{'border-teal-500 text-teal-600': activeTab === 'add_question', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'add_question'}" 
                       class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                       Tambah Soal Baru
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
        <div x-show="activeTab === 'add_question'" x-cloak>
            @include('admin_pemeringkatan.question_banks._question-form', ['questionBank' => $questionBank])
        </div>
        <div x-show="activeTab === 'questions'">
            @include('admin_pemeringkatan.question_banks._question-list', ['questionBank' => $questionBank])
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
