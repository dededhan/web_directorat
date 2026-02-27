@extends('inov_challenge.admin.layout')

@section('title', 'Session Details - ' . $session->title)

@section('page-title', $session->title)
@section('page-description', 'Innovation Challenge Session Details')

@section('content')
    <div class="space-y-6">
        <!-- Action Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition-colors">
                <i class='bx bx-arrow-back mr-2'></i>
                Back to Sessions
            </a>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.inov_challenge.sessions.edit', $session->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-edit mr-2'></i>
                    Edit
                </a>
                <a href="{{ route('admin.inov_challenge.forms.index', ['session' => $session->id]) }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-layout mr-2'></i>
                    Form Builder
                </a>
            </div>
        </div>

        <!-- Session Info Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Session Information</h3>
                    <p class="text-indigo-100 text-sm mt-1">Created by {{ $session->creator->name ?? 'Admin' }} on
                        {{ $session->created_at->format('d M Y') }}</p>
                </div>
                <span
                    class="px-4 py-2 text-sm font-bold rounded-full
                @if ($session->status == 'active') bg-green-500 text-white
                @elseif($session->status == 'closed') bg-gray-500 text-white
                @else bg-yellow-500 text-white @endif">
                    {{ strtoupper($session->status) }}
                </span>
            </div>

            <div class="p-6 space-y-6">
                <!-- Description -->
                @if ($session->description)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Description</h4>
                        <p class="text-gray-600 leading-relaxed">{{ $session->description }}</p>
                    </div>
                @endif

                <!-- Date Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-event text-2xl text-blue-600 mr-2'></i>
                            <h4 class="text-sm font-semibold text-gray-700">Start Date</h4>
                        </div>
                        <p class="text-lg font-bold text-gray-900">{{ $session->start_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $session->start_date->diffForHumans() }}</p>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-check text-2xl text-green-600 mr-2'></i>
                            <h4 class="text-sm font-semibold text-gray-700">End Date</h4>
                        </div>
                        <p class="text-lg font-bold text-gray-900">{{ $session->end_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $session->end_date->diffForHumans() }}</p>
                    </div>

                    <div class="bg-orange-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-x text-2xl text-orange-600 mr-2'></i>
                            <h4 class="text-sm font-semibold text-gray-700">Registration Deadline</h4>
                        </div>
                        <p class="text-lg font-bold text-gray-900">{{ $session->registration_deadline->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $session->registration_deadline->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-4">
                        <i class='bx bx-group text-3xl text-indigo-600'></i>
                        <div>
                            <p class="text-sm text-gray-600">Maximum Participants</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $session->max_participants ?? 'Unlimited' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-4">
                        <i class='bx bx-time text-3xl text-purple-600'></i>
                        <div>
                            <p class="text-sm text-gray-600">Duration</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $session->start_date->diffInDays($session->end_date) }} days
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistics['total_submissions'] }}</p>
                    </div>
                    <i class='bx bx-file text-4xl text-indigo-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Draft</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistics['draft_submissions'] }}</p>
                    </div>
                    <i class='bx bx-edit text-4xl text-gray-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Submitted</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistics['submitted_submissions'] }}</p>
                    </div>
                    <i class='bx bx-send text-4xl text-yellow-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Approved</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistics['approved_submissions'] }}</p>
                    </div>
                    <i class='bx bx-check-circle text-4xl text-green-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Rejected</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistics['rejected_submissions'] }}</p>
                    </div>
                    <i class='bx bx-x-circle text-4xl text-red-500'></i>
                </div>
            </div>
        </div>

        <!-- Form Builder Status (if needed) -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class='bx bx-layout mr-2 text-indigo-600'></i>
                Form Builder Status
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach (['phase_1', 'phase_2', 'phase_3'] as $phase)
                    @php
                        $formBuilder = $session->formBuilders->where('phase', $phase)->first();
                    @endphp
                    <div
                        class="border rounded-lg p-4 {{ $formBuilder ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }}">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $phase)) }}</h4>
                            @if ($formBuilder)
                                <i class='bx bx-check-circle text-2xl text-green-600'></i>
                            @else
                                <i class='bx bx-x-circle text-2xl text-red-600'></i>
                            @endif
                        </div>
                        <p class="text-sm {{ $formBuilder ? 'text-green-700' : 'text-red-700' }}">
                            {{ $formBuilder ? 'Form configured' : 'Form not configured' }}
                        </p>
                        @if ($formBuilder)
                            <p class="text-xs text-gray-600 mt-1">{{ count($formBuilder->form_config) }} fields</p>
                        @endif
                    </div>
                @endforeach
            </div>
            @if ($session->formBuilders->count() < 3)
                <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class='bx bx-info-circle mr-1'></i>
                        Configure forms for all phases before activating this session.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
