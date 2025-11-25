@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">

            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <a href="{{ route('admin_pemeringkatan.data-akreditasi.index') }}" 
                       class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                        <i class='bx bx-arrow-back text-2xl mr-1'></i>
                        <span class="font-medium">Kembali</span>
                    </a>
                </div>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-2xl text-red-500 mr-3 flex-shrink-0'></i>
                        <div class="flex-1">
                            <h3 class="text-red-800 font-semibold mb-2">Terdapat kesalahan pada input:</h3>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class='bx bx-plus-circle text-2xl mr-2'></i>
                        Tambah Data Akreditasi
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Lengkapi form di bawah untuk menambah data akreditasi baru</p>
                </div>

                <!-- Form Body -->
                <form action="{{ route('admin_pemeringkatan.data-akreditasi.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Section: Identitas Program Studi -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            Identitas Program Studi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fakultas -->
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fakultas <span class="text-red-500">*</span>
                                </label>
                                <select name="fakultas" 
                                        id="fakultas"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fakultas') border-red-500 @enderror">
                                    <option value="">Pilih Fakultas</option>
                                    <option value="pascasarjana" {{ old('fakultas') == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                                    <option value="fip" {{ old('fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                                    <option value="fmipa" {{ old('fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                                    <option value="fppsi" {{ old('fakultas') == 'fppsi' ? 'selected' : '' }}>FPPsi</option>
                                    <option value="fbs" {{ old('fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                                    <option value="ft" {{ old('fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                                    <option value="fik" {{ old('fakultas') == 'fik' ? 'selected' : '' }}>FIK</option>
                                    <option value="fis" {{ old('fakultas') == 'fis' ? 'selected' : '' }}>FIS</option>
                                    <option value="fe" {{ old('fakultas') == 'fe' ? 'selected' : '' }}>FE</option>
                                    <option value="profesi" {{ old('fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                                </select>
                                @error('fakultas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih fakultas yang akan diinput data akreditasinya</p>
                            </div>

                            <!-- Program Studi -->
                            <div>
                                <label for="prodi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Program Studi <span class="text-red-500">*</span>
                                </label>
                                <select name="prodi" 
                                        id="prodi"
                                        required
                                        disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed @error('prodi') border-red-500 @enderror">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                                @error('prodi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih program studi yang akan diinput data akreditasinya</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Informasi Akreditasi -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                            Informasi Akreditasi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Lembaga Akreditasi -->
                            <div>
                                <label for="lembaga_akreditasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lembaga Akreditasi <span class="text-red-500">*</span>
                                </label>
                                <select name="lembaga_akreditasi" 
                                        id="lembaga_akreditasi"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('lembaga_akreditasi') border-red-500 @enderror">
                                    <option value="">Pilih Lembaga Akreditasi</option>
                                    <option value="ban-pt" {{ old('lembaga_akreditasi') == 'ban-pt' ? 'selected' : '' }}>BAN-PT</option>
                                    <option value="lam-infokom" {{ old('lembaga_akreditasi') == 'lam-infokom' ? 'selected' : '' }}>LAM INFOKOM</option>
                                    <option value="lam-teknik" {{ old('lembaga_akreditasi') == 'lam-teknik' ? 'selected' : '' }}>LAM TEKNIK</option>
                                    <option value="lam-ekonomi" {{ old('lembaga_akreditasi') == 'lam-ekonomi' ? 'selected' : '' }}>LAMEMBA</option>
                                    <option value="lam-pendidikan" {{ old('lembaga_akreditasi') == 'lam-pendidikan' ? 'selected' : '' }}>LAMDIK</option>
                                    <option value="lam-sains" {{ old('lembaga_akreditasi') == 'lam-sains' ? 'selected' : '' }}>LAMSAMA</option>
                                </select>
                                @error('lembaga_akreditasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih lembaga yang mengeluarkan akreditasi</p>
                            </div>

                            <!-- Peringkat -->
                            <div>
                                <label for="peringkat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Peringkat Akreditasi <span class="text-red-500">*</span>
                                </label>
                                <select name="peringkat" 
                                        id="peringkat"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('peringkat') border-red-500 @enderror">
                                    <option value="">Pilih Peringkat</option>
                                    <option value="unggul" {{ old('peringkat') == 'unggul' ? 'selected' : '' }}>Unggul</option>
                                    <option value="baik_sekali" {{ old('peringkat') == 'baik_sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                    <option value="baik" {{ old('peringkat') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="a" {{ old('peringkat') == 'a' ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ old('peringkat') == 'b' ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ old('peringkat') == 'c' ? 'selected' : '' }}>C</option>
                                </select>
                                @error('peringkat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih peringkat akreditasi yang diperoleh</p>
                            </div>

                            <!-- Nomor SK -->
                            <div class="md:col-span-2">
                                <label for="nomor_sk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor SK <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nomor_sk" 
                                       id="nomor_sk"
                                       required
                                       value="{{ old('nomor_sk') }}"
                                       placeholder="Contoh: 1234/SK/BAN-PT/2024"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_sk') border-red-500 @enderror">
                                @error('nomor_sk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Masukkan nomor SK akreditasi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Periode Berlaku -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-200">
                            Periode Berlaku
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Periode Awal -->
                            <div>
                                <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Periode Awal Berlaku <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="periode_awal" 
                                       id="periode_awal"
                                       required
                                       value="{{ old('periode_awal') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('periode_awal') border-red-500 @enderror">
                                @error('periode_awal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih tanggal mulai berlakunya akreditasi</p>
                            </div>

                            <!-- Periode Akhir -->
                            <div>
                                <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Periode Akhir Berlaku <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="periode_akhir" 
                                       id="periode_akhir"
                                       required
                                       value="{{ old('periode_akhir') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('periode_akhir') border-red-500 @enderror">
                                @error('periode_akhir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih tanggal berakhirnya akreditasi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.data-akreditasi.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out">
                            <i class='bx bx-x text-xl mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                            <i class='bx bx-save text-xl mr-2'></i>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @vite(['resources/js/admin/akreditasi_dashboard.js'])
@endsection
