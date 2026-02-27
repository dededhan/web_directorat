@extends('inov_challenge.admin.layout')

@section('title', 'Submission Detail - ' . $submission->title)

@section('page-title', 'Submission Detail')
@section('page-description', $submission->session->title ?? '')

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'phase_1' }">
        <!-- Back Button -->
        <div>
            <a href="{{ route('admin.inov_challenge.submissions.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium">
                <i class='bx bx-arrow-back mr-2'></i>
                Back to Submissions
            </a>
        </div>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md p-6 text-white">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-3">
                        <i class='bx bx-file-blank text-4xl'></i>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $submission->title }}</h2>
                            <p class="text-indigo-100 text-sm mt-1">{{ $submission->session->title ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-xs text-indigo-100">Submitted by</p>
                            <p class="font-semibold mt-1">{{ $submission->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-indigo-100 mt-1">{{ $submission->user->email ?? '' }}</p>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-xs text-indigo-100">Submission Date</p>
                            <p class="font-semibold mt-1">{{ $submission->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-indigo-100 mt-1">{{ $submission->created_at->format('H:i') }}</p>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-xs text-indigo-100">Last Updated</p>
                            <p class="font-semibold mt-1">{{ $submission->updated_at->format('d M Y') }}</p>
                            <p class="text-xs text-indigo-100 mt-1">{{ $submission->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                <div class="ml-6">
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                    @if ($submission->final_status == 'approved') bg-green-500
                    @elseif($submission->final_status == 'rejected') bg-red-500
                    @elseif(in_array($submission->final_status, ['submitted', 'under_review', 'reviewed'])) bg-yellow-500
                    @elseif($submission->final_status == 'draft') bg-gray-500
                    @else bg-blue-500 @endif">
                        {{ strtoupper(str_replace('_', ' ', $submission->final_status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.inov_challenge.reviewers.assign', ['submission' => $submission->id]) }}"
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                <i class='bx bx-user-plus mr-2'></i>
                Assign Reviewer
            </a>

            @if ($submission->final_status == 'reviewed')
                <form action="{{ route('admin.inov_challenge.submissions.approve', [$submission->id, 'phase_1']) }}"
                    method="POST" onsubmit="return confirm('Are you sure you want to approve this submission?');"
                    class="inline">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <i class='bx bx-check-circle mr-2'></i>
                        Approve
                    </button>
                </form>

                <form action="{{ route('admin.inov_challenge.submissions.reject', [$submission->id, 'phase_1']) }}"
                    method="POST" onsubmit="return confirm('Are you sure you want to reject this submission?');"
                    class="inline">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <i class='bx bx-x-circle mr-2'></i>
                        Reject
                    </button>
                </form>
            @endif
        </div>

        <!-- Team Members -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class='bx bx-group mr-2 text-indigo-600'></i>
                Team Members ({{ $submission->teamMembers->count() + 1 }})
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Leader -->
                <div class="border rounded-lg p-4 bg-indigo-50 border-indigo-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($submission->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $submission->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $submission->user->email ?? '' }}</p>
                                @if ($submission->user->phone ?? false)
                                    <p class="text-xs text-gray-500 mt-1">{{ $submission->user->phone }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full">LEADER</span>
                    </div>
                </div>

                <!-- Members -->
                @foreach ($submission->teamMembers as $member)
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($member->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $member->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $member->user->email ?? '' }}</p>
                                @if ($member->user->phone ?? false)
                                    <p class="text-xs text-gray-500 mt-1">{{ $member->user->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Phase Tabs -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Tab Headers -->
            <div class="border-b bg-gray-50">
                <div class="flex items-center space-x-1 p-2">
                    @foreach (['phase_1', 'phase_2', 'phase_3'] as $phase)
                        @php
                            $phaseStatus = $submission->{$phase . '_status'};
                            $phaseData = $submission->{$phase . '_data'};
                            $phaseNumber = str_replace('phase_', '', $phase);
                        @endphp
                        <button @click="activeTab = '{{ $phase }}'"
                            :class="activeTab === '{{ $phase }}' ?
                                'bg-white border-b-2 border-indigo-600 text-indigo-600' :
                                'text-gray-600 hover:text-gray-900'"
                            class="flex-1 px-4 py-3 font-semibold rounded-t-lg transition-colors">
                            <div class="flex items-center justify-center space-x-2">
                                <span>Phase {{ $phaseNumber }}</span>
                                @if ($phaseData)
                                    @if ($phaseStatus == 'approved')
                                        <i class='bx bx-check-circle text-green-600'></i>
                                    @elseif($phaseStatus == 'rejected')
                                        <i class='bx bx-x-circle text-red-600'></i>
                                    @elseif(in_array($phaseStatus, ['submitted', 'under_review', 'reviewed']))
                                        <i class='bx bx-time-five text-yellow-600'></i>
                                    @else
                                        <i class='bx bx-edit text-blue-600'></i>
                                    @endif
                                @else
                                    <i class='bx bx-circle text-gray-400'></i>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @foreach (['phase_1', 'phase_2', 'phase_3'] as $phase)
                    <div x-show="activeTab === '{{ $phase }}'" x-transition>
                        @php
                            $phaseStatus = $submission->{$phase . '_status'};
                            $phaseData = $submission->{$phase . '_data'};
                            $phaseNumber = str_replace('phase_', '', $phase);
                        @endphp

                        <!-- Phase Status -->
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Phase {{ $phaseNumber }} Details</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Status:
                                    <span
                                        class="font-semibold
                                    @if ($phaseStatus == 'approved') text-green-600
                                    @elseif($phaseStatus == 'rejected') text-red-600
                                    @elseif(in_array($phaseStatus, ['submitted', 'under_review', 'reviewed'])) text-yellow-600
                                    @else text-gray-600 @endif">
                                        {{ $phaseStatus ? ucfirst(str_replace('_', ' ', $phaseStatus)) : 'Not Started' }}
                                    </span>
                                </p>
                            </div>
                            @if ($scores[$phase])
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Average Score</p>
                                    <p class="text-3xl font-bold text-indigo-600">{{ number_format($scores[$phase], 1) }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if ($phaseData)
                            <!-- Submission Data -->
                            <div class="space-y-6">
                                @if ($formConfigs[$phase])
                                    @foreach ($formConfigs[$phase] as $field)
                                        @php
                                            $fieldValue = $phaseData[$field['name']] ?? null;
                                        @endphp

                                        @if ($fieldValue)
                                            <div class="border-b pb-4">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    {{ $field['label'] }}
                                                    @if ($field['required'] ?? false)
                                                        <span class="text-red-600">*</span>
                                                    @endif
                                                </label>

                                                @if ($field['type'] == 'file')
                                                    <!-- File field - show upload info -->
                                                    @php
                                                        $upload = $submission->uploads
                                                            ->where('field_name', $field['name'])
                                                            ->where('phase', $phase)
                                                            ->first();
                                                    @endphp
                                                    @if ($upload)
                                                        <a href="{{ Storage::url($upload->file_path) }}" target="_blank"
                                                            class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                                                            <i class='bx bx-download mr-2'></i>
                                                            {{ $upload->original_filename }}
                                                            <span
                                                                class="ml-2 text-xs text-gray-600">({{ number_format($upload->file_size / 1024, 2) }}
                                                                KB)</span>
                                                        </a>
                                                    @else
                                                        <p class="text-gray-500 italic">No file uploaded</p>
                                                    @endif
                                                @elseif($field['type'] == 'textarea')
                                                    <div
                                                        class="bg-gray-50 rounded-lg p-4 text-gray-800 whitespace-pre-wrap">
                                                        {{ $fieldValue }}</div>
                                                @elseif($field['type'] == 'select' || $field['type'] == 'radio')
                                                    @php
                                                        $optionLabel = $field['options'][$fieldValue] ?? $fieldValue;
                                                    @endphp
                                                    <p class="text-gray-800">{{ $optionLabel }}</p>
                                                @elseif($field['type'] == 'checkbox')
                                                    @php
                                                        $selectedOptions = is_array($fieldValue)
                                                            ? $fieldValue
                                                            : [$fieldValue];
                                                    @endphp
                                                    <div class="space-y-1">
                                                        @foreach ($selectedOptions as $selectedValue)
                                                            @php
                                                                $optionLabel =
                                                                    $field['options'][$selectedValue] ?? $selectedValue;
                                                            @endphp
                                                            <p class="text-gray-800">• {{ $optionLabel }}</p>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-gray-800">{{ $fieldValue }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                                        <p class="text-sm text-yellow-800">
                                            <i class='bx bx-info-circle mr-1'></i>
                                            Form configuration not found for this phase.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Reviews for this Phase -->
                            @php
                                $phaseReviews = $submission->reviews->where('phase', $phase);
                            @endphp

                            @if ($phaseReviews->count() > 0)
                                <div class="mt-8 pt-6 border-t">
                                    <h4 class="text-lg font-bold text-gray-800 mb-4">Reviews
                                        ({{ $phaseReviews->count() }})</h4>
                                    <div class="space-y-4">
                                        @foreach ($phaseReviews as $review)
                                            <div
                                                class="bg-gray-50 rounded-lg p-4 border-l-4 
                                            @if ($review->status == 'approved') border-green-500
                                            @elseif($review->status == 'rejected') border-red-500
                                            @else border-yellow-500 @endif">
                                                <div class="flex items-start justify-between mb-3">
                                                    <div class="flex items-center space-x-3">
                                                        <div
                                                            class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                                            {{ strtoupper(substr($review->reviewer->name ?? 'R', 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold text-gray-900">
                                                                {{ $review->reviewer->name ?? 'N/A' }}</p>
                                                            <p class="text-xs text-gray-500">
                                                                {{ $review->created_at->format('d M Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        @if ($review->score)
                                                            <p class="text-2xl font-bold text-indigo-600">
                                                                {{ $review->score }}</p>
                                                            <p class="text-xs text-gray-600">Score</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($review->comments)
                                                    <div class="mt-3 pt-3 border-t">
                                                        <p class="text-sm font-semibold text-gray-700 mb-1">Comments:</p>
                                                        <p class="text-gray-800">{{ $review->comments }}</p>
                                                    </div>
                                                @endif

                                                @if ($review->feedback)
                                                    <div class="mt-3 pt-3 border-t">
                                                        <p class="text-sm font-semibold text-gray-700 mb-1">Feedback:</p>
                                                        <p class="text-gray-800">{{ $review->feedback }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mt-8 pt-6 border-t">
                                    <div class="text-center py-8">
                                        <i class='bx bx-message-square-x text-4xl text-gray-400 mb-2'></i>
                                        <p class="text-gray-600">No reviews yet for this phase</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <!-- No Data for Phase -->
                            <div class="text-center py-12">
                                <i class='bx bx-file-blank text-6xl text-gray-400 mb-4'></i>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">No Submission Data</h4>
                                <p class="text-gray-600">This phase has not been started yet.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class='bx bx-history mr-2 text-indigo-600'></i>
                Activity Timeline
            </h3>

            @if ($submission->notifications->count() > 0)
                <div class="space-y-4">
                    @foreach ($submission->notifications->sortByDesc('created_at')->take(10) as $notification)
                        <div class="flex items-start space-x-4 pb-4 border-b last:border-b-0">
                            <div
                                class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i
                                    class='bx {{ $notification->type == 'status_changed' ? 'bx-refresh' : ($notification->type == 'reviewer_assigned' ? 'bx-user-plus' : 'bx-bell') }} text-indigo-600'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class='bx bx-history text-4xl text-gray-400 mb-2'></i>
                    <p class="text-gray-600">No activity yet</p>
                </div>
            @endif
        </div>
    </div>
@endsection
