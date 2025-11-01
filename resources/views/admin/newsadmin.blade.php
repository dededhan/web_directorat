@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('contentadmin')

<style>
    /* Custom scrollbar untuk table */
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #14b8a6;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #0d9488;
    }
</style>

<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6 lg:p-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Kelola Berita</h1>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="#" class="hover:text-teal-600 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-teal-600 font-medium">Berita</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-5 py-4 rounded-t-xl">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-newspaper"></i>
                Input Berita
            </h2>
        </div>

        <div class="p-5 sm:p-6">
            <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 mb-5 flex items-start gap-3">
                <i class="fas fa-language text-teal-600 text-xl mt-0.5 flex-shrink-0"></i>
                <div class="flex-1">
                    <h4 class="font-semibold text-teal-900 mb-1">Fitur Terjemahan Otomatis Aktif!</h4>
                    <p class="text-sm text-teal-800">
                        Cukup masukkan judul dan isi berita dalam <strong>Bahasa Indonesia</strong>. 
                        Sistem akan otomatis menerjemahkan ke <strong>Bahasa Inggris</strong>.
                    </p>
                </div>
                <button type="button" class="text-teal-600 hover:text-teal-800" onclick="this.closest('.bg-teal-50').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-900 mb-2">Terjadi Kesalahan!</h4>
                        <ul class="list-disc list-inside text-sm text-red-800 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="text-red-600 hover:text-red-800" onclick="this.closest('.bg-red-50').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-green-900 mb-1">Berhasil!</h4>
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="text-green-600 hover:text-green-800" onclick="this.closest('.bg-green-50').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-times-circle text-red-600 text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-900 mb-1">Gagal!</h4>
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="text-red-600 hover:text-red-800" onclick="this.closest('.bg-red-50').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route($routePrefix . '.news.store') }}" enctype="multipart/form-data" id="beritaForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="category" 
                                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('kategori') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="inovasi" {{ old('kategori') == 'inovasi' ? 'selected' : '' }}>Inovasi</option>
                            <option value="pemeringkatan" {{ old('kategori') == 'pemeringkatan' ? 'selected' : '' }}>Pemeringkatan</option>
                            <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="fakultas" {{ old('kategori') == 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                            <option value="prodi" {{ old('kategori') == 'prodi' ? 'selected' : '' }}>Prodi</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                               class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('tanggal') border-red-500 @enderror">
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Berita (Bahasa Indonesia) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul_berita" id="judul_berita" value="{{ old('judul_berita') }}"
                           placeholder="Masukkan judul berita..."
                           class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('judul_berita') border-red-500 @enderror">
                    @error('judul_berita')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-xs text-gray-600 flex items-center gap-1">
                        <i class="fas fa-info-circle text-teal-500"></i>
                        Maksimal 200 karakter. Terjemahan otomatis akan dibuat.
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Isi Berita (Bahasa Indonesia) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi_berita" id="isi_berita" rows="6"
                              class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error('isi_berita') border-red-500 @enderror">{{ old('isi_berita') }}</textarea>
                    @error('isi_berita')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-xs text-gray-600 flex items-center gap-1">
                        <i class="fas fa-info-circle text-teal-500"></i>
                        Tuliskan isi berita secara lengkap. Terjemahan otomatis akan dibuat.
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Cover Gambar <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden">
                        <label for="gambar" 
                               class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center py-4">
                                <i class="fas fa-cloud-upload-alt text-4xl text-teal-500 mb-2"></i>
                                <p class="text-sm text-gray-600"><span class="font-semibold text-teal-600">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG atau JPEG (Max. 2MB)</p>
                            </div>
                        </label>
                    </div>
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Tambahan (Opsional)
                    </label>
                    <div class="relative">
                        <input type="file" name="additional_images[]" id="additional_images" multiple accept="image/*" class="hidden">
                        <label for="additional_images" 
                               class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center py-4">
                                <i class="fas fa-images text-4xl text-teal-500 mb-2"></i>
                                <p class="text-sm text-gray-600"><span class="font-semibold text-teal-600">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-gray-500 mt-1">Multiple images - JPG, PNG (Max. 2MB each)</p>
                            </div>
                        </label>
                    </div>
                    @error('additional_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" id="submitBerita"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition-all shadow-md hover:shadow-lg">
                        <i class="fas fa-save"></i>
                        Simpan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-5 py-4 rounded-t-xl">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-list"></i>
                Daftar Berita
            </h2>
        </div>

        <div class="overflow-hidden">
            <table class="w-full table-fixed" id="berita-table">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="px-2 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-12">No</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-32">Ditambahkan Oleh</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Kategori</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Tanggal</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Berita</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Isi</th>
                        <th class="px-2 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-20">Cover</th>
                        <th class="px-2 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-40">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($beritas as $index => $berita)
                        <tr class="hover:bg-teal-50 transition-colors">
                            <td class="px-2 py-4 text-sm text-gray-900 font-medium text-center">{{ $index + 1 }}</td>
                            <td class="px-2 py-4 text-sm text-gray-700 truncate" title="{{ $berita->user ? $berita->user->name : 'N/A' }}">{{ $berita->user ? $berita->user->name : 'N/A' }}</td>
                            <td class="px-2 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                    {{ [
                                        'inovasi' => 'bg-blue-100 text-blue-700',
                                        'pemeringkatan' => 'bg-green-100 text-green-700',
                                        'umum' => 'bg-purple-100 text-purple-700',
                                        'fakultas' => 'bg-yellow-100 text-yellow-700',
                                        'prodi' => 'bg-red-100 text-red-700'
                                    ][$berita->kategori] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($berita->kategori) }}
                                </span>
                            </td>
                            <td class="px-2 py-4 text-xs text-gray-700">{{ $berita->tanggal }}</td>
                            <td class="px-2 py-4 text-sm text-gray-900 font-medium truncate" title="{{ $berita->judul }}">{{ $berita->judul }}</td>
                            <td class="px-2 py-4 text-sm text-gray-600 truncate" title="{{ strip_tags($berita->isi) }}">{{ Str::limit(strip_tags($berita->isi), 80) }}</td>
                            <td class="px-2 py-4 text-center">
                                <button class="px-3 py-2 bg-teal-500 text-white text-xs font-medium rounded hover:bg-teal-600 transition-all view-image"
                                        data-image="{{ asset('storage/' . $berita->gambar) }}"
                                        data-title="{{ $berita->judul }}"
                                        title="Lihat Gambar">
                                    <i class="fas fa-image"></i>
                                </button>
                            </td>
                            <td class="px-2 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="button" 
                                            class="px-3 py-2 bg-orange-500 text-white text-xs font-medium rounded hover:bg-orange-600 transition-all edit-berita"
                                            data-id="{{ $berita->id }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" action="{{ route($routePrefix . '.news.destroy', $berita->id) }}" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="px-3 py-2 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600 transition-all delete-btn" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-sm font-medium">Belum ada data berita</p>
                                    <p class="text-xs text-gray-400 mt-1">Tambahkan berita baru menggunakan form di atas</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-xl border-0 shadow-2xl">
            <div class="modal-header bg-gradient-to-r from-teal-500 to-teal-600 rounded-t-xl border-0">
                <h5 class="modal-title text-white font-bold" id="imageModalLabel">Gambar Berita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center bg-gray-50">
                <img id="modalImage" src="" class="w-full h-auto rounded-lg shadow-md" alt="Gambar Berita">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-xl border-0 shadow-2xl">
            <div class="modal-header bg-gradient-to-r from-teal-500 to-teal-600 rounded-t-xl border-0">
                <h5 class="modal-title text-white font-bold" id="editBeritaModalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Berita
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 bg-gray-50">
                <form id="editBeritaForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" id="edit_kategori" 
                                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="inovasi">Inovasi</option>
                                <option value="pemeringkatan">Pemeringkatan</option>
                                <option value="umum">Umum</option>
                                <option value="fakultas">Fakultas</option>
                                <option value="prodi">Prodi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                            <input type="date" name="tanggal" id="edit_tanggal" 
                                   class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita</label>
                        <input type="text" name="judul_berita" id="edit_judul_berita" 
                               class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita</label>
                        <textarea name="isi_berita" id="edit_isi_berita" rows="6"
                                  class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Baru (opsional)</label>
                        <input type="file" name="gambar" id="edit_gambar" accept="image/*"
                               class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <div class="mt-3 p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Gambar saat ini:</p>
                            <img id="current_image" src="" class="max-h-48 rounded-lg shadow-sm mx-auto" alt="Current Image">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-gray-100 border-0 rounded-b-xl">
                <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md" id="saveEditBerita">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const appConfig = {
        csrfToken: '{{ csrf_token() }}',
        uploadUrl: '{{ route($routePrefix . '.news.upload') }}',
        routePrefix: '{{ $routePrefix }}'
    };
</script>

<script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);
                data.append('_token', '{{ csrf_token() }}');

                fetch('{{ route($routePrefix . '.news.upload') }}', {
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

    ClassicEditor
        .create(document.querySelector('#isi_berita'), {
            licenseKey: 'GPL',
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'subscript', 'superscript', '|',
                    'indent', 'outdent', '|',
                    'bulletedList', 'numberedList', '|',
                    'imageUpload', 'mediaEmbed', 'link', '|',
                    'blockQuote', 'insertTable', 'codeBlock', 'htmlEmbed', 'horizontalLine', '|',
                    'specialCharacters', 'emoji', '|',
                    'undo', 'redo', 'findAndReplace', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'toggleImageCaption',
                    'imageStyle:inline',
                    'imageStyle:block', 
                    'imageStyle:side',
                    'linkImage'
                ],
                styles: [
                    'full',
                    'side',
                    'alignLeft',
                    'alignCenter',
                    'alignRight'
                ],
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            link: {
                defaultProtocol: 'https://',
                decorators: {
                    openInNewTab: {
                        mode: 'manual',
                        label: 'Open in a new tab',
                        attributes: {
                            target: '_blank',
                            rel: 'noopener noreferrer'
                        }
                    }
                }
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
            fontColor: {
                colors: [
                    { color: 'hsl(0, 0%, 0%)', label: 'Black' },
                    { color: 'hsl(0, 0%, 30%)', label: 'Dim grey' },
                    { color: 'hsl(0, 0%, 60%)', label: 'Grey' },
                    { color: 'hsl(0, 0%, 90%)', label: 'Light grey' },
                    { color: 'hsl(0, 0%, 100%)', label: 'White' },
                    { color: 'hsl(0, 75%, 60%)', label: 'Red' },
                    { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                    { color: 'hsl(60, 75%, 60%)', label: 'Yellow' },
                    { color: 'hsl(90, 75%, 60%)', label: 'Light green' },
                    { color: 'hsl(120, 75%, 60%)', label: 'Green' },
                    { color: 'hsl(150, 75%, 60%)', label: 'Aquamarine' },
                    { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                    { color: 'hsl(210, 75%, 60%)', label: 'Light blue' },
                    { color: 'hsl(240, 75%, 60%)', label: 'Blue' },
                    { color: 'hsl(270, 75%, 60%)', label: 'Purple' }
                ]
            },
            fontBackgroundColor: {
                colors: [
                    { color: 'hsl(0, 0%, 0%)', label: 'Black' },
                    { color: 'hsl(0, 0%, 30%)', label: 'Dim grey' },
                    { color: 'hsl(0, 0%, 60%)', label: 'Grey' },
                    { color: 'hsl(0, 0%, 90%)', label: 'Light grey' },
                    { color: 'hsl(0, 0%, 100%)', label: 'White' },
                    { color: 'hsl(0, 75%, 60%)', label: 'Red' },
                    { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                    { color: 'hsl(60, 75%, 60%)', label: 'Yellow' },
                    { color: 'hsl(90, 75%, 60%)', label: 'Light green' },
                    { color: 'hsl(120, 75%, 60%)', label: 'Green' },
                    { color: 'hsl(150, 75%, 60%)', label: 'Aquamarine' },
                    { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                    { color: 'hsl(210, 75%, 60%)', label: 'Light blue' },
                    { color: 'hsl(240, 75%, 60%)', label: 'Blue' },
                    { color: 'hsl(270, 75%, 60%)', label: 'Purple' }
                ]
            },
            htmlEmbed: {
                showPreviews: true
            },
            mention: {
                feeds: [
                    {
                        marker: '@',
                        feed: ['@alice', '@bob', '@charlie']
                    }
                ]
            },
            placeholder: 'Type or paste your content here...',
            typing: {
                transformations: {
                    include: [
                        'quotes',
                        'typography',
                        'symbols',
                        'mathematical',
                        'arrows'
                    ]
                }
            },
            language: 'en'
        })
        .then(editor => {
            console.log('Editor initialized successfully', editor);
            window.editor = editor;
        })
        .catch(error => {
            console.error('Error initializing editor:', error);
        });
     
    let editBeritaEditor;
    ClassicEditor
        .create(document.querySelector('#edit_isi_berita'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'imageUpload', 'blockQuote', 'undo', 'redo'
                ]
            },
            image: {
                toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
            }
        })
        .then(editor => {
            editBeritaEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    document.addEventListener('DOMContentLoaded', function() {
        const beritaForm = document.getElementById('beritaForm');
        if (beritaForm) {
            beritaForm.addEventListener('submit', function(e) {
                if (window.editor) {
                    const editorData = window.editor.getData();
                    document.getElementById('isi_berita').value = editorData;
                    console.log('CKEditor data synced:', editorData.substring(0, 100));
                } else {
                    console.warn('CKEditor instance not found');
                }
            });
        }

        function showSuccessAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#14b8a6',
                confirmButtonText: 'OK'
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                title: 'Gagal!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#14b8a6',
                confirmButtonText: 'OK'
            });
        }

        function showConfirmationDialog(message, callback) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#14b8a6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        document.querySelectorAll('.view-image').forEach(button => {
            button.addEventListener('click', function() {
                const imageUrl = this.dataset.image;
                const title = this.dataset.title;

                document.getElementById('imageModalLabel').textContent = title;
                document.getElementById('modalImage').src = imageUrl;

                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                imageModal.show();
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                showConfirmationDialog('Apakah Anda yakin ingin menghapus berita ini?', () => {
                    form.submit();
                });
            });
        });

        document.querySelectorAll('.edit-berita').forEach(button => {
            button.addEventListener('click', function() {
                const beritaId = this.dataset.id;
                const routePrefix = '{{ $routePrefix }}';
                const routePath = routePrefix.replace('.', '/');

                fetch(`/${routePath}/berita/${beritaId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('edit_kategori').value = data.kategori;
                        document.getElementById('edit_tanggal').value = data.tanggal;
                        document.getElementById('edit_judul_berita').value = data.judul;

                        if (editBeritaEditor) {
                            editBeritaEditor.setData(data.isi);
                        }

                        const currentImage = document.getElementById('current_image');
                        currentImage.src = `/storage/${data.gambar}`;

                        const form = document.getElementById('editBeritaForm');
                        form.action = `/${routePath}/berita/${beritaId}`;

                        const editModal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
                        editModal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching berita details:', error);
                        showErrorAlert('Gagal mengambil data berita.');
                    });
            });
        });

        document.getElementById('saveEditBerita').addEventListener('click', function() {
            const editorData = editBeritaEditor.getData();
            document.getElementById('edit_isi_berita').value = editorData;

            const form = document.getElementById('editBeritaForm');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modalElement = document.getElementById('editBeritaModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();

                        showSuccessAlert(data.message || 'Berita berhasil diperbarui!');

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                    }
                })
                .catch(error => {
                    console.error('Error saving berita:', error);
                    showErrorAlert('Gagal menyimpan perubahan.');
                });
        });

        // File upload preview
        const gambarInput = document.getElementById('gambar');
        const additionalImagesInput = document.getElementById('additional_images');

        if (gambarInput) {
            gambarInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name;
                if (fileName) {
                    const label = this.nextElementSibling;
                    const textElement = label.querySelector('p.text-sm');
                    textElement.innerHTML = `<span class="font-semibold text-teal-600">File dipilih:</span> ${fileName}`;
                }
            });
        }

        if (additionalImagesInput) {
            additionalImagesInput.addEventListener('change', function(e) {
                const fileCount = e.target.files.length;
                if (fileCount > 0) {
                    const label = this.nextElementSibling;
                    const textElement = label.querySelector('p.text-sm');
                    textElement.innerHTML = `<span class="font-semibold text-teal-600">${fileCount} file dipilih</span>`;
                }
            });
        }
    });
</script>

@endsection