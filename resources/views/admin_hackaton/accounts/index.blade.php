@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">Admin Hackaton / Pengguna</p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Kelola Akun Hackaton</h1>
                <p class="mt-2 text-base text-gray-700">Daftar pengguna terdaftar pada program Hackaton (Dosen, Tendik, Mahasiswa, DUDI, Alumni, Reviewer, Admin).</p>
            </div>

            <a href="{{ route('admin_hackaton.accounts.create') }}" class="inline-flex items-center justify-center bg-gray-950 px-5 py-3 text-sm font-bold uppercase tracking-wider text-white hover:bg-gray-800 transition">
                <i class="fas fa-user-plus mr-2 text-xs"></i> Tambah Akun
            </a>
        </div>

        {{-- Role Filter Pills --}}
        <div class="flex flex-wrap gap-2 border-2 border-gray-950 bg-white p-4">
            <a href="{{ route('admin_hackaton.accounts.index') }}"
                class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider {{ !request('role') ? 'bg-gray-950 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua ({{ $users->total() }})
            </a>
            @foreach ($roleLabels as $rKey => $rLabel)
                <a href="{{ route('admin_hackaton.accounts.index', ['role' => $rKey, 'search' => request('search')]) }}"
                    class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider {{ request('role') === $rKey ? 'bg-gray-950 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $rLabel }}
                    @if (isset($roleCounts[$rKey]))
                        <span class="ml-1 text-[10px] opacity-75">({{ $roleCounts[$rKey] }})</span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Search Form --}}
        <div class="border-2 border-gray-950 bg-white p-4">
            <form method="GET" action="{{ route('admin_hackaton.accounts.index') }}" class="flex gap-2">
                @if (request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..."
                    class="flex-1 border-2 border-gray-950 px-4 py-2 text-sm focus:bg-amber-50 focus:outline-none">
                <button type="submit" class="bg-gray-950 text-white px-5 py-2 text-xs font-bold uppercase tracking-wider">
                    Cari
                </button>
            </form>
        </div>

        {{-- Accounts Table --}}
        <div class="border-2 border-gray-950 bg-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-950 bg-gray-100 text-xs uppercase tracking-wider text-gray-700">
                            <th class="p-4 w-12 text-center">#</th>
                            <th class="p-4">Nama Lengkap</th>
                            <th class="p-4">Email</th>
                            <th class="p-4 text-center">Role Hackaton</th>
                            <th class="p-4">Fakultas / Institusi</th>
                            <th class="p-4 text-center">Terdaftar</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($users as $u)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center font-bold text-gray-500">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </td>
                                <td class="p-4 font-bold text-gray-950">
                                    {{ $u->name }}
                                </td>
                                <td class="p-4 text-gray-600 text-xs font-medium">
                                    {{ $u->email }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold border {{ $roleColors[$u->role] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $roleLabels[$u->role] ?? ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td class="p-4 text-xs text-gray-600">
                                    {{ $u->profile?->fakultas?->name ?? ($u->profile?->institusi ?? '-') }}
                                </td>
                                <td class="p-4 text-center text-xs text-gray-500">
                                    {{ $u->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin_hackaton.accounts.edit', $u) }}" class="p-2 text-xs font-bold text-gray-700 hover:text-black border border-gray-300 bg-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if ($u->id !== auth()->id())
                                            <form action="{{ route('admin_hackaton.accounts.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 bg-white" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 italic">
                                    Tidak ada data akun yang sesuai kriteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="p-4 border-t-2 border-gray-950 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
