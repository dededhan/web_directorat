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
                                @if ($role !== 'dudi')
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
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
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
