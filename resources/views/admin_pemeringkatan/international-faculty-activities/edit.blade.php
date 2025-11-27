@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Activity</h1>
                <p class="text-sm text-gray-600 mt-1">Update activity information</p>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-2xl text-red-500 mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <p class="font-medium text-red-800 mb-2">Please correct the following errors:</p>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Activity Information</h2>
                    <p class="text-sm text-amber-100 mt-1">Update the details below</p>
                </div>

                <!-- Form -->
                <form action="{{ route('admin_pemeringkatan.international-faculty-activities.update', $activity->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Section 1: Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-amber-200">
                                Basic Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Publication Date -->
                                <div>
                                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                        Publication Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           name="tanggal" 
                                           id="tanggal" 
                                           value="{{ old('tanggal', $activity->tanggal) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('tanggal') border-red-500 @enderror"
                                           required>
                                    <p class="mt-1 text-xs text-gray-500">Date when the activity occurred or will occur</p>
                                    @error('tanggal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Title -->
                                <div>
                                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="judul" 
                                           id="judul" 
                                           value="{{ old('judul', $activity->judul) }}"
                                           maxlength="200"
                                           placeholder="e.g., International Faculty Seminar on AI"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                                           required>
                                    <p class="mt-1 text-xs text-gray-500">Maximum 200 characters</p>
                                    @error('judul')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Content -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-200">
                                Content
                            </h3>

                            <div>
                                <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Article Content <span class="text-red-500">*</span>
                                </label>
                                <textarea name="isi" 
                                          id="isi" 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('isi') border-red-500 @enderror">{{ old('isi', $activity->isi) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Write the full article content. You can format text, add images, and create tables.</p>
                                @error('isi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 3: Cover Image -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-200">
                                Cover Image
                            </h3>

                            <!-- Current Image Preview -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Cover Image</label>
                                <div class="relative inline-block">
                                    <img src="{{ Storage::url($activity->gambar) }}" 
                                         alt="Current cover" 
                                         class="h-48 w-auto object-cover rounded-lg border-2 border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <!-- Upload New Image -->
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload New Cover Image (Optional)
                                </label>
                                <input type="file" 
                                       name="gambar" 
                                       id="gambar" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('gambar') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">
                                    Leave empty to keep current image | Accepted formats: JPG, PNG, JPEG | Maximum size: 2MB
                                </p>
                                @error('gambar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.international-faculty-activities.index') }}" 
                           class="inline-flex items-center px-6 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors shadow-sm">
                            <i class='bx bx-x mr-2'></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors shadow-sm">
                            <i class='bx bx-save mr-2'></i>
                            Update Activity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script>
        let editorInstance;

        // Custom upload adapter for CKEditor
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('admin_pemeringkatan.international-faculty-activities-upload-image') }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.uploaded) {
                            resolve({ default: result.url });
                        } else {
                            reject(result.error.message);
                        }
                    })
                    .catch(error => {
                        reject('Upload failed');
                    });
                }));
            }

            abort() {
                // Handle abort
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#isi'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'link', 'imageUpload', 'blockQuote', 'insertTable', '|',
                        'undo', 'redo', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                fontSize: {
                    options: [
                        'tiny',
                        'small',
                        'default',
                        'big',
                        'huge'
                    ]
                },
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        'linkImage'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },
                link: {
                    defaultProtocol: 'https://',
                    decorators: {
                        openInNewTab: {
                            mode: 'manual',
                            label: 'Open in a new tab',
                            attributes: {
                                target: '_blank',
                                rel: 'noopener noreferrer'
                            }
                        }
                    }
                }
            })
            .then(editor => {
                editorInstance = editor;
                console.log('CKEditor initialized successfully');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>
    @endpush
@endsection
