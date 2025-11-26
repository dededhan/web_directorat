@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Validation Errors -->
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <i class='bx bx-error-circle text-red-500 text-2xl mr-3 flex-shrink-0'></i>
                    <div class="flex-1">
                        <h3 class="text-red-800 font-semibold mb-2">Terdapat kesalahan pada input:</h3>
                        <ul class="list-disc list-inside text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">Edit Indikator Pemeringkatan</h1>
                            <p class="text-amber-100 text-sm">Perbarui informasi indikator penilaian</p>
                        </div>
                        <i class='bx bx-edit text-5xl text-amber-100 opacity-50'></i>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.indikator.update', $indikator->id) }}" method="POST" class="p-6 sm:p-8" id="editIndikatorForm">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Informasi Indikator -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-amber-200">
                            <i class='bx bx-info-circle text-xl mr-2 text-amber-600'></i>
                            Informasi Indikator
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Judul Indikator -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Indikator <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       id="judul" 
                                       value="{{ old('judul', $indikator->judul) }}"
                                       maxlength="200"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                                       placeholder="Masukkan judul indikator (maksimal 200 karakter)"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Judul akan ditampilkan di sidebar navigasi</p>
                                @error('judul')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi Indikator -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Indikator <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="deskripsi" 
                                    id="deskripsi" 
                                    rows="8"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                                    placeholder="Tuliskan deskripsi indikator secara lengkap dan detail">{{ old('deskripsi', $indikator->deskripsi) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Gunakan editor untuk format teks yang lebih baik</p>
                                @error('deskripsi')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.indikator.index') }}" 
                           class="px-6 py-2.5 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors duration-200 flex items-center">
                            <i class='bx bx-x text-lg mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center shadow-md hover:shadow-lg">
                            <i class='bx bx-save text-lg mr-2'></i>
                            Update Indikator
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CKEditor Scripts -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
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

                    fetch('{{ route('admin_pemeringkatan.indikator.upload') }}', {
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

        // Initialize CKEditor
        let editorInstance;
        ClassicEditor.create(document.querySelector('#deskripsi'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'alignment', 'fontColor', 'fontBackgroundColor', '|',
                    'blockQuote', 'imageUpload', '|',
                    'insertTable', 'undo', 'redo'
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
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error('CKEditor error:', error);
        });

        // Update textarea with CKEditor data before form submission
        document.getElementById('editIndikatorForm').addEventListener('submit', function(e) {
            if (editorInstance) {
                const editorData = editorInstance.getData();
                
                // Validate that editor has content
                if (!editorData || editorData.trim() === '' || editorData === '<p>&nbsp;</p>' || editorData === '<p></p>') {
                    e.preventDefault();
                    alert('Deskripsi tidak boleh kosong!');
                    return false;
                }
                
                // Update the textarea
                document.getElementById('deskripsi').value = editorData;
            } else {
                e.preventDefault();
                alert('Editor belum siap. Silakan tunggu sebentar dan coba lagi.');
                return false;
            }
        });
    </script>
@endsection
