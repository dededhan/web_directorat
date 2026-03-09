@extends('admin_inovchalenge.index')

@section('contentadmin_inovchalenge')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Akun</h1>
            <p class="text-gray-500 text-sm mt-1">Setujui atau tolak pendaftaran akun dari calon peserta Innovation Challenge
            </p>
        </div>

        {{-- Status Filter Tabs --}}
        <div class="flex gap-2 border-b border-gray-200 pb-0">
            @foreach ([
            '' => ['label' => 'Menunggu', 'icon' => 'fa-clock', 'color' => 'amber'],
            'approved' => ['label' => 'Disetujui', 'icon' => 'fa-check-circle', 'color' => 'green'],
            'declined' => ['label' => 'Ditolak', 'icon' => 'fa-times-circle', 'color' => 'red'],
        ] as $statusKey => $info)
                @php
                    $isActive = request('status', '') === $statusKey;
                @endphp
                <a href="{{ route('admin_inovchalenge.accounts.registrations', ['status' => $statusKey ?: 'pending']) }}"
                    class="relative px-4 py-2.5 text-sm font-semibold transition rounded-t-lg
                      {{ $isActive ? 'bg-white text-teal-700 border border-gray-200 border-b-white -mb-px' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas {{ $info['icon'] }} mr-1"></i> {{ $info['label'] }}
                    @if ($statusKey === '' && $pendingCount > 0)
                        <span
                            class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full bg-red-500 text-white">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Search --}}
        <form action="{{ route('admin_inovchalenge.accounts.registrations') }}" method="GET" class="flex gap-2">
            <input type="hidden" name="status" value="{{ request('status', 'pending') }}">
            <div class="relative flex-1 max-w-md">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    placeholder="Cari nama atau email...">
            </div>
            <button type="submit"
                class="px-4 py-2.5 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-900 transition">
                Cari
            </button>
        </form>

        {{-- Batch Approve (only for pending tab) --}}
        @if (request('status', 'pending') === 'pending')
            <form id="batchApproveForm" action="{{ route('admin_inovchalenge.accounts.registrations.batchApprove') }}"
                method="POST" x-data="batchApproval()">
                @csrf
                @method('PATCH')

                {{-- Batch action bar --}}
                <div x-show="selectedIds.length > 0" x-transition
                    class="sticky top-0 z-20 mb-4 flex items-center justify-between bg-teal-50 border border-teal-200 rounded-xl px-5 py-3 shadow-sm"
                    x-cloak>
                    <span class="text-sm font-semibold text-teal-800">
                        <i class="fas fa-check-double mr-1"></i>
                        <span x-text="selectedIds.length"></span> pendaftaran dipilih
                    </span>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition shadow-sm"
                        onclick="return confirm('Yakin ingin menyetujui ' + document.querySelectorAll('input[name=\'registration_ids[]\']:checked').length + ' pendaftaran yang dipilih?')">
                        <i class="fas fa-check-double mr-1.5"></i> Setujui Semua yang Dipilih
                    </button>
                </div>

                {{-- Select all toggle --}}
                <div class="flex items-center gap-3 mb-3">
                    <label
                        class="inline-flex items-center gap-2 cursor-pointer text-sm text-gray-600 hover:text-gray-800 transition">
                        <input type="checkbox" @change="toggleAll($event)" :checked="allSelected"
                            class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="font-medium">Pilih Semua</span>
                    </label>
                </div>
        @endif

        {{-- Registrations List --}}
        <div class="space-y-4">
            @forelse($registrations as $reg)
                <div class="bg-white rounded-xl shadow border border-gray-100 p-5" x-data="{ showNotes: false }">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        {{-- Info --}}
                        <div class="flex items-start gap-4">
                            @if ($reg->status === 'pending')
                                <div class="flex items-center pt-1">
                                    <input type="checkbox" name="registration_ids[]" value="{{ $reg->id }}"
                                        class="batch-checkbox w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 cursor-pointer"
                                        @change="toggleId({{ $reg->id }}, $event)"
                                        :checked="selectedIds.includes({{ $reg->id }})">
                                </div>
                            @endif
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                                style="background: linear-gradient(135deg, #277177, #1d5559);">
                                {{ strtoupper(substr($reg->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-800">{{ $reg->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $reg->email }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    @php
                                        $roleColors = [
                                            'dosen' => 'bg-teal-100 text-teal-800',
                                            'alumni' => 'bg-green-100 text-green-800',
                                            'peneliti' => 'bg-indigo-100 text-indigo-800',
                                            'dudi' => 'bg-amber-100 text-amber-800',
                                            'pppk' => 'bg-orange-100 text-orange-800',
                                            'mahasiswa' => 'bg-cyan-100 text-cyan-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $roleColors[$reg->role] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $reg->role_label }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $reg->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if ($reg->status === 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin_inovchalenge.accounts.registrations.approve', $reg) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menyetujui pendaftaran {{ $reg->name }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition shadow-sm">
                                        <i class="fas fa-check mr-1"></i> Setujui
                                    </button>
                                </form>

                                {{-- Decline toggle --}}
                                <button @click="showNotes = !showNotes"
                                    class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-semibold hover:bg-red-200 transition">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            @elseif($reg->status === 'approved')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i> Disetujui
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Decline reason form --}}
                    <div x-show="showNotes" x-transition class="mt-4 pt-4 border-t border-gray-200" x-cloak>
                        <form action="{{ route('admin_inovchalenge.accounts.registrations.decline', $reg) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan
                                (opsional)
                            </label>
                            <textarea name="admin_notes" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                placeholder="Tuliskan alasan penolakan..."></textarea>
                            <div class="flex justify-end gap-2 mt-3">
                                <button type="button" @click="showNotes = false"
                                    class="px-3 py-1.5 text-sm text-gray-500 hover:text-gray-700 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-1.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition"
                                    onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">
                                    Konfirmasi Tolak
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Show admin notes if processed --}}
                    @if ($reg->status !== 'pending' && $reg->admin_notes)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500"><i class="fas fa-sticky-note mr-1"></i> Catatan:
                                {{ $reg->admin_notes }}</p>
                        </div>
                    @endif

                    @if ($reg->processedBy)
                        <div class="mt-2">
                            <p class="text-xs text-gray-400">
                                Diproses oleh {{ $reg->processedBy->name }} pada
                                {{ $reg->processed_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-400 font-medium">Tidak ada pendaftaran
                        {{ request('status', 'pending') === 'pending' ? 'yang menunggu' : '' }}</p>
                </div>
            @endforelse
        </div>

        @if (request('status', 'pending') === 'pending')
            </form>
        @endif

        @if ($registrations->hasPages())
            <div class="pt-2">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    {{-- Batch approval Alpine component --}}
    <script>
        function batchApproval() {
            return {
                selectedIds: [],
                get allSelected() {
                    const checkboxes = document.querySelectorAll('.batch-checkbox');
                    return checkboxes.length > 0 && this.selectedIds.length === checkboxes.length;
                },
                toggleId(id, event) {
                    if (event.target.checked) {
                        if (!this.selectedIds.includes(id)) this.selectedIds.push(id);
                    } else {
                        this.selectedIds = this.selectedIds.filter(i => i !== id);
                    }
                },
                toggleAll(event) {
                    const checkboxes = document.querySelectorAll('.batch-checkbox');
                    if (event.target.checked) {
                        this.selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
                        checkboxes.forEach(cb => cb.checked = true);
                    } else {
                        this.selectedIds = [];
                        checkboxes.forEach(cb => cb.checked = false);
                    }
                }
            }
        }
    </script>
@endsection
