{{-- Phase Detail Partial --}}
@php
    $statusConfig = [
        'draft' => ['label' => 'Draft', 'color' => 'gray', 'icon' => 'bx-edit'],
        'pending' => ['label' => 'Menunggu Review', 'color' => 'yellow', 'icon' => 'bx-time'],
        'under_review' => ['label' => 'Sedang Direview', 'color' => 'purple', 'icon' => 'bx-search-alt'],
        'revision_requested' => ['label' => 'Revisi Diminta', 'color' => 'orange', 'icon' => 'bx-error'],
        'approved' => ['label' => 'Disetujui', 'color' => 'green', 'icon' => 'bx-check'],
        'rejected' => ['label' => 'Ditolak', 'color' => 'red', 'icon' => 'bx-x'],
    ];
    $statusInfo = isset($phaseStatus) && $phaseStatus ? ($statusConfig[$phaseStatus] ?? $statusConfig['draft']) : null;
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center">
                <i class='bx {{ $phaseIcon }} text-{{ $phaseColor }}-500 mr-2'></i>
                Phase {{ $phase }}: {{ $phaseTitle }}
            </h2>
            @if($statusInfo)
            <span class="inline-flex items-center px-3 py-1 bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-700 text-sm font-semibold rounded-full">
                <i class='bx {{ $statusInfo['icon'] }} mr-1'></i>
                {{ $statusInfo['label'] }}
            </span>
            @else
            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 text-sm font-semibold rounded-full">
                <i class='bx bx-circle mr-1'></i>
                Belum Dimulai
            </span>
            @endif
        </div>
        @if(isset($phaseProgress))
        <div class="text-right">
            <p class="text-sm text-gray-600 mb-1">Progress</p>
            <p class="text-2xl font-bold text-{{ $phaseColor }}-600">{{ $phaseProgress }}%</p>
        </div>
        @endif
    </div>

    {{-- Progress Bar --}}
    @if(isset($phaseProgress))
    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-{{ $phaseColor }}-500 h-3 rounded-full transition-all" style="width: {{ $phaseProgress }}%"></div>
    </div>
    @endif

    {{-- Feedback/Review Section --}}
    @if(isset($feedbackData) && $feedbackData)
    <div class="bg-{{ $phaseStatus == 'approved' ? 'green' : ($phaseStatus == 'revision_requested' ? 'orange' : 'purple') }}-50 border border-{{ $phaseStatus == 'approved' ? 'green' : ($phaseStatus == 'revision_requested' ? 'orange' : 'purple') }}-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class='bx {{ $phaseStatus == 'approved' ? 'bx-check-circle' : ($phaseStatus == 'revision_requested' ? 'bx-error-circle' : 'bx-info-circle') }} text-2xl text-{{ $phaseStatus == 'approved' ? 'green' : ($phaseStatus == 'revision_requested' ? 'orange' : 'purple') }}-600 mr-3'></i>
            <div class="flex-1">
                <h4 class="font-semibold text-{{ $phaseStatus == 'approved' ? 'green' : ($phaseStatus == 'revision_requested' ? 'orange' : 'purple') }}-900 mb-2">
                    {{ $phaseStatus == 'approved' ? 'Feedback dari Reviewer' : ($phaseStatus == 'revision_requested' ? 'Revisi Diperlukan' : 'Catatan Review') }}
                </h4>
                @if(is_array($feedbackData))
                    @if(isset($feedbackData['comment']))
                    <p class="text-sm text-gray-700 mb-2">{{ $feedbackData['comment'] }}</p>
                    @endif
                    @if(isset($feedbackData['reviewer_name']))
                    <p class="text-xs text-gray-600 mt-2">
                        <i class='bx bx-user text-sm mr-1'></i>
                        Reviewer: {{ $feedbackData['reviewer_name'] }}
                    </p>
                    @endif
                    @if(isset($feedbackData['reviewed_at']))
                    <p class="text-xs text-gray-600">
                        <i class='bx bx-time text-sm mr-1'></i>
                        {{ \Carbon\Carbon::parse($feedbackData['reviewed_at'])->format('d M Y, H:i') }} WIB
                    </p>
                    @endif
                @else
                    <p class="text-sm text-gray-700">{{ $feedbackData }}</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Submitted Data --}}
    @if(isset($phaseData) && $phaseData)
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data yang Disubmit</h3>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
            @if(is_array($phaseData))
                <div class="space-y-4">
                    @foreach($phaseData as $key => $value)
                        @if(is_array($value))
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}</p>
                                @if(isset($value['path']) || isset($value['url']))
                                    {{-- File upload --}}
                                    <a href="{{ $value['url'] ?? Storage::url($value['path']) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition-colors text-sm">
                                        <i class='bx bx-file mr-2'></i>
                                        {{ $value['name'] ?? basename($value['path'] ?? $value['url']) }}
                                    </a>
                                @else
                                    <pre class="text-sm text-gray-600 whitespace-pre-wrap">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                @endif
                            </div>
                        @else
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</p>
                                <p class="text-sm text-gray-600">{{ $value }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-600">{{ $phaseData }}</p>
            @endif
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <i class='bx bx-file-blank text-6xl text-gray-300 mb-4'></i>
        <p class="text-gray-600 mb-2">Belum ada data yang disubmit untuk phase ini</p>
        @if(!$phaseStatus || $phaseStatus == 'draft')
        <p class="text-sm text-gray-500">Klik tombol di sidebar untuk mulai mengisi</p>
        @endif
    </div>
    @endif

    {{-- Uploaded Files --}}
    @php
        $uploads = \App\Models\InovChallengeUpload::where('submission_id', $submission->id)
            ->where('phase', $phase)
            ->get();
    @endphp
    @if($uploads->count() > 0)
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen Terlampir</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($uploads as $upload)
            <a href="{{ Storage::url($upload->file_path) }}" 
               target="_blank"
               class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">
                <i class='bx bx-file text-2xl text-teal-500 mr-3'></i>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $upload->file_name }}</p>
                    <p class="text-xs text-gray-500">
                        {{ number_format($upload->file_size / 1024, 2) }} KB
                        • {{ \Carbon\Carbon::parse($upload->created_at)->format('d M Y') }}
                    </p>
                </div>
                <i class='bx bx-download text-xl text-gray-400'></i>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
