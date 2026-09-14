@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-6" x-data="{ openDecline: null }">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Hackaton</h1>
            <p class="mt-1 text-sm text-gray-500">Setujui atau tolak pendaftaran akun peserta Hackaton.</p>
        </div>

        <div class="flex flex-wrap gap-2 border-b border-gray-200">
            @foreach (['pending' => 'Menunggu', 'approved' => 'Disetujui', 'declined' => 'Ditolak'] as $statusKey => $label)
                <a href="{{ route('admin_hackaton.registrations.index', ['status' => $statusKey]) }}" class="rounded-t-lg px-4 py-2.5 text-sm font-semibold {{ request('status', 'pending') === $statusKey ? 'border border-b-white bg-white text-amber-700' : 'text-gray-500 hover:text-gray-800' }}">
                    {{ $label }}
                    @if ($statusKey === 'pending')<span class="ml-1 rounded-full bg-red-500 px-1.5 py-0.5 text-xs text-white">{{ $pendingCount }}</span>@endif
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin_hackaton.registrations.index') }}" method="GET" class="flex max-w-xl gap-2">
            <input type="hidden" name="status" value="{{ request('status', 'pending') }}">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500">
            <button class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"><i class="fas fa-search"></i></button>
        </form>

        <div class="space-y-4">
            @forelse ($registrations as $registration)
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-amber-100 text-lg font-bold text-amber-700">{{ strtoupper(substr($registration->name, 0, 1)) }}</div>
                            <div>
                                <h2 class="font-bold text-gray-800">{{ $registration->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $registration->email }}</p>
                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                                    <span class="rounded-full bg-blue-100 px-2.5 py-1 font-semibold text-blue-800">{{ $registration->role_label }}</span>
                                    <span class="text-gray-400">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            @if ($registration->status === 'pending')
                                <form action="{{ route('admin_hackaton.registrations.approve', $registration) }}" method="POST" onsubmit="return confirm('Setujui pendaftaran ini?')">
                                    @csrf @method('PATCH')
                                    <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"><i class="fas fa-check mr-1"></i> Setujui</button>
                                </form>
                                <button type="button" @click="openDecline = openDecline === {{ $registration->id }} ? null : {{ $registration->id }}" class="rounded-lg bg-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-200"><i class="fas fa-times mr-1"></i> Tolak</button>
                            @else
                                <span class="rounded-lg px-3 py-1.5 text-xs font-semibold {{ $registration->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $registration->status_label }}</span>
                            @endif
                        </div>
                    </div>
                    <div x-show="openDecline === {{ $registration->id }}" x-cloak class="mt-4 border-t border-gray-100 pt-4">
                        <form action="{{ route('admin_hackaton.registrations.decline', $registration) }}" method="POST" class="space-y-3">
                            @csrf @method('PATCH')
                            <textarea name="admin_notes" rows="2" placeholder="Alasan penolakan (opsional)" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-red-400 focus:ring-red-400"></textarea>
                            <div class="flex justify-end"><button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700" onclick="return confirm('Tolak pendaftaran ini?')">Konfirmasi Tolak</button></div>
                        </form>
                    </div>
                    @if ($registration->admin_notes)
                        <p class="mt-3 border-t border-gray-100 pt-3 text-xs text-gray-500"><i class="fas fa-sticky-note mr-1"></i>{{ $registration->admin_notes }}</p>
                    @endif
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center text-gray-500">Belum ada pendaftaran pada filter ini.</div>
            @endforelse
        </div>

        {{ $registrations->links() }}
    </div>
@endsection
