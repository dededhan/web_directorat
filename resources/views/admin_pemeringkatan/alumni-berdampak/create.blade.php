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
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">Tambah Alumni Berdampak</h1>
                            <p class="text-blue-100 text-sm">Isi formulir untuk menambahkan data alumni berdampak baru</p>
                        </div>
                        <i class='bx bx-user-check text-5xl text-blue-100 opacity-50'></i>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.alumni-berdampak.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf

                    <!-- Section 1: Informasi Berita -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            <i class='bx bx-info-circle text-xl mr-2 text-blue-600'></i>
                            Informasi Berita
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Judul Berita -->
                            <div class="lg:col-span-2">
                                <label for="judul_berita" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Berita/Artikel <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="judul_berita" 
                                       id="judul_berita" 
                                       value="{{ old('judul_berita') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul_berita') border-red-500 @enderror"
                                       placeholder="Masukkan judul berita atau artikel"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Masukkan judul lengkap berita alumni berdampak</p>
                                @error('judul_berita')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Berita -->
                            <div>
                                <label for="tanggal_berita" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Berita/Artikel <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal_berita" 
                                       id="tanggal_berita" 
                                       value="{{ old('tanggal_berita', date('Y-m-d')) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_berita') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Tanggal publikasi berita</p>
                                @error('tanggal_berita')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Link Berita -->
                            <div>
                                <label for="link_berita" class="block text-sm font-medium text-gray-700 mb-2">
                                    Link Berita/Artikel <span class="text-red-500">*</span>
                                </label>
                                <input type="url" 
                                       name="link_berita" 
                                       id="link_berita" 
                                       value="{{ old('link_berita') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('link_berita') border-red-500 @enderror"
                                       placeholder="https://example.com/berita"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">URL lengkap berita</p>
                                @error('link_berita')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Alumni <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Upload foto alumni (JPG, PNG, max 2MB)</p>
                                @error('image')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Informasi Alumni -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                            <i class='bx bx-building text-xl mr-2 text-green-600'></i>
                            Informasi Alumni
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
                                        <option value="{{ strtolower($key) }}" {{ old('fakultas') == strtolower($key) ? 'selected' : '' }}>
                                            {{ $faculty['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih fakultas alumni</p>
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
                                <p class="text-xs text-gray-500 mt-1">Opsional - Pilih program studi alumni</p>
                                @error('prodi')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.alumni-berdampak.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                            <i class='bx bx-x text-lg mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                            <i class='bx bx-save text-lg mr-2'></i>
                            Simpan
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
            
            // Initialize if fakultas already selected (from old input)
            if (fakultasSelect.value) {
                populateProdiDropdown(fakultasSelect.value, "{{ old('prodi') }}");
            }
        }
    });
    </script>
@endsection
