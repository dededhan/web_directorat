@extends('admin_equity.index')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <header class="mb-8">
         <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex items-center space-x-2">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.manageuser.index') }}" class="hover:text-teal-600">Manajemen Pengguna</a></li>
                <li><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-medium text-gray-800">Detail Pengguna</li>
            </ol>
        </nav>
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Pengguna</h1>
            <p class="mt-2 text-gray-600">Informasi detail untuk pengguna: {{ $user->name }}</p>
        </div>
    </header>

    {{-- Details Card --}}
    <div class="bg-white rounded-2xl shadow-lg border">
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-5">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class='bx bxs-user-detail text-2xl mr-3'></i>
                Profil Pengguna
            </h2>
        </div>
        
        <div class="p-8">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="border-b pb-4">
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->name }}</dd>
                </div>
                <div class="border-b pb-4">
                    <dt class="text-sm font-medium text-gray-500">Alamat Email</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->email }}</dd>
                </div>
                 <div class="border-b pb-4">
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">
                         @if($user->role == 'dosen')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Dosen</span>
                        @elseif($user->role == 'reviewer_equity')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">Reviewer Equity</span>
                        @elseif($user->role == 'equity_fakultas')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Equity Fakultas</span>
                        @endif
                    </dd>
                </div>
                <div class="border-b pb-4">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->created_at->isoFormat('D MMMM YYYY') }}</dd>
                </div>

                @if($user->role == 'dosen' && $user->profile)
                <div class="md:col-span-2 pt-6 border-t mt-2">
                     <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Profil Dosen</h3>
                     <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="border-b pb-4">
                            <dt class="text-sm font-medium text-gray-500">NIP / NIDN</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->profile->identifier_number ?: '-' }}</dd>
                        </div>
                        <div class="border-b pb-4">
                             <dt class="text-sm font-medium text-gray-500">Fakultas</dt>
                             <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->profile->prodi->fakultas->name ?? '-' }}</dd>
                        </div>
                         <div class="border-b pb-4 md:col-span-2">
                             <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                             <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->profile->prodi->name ?? '-' }}</dd>
                        </div>
                     </dl>
                </div>
                @elseif($user->role == 'equity_fakultas' && $user->profile?->fakultas)
                 <div class="md:col-span-2 pt-6 border-t mt-2">
                     <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Profil Fakultas</h3>
                     <dl class="grid grid-cols-1">
                        <div class="border-b pb-4">
                             <dt class="text-sm font-medium text-gray-500">Fakultas</dt>
                             <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->profile->fakultas->name ?? '-' }}</dd>
                        </div>
                     </dl>
                </div>
                @endif
            </dl>
        </div>

        {{-- Action Buttons --}}
        <div class="bg-gray-50 px-6 py-4 border-t flex items-center justify-end space-x-3 rounded-b-2xl">
             <a href="{{ route('admin_equity.manageuser.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-100">
                <i class='bx bx-arrow-back text-lg mr-2'></i> Kembali
            </a>
            <a href="{{ route('admin_equity.manageuser.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-yellow-600">
                <i class='bx bxs-edit text-lg mr-2'></i> Edit Pengguna
            </a>
        </div>
    </div>
</div>
@endsection
