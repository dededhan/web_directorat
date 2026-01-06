@extends('admin_pemeringkatan.index')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

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
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">Tambah Berita</h1>
                            <p class="text-blue-100 text-sm">Isi formulir untuk menambahkan berita baru</p>
                        </div>
                        <i class='bx bx-news text-5xl text-blue-100 opacity-50'></i>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.berita.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf

                    <!-- Section 1: Informasi Dasar -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            <i class='bx bx-info-circle text-xl mr-2 text-blue-600'></i>
                            Informasi Dasar
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori" 
                                        id="kategori" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="inovasi" {{ old('kategori') == 'inovasi' ? 'selected' : '' }}>Inovasi</option>
                                    <option value="pemeringkatan" {{ old('kategori') == 'pemeringkatan' ? 'selected' : '' }}>Pemeringkatan</option>
                                    <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih kategori yang sesuai</p>
                                @error('kategori')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Berita -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Berita <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal" 
                                       id="tanggal" 
                                       value="{{ old('tanggal', date('Y-m-d')) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Tanggal publikasi berita</p>
                                @error('tanggal')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Judul Berita -->
                            <div class="lg:col-span-2">
                                <label for="judul_berita" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Berita <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="judul_berita" 
                                       id="judul_berita" 
                                       value="{{ old('judul_berita') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul_berita') border-red-500 @enderror"
                                       placeholder="Masukkan judul berita"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Judul berita maksimal 200 karakter</p>
                                @error('judul_berita')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Konten Berita -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                            <i class='bx bx-text text-xl mr-2 text-green-600'></i>
                            Konten Berita
                        </h3>
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Isi Berita -->
                            <div>
                                <label for="isi_berita" class="block text-sm font-medium text-gray-700 mb-2">
                                    Isi Berita <span class="text-red-500">*</span>
                                </label>
                                <textarea name="isi_berita" 
                                          id="isi_berita" 
                                          rows="10"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('isi_berita') border-red-500 @enderror">{{ old('isi_berita') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Tulis konten berita secara lengkap dan detail</p>
                                @error('isi_berita')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Media -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-200">
                            <i class='bx bx-image text-xl mr-2 text-purple-600'></i>
                            Media
                        </h3>
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Cover Gambar -->
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Cover Gambar <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="gambar" 
                                       id="gambar" 
                                       accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gambar') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Upload gambar cover (JPG, PNG, JPEG, max 2MB)</p>
                                @error('gambar')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Additional Images -->
                            <div>
                                <label for="additional_images" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Tambahan (Opsional)
                                </label>
                                <input type="file" 
                                       name="additional_images[]" 
                                       id="additional_images" 
                                       accept="image/*"
                                       multiple
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('additional_images.*') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Upload gambar tambahan (JPG, PNG, JPEG, max 2MB per file)</p>
                                @error('additional_images.*')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.berita.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200 w-full sm:w-auto">
                            <i class='bx bx-arrow-back text-lg mr-2'></i>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto sm:ml-auto">
                            <i class='bx bx-save text-lg mr-2'></i>
                            Simpan Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let isiBeritaEditor;
        
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#isi_berita'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'undo', 'redo'
                    ]
                }
            })
            .then(editor => {
                isiBeritaEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        // Handle form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            // Sync CKEditor data to textarea
            if (isiBeritaEditor) {
                const content = isiBeritaEditor.getData();
                document.querySelector('#isi_berita').value = content;
                
                // Validate content is not empty
                if (!content || content.trim() === '' || content === '<p>&nbsp;</p>') {
                    e.preventDefault();
                    alert('Isi berita tidak boleh kosong!');
                    return false;
                }
            }
        });
    </script>
@endsection
