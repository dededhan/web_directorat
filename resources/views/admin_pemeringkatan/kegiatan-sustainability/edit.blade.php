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
                <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">Edit Kegiatan Sustainability</h1>
                            <p class="text-amber-100 text-sm">Perbarui informasi kegiatan sustainability</p>
                        </div>
                        <i class='bx bx-edit text-5xl text-amber-100 opacity-50'></i>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.kegiatan-sustainability.update', $sustainability->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Informasi Kegiatan -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            <i class='bx bx-info-circle text-xl mr-2 text-blue-600'></i>
                            Informasi Kegiatan
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Judul Kegiatan -->
                            <div class="lg:col-span-2">
                                <label for="judul_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="judul_kegiatan" 
                                       id="judul_kegiatan" 
                                       value="{{ old('judul_kegiatan', $sustainability->judul_kegiatan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul_kegiatan') border-red-500 @enderror"
                                       placeholder="Masukkan judul kegiatan"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Masukkan judul lengkap kegiatan sustainability</p>
                                @error('judul_kegiatan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Kegiatan -->
                            <div>
                                <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal_kegiatan" 
                                       id="tanggal_kegiatan" 
                                       value="{{ old('tanggal_kegiatan', $sustainability->tanggal_kegiatan->format('Y-m-d')) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_kegiatan') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Tanggal pelaksanaan kegiatan</p>
                                @error('tanggal_kegiatan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Link Kegiatan -->
                            <div>
                                <label for="link_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Link Kegiatan
                                </label>
                                <input type="url" 
                                       name="link_kegiatan" 
                                       id="link_kegiatan" 
                                       value="{{ old('link_kegiatan', $sustainability->link_kegiatan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('link_kegiatan') border-red-500 @enderror"
                                       placeholder="https://example.com">
                                <p class="text-xs text-gray-500 mt-1">URL dokumentasi kegiatan (opsional)</p>
                                @error('link_kegiatan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi Kegiatan -->
                            <div class="lg:col-span-2">
                                <label for="deskripsi_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="deskripsi_kegiatan" 
                                          id="deskripsi_kegiatan" 
                                          rows="4"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi_kegiatan') border-red-500 @enderror"
                                          placeholder="Masukkan deskripsi lengkap kegiatan"
                                          required>{{ old('deskripsi_kegiatan', $sustainability->deskripsi_kegiatan) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Deskripsi lengkap mengenai kegiatan</p>
                                @error('deskripsi_kegiatan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Lokasi & Dokumentasi -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                            <i class='bx bx-building text-xl mr-2 text-green-600'></i>
                            Lokasi & Dokumentasi
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Fakultas -->
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fakultas <span class="text-red-500">*</span>
                                </label>
                                <select name="fakultas" 
                                        id="fakultas" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fakultas') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Fakultas</option>
                                    @php
                                        $faculties = $faculties_data ?? [];
                                    @endphp
                                    @foreach ($faculties as $key => $faculty)
                                        <option value="{{ strtolower($key) }}" {{ old('fakultas', $sustainability->fakultas) == strtolower($key) ? 'selected' : '' }}>
                                            {{ $faculty['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih fakultas penyelenggara</p>
                                @error('fakultas')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Program Studi -->
                            <div>
                                <label for="prodi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Program Studi
                                </label>
                                <select name="prodi" 
                                        id="prodi" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prodi') border-red-500 @enderror"
                                        disabled>
                                    <option value="">Pilih Program Studi</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Opsional - Pilih program studi terkait</p>
                                @error('prodi')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Current Photos -->
                            @if($sustainability->photos->count() > 0)
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                    @foreach($sustainability->photos as $photo)
                                        <div class="relative group">
                                            <img src="/storage/{{ $photo->path }}" 
                                                 alt="Foto Kegiatan" 
                                                 class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                            <a href="/storage/{{ $photo->path }}" 
                                               target="_blank"
                                               class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 rounded-lg">
                                                <i class='bx bx-search text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200'></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 mt-2">{{ $sustainability->photos->count() }} foto tersimpan</p>
                            </div>
                            @endif

                            <!-- Foto Kegiatan -->
                            <div class="lg:col-span-2">
                                <label for="foto_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tambah Foto Baru
                                </label>
                                <input type="file" 
                                       name="foto_kegiatan[]" 
                                       id="foto_kegiatan" 
                                       accept="image/*"
                                       multiple
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('foto_kegiatan') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Upload foto tambahan untuk kegiatan ini (JPG, PNG, max 2MB per file)</p>
                                @error('foto_kegiatan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.kegiatan-sustainability.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                            <i class='bx bx-x text-lg mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                            <i class='bx bx-save text-lg mr-2'></i>
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const facultiesData = @json($faculties_data ?? []);
        const fakultasSelect = document.getElementById('fakultas');
        const prodiSelect = document.getElementById('prodi');
        const currentProdi = "{{ old('prodi', $sustainability->prodi) }}";

        function populateProdiDropdown(fakultasValue, selectedProdi = null) {
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            prodiSelect.disabled = true;

            if (fakultasValue && facultiesData[fakultasValue.toUpperCase()] && facultiesData[fakultasValue.toUpperCase()].programs) {
                prodiSelect.disabled = false;
                facultiesData[fakultasValue.toUpperCase()].programs.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    if (selectedProdi && prodi === selectedProdi) {
                        option.selected = true;
                    }
                    prodiSelect.appendChild(option);
                });
            }
            
            // Add option for no prodi
            const noProdiOption = document.createElement('option');
            noProdiOption.value = "";
            noProdiOption.textContent = "-- Tidak Ada --";
            if (selectedProdi === null || selectedProdi === "") {
                noProdiOption.selected = true;
            }
            prodiSelect.insertBefore(noProdiOption, prodiSelect.firstChild.nextSibling);
        }

        if (fakultasSelect) {
            fakultasSelect.addEventListener('change', function() {
                populateProdiDropdown(this.value);
            });
            
            // Initialize with current fakultas value
            if (fakultasSelect.value) {
                populateProdiDropdown(fakultasSelect.value, currentProdi);
            }
        }
    });
    </script>
@endsection
