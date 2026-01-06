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
                            <h1 class="text-2xl font-bold text-white mb-1">Tambah Mata Kuliah Sustainability</h1>
                            <p class="text-blue-100 text-sm">Isi formulir untuk menambahkan mata kuliah sustainability baru</p>
                        </div>
                        <i class='bx bx-book-content text-5xl text-blue-100 opacity-50'></i>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.mata-kuliah-sustainability.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf

                    <!-- Section 1: Informasi Dasar -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            <i class='bx bx-info-circle text-xl mr-2 text-blue-600'></i>
                            Informasi Dasar
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Kelompok Kategori SDGs -->
                            <div class="lg:col-span-2">
                                <label for="sdgs_group" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kelompok Kategori SDGs <span class="text-red-500">*</span>
                                </label>
                                <select name="sdgs_group" 
                                        id="sdgs_group" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sdgs_group') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Kelompok Kategori</option>
                                    @php
                                        $sdgGoalsData = [
                                            1 => 'Tanpa Kemiskinan',
                                            2 => 'Tanpa Kelaparan',
                                            3 => 'Kehidupan Sehat dan Sejahtera',
                                            4 => 'Pendidikan Berkualitas',
                                            5 => 'Kesetaraan Gender',
                                            6 => 'Air Bersih dan Sanitasi Layak',
                                            7 => 'Energi Bersih dan Terjangkau',
                                            8 => 'Pekerjaan Layak dan Pertumbuhan Ekonomi',
                                            9 => 'Industri, Inovasi, dan Infrastruktur',
                                            10 => 'Berkurangnya Kesenjangan',
                                            11 => 'Kota dan Pemukiman yang Berkelanjutan',
                                            12 => 'Konsumsi dan Produksi yang Bertanggung Jawab',
                                            13 => 'Penanganan Perubahan Iklim',
                                            14 => 'Ekosistem Lautan',
                                            15 => 'Ekosistem Daratan',
                                            16 => 'Perdamaian, Keadilan, dan Kelembagaan yang Tangguh',
                                            17 => 'Kemitraan untuk Mencapai Tujuan',
                                        ];
                                    @endphp
                                    @foreach ($sdgGoalsData as $number => $description)
                                        @php $optionValue = 'SDGs ' . $number; @endphp
                                        <option value="{{ $optionValue }}" {{ old('sdgs_group') == $optionValue ? 'selected' : '' }}>
                                            SDGs {{ $number }}: {{ $description }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih kelompok SDGs yang relevan</p>
                                @error('sdgs_group')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Mata Kuliah -->
                            <div class="lg:col-span-2">
                                <label for="nama_matkul" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Mata Kuliah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama_matkul" 
                                       id="nama_matkul" 
                                       value="{{ old('nama_matkul') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_matkul') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap mata kuliah"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Masukkan nama lengkap mata kuliah</p>
                                @error('nama_matkul')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kode Mata Kuliah -->
                            <div>
                                <label for="kode_matkul" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Mata Kuliah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="kode_matkul" 
                                       id="kode_matkul" 
                                       value="{{ old('kode_matkul') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kode_matkul') border-red-500 @enderror"
                                       placeholder="Contoh: MK001"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Kode unik mata kuliah</p>
                                @error('kode_matkul')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Semester -->
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="semester" 
                                       id="semester" 
                                       value="{{ old('semester') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('semester') border-red-500 @enderror"
                                       placeholder="Contoh: 1, 2, 3"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Semester pelaksanaan</p>
                                @error('semester')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

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
                                <p class="text-xs text-gray-500 mt-1">Opsional - Pilih program studi atau kosongkan untuk level fakultas</p>
                                @error('prodi')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Dokumen & Deskripsi -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                            <i class='bx bx-file text-xl mr-2 text-green-600'></i>
                            Dokumen & Deskripsi
                        </h3>
                        
                        <!-- RPS Upload -->
                        <div class="mb-6">
                            <label for="rps" class="block text-sm font-medium text-gray-700 mb-2">
                                RPS Mata Kuliah
                            </label>
                            <input type="file" 
                                   name="rps" 
                                   id="rps" 
                                   accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rps') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Upload file RPS (PDF, DOC, DOCX, maksimal 10MB)</p>
                            @error('rps')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Mata Kuliah <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="5"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                                      placeholder="Masukkan deskripsi lengkap mata kuliah (minimal 50 karakter)"
                                      required>{{ old('deskripsi') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Deskripsi lengkap mata kuliah (minimal 50 karakter)</p>
                            @error('deskripsi')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.mata-kuliah-sustainability.index') }}" 
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
            
            // Add option for faculty level
            const noProdiOption = document.createElement('option');
            noProdiOption.value = "";
            noProdiOption.textContent = "-- Level Fakultas (Tanpa Prodi) --";
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
