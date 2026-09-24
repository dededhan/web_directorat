@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="p-6 max-w-4xl mx-auto space-y-6">
    {{-- Breadcrumb & Header --}}
    <div>
        <nav class="flex text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
            <a href="{{ route('admin_pemeringkatan.responden-bank.index') }}" class="hover:text-teal-600 transition">
                Responden Bank
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">Tambah Responden</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-user-plus text-teal-600"></i>
            Tambah Responden ke Bank Induk
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Daftarkan responden secara manual. Email wajib unik di seluruh sistem.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-sm font-semibold text-red-800">Terdapat kesalahan pada isian form:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin_pemeringkatan.responden-bank.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Personal Info Section --}}
            <div>
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3 pb-1 border-b border-gray-100 flex items-center gap-2">
                    <i class="fas fa-id-card text-teal-600"></i> Identitas Personal
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    {{-- Title --}}
                    <div class="md:col-span-1">
                        <label for="title" class="block text-xs font-semibold text-gray-700 mb-1">Title</label>
                        <select name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">—</option>
                            <option value="Mr." {{ old('title') === 'Mr.' ? 'selected' : '' }}>Mr.</option>
                            <option value="Mrs." {{ old('title') === 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                            <option value="Ms." {{ old('title') === 'Ms.' ? 'selected' : '' }}>Ms.</option>
                            <option value="Dr." {{ old('title') === 'Dr.' ? 'selected' : '' }}>Dr.</option>
                            <option value="Prof." {{ old('title') === 'Prof.' ? 'selected' : '' }}>Prof.</option>
                        </select>
                    </div>

                    {{-- First Name --}}
                    <div class="md:col-span-3">
                        <label for="first_name" class="block text-xs font-semibold text-gray-700 mb-1">
                            Nama Depan / Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" required
                               value="{{ old('first_name') }}"
                               placeholder="Nama depan / lengkap"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    {{-- Last Name --}}
                    <div class="md:col-span-2">
                        <label for="last_name" class="block text-xs font-semibold text-gray-700 mb-1">Nama Belakang</label>
                        <input type="text" name="last_name" id="last_name"
                               value="{{ old('last_name') }}"
                               placeholder="Nama belakang (opsional)"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">
                            Alamat Email (Unik) <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email') }}"
                               placeholder="nama@institusi.ac.id"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <p class="text-[11px] text-gray-400 mt-1">Digunakan untuk pengiriman link consent dan deduplikasi.</p>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone') }}"
                               placeholder="+62 812 3456 7890"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
            </div>

            {{-- Professional & Institutional Section --}}
            <div class="pt-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3 pb-1 border-b border-gray-100 flex items-center gap-2">
                    <i class="fas fa-building text-teal-600"></i> Institusi & Pekerjaan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Category --}}
                    <div>
                        <label for="category" class="block text-xs font-semibold text-gray-700 mb-1">
                            Kategori Responden
                        </label>
                        <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">— Pilih Kategori —</option>
                            <option value="academic" {{ old('category') === 'academic' ? 'selected' : '' }}>Academic (Akademisi / Peneliti)</option>
                            <option value="employee" {{ old('category') === 'employee' ? 'selected' : '' }}>Employer (Pengguna Lulusan / Industri)</option>
                        </select>
                    </div>

                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-xs font-semibold text-gray-700 mb-1">Negara</label>
                        <input type="text" name="country" id="country"
                               value="{{ old('country', 'Indonesia') }}"
                               placeholder="Indonesia"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    {{-- Institution --}}
                    <div>
                        <label for="institution" class="block text-xs font-semibold text-gray-700 mb-1">Nama Universitas / Institusi</label>
                        <input type="text" name="institution" id="institution"
                               value="{{ old('institution') }}"
                               placeholder="Contoh: Universitas Gadjah Mada"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    {{-- Company Name --}}
                    <div>
                        <label for="company_name" class="block text-xs font-semibold text-gray-700 mb-1">Nama Perusahaan (Bila Employer)</label>
                        <input type="text" name="company_name" id="company_name"
                               value="{{ old('company_name') }}"
                               placeholder="Contoh: PT Telekomunikasi Indonesia"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    {{-- Department --}}
                    <div>
                        <label for="department" class="block text-xs font-semibold text-gray-700 mb-1">Fakultas / Departemen</label>
                        <input type="text" name="department" id="department"
                               value="{{ old('department') }}"
                               placeholder="Contoh: Fakultas Ilmu Pendidikan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    {{-- Job Title / Position --}}
                    <div>
                        <label for="job_title" class="block text-xs font-semibold text-gray-700 mb-1">Jabatan / Posisi</label>
                        <input type="text" name="job_title" id="job_title"
                               value="{{ old('job_title') }}"
                               placeholder="Contoh: Senior Researcher / HR Manager"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin_pemeringkatan.responden-bank.index') }}" 
                   class="px-5 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium rounded-lg transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow transition">
                    <i class="fas fa-check mr-2"></i>
                    Simpan ke Bank
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
