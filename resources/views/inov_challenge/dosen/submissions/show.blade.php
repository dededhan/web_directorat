@extends('subdirektorat-inovasi.dosen.layout')

@section('title', 'Detail Submission - ' . $submission->title)

@section('content')
<div x-data="{ 
    activeTab: '{{ request()->query('tab', 'overview') }}',
    showDeleteModal: false,
    switchTab(tab) {
        this.activeTab = tab;
        // Update URL without reload
        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.pushState({}, '', url);
    }
}">
    <div class="container mx-auto px-4 py-6">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('dosen.inov_challenge.submissions.index') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-2 transition-colors">
                        <i class='bx bx-arrow-back mr-1'></i>
                        <span class="font-medium">Kembali ke Daftar Submission</span>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $submission->title }}</h1>
                    <p class="mt-2 text-gray-600">{{ $submission->session->title }}</p>
                </div>
                <div class="flex flex-col items-end gap-2">
                    @php
                        $phaseConfig = [
                            'phase_1' => ['label' => 'Phase 1', 'color' => 'blue'],
                            'phase_2' => ['label' => 'Phase 2', 'color' => 'purple'],
                            'phase_3' => ['label' => 'Phase 3', 'color' => 'amber'],
                            'completed' => ['label' => 'Selesai', 'color' => 'green'],
                        ];
                        $currentPhaseInfo = $phaseConfig[$submission->current_phase] ?? $phaseConfig['phase_1'];
                        
                        $statusConfig = [
                            'draft' => ['label' => 'Draft', 'color' => 'gray'],
                            'pending' => ['label' => 'Menunggu Review', 'color' => 'yellow'],
                            'under_review' => ['label' => 'Sedang Direview', 'color' => 'purple'],
                            'revision_requested' => ['label' => 'Revisi Diminta', 'color' => 'orange'],
                            'approved' => ['label' => 'Disetujui', 'color' => 'green'],
                            'rejected' => ['label' => 'Ditolak', 'color' => 'red'],
                            'completed' => ['label' => 'Selesai', 'color' => 'green'],
                        ];
                        $statusInfo = $statusConfig[$submission->status] ?? $statusConfig['draft'];
                    @endphp
                    <span class="px-3 py-1 bg-{{ $currentPhaseInfo['color'] }}-100 text-{{ $currentPhaseInfo['color'] }}-700 text-xs font-semibold rounded-full">
                        {{ $currentPhaseInfo['label'] }}
                    </span>
                    <span class="px-3 py-1 bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-700 text-xs font-semibold rounded-full">
                        {{ $statusInfo['label'] }}
                    </span>
                </div>
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
            <div class="lg:col-span-2">
                {{-- Tab Navigation --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 mb-6">
                    <div class="flex overflow-x-auto border-b border-gray-200">
                        <button @click="switchTab('overview')" 
                                :class="activeTab === 'overview' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                            <i class='bx bx-info-circle text-lg mr-2'></i>
                            Overview
                        </button>
                        <button @click="switchTab('phase1')" 
                                :class="activeTab === 'phase1' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                            <i class='bx bx-bulb text-lg mr-2'></i>
                            Phase 1
                            @if($submission->phase_1_status == 'approved')
                            <i class='bx bx-check-circle text-green-500 ml-1'></i>
                            @elseif($submission->phase_1_status == 'revision_requested')
                            <i class='bx bx-error-circle text-orange-500 ml-1'></i>
                            @endif
                        </button>
                        <button @click="switchTab('phase2')" 
                                :class="activeTab === 'phase2' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                            <i class='bx bx-code-alt text-lg mr-2'></i>
                            Phase 2
                            @if($submission->phase_2_status == 'approved')
                            <i class='bx bx-check-circle text-green-500 ml-1'></i>
                            @elseif($submission->phase_2_status == 'revision_requested')
                            <i class='bx bx-error-circle text-orange-500 ml-1'></i>
                            @endif
                        </button>
                        <button @click="switchTab('phase3')" 
                                :class="activeTab === 'phase3' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                            <i class='bx bx-trophy text-lg mr-2'></i>
                            Phase 3
                            @if($submission->phase_3_status == 'approved')
                            <i class='bx bx-check-circle text-green-500 ml-1'></i>
                            @elseif($submission->phase_3_status == 'revision_requested')
                            <i class='bx bx-error-circle text-orange-500 ml-1'></i>
                            @endif
                        </button>
                        <button @click="switchTab('team')" 
                                :class="activeTab === 'team' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                            <i class='bx bx-group text-lg mr-2'></i>
                            Tim
                        </button>
                        <button @click="switchTab('history')" 
                                :class="activeTab === 'history' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                            <i class='bx bx-history text-lg mr-2'></i>
                            Riwayat
                        </button>
                    </div>
                </div>

                {{-- Tab Content --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                    {{-- Overview Tab --}}
                    <div x-show="activeTab === 'overview'" x-transition>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ringkasan Submission</h2>
                        
                        {{-- Progress Overview --}}
                        @php
                            $overallProgress = 0;
                            if ($submission->phase_1_status == 'approved') $overallProgress += 33.33;
                            if ($submission->phase_2_status == 'approved') $overallProgress += 33.33;
                            if ($submission->phase_3_status == 'approved') $overallProgress += 33.33;
                            if ($submission->current_phase == 'completed') $overallProgress = 100;
                        @endphp
                        
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress Keseluruhan</span>
                                <span class="text-sm font-bold text-teal-600">{{ number_format($overallProgress, 0) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-4 rounded-full transition-all duration-500 flex items-center justify-end pr-2" 
                                     style="width: {{ $overallProgress }}%">
                                    <span class="text-xs text-white font-bold">{{ number_format($overallProgress, 0) }}%</span>
                                </div>
                            </div>
                        </div>

                        {{-- Phase Status Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            {{-- Phase 1 --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-bulb text-2xl text-blue-600'></i>
                                    </div>
                                    @if($submission->phase_1_status == 'approved')
                                    <i class='bx bx-check-circle text-2xl text-green-500'></i>
                                    @elseif($submission->phase_1_status == 'revision_requested')
                                    <i class='bx bx-error-circle text-2xl text-orange-500'></i>
                                    @elseif(in_array($submission->phase_1_status, ['pending', 'under_review']))
                                    <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                                    @else
                                    <i class='bx bx-circle text-2xl text-gray-400'></i>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">Phase 1</h3>
                                <p class="text-xs text-gray-600 mb-2">Ide & Konsep</p>
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                    {{ $submission->phase_1_status ? ucfirst(str_replace('_', ' ', $submission->phase_1_status)) : 'Belum Dimulai' }}
                                </span>
                            </div>

                            {{-- Phase 2 --}}
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-code-alt text-2xl text-purple-600'></i>
                                    </div>
                                    @if($submission->phase_2_status == 'approved')
                                    <i class='bx bx-check-circle text-2xl text-green-500'></i>
                                    @elseif($submission->phase_2_status == 'revision_requested')
                                    <i class='bx bx-error-circle text-2xl text-orange-500'></i>
                                    @elseif(in_array($submission->phase_2_status, ['pending', 'under_review']))
                                    <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                                    @else
                                    <i class='bx bx-circle text-2xl text-gray-400'></i>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">Phase 2</h3>
                                <p class="text-xs text-gray-600 mb-2">Pengembangan</p>
                                <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded">
                                    {{ $submission->phase_2_status ? ucfirst(str_replace('_', ' ', $submission->phase_2_status)) : 'Belum Dimulai' }}
                                </span>
                            </div>

                            {{-- Phase 3 --}}
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-trophy text-2xl text-amber-600'></i>
                                    </div>
                                    @if($submission->phase_3_status == 'approved')
                                    <i class='bx bx-check-circle text-2xl text-green-500'></i>
                                    @elseif($submission->phase_3_status == 'revision_requested')
                                    <i class='bx bx-error-circle text-2xl text-orange-500'></i>
                                    @elseif(in_array($submission->phase_3_status, ['pending', 'under_review']))
                                    <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                                    @else
                                    <i class='bx bx-circle text-2xl text-gray-400'></i>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">Phase 3</h3>
                                <p class="text-xs text-gray-600 mb-2">Finalisasi</p>
                                <span class="inline-block px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded">
                                    {{ $submission->phase_3_status ? ucfirst(str_replace('_', ' ', $submission->phase_3_status)) : 'Belum Dimulai' }}
                                </span>
                            </div>
                        </div>

                        {{-- Submission Info --}}
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class='bx bx-calendar text-teal-500 text-xl mr-3 mt-0.5'></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Dibuat</p>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class='bx bx-time text-teal-500 text-xl mr-3 mt-0.5'></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Terakhir Diupdate</p>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($submission->updated_at)->format('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            @if($submission->description)
                            <div class="flex items-start">
                                <i class='bx bx-note text-teal-500 text-xl mr-3 mt-0.5'></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Deskripsi</p>
                                    <p class="text-sm text-gray-600">{{ $submission->description }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Phase 1 Tab --}}
                    <div x-show="activeTab === 'phase1'" x-transition>
                        @include('inov_challenge.dosen.submissions.partials.phase-detail', [
                            'phase' => 1,
                            'phaseTitle' => 'Ide & Konsep',
                            'phaseIcon' => 'bx-bulb',
                            'phaseColor' => 'blue',
                            'phaseStatus' => $submission->phase_1_status,
                            'phaseData' => $submission->phase_1_data,
                            'phaseProgress' => $submission->phase_1_progress ?? 0,
                            'feedbackData' => $submission->phase_1_feedback ?? null
                        ])
                    </div>

                    {{-- Phase 2 Tab --}}
                    <div x-show="activeTab === 'phase2'" x-transition>
                        @include('inov_challenge.dosen.submissions.partials.phase-detail', [
                            'phase' => 2,
                            'phaseTitle' => 'Pengembangan',
                            'phaseIcon' => 'bx-code-alt',
                            'phaseColor' => 'purple',
                            'phaseStatus' => $submission->phase_2_status,
                            'phaseData' => $submission->phase_2_data,
                            'phaseProgress' => $submission->phase_2_progress ?? 0,
                            'feedbackData' => $submission->phase_2_feedback ?? null
                        ])
                    </div>

                    {{-- Phase 3 Tab --}}
                    <div x-show="activeTab === 'phase3'" x-transition>
                        @include('inov_challenge.dosen.submissions.partials.phase-detail', [
                            'phase' => 3,
                            'phaseTitle' => 'Finalisasi & Presentasi',
                            'phaseIcon' => 'bx-trophy',
                            'phaseColor' => 'amber',
                            'phaseStatus' => $submission->phase_3_status,
                            'phaseData' => $submission->phase_3_data,
                            'phaseProgress' => $submission->phase_3_progress ?? 0,
                            'feedbackData' => $submission->phase_3_feedback ?? null
                        ])
                    </div>

                    {{-- Team Tab --}}
                    <div x-show="activeTab === 'team'" x-transition>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Anggota Tim</h2>
                        
                        @php
                            $teamMembers = \App\Models\InovChallengeTeamMember::where('submission_id', $submission->id)
                                ->with(['user', 'invitedUser'])
                                ->get();
                        @endphp

                        {{-- Team Leader --}}
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Ketua Tim</h3>
                            <div class="flex items-center p-4 bg-teal-50 border border-teal-200 rounded-lg">
                                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mr-4">
                                    <i class='bx bx-user text-2xl text-teal-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $submission->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $submission->user->email }}</p>
                                </div>
                                <span class="px-3 py-1 bg-teal-600 text-white text-xs font-semibold rounded-full">
                                    Ketua
                                </span>
                            </div>
                        </div>

                        {{-- Team Members --}}
                        @if($teamMembers->count() > 0)
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-medium text-gray-700">Anggota Tim ({{ $teamMembers->where('status', 'accepted')->count() }})</h3>
                                <a href="{{ route('dosen.inov_challenge.teams.index', $submission) }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                                    Kelola Tim →
                                </a>
                            </div>
                            <div class="space-y-2">
                                @foreach($teamMembers as $member)
                                <div class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                        <i class='bx {{ $member->member_type == "dosen" ? "bx-user" : "bx-user-circle" }} text-2xl text-gray-600'></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">
                                            @if($member->user)
                                                {{ $member->user->name }}
                                            @elseif($member->invitedUser)
                                                {{ $member->invitedUser->name }}
                                            @else
                                                {{ $member->external_name }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @if($member->user)
                                                {{ $member->user->email }}
                                            @elseif($member->invitedUser)
                                                {{ $member->invitedUser->email }}
                                            @else
                                                {{ $member->external_email }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $member->status == 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $member->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $member->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <i class='bx bx-user-plus text-5xl text-gray-300 mb-3'></i>
                            <p class="text-gray-600 mb-4">Belum ada anggota tim</p>
                            <a href="{{ route('dosen.inov_challenge.teams.index', $submission) }}" 
                               class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors text-sm font-medium">
                                <i class='bx bx-plus mr-2'></i>
                                Tambah Anggota
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- History Tab --}}
                    <div x-show="activeTab === 'history'" x-transition>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Aktivitas</h2>
                        
                        @php
                            $history = collect([
                                ['date' => $submission->created_at, 'action' => 'Submission dibuat', 'icon' => 'bx-plus-circle', 'color' => 'blue'],
                            ]);
                            
                            if ($submission->phase_1_submitted_at) {
                                $history->push(['date' => $submission->phase_1_submitted_at, 'action' => 'Phase 1 disubmit', 'icon' => 'bx-send', 'color' => 'blue']);
                            }
                            if ($submission->phase_1_reviewed_at) {
                                $history->push(['date' => $submission->phase_1_reviewed_at, 'action' => 'Phase 1 direview', 'icon' => 'bx-search-alt', 'color' => 'purple']);
                            }
                            if ($submission->phase_2_submitted_at) {
                                $history->push(['date' => $submission->phase_2_submitted_at, 'action' => 'Phase 2 disubmit', 'icon' => 'bx-send', 'color' => 'purple']);
                            }
                            if ($submission->phase_2_reviewed_at) {
                                $history->push(['date' => $submission->phase_2_reviewed_at, 'action' => 'Phase 2 direview', 'icon' => 'bx-search-alt', 'color' => 'purple']);
                            }
                            if ($submission->phase_3_submitted_at) {
                                $history->push(['date' => $submission->phase_3_submitted_at, 'action' => 'Phase 3 disubmit', 'icon' => 'bx-send', 'color' => 'amber']);
                            }
                            if ($submission->phase_3_reviewed_at) {
                                $history->push(['date' => $submission->phase_3_reviewed_at, 'action' => 'Phase 3 direview', 'icon' => 'bx-search-alt', 'color' => 'purple']);
                            }
                            if ($submission->completed_at) {
                                $history->push(['date' => $submission->completed_at, 'action' => 'Submission selesai', 'icon' => 'bx-check-circle', 'color' => 'green']);
                            }
                            
                            $history = $history->sortByDesc('date');
                        @endphp

                        <div class="relative">
                            @foreach($history as $index => $item)
                            <div class="flex items-start mb-6 last:mb-0">
                                <div class="flex flex-col items-center mr-4">
                                    <div class="w-10 h-10 bg-{{ $item['color'] }}-100 rounded-full flex items-center justify-center">
                                        <i class='bx {{ $item['icon'] }} text-xl text-{{ $item['color'] }}-600'></i>
                                    </div>
                                    @if(!$loop->last)
                                    <div class="w-0.5 h-12 bg-gray-200 mt-2"></div>
                                    @endif
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="font-medium text-gray-900">{{ $item['action'] }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ \Carbon\Carbon::parse($item['date'])->format('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sticky top-6 space-y-6">
                    {{-- Quick Actions --}}
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-2">
                            @if($submission->current_phase != 'completed')
                                @php
                                    $canEdit = false;
                                    $editRoute = null;
                                    $editLabel = 'Lanjutkan';
                                    $editIcon = 'bx-play-circle';
                                    
                                    if ($submission->current_phase == 'phase_1') {
                                        $canEdit = true;
                                        $editRoute = route('dosen.inov_challenge.submissions.phase1.edit', $submission);
                                        if ($submission->phase_1_status == 'revision_requested') {
                                            $editLabel = 'Revisi Phase 1';
                                            $editIcon = 'bx-edit';
                                        } elseif (!$submission->phase_1_status) {
                                            $editLabel = 'Mulai Phase 1';
                                        }
                                    } elseif ($submission->current_phase == 'phase_2' && $submission->phase_1_status == 'approved') {
                                        $canEdit = true;
                                        $editRoute = route('dosen.inov_challenge.submissions.phase2.edit', $submission);
                                        if ($submission->phase_2_status == 'revision_requested') {
                                            $editLabel = 'Revisi Phase 2';
                                            $editIcon = 'bx-edit';
                                        } elseif (!$submission->phase_2_status) {
                                            $editLabel = 'Mulai Phase 2';
                                        }
                                    } elseif ($submission->current_phase == 'phase_3' && $submission->phase_2_status == 'approved') {
                                        $canEdit = true;
                                        $editRoute = route('dosen.inov_challenge.submissions.phase3.edit', $submission);
                                        if ($submission->phase_3_status == 'revision_requested') {
                                            $editLabel = 'Revisi Phase 3';
                                            $editIcon = 'bx-edit';
                                        } elseif (!$submission->phase_3_status) {
                                            $editLabel = 'Mulai Phase 3';
                                        }
                                    }
                                @endphp

                                @if($canEdit)
                                <a href="{{ $editRoute }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors font-medium shadow-sm">
                                    <i class='bx {{ $editIcon }} mr-2 text-lg'></i>
                                    {{ $editLabel }}
                                </a>
                                @else
                                <button disabled 
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium"
                                        title="Selesaikan phase sebelumnya terlebih dahulu">
                                    <i class='bx bx-lock mr-2 text-lg'></i>
                                    Menunggu Approval
                                </button>
                                @endif
                            @else
                                <div class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-100 text-green-700 rounded-lg font-medium">
                                    <i class='bx bx-check-circle mr-2 text-lg'></i>
                                    Submission Selesai
                                </div>
                            @endif

                            <a href="{{ route('dosen.inov_challenge.teams.index', $submission) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-medium">
                                <i class='bx bx-group mr-2 text-lg'></i>
                                Kelola Tim
                            </a>

                            <a href="{{ route('dosen.inov_challenge.sessions.show', $submission->session) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-medium">
                                <i class='bx bx-info-circle mr-2 text-lg'></i>
                                Detail Sesi
                            </a>
                        </div>
                    </div>

                    {{-- Session Info --}}
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Sesi</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <i class='bx bx-calendar text-teal-500 text-lg mr-3 mt-0.5'></i>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Periode Sesi</p>
                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($submission->session->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($submission->session->end_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class='bx bx-time text-teal-500 text-lg mr-3 mt-0.5'></i>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Batas Pendaftaran</p>
                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($submission->session->registration_deadline)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Next Steps --}}
                    @if($submission->current_phase != 'completed')
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Langkah Selanjutnya</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            @if($submission->current_phase == 'phase_1')
                                @if(!$submission->phase_1_status || $submission->phase_1_status == 'draft')
                                <p>✓ Lengkapi dan submit Phase 1</p>
                                @elseif($submission->phase_1_status == 'revision_requested')
                                <p>⚠️ Lakukan revisi Phase 1</p>
                                @else
                                <p>⏱ Menunggu approval Phase 1</p>
                                @endif
                            @elseif($submission->current_phase == 'phase_2')
                                @if(!$submission->phase_2_status || $submission->phase_2_status == 'draft')
                                <p>✓ Lengkapi dan submit Phase 2</p>
                                @elseif($submission->phase_2_status == 'revision_requested')
                                <p>⚠️ Lakukan revisi Phase 2</p>
                                @else
                                <p>⏱ Menunggu approval Phase 2</p>
                                @endif
                            @elseif($submission->current_phase == 'phase_3')
                                @if(!$submission->phase_3_status || $submission->phase_3_status == 'draft')
                                <p>✓ Lengkapi dan submit Phase 3</p>
                                @elseif($submission->phase_3_status == 'revision_requested')
                                <p>⚠️ Lakukan revisi Phase 3</p>
                                @else
                                <p>⏱ Menunggu approval Phase 3</p>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
