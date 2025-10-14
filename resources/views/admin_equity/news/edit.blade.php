@extends('admin_equity.index')

@section('title', 'Edit Berita EQUITY')

@section('content')
<div class="px-6 py-4">
    <div class="mb-6">
        <a href="{{ route('admin_equity.news.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <i class='bx bx-arrow-back text-xl mr-2'></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Edit Berita & Informasi Terkini</h2>
            <p class="text-yellow-100 text-sm mt-1">Perbarui informasi berita di bawah ini</p>
        </div>
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <div class="flex items-start">
                        <i class='bx bx-error text-2xl mr-3 flex-shrink-0'></i>
                        <div>
                            <p class="font-semibold">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin_equity.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('category') border-red-500 @enderror" 
                               id="category" 
                               name="category" 
                               value="{{ old('category', $news->category) }}" 
                               placeholder="Contoh: PROFIL PPID, INFORMASI, GCG, REKRUTMEN"
                               required>
                        @error('category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Nama kategori dalam huruf kapital</p>
                    </div>

                    <div>
                        <label for="gradient_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Warna Gradient <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('gradient_color') border-red-500 @enderror" 
                                id="gradient_color" 
                                name="gradient_color" 
                                required>
                            @foreach($gradientColors as $key => $label)
                                <option value="{{ $key }}" {{ old('gradient_color', $news->gradient_color) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('gradient_color')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('title') border-red-500 @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $news->title) }}" 
                           maxlength="200"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('description') border-red-500 @enderror" 
                              id="description" 
                              name="description" 
                              rows="8">{{ old('description', $news->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Anda bisa menggunakan HTML sederhana seperti &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, dll.</p>
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    <div class="mb-3 border border-gray-200 rounded-lg p-3 inline-block">
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}" 
                             class="rounded shadow-sm"
                             style="max-width: 300px; max-height: 200px;">
                    </div>
                    <input type="file" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('image') border-red-500 @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti gambar. Format: JPG, PNG, GIF. Maksimal 2MB</p>
                    <div id="imagePreview" class="mt-3"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('order') border-red-500 @enderror" 
                               id="order" 
                               name="order" 
                               value="{{ old('order', $news->order) }}" 
                               min="0">
                        @error('order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Angka lebih kecil akan tampil lebih dulu</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex items-center mt-3">
                            <input type="checkbox" 
                                   class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500" 
                                   id="is_active" 
                                   name="is_active" 
                                   {{ old('is_active', $news->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-3 text-sm text-gray-700">
                                Aktif (tampilkan di halaman depan)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                        <i class='bx bx-save text-xl mr-2'></i>
                        Update
                    </button>
                    <a href="{{ route('admin_equity.news.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-150">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.mce.com/1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
// Initialize TinyMCE
tinymce.init({
    selector: '#description',
    height: 300,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
        'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
    valid_elements: 'p,br,strong,em,u,h1,h2,h3,h4,h5,h6,ul,ol,li,a[href|target],blockquote',
    valid_children: '+body[style]',
    branding: false
});

// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = 
                '<div class="border border-gray-200 rounded-lg p-2 inline-block"><img src="' + e.target.result + '" class="rounded shadow-sm" style="max-width: 300px; max-height: 200px;"></div>';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
