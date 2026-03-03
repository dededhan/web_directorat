<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ $roleLabel }} | Innovation Challenge</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div x-data="{ sidebarOpen: true, mobileOpen: false, activeTab: 'biodata' }" class="flex h-screen bg-gray-100">

        {{-- Sidebar --}}
        <aside class="flex-shrink-0 w-64 bg-gray-800 text-gray-300 flex flex-col transition-all duration-300"
            :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-transition x-cloak>

            {{-- Sidebar Header --}}
            <div class="h-16 flex items-center justify-center bg-gray-900 shadow-md">
                @php
                    $roleIcons = [
                        'alumni' => 'fa-user-graduate',
                        'peneliti' => 'fa-microscope',
                        'dudi' => 'fa-building',
                        'pppk' => 'fa-user-tie',
                        'mahasiswa' => 'fa-graduation-cap',
                    ];
                @endphp
                <i class="fas {{ $roleIcons[$role] ?? 'fa-user' }} text-white text-2xl mr-3"></i>
                <span class="text-white text-lg font-semibold">{{ $roleLabel }}</span>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#" @click.prevent="activeTab = 'biodata'"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200"
                    :class="activeTab === 'biodata' ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white'">
                    <i class="fas fa-id-card fa-fw w-6 text-center"></i>
                    <span class="ml-4">Biodata</span>
                </a>

                <a href="#" @click.prevent="activeTab = 'participations'"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200"
                    :class="activeTab === 'participations' ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white'">
                    <i class="fas fa-trophy fa-fw w-6 text-center"></i>
                    <span class="ml-4">Undangan & Partisipasi</span>
                    @if ($participations->where('approval_status', 'pending')->count() > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5">
                            {{ $participations->where('approval_status', 'pending')->count() }}
                        </span>
                    @endif
                </a>

                <a href="#" @click.prevent="activeTab = 'notifications'"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200"
                    :class="activeTab === 'notifications' ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white'">
                    <i class="fas fa-bell fa-fw w-6 text-center"></i>
                    <span class="ml-4">Notifikasi & Riwayat</span>
                    @if (($unreadCount ?? 0) > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </nav>

            {{-- Logout --}}
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-2.5 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200">
                        <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                        <span class="ml-4">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Topbar --}}
            <header class="h-16 bg-white shadow flex items-center justify-between px-6 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ $user->name }}</span>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto max-w-5xl space-y-6">

                    {{-- Welcome --}}
                    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-xl p-6 text-white shadow-lg">
                        <h1 class="text-2xl font-bold">Selamat Datang, {{ $user->name }}!</h1>
                        <p class="text-teal-100 mt-1">Dashboard {{ $roleLabel }} — UNJ Innovative Challenge</p>
                    </div>

                    {{-- ========== BIODATA TAB ========== --}}
                    <div x-show="activeTab === 'biodata'" x-cloak>

                        {{-- Biodata Card --}}
                        <div class="bg-white rounded-xl shadow border border-gray-100 p-6" x-data="{ editing: false }">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-bold text-gray-800">
                                    <i class="fas fa-id-card mr-2 text-teal-600"></i> Lengkapi Biodata Pribadi
                                </h2>
                                <button @click="editing = !editing"
                                    class="text-sm text-teal-600 hover:text-teal-800 font-semibold transition">
                                    <i class="fas" :class="editing ? 'fa-times' : 'fa-edit'"></i>
                                    <span x-text="editing ? 'Batal' : 'Edit'"></span>
                                </button>
                            </div>

                            @if (!$user->profile || !$user->profile->identifier_number)
                                <div
                                    class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-sm text-amber-700">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <strong>Biodata belum lengkap.</strong> Silakan lengkapi biodata Anda agar dapat
                                    berpartisipasi di Innovation Challenge.
                                </div>
                            @endif

                            {{-- View mode --}}
                            <div x-show="!editing" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Nama</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Email</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">NIM / NIP / NIK</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">
                                        {{ $user->profile?->identifier_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Role</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-teal-100 text-teal-800">
                                            {{ $roleLabel }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Alamat</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">
                                        {{ $user->profile?->alamat ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Kode Pos</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">
                                        {{ $user->profile?->kode_pos ?? '-' }}</p>
                                </div>
                                @if ($role === 'dudi')
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Institusi</p>
                                        <p class="text-sm font-medium text-gray-800 mt-1">
                                            {{ $user->profile?->institusi ?? '-' }}</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Fakultas</p>
                                        <p class="text-sm font-medium text-gray-800 mt-1">
                                            {{ $user->profile?->fakultas?->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Program Studi</p>
                                        <p class="text-sm font-medium text-gray-800 mt-1">
                                            {{ $user->profile?->prodi?->name ?? '-' }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Terdaftar Sejak</p>
                                    <p class="text-sm font-medium text-gray-800 mt-1">
                                        {{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            {{-- Edit mode --}}
                            <div x-show="editing" x-cloak>
                                <form action="{{ route('inovchalenge.role.profile.update') }}" method="POST"
                                    x-data="{
                                        selectedFakultasId: '{{ $user->profile?->fakultas_id ?? '' }}',
                                        allProdi: @js($prodiList),
                                        get filteredProdi() {
                                            if (!this.selectedFakultasId) return this.allProdi;
                                            return this.allProdi.filter(p => p.fakultas_id == this.selectedFakultasId);
                                        }
                                    }" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        {{-- Nama --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                required>
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- NIM/NIP/NIK --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">NIM / NIP /
                                                NIK <span class="text-red-500">*</span></label>
                                            <input type="text" name="identifier_number"
                                                value="{{ old('identifier_number', $user->profile?->identifier_number) }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                required>
                                            @error('identifier_number')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Alamat --}}
                                        <div class="sm:col-span-2">
                                            <label
                                                class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                                            <textarea name="alamat" rows="2"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('alamat', $user->profile?->alamat) }}</textarea>
                                            @error('alamat')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Kode Pos --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kode
                                                Pos</label>
                                            <input type="text" name="kode_pos"
                                                value="{{ old('kode_pos', $user->profile?->kode_pos) }}"
                                                maxlength="10"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            @error('kode_pos')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Institusi (DUDI only) --}}
                                        @if ($role === 'dudi')
                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Institusi
                                                    <span class="text-red-500">*</span></label>
                                                <input type="text" name="institusi"
                                                    value="{{ old('institusi', $user->profile?->institusi) }}"
                                                    placeholder="Nama perusahaan / organisasi"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    required>
                                                @error('institusi')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif

                                        {{-- Fakultas --}}
                                        <div>
                                            <label
                                                class="block text-sm font-semibold text-gray-700 mb-1">Fakultas</label>
                                            <select name="fakultas_id" x-model="selectedFakultasId"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                                <option value="">-- Pilih Fakultas --</option>
                                                @foreach ($fakultasList as $fak)
                                                    <option value="{{ $fak->id }}"
                                                        {{ old('fakultas_id', $user->profile?->fakultas_id) == $fak->id ? 'selected' : '' }}>
                                                        {{ $fak->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fakultas_id')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Program Studi (hidden for DUDI) --}}
                                        @if ($role !== 'dudi')
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Program
                                                    Studi</label>
                                                <select name="prodi_id"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="">-- Pilih Prodi --</option>
                                                    <template x-for="p in filteredProdi" :key="p.id">
                                                        <option :value="p.id" x-text="p.name"
                                                            :selected="p.id == {{ $user->profile?->prodi_id ?? 0 }}">
                                                        </option>
                                                    </template>
                                                </select>
                                                @error('prodi_id')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex justify-end pt-2">
                                        <button type="submit"
                                            class="px-5 py-2.5 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 transition shadow">
                                            <i class="fas fa-save mr-1"></i> Simpan Biodata
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ========== PARTICIPATIONS TAB ========== --}}
                    <div x-show="activeTab === 'participations'" x-cloak>

                        {{-- Pending Invitations --}}
                        @php
                            $pending = $participations->where('approval_status', 'pending');
                            $approved = $participations->where('approval_status', 'approved');
                            $rejected = $participations->where('approval_status', 'rejected');
                        @endphp

                        {{-- Pending Section --}}
                        @if ($pending->count() > 0)
                            <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
                                <h2 class="text-lg font-bold text-gray-800 mb-4">
                                    <i class="fas fa-envelope mr-2 text-amber-500"></i> Undangan Menunggu Respon
                                    <span
                                        class="ml-2 bg-amber-100 text-amber-700 text-xs rounded-full px-2 py-0.5">{{ $pending->count() }}</span>
                                </h2>
                                <div class="space-y-3">
                                    @foreach ($pending as $p)
                                        <div class="p-4 rounded-lg border-2 border-amber-200 bg-amber-50">
                                            <div
                                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-bold text-gray-800">
                                                        {{ $p->submission->session->name ?? ($p->submission->session->nama_sesi ?? 'Sesi tidak ditemukan') }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500 mt-0.5">
                                                        <i class="fas fa-user mr-1"></i> Diundang oleh: <span
                                                            class="font-semibold">{{ $p->submission->user->name ?? '-' }}</span>
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-0.5">
                                                        Sebagai: <span
                                                            class="font-semibold">{{ ucfirst($p->tipe_anggota ?? $role) }}</span>
                                                        &middot; {{ $p->created_at->format('d M Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="flex gap-2 flex-shrink-0">
                                                    <form method="POST"
                                                        action="{{ route('inovchalenge.role.invitations.approve', $p) }}">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition shadow-sm">
                                                            <i class="fas fa-check mr-1.5"></i> Terima
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('inovchalenge.role.invitations.reject', $p) }}"
                                                        onsubmit="return confirm('Tolak undangan ini?')">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition shadow-sm">
                                                            <i class="fas fa-times mr-1.5"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Approved / Active Participations with Team Tracking --}}
                        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-trophy mr-2 text-green-500"></i> Partisipasi Aktif
                            </h2>

                            @if ($approved->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($approved as $p)
                                        <div class="rounded-lg border border-green-200 overflow-hidden"
                                            x-data="{ showTeam: false }">
                                            <div class="p-4 bg-green-50 flex items-center justify-between cursor-pointer"
                                                @click="showTeam = !showTeam">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-bold text-gray-800">
                                                        {{ $p->submission->session->name ?? ($p->submission->session->nama_sesi ?? 'Sesi') }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500 mt-0.5">
                                                        <i class="fas fa-user mr-1"></i> Ketua:
                                                        {{ $p->submission->user->name ?? '-' }}
                                                        &middot; Sebagai: <span
                                                            class="font-semibold">{{ ucfirst($p->tipe_anggota ?? $role) }}</span>
                                                    </p>
                                                    @if ($p->responded_at)
                                                        <p class="text-xs text-gray-400 mt-0.5">Diterima
                                                            {{ $p->responded_at->format('d M Y H:i') }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                                                    <a href="{{ route('inovchalenge.role.submissions.show', $p->submission) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition shadow-sm">
                                                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                                                    </a>
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                        Disetujui
                                                    </span>
                                                    <i class="fas fa-chevron-down text-gray-400 transition-transform"
                                                        :class="{ 'rotate-180': showTeam }"></i>
                                                </div>
                                            </div>
                                            {{-- Team Member Tracking --}}
                                            <div x-show="showTeam" x-collapse x-cloak
                                                class="border-t border-green-200 p-4 bg-white">
                                                <h5
                                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                                                    <i class="fas fa-users mr-1"></i> Anggota Tim
                                                </h5>
                                                @if ($p->submission->members && $p->submission->members->count() > 0)
                                                    <div class="space-y-2">
                                                        @foreach ($p->submission->members as $member)
                                                            @php
                                                                $mStatusColors = [
                                                                    'pending' => 'bg-amber-100 text-amber-700',
                                                                    'approved' => 'bg-green-100 text-green-700',
                                                                    'rejected' => 'bg-red-100 text-red-700',
                                                                ];
                                                            @endphp
                                                            <div
                                                                class="flex items-center justify-between py-2 px-3 rounded-lg bg-gray-50">
                                                                <div>
                                                                    <span
                                                                        class="text-sm font-medium text-gray-800">{{ $member->nama_lengkap }}</span>
                                                                    <span
                                                                        class="text-xs text-gray-400 ml-2">({{ ucfirst($member->tipe_anggota) }}
                                                                        - {{ $member->peran }})</span>
                                                                </div>
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $mStatusColors[$member->approval_status] ?? 'bg-gray-100 text-gray-600' }}">
                                                                    {{ ucfirst($member->approval_status ?? 'N/A') }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-400">Belum ada anggota tim.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <i class="fas fa-clipboard-check text-gray-300 text-3xl mb-2"></i>
                                    <p class="text-gray-400 text-sm">Belum ada partisipasi aktif.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Rejected --}}
                        @if ($rejected->count() > 0)
                            <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
                                <h2 class="text-lg font-bold text-gray-800 mb-4">
                                    <i class="fas fa-times-circle mr-2 text-red-400"></i> Undangan Ditolak
                                </h2>
                                <div class="space-y-3">
                                    @foreach ($rejected as $p)
                                        <div
                                            class="flex items-center justify-between p-4 rounded-lg border border-red-100 bg-red-50">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-bold text-gray-800">
                                                    {{ $p->submission->session->name ?? ($p->submission->session->nama_sesi ?? 'Sesi') }}
                                                </h4>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    Ketua: {{ $p->submission->user->name ?? '-' }}
                                                </p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Empty state if no participations at all --}}
                        @if ($participations->count() === 0)
                            <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                    <p class="text-gray-400 font-medium">Belum ada partisipasi</p>
                                    <p class="text-gray-400 text-sm mt-1">Anda akan muncul di sini ketika dosen
                                        mengundang Anda ke tim proposal.</p>
                                </div>
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700 mt-6">
                            <p class="font-semibold mb-1"><i class="fas fa-info-circle mr-1"></i> Cara Berpartisipasi
                            </p>
                            <p>Partisipasi di Innovation Challenge dimulai ketika seorang dosen (sebagai ketua tim)
                                menambahkan Anda sebagai anggota tim proposal. Anda akan menerima undangan yang bisa
                                Anda terima atau tolak.</p>
                        </div>
                    </div>

                    {{-- ========== NOTIFICATIONS & STATUS HISTORY TAB ========== --}}
                    <div x-show="activeTab === 'notifications'" x-cloak>

                        {{-- Progress Overview per Submission --}}
                        @php
                            $approvedParticipations = $participations->where('approval_status', 'approved');
                        @endphp

                        @if ($approvedParticipations->count() > 0)
                            <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
                                <h2 class="text-lg font-bold text-gray-800 mb-4">
                                    <i class="fas fa-tasks mr-2 text-indigo-500"></i> Progress Submission
                                </h2>
                                <div class="space-y-4">
                                    @foreach ($approvedParticipations as $p)
                                        @php
                                            $sub = $p->submission;
                                            $session = $sub->session ?? null;
                                            $tahaps = $sub->submissionTahap ?? collect();
                                            $totalTahaps = $tahaps->count();
                                            $completedTahaps = $tahaps->where('status', 'diajukan')->count();
                                            $approvedTahaps = $tahaps->where('admin_status', 'disetujui')->count();
                                            $progressPercent =
                                                $totalTahaps > 0 ? round(($approvedTahaps / $totalTahaps) * 100) : 0;

                                            $overallStatusColors = [
                                                'draft' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                'diajukan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'menunggu_direview' =>
                                                    'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                'sedang_direview' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'perbaikan_diperlukan' =>
                                                    'bg-orange-100 text-orange-700 border-orange-200',
                                                'proses_tahap_selanjutnya' =>
                                                    'bg-cyan-100 text-cyan-700 border-cyan-200',
                                                'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                            ];
                                            $statusValue =
                                                $sub->status instanceof \App\Enums\InovChalengeStatusEnum
                                                    ? $sub->status->value
                                                    : $sub->status ?? 'draft';
                                            $overallColor =
                                                $overallStatusColors[$statusValue] ??
                                                'bg-gray-100 text-gray-600 border-gray-200';
                                        @endphp
                                        <div class="rounded-xl border border-gray-200 overflow-hidden"
                                            x-data="{ open: false }">
                                            <div class="p-4 bg-gradient-to-r from-gray-50 to-white cursor-pointer hover:bg-gray-50 transition"
                                                @click="open = !open">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1 min-w-0">
                                                        <h4 class="text-sm font-bold text-gray-800 truncate">
                                                            {{ $session->name ?? ($session->nama_sesi ?? 'Sesi') }}
                                                        </h4>
                                                        <p class="text-xs text-gray-500 mt-0.5">
                                                            <i class="fas fa-user mr-1"></i> Ketua:
                                                            {{ $sub->user->name ?? '-' }}
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $overallColor }}">
                                                            {{ $sub->status instanceof \App\Enums\InovChalengeStatusEnum ? $sub->status->label() : ucwords(str_replace('_', ' ', $sub->status ?? 'draft')) }}
                                                        </span>
                                                        <i class="fas fa-chevron-down text-gray-400 transition-transform text-xs"
                                                            :class="{ 'rotate-180': open }"></i>
                                                    </div>
                                                </div>

                                                {{-- Progress bar --}}
                                                @if ($totalTahaps > 0)
                                                    <div class="mt-3">
                                                        <div
                                                            class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                                            <span>Tahap {{ $approvedTahaps }}/{{ $totalTahaps }}
                                                                disetujui</span>
                                                            <span class="font-semibold">{{ $progressPercent }}%</span>
                                                        </div>
                                                        <div
                                                            class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                                            <div class="h-full rounded-full transition-all duration-500 {{ $progressPercent >= 100 ? 'bg-green-500' : ($progressPercent >= 50 ? 'bg-teal-500' : 'bg-blue-500') }}"
                                                                style="width: {{ $progressPercent }}%"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Tahap detail --}}
                                            <div x-show="open" x-collapse x-cloak
                                                class="border-t border-gray-100 p-4 bg-gray-50">
                                                @if ($totalTahaps > 0)
                                                    <h5
                                                        class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                                                        <i class="fas fa-layer-group mr-1"></i> Detail Tahap
                                                    </h5>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                        @foreach ($tahaps->sortBy(fn($t) => $t->tahap->tahap_ke ?? 0) as $tahap)
                                                            @php
                                                                $tDosenColors = [
                                                                    'belum_diisi' => 'bg-gray-100 text-gray-500',
                                                                    'draft' => 'bg-yellow-100 text-yellow-700',
                                                                    'diajukan' => 'bg-blue-100 text-blue-700',
                                                                    'perbaikan' => 'bg-orange-100 text-orange-700',
                                                                ];
                                                                $tAdminColors = [
                                                                    'menunggu' => 'bg-gray-100 text-gray-500',
                                                                    'disetujui' => 'bg-green-100 text-green-700',
                                                                    'perbaikan' => 'bg-orange-100 text-orange-700',
                                                                    'selesai' => 'bg-teal-100 text-teal-700',
                                                                ];
                                                                $dosenColor =
                                                                    $tDosenColors[$tahap->status ?? 'belum_diisi'] ??
                                                                    'bg-gray-100 text-gray-500';
                                                                $adminColor =
                                                                    $tAdminColors[$tahap->admin_status ?? 'menunggu'] ??
                                                                    'bg-gray-100 text-gray-500';
                                                            @endphp
                                                            <div
                                                                class="p-3 rounded-lg bg-white border border-gray-100">
                                                                <div class="flex items-center justify-between mb-2">
                                                                    <span class="text-xs font-bold text-gray-700">
                                                                        <i
                                                                            class="fas fa-flag mr-1 text-indigo-400"></i>
                                                                        Tahap {{ $tahap->tahap->tahap_ke ?? '?' }}
                                                                    </span>
                                                                    @if ($tahap->admin_status === 'disetujui')
                                                                        <i
                                                                            class="fas fa-check-circle text-green-500"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="flex flex-wrap gap-1.5">
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $dosenColor }}">
                                                                        <i class="fas fa-pen mr-1 text-[8px]"></i>
                                                                        {{ ucwords(str_replace('_', ' ', $tahap->status ?? 'belum_diisi')) }}
                                                                    </span>
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $adminColor }}">
                                                                        <i
                                                                            class="fas fa-user-shield mr-1 text-[8px]"></i>
                                                                        {{ ucwords(str_replace('_', ' ', $tahap->admin_status ?? 'menunggu')) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-400 text-center py-4">Belum ada tahap.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Status History Timeline --}}
                        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                <h2 class="text-lg font-bold text-gray-800">
                                    <i class="fas fa-bell mr-2 text-teal-500"></i> Notifikasi & Riwayat Status
                                </h2>
                                @if (($statusLogs ?? collect())->count() > 5)
                                    <span class="text-xs text-gray-400">{{ $statusLogs->count() }} aktivitas</span>
                                @endif
                            </div>
                            <div class="p-6">
                                @if (($statusLogs ?? collect())->count())
                                    <div class="relative">
                                        {{-- Timeline line --}}
                                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                                        <div class="space-y-0">
                                            @foreach ($statusLogs->take(30) as $log)
                                                @php
                                                    $dotColors = [
                                                        'draft' => 'bg-yellow-400',
                                                        'diajukan' => 'bg-blue-500',
                                                        'menunggu' => 'bg-gray-400',
                                                        'menunggu_direview' => 'bg-yellow-500',
                                                        'sedang_direview' => 'bg-purple-500',
                                                        'disetujui' => 'bg-green-500',
                                                        'perbaikan' => 'bg-orange-500',
                                                        'perbaikan_diperlukan' => 'bg-orange-500',
                                                        'selesai' => 'bg-teal-500',
                                                        'proses_tahap_selanjutnya' => 'bg-cyan-500',
                                                        'belum_diisi' => 'bg-gray-300',
                                                    ];
                                                    $dotColor = $dotColors[$log->status_ke] ?? 'bg-gray-400';

                                                    $roleColors = [
                                                        'dosen' => 'text-teal-600',
                                                        'admin' => 'text-indigo-600',
                                                        'system' => 'text-gray-500',
                                                    ];
                                                    $roleColor = $roleColors[$log->causer_role] ?? 'text-gray-500';

                                                    $roleBadge = match ($log->causer_role) {
                                                        'admin' => 'bg-indigo-100 text-indigo-700',
                                                        'dosen' => 'bg-teal-100 text-teal-700',
                                                        default => 'bg-gray-100 text-gray-600',
                                                    };
                                                @endphp
                                                <div class="relative pl-10 pb-5">
                                                    {{-- Dot --}}
                                                    <div
                                                        class="absolute left-2.5 top-1 w-3 h-3 rounded-full {{ $dotColor }} ring-2 ring-white shadow-sm z-10">
                                                    </div>

                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-1">
                                                        <div class="flex-1">
                                                            {{-- Submission context --}}
                                                            <p class="text-[10px] text-gray-400 mb-0.5">
                                                                <i class="fas fa-folder-open mr-1"></i>
                                                                {{ $log->submission->session->name ?? ($log->submission->session->nama_sesi ?? 'Sesi') }}
                                                                &mdash; {{ $log->submission->user->name ?? '' }}
                                                            </p>
                                                            {{-- Status change text --}}
                                                            <p class="text-sm text-gray-800 font-medium leading-snug">
                                                                @if ($log->tipe === 'tahap' && $log->tahap)
                                                                    <span
                                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 mr-1">
                                                                        T{{ $log->tahap->tahap_ke }}
                                                                    </span>
                                                                @endif
                                                                {{ $log->keterangan ?? $log->getStatusLabel($log->status_ke) }}
                                                            </p>

                                                            <div class="flex items-center gap-1.5 mt-1">
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ str_replace('bg-', 'bg-', $dotColor) }} bg-opacity-20 {{ $roleColor }}">
                                                                    <i
                                                                        class="fas {{ $log->getStatusIcon() }} mr-1 text-[8px]"></i>
                                                                    {{ $log->getStatusLabel($log->status_ke) }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        {{-- Timestamp + role --}}
                                                        <div
                                                            class="flex items-center gap-2 flex-shrink-0 mt-1 sm:mt-0">
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $roleBadge }}">
                                                                {{ ucfirst($log->causer_role ?? 'system') }}
                                                            </span>
                                                            <span class="text-[11px] text-gray-400 whitespace-nowrap">
                                                                <i class="far fa-clock mr-0.5"></i>
                                                                {{ $log->created_at->format('d M Y') }}
                                                                <span
                                                                    class="font-semibold">{{ $log->created_at->format('H:i') }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if ($statusLogs->count() > 30)
                                            <div class="pl-10 pt-2 text-xs text-gray-400">
                                                <i class="fas fa-ellipsis-h mr-1"></i>
                                                +{{ $statusLogs->count() - 30 }} aktivitas lainnya
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <div
                                            class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-bell-slash text-xl text-gray-300"></i>
                                        </div>
                                        <p class="text-sm text-gray-400">Belum ada riwayat perubahan status</p>
                                        <p class="text-xs text-gray-400 mt-1">Notifikasi akan muncul setelah Anda
                                            bergabung di tim proposal.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
                            <p class="font-semibold mb-1"><i class="fas fa-info-circle mr-1"></i> Tentang Notifikasi
                            </p>
                            <p>Halaman ini menampilkan riwayat perubahan status dan progress dari submission yang Anda
                                ikuti.
                                Setiap perubahan status tahap (diajukan, disetujui, perbaikan, dll) akan tercatat secara
                                otomatis.</p>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif

</body>

</html>
