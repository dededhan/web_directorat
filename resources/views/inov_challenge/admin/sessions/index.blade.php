@extends('inov_challenge.admin.layout')

@section('title', 'Manage Innovation Challenge Sessions')

@section('page-title', 'Kelola Sesi')
@section('page-description', 'Manage Innovation Challenge sessions and their configurations')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">All Sessions</h2>
                <p class="text-sm text-gray-600 mt-1">Create and manage Innovation Challenge sessions</p>
            </div>
            <a href="{{ route('admin.inov_challenge.sessions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-lg transition-all transform hover:scale-105">
                <i class='bx bx-plus-circle text-xl mr-2'></i>
                Create New Session
            </a>
        </div>

        <!-- Sessions List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @if ($sessions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b-2 border-indigo-200">
                            <tr>
                                <th
                                    class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">
                                    Session Info</th>
                                <th
                                    class="text-center py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">
                                    Dates</th>
                                <th
                                    class="text-center py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">
                                    Submissions</th>
                                <th
                                    class="text-center py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="text-center py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($sessions as $session)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Session Info -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-gradient-to-br 
                                            @if ($session->status == 'active') from-green-400 to-emerald-500
                                            @elseif($session->status == 'closed') from-gray-400 to-gray-500
                                            @else from-yellow-400 to-orange-500 @endif
                                            flex items-center justify-center text-white shadow-lg">
                                                    <i class='bx bxs-calendar text-2xl'></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('admin.inov_challenge.sessions.show', $session->id) }}"
                                                    class="text-base font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                                                    {{ $session->title }}
                                                </a>
                                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                                    {{ Str::limit($session->description, 80) }}
                                                </p>
                                                <div class="flex items-center mt-2 space-x-3 text-xs text-gray-500">
                                                    <span class="flex items-center">
                                                        <i class='bx bx-user mr-1'></i>
                                                        {{ $session->creator->name ?? 'Admin' }}
                                                    </span>
                                                    @if ($session->max_participants)
                                                        <span class="flex items-center">
                                                            <i class='bx bx-group mr-1'></i>
                                                            Max: {{ $session->max_participants }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Dates -->
                                    <td class="py-4 px-6">
                                        <div class="text-sm space-y-2">
                                            <div class="flex flex-col">
                                                <span class="text-gray-500 text-xs">Start:</span>
                                                <span
                                                    class="font-medium text-gray-900">{{ $session->start_date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-gray-500 text-xs">End:</span>
                                                <span
                                                    class="font-medium text-gray-900">{{ $session->end_date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-gray-500 text-xs">Registration:</span>
                                                <span
                                                    class="font-medium text-gray-900">{{ $session->registration_deadline->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Submissions Count -->
                                    <td class="py-4 px-6 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-3xl font-bold text-indigo-600">
                                                {{ $session->submissions()->count() }}
                                            </span>
                                            <span class="text-xs text-gray-500 mt-1">submissions</span>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-6 text-center">
                                        <span
                                            class="px-3 py-1.5 text-xs font-bold rounded-full uppercase tracking-wide
                                    @if ($session->status == 'active') bg-green-100 text-green-800
                                    @elseif($session->status == 'closed') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $session->status }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- View Details -->
                                            <a href="{{ route('admin.inov_challenge.sessions.show', $session->id) }}"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="View Details">
                                                <i class='bx bx-show text-xl'></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.inov_challenge.sessions.edit', $session->id) }}"
                                                class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                                                title="Edit">
                                                <i class='bx bx-edit text-xl'></i>
                                            </a>

                                            <!-- Activate/Close -->
                                            @if ($session->status == 'draft')
                                                <form
                                                    action="{{ route('admin.inov_challenge.sessions.activate', $session->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to activate this session?')">
                                                    @csrf
                                                    <button type="submit"
                                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                        title="Activate">
                                                        <i class='bx bx-play-circle text-xl'></i>
                                                    </button>
                                                </form>
                                            @elseif($session->status == 'active')
                                                <form
                                                    action="{{ route('admin.inov_challenge.sessions.close', $session->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to close this session? This action cannot be undone.')">
                                                    @csrf
                                                    <button type="submit"
                                                        class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"
                                                        title="Close">
                                                        <i class='bx bx-stop-circle text-xl'></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete -->
                                            @if ($session->submissions()->count() == 0)
                                                <form
                                                    action="{{ route('admin.inov_challenge.sessions.destroy', $session->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this session? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Delete">
                                                        <i class='bx bx-trash text-xl'></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Form Builder -->
                                            <a href="{{ route('admin.inov_challenge.forms.index', ['session' => $session->id]) }}"
                                                class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                                title="Form Builder">
                                                <i class='bx bx-layout text-xl'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $sessions->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div
                        class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 mb-6">
                        <i class='bx bx-calendar-x text-5xl text-indigo-600'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Sessions Yet</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        Get started by creating your first Innovation Challenge session. Sessions help organize submissions
                        by timeframe.
                    </p>
                    <a href="{{ route('admin.inov_challenge.sessions.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-lg transition-all transform hover:scale-105">
                        <i class='bx bx-plus-circle text-xl mr-2'></i>
                        Create Your First Session
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        @if ($sessions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Active Sessions</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $sessions->where('status', 'active')->count() }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-check-circle text-2xl text-green-600'></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Draft Sessions</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $sessions->where('status', 'draft')->count() }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Closed Sessions</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $sessions->where('status', 'closed')->count() }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-lock text-2xl text-gray-600'></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
