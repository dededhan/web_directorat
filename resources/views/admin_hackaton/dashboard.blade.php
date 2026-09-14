@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-gray-900 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/30 flex items-center justify-center">
                    <i class="fas fa-lightbulb text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Hackaton</h1>
                    <p class="mt-1 text-sm text-amber-950">Kelola pendaftaran peserta Hackaton UNJ.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['label' => 'Total Pendaftaran', 'key' => 'totalRegistrations', 'icon' => 'fa-users', 'color' => 'blue'],
                ['label' => 'Menunggu', 'key' => 'pendingRegistrations', 'icon' => 'fa-clock', 'color' => 'amber'],
                ['label' => 'Disetujui', 'key' => 'approvedRegistrations', 'icon' => 'fa-check-circle', 'color' => 'green'],
                ['label' => 'Ditolak', 'key' => 'declinedRegistrations', 'icon' => 'fa-times-circle', 'color' => 'red'],
            ] as $stat)
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600">
                            <i class="fas {{ $stat['icon'] }}"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats[$stat['key']] }}</p>
                            <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Pendaftaran Peserta</h2>
                    <p class="mt-1 text-sm text-gray-500">Tinjau pendaftaran yang masuk dan proses akun peserta.</p>
                </div>
                <a href="{{ route('admin_hackaton.registrations.index') }}" class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800">
                    <i class="fas fa-list mr-2"></i> Lihat Pendaftaran
                </a>
            </div>
        </div>
    </div>
@endsection
