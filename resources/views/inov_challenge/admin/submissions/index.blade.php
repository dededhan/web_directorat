@extends('inov_challenge.admin.layout')

@section('title', 'Submissions Management')

@section('page-title', 'Submissions')
@section('page-description', 'Kelola submission Innovation Challenge')

@section('content')
    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Submissions</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $statistics['total'] }}</p>
                    </div>
                    <i class='bx bx-file text-3xl text-indigo-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-gray-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Draft</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $statistics['draft'] }}</p>
                    </div>
                    <i class='bx bx-edit text-3xl text-gray-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">In Progress</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $statistics['submitted'] }}</p>
                    </div>
                    <i class='bx bx-time text-3xl text-yellow-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Approved</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $statistics['approved'] }}</p>
                    </div>
                    <i class='bx bx-check-circle text-3xl text-green-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Rejected</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $statistics['rejected'] }}</p>
                    </div>
                    <i class='bx bx-x-circle text-3xl text-red-500'></i>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('admin.inov_challenge.submissions.index') }}" method="GET" class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Filter & Search</h3>
                    <div class="flex items-center space-x-3">
                        @if (request()->hasAny(['session_id', 'status', 'phase', 'search']))
                            <a href="{{ route('admin.inov_challenge.submissions.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-800">
                                <i class='bx bx-x-circle mr-1'></i>
                                Clear Filters
                            </a>
                        @endif
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-search mr-2'></i>
                            Apply Filters
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Title, name, email..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <!-- Session Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Session</label>
                        <select name="session_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">All Sessions</option>
                            @foreach ($sessions as $session)
                                <option value="{{ $session->id }}"
                                    {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                    {{ $session->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted
                            </option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under
                                Review</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <!-- Phase Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phase</label>
                        <select name="phase"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">All Phases</option>
                            <option value="phase_1" {{ request('phase') == 'phase_1' ? 'selected' : '' }}>Phase 1</option>
                            <option value="phase_2" {{ request('phase') == 'phase_2' ? 'selected' : '' }}>Phase 2</option>
                            <option value="phase_3" {{ request('phase') == 'phase_3' ? 'selected' : '' }}>Phase 3</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div
                class="px-6 py-4 border-b bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Submissions List</h3>
                    <p class="text-indigo-100 text-sm mt-1">{{ $submissions->total() }} submissions found</p>
                </div>
                <a href="{{ route('admin.inov_challenge.submissions.export', request()->all()) }}"
                    class="px-4 py-2 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors font-medium">
                    <i class='bx bx-download mr-2'></i>
                    Export to Excel
                </a>
            </div>

            @if ($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Submission Info
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Session
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Team Members
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Phase Progress
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($submissions as $submission)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Submission Info -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            <i class='bx bx-file-blank text-3xl text-indigo-600 mt-1'></i>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $submission->title }}</p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    <i class='bx bx-user'></i>
                                                    {{ $submission->user->name ?? 'N/A' }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Submitted: {{ $submission->created_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Session -->
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $submission->session->title ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $submission->session->start_date->format('d M Y') ?? '' }}
                                        </p>
                                    </td>

                                    <!-- Team Members -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-group text-xl text-gray-600'></i>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $submission->teamMembers->count() + 1 }} members
                                            </span>
                                        </div>
                                        @if ($submission->teamMembers->count() > 0)
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $submission->teamMembers->pluck('user.name')->take(2)->join(', ') }}
                                                @if ($submission->teamMembers->count() > 2)
                                                    +{{ $submission->teamMembers->count() - 2 }} more
                                                @endif
                                            </p>
                                        @endif
                                    </td>

                                    <!-- Phase Progress -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            @foreach (['phase_1', 'phase_2', 'phase_3'] as $phase)
                                                @php
                                                    $phaseStatus = $submission->{$phase . '_status'};
                                                    $phaseData = $submission->{$phase . '_data'};
                                                    $phaseColor = 'gray';
                                                    $phaseIcon = 'bx-circle';

                                                    if ($phaseData) {
                                                        if ($phaseStatus == 'approved') {
                                                            $phaseColor = 'green';
                                                            $phaseIcon = 'bx-check-circle';
                                                        } elseif ($phaseStatus == 'rejected') {
                                                            $phaseColor = 'red';
                                                            $phaseIcon = 'bx-x-circle';
                                                        } elseif (
                                                            in_array($phaseStatus, [
                                                                'submitted',
                                                                'under_review',
                                                                'reviewed',
                                                            ])
                                                        ) {
                                                            $phaseColor = 'yellow';
                                                            $phaseIcon = 'bx-time-five';
                                                        } else {
                                                            $phaseColor = 'blue';
                                                            $phaseIcon = 'bx-edit';
                                                        }
                                                    }
                                                @endphp
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                                {{ $phaseColor == 'green'
                                                    ? 'bg-green-100'
                                                    : ($phaseColor == 'red'
                                                        ? 'bg-red-100'
                                                        : ($phaseColor == 'yellow'
                                                            ? 'bg-yellow-100'
                                                            : ($phaseColor == 'blue'
                                                                ? 'bg-blue-100'
                                                                : 'bg-gray-100'))) }}"
                                                    title="{{ ucfirst(str_replace('_', ' ', $phase)) }}: {{ $phaseStatus ?? 'Not started' }}">
                                                    <i class='bx {{ $phaseIcon }} text-{{ $phaseColor }}-600'></i>
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            @php
                                                $completedPhases = collect(['phase_1', 'phase_2', 'phase_3'])
                                                    ->filter(fn($p) => $submission->{$p . '_status'} == 'approved')
                                                    ->count();
                                            @endphp
                                            {{ $completedPhases }}/3 completed
                                        </p>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($submission->final_status == 'approved') bg-green-100 text-green-800
                                        @elseif($submission->final_status == 'rejected') bg-red-100 text-red-800
                                        @elseif(in_array($submission->final_status, ['submitted', 'under_review', 'reviewed'])) bg-yellow-100 text-yellow-800
                                        @elseif($submission->final_status == 'draft') bg-gray-100 text-gray-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $submission->final_status)) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.inov_challenge.submissions.show', $submission->id) }}"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="View Details">
                                                <i class='bx bx-show text-xl'></i>
                                            </a>

                                            @if ($submission->final_status == 'reviewed')
                                                <button type="button"
                                                    onclick="if(confirm('Approve this submission?')) window.location.href='{{ route('admin.inov_challenge.submissions.approve', [$submission->id, 'phase_1']) }}'"
                                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                    title="Approve">
                                                    <i class='bx bx-check-circle text-xl'></i>
                                                </button>
                                                <button type="button"
                                                    onclick="if(confirm('Reject this submission?')) window.location.href='{{ route('admin.inov_challenge.submissions.reject', [$submission->id, 'phase_1']) }}'"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Reject">
                                                    <i class='bx bx-x-circle text-xl'></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t bg-gray-50">
                    {{ $submissions->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <i class='bx bx-file-blank text-6xl text-gray-400 mb-4'></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Submissions Found</h3>
                    <p class="text-gray-600 mb-6">
                        @if (request()->hasAny(['session_id', 'status', 'phase', 'search']))
                            No submissions match your current filters. Try adjusting your search criteria.
                        @else
                            There are no submissions yet. Submissions will appear here once participants submit their work.
                        @endif
                    </p>
                    @if (request()->hasAny(['session_id', 'status', 'phase', 'search']))
                        <a href="{{ route('admin.inov_challenge.submissions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-x-circle mr-2'></i>
                            Clear All Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
