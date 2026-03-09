@extends('admin_inovchalenge.index')

@section('contentadmin_inovchalenge')
    <div class="space-y-6">
        {{-- Welcome Header --}}
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-trophy text-3xl text-yellow-300"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Innovation Challenge Panel</h1>
                    <p class="text-teal-100 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            {{-- Total Sesi --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalSessions'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total Sesi</p>
                    </div>
                </div>
            </div>

            {{-- Sesi Aktif --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-play-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['activeSessions'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Sesi Aktif</p>
                    </div>
                </div>
            </div>

            {{-- Total Submission --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalSubmissions'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total Submission</p>
                    </div>
                </div>
            </div>

            {{-- Pending Registrations --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-clock text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pendingRegistrations'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Pending Registrasi</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-bolt text-yellow-500 mr-2"></i>Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.create') }}"
                   class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-teal-300 hover:bg-teal-50 transition group">
                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center group-hover:bg-teal-200 transition">
                        <i class="fas fa-plus text-teal-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Buat Sesi Baru</p>
                        <p class="text-xs text-gray-400">Buat sesi innovation challenge</p>
                    </div>
                </a>

                <a href="{{ route('admin_inovchalenge.accounts.create') }}"
                   class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition group">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Tambah Akun</p>
                        <p class="text-xs text-gray-400">Buat akun pengguna baru</p>
                    </div>
                </a>

                <a href="{{ route('admin_inovchalenge.accounts.registrations') }}"
                   class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition group">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition">
                        <i class="fas fa-user-check text-orange-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Pendaftaran</p>
                        <p class="text-xs text-gray-400">Review pendaftaran akun</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
