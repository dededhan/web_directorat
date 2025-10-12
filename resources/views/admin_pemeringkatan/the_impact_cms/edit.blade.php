@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')

<div class="mb-6">
    <a href="{{ route('admin_pemeringkatan.the-impact-cms.editor', $sdg->id) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Editor
    </a>
    <h1 class="text-3xl font-bold text-gray-800">
        <span class="inline-block w-12 h-12 rounded-full text-white flex items-center justify-center text-xl font-bold mr-3" 
              style="background-color: {{ $sdg->color }};">{{ $sdg->number }}</span>
        Edit Konten
    </h1>
    <p class="text-gray-600 mt-1 ml-14">
        {{ $content->point_number }} {{ $content->title }}
    </p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin_pemeringkatan.the-impact-cms.content.update', $content->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Point Number (Read Only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Point Number
                </label>
                <input type="text" 
                       value="{{ $content->point_number }}"
                       disabled
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                <p class="mt-1 text-sm text-gray-500">Numbering otomatis, tidak bisa diubah</p>
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $content->title) }}"
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
                    <option value="text" {{ old('content_type', $content->content_type) == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="link" {{ old('content_type', $content->content_type) == 'link' ? 'selected' : '' }}>Link</option>
                </select>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun
                </label>
                @if($content->parent_id)
                    <input type="hidden" name="year" value="{{ $content->parent->year }}">
                    <input type="text" 
                           value="{{ $content->parent->year ?? 'Tidak ada tahun' }}"
                           disabled
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    <p class="mt-1 text-sm text-yellow-600">
                        <i class="fas fa-lock mr-1"></i>Sub-konten harus mengikuti tahun parent: <strong>{{ $content->parent->year ?? 'Tidak ada tahun' }}</strong>
                    </p>
                @else
                    <select name="year" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Tahun --</option>
                        @php
                            $currentYear = date('Y');
                            $maxYear = $currentYear + 1;
                            $minYear = 2020;
                        @endphp
                        @for($y = $maxYear; $y >= $minYear; $y--)
                            <option value="{{ $y }}" {{ old('year', $content->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Wajib: Pilih tahun untuk grouping konten berdasarkan tahun</p>
                    @if($content->children->count() > 0)
                        <p class="mt-1 text-sm text-blue-600">
                            <i class="fas fa-info-circle mr-1"></i>Mengubah tahun akan otomatis mengupdate semua sub-konten ({{ $content->children->count() }} item)
                        </p>
                    @endif
                @endif
            </div>

            <!-- Konten Text -->
            <div id="text-content-field" style="display: {{ old('content_type', $content->content_type) == 'text' ? 'block' : 'none' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konten Text
                </label>
                <textarea name="content" 
                          rows="8"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content', $content->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Link -->
            <div id="link-content-field" style="display: {{ old('content_type', $content->content_type) == 'link' ? 'block' : 'none' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    URL Links (Multiple)
                </label>
                <div id="links-container" class="space-y-2">
                    <!-- Links will be added dynamically -->
                </div>
                <button type="button" 
                        onclick="addLinkField()"
                        class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Link
                </button>
                @error('link_url')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                @error('link_url.*')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Klik "Tambah Link" untuk menambahkan URL baru. Setiap URL harus lengkap dengan https://
                </p>
            </div>

            <!-- Info Children -->
            @if($content->children->count() > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Konten ini memiliki {{ $content->children->count() }} sub-konten. 
                            Perubahan point number atau penghapusan akan mempengaruhi semua sub-konten.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-between">
            <button type="button" 
                    onclick="confirmDelete()"
                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i> Hapus Konten
            </button>
            <div class="flex space-x-3">
                <a href="{{ route('admin_pemeringkatan.the-impact-cms.editor', $sdg->id) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i> Update Konten
                </button>
            </div>
        </div>
    </form>

    <!-- Form Delete (Hidden) -->
    <form id="delete-form" 
          action="{{ route('admin_pemeringkatan.the-impact-cms.content.delete', $content->id) }}" 
          method="POST" 
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    let linkCounter = 0;

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
            
            // Add one link field if container is empty
            const container = document.getElementById('links-container');
            if (container.children.length === 0) {
                addLinkField();
            }
        }
    });

    // Add link field
    function addLinkField(value = '') {
        linkCounter++;
        const container = document.getElementById('links-container');
        const linkDiv = document.createElement('div');
        linkDiv.className = 'flex items-center space-x-2';
        linkDiv.id = `link-field-${linkCounter}`;
        
        linkDiv.innerHTML = `
            <input type="url" 
                   name="link_url[]" 
                   value="${value}"
                   placeholder="https://example.com/report.pdf"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="button" 
                    onclick="removeLinkField(${linkCounter})"
                    class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        container.appendChild(linkDiv);
    }

    // Remove link field
    function removeLinkField(id) {
        const field = document.getElementById(`link-field-${id}`);
        if (field) {
            field.remove();
        }
    }

    // Initialize with existing links on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(old('link_url'))
            @foreach(old('link_url', []) as $link)
                addLinkField('{{ $link }}');
            @endforeach
        @elseif($content->link_url && is_array($content->link_url))
            @foreach($content->link_url as $link)
                addLinkField('{{ $link }}');
            @endforeach
        @elseif($content->content_type == 'link')
            addLinkField();
        @endif
    });

    // Confirm delete
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Konten?',
            text: 'Konten dan semua sub-kontennya akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>

@endsection
