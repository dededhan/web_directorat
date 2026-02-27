@extends('inov_challenge.admin.layout')

@section('title', 'Create Innovation Challenge Session')

@section('page-title', 'Create New Session')
@section('page-description', 'Create a new Innovation Challenge session with custom configuration')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class='bx bx-plus-circle mr-2 text-2xl'></i>
                    Create Innovation Challenge Session
                </h3>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.inov_challenge.sessions.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Session Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
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
                        placeholder="Describe the Innovation Challenge session, objectives, and requirements...">{{ old('description') }}</textarea>
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
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
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
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
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
                            value="{{ old('registration_deadline') }}"
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
                        value="{{ old('max_participants') }}" min="1"
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

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex">
                        <i class='bx bx-info-circle text-blue-600 text-2xl mr-3'></i>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">Session Workflow</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• New sessions start in <strong>Draft</strong> status</li>
                                <li>• You need to configure forms for all 3 phases before activation</li>
                                <li>• Once activated, the session becomes visible to participants</li>
                                <li>• Closed sessions cannot be reopened</li>
                            </ul>
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
                        Create Session
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
    </script>
@endpush
