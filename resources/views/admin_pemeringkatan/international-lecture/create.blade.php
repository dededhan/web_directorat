@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    {{-- Load JavaScript for fakultas → prodi cascading dropdown --}}
    @vite(['resources/js/admin/international_lecture_dashboard.js'])

    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            
            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-red-500 text-xl mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <h3 class="text-red-800 font-medium mb-2">Please correct the following errors:</h3>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
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
                <!-- Header with Blue Gradient -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Add New International Lecturer</h2>
                    <p class="text-blue-100 text-sm mt-1">Fill in the details to add a new international visiting lecturer</p>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.international-lecture.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Section 1: Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">Personal Information</h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Lecturer Name -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                    Lecturer Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama" 
                                       id="nama" 
                                       value="{{ old('nama') }}"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Full name of the international lecturer</p>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Country and University -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="negara" class="block text-sm font-medium text-gray-700 mb-1">
                                        Country of Origin <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="negara" 
                                           id="negara" 
                                           value="{{ old('negara') }}"
                                           required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('negara') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Lecturer's home country</p>
                                    @error('negara')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="universitas_asal" class="block text-sm font-medium text-gray-700 mb-1">
                                        Home University <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="universitas_asal" 
                                           id="universitas_asal" 
                                           value="{{ old('universitas_asal') }}"
                                           required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('universitas_asal') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Lecturer's affiliated university</p>
                                    @error('universitas_asal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Academic Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">Academic Details</h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Fakultas and Program Studi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">
                                        Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="fakultas" 
                                            id="fakultas" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('fakultas') border-red-500 @enderror">
                                        <option value="">Select Fakultas</option>
                                        <option value="pascasarjana" {{ old('fakultas') == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                                        <option value="fip" {{ old('fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                                        <option value="fmipa" {{ old('fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                                        <option value="fppsi" {{ old('fakultas') == 'fppsi' ? 'selected' : '' }}>FPPsi</option>
                                        <option value="fbs" {{ old('fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                                        <option value="ft" {{ old('fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                                        <option value="fik" {{ old('fakultas') == 'fik' ? 'selected' : '' }}>FIK</option>
                                        <option value="fis" {{ old('fakultas') == 'fis' ? 'selected' : '' }}>FIS</option>
                                        <option value="fe" {{ old('fe') == 'fe' ? 'selected' : '' }}>FE</option>
                                        <option value="profesi" {{ old('fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Faculty where lecturer teaches</p>
                                    @error('fakultas')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">
                                        Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="prodi" 
                                            id="prodi" 
                                            required
                                            disabled
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('prodi') border-red-500 @enderror">
                                        <option value="">Select Program Studi</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Select fakultas first, then choose study program</p>
                                    @error('prodi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Expertise Field -->
                            <div>
                                <label for="bidang_keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                                    Field of Expertise <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="bidang_keahlian" 
                                       id="bidang_keahlian" 
                                       value="{{ old('bidang_keahlian') }}"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bidang_keahlian') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Area of academic specialization</p>
                                @error('bidang_keahlian')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Employment Status -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500">Employment Status</h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Employment Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" 
                                        id="status" 
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                    <option value="">Select Status</option>
                                    <option value="fulltime" {{ old('status') == 'fulltime' ? 'selected' : '' }}>Full Time</option>
                                    <option value="parttime" {{ old('status') == 'parttime' ? 'selected' : '' }}>Part Time</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Employment classification at UNJ</p>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.international-lecture.index') }}" 
                           class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                            <i class='bx bx-x text-lg mr-1'></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                            <i class='bx bx-save text-lg mr-1'></i>
                            Save Lecturer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
