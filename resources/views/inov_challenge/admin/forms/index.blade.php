@extends('inov_challenge.admin.layout')

@section('title', 'Form Builder - ' . $session->title)

@section('page-title', 'Form Builder')
@section('page-description', 'Kelola form untuk setiap fase challenge')

@section('content')
    <div class="space-y-6">
        <!-- Session Context -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-md p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">{{ $session->title }}</h2>
                    <p class="text-purple-100 text-sm">{{ $session->description }}</p>
                    <div class="flex items-center space-x-6 mt-4">
                        <div class="flex items-center">
                            <i class='bx bx-calendar text-xl mr-2'></i>
                            <span class="text-sm">{{ $session->start_date->format('d M Y') }} -
                                {{ $session->end_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-full {{ $session->status == 'active' ? 'bg-green-500' : ($session->status == 'closed' ? 'bg-gray-500' : 'bg-yellow-500') }}">
                                {{ strtoupper($session->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.inov_challenge.sessions.show', $session->id) }}"
                    class="px-4 py-2 bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-colors font-medium">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Back to Session
                </a>
            </div>
        </div>

        <!-- Info Alert -->
        @if (count($missingPhases) > 0 && $session->status == 'draft')
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class='bx bx-info-circle text-2xl text-yellow-600 mr-3 mt-0.5'></i>
                    <div>
                        <h3 class="font-semibold text-yellow-800">Form Tidak Lengkap</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Anda harus membuat form untuk semua fase (Phase 1, Phase 2, Phase 3) sebelum sesi dapat
                            diaktifkan.
                            Fase yang belum dikonfigurasi:
                            <strong>{{ implode(', ', array_map(fn($p) => ucfirst(str_replace('_', ' ', $p)), $missingPhases)) }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Forms Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach (['phase_1', 'phase_2', 'phase_3'] as $phase)
                @php
                    $formBuilder = $formBuilders->where('phase', $phase)->first();
                    $phaseNumber = str_replace('phase_', '', $phase);
                    $phaseColors = [
                        'phase_1' => [
                            'bg' => 'bg-blue-50',
                            'border' => 'border-blue-500',
                            'text' => 'text-blue-600',
                            'icon' => 'text-blue-500',
                        ],
                        'phase_2' => [
                            'bg' => 'bg-green-50',
                            'border' => 'border-green-500',
                            'text' => 'text-green-600',
                            'icon' => 'text-green-500',
                        ],
                        'phase_3' => [
                            'bg' => 'bg-purple-50',
                            'border' => 'border-purple-500',
                            'text' => 'text-purple-600',
                            'icon' => 'text-purple-500',
                        ],
                    ];
                    $colors = $phaseColors[$phase];
                @endphp

                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden border-2 {{ $formBuilder ? $colors['border'] : 'border-gray-200' }}">
                    <!-- Card Header -->
                    <div class="px-6 py-4 {{ $formBuilder ? $colors['bg'] : 'bg-gray-50' }} border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold {{ $formBuilder ? $colors['text'] : 'text-gray-700' }}">
                                    Phase {{ $phaseNumber }}
                                </h3>
                                <p class="text-xs {{ $formBuilder ? $colors['text'] : 'text-gray-500' }} opacity-75 mt-1">
                                    {{ $phaseNumber == 1 ? 'Tahap Penyerahan Awal' : ($phaseNumber == 2 ? 'Tahap Pengembangan' : 'Tahap Final') }}
                                </p>
                            </div>
                            <i
                                class='bx {{ $formBuilder ? 'bx-check-circle text-3xl ' . $colors['icon'] : 'bx-circle text-3xl text-gray-400' }}'></i>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        @if ($formBuilder)
                            <!-- Form Exists -->
                            <div class="space-y-4">
                                <!-- Form Info -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Total Fields:</span>
                                        <span class="font-bold text-gray-900">{{ count($formBuilder->form_config) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Required Fields:</span>
                                        <span class="font-bold text-gray-900">
                                            {{ collect($formBuilder->form_config)->where('required', true)->count() }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Last Updated:</span>
                                        <span
                                            class="font-medium text-gray-700">{{ $formBuilder->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Field Types Preview -->
                                <div class="pt-3 border-t">
                                    <p class="text-xs text-gray-500 mb-2">Field Types:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @php
                                            $fieldTypes = collect($formBuilder->form_config)->pluck('type')->countBy();
                                        @endphp
                                        @foreach ($fieldTypes as $type => $count)
                                            <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-md">
                                                {{ ucfirst($type) }} ({{ $count }})
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="pt-4 space-y-2">
                                    <a href="{{ route('admin.inov_challenge.forms.preview', ['session' => $session->id, 'form' => $formBuilder->id]) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                        <i class='bx bx-show mr-2'></i>
                                        Preview Form
                                    </a>
                                    <a href="{{ route('admin.inov_challenge.forms.edit', ['session' => $session->id, 'form' => $formBuilder->id]) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                                        <i class='bx bx-edit mr-2'></i>
                                        Edit Form
                                    </a>
                                    <form
                                        action="{{ route('admin.inov_challenge.forms.destroy', ['session' => $session->id, 'form' => $formBuilder->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus form ini? Tindakan ini tidak dapat dibatalkan.');"
                                        class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                            <i class='bx bx-trash mr-2'></i>
                                            Delete Form
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Form Does Not Exist -->
                            <div class="text-center py-8">
                                <i class='bx bx-file-blank text-5xl text-gray-400 mb-4'></i>
                                <p class="text-sm text-gray-600 mb-6">Form belum dikonfigurasi untuk fase ini.</p>
                                <a href="{{ route('admin.inov_challenge.forms.create', ['session' => $session->id, 'phase' => $phase]) }}"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg transition-colors shadow-md">
                                    <i class='bx bx-plus-circle mr-2'></i>
                                    Create Form
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Help Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <i class='bx bx-help-circle text-3xl text-blue-600 mr-4 mt-1'></i>
                <div class="flex-1">
                    <h3 class="font-bold text-blue-900 mb-2">Tentang Form Builder</h3>
                    <div class="text-sm text-blue-800 space-y-2">
                        <p>
                            <strong>Phase 1 (Tahap Penyerahan Awal):</strong> Form untuk pendaftaran dan penyerahan proposal
                            awal.
                            Biasanya berisi informasi umum tim, deskripsi ide, dan dokumen pendukung.
                        </p>
                        <p>
                            <strong>Phase 2 (Tahap Pengembangan):</strong> Form untuk tim yang lolos fase 1.
                            Berisi progress report, prototipe, dan dokumentasi pengembangan.
                        </p>
                        <p>
                            <strong>Phase 3 (Tahap Final):</strong> Form untuk presentasi final dan dokumentasi lengkap.
                            Termasuk hasil akhir, demo, dan evaluasi.
                        </p>
                        <p class="pt-2 border-t border-blue-200 mt-3">
                            <i class='bx bx-info-circle mr-1'></i>
                            Setiap form dapat dikonfigurasi dengan berbagai tipe field (text, textarea, file upload, select,
                            dll.)
                            sesuai kebutuhan masing-masing fase.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Forms Configured</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $formBuilders->count() }}/3</p>
                    </div>
                    <i class='bx bx-layout text-3xl text-indigo-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Fields</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $formBuilders->sum(fn($f) => count($f->form_config)) }}</p>
                    </div>
                    <i class='bx bx-list-ul text-3xl text-green-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Required Fields</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $formBuilders->sum(fn($f) => collect($f->form_config)->where('required', true)->count()) }}
                        </p>
                    </div>
                    <i class='bx bx-error text-3xl text-red-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Session Status</p>
                        <p
                            class="text-lg font-bold mt-1 {{ $session->status == 'active' ? 'text-green-600' : ($session->status == 'closed' ? 'text-gray-600' : 'text-yellow-600') }}">
                            {{ ucfirst($session->status) }}
                        </p>
                    </div>
                    <i
                        class='bx {{ $session->status == 'active' ? 'bx-check-circle text-green-500' : ($session->status == 'closed' ? 'bx-x-circle text-gray-500' : 'bx-time text-yellow-500') }} text-3xl'></i>
                </div>
            </div>
        </div>
    </div>
@endsection
