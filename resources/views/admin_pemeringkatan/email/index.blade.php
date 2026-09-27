@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-slate-50 p-4 sm:p-6 lg:p-8 xl:p-10">
        <div class="max-w-[1920px] mx-auto space-y-6">
            
            <!-- Header & Breadcrumb -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <nav class="flex text-sm text-slate-500 mb-2" aria-label="Breadcrumb">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-teal-600 transition">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" class="hover:text-teal-600 transition">QS Campaign</a>
                        <span class="mx-2">/</span>
                        <span class="text-slate-800 font-semibold">Email Templates</span>
                    </nav>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-600/10 text-teal-600 flex items-center justify-center font-bold">
                            <i class="fas fa-envelope-open-text text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Email Templates Management</h1>
                            <p class="text-xs sm:text-sm text-slate-500">Konfigurasi format dan konten email persetujuan (consent) untuk responden QS World University Rankings</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-medium rounded-xl shadow-sm transition">
                        <i class="fas fa-calendar-alt mr-2 text-teal-600"></i> Ke QS Sessions
                    </a>
                </div>
            </div>

            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 text-lg mr-3"></i>
                        <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-rose-500 text-lg mr-3"></i>
                        <p class="text-sm text-rose-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Feature Overview Card -->
            <div class="bg-gradient-to-r from-teal-900 via-teal-800 to-emerald-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-white/10 rounded-full text-xs font-semibold text-teal-200">
                            <i class="fas fa-layer-group"></i> 2 Kategori Responden
                        </div>
                        <h3 class="text-lg font-bold">Academic & Employer</h3>
                        <p class="text-xs text-teal-100/80 leading-relaxed">
                            Format template dibedakan secara otomatis untuk akademisi (dosen/peneliti) dan pemberi kerja (alumni supervisor/industri mitra).
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-white/10 rounded-full text-xs font-semibold text-teal-200">
                            <i class="fas fa-globe"></i> Fleksibilitas Bahasa
                        </div>
                        <h3 class="text-lg font-bold">Bilingual, EN Only, ID Only</h3>
                        <p class="text-xs text-teal-100/80 leading-relaxed">
                            Mendukung pengiriman dalam mode dwibahasa (bilingual) maupun satu bahasa tunggal saat melakukan pengiriman email blast di QS Sessions.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-white/10 rounded-full text-xs font-semibold text-teal-200">
                            <i class="fas fa-code"></i> Variabel Dinamis
                        </div>
                        <h3 class="text-lg font-bold">Smart Placeholders</h3>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <code class="px-2 py-0.5 bg-white/15 rounded text-xs text-white font-mono">{`{title}`}</code>
                            <code class="px-2 py-0.5 bg-white/15 rounded text-xs text-white font-mono">{`{fullname}`}</code>
                            <code class="px-2 py-0.5 bg-white/15 rounded text-xs text-white font-mono">{`{surveyLink}`}</code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Templates Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($templates as $template)
                    @php
                        $isAcademic = $template->category === 'academic';
                        $accentColor = $isAcademic ? 'teal' : 'indigo';
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 hover:border-slate-300 transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                        
                        <div>
                            <!-- Header of Card -->
                            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between {{ $isAcademic ? 'bg-teal-50/50' : 'bg-indigo-50/50' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl {{ $isAcademic ? 'bg-teal-600 text-white' : 'bg-indigo-600 text-white' }} flex items-center justify-center font-bold shadow-sm">
                                        <i class="fas {{ $isAcademic ? 'fa-graduation-cap' : 'fa-briefcase' }}"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-800">
                                            Responden {{ $template->category_name }}
                                        </h3>
                                        <p class="text-xs text-slate-500">
                                            Bahasa: <span class="font-semibold text-slate-700">{{ $template->language_name }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $template->language === 'en' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                                        {{ strtoupper($template->language) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content Details -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Subject Email</div>
                                    <p class="text-sm font-semibold text-slate-800 line-clamp-2">
                                        {{ $template->subject }}
                                    </p>
                                </div>

                                <div>
                                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sapaan (Greeting)</div>
                                    <code class="text-xs text-slate-700 bg-slate-100 px-2 py-1 rounded inline-block font-mono">
                                        {{ $template->greeting }}
                                    </code>
                                </div>

                                <div>
                                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Preview Isi Konten</div>
                                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                        {{ strip_tags($template->email_content) }}
                                    </p>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                    <span>Teks Tombol: <strong class="text-slate-700">{{ $template->button_text }}</strong></span>
                                    <span>Update: {{ $template->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin_pemeringkatan.email.edit', $template->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition shadow-sm hover:shadow">
                                    <i class="fas fa-edit mr-1.5"></i> Edit Template
                                </a>

                                <button type="button" 
                                        onclick="openQuickPreview({{ $template->id }}, '{{ $template->category_name }} - {{ $template->language_name }}')"
                                        class="inline-flex items-center px-3 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                                    <i class="fas fa-eye mr-1.5 text-slate-500"></i> Preview
                                </button>
                            </div>

                            <button type="button" 
                                    class="reset-btn text-xs text-slate-500 hover:text-rose-600 font-medium px-2 py-1.5 rounded-lg hover:bg-rose-50 transition"
                                    data-id="{{ $template->id }}"
                                    data-category="{{ $template->category_name }}"
                                    data-language="{{ $template->language_name }}">
                                <i class="fas fa-undo-alt mr-1"></i> Reset Default
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="col-span-2 text-center py-16 bg-white rounded-2xl border border-slate-200">
                        <i class="fas fa-envelope-open text-5xl text-slate-300 mb-3"></i>
                        <h4 class="text-base font-bold text-slate-700">Belum Ada Template Email</h4>
                        <p class="text-xs text-slate-500 mt-1">Jalankan EmailTemplateSeeder untuk mengisi template bawaan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Quick Preview Modal -->
    <div id="previewModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-4xl h-[85vh] flex flex-col overflow-hidden">
            <div class="px-6 py-4 bg-teal-800 text-white flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-2">
                    <i class="fas fa-eye text-teal-300"></i>
                    <h3 id="previewModalTitle" class="font-bold text-base">Preview Template Email</h3>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center bg-teal-900/60 rounded-lg p-1 text-xs">
                        <button onclick="setPreviewLangMode('bilingual')" id="btnPreviewBilingual" class="px-2.5 py-1 rounded font-semibold text-white bg-teal-600 transition">Bilingual</button>
                        <button onclick="setPreviewLangMode('en')" id="btnPreviewEn" class="px-2.5 py-1 rounded font-semibold text-teal-200 hover:text-white transition">EN Only</button>
                        <button onclick="setPreviewLangMode('id')" id="btnPreviewId" class="px-2.5 py-1 rounded font-semibold text-teal-200 hover:text-white transition">ID Only</button>
                    </div>
                    <button onclick="closeQuickPreview()" class="text-white/80 hover:text-white text-lg">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="flex-1 bg-slate-100 p-4 overflow-hidden">
                <iframe id="previewFrame" src="about:blank" class="w-full h-full rounded-xl border border-slate-300 bg-white"></iframe>
            </div>
        </div>
    </div>

    <script>
        let currentPreviewId = null;
        let currentLangMode = 'bilingual';

        function openQuickPreview(id, title) {
            currentPreviewId = id;
            document.getElementById('previewModalTitle').innerText = 'Preview: ' + title;
            updatePreviewFrame();
            document.getElementById('previewModal').classList.remove('hidden');
        }

        function closeQuickPreview() {
            document.getElementById('previewModal').classList.add('hidden');
            document.getElementById('previewFrame').src = 'about:blank';
        }

        function setPreviewLangMode(mode) {
            currentLangMode = mode;
            ['bilingual', 'en', 'id'].forEach(m => {
                const btn = document.getElementById('btnPreview' + m.charAt(0).toUpperCase() + m.slice(1));
                if (btn) {
                    if (m === mode) {
                        btn.className = 'px-2.5 py-1 rounded font-semibold text-white bg-teal-600 transition';
                    } else {
                        btn.className = 'px-2.5 py-1 rounded font-semibold text-teal-200 hover:text-white transition';
                    }
                }
            });
            updatePreviewFrame();
        }

        function updatePreviewFrame() {
            if (currentPreviewId) {
                document.getElementById('previewFrame').src = `/admin_pemeringkatan/email/${currentPreviewId}/preview?mode=${currentLangMode}`;
            }
        }

        // Reset button handler with SweetAlert2
        document.querySelectorAll('.reset-btn').forEach(button => {
            button.addEventListener('click', function() {
                const templateId = this.dataset.id;
                const category = this.dataset.category;
                const language = this.dataset.language;
                
                Swal.fire({
                    title: 'Reset Template?',
                    text: `Kembalikan template ${category} (${language}) ke susunan teks bawaan resmi UNJ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0f766e',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Reset ke Default',
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
                        
                        form.appendChild(csrfToken);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
