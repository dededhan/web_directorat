@extends('admin_pemeringkatan.index')

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 280px;
        max-height: 450px;
    }
    .ck.ck-editor {
        border-radius: 0.75rem !important;
        overflow: hidden;
    }
</style>
@endpush

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-slate-100 p-4 sm:p-6 lg:p-8">
        <div class="max-w-[1920px] mx-auto space-y-6">
            
            <!-- Header & Breadcrumb -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <nav class="flex text-sm text-slate-500 mb-2" aria-label="Breadcrumb">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-teal-600 transition">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('admin_pemeringkatan.email.index') }}" class="hover:text-teal-600 transition">Email Templates</a>
                        <span class="mx-2">/</span>
                        <span class="text-slate-800 font-semibold">Edit Template</span>
                    </nav>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                            Edit Email Template: {{ $template->category_name }}
                        </h1>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $template->language === 'en' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                            {{ $template->language_name }} ({{ strtoupper($template->language) }})
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if($siblingTemplate)
                        <a href="{{ route('admin_pemeringkatan.email.edit', $siblingTemplate->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition shadow-sm">
                            <i class="fas fa-exchange-alt mr-1.5 text-teal-600"></i> Beralih ke Versi {{ $siblingTemplate->language_name }}
                        </a>
                    @endif
                    <a href="{{ route('admin_pemeringkatan.email.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition">
                        <i class="fas fa-arrow-left mr-1.5"></i> Kembali
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-rose-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-rose-800">Terdapat {{ $errors->count() }} kesalahan input:</h3>
                            <ul class="mt-2 text-xs text-rose-700 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- SPLIT SCREEN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- LEFT COLUMN: Form Editor (7 cols) -->
                <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    
                    <div class="px-6 py-4 bg-gradient-to-r {{ $template->category === 'academic' ? 'from-teal-800 to-teal-700' : 'from-indigo-800 to-indigo-700' }} text-white flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-edit text-teal-300"></i>
                            <h2 class="font-bold text-base">Editor Formulir Template</h2>
                        </div>
                        <span class="text-xs text-teal-100 bg-white/10 px-2.5 py-1 rounded-md font-mono">
                            Category: {{ $template->category }} &bull; Lang: {{ $template->language }}
                        </span>
                    </div>

                    <form id="templateEditForm" method="POST" action="{{ route('admin_pemeringkatan.email.update', $template->id) }}" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Placeholder Quick Insert Guide -->
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    <i class="fas fa-code mr-1 text-teal-600"></i> Placeholder Tersedia:
                                </span>
                                <span class="text-[11px] text-slate-400">Klik untuk copy ke clipboard</span>
                            </div>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <button type="button" onclick="copyTag('{title}')" class="px-2.5 py-1 bg-white border border-slate-200 hover:border-teal-500 rounded-lg font-mono text-teal-700 font-semibold shadow-2xs transition">
                                    {`{title}`} <span class="text-slate-400 font-sans font-normal">(Gelar/Sapaan)</span>
                                </button>
                                <button type="button" onclick="copyTag('{fullname}')" class="px-2.5 py-1 bg-white border border-slate-200 hover:border-teal-500 rounded-lg font-mono text-teal-700 font-semibold shadow-2xs transition">
                                    {`{fullname}`} <span class="text-slate-400 font-sans font-normal">(Nama Lengkap)</span>
                                </button>
                                <button type="button" onclick="copyTag('{surveyLink}')" class="px-2.5 py-1 bg-white border border-slate-200 hover:border-teal-500 rounded-lg font-mono text-teal-700 font-semibold shadow-2xs transition">
                                    {`{surveyLink}`} <span class="text-slate-400 font-sans font-normal">(Tautan Consent)</span>
                                </button>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Subject Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="subject" id="subject" required
                                value="{{ old('subject', $template->subject) }}"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                                placeholder="Contoh: Consent Letter for Academic Respondent Universitas Negeri Jakarta">
                            <p class="text-[11px] text-slate-400 mt-1">Judul email yang akan muncul di inbox penerima.</p>
                        </div>

                        <!-- Greeting -->
                        <div>
                            <label for="greeting" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Sapaan Pembuka (Greeting) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="greeting" id="greeting" required
                                value="{{ old('greeting', $template->greeting) }}"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 font-mono transition"
                                placeholder="Dear {title} {fullname},">
                        </div>

                        <!-- Body Content -->
                        <div>
                            <label for="email_content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Isi Utama Email (Body Content) <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="email_content" id="email_content" required>{{ old('email_content', $template->email_content ?? '') }}</textarea>
                            <p class="text-[11px] text-slate-400 mt-1">Gunakan editor untuk bold, italic, list, atau hyperlink.</p>
                        </div>

                        <!-- Button Text -->
                        <div>
                            <label for="button_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Teks Tombol CTA (Button Text) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="button_text" id="button_text" required
                                value="{{ old('button_text', $template->button_text) }}"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                                placeholder="Click here to fill out the consent letter">
                        </div>

                        <!-- Closing -->
                        <div>
                            <label for="closing" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kalimat Penutup (Closing Statement) <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="closing" id="closing" rows="2" required
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">{{ old('closing', $template->closing) }}</textarea>
                        </div>

                        <!-- Signatory (Grid 2 cols) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label for="signature_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Nama Penanda Tangan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="signature_name" id="signature_name" required
                                    value="{{ old('signature_name', $template->signature_name) }}"
                                    class="w-full px-4 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                                    placeholder="Dr. RA Murti Kusuma W. S.IP, M.Si">
                            </div>
                            <div>
                                <label for="signature_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Jabatan & Institusi <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="signature_title" id="signature_title" rows="2" required
                                    class="w-full px-4 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 font-mono text-xs transition">{{ old('signature_title', $template->signature_title) }}</textarea>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                            <button type="button" onclick="openTestEmailModal()" 
                                    class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center shadow-sm">
                                <i class="fas fa-paper-plane mr-2 text-teal-400"></i> Kirim Test Email
                            </button>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin_pemeringkatan.email.index') }}"
                                    class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-bold text-xs transition shadow-sm hover:shadow">
                                    <i class="fas fa-save mr-1.5"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- RIGHT COLUMN: Interactive Live Preview (5 cols, Sticky) -->
                <div class="lg:col-span-5 sticky top-6 space-y-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                        
                        <!-- Top Toolbar of Live Preview -->
                        <div class="px-5 py-3.5 bg-slate-900 text-white flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="text-xs font-bold tracking-wide uppercase">Live Interactive Preview</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- Mode Selector (Bilingual, EN, ID) -->
                                <select id="previewModeSelector" onchange="changePreviewMode(this.value)" 
                                        class="bg-slate-800 text-slate-200 text-xs rounded-lg px-2.5 py-1 border border-slate-700 focus:outline-none focus:ring-1 focus:ring-teal-400">
                                    <option value="bilingual">Bilingual (EN + ID)</option>
                                    <option value="en" {{ $template->language === 'en' ? 'selected' : '' }}>English Only</option>
                                    <option value="id" {{ $template->language === 'id' ? 'selected' : '' }}>Indonesian Only</option>
                                </select>

                                <!-- Viewport Toggle: Desktop vs Mobile -->
                                <div class="bg-slate-800 rounded-lg p-0.5 flex items-center border border-slate-700">
                                    <button type="button" id="btnViewDesktop" onclick="setDeviceView('desktop')" 
                                            class="px-2 py-1 rounded text-xs text-white bg-teal-600 transition" title="Desktop View">
                                        <i class="fas fa-desktop"></i>
                                    </button>
                                    <button type="button" id="btnViewMobile" onclick="setDeviceView('mobile')" 
                                            class="px-2 py-1 rounded text-xs text-slate-400 hover:text-white transition" title="Mobile View">
                                        <i class="fas fa-mobile-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Frame Container -->
                        <div class="p-4 bg-slate-100 flex justify-center items-center overflow-x-auto min-h-[620px]">
                            <div id="previewFrameWrapper" class="w-full transition-all duration-300 mx-auto shadow-sm" style="max-width: 100%;">
                                <iframe id="livePreviewFrame" 
                                        src="{{ route('admin_pemeringkatan.email.preview', $template->id) }}?mode={{ $template->language === 'en' ? 'en' : ($template->language === 'id' ? 'id' : 'bilingual') }}" 
                                        class="w-full h-[620px] rounded-xl border border-slate-300 bg-white shadow-inner">
                                </iframe>
                            </div>
                        </div>

                        <!-- Footer of Preview -->
                        <div class="px-5 py-3 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-500">
                            <span>Simulasi dengan nama responden sample</span>
                            <button type="button" onclick="refreshLivePreview()" class="text-teal-600 hover:text-teal-800 font-semibold flex items-center">
                                <i class="fas fa-sync-alt mr-1"></i> Refresh Preview
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- TEST EMAIL MODAL -->
    <div id="testEmailModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-paper-plane text-teal-400"></i>
                    <h3 class="font-bold text-base">Kirim Email Simulasi / Test</h3>
                </div>
                <button onclick="closeTestEmailModal()" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="sendTestEmailForm" onsubmit="handleSendTest(event)" class="p-6 space-y-4">
                <p class="text-xs text-slate-500 leading-relaxed">
                    Sistem akan mengirimkan email riil ke alamat tujuan menggunakan template <strong>{{ $template->category_name }}</strong> yang sedang diedit.
                </p>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Alamat Email Penerima Test <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="testEmailInput" required
                           value="{{ auth()->user()->email ?? '' }}"
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                           placeholder="nama@email.com">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Mode Bahasa Pengiriman
                    </label>
                    <select id="testEmailLangMode" 
                            class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <option value="bilingual">Bilingual (English + Indonesia)</option>
                        <option value="en">Hanya English (EN)</option>
                        <option value="id">Hanya Indonesia (ID)</option>
                    </select>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeTestEmailModal()" 
                            class="px-4 py-2 border border-slate-300 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitTestEmail"
                            class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition flex items-center shadow-sm">
                        <i class="fas fa-paper-plane mr-1.5"></i> Kirim Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance;
        const templateId = {{ $template->id }};
        let activeLangMode = '{{ $template->language === "en" ? "en" : ($template->language === "id" ? "id" : "bilingual") }}';

        ClassicEditor
            .create(document.querySelector('#email_content'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .then(editor => {
                editorInstance = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '280px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });

        // Ensure editor content is committed before form submit
        document.querySelector('#templateEditForm').addEventListener('submit', function(e) {
            if (editorInstance) {
                document.querySelector('#email_content').value = editorInstance.getData();
            }
        });

        // Copy placeholder helper
        function copyTag(tag) {
            navigator.clipboard.writeText(tag).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Placeholder ${tag} disalin!`,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        // Preview controls
        function changePreviewMode(mode) {
            activeLangMode = mode;
            refreshLivePreview();
        }

        function setDeviceView(device) {
            const wrapper = document.getElementById('previewFrameWrapper');
            const btnDesktop = document.getElementById('btnViewDesktop');
            const btnMobile = document.getElementById('btnViewMobile');

            if (device === 'mobile') {
                wrapper.style.maxWidth = '380px';
                btnMobile.className = 'px-2 py-1 rounded text-xs text-white bg-teal-600 transition';
                btnDesktop.className = 'px-2 py-1 rounded text-xs text-slate-400 hover:text-white transition';
            } else {
                wrapper.style.maxWidth = '100%';
                btnDesktop.className = 'px-2 py-1 rounded text-xs text-white bg-teal-600 transition';
                btnMobile.className = 'px-2 py-1 rounded text-xs text-slate-400 hover:text-white transition';
            }
        }

        function refreshLivePreview() {
            const frame = document.getElementById('livePreviewFrame');
            frame.src = `/admin_pemeringkatan/email/${templateId}/preview?mode=${activeLangMode}&t=` + new Date().getTime();
        }

        // Test Email Modal Controls
        function openTestEmailModal() {
            document.getElementById('testEmailModal').classList.remove('hidden');
        }

        function closeTestEmailModal() {
            document.getElementById('testEmailModal').classList.add('hidden');
        }

        function handleSendTest(e) {
            e.preventDefault();
            const email = document.getElementById('testEmailInput').value;
            const langMode = document.getElementById('testEmailLangMode').value;
            const submitBtn = document.getElementById('btnSubmitTestEmail');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Mengirim...';

            fetch(`/admin_pemeringkatan/email/${templateId}/send-test`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    email: email,
                    language_mode: langMode
                })
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-1.5"></i> Kirim Sekarang';
                closeTestEmailModal();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Terkirim!',
                        text: data.message,
                        confirmButtonColor: '#0f766e'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengirim',
                        text: data.message || 'Terjadi kesalahan sistem.',
                        confirmButtonColor: '#0f766e'
                    });
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-1.5"></i> Kirim Sekarang';
                closeTestEmailModal();
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan',
                    text: err.message,
                    confirmButtonColor: '#0f766e'
                });
            });
        }
    </script>
    @endpush
@endsection
