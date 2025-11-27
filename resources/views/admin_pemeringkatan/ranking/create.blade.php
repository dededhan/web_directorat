@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Tambah Ranking Pemeringkatan</h1>
                    <a href="{{ route('admin_pemeringkatan.ranking.index') }}"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-md w-full sm:w-auto">
                        <i class='bx bx-arrow-back text-xl mr-2'></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-red-500 text-2xl mr-3 flex-shrink-0'></i>
                        <div class="flex-1">
                            <h3 class="text-red-800 font-medium mb-2">Terdapat kesalahan pada form:</h3>
                            <ul class="list-disc list-inside text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class='bx bx-plus-circle text-2xl mr-3'></i>
                        Form Tambah Ranking Baru
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Lengkapi semua informasi ranking pemeringkatan</p>
                </div>

                <!-- Form Content -->
                <form action="{{ route('admin_pemeringkatan.ranking.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf

                    <!-- Section: Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">
                            Informasi Dasar
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Judul -->
                            <div class="lg:col-span-2">
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                                    Judul Ranking <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                                    placeholder="Contoh: QS World University Rankings 2024">
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    <i class='bx bx-info-circle'></i> Masukkan nama lengkap ranking (maksimal 200 karakter)
                                </p>
                            </div>

                            <!-- Score Ranking -->
                            <div>
                                <label for="score_ranking" class="block text-sm font-medium text-gray-700 mb-1">
                                    Skor Ranking <span class="text-gray-400 text-xs">(Opsional)</span>
                                </label>
                                <input type="text" name="score_ranking" id="score_ranking" value="{{ old('score_ranking') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('score_ranking') border-red-500 @enderror"
                                    placeholder="Contoh: 85.5 atau #201-250">
                                @error('score_ranking')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    <i class='bx bx-info-circle'></i> Skor atau peringkat yang diperoleh (maksimal 50 karakter)
                                </p>
                            </div>

                            <!-- Logo Upload -->
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">
                                    Logo Ranking <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="gambar" id="gambar" accept="image/*" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gambar') border-red-500 @enderror"
                                    onchange="previewImage(event)">
                                @error('gambar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    <i class='bx bx-info-circle'></i> Format: JPG, PNG, JPEG. Maksimal 2MB
                                </p>
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3 hidden">
                                    <img id="preview" src="" alt="Preview" class="max-h-32 rounded-lg shadow-md">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">
                            Deskripsi Ranking
                        </h3>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                                Deskripsi Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="8"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror hidden">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                <i class='bx bx-info-circle'></i> Gunakan editor untuk menulis deskripsi lengkap ranking. Anda dapat menambahkan gambar, tabel, dan format teks lainnya.
                            </p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.ranking.index') }}"
                            class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200 w-full sm:w-auto">
                            <i class='bx bx-x text-xl mr-2'></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg w-full sm:w-auto">
                            <i class='bx bx-save text-xl mr-2'></i>
                            Simpan Ranking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Image preview function
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                const previewContainer = document.getElementById('imagePreview');
                preview.src = reader.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Custom upload adapter for CKEditor
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('admin_pemeringkatan.ranking.upload') }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.error) {
                            return reject(result.error.message);
                        }
                        resolve({
                            default: result.url
                        });
                    })
                    .catch(error => {
                        reject('Upload failed: ' + error.message);
                    });
                }));
            }

            abort() {
                return Promise.reject();
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        // CKEditor configuration
        const editorConfig = {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'alignment', 'fontColor', 'fontBackgroundColor', '|',
                    'imageUpload', 'imageResize', 'blockQuote', '|',
                    'insertTable', 'undo', 'redo'
                ]
            },
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side',
                    'toggleImageCaption', 'imageResize:25', 'imageResize:50', 'imageResize:75', 'imageResize:original'
                ],
                resizeOptions: [
                    { name: 'imageResize:original', label: 'Original', value: null },
                    { name: 'imageResize:25', label: '25%', value: '25' },
                    { name: 'imageResize:50', label: '50%', value: '50' },
                    { name: 'imageResize:75', label: '75%', value: '75' }
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells',
                    'tableProperties', 'tableCellProperties'
                ]
            },
            alignment: {
                options: ['left', 'right', 'center', 'justify']
            }
        };

        // Initialize CKEditor
        let editor;
        ClassicEditor
            .create(document.querySelector('#deskripsi'), editorConfig)
            .then(newEditor => {
                editor = newEditor;

                // Add validation on form submit
                const form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    const editorData = editor.getData().trim();
                    if (!editorData || editorData === '<p>&nbsp;</p>' || editorData === '') {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Deskripsi ranking wajib diisi',
                            icon: 'warning',
                            confirmButtonColor: '#3b82f6',
                            confirmButtonText: 'OK'
                        });
                        return false;
                    }
                    // Sync editor data to hidden textarea
                    document.querySelector('#deskripsi').value = editorData;
                });
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>
@endsection
