@extends('inov_challenge.admin.layout')

@section('title', 'Form Preview - ' . ucfirst(str_replace('_', ' ', $form->phase)))

@section('page-title', 'Form Preview')
@section('page-description', ucfirst(str_replace('_', ' ', $form->phase)))

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $session->title }}</h2>
                <p class="text-sm text-gray-600 mt-1">Preview: {{ ucfirst(str_replace('_', ' ', $form->phase)) }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.inov_challenge.forms.index', $session->id) }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Back to Forms
                </a>
                <a href="{{ route('admin.inov_challenge.forms.edit', ['session' => $session->id, 'form' => $form->id]) }}"
                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg">
                    <i class='bx bx-edit mr-2'></i>
                    Edit Form
                </a>
            </div>
        </div>

        <!-- Info Alert -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex items-start">
                <i class='bx bx-info-circle text-2xl text-blue-600 mr-3 mt-0.5'></i>
                <div>
                    <h3 class="font-semibold text-blue-800">Preview Mode</h3>
                    <p class="text-sm text-blue-700 mt-1">
                        This is how the form will appear to participants. This is a preview only - submissions will not be
                        saved.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Preview -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <div class="max-w-3xl mx-auto">
                <!-- Form Header -->
                <div class="mb-8 pb-6 border-b">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ ucfirst(str_replace('_', ' ', $form->phase)) }}
                    </h3>
                    <p class="text-gray-600">Session: {{ $session->title }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class='bx bx-info-circle mr-1'></i>
                        Fields marked with <span class="text-red-600 font-bold">*</span> are required
                    </p>
                </div>

                <!-- Form Fields -->
                <form class="space-y-6">
                    @foreach ($form->form_config as $field)
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ $field['label'] }}
                                @if ($field['required'] ?? false)
                                    <span class="text-red-600">*</span>
                                @endif
                            </label>

                            @switch($field['type'])
                                @case('text')
                                @case('email')

                                @case('number')
                                @case('date')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        {{ $field['required'] ?? false ? 'required' : '' }}
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                @break

                                @case('textarea')
                                    <textarea name="{{ $field['name'] }}" rows="{{ $field['rows'] ?? 5 }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}" {{ $field['required'] ?? false ? 'required' : '' }}
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                                @break

                                @case('select')
                                    <select name="{{ $field['name'] }}" {{ $field['required'] ?? false ? 'required' : '' }}
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">- Select {{ $field['label'] }} -</option>
                                        @foreach ($field['options'] ?? [] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                @break

                                @case('radio')
                                    <div class="space-y-2">
                                        @foreach ($field['options'] ?? [] as $key => $value)
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="{{ $field['name'] }}" value="{{ $key }}"
                                                    {{ $field['required'] ?? false ? 'required' : '' }}
                                                    class="w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                                                <span class="ml-3 text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @break

                                @case('checkbox')
                                    <div class="space-y-2">
                                        @foreach ($field['options'] ?? [] as $key => $value)
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" name="{{ $field['name'] }}[]" value="{{ $key }}"
                                                    class="w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                                                <span class="ml-3 text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @break

                                @case('file')
                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-500 transition-colors">
                                        <i class='bx bx-cloud-upload text-4xl text-gray-400 mb-2'></i>
                                        <p class="text-sm text-gray-600 mb-2">Click to upload or drag and drop</p>
                                        @if (isset($field['accept']))
                                            <p class="text-xs text-gray-500">Accepted files: {{ $field['accept'] }}</p>
                                        @endif
                                        @if (isset($field['max_size']))
                                            <p class="text-xs text-gray-500">Max size:
                                                {{ number_format($field['max_size'] / 1024, 2) }} MB</p>
                                        @endif
                                        <input type="file" name="{{ $field['name'] }}" accept="{{ $field['accept'] ?? '' }}"
                                            {{ $field['multiple'] ?? false ? 'multiple' : '' }}
                                            {{ $field['required'] ?? false ? 'required' : '' }} class="hidden">
                                    </div>
                                @break
                            @endswitch

                            @if (isset($field['placeholder']) && !in_array($field['type'], ['text', 'email', 'number', 'textarea']))
                                <p class="text-xs text-gray-500 mt-1">{{ $field['placeholder'] }}</p>
                            @endif
                        </div>
                    @endforeach

                    <!-- Preview Actions (Disabled) -->
                    <div class="pt-6 border-t flex items-center justify-between">
                        <button type="button" disabled
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-400 bg-gray-50 font-medium cursor-not-allowed">
                            <i class='bx bx-save mr-2'></i>
                            Save as Draft
                        </button>
                        <button type="button" disabled
                            class="px-6 py-2 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed">
                            <i class='bx bx-send mr-2'></i>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Fields</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($form->form_config) }}</p>
                    </div>
                    <i class='bx bx-list-ul text-3xl text-indigo-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Required Fields</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ collect($form->form_config)->where('required', true)->count() }}
                        </p>
                    </div>
                    <i class='bx bx-error text-3xl text-red-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">File Uploads</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ collect($form->form_config)->where('type', 'file')->count() }}
                        </p>
                    </div>
                    <i class='bx bx-upload text-3xl text-green-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Last Updated</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ $form->updated_at->format('d M Y') }}</p>
                    </div>
                    <i class='bx bx-time text-3xl text-purple-500'></i>
                </div>
            </div>
        </div>
    </div>
@endsection
