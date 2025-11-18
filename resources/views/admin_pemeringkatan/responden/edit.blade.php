@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Responden</h1>
            <nav class="flex text-sm text-gray-600" aria-label="Breadcrumb">
                <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin_pemeringkatan.responden.index') }}" class="hover:text-blue-600 transition">Responden</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium">Edit</span>
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

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Form Edit Responden</h2>
                <p class="text-amber-100 text-sm mt-1">Perbarui data responden sesuai kebutuhan</p>
            </div>

            <form method="POST" action="{{ route('admin_pemeringkatan.responden.update', $responden->id) }}" class="p-6">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">Informasi Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <div class="md:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                            <select name="title" id="title" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Pilih</option>
                                <option value="mr" {{ old('title', $responden->title) == 'mr' ? 'selected' : '' }}>Mr.</option>
                                <option value="mrs" {{ old('title', $responden->title) == 'mrs' ? 'selected' : '' }}>Mrs.</option>
                                <option value="ms" {{ old('title', $responden->title) == 'ms' ? 'selected' : '' }}>Ms.</option>
                            </select>
                        </div>
                        <div class="md:col-span-9">
                            <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="fullname" id="fullname" required
                                value="{{ old('fullname', $responden->fullname) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Contoh: Dr. John Doe, M.Sc">
                            <p class="mt-1 text-xs text-gray-500">Masukkan nama lengkap responden beserta gelar akademik (jika ada)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" required
                                value="{{ old('email', $responden->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="email@example.com">
                            <p class="mt-1 text-xs text-gray-500">Alamat email aktif responden untuk keperluan survey</p>
                        </div>
                        <div>
                            <label for="phone_responden" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone_responden" id="phone_responden"
                                value="{{ old('phone_responden', $responden->phone_responden) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                            <p class="mt-1 text-xs text-gray-500">Nomor telepon aktif responden (format: 08xxxx)</p>
                        </div>
                    </div>
                </div>

                <!-- Work Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">Informasi Pekerjaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" name="jabatan" id="jabatan" required
                                value="{{ old('jabatan', $responden->jabatan) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Contoh: Lecturer, Manager, Director">
                            <p class="mt-1 text-xs text-gray-500">Jabatan/posisi responden di instansi tempat bekerja</p>
                        </div>
                        <div>
                            <label for="instansi" class="block text-sm font-medium text-gray-700 mb-2">Instansi <span class="text-red-500">*</span></label>
                            <input type="text" name="instansi" id="instansi" required
                                value="{{ old('instansi', $responden->instansi) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Nama perusahaan/institusi">
                            <p class="mt-1 text-xs text-gray-500">Nama instansi/perusahaan tempat responden bekerja</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori Responden <span class="text-red-500">*</span></label>
                        <select name="category" id="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="academic" {{ old('category', $responden->category) == 'academic' ? 'selected' : '' }}>Academic (Institusi Pendidikan)</option>
                            <option value="employer" {{ old('category', $responden->category) == 'employer' ? 'selected' : '' }}>Employee (Dunia Kerja/Industri)</option>
                        </select>
                    </div>
                </div>

                <!-- Proposer Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500">Informasi Pengusul</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_dosen_pengusul" class="block text-sm font-medium text-gray-700 mb-2">Nama Dosen Pengusul <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_dosen_pengusul" id="nama_dosen_pengusul" required
                                value="{{ old('nama_dosen_pengusul', $responden->nama_dosen_pengusul) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Nama lengkap dosen">
                            <p class="mt-1 text-xs text-gray-500">Nama lengkap dosen yang mengusulkan responden</p>
                        </div>
                        <div>
                            <label for="phone_dosen" class="block text-sm font-medium text-gray-700 mb-2">Nomor Narahubung <span class="text-red-500">*</span></label>
                            <input type="text" name="phone_dosen" id="phone_dosen" required
                                value="{{ old('phone_dosen', $responden->phone_dosen) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                            <p class="mt-1 text-xs text-gray-500">Nomor telepon aktif dosen pengusul</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">Fakultas Narahubung <span class="text-red-500">*</span></label>
                        <select name="fakultas" id="fakultas" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana" {{ old('fakultas', $responden->fakultas) == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                            <option value="fip" {{ old('fakultas', $responden->fakultas) == 'fip' ? 'selected' : '' }}>FIP</option>
                            <option value="fmipa" {{ old('fakultas', $responden->fakultas) == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                            <option value="fpsi" {{ old('fakultas', $responden->fakultas) == 'fpsi' ? 'selected' : '' }}>FPsi</option>
                            <option value="fbs" {{ old('fakultas', $responden->fakultas) == 'fbs' ? 'selected' : '' }}>FBS</option>
                            <option value="ft" {{ old('fakultas', $responden->fakultas) == 'ft' ? 'selected' : '' }}>FT</option>
                            <option value="fikk" {{ old('fakultas', $responden->fakultas) == 'fikk' ? 'selected' : '' }}>FIKK</option>
                            <option value="fish" {{ old('fakultas', $responden->fakultas) == 'fish' ? 'selected' : '' }}>FISH</option>
                            <option value="feb" {{ old('fakultas', $responden->fakultas) == 'feb' ? 'selected' : '' }}>FEB</option>
                            <option value="profesi" {{ old('fakultas', $responden->fakultas) == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Pilih fakultas dari dosen pengusul</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin_pemeringkatan.responden.index') }}"
                        class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                        <i class='bx bx-x mr-2'></i>Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-save mr-2'></i>Update Responden
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
