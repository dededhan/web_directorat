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
            <!-- Custom Point Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Point (Opsional)
                </label>
                <input type="text" 
                       name="custom_point_number" 
                       value="{{ old('custom_point_number') }}"
                       placeholder="Contoh: 1.3, 1.4, 2, atau 3.5.2"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('custom_point_number') border-red-500 @enderror">
                @error('custom_point_number')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i> Kosongkan untuk menggunakan numbering otomatis. 
                    Anda bisa memasukkan nomor apa saja (misal: 1.3, skip 1.2, atau langsung ke 3).
                </p>
            </div>

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

            <!-- Hidden field - always text -->
            <input type="hidden" name="content_type" value="text">

            <!-- Year -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun
                </label>
                @if($parentContent)
                    <input type="hidden" name="year" value="{{ $parentContent->year }}">
                    <input type="text" 
                           value="{{ $parentContent->year ?? 'Tidak ada tahun' }}"
                           disabled
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    <p class="mt-1 text-sm text-yellow-600">
                        <i class="fas fa-lock mr-1"></i>Sub-konten harus mengikuti tahun parent: <strong>{{ $parentContent->year ?? 'Tidak ada tahun' }}</strong>
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
                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Wajib: Pilih tahun untuk grouping konten berdasarkan tahun</p>
                @endif
            </div>

            <!-- Konten -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konten <span class="text-red-500">*</span>
                </label>
                <textarea name="content" 
                          rows="8"
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan deskripsi atau penjelasan konten. URL yang dicantumkan akan otomatis dapat diklik.</p>
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



@endsection
