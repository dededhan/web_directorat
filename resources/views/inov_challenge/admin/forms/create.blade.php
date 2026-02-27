@extends('inov_challenge.admin.layout')

@section('title', 'Create Form - ' . ucfirst(str_replace('_', ' ', $phase)))

@section('page-title', 'Create Form Builder')
@section('page-description', ucfirst(str_replace('_', ' ', $phase)))

@push('styles')
    <style>
        .dragging {
            opacity: 0.5;
        }

        .drag-over {
            border-top: 2px solid #6366f1;
        }

        .field-item:hover .drag-handle {
            opacity: 1;
        }

        .drag-handle {
            opacity: 0.3;
            transition: opacity 0.2s;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-6" x-data="formBuilder()">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $session->title }}</h2>
                <p class="text-sm text-gray-600 mt-1">Konfigurasi form untuk {{ ucfirst(str_replace('_', ' ', $phase)) }}</p>
            </div>
            <a href="{{ route('admin.inov_challenge.forms.index', $session->id) }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium">
                <i class='bx bx-arrow-back mr-2'></i>
                Back
            </a>
        </div>

        <!-- Main Form -->
        <form action="{{ route('admin.inov_challenge.forms.store', $session->id) }}" method="POST"
            @submit.prevent="submitForm">
            @csrf
            <input type="hidden" name="phase" value="{{ $phase }}">
            <input type="hidden" name="form_config" x-model="formConfigJSON">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Builder Panel -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Controls -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Form Fields</h3>
                            <span class="text-sm text-gray-600" x-text="fields.length + ' fields'"></span>
                        </div>

                        <!-- Add Field Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg transition-colors">
                                <i class='bx bx-plus-circle mr-2'></i>
                                Add Field
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute z-10 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 max-h-96 overflow-y-auto">
                                <div class="p-2">
                                    <template x-for="fieldType in fieldTypes" :key="fieldType.type">
                                        <button type="button" @click="addField(fieldType.type); open = false"
                                            class="w-full flex items-center px-4 py-3 hover:bg-indigo-50 rounded-lg transition-colors text-left">
                                            <i :class="fieldType.icon" class="text-2xl text-indigo-600 mr-3"></i>
                                            <div>
                                                <p class="font-semibold text-gray-800" x-text="fieldType.label"></p>
                                                <p class="text-xs text-gray-600" x-text="fieldType.description"></p>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fields List -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <template x-if="fields.length === 0">
                            <div class="text-center py-12">
                                <i class='bx bx-file-blank text-6xl text-gray-400 mb-4'></i>
                                <p class="text-gray-600">Belum ada field. Klik "Add Field" untuk memulai.</p>
                            </div>
                        </template>

                        <div class="space-y-3" x-ref="fieldsContainer">
                            <template x-for="(field, index) in fields" :key="field.id">
                                <div class="field-item border rounded-lg p-4 hover:shadow-md transition-shadow"
                                    :class="{
                                        'border-indigo-500 bg-indigo-50': selectedFieldIndex ===
                                            index,
                                        'border-gray-200': selectedFieldIndex !== index
                                    }"
                                    @click="selectField(index)">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <i
                                                class='bx bx-grid-vertical text-xl text-gray-400 cursor-move drag-handle'></i>
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-semibold text-gray-800"
                                                        x-text="field.label || 'Untitled Field'"></span>
                                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded"
                                                        x-text="field.type"></span>
                                                    <template x-if="field.required">
                                                        <span
                                                            class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded font-semibold">Required</span>
                                                    </template>
                                                </div>
                                                <p class="text-sm text-gray-600 mt-1"
                                                    x-text="field.name ? 'Name: ' + field.name : 'No name set'"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" @click.stop="moveField(index, -1)"
                                                :disabled="index === 0"
                                                class="p-1 text-gray-400 hover:text-indigo-600 disabled:opacity-30">
                                                <i class='bx bx-chevron-up text-xl'></i>
                                            </button>
                                            <button type="button" @click.stop="moveField(index, 1)"
                                                :disabled="index === fields.length - 1"
                                                class="p-1 text-gray-400 hover:text-indigo-600 disabled:opacity-30">
                                                <i class='bx bx-chevron-down text-xl'></i>
                                            </button>
                                            <button type="button" @click.stop="duplicateField(index)"
                                                class="p-1 text-gray-400 hover:text-green-600">
                                                <i class='bx bx-copy text-xl'></i>
                                            </button>
                                            <button type="button" @click.stop="removeField(index)"
                                                class="p-1 text-gray-400 hover:text-red-600">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Field Editor Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                        <template x-if="selectedFieldIndex === null">
                            <div class="text-center py-12">
                                <i class='bx bx-edit text-5xl text-gray-400 mb-4'></i>
                                <p class="text-gray-600 text-sm">Pilih field untuk mengedit propertinya</p>
                            </div>
                        </template>

                        <template x-if="selectedFieldIndex !== null && fields[selectedFieldIndex]">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-gray-800">Edit Field</h3>
                                    <button type="button" @click="selectedFieldIndex = null"
                                        class="text-gray-400 hover:text-gray-600">
                                        <i class='bx bx-x text-2xl'></i>
                                    </button>
                                </div>

                                <!-- Field Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Field Name *</label>
                                    <input type="text" x-model="fields[selectedFieldIndex].name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        placeholder="e.g., email, full_name">
                                    <p class="text-xs text-gray-500 mt-1">Nama unik untuk field ini (gunakan underscore,
                                        tanpa spasi)</p>
                                </div>

                                <!-- Field Label -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Label *</label>
                                    <input type="text" x-model="fields[selectedFieldIndex].label"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        placeholder="e.g., Email Address">
                                </div>

                                <!-- Field Type -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type *</label>
                                    <select x-model="fields[selectedFieldIndex].type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <template x-for="fieldType in fieldTypes" :key="fieldType.type">
                                            <option :value="fieldType.type" x-text="fieldType.label"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Required -->
                                <div>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="fields[selectedFieldIndex].required"
                                            class="w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm font-semibold text-gray-700">Required Field</span>
                                    </label>
                                </div>

                                <!-- Placeholder (for text-like inputs) -->
                                <template
                                    x-if="['text', 'email', 'number', 'textarea'].includes(fields[selectedFieldIndex].type)">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Placeholder</label>
                                        <input type="text" x-model="fields[selectedFieldIndex].placeholder"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            placeholder="Enter placeholder text">
                                    </div>
                                </template>

                                <!-- Rows (for textarea) -->
                                <template x-if="fields[selectedFieldIndex].type === 'textarea'">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rows</label>
                                        <input type="number" x-model.number="fields[selectedFieldIndex].rows"
                                            min="3" max="20"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    </div>
                                </template>

                                <!-- Options (for select, radio, checkbox) -->
                                <template x-if="['select', 'radio', 'checkbox'].includes(fields[selectedFieldIndex].type)">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Options</label>
                                        <div class="space-y-2" x-data="{ newOption: '' }">
                                            <template x-if="!fields[selectedFieldIndex].options">
                                                <p class="text-xs text-gray-500">No options yet</p>
                                            </template>
                                            <template x-for="(value, key) in fields[selectedFieldIndex].options"
                                                :key="key">
                                                <div class="flex items-center space-x-2">
                                                    <input type="text" :value="key"
                                                        @change="updateOptionKey(selectedFieldIndex, key, $event.target.value)"
                                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                                        placeholder="Key">
                                                    <input type="text"
                                                        x-model="fields[selectedFieldIndex].options[key]"
                                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                                        placeholder="Label">
                                                    <button type="button" @click="removeOption(selectedFieldIndex, key)"
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </div>
                                            </template>
                                            <div class="flex items-center space-x-2">
                                                <input type="text" x-model="newOption"
                                                    @keydown.enter.prevent="addOption(selectedFieldIndex, newOption); newOption = ''"
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                                    placeholder="Add option (press Enter)">
                                                <button type="button"
                                                    @click="addOption(selectedFieldIndex, newOption); newOption = ''"
                                                    class="px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                                    <i class='bx bx-plus'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- File Accept (for file type) -->
                                <template x-if="fields[selectedFieldIndex].type === 'file'">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Accepted File
                                            Types</label>
                                        <input type="text" x-model="fields[selectedFieldIndex].accept"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            placeholder="e.g., .pdf,.doc,.docx">
                                        <p class="text-xs text-gray-500 mt-1">Comma-separated file extensions</p>
                                    </div>
                                </template>

                                <!-- File Max Size (for file type) -->
                                <template x-if="fields[selectedFieldIndex].type === 'file'">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Max File Size
                                            (KB)</label>
                                        <input type="number" x-model.number="fields[selectedFieldIndex].max_size"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            placeholder="e.g., 10240 (10MB)">
                                    </div>
                                </template>

                                <!-- Multiple Files (for file type) -->
                                <template x-if="fields[selectedFieldIndex].type === 'file'">
                                    <div>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" x-model="fields[selectedFieldIndex].multiple"
                                                class="w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm font-semibold text-gray-700">Allow Multiple
                                                Files</span>
                                        </label>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between bg-white rounded-xl shadow-md p-6 mt-6">
                <a href="{{ route('admin.inov_challenge.forms.index', $session->id) }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg transition-colors shadow-md">
                    <i class='bx bx-save mr-2'></i>
                    Save Form Configuration
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function formBuilder() {
            return {
                fields: @json($defaultFields ?? []),
                selectedFieldIndex: null,
                nextId: 1,
                fieldTypes: [{
                        type: 'text',
                        label: 'Text Input',
                        description: 'Single line text input',
                        icon: 'bx bx-text'
                    },
                    {
                        type: 'textarea',
                        label: 'Textarea',
                        description: 'Multi-line text input',
                        icon: 'bx bx-align-left'
                    },
                    {
                        type: 'number',
                        label: 'Number',
                        description: 'Numeric input',
                        icon: 'bx bx-hash'
                    },
                    {
                        type: 'email',
                        label: 'Email',
                        description: 'Email address input',
                        icon: 'bx bx-envelope'
                    },
                    {
                        type: 'date',
                        label: 'Date',
                        description: 'Date picker',
                        icon: 'bx bx-calendar'
                    },
                    {
                        type: 'select',
                        label: 'Dropdown',
                        description: 'Select from options',
                        icon: 'bx bx-list-ul'
                    },
                    {
                        type: 'radio',
                        label: 'Radio Buttons',
                        description: 'Single choice',
                        icon: 'bx bx-radio-circle'
                    },
                    {
                        type: 'checkbox',
                        label: 'Checkboxes',
                        description: 'Multiple choices',
                        icon: 'bx bx-check-square'
                    },
                    {
                        type: 'file',
                        label: 'File Upload',
                        description: 'File attachment',
                        icon: 'bx bx-upload'
                    },
                ],

                init() {
                    this.fields.forEach(field => {
                        if (!field.id) field.id = this.nextId++;
                    });
                },

                get formConfigJSON() {
                    return JSON.stringify(this.fields.map(field => {
                        const {
                            id,
                            ...fieldData
                        } = field;
                        return fieldData;
                    }));
                },

                addField(type) {
                    const newField = {
                        id: this.nextId++,
                        name: '',
                        label: '',
                        type: type,
                        required: false,
                    };

                    if (type === 'textarea') {
                        newField.rows = 5;
                    }

                    if (['select', 'radio', 'checkbox'].includes(type)) {
                        newField.options = {};
                    }

                    if (type === 'file') {
                        newField.accept = '';
                        newField.max_size = 10240;
                        newField.multiple = false;
                    }

                    this.fields.push(newField);
                    this.selectedFieldIndex = this.fields.length - 1;
                },

                removeField(index) {
                    if (confirm('Are you sure you want to remove this field?')) {
                        this.fields.splice(index, 1);
                        if (this.selectedFieldIndex === index) {
                            this.selectedFieldIndex = null;
                        } else if (this.selectedFieldIndex > index) {
                            this.selectedFieldIndex--;
                        }
                    }
                },

                duplicateField(index) {
                    const field = JSON.parse(JSON.stringify(this.fields[index]));
                    field.id = this.nextId++;
                    field.name = field.name + '_copy';
                    this.fields.splice(index + 1, 0, field);
                },

                selectField(index) {
                    this.selectedFieldIndex = index;
                },

                moveField(index, direction) {
                    const newIndex = index + direction;
                    if (newIndex >= 0 && newIndex < this.fields.length) {
                        const temp = this.fields[index];
                        this.fields[index] = this.fields[newIndex];
                        this.fields[newIndex] = temp;

                        if (this.selectedFieldIndex === index) {
                            this.selectedFieldIndex = newIndex;
                        } else if (this.selectedFieldIndex === newIndex) {
                            this.selectedFieldIndex = index;
                        }
                    }
                },

                addOption(fieldIndex, option) {
                    if (!option) return;

                    if (!this.fields[fieldIndex].options) {
                        this.fields[fieldIndex].options = {};
                    }

                    const key = option.toLowerCase().replace(/\s+/g, '_');
                    this.fields[fieldIndex].options[key] = option;
                },

                removeOption(fieldIndex, key) {
                    delete this.fields[fieldIndex].options[key];
                },

                updateOptionKey(fieldIndex, oldKey, newKey) {
                    if (oldKey === newKey || !newKey) return;

                    const value = this.fields[fieldIndex].options[oldKey];
                    delete this.fields[fieldIndex].options[oldKey];
                    this.fields[fieldIndex].options[newKey] = value;
                },

                submitForm(e) {
                    // Validate
                    if (this.fields.length === 0) {
                        alert('Please add at least one field to the form.');
                        return;
                    }

                    for (let field of this.fields) {
                        if (!field.name || !field.label) {
                            alert('All fields must have a name and label.');
                            return;
                        }
                    }

                    e.target.submit();
                }
            }
        }
    </script>
@endpush
