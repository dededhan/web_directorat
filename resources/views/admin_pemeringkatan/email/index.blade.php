@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Header & Breadcrumb -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Email Templates Management</h1>
                        <nav class="flex text-sm text-gray-600 mt-2" aria-label="Breadcrumb">
                            <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                            <span class="mx-2">/</span>
                            <span class="text-gray-800 font-medium">Email Templates</span>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 whitespace-pre-line">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 whitespace-pre-line">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi Template Email</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>• Terdapat 4 template email: 2 kategori (Academic & Employee) × 2 bahasa (English & Indonesian)</p>
                            <p>• Gunakan placeholder: <code class="bg-blue-100 px-1 rounded">{`{title}`}</code>, <code class="bg-blue-100 px-1 rounded">{`{fullname}`}</code>, <code class="bg-blue-100 px-1 rounded">{`{surveyLink}`}</code></p>
                            <p>• Gunakan HTML tags untuk formatting: <code class="bg-blue-100 px-1 rounded">&lt;strong&gt;</code>, <code class="bg-blue-100 px-1 rounded">&lt;br&gt;</code>, dll.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Templates Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($templates as $template)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <!-- Header -->
                        <div class="bg-gradient-to-r {{ $template->category === 'academic' ? 'from-green-600 to-green-700' : 'from-purple-600 to-purple-700' }} px-6 py-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-white">{{ $template->category_name }}</h3>
                                    <p class="text-sm text-white/80">{{ $template->language_name }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-medium text-white">
                                        {{ strtoupper($template->language) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Content Preview -->
                        <div class="p-6">
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Subject</h4>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $template->subject }}</p>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Greeting</h4>
                                <p class="text-sm text-gray-600 line-clamp-1">{{ $template->greeting }}</p>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Preview</h4>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit(strip_tags($template->email_content), 150) }}</p>
                            </div>

                            <div class="text-xs text-gray-500">
                                Last updated: {{ $template->updated_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                            <a href="{{ route('admin_pemeringkatan.email.edit', $template->id) }}" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium flex items-center">
                                <i class='bx bxs-edit mr-2'></i>
                                Edit Template
                            </a>
                            <button type="button" 
                                class="reset-btn px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-sm font-medium flex items-center"
                                data-id="{{ $template->id }}"
                                data-category="{{ $template->category_name }}"
                                data-language="{{ $template->language_name }}">
                                <i class='bx bx-reset mr-2'></i>
                                Reset
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12">
                        <i class='bx bx-envelope text-6xl text-gray-300 mb-4'></i>
                        <p class="text-gray-500">Tidak ada template email. Jalankan seeder untuk membuat template default.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // Reset button handler
        document.querySelectorAll('.reset-btn').forEach(button => {
            button.addEventListener('click', function() {
                const templateId = this.dataset.id;
                const category = this.dataset.category;
                const language = this.dataset.language;
                
                Swal.fire({
                    title: 'Reset Template?',
                    text: `Reset ${category} (${language}) template ke default?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin_pemeringkatan/email/${templateId}/reset`;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'POST';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
