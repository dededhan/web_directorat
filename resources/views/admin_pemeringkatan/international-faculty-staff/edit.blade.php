@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <!-- Main container with progressive padding -->
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Faculty Staff</h1>
                <p class="mt-1 text-sm text-gray-600">Update information for {{ $staff->nama }}</p>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-red-500 text-xl mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
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
                <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Update Faculty Staff Information</h2>
                    <p class="text-amber-100 text-sm mt-1">Modify the information below to update faculty member details</p>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.international-faculty-staff.update', $staff->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama" 
                                       id="nama" 
                                       value="{{ old('nama', $staff->nama) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror" 
                                       placeholder="Enter full name">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Current Photo Display -->
                            @if($staff->foto_path)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ Storage::url($staff->foto_path) }}" 
                                             alt="{{ $staff->nama }}" 
                                             class="h-24 w-24 rounded-lg object-cover border-2 border-gray-200 shadow-sm">
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-600">Current photo will be replaced if you upload a new one</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Photo Upload -->
                            <div class="md:col-span-2">
                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ $staff->foto_path ? 'Update Photo' : 'Upload Photo' }} 
                                    <span class="text-gray-500 text-xs">(Optional, max 2MB)</span>
                                </label>
                                <input type="file" 
                                       name="foto" 
                                       id="foto" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('foto') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $staff->foto_path ? 'Leave empty to keep current photo. ' : '' }}Supported formats: JPG, PNG, GIF (max 2MB)
                                </p>
                                @error('foto')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Academic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">
                            Academic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fakultas -->
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">
                                    Fakultas <span class="text-red-500">*</span>
                                </label>
                                <select name="fakultas" 
                                        id="fakultas" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fakultas') border-red-500 @enderror">
                                    <option value="">Select Fakultas</option>
                                    <option value="pascasarjana" {{ old('fakultas', $staff->fakultas) == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                                    <option value="fip" {{ old('fakultas', $staff->fakultas) == 'fip' ? 'selected' : '' }}>FIP</option>
                                    <option value="fmipa" {{ old('fakultas', $staff->fakultas) == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                                    <option value="fppsi" {{ old('fakultas', $staff->fakultas) == 'fppsi' ? 'selected' : '' }}>FPPsi</option>
                                    <option value="fbs" {{ old('fakultas', $staff->fakultas) == 'fbs' ? 'selected' : '' }}>FBS</option>
                                    <option value="ft" {{ old('fakultas', $staff->fakultas) == 'ft' ? 'selected' : '' }}>FT</option>
                                    <option value="fik" {{ old('fakultas', $staff->fakultas) == 'fik' ? 'selected' : '' }}>FIK</option>
                                    <option value="fis" {{ old('fakultas', $staff->fakultas) == 'fis' ? 'selected' : '' }}>FIS</option>
                                    <option value="fe" {{ old('fakultas', $staff->fakultas) == 'fe' ? 'selected' : '' }}>FE</option>
                                    <option value="profesi" {{ old('fakultas', $staff->fakultas) == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                                </select>
                                @error('fakultas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Home University -->
                            <div>
                                <label for="universitas_asal" class="block text-sm font-medium text-gray-700 mb-1">
                                    Home University <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="universitas_asal" 
                                       id="universitas_asal" 
                                       value="{{ old('universitas_asal', $staff->universitas_asal) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('universitas_asal') border-red-500 @enderror" 
                                       placeholder="e.g., Harvard University">
                                @error('universitas_asal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expertise Field -->
                            <div>
                                <label for="bidang_keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                                    Field of Expertise <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="bidang_keahlian" 
                                       id="bidang_keahlian" 
                                       value="{{ old('bidang_keahlian', $staff->bidang_keahlian) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bidang_keahlian') border-red-500 @enderror" 
                                       placeholder="e.g., Computer Science, Education">
                                @error('bidang_keahlian')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category" 
                                        id="category" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror">
                                    <option value="">Select Category</option>
                                    <option value="fulltime" {{ old('category', $staff->category) == 'fulltime' ? 'selected' : '' }}>Full Time</option>
                                    <option value="adjunct" {{ old('category', $staff->category) == 'adjunct' ? 'selected' : '' }}>Adjunct</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Full Time: Permanent position | Adjunct: Visiting/Part-time</p>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">
                                    Year <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="tahun" 
                                       id="tahun" 
                                       value="{{ old('tahun', $staff->tahun) }}"
                                       min="2000"
                                       max="{{ date('Y') + 5 }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun') border-red-500 @enderror" 
                                       placeholder="{{ date('Y') }}">
                                @error('tahun')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Rankings & Metrics (Optional) -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500">
                            Rankings & Metrics <span class="text-sm font-normal text-gray-500">(Optional)</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- QS WUR -->
                            <div>
                                <label for="qs_wur" class="block text-sm font-medium text-gray-700 mb-1">
                                    QS World University Rankings
                                </label>
                                <input type="text" 
                                       name="qs_wur" 
                                       id="qs_wur" 
                                       value="{{ old('qs_wur', $staff->qs_wur) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('qs_wur') border-red-500 @enderror" 
                                       placeholder="e.g., Top 100">
                                @error('qs_wur')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- QS Subject -->
                            <div>
                                <label for="qs_subject" class="block text-sm font-medium text-gray-700 mb-1">
                                    QS Subject Rankings
                                </label>
                                <input type="text" 
                                       name="qs_subject" 
                                       id="qs_subject" 
                                       value="{{ old('qs_subject', $staff->qs_subject) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('qs_subject') border-red-500 @enderror" 
                                       placeholder="e.g., Engineering Top 50">
                                @error('qs_subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Scopus -->
                            <div>
                                <label for="scopus" class="block text-sm font-medium text-gray-700 mb-1">
                                    Scopus H-Index
                                </label>
                                <input type="text" 
                                       name="scopus" 
                                       id="scopus" 
                                       value="{{ old('scopus', $staff->scopus) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('scopus') border-red-500 @enderror" 
                                       placeholder="e.g., H-Index: 25">
                                @error('scopus')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 w-full sm:w-auto">
                            <i class='bx bx-save text-lg mr-2'></i>
                            Update Faculty Staff
                        </button>
                        <a href="{{ route('admin_pemeringkatan.international-faculty-staff.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 w-full sm:w-auto">
                            <i class='bx bx-arrow-back text-lg mr-2'></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
