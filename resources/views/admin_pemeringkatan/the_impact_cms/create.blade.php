@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')

<div class="mb-6">
    <a href="{{ route('admin_pemeringkatan.the-impact-cms.editor', $sdg->id) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Editor
    </a>
    <h1 class="text-3xl font-bold text-gray-800">
        <span class="inline-block w-12 h-12 rounded-full text-white flex items-center justify-center text-xl font-bold mr-3" 
              style="background-color: {{ $sdg->color }};">{{ $sdg->number }}</span>
        {{ $parentContent ? 'Tambah Sub Konten' : 'Tambah Konten Root' }}
    </h1>
    <p class="text-gray-600 mt-1 ml-14">
        SDG {{ $sdg->number }}: {{ $sdg->title }}
        @if($parentContent)
            <span class="text-blue-600 ml-2">→ Parent: {{ $parentContent->point_number }} {{ $parentContent->title }}</span>
        @endif
    </p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin_pemeringkatan.the-impact-cms.content.store', $sdg->id) }}" method="POST">
        @csrf
        
        @if($parentContent)
            <input type="hidden" name="parent_id" value="{{ $parentContent->id }}">
        @endif

        <div class="space-y-6">
            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipe Konten -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Konten <span class="text-red-500">*</span>
                </label>
                <select name="content_type" 
                        id="content_type"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="link" {{ old('content_type') == 'link' ? 'selected' : '' }}>Link</option>
                </select>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun
                </label>
                <select name="year" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Semua Tahun --</option>
                    @for($y = 2025; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <p class="mt-1 text-sm text-gray-500">Opsional: Pilih tahun untuk grouping konten berdasarkan tahun</p>
            </div>

            <!-- Konten Text -->
            <div id="text-content-field" style="display: {{ old('content_type', 'text') == 'text' ? 'block' : 'none' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konten Text
                </label>
                <textarea name="content" 
                          rows="8"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan deskripsi atau penjelasan konten</p>
            </div>

            <!-- URL Link -->
            <div id="link-content-field" style="display: {{ old('content_type') == 'link' ? 'block' : 'none' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    URL Link
                </label>
                <input type="url" 
                       name="link_url" 
                       value="{{ old('link_url') }}"
                       placeholder="https://example.com"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('link_url') border-red-500 @enderror">
                @error('link_url')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan URL lengkap dengan https://</p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin_pemeringkatan.the-impact-cms.editor', $sdg->id) }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i> Simpan Konten
            </button>
        </div>
    </form>
</div>

<script>
    // Toggle antara text dan link field
    document.getElementById('content_type').addEventListener('change', function() {
        const textField = document.getElementById('text-content-field');
        const linkField = document.getElementById('link-content-field');
        
        if (this.value === 'text') {
            textField.style.display = 'block';
            linkField.style.display = 'none';
        } else {
            textField.style.display = 'none';
            linkField.style.display = 'block';
        }
    });
</script>

@endsection
