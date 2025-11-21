@extends('admin_pemeringkatan.index')

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 400px;
    }
</style>
@endpush

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Header & Breadcrumb -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Email Template</h1>
                <nav class="flex text-sm text-gray-600 mt-2" aria-label="Breadcrumb">
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('admin_pemeringkatan.email.index') }}" class="hover:text-blue-600 transition">Email Templates</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-800 font-medium">Edit</span>
                </nav>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r {{ $template->category === 'academic' ? 'from-green-600 to-green-700' : 'from-purple-600 to-purple-700' }} px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">{{ $template->category_name }} - {{ $template->language_name }}</h2>
                    <p class="text-white/80 text-sm mt-1">Customize email template content</p>
                </div>

                <form method="POST" action="{{ route('admin_pemeringkatan.email.update', $template->id) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Placeholder Guide -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <h3 class="text-sm font-semibold text-blue-800 mb-2">📝 Available Placeholders:</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                            <div>
                                <code class="bg-blue-100 px-2 py-1 rounded text-blue-800">{`{title}`}</code>
                                <p class="text-blue-700 text-xs mt-1">Mr./Mrs./Ms.</p>
                            </div>
                            <div>
                                <code class="bg-blue-100 px-2 py-1 rounded text-blue-800">{`{fullname}`}</code>
                                <p class="text-blue-700 text-xs mt-1">Responden full name</p>
                            </div>
                            <div>
                                <code class="bg-blue-100 px-2 py-1 rounded text-blue-800">{`{surveyLink}`}</code>
                                <p class="text-blue-700 text-xs mt-1">Survey URL</p>
                            </div>
                        </div>
                        <p class="text-xs text-blue-600 mt-3">💡 Use the rich text editor below to format your content - no HTML knowledge required!</p>
                    </div>

                    <!-- Email Subject -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">Email Subject</h3>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject Line <span class="text-red-500">*</span></label>
                            <input type="text" name="subject" id="subject" required
                                value="{{ old('subject', $template->subject) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Email subject line">
                            <p class="mt-1 text-xs text-gray-500">Subject yang akan muncul di inbox responden</p>
                        </div>
                    </div>

                    <!-- Email Content -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">Email Content</h3>
                        
                        <div class="space-y-6">
                            <!-- Greeting -->
                            <div>
                                <label for="greeting" class="block text-sm font-medium text-gray-700 mb-2">Greeting <span class="text-red-500">*</span></label>
                                <textarea name="greeting" id="greeting" rows="2" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono text-sm"
                                    placeholder="Dear {title} {fullname},">{{ old('greeting', $template->greeting) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Sapaan pembuka email</p>
                            </div>

                            <!-- Email Content (Rich Text Editor) -->
                            <div>
                                <label for="email_content" class="block text-sm font-medium text-gray-700 mb-2">Email Body Content <span class="text-red-500">*</span></label>
                                <textarea name="email_content" id="email_content" required>{{ old('email_content', $template->email_content ?? '') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Isi utama email (Introduction, Main Content, Call to Action). Gunakan editor untuk format teks, bold, italic, bullet points, dll.</p>
                            </div>

                            <!-- Button Text -->
                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text <span class="text-red-500">*</span></label>
                                <input type="text" name="button_text" id="button_text" required
                                    value="{{ old('button_text', $template->button_text) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="Click here to participate">
                                <p class="mt-1 text-xs text-gray-500">Teks yang muncul di button</p>
                            </div>

                            <!-- Closing -->
                            <div>
                                <label for="closing" class="block text-sm font-medium text-gray-700 mb-2">Closing Statement <span class="text-red-500">*</span></label>
                                <textarea name="closing" id="closing" rows="2" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono text-sm">{{ old('closing', $template->closing) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Kalimat penutup setelah button</p>
                            </div>
                        </div>
                    </div>

                    <!-- Signature -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500">Email Signature</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="signature_name" class="block text-sm font-medium text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                                <input type="text" name="signature_name" id="signature_name" required
                                    value="{{ old('signature_name', $template->signature_name) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="Dr. Name">
                                <p class="mt-1 text-xs text-gray-500">Nama penanda tangan</p>
                            </div>
                            
                            <div>
                                <label for="signature_title" class="block text-sm font-medium text-gray-700 mb-2">Title/Position <span class="text-red-500">*</span></label>
                                <textarea name="signature_title" id="signature_title" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono text-sm">{{ old('signature_title', $template->signature_title) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Jabatan dan institusi (gunakan &lt;br&gt; untuk baris baru)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin_pemeringkatan.email.index') }}"
                            class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                            <i class='bx bx-x mr-2'></i>Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-save mr-2'></i>Update Template
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance;
        
        ClassicEditor
            .create(document.querySelector('#email_content'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'blockQuote', '|',
                        'undo', 'redo'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading3', view: 'h3', title: 'Heading', class: 'ck-heading_heading3' }
                    ]
                }
            })
            .then(editor => {
                editorInstance = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '400px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });

        // Ensure editor content is saved before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            if (editorInstance) {
                const editorData = editorInstance.getData();
                document.querySelector('#email_content').value = editorData;
            }
        });
    </script>
    @endpush
@endsection
