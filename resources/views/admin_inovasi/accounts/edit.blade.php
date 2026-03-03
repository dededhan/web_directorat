@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin_inovasi.accounts.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Akun</h1>
                <p class="text-gray-500 text-sm mt-1">Perbarui informasi akun <span
                        class="font-semibold text-gray-700">{{ $user->name }}</span></p>
            </div>
        </div>

        {{-- User Info Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="relative flex-shrink-0">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                            class="w-14 h-14 rounded-xl object-cover shadow-sm">
                    @else
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-sm"
                            style="background: linear-gradient(135deg, #277177, #1d5559);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    @if ($user->google_id)
                        <div
                            class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow border border-gray-200">
                            <i class="fab fa-google text-[10px] text-red-500"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-1.5">
                        @if ($user->google_id)
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-red-50 text-red-600 border border-red-100">
                                <i class="fab fa-google mr-1"></i> Google Account
                            </span>
                        @endif
                        <span class="text-[10px] text-gray-400">Terdaftar {{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin_inovasi.accounts.update', $user) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="contoh@email.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Password
                        <span class="text-gray-400 font-normal text-xs ml-1">(opsional)</span>
                    </label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Kosongkan jika tidak ingin mengubah password">
                    <p class="text-gray-400 text-xs mt-1">Minimal 8 karakter. Biarkan kosong untuk mempertahankan password
                        saat ini.</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                    <select id="role" name="role"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roleLabels as $roleKey => $label)
                            <option value="{{ $roleKey }}"
                                {{ old('role', $user->role) === $roleKey ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin_inovasi.accounts.index') }}"
                        class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 transition shadow">
                        <i class="fas fa-save mr-1"></i> Perbarui Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
