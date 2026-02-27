@extends('subdirektorat-inovasi.dosen.layout')

@section('title', 'Detail Sesi Innovation Challenge')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('dosen.inov_challenge.sessions.index') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-2 transition-colors">
                    <i class='bx bx-arrow-back mr-1'></i>
                    <span class="font-medium">Kembali ke Daftar Sesi</span>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $session->title }}</h1>
                <p class="mt-2 text-gray-600">Informasi lengkap tentang sesi Innovation Challenge</p>
            </div>
            @if($isJoined)
            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold flex items-center">
                <i class='bx bx-check-circle mr-2 text-xl'></i>
                Anda Sudah Tergabung
            </span>
            @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Session Description --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-info-circle text-teal-500 mr-2'></i>
                    Deskripsi Sesi
                </h2>
                @if($session->description)
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($session->description)) !!}
                </div>
                @else
                <p class="text-gray-500 italic">Tidak ada deskripsi tersedia.</p>
                @endif
            </div>

            {{-- Phase Information --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-layer text-teal-500 mr-2'></i>
                    Tahapan Challenge
                </h2>
                <div class="space-y-4">
                    @php
                        $phases = [
                            1 => ['title' => 'Phase 1: Ide & Konsep', 'icon' => 'bx-bulb', 'color' => 'blue'],
                            2 => ['title' => 'Phase 2: Pengembangan', 'icon' => 'bx-code-alt', 'color' => 'purple'],
                            3 => ['title' => 'Phase 3: Finalisasi & Presentasi', 'icon' => 'bx-trophy', 'color' => 'amber'],
                        ];
                    @endphp

                    @foreach($phases as $phaseNum => $phase)
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex-shrink-0 w-12 h-12 bg-{{ $phase['color'] }}-100 rounded-full flex items-center justify-center mr-4">
                            <i class='bx {{ $phase['icon'] }} text-2xl text-{{ $phase['color'] }}-600'></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $phase['title'] }}</h3>
                            <p class="text-sm text-gray-600">
                                @if($phaseNum == 1)
                                Tahap awal untuk menyampaikan ide inovatif dan konsep dasar solusi yang akan dikembangkan.
                                @elseif($phaseNum == 2)
                                Pengembangan prototype atau MVP (Minimum Viable Product) dari ide yang telah disetujui.
                                @else
                                Finalisasi produk dan presentasi hasil karya kepada tim penilai.
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Requirements & Guidelines --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-list-check text-teal-500 mr-2'></i>
                    Persyaratan & Panduan
                </h2>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <i class='bx bx-check text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-gray-700">Dosen dapat bergabung sebagai individu atau dengan tim (maksimal 5 anggota)</p>
                    </div>
                    <div class="flex items-start">
                        <i class='bx bx-check text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-gray-700">Setiap tahapan harus diselesaikan secara berurutan (Phase 1 → Phase 2 → Phase 3)</p>
                    </div>
                    <div class="flex items-start">
                        <i class='bx bx-check text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-gray-700">Submission dapat disimpan sebagai draft dan disubmit saat sudah siap</p>
                    </div>
                    <div class="flex items-start">
                        <i class='bx bx-check text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-gray-700">Pastikan mengisi formulir dengan lengkap dan mengunggah dokumen yang diperlukan</p>
                    </div>
                    <div class="flex items-start">
                        <i class='bx bx-check text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-gray-700">Tim review akan mengevaluasi setiap tahapan sebelum dapat melanjutkan ke tahap berikutnya</p>
                    </div>
                </div>
            </div>

            {{-- Participant List (if joined) --}}
            @if($isJoined)
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-group text-teal-500 mr-2'></i>
                    Peserta Terdaftar
                </h2>
                @php
                    $participants = \App\Models\InovChallengeSubmission::where('session_id', $session->id)
                        ->with('user')
                        ->latest()
                        ->take(10)
                        ->get();
                @endphp
                @if($participants->count() > 0)
                <div class="space-y-2">
                    @foreach($participants as $participant)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-3">
                            <i class='bx bx-user text-teal-600 text-xl'></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $participant->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $participant->title }}</p>
                        </div>
                        <span class="px-3 py-1 bg-{{ $participant->current_phase == 'completed' ? 'green' : 'blue' }}-100 text-{{ $participant->current_phase == 'completed' ? 'green' : 'blue' }}-700 text-xs font-medium rounded-full">
                            {{ ucfirst($participant->current_phase) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @if(\App\Models\InovChallengeSubmission::where('session_id', $session->id)->count() > 10)
                <p class="text-center text-sm text-gray-500 mt-4">
                    Dan {{ \App\Models\InovChallengeSubmission::where('session_id', $session->id)->count() - 10 }} peserta lainnya
                </p>
                @endif
                @else
                <p class="text-gray-500 italic">Belum ada peserta terdaftar.</p>
                @endif
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Session Info Card --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 sticky top-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Sesi</h3>
                
                <div class="space-y-4 mb-6">
                    {{-- Period --}}
                    <div class="flex items-start">
                        <i class='bx bx-calendar-event text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Periode Sesi</p>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($session->start_date)->format('d M Y') }}
                                <br>
                                s.d. {{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Registration Deadline --}}
                    <div class="flex items-start">
                        <i class='bx bx-time-five text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Batas Pendaftaran</p>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($session->registration_deadline)->format('d M Y, H:i') }} WIB
                            </p>
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($session->registration_deadline), false);
                            @endphp
                            @if($daysLeft >= 0 && !$isJoined)
                            <p class="text-xs mt-1 font-medium {{ $daysLeft <= 7 ? 'text-amber-600' : 'text-teal-600' }}">
                                @if($daysLeft == 0)
                                ⚠️ Ditutup hari ini
                                @elseif($daysLeft == 1)
                                ⚠️ Ditutup besok
                                @else
                                {{ $daysLeft }} hari lagi
                                @endif
                            </p>
                            @endif
                        </div>
                    </div>

                    {{-- Quota --}}
                    @if($session->max_participants > 0)
                    @php
                        $participantCount = \App\Models\InovChallengeSubmission::where('session_id', $session->id)->count();
                        $percentage = ($participantCount / $session->max_participants) * 100;
                        $slotsLeft = $session->max_participants - $participantCount;
                    @endphp
                    <div class="flex items-start">
                        <i class='bx bx-group text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 mb-1">Kuota Peserta</p>
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm text-gray-600">{{ $participantCount }}/{{ $session->max_participants }} peserta</p>
                                @if($slotsLeft > 0 && !$isJoined)
                                <p class="text-xs font-medium {{ $slotsLeft <= 5 ? 'text-amber-600' : 'text-gray-500' }}">
                                    {{ $slotsLeft }} slot tersisa
                                </p>
                                @endif
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-500 h-2 rounded-full transition-all" style="width: {{ min($percentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Status --}}
                    <div class="flex items-start">
                        <i class='bx bx-info-circle text-teal-500 text-xl mr-3 mt-0.5'></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Status</p>
                            @php
                                $now = \Carbon\Carbon::now();
                                $startDate = \Carbon\Carbon::parse($session->start_date);
                                $endDate = \Carbon\Carbon::parse($session->end_date);
                                $regDeadline = \Carbon\Carbon::parse($session->registration_deadline);
                            @endphp
                            @if($now->lt($startDate))
                            <span class="inline-flex items-center px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                <i class='bx bx-time mr-1'></i> Akan Datang
                            </span>
                            @elseif($now->gte($startDate) && $now->lte($endDate))
                            <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                <i class='bx bx-play-circle mr-1'></i> Sedang Berlangsung
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                <i class='bx bx-check-circle mr-1'></i> Selesai
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @if($isJoined)
                <div class="space-y-3">
                    <a href="{{ route('dosen.inov_challenge.submissions.show', $userSubmission) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors font-medium shadow-sm">
                        <i class='bx bx-file-find mr-2 text-lg'></i>
                        Lihat Submission Saya
                    </a>
                    <a href="{{ route('dosen.inov_challenge.index') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-medium">
                        <i class='bx bx-home mr-2 text-lg'></i>
                        Ke Dashboard
                    </a>
                </div>
                @else
                    @php
                        $isExpired = \Carbon\Carbon::parse($session->registration_deadline)->isPast();
                        $isFull = $session->max_participants > 0 && \App\Models\InovChallengeSubmission::where('session_id', $session->id)->count() >= $session->max_participants;
                    @endphp
                    
                    @if($isExpired)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-3">
                        <div class="flex items-center text-red-700">
                            <i class='bx bx-error-circle text-xl mr-2'></i>
                            <p class="text-sm font-medium">Pendaftaran telah ditutup</p>
                        </div>
                    </div>
                    <button disabled class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium">
                        <i class='bx bx-lock mr-2 text-lg'></i>
                        Tidak Dapat Bergabung
                    </button>
                    @elseif($isFull)
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-3">
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-error-circle text-xl mr-2'></i>
                            <p class="text-sm font-medium">Kuota peserta telah penuh</p>
                        </div>
                    </div>
                    <button disabled class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium">
                        <i class='bx bx-user-x mr-2 text-lg'></i>
                        Kuota Penuh
                    </button>
                    @else
                    @if($daysLeft <= 7)
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-3">
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-error-circle text-xl mr-2'></i>
                            <p class="text-sm font-medium">Segera daftar! Pendaftaran akan ditutup dalam {{ $daysLeft }} hari</p>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('dosen.inov_challenge.sessions.join', $session) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin bergabung dengan sesi ini?\n\nAnda akan diminta untuk:\n• Melengkapi submission melalui 3 tahapan\n• Mengikuti timeline yang ditentukan\n• Berkomitmen menyelesaikan challenge')"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                            <i class='bx bx-user-plus mr-2 text-lg'></i>
                            Bergabung dengan Sesi Ini
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 text-center mt-3">
                        Dengan bergabung, Anda menyetujui untuk mengikuti seluruh tahapan challenge
                    </p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
