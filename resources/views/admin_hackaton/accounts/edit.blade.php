@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="max-w-xl space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6">
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                <a href="{{ route('admin_hackaton.accounts.index') }}" class="hover:underline">Admin Hackaton / Pengguna</a> / Edit
            </p>
            <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Edit Akun: {{ $user->name }}</h1>
            <p class="mt-2 text-base text-gray-700">Perbarui informasi profil atau ubah role akses pengguna.</p>
        </div>

        <form action="{{ route('admin_hackaton.accounts.update', $user) }}" method="POST" class="border-2 border-gray-950 bg-white p-6 sm:p-8 space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-900 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:bg-amber-50 focus:outline-none">
                @error('name') <p class="text-rose-600 font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-900 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:bg-amber-50 focus:outline-none">
                @error('email') <p class="text-rose-600 font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-900 mb-1">Role Akun *</label>
                <select name="role" required class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white font-bold">
                    @foreach ($roleLabels as $rKey => $rLabel)
                        <option value="{{ $rKey }}" {{ old('role', $user->role) === $rKey ? 'selected' : '' }}>{{ $rLabel }} ({{ $rKey }})</option>
                    @endforeach
                </select>
                @error('role') <p class="text-rose-600 font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-900 mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password"
                    class="w-full border-2 border-gray-950 px-3 py-2 text-sm bg-white focus:bg-amber-50 focus:outline-none"
                    placeholder="Minimal 8 karakter...">
                @error('password') <p class="text-rose-600 font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="border-t-2 border-gray-950 pt-4 flex items-center justify-between">
                <a href="{{ route('admin_hackaton.accounts.index') }}" class="font-bold uppercase text-gray-600 hover:text-black">Batal</a>
                <button type="submit" class="bg-gray-950 text-white px-5 py-2.5 font-bold uppercase tracking-wider hover:bg-gray-800">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
