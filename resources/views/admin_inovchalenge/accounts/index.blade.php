@extends('admin_inovchalenge.index')

@section('contentadmin_inovchalenge')
    <div class="space-y-6" x-data="{ viewMode: 'card' }">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl p-6 shadow-xl text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users-cog text-teal-400"></i>
                        </div>
                        Manajemen Akun
                    </h1>
                    <p class="text-gray-400 text-sm mt-2 ml-[52px]">Kelola semua akun terkait Subdirektorat Inovasi</p>
                </div>
                <a href="{{ route('admin_inovchalenge.accounts.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-teal-500 text-white rounded-xl text-sm font-semibold hover:bg-teal-400 transition shadow-lg shadow-teal-500/25">
                    <i class="fas fa-plus mr-2"></i> Tambah Akun
                </a>
            </div>

            {{-- Stats bar --}}
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mt-6 ml-[52px]">
                <div class="bg-white/5 backdrop-blur rounded-xl px-4 py-3 border border-white/10">
                    <p class="text-2xl font-bold text-white">{{ $roleCounts->sum() }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Akun</p>
                </div>
                @foreach (['dosen' => 'Dosen', 'alumni' => 'Alumni', 'reviewer_inovchalenge' => 'Reviewer IC', 'validator' => 'Rev. Katsinov'] as $rk => $rl)
                    <div class="bg-white/5 backdrop-blur rounded-xl px-4 py-3 border border-white/10">
                        <p class="text-2xl font-bold text-white">{{ $roleCounts[$rk] ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $rl }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                {{-- Role Filter Chips --}}
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin_inovchalenge.accounts.index', request()->only('search')) }}"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition border
                          {{ !request('role') ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">
                        Semua <span class="ml-1 opacity-60">{{ $roleCounts->sum() }}</span>
                    </a>
                    @foreach ($roleLabels as $roleKey => $label)
                        <a href="{{ route('admin_inovchalenge.accounts.index', array_merge(request()->only('search'), ['role' => $roleKey])) }}"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition border
                              {{ request('role') === $roleKey ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">
                            {{ $label }} <span class="ml-1 opacity-60">{{ $roleCounts[$roleKey] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Search + View Toggle --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <form action="{{ route('admin_inovchalenge.accounts.index') }}" method="GET" class="flex gap-2">
                        @if (request('role'))
                            <input type="hidden" name="role" value="{{ request('role') }}">
                        @endif
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-56 pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Cari nama / email...">
                        </div>
                        <button type="submit"
                            class="px-3.5 py-2 bg-gray-900 text-white rounded-lg text-sm hover:bg-gray-800 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div class="flex border border-gray-200 rounded-lg overflow-hidden ml-1">
                        <button @click="viewMode = 'card'" class="px-3 py-2 text-sm transition"
                            :class="viewMode === 'card' ? 'bg-gray-900 text-white' :
                                'bg-white text-gray-500 hover:bg-gray-50'">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button @click="viewMode = 'table'" class="px-3 py-2 text-sm transition"
                            :class="viewMode === 'table' ? 'bg-gray-900 text-white' :
                                'bg-white text-gray-500 hover:bg-gray-50'">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════ CARD VIEW ═══════ --}}
        <div x-show="viewMode === 'card'" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($users as $user)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-gray-200 transition-all duration-300 overflow-hidden group">
                    {{-- Card Top Accent --}}
                    <div class="h-1.5 {{ $roleColors[$user->role] ?? 'bg-gray-200' }}"></div>

                    <div class="p-5">
                        {{-- Avatar + Info --}}
                        <div class="flex items-start gap-4">
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
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow border border-gray-200"
                                        title="Login via Google">
                                        <i class="fab fa-google text-[10px] text-red-500"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-bold text-gray-900 truncate">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ $user->email }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        <i class="fas {{ $roleIcons[$user->role] ?? 'fa-user' }} mr-1 text-[9px]"></i>
                                        {{ $roleLabels[$user->role] ?? $user->role }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="flex items-center gap-4 mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                            <span><i class="far fa-calendar mr-1"></i> {{ $user->created_at->format('d M Y') }}</span>
                            @if ($user->google_id)
                                <span class="text-red-400"><i class="fab fa-google mr-1"></i> Google</span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                            <a href="{{ route('admin_inovchalenge.accounts.edit', $user) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-teal-50 hover:text-teal-700 transition">
                                <i class="fas fa-pen mr-1.5"></i> Edit
                            </a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin_inovchalenge.accounts.destroy', $user) }}" method="POST"
                                    class="flex-1"
                                    onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-red-50 hover:text-red-600 transition">
                                        <i class="fas fa-trash-alt mr-1.5"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <span
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-50 text-gray-300 rounded-lg text-xs font-semibold cursor-not-allowed">
                                    <i class="fas fa-lock mr-1.5"></i> Anda
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fas fa-users text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-medium">Belum ada akun terdaftar</p>
                    <p class="text-gray-300 text-sm mt-1">Klik "Tambah Akun" untuk membuat akun baru</p>
                </div>
            @endforelse
        </div>

        {{-- ═══════ TABLE VIEW ═══════ --}}
        <div x-show="viewMode === 'table'" x-transition
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                Pengguna</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                Login</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                Terdaftar</th>
                            <th class="px-6 py-4 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex-shrink-0">
                                            @if ($user->avatar)
                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                    class="w-10 h-10 rounded-xl object-cover shadow-sm">
                                            @else
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-sm"
                                                    style="background: linear-gradient(135deg, #277177, #1d5559);">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            @if ($user->google_id)
                                                <div
                                                    class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-white rounded-full flex items-center justify-center shadow border border-gray-200">
                                                    <i class="fab fa-google text-[8px] text-red-500"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->name }}
                                            </p>
                                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider border {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        <i class="fas {{ $roleIcons[$user->role] ?? 'fa-user' }} mr-1.5 text-[9px]"></i>
                                        {{ $roleLabels[$user->role] ?? $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->google_id)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-red-50 text-red-600 border border-red-100">
                                            <i class="fab fa-google mr-1"></i> Google
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">Email/Password</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin_inovchalenge.accounts.edit', $user) }}"
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 hover:text-teal-600 hover:bg-teal-50 transition"
                                            title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin_inovchalenge.accounts.destroy', $user) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div
                                        class="w-16 h-16 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-400 font-medium">Belum ada akun terdaftar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        {{-- Pagination for card view --}}
        <div x-show="viewMode === 'card'">
            @if ($users->hasPages())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
