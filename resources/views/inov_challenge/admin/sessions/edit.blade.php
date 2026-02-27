@extends('inov_challenge.admin.layout')

@section('title', 'Edit Innovation Challenge Session')

@section('page-title', 'Edit Session')
@section('page-description', 'Update Innovation Challenge session configuration')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class='bx bx-edit mr-2 text-2xl'></i>
                    Edit Session: {{ $session->title }}
                </h3>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.inov_challenge.sessions.update', $session->id) }}" method="POST"
                class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Session Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $session->title) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('title') border-red-500 @enderror"
                        placeholder="e.g., Innovation Challenge 2026 - Semester 1" required>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('description') border-red-500 @enderror"
                        placeholder="Describe the Innovation Challenge session, objectives, and requirements...">{{ old('description', $session->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Provide a clear description to help participants understand the
                        session</p>
                </div>

                <!-- Date Fields (Grid) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', $session->start_date->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('start_date') border-red-500 @enderror"
                            required>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', $session->end_date->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('end_date') border-red-500 @enderror"
                            required>
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Registration Deadline -->
                    <div>
                        <label for="registration_deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                            Registration Deadline <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="registration_deadline" id="registration_deadline"
                            value="{{ old('registration_deadline', $session->registration_deadline->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('registration_deadline') border-red-500 @enderror"
                            required>
                        @error('registration_deadline')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Max Participants -->
                <div>
                    <label for="max_participants" class="block text-sm font-semibold text-gray-700 mb-2">
                        Maximum Participants
                    </label>
                    <input type="number" name="max_participants" id="max_participants"
                        value="{{ old('max_participants', $session->max_participants) }}" min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('max_participants') border-red-500 @enderror"
                        placeholder="Leave empty for unlimited">
                    @error('max_participants')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Set a limit for the number of submissions allowed (optional)</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('status') border-red-500 @enderror"
                        required>
                        <option value="draft" {{ old('status', $session->status) == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                        <option value="active" {{ old('status', $session->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="closed" {{ old('status', $session->status) == 'closed' ? 'selected' : '' }}>
                            Closed
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="mt-2 text-xs space-y-1">
                        <p class="text-gray-600"><strong>Draft:</strong> Session is being configured, not visible to
                            participants</p>
                        <p class="text-gray-600"><strong>Active:</strong> Session is open for submissions</p>
                        <p class="text-gray-600"><strong>Closed:</strong> Session is closed, no new submissions allowed</p>
                    </div>
                </div>

                <!-- Warning Box for Status Change -->
                @if ($session->status == 'active')
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                        <div class="flex">
                            <i class='bx bx-error text-yellow-600 text-2xl mr-3'></i>
                            <div>
                                <h4 class="text-sm font-semibold text-yellow-900 mb-1">Caution</h4>
                                <p class="text-sm text-yellow-800">
                                    This session is currently active. Changing dates or status may affect ongoing
                                    submissions.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Session Statistics -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Session Statistics</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ $session->submissions()->count() }}</p>
                            <p class="text-xs text-gray-600 mt-1">Total Submissions</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">
                                {{ $session->submissions()->where('final_status', 'approved')->count() }}</p>
                            <p class="text-xs text-gray-600 mt-1">Approved</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ $session->submissions()->whereIn('final_status', ['submitted', 'under_review', 'reviewed'])->count() }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1">In Progress</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-red-600">
                                {{ $session->submissions()->where('final_status', 'rejected')->count() }}</p>
                            <p class="text-xs text-gray-600 mt-1">Rejected</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition-colors">
                        <i class='bx bx-arrow-back mr-2'></i>
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-lg transition-all transform hover:scale-105">
                        <i class='bx bx-save mr-2'></i>
                        Update Session
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Date validation
        document.getElementById('end_date').addEventListener('change', function() {
            const startDate = document.getElementById('start_date').value;
            const endDate = this.value;

            if (startDate && endDate && endDate < startDate) {
                alert('End date must be after start date');
                this.value = '';
            }
        });

        document.getElementById('registration_deadline').addEventListener('change', function() {
            const endDate = document.getElementById('end_date').value;
            const regDeadline = this.value;

            if (endDate && regDeadline && regDeadline > endDate) {
                alert('Registration deadline must be before or equal to end date');
                this.value = '';
            }
        });

        // Status change confirmation
        const statusSelect = document.getElementById('status');
        const originalStatus = '{{ $session->status }}';

        statusSelect.addEventListener('change', function() {
            if (originalStatus === 'active' && this.value === 'closed') {
                if (!confirm(
                        'Are you sure you want to close this session? This action cannot be undone. All draft submissions will be cancelled.'
                        )) {
                    this.value = originalStatus;
                }
            }
        });
    </script>
@endpush
