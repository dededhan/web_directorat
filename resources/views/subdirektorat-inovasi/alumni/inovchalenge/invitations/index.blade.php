@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Undangan Innovation Challenge</h1>
                <p class="mt-1 text-sm text-gray-500">Undangan sebagai anggota tim dari dosen</p>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Invitations --}}
            <div class="space-y-4">
                @forelse($invitations as $invitation)
                    @php
                        $isPending = $invitation->approval_status === 'pending';
                        $badgeColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'approved' => 'bg-green-100 text-green-700 border-green-200',
                            'rejected' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                    @endphp
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                {{-- Info --}}
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $invitation->submission->session->nama_sesi }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-user mr-1"></i> Diundang oleh:
                                        <span
                                            class="font-medium text-gray-700">{{ $invitation->submission->user->name }}</span>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-clock mr-1"></i>
                                        @if ($invitation->responded_at)
                                            Direspon {{ $invitation->responded_at->format('d M Y H:i') }}
                                        @else
                                            Diundang {{ $invitation->created_at->format('d M Y H:i') }}
                                        @endif
                                    </p>
                                    <div class="mt-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeColors[$invitation->approval_status] ?? '' }}">
                                            {{ ucfirst($invitation->approval_status) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions (only for pending) --}}
                                @if ($isPending)
                                    <div class="flex gap-2 flex-shrink-0">
                                        <form method="POST"
                                            action="{{ route('subdirektorat-inovasi.alumni.inovchalenge.invitations.approve', $invitation) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-medium rounded-xl hover:from-green-600 hover:to-green-700 transition shadow-sm">
                                                <i class="fas fa-check mr-1.5"></i> Terima
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('subdirektorat-inovasi.alumni.inovchalenge.invitations.reject', $invitation) }}"
                                            onsubmit="return confirm('Tolak undangan ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-medium rounded-xl hover:from-red-600 hover:to-red-700 transition shadow-sm">
                                                <i class="fas fa-times mr-1.5"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center mb-4">
                                <i class="fas fa-envelope-open text-3xl text-indigo-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Belum ada undangan</h3>
                            <p class="text-sm text-gray-400 mt-1">Anda belum menerima undangan sebagai anggota tim.</p>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
