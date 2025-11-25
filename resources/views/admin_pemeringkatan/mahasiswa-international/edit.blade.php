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
                            <h1 class="text-2xl font-bold text-white mb-1">Edit Mahasiswa International</h1>
                            <p class="text-amber-100 text-sm">Perbarui data mahasiswa internasional</p>
                        </div>
                        <i class='bx bx-edit text-5xl text-amber-100 opacity-50'></i>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.mahasiswa-international.update', $student->id) }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Identitas Mahasiswa -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            <i class='bx bx-user text-xl mr-2 text-blue-600'></i>
                            Identitas Mahasiswa
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Mahasiswa -->
                            <div>
                                <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Mahasiswa <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama_mahasiswa" 
                                       id="nama_mahasiswa" 
                                       value="{{ old('nama_mahasiswa', $student->nama_mahasiswa) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_mahasiswa') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap mahasiswa"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Nama lengkap mahasiswa internasional</p>
                                @error('nama_mahasiswa')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIM -->
                            <div>
                                <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                                    NIM (Opsional)
                                </label>
                                <input type="text" 
                                       name="nim" 
                                       id="nim" 
                                       value="{{ old('nim', $student->nim) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nim') border-red-500 @enderror"
                                       placeholder="Contoh: 123456789">
                                <p class="text-xs text-gray-500 mt-1">Nomor Induk Mahasiswa (jika ada)</p>
                                @error('nim')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Negara -->
                            <div>
                                <label for="negara" class="block text-sm font-medium text-gray-700 mb-2">
                                    Negara Asal <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="negara" 
                                       id="negara" 
                                       value="{{ old('negara', $student->negara) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('negara') border-red-500 @enderror"
                                       placeholder="Contoh: Malaysia, Thailand, Australia"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Negara asal mahasiswa</p>
                                @error('negara')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Status Akademik -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                            <i class='bx bx-book text-xl mr-2 text-green-600'></i>
                            Status Akademik
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
                                    <option value="inbound" {{ old('kategori', $student->kategori) == 'inbound' ? 'selected' : '' }}>Inbound (Masuk ke UNP)</option>
                                    <option value="outbound" {{ old('kategori', $student->kategori) == 'outbound' ? 'selected' : '' }}>Outbound (Keluar dari UNP)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih apakah mahasiswa inbound atau outbound</p>
                                @error('kategori')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Studi <span class="text-red-500">*</span>
                                </label>
                                <select name="status" 
                                        id="status" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="fulltime" {{ old('status', $student->status) == 'fulltime' ? 'selected' : '' }}>Full Time</option>
                                    <option value="parttime" {{ old('status', $student->status) == 'parttime' ? 'selected' : '' }}>Part Time</option>
                                    <option value="other" {{ old('status', $student->status) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Status waktu studi mahasiswa</p>
                                @error('status')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fakultas -->
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fakultas (Opsional)
                                </label>
                                <input type="text" 
                                       name="fakultas" 
                                       id="fakultas" 
                                       value="{{ old('fakultas', $student->fakultas) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fakultas') border-red-500 @enderror"
                                       placeholder="Contoh: Fakultas Teknik">
                                <p class="text-xs text-gray-500 mt-1">Fakultas tempat mahasiswa belajar</p>
                                @error('fakultas')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Program Studi -->
                            <div>
                                <label for="program_studi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Program Studi (Opsional)
                                </label>
                                <input type="text" 
                                       name="program_studi" 
                                       id="program_studi" 
                                       value="{{ old('program_studi', $student->program_studi) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('program_studi') border-red-500 @enderror"
                                       placeholder="Contoh: Teknik Informatika">
                                <p class="text-xs text-gray-500 mt-1">Program studi yang diambil</p>
                                @error('program_studi')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Periode Studi -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-200">
                            <i class='bx bx-calendar text-xl mr-2 text-purple-600'></i>
                            Periode Studi
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Periode Mulai -->
                            <div>
                                <label for="periode_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="periode_mulai" 
                                       id="periode_mulai" 
                                       value="{{ old('periode_mulai', $student->periode_mulai) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('periode_mulai') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Tanggal mulai periode studi</p>
                                @error('periode_mulai')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Periode Akhir -->
                            <div>
                                <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="periode_akhir" 
                                       id="periode_akhir" 
                                       value="{{ old('periode_akhir', $student->periode_akhir) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('periode_akhir') border-red-500 @enderror"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Tanggal selesai periode studi (harus setelah tanggal mulai)</p>
                                @error('periode_akhir')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.mahasiswa-international.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200 w-full sm:w-auto">
                            <i class='bx bx-arrow-back text-lg mr-2'></i>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto sm:ml-auto">
                            <i class='bx bx-save text-lg mr-2'></i>
                            Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ez script validation
        document.getElementById('periode_akhir').addEventListener('change', function() {
            const mulai = document.getElementById('periode_mulai').value;
            const akhir = this.value;
            
            if (mulai && akhir && akhir <= mulai) {
                alert('Tanggal selesai harus setelah tanggal mulai!');
                this.value = '{{ $student->periode_akhir }}';
            }
        });

        document.getElementById('periode_mulai').addEventListener('change', function() {
            const mulai = this.value;
            const akhir = document.getElementById('periode_akhir').value;
            
            if (mulai && akhir && akhir <= mulai) {
                alert('Tanggal selesai harus setelah tanggal mulai!');
                this.value = '{{ $student->periode_mulai }}';
            }
        });
    </script>
@endsection