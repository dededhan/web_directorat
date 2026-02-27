@extends('inov_challenge.admin.layout')

@section('title', 'Innovation Challenge - Dashboard')

@section('page-title', 'Dashboard')
@section('page-description', 'Overview Innovation Challenge System')

@section('content')
    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Sessions -->
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Sesi</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $statistics['total_sessions'] }}</h3>
                        <p class="text-blue-100 text-xs mt-1">{{ $statistics['active_sessions'] }} Active</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class='bx bxs-calendar text-4xl'></i>
                    </div>
                </div>
            </div>

            <!-- Total Submissions -->
            <div
                class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Submissions</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $statistics['total_submissions'] }}</h3>
                        <p class="text-purple-100 text-xs mt-1">All phases</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class='bx bxs-file-doc text-4xl'></i>
                    </div>
                </div>
            </div>

            <!-- Pending Reviews -->
            <div
                class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Pending Reviews</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $statistics['pending_reviews'] }}</h3>
                        <p class="text-orange-100 text-xs mt-1">Need attention</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class='bx bxs-hourglass text-4xl'></i>
                    </div>
                </div>
            </div>

            <!-- Total Reviewers -->
            <div
                class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Reviewers</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $statistics['total_reviewers'] }}</h3>
                        <p class="text-green-100 text-xs mt-1">{{ $statistics['completed_reviews'] }} Completed</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class='bx bxs-user-check text-4xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Submission Status Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class='bx bxs-pie-chart-alt-2 mr-2 text-indigo-600'></i>
                    Submission Status
                </h3>
                <canvas id="submissionStatusChart" height="250"></canvas>
            </div>

            <!-- Phase Statistics Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class='bx bxs-bar-chart-alt-2 mr-2 text-indigo-600'></i>
                    Submissions by Phase
                </h3>
                <canvas id="phaseChart" height="250"></canvas>
            </div>
        </div>

        <!-- Pending Actions Alert -->
        @if ($pendingReviewAssignments->count() > 0 || $statistics['pending_reviews'] > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <i class='bx bx-error text-3xl text-yellow-600 mr-4'></i>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-yellow-800 mb-2">Pending Actions</h3>
                        <ul class="space-y-2 text-yellow-700">
                            @if ($pendingReviewAssignments->count() > 0)
                                <li class="flex items-center">
                                    <i class='bx bx-chevron-right mr-2'></i>
                                    <span><strong>{{ $pendingReviewAssignments->count() }}</strong> submissions awaiting
                                        reviewer assignment</span>
                                </li>
                            @endif
                            @if ($statistics['pending_reviews'] > 0)
                                <li class="flex items-center">
                                    <i class='bx bx-chevron-right mr-2'></i>
                                    <span><strong>{{ $statistics['pending_reviews'] }}</strong> reviews pending
                                        completion</span>
                                </li>
                            @endif
                        </ul>
                        <div class="mt-4 flex space-x-3">
                            @if ($pendingReviewAssignments->count() > 0)
                                <a href="{{ route('admin.inov_challenge.submissions.index') }}?status=submitted"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <i class='bx bx-user-plus mr-2'></i>
                                    Assign Reviewers
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Submissions and Sessions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Submissions -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class='bx bx-time-five mr-2 text-indigo-600'></i>
                        Recent Submissions
                    </h3>
                    <a href="{{ route('admin.inov_challenge.submissions.index') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        View All →
                    </a>
                </div>

                @if ($recentSubmissions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Title</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Leader</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Session</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($recentSubmissions as $submission)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <a href="{{ route('admin.inov_challenge.submissions.show', $submission->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                                {{ Str::limit($submission->title ?? 'Untitled', 40) }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">{{ $submission->user->name ?? '-' }}</td>
                                        <td class="py-3 px-4 text-gray-600">
                                            {{ Str::limit($submission->session->title ?? '-', 20) }}</td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if ($submission->final_status == 'approved') bg-green-100 text-green-800
                                        @elseif($submission->final_status == 'rejected') bg-red-100 text-red-800
                                        @elseif($submission->final_status == 'under_review') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $submission->final_status)) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-500 text-xs">
                                            {{ $submission->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class='bx bx-file text-4xl mb-2'></i>
                        <p>No recent submissions</p>
                    </div>
                @endif
            </div>

            <!-- Active Sessions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class='bx bxs-calendar-check mr-2 text-indigo-600'></i>
                        Sessions
                    </h3>
                    <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        View All →
                    </a>
                </div>

                @if ($sessions->count() > 0)
                    <div class="space-y-3">
                        @foreach ($sessions as $session)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 mb-1">{{ Str::limit($session->title, 30) }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mb-2">{{ $session->submissions_count }} submissions
                                        </p>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if ($session->status == 'active') bg-green-100 text-green-800
                                    @elseif($session->status == 'closed') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class='bx bx-calendar-x text-4xl mb-2'></i>
                        <p class="text-sm">No sessions available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reviewer Workload -->
        @if ($reviewerWorkload->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class='bx bxs-user-detail mr-2 text-indigo-600'></i>
                    Reviewer Workload
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Reviewer</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700">Total</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700">Pending</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700">In Progress</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700">Completed</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($reviewerWorkload as $workload)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-xs mr-3">
                                                {{ strtoupper(substr($workload->reviewer->name ?? 'R', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    {{ $workload->reviewer->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-gray-500">{{ $workload->reviewer->email ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center font-semibold text-gray-800">
                                        {{ $workload->total_reviews }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span
                                            class="px-2 py-1 bg-orange-100 text-orange-800 text-xs font-semibold rounded-full">
                                            {{ $workload->pending }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                            {{ $workload->in_progress }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                            {{ $workload->completed }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Submission Status Pie Chart
        const submissionStatusCtx = document.getElementById('submissionStatusChart').getContext('2d');
        new Chart(submissionStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Draft', 'Submitted', 'Reviewed', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $submissionStats['draft'] }},
                        {{ $submissionStats['submitted'] }},
                        {{ $submissionStats['reviewed'] }},
                        {{ $submissionStats['approved'] }},
                        {{ $submissionStats['rejected'] }}
                    ],
                    backgroundColor: [
                        '#9CA3AF', // gray
                        '#3B82F6', // blue
                        '#F59E0B', // yellow
                        '#10B981', // green
                        '#EF4444' // red
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Phase Statistics Bar Chart
        const phaseCtx = document.getElementById('phaseChart').getContext('2d');
        new Chart(phaseCtx, {
            type: 'bar',
            data: {
                labels: ['Phase 1', 'Phase 2', 'Phase 3'],
                datasets: [{
                        label: 'Submitted',
                        data: [
                            {{ $phaseStats['phase_1']['submitted'] }},
                            {{ $phaseStats['phase_2']['submitted'] }},
                            {{ $phaseStats['phase_3']['submitted'] }}
                        ],
                        backgroundColor: '#3B82F6'
                    },
                    {
                        label: 'Under Review',
                        data: [
                            {{ $phaseStats['phase_1']['under_review'] }},
                            {{ $phaseStats['phase_2']['under_review'] }},
                            {{ $phaseStats['phase_3']['under_review'] }}
                        ],
                        backgroundColor: '#F59E0B'
                    },
                    {
                        label: 'Approved',
                        data: [
                            {{ $phaseStats['phase_1']['approved'] }},
                            {{ $phaseStats['phase_2']['approved'] }},
                            {{ $phaseStats['phase_3']['approved'] }}
                        ],
                        backgroundColor: '#10B981'
                    },
                    {
                        label: 'Rejected',
                        data: [
                            {{ $phaseStats['phase_1']['rejected'] }},
                            {{ $phaseStats['phase_2']['rejected'] }},
                            {{ $phaseStats['phase_3']['rejected'] }}
                        ],
                        backgroundColor: '#EF4444'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
