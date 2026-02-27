@extends('subdirektorat-inovasi.dosen.layout')

@section('title', 'Sesi Innovation Challenge Aktif')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Sesi Innovation Challenge</h1>
                <p class="mt-2 text-gray-600">Jelajahi dan bergabung dengan sesi Innovation Challenge yang sedang aktif</p>
            </div>
            <a href="{{ route('dosen.inov_challenge.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                <i class='bx bx-arrow-back mr-2'></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
            <i class='bx bx-error-circle text-red-500 text-2xl mr-3'></i>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
        <div class="flex items-center">
            <i class='bx bx-info-circle text-blue-500 text-2xl mr-3'></i>
            <p class="text-blue-700 font-medium">{{ session('info') }}</p>
        </div>
    </div>
    @endif

    {{-- Sessions Grid --}}
    @if($sessions->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sessions as $session)
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-200">
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $session->title }}</h3>
                        <div class="flex items-center text-teal-100">
                            <i class='bx bx-calendar text-lg mr-2'></i>
                            <span class="text-sm">{{ \Carbon\Carbon::parse($session->start_date)->format('d M Y') }}</span>
                        </div>
                    </div>
                    @if(in_array($session->id, $joinedSessionIds))
                    <span class="ml-3 px-3 py-1 bg-green-400 text-white text-xs font-semibold rounded-full">
                        Tergabung
                    </span>
                    @else
                    <span class="ml-3 px-3 py-1 bg-yellow-400 text-gray-800 text-xs font-semibold rounded-full">
                        Tersedia
                    </span>
                    @endif
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-6">
                {{-- Description --}}
                @if($session->description)
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $session->description }}</p>
                @endif

                {{-- Session Info --}}
                <div class="space-y-3 mb-4">
                    <div class="flex items-center text-sm text-gray-700">
                        <i class='bx bx-calendar-event text-lg text-teal-500 mr-3'></i>
                        <div>
                            <span class="font-medium">Periode:</span>
                            <span class="ml-1">{{ \Carbon\Carbon::parse($session->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-700">
                        <i class='bx bx-time-five text-lg text-teal-500 mr-3'></i>
                        <div>
                            <span class="font-medium">Batas Pendaftaran:</span>
                            <span class="ml-1">{{ \Carbon\Carbon::parse($session->registration_deadline)->format('d M Y') }}</span>
                        </div>
                    </div>

                    @if($session->max_participants > 0)
                    @php
                        $participantCount = \App\Models\InovChallengeSubmission::where('session_id', $session->id)->count();
                        $percentage = ($participantCount / $session->max_participants) * 100;
                    @endphp
                    <div class="flex items-start text-sm text-gray-700">
                        <i class='bx bx-group text-lg text-teal-500 mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium">Kuota:</span>
                                <span class="text-xs text-gray-500">{{ $participantCount }}/{{ $session->max_participants }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-500 h-2 rounded-full transition-all" style="width: {{ min($percentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Deadline Warning --}}
                @php
                    $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($session->registration_deadline), false);
                @endphp
                @if($daysLeft >= 0 && $daysLeft <= 7 && !in_array($session->id, $joinedSessionIds))
                <div class="mb-4 bg-amber-50 border border-amber-200 rounded-lg p-3">
                    <div class="flex items-center text-amber-800">
                        <i class='bx bx-error text-lg mr-2'></i>
                        <span class="text-xs font-medium">
                            @if($daysLeft == 0)
                            Pendaftaran ditutup hari ini!
                            @elseif($daysLeft == 1)
                            Pendaftaran ditutup besok
                            @else
                            {{ $daysLeft }} hari lagi
                            @endif
                        </span>
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <a href="{{ route('dosen.inov_challenge.sessions.show', $session) }}" 
                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm font-medium">
                        <i class='bx bx-info-circle mr-2'></i>
                        Detail
                    </a>

                    @if(!in_array($session->id, $joinedSessionIds))
                        @php
                            $isExpired = \Carbon\Carbon::parse($session->registration_deadline)->isPast();
                            $isFull = $session->max_participants > 0 && \App\Models\InovChallengeSubmission::where('session_id', $session->id)->count() >= $session->max_participants;
                        @endphp
                        
                        @if($isExpired)
                        <button disabled class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm font-medium">
                            <i class='bx bx-lock mr-2'></i>
                            Ditutup
                        </button>
                        @elseif($isFull)
                        <button disabled class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm font-medium">
                            <i class='bx bx-user-x mr-2'></i>
                            Penuh
                        </button>
                        @else
                        <form action="{{ route('dosen.inov_challenge.sessions.join', $session) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Apakah Anda yakin ingin bergabung dengan sesi ini?')"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors text-sm font-medium shadow-sm">
                                <i class='bx bx-user-plus mr-2'></i>
                                Bergabung
                            </button>
                        </form>
                        @endif
                    @else
                    <a href="{{ route('dosen.inov_challenge.submissions.show', \App\Models\InovChallengeSubmission::where('user_id', auth()->id())->where('session_id', $session->id)->first()) }}" 
                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium shadow-sm">
                        <i class='bx bx-file-find mr-2'></i>
                        Lihat Submission
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($sessions->hasPages())
    <div class="mt-8">
        {{ $sessions->links() }}
    </div>
    @endif

    @else
    {{-- Empty State --}}
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-calendar-x text-5xl text-gray-400'></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Sesi Aktif</h3>
            <p class="text-gray-600 mb-6">
                Saat ini belum ada sesi Innovation Challenge yang sedang aktif. <br>
                Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.
            </p>
            <a href="{{ route('dosen.inov_challenge.index') }}" class="inline-flex items-center px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors font-medium">
                <i class='bx bx-home mr-2'></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
