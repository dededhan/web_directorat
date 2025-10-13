@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Form Informasi Dasar Inovasi</h1>
            <p class="text-gray-600">Lengkapi informasi dasar mengenai inovasi Anda</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin_inovasi.katsinov-v2.form-informasi-dasar.store', $katsinov->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-8">
            @csrf

            <div class="space-y-6">
                {{-- Section 1: Informasi Kontak --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Kontak</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Penanggung Jawab / PIC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pic" value="{{ old('pic', $informasi->pic ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('pic')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Institusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="institution" value="{{ old('institution', $informasi->institution ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('institution')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $informasi->phone ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="3" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address', $informasi->address ?? '') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fax (Opsional)
                            </label>
                            <input type="text" name="fax" value="{{ old('fax', $informasi->fax ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('fax')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Detail Inovasi --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Inovasi</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="innovation_title" value="{{ old('innovation_title', $informasi->innovation_title ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('innovation_title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="innovation_name" value="{{ old('innovation_name', $informasi->innovation_name ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('innovation_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Inovasi <span class="text-red-500">*</span>
                            </label>
                            <select name="innovation_type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis</option>
                                <option value="Produk" {{ old('innovation_type', $informasi->innovation_type ?? '') == 'Produk' ? 'selected' : '' }}>Produk</option>
                                <option value="Proses" {{ old('innovation_type', $informasi->innovation_type ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Layanan" {{ old('innovation_type', $informasi->innovation_type ?? '') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                            </select>
                            @error('innovation_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="innovation_field" value="{{ old('innovation_field', $informasi->innovation_field ?? '') }}" required
                                   placeholder="Contoh: Teknologi Informasi"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('innovation_field')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Aplikasi Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="innovation_application" value="{{ old('innovation_application', $informasi->innovation_application ?? '') }}" required
                                   placeholder="Contoh: Industri 4.0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('innovation_application')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi Pengembangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="innovation_duration" value="{{ old('innovation_duration', $informasi->innovation_duration ?? '') }}" required
                                   placeholder="Contoh: 12 bulan"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('innovation_duration')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="innovation_year" value="{{ old('innovation_year', $informasi->innovation_year ?? date('Y')) }}" required
                                   placeholder="2024"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('innovation_year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 3: Deskripsi --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Deskripsi Inovasi</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ringkasan Inovasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="innovation_summary" rows="5" required
                                      placeholder="Jelaskan secara ringkas mengenai inovasi Anda..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('innovation_summary', $informasi->innovation_summary ?? '') }}</textarea>
                            @error('innovation_summary')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kebaruan Inovasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="innovation_novelty" rows="5" required
                                      placeholder="Jelaskan aspek kebaruan dari inovasi Anda..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('innovation_novelty', $informasi->innovation_novelty ?? '') }}</textarea>
                            @error('innovation_novelty')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keunggulan Inovasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="innovation_supremacy" rows="5" required
                                      placeholder="Jelaskan keunggulan kompetitif dari inovasi Anda..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('innovation_supremacy', $informasi->innovation_supremacy ?? '') }}</textarea>
                            @error('innovation_supremacy')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan Informasi Dasar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
