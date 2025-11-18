@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Input Responden Baru</h1>
            <nav class="flex text-sm text-gray-600" aria-label="Breadcrumb">
                <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin_pemeringkatan.responden.index') }}" class="hover:text-blue-600 transition">Responden</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium">Create</span>
            </nav>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Form Input Responden</h2>
                <p class="text-blue-100 text-sm mt-1">Lengkapi formulir di bawah ini dengan data responden yang valid</p>
            </div>

            <form method="POST" action="{{ route('admin_pemeringkatan.responden.store') }}" class="p-6">
                @csrf

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">Informasi Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <div class="md:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                            <select name="responden_title" id="title" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Pilih</option>
                                <option value="mr">Mr.</option>
                                <option value="mrs">Mrs.</option>
                                <option value="ms">Ms.</option>
                            </select>
                        </div>
                        <div class="md:col-span-9">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="responden_fullname" id="nama_lengkap" required
                                value="{{ old('responden_fullname') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Contoh: Dr. John Doe, M.Sc">
                            <p class="mt-1 text-xs text-gray-500">Masukkan nama lengkap responden beserta gelar akademik (jika ada)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" required
                                value="{{ old('email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="email@example.com">
                            <p class="mt-1 text-xs text-gray-500">Alamat email aktif responden untuk keperluan survey</p>
                        </div>
                        <div>
                            <label for="nomor_responden" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone_responden" id="nomor_responden"
                                value="{{ old('phone_responden') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                            <p class="mt-1 text-xs text-gray-500">Nomor telepon aktif responden (format: 08xxxx)</p>
                        </div>
                    </div>
                </div>


                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">Informasi Pekerjaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" name="responden_jabatan" id="jabatan" required
                                value="{{ old('responden_jabatan') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Contoh: Lecturer, Manager, Director">
                            <p class="mt-1 text-xs text-gray-500">Jabatan/posisi responden di instansi tempat bekerja</p>
                        </div>
                        <div>
                            <label for="instansi" class="block text-sm font-medium text-gray-700 mb-2">Instansi <span class="text-red-500">*</span></label>
                            <input type="text" name="responden_instansi" id="instansi" required
                                value="{{ old('responden_instansi') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Nama perusahaan/institusi">
                            <p class="mt-1 text-xs text-gray-500">Nama instansi/perusahaan tempat responden bekerja</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="respondent-type" class="block text-sm font-medium text-gray-700 mb-2">Kategori Responden <span class="text-red-500">*</span></label>
                        <select name="responden_category" id="respondent-type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="academic" {{ old('responden_category') == 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="employer" {{ old('responden_category') == 'employer' ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500">Informasi Pengusul</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_dosen" class="block text-sm font-medium text-gray-700 mb-2">Nama Dosen Pengusul <span class="text-red-500">*</span></label>
                            <input type="text" name="responden_dosen" id="nama_dosen" required
                                value="{{ old('responden_dosen') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Nama lengkap dosen">
                            <p class="mt-1 text-xs text-gray-500">Nama lengkap dosen yang mengusulkan responden</p>
                        </div>
                        <div>
                            <label for="nomor_narahubung" class="block text-sm font-medium text-gray-700 mb-2">Nomor Narahubung <span class="text-red-500">*</span></label>
                            <input type="text" name="responden_dosen_phone" id="nomor_narahubung" required
                                value="{{ old('responden_dosen_phone') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                            <p class="mt-1 text-xs text-gray-500">Nomor telepon aktif dosen pengusul</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="fakultas_narahubung" class="block text-sm font-medium text-gray-700 mb-2">Fakultas Narahubung <span class="text-red-500">*</span></label>
                        <select name="responden_fakultas" id="fakultas_narahubung" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana" {{ old('responden_fakultas') == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                            <option value="fip" {{ old('responden_fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                            <option value="fmipa" {{ old('responden_fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                            <option value="fpsi" {{ old('responden_fakultas') == 'fpsi' ? 'selected' : '' }}>FPsi</option>
                            <option value="fbs" {{ old('responden_fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                            <option value="ft" {{ old('responden_fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                            <option value="fikk" {{ old('responden_fakultas') == 'fikk' ? 'selected' : '' }}>FIKK</option>
                            <option value="fish" {{ old('responden_fakultas') == 'fish' ? 'selected' : '' }}>FISH</option>
                            <option value="feb" {{ old('responden_fakultas') == 'feb' ? 'selected' : '' }}>FEB</option>
                            <option value="profesi" {{ old('responden_fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Pilih fakultas dari dosen pengusul</p>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin_pemeringkatan.responden.index') }}"
                        class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                        <i class='bx bx-x mr-2'></i>Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-save mr-2'></i>Simpan Responden
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
