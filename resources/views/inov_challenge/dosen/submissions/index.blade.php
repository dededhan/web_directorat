@extends('subdirektorat-inovasi.dosen.layout')

@section('title', 'Submission Saya')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Submission Saya</h1>
                <p class="mt-2 text-gray-600">Kelola dan pantau progress submission Innovation Challenge Anda</p>
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

    {{-- Statistics Cards --}}
    @if($submissions->total() > 0)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total Submission</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $submissions->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class='bx bx-file text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Draft</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['draft'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class='bx bx-edit text-2xl text-yellow-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Sedang Review</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['under_review'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class='bx bx-time-five text-2xl text-purple-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['completed'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class='bx bx-check-circle text-2xl text-green-600'></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Submissions List --}}
    @if($submissions->count() > 0)
    <div class="space-y-4">
        @foreach($submissions as $submission)
        @php
            $phaseConfig = [
                'phase_1' => ['label' => 'Phase 1', 'color' => 'blue', 'icon' => 'bx-bulb', 'title' => 'Ide & Konsep'],
                'phase_2' => ['label' => 'Phase 2', 'color' => 'purple', 'icon' => 'bx-code-alt', 'title' => 'Pengembangan'],
                'phase_3' => ['label' => 'Phase 3', 'color' => 'amber', 'icon' => 'bx-trophy', 'title' => 'Finalisasi'],
                'completed' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'bx-check-circle', 'title' => 'Completed'],
            ];
            
            $currentPhaseInfo = $phaseConfig[$submission->current_phase] ?? $phaseConfig['phase_1'];
            
            $statusConfig = [
                'draft' => ['label' => 'Draft', 'color' => 'gray', 'icon' => 'bx-edit'],
                'pending' => ['label' => 'Menunggu Review', 'color' => 'yellow', 'icon' => 'bx-time'],
                'under_review' => ['label' => 'Sedang Direview', 'color' => 'purple', 'icon' => 'bx-search-alt'],
                'revision_requested' => ['label' => 'Revisi Diminta', 'color' => 'orange', 'icon' => 'bx-error'],
                'approved' => ['label' => 'Disetujui', 'color' => 'green', 'icon' => 'bx-check'],
                'rejected' => ['label' => 'Ditolak', 'color' => 'red', 'icon' => 'bx-x'],
                'completed' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'bx-check-circle'],
            ];
            
            $statusInfo = $statusConfig[$submission->status] ?? $statusConfig['draft'];
            
            // Calculate overall progress (each phase = 33.33%)
            $overallProgress = 0;
            if ($submission->phase_1_status == 'approved') $overallProgress += 33.33;
            if ($submission->phase_2_status == 'approved') $overallProgress += 33.33;
            if ($submission->phase_3_status == 'approved') $overallProgress += 33.33;
            if ($submission->current_phase == 'completed') $overallProgress = 100;
        @endphp

        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-200">
            <div class="p-6">
                {{-- Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $submission->title }}</h3>
                        <div class="flex items-center text-sm text-gray-600 space-x-4">
                            <span class="flex items-center">
                                <i class='bx bx-calendar mr-1'></i>
                                {{ $submission->session->title }}
                            </span>
                            <span class="flex items-center">
                                <i class='bx bx-time mr-1'></i>
                                Dibuat {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 bg-{{ $currentPhaseInfo['color'] }}-100 text-{{ $currentPhaseInfo['color'] }}-700 text-xs font-semibold rounded-full flex items-center">
                            <i class='bx {{ $currentPhaseInfo['icon'] }} mr-1'></i>
                            {{ $currentPhaseInfo['label'] }}
                        </span>
                        <span class="px-3 py-1 bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-700 text-xs font-semibold rounded-full flex items-center">
                            <i class='bx {{ $statusInfo['icon'] }} mr-1'></i>
                            {{ $statusInfo['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Overall Progress Bar --}}
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Progress Keseluruhan</span>
                        <span class="text-sm font-bold text-{{ $overallProgress == 100 ? 'green' : 'teal' }}-600">{{ number_format($overallProgress, 0) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-3 rounded-full transition-all duration-500 flex items-center justify-end pr-1" 
                             style="width: {{ $overallProgress }}%">
                            @if($overallProgress > 10)
                            <span class="text-[10px] text-white font-bold">{{ number_format($overallProgress, 0) }}%</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Phase Status Indicators --}}
                <div class="grid grid-cols-3 gap-3 mb-4">
                    {{-- Phase 1 --}}
                    <div class="flex items-center space-x-2 p-3 rounded-lg {{ $submission->phase_1_status ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50 border border-gray-200' }}">
                        @if($submission->phase_1_status == 'approved')
                        <i class='bx bx-check-circle text-2xl text-green-500'></i>
                        @elseif($submission->phase_1_status == 'revision_requested')
                        <i class='bx bx-error-circle text-2xl text-orange-500'></i>
                        @elseif($submission->phase_1_status == 'rejected')
                        <i class='bx bx-x-circle text-2xl text-red-500'></i>
                        @elseif(in_array($submission->phase_1_status, ['pending', 'under_review']))
                        <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                        @else
                        <i class='bx bx-circle text-2xl text-gray-400'></i>
                        @endif
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-700">Phase 1</p>
                            <p class="text-[10px] text-gray-600">{{ $phaseConfig['phase_1']['title'] }}</p>
                        </div>
                    </div>

                    {{-- Phase 2 --}}
                    <div class="flex items-center space-x-2 p-3 rounded-lg {{ $submission->phase_2_status ? 'bg-purple-50 border border-purple-200' : 'bg-gray-50 border border-gray-200' }}">
                        @if($submission->phase_2_status == 'approved')
                        <i class='bx bx-check-circle text-2xl text-green-500'></i>
                        @elseif($submission->phase_2_status == 'revision_requested')
                        <i class='bx bx-error-circle text-2xl text-orange-500'></i>
                        @elseif($submission->phase_2_status == 'rejected')
                        <i class='bx bx-x-circle text-2xl text-red-500'></i>
                        @elseif(in_array($submission->phase_2_status, ['pending', 'under_review']))
                        <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                        @else
                        <i class='bx bx-circle text-2xl text-gray-400'></i>
                        @endif
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-700">Phase 2</p>
                            <p class="text-[10px] text-gray-600">{{ $phaseConfig['phase_2']['title'] }}</p>
                        </div>
                    </div>

                    {{-- Phase 3 --}}
                    <div class="flex items-center space-x-2 p-3 rounded-lg {{ $submission->phase_3_status ? 'bg-amber-50 border border-amber-200' : 'bg-gray-50 border border-gray-200' }}">
                        @if($submission->phase_3_status == 'approved')
                        <i class='bx bx-check-circle text-2xl text-green-500'></i>
                        @elseif($submission->phase_3_status == 'revision_requested')
                        <i class='bx bx-error-circle text-2xl text-orange-500'></i>
                        @elseif($submission->phase_3_status == 'rejected')
                        <i class='bx bx-x-circle text-2xl text-red-500'></i>
                        @elseif(in_array($submission->phase_3_status, ['pending', 'under_review']))
                        <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                        @else
                        <i class='bx bx-circle text-2xl text-gray-400'></i>
                        @endif
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-700">Phase 3</p>
                            <p class="text-[10px] text-gray-600">{{ $phaseConfig['phase_3']['title'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Team Info --}}
                @php
                    $teamMembers = \App\Models\InovChallengeTeamMember::where('submission_id', $submission->id)
                        ->where('status', 'accepted')
                        ->count();
                @endphp
                @if($teamMembers > 0)
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class='bx bx-group text-lg mr-2 text-teal-500'></i>
                    <span>Tim ({{ $teamMembers + 1 }} anggota)</span>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-2 pt-4 border-t border-gray-200">
                    <a href="{{ route('dosen.inov_challenge.submissions.show', $submission) }}" 
                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors text-sm font-medium shadow-sm">
                        <i class='bx bx-show mr-2'></i>
                        Lihat Detail
                    </a>

                    @if($submission->current_phase != 'completed')
                        @php
                            $canEdit = false;
                            $editRoute = null;
                            $editLabel = 'Lanjutkan';
                            
                            if ($submission->current_phase == 'phase_1') {
                                $canEdit = true;
                                $editRoute = route('dosen.inov_challenge.submissions.phase1.edit', $submission);
                                if ($submission->phase_1_status == 'revision_requested') {
                                    $editLabel = 'Revisi Phase 1';
                                } elseif (!$submission->phase_1_status) {
                                    $editLabel = 'Mulai Phase 1';
                                } else {
                                    $editLabel = 'Edit Phase 1';
                                }
                            } elseif ($submission->current_phase == 'phase_2' && $submission->phase_1_status == 'approved') {
                                $canEdit = true;
                                $editRoute = route('dosen.inov_challenge.submissions.phase2.edit', $submission);
                                if ($submission->phase_2_status == 'revision_requested') {
                                    $editLabel = 'Revisi Phase 2';
                                } elseif (!$submission->phase_2_status) {
                                    $editLabel = 'Mulai Phase 2';
                                } else {
                                    $editLabel = 'Edit Phase 2';
                                }
                            } elseif ($submission->current_phase == 'phase_3' && $submission->phase_2_status == 'approved') {
                                $canEdit = true;
                                $editRoute = route('dosen.inov_challenge.submissions.phase3.edit', $submission);
                                if ($submission->phase_3_status == 'revision_requested') {
                                    $editLabel = 'Revisi Phase 3';
                                } elseif (!$submission->phase_3_status) {
                                    $editLabel = 'Mulai Phase 3';
                                } else {
                                    $editLabel = 'Edit Phase 3';
                                }
                            }
                        @endphp

                        @if($canEdit)
                        <a href="{{ $editRoute }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium shadow-sm">
                            <i class='bx {{ str_contains($editLabel, "Revisi") ? "bx-edit" : (str_contains($editLabel, "Mulai") ? "bx-play-circle" : "bx-edit-alt") }} mr-2'></i>
                            {{ $editLabel }}
                        </a>
                        @else
                        <button disabled 
                                class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm font-medium"
                                title="Selesaikan phase sebelumnya terlebih dahulu">
                            <i class='bx bx-lock mr-2'></i>
                            Menunggu Approval
                        </button>
                        @endif
                    @else
                        <div class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                            <i class='bx bx-check-circle mr-2'></i>
                            Submission Selesai
                        </div>
                    @endif

                    <a href="{{ route('dosen.inov_challenge.teams.index', $submission) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm font-medium"
                       title="Kelola Tim">
                        <i class='bx bx-group text-lg'></i>
                    </a>
                </div>

                {{-- Revision Notice --}}
                @php
                    $hasRevision = in_array('revision_requested', [
                        $submission->phase_1_status, 
                        $submission->phase_2_status, 
                        $submission->phase_3_status
                    ]);
                @endphp
                @if($hasRevision)
                <div class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-3">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-orange-500 text-xl mr-2 mt-0.5'></i>
                        <div>
                            <p class="text-sm font-medium text-orange-800">Revisi Diperlukan</p>
                            <p class="text-xs text-orange-700 mt-1">Ada fase yang memerlukan revisi. Silakan periksa detail submission untuk informasi lebih lanjut.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($submissions->hasPages())
    <div class="mt-6">
        {{ $submissions->links() }}
    </div>
    @endif

    @else
    {{-- Empty State --}}
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-file text-5xl text-gray-400'></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Submission</h3>
            <p class="text-gray-600 mb-6">
                Anda belum memiliki submission Innovation Challenge. <br>
                Mulai dengan bergabung ke sesi yang tersedia.
            </p>
            <a href="{{ route('dosen.inov_challenge.sessions.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors font-medium shadow-sm">
                <i class='bx bx-search mr-2'></i>
                Jelajahi Sesi Aktif
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
