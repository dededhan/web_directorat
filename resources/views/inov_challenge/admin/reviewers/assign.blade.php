@extends('inov_challenge.admin.layout')

@section('title', 'Assign Reviewer')

@section('page-title', 'Assign Reviewer')
@section('page-description', 'Assign reviewers to submissions')

@section('content')
    <div class="space-y-6">
        <!-- Info Alert -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex items-start">
                <i class='bx bx-info-circle text-2xl text-blue-600 mr-3 mt-0.5'></i>
                <div>
                    <h3 class="font-semibold text-blue-800">Reviewer Assignment Guidelines</h3>
                    <ul class="text-sm text-blue-700 mt-2 space-y-1 list-disc list-inside">
                        <li>Reviewers cannot review their own submissions or submissions from their team</li>
                        <li>Multiple reviewers can be assigned to the same submission and phase</li>
                        <li>Check reviewer workload before assigning to distribute work evenly</li>
                        <li>Only submissions with status "submitted" or "under_review" can be assigned reviewers</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('admin.inov_challenge.reviewers.assign.store') }}" method="POST" id="assignForm"
                x-data="assignmentForm()">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column: Form Inputs -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Assignment Details</h3>

                        <!-- Select Submission -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Select Submission *
                            </label>
                            <select name="submission_id" x-model="submissionId" @change="updateSubmissionInfo" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">-- Select Submission --</option>
                                @foreach ($submissions as $submission)
                                    <option value="{{ $submission->id }}" data-title="{{ $submission->title }}"
                                        data-user="{{ $submission->user->name ?? 'N/A' }}"
                                        data-session="{{ $submission->session->title ?? 'N/A' }}"
                                        {{ $selectedSubmission && $selectedSubmission->id == $submission->id ? 'selected' : '' }}>
                                        {{ $submission->title }} - {{ $submission->user->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('submission_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Select Phase -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Select Phase *
                            </label>
                            <select name="phase" x-model="phase" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">-- Select Phase --</option>
                                <option value="phase_1">Phase 1 - Tahap Penyerahan Awal</option>
                                <option value="phase_2">Phase 2 - Tahap Pengembangan</option>
                                <option value="phase_3">Phase 3 - Tahap Final</option>
                            </select>
                            @error('phase')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Select Reviewer -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Select Reviewer *
                            </label>
                            <select name="reviewer_id" x-model="reviewerId" @change="updateReviewerInfo" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">-- Select Reviewer --</option>
                                @foreach ($reviewers as $reviewer)
                                    <option value="{{ $reviewer->id }}" data-name="{{ $reviewer->name }}"
                                        data-email="{{ $reviewer->email }}"
                                        data-active="{{ $reviewerWorkload[$reviewer->id]['active'] }}"
                                        data-completed="{{ $reviewerWorkload[$reviewer->id]['completed'] }}">
                                        {{ $reviewer->name }} - {{ $reviewer->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('reviewer_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg transition-colors shadow-md">
                                <i class='bx bx-user-plus mr-2'></i>
                                Assign Reviewer
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Preview & Info -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Preview</h3>

                        <!-- Submission Info -->
                        <div x-show="submissionId" x-transition>
                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                                <h4 class="font-semibold text-indigo-900 mb-3 flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Submission Details
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Title:</span>
                                        <span class="font-medium text-gray-900" x-text="submissionTitle"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Submitter:</span>
                                        <span class="font-medium text-gray-900" x-text="submissionUser"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Session:</span>
                                        <span class="font-medium text-gray-900" x-text="submissionSession"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviewer Info -->
                        <div x-show="reviewerId" x-transition>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <h4 class="font-semibold text-purple-900 mb-3 flex items-center">
                                    <i class='bx bx-user mr-2'></i>
                                    Reviewer Details
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Name:</span>
                                        <span class="font-medium text-gray-900" x-text="reviewerName"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium text-gray-900" x-text="reviewerEmail"></span>
                                    </div>
                                </div>

                                <!-- Workload Indicator -->
                                <div class="mt-4 pt-4 border-t border-purple-200">
                                    <p class="text-xs text-gray-600 mb-2">Current Workload:</p>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-white rounded-lg p-3 text-center">
                                            <p class="text-2xl font-bold text-yellow-600" x-text="reviewerActiveReviews">
                                            </p>
                                            <p class="text-xs text-gray-600">Active</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 text-center">
                                            <p class="text-2xl font-bold text-green-600" x-text="reviewerCompletedReviews">
                                            </p>
                                            <p class="text-xs text-gray-600">Completed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div x-show="!submissionId && !reviewerId">
                            <div class="text-center py-12 text-gray-400">
                                <i class='bx bx-selection text-6xl mb-3'></i>
                                <p class="text-sm">Select submission and reviewer to see preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Reviewer Workload Overview -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Reviewer Workload Overview</h3>

            @if ($reviewers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Reviewer</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Active
                                    Reviews</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Completed
                                    Reviews</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Workload
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($reviewers as $reviewer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($reviewer->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $reviewer->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $reviewer->email }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            {{ $reviewerWorkload[$reviewer->id]['active'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            {{ $reviewerWorkload[$reviewer->id]['completed'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold text-gray-900">
                                        {{ $reviewerWorkload[$reviewer->id]['total'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $active = $reviewerWorkload[$reviewer->id]['active'];
                                            $maxWorkload = 10; // Adjust based on your needs
                                            $percentage = min(($active / $maxWorkload) * 100, 100);
                                            $color = $percentage > 80 ? 'red' : ($percentage > 50 ? 'yellow' : 'green');
                                        @endphp
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-{{ $color }}-500 h-2 rounded-full"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1 text-center">
                                            {{ $active }}/{{ $maxWorkload }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class='bx bx-user-x text-6xl text-gray-400 mb-4'></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Reviewers Found</h3>
                    <p class="text-gray-600">Please ensure users with the "reviewer_inovchalange" role exist in the system.
                    </p>
                </div>
            @endif
        </div>

        <!-- Current Assignments (if viewing specific submission) -->
        @if ($selectedSubmission)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Current Reviewer Assignments</h3>

                @if ($selectedSubmission->reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach (['phase_1', 'phase_2', 'phase_3'] as $phase)
                            @php
                                $phaseReviews = $selectedSubmission->reviews->where('phase', $phase);
                            @endphp
                            @if ($phaseReviews->count() > 0)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-3">
                                        {{ ucfirst(str_replace('_', ' ', $phase)) }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach ($phaseReviews as $review)
                                            <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                                        {{ strtoupper(substr($review->reviewer->name ?? 'R', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900 text-sm">
                                                            {{ $review->reviewer->name ?? 'N/A' }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            Status:
                                                            <span
                                                                class="font-semibold
                                                            @if ($review->status == 'completed') text-green-600
                                                            @elseif($review->status == 'in_progress') text-yellow-600
                                                            @else text-blue-600 @endif">
                                                                {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                @if ($review->status != 'completed')
                                                    <form
                                                        action="{{ route('admin.inov_challenge.reviewers.remove', $review->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Remove this reviewer?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-600 py-8">No reviewers assigned yet.</p>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function assignmentForm() {
            return {
                submissionId: '{{ $selectedSubmission->id ?? '' }}',
                phase: '',
                reviewerId: '',
                submissionTitle: '{{ $selectedSubmission->title ?? '' }}',
                submissionUser: '{{ $selectedSubmission->user->name ?? '' }}',
                submissionSession: '{{ $selectedSubmission->session->title ?? '' }}',
                reviewerName: '',
                reviewerEmail: '',
                reviewerActiveReviews: 0,
                reviewerCompletedReviews: 0,

                updateSubmissionInfo() {
                    const select = document.querySelector('select[name="submission_id"]');
                    const option = select.options[select.selectedIndex];

                    if (option && option.value) {
                        this.submissionTitle = option.getAttribute('data-title') || '';
                        this.submissionUser = option.getAttribute('data-user') || '';
                        this.submissionSession = option.getAttribute('data-session') || '';
                    } else {
                        this.submissionTitle = '';
                        this.submissionUser = '';
                        this.submissionSession = '';
                    }
                },

                updateReviewerInfo() {
                    const select = document.querySelector('select[name="reviewer_id"]');
                    const option = select.options[select.selectedIndex];

                    if (option && option.value) {
                        this.reviewerName = option.getAttribute('data-name') || '';
                        this.reviewerEmail = option.getAttribute('data-email') || '';
                        this.reviewerActiveReviews = option.getAttribute('data-active') || 0;
                        this.reviewerCompletedReviews = option.getAttribute('data-completed') || 0;
                    } else {
                        this.reviewerName = '';
                        this.reviewerEmail = '';
                        this.reviewerActiveReviews = 0;
                        this.reviewerCompletedReviews = 0;
                    }
                }
            }
        }
    </script>
@endpush
