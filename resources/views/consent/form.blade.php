<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Responden & Persetujuan QS WUR — Universitas Negeri Jakarta</title>
    
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-teal-50/20 to-emerald-50/30 min-h-screen flex flex-col justify-between text-gray-800 antialiased selection:bg-teal-500 selection:text-white">

    {{-- Main Container --}}
    <main class="flex-1 max-w-4xl w-full mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-teal-900/5 border border-gray-100 overflow-hidden">
            
            {{-- Header with UNJ Branding --}}
            <div class="bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-700 px-6 py-8 text-white relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl">
                    <i class="fas fa-university"></i>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                         alt="Universitas Negeri Jakarta Logo" 
                         class="h-16 w-16 drop-shadow-md object-contain">
                    
                    <div class="text-center sm:text-left flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-600/50 backdrop-blur-sm text-teal-100 text-xs font-semibold uppercase tracking-wider mb-2">
                            <i class="fas fa-file-signature"></i>
                            <span>{{ $category === 'academic' ? 'Academic Respondent Survey' : 'Employer / Employee Respondent Survey' }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight">
                            UNIVERSITAS NEGERI JAKARTA
                        </h1>
                        <p class="text-xs sm:text-sm text-teal-100 font-medium tracking-wide mt-1">
                            QS World University Rankings Campaign — {{ $session->name }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Validation Errors Alert --}}
            @if ($errors->any())
                <div class="m-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                    <div class="flex items-center gap-2 text-red-800 font-bold text-sm mb-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Mohon periksa kembali isian formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Start --}}
            <form action="{{ route('consent.submit_form', ['token' => $token]) }}" method="POST" class="p-6 sm:p-10 space-y-8">
                @csrf

                {{-- Letter & Invitation Section --}}
                <div class="bg-gradient-to-br from-teal-50/80 to-emerald-50/40 border border-teal-100/80 rounded-2xl p-6 sm:p-8 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">
                            {{ strtoupper(substr($fullname ?: 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs text-teal-700 font-semibold uppercase tracking-wider">Surat Undangan Partisipasi / Invitation Letter</div>
                            <div class="text-base font-bold text-gray-900">{{ $fullname ?: 'Bapak / Ibu' }}</div>
                        </div>
                    </div>

                    <div class="text-sm text-gray-700 leading-relaxed space-y-3 pt-2 border-t border-teal-100">
                        @if($category === 'academic')
                            <p>
                                <strong>Dear {{ $bankRespondent->title ? $bankRespondent->title . ' ' : '' }}{{ $fullname ?: 'Colleague' }},</strong>
                            </p>
                            <p>
                                We are writing to you as an esteemed academic partner and stakeholder of <strong>Universitas Negeri Jakarta (UNJ)</strong>. In support of our commitment to excellence and international recognition through the <strong>QS World University Rankings</strong>, we cordially invite you to verify your contact information and complete this brief questionnaire.
                            </p>
                            <p class="text-xs text-gray-500 italic">
                                Salam hangat dari Universitas Negeri Jakarta. Kami memohon kesediaan Bapak/Ibu akademisi untuk memverifikasi data kontak serta menjawab kuesioner singkat di bawah ini guna mendukung evaluasi reputasi akademik UNJ.
                            </p>
                        @else
                            <p>
                                <strong>Kepada Yth. {{ $bankRespondent->title ? $bankRespondent->title . ' ' : '' }}{{ $fullname ?: 'Bapak/Ibu' }},</strong>
                            </p>
                            <p>
                                Kami menghubungi Anda sebagai mitra industri dan pimpinan instansi terkemuka yang bekerja sama dengan <strong>Universitas Negeri Jakarta (UNJ)</strong>. Dalam rangka evaluasi reputasi lulusan dan kerja sama institusi pada <strong>QS World University Rankings</strong>, kami memohon kesediaan Bapak/Ibu untuk melengkapi formulir dan kuesioner singkat berikut.
                            </p>
                            <p class="text-xs text-gray-500 italic">
                                We cordially invite you as an esteemed industry employer/partner to verify your details and complete this brief survey for Universitas Negeri Jakarta's QS World University Rankings submission.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- SECTION 1: Data Responden --}}
                <div class="space-y-5">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 font-bold text-xs flex items-center justify-center">1</span>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900">Data Profil Responden</h2>
                        <span class="text-xs text-gray-400 font-normal ml-auto">* Periksa dan perbarui bila ada perubahan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Email (LOCKED / Read-Only) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                Email Terdaftar <span class="text-teal-600 font-normal lowercase">(dikunci demi keamanan data)</span>
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       value="{{ $bankRespondent->email }}" 
                                       readonly 
                                       tabindex="-1"
                                       class="w-full pl-10 pr-10 py-2.5 bg-gray-50 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium cursor-not-allowed focus:outline-none select-none">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-teal-600">
                                    <i class="fas fa-lock text-sm" title="Email dikunci"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Title --}}
                        @if(!empty($schema['standard_fields']['title']['enabled']))
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Gelar / Title @if(!empty($schema['standard_fields']['title']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="title" 
                                       value="{{ old('title', $bankRespondent->title) }}" 
                                       placeholder="Contoh: Prof. / Dr. / Mr. / Ms."
                                       {{ !empty($schema['standard_fields']['title']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @endif

                        {{-- First Name & Last Name --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                Nama Depan / First Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="first_name" 
                                   value="{{ old('first_name', $bankRespondent->first_name) }}" 
                                   required
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                Nama Belakang / Last Name
                            </label>
                            <input type="text" 
                                   name="last_name" 
                                   value="{{ old('last_name', $bankRespondent->last_name) }}" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                        </div>

                        {{-- Institution / Company --}}
                        @if($category === 'academic' && !empty($schema['standard_fields']['institution']['enabled']))
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Nama Institusi / Universitas @if(!empty($schema['standard_fields']['institution']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="institution" 
                                       value="{{ old('institution', $bankRespondent->institution) }}" 
                                       placeholder="Nama perguruan tinggi / institusi"
                                       {{ !empty($schema['standard_fields']['institution']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @elseif($category === 'employee' && !empty($schema['standard_fields']['company_name']['enabled']))
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Nama Perusahaan / Instansi @if(!empty($schema['standard_fields']['company_name']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="company_name" 
                                       value="{{ old('company_name', $bankRespondent->company_name) }}" 
                                       placeholder="Nama perusahaan atau organisasi"
                                       {{ !empty($schema['standard_fields']['company_name']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @endif

                        {{-- Job Title --}}
                        @if(!empty($schema['standard_fields']['job_title']['enabled']))
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Jabatan / Job Title @if(!empty($schema['standard_fields']['job_title']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="job_title" 
                                       value="{{ old('job_title', $bankRespondent->job_title) }}" 
                                       placeholder="Contoh: Dean / Professor / HR Director"
                                       {{ !empty($schema['standard_fields']['job_title']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @endif

                        {{-- Department --}}
                        @if(!empty($schema['standard_fields']['department']['enabled']))
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Departemen / Fakultas / Divisi @if(!empty($schema['standard_fields']['department']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="department" 
                                       value="{{ old('department', $bankRespondent->department) }}" 
                                       placeholder="Contoh: Faculty of Education / Human Capital"
                                       {{ !empty($schema['standard_fields']['department']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @endif

                        {{-- Country --}}
                        @if(!empty($schema['standard_fields']['country']['enabled']))
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Negara / Country @if(!empty($schema['standard_fields']['country']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="country" 
                                       value="{{ old('country', $bankRespondent->country) }}" 
                                       placeholder="Contoh: Indonesia / Malaysia / United States"
                                       {{ !empty($schema['standard_fields']['country']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @endif

                        {{-- Phone (Editable) --}}
                        @if(!empty($schema['standard_fields']['phone']['enabled']))
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                                    Nomor Telepon / WhatsApp @if(!empty($schema['standard_fields']['phone']['required'])) <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', $bankRespondent->phone) }}" 
                                       placeholder="+62 8..."
                                       {{ !empty($schema['standard_fields']['phone']['required']) ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- SECTION 2: Custom Questionnaire Questions (if any configured) --}}
                @if(!empty($schema['custom_questions']) && count($schema['custom_questions']) > 0)
                    <div class="space-y-6 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center">2</span>
                            <h2 class="text-base sm:text-lg font-bold text-gray-900">Pertanyaan Kuesioner</h2>
                        </div>

                        <div class="space-y-5">
                            @foreach($schema['custom_questions'] as $cq)
                                @php
                                    $qid = $cq['id'];
                                    $label = $cq['label'] ?? 'Pertanyaan';
                                    $type = $cq['type'] ?? 'text';
                                    $required = !empty($cq['required']);
                                    $options = $cq['options'] ?? [];
                                    $oldVal = old("answers.{$qid}");
                                @endphp

                                <div class="bg-gray-50/70 p-4 sm:p-5 rounded-2xl border border-gray-100 space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800">
                                        {{ $loop->iteration }}. {{ $label }}
                                        @if($required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>

                                    @if($type === 'text')
                                        <input type="text" 
                                               name="answers[{{ $qid }}]" 
                                               value="{{ $oldVal }}"
                                               {{ $required ? 'required' : '' }}
                                               placeholder="Tuliskan jawaban Anda di sini..."
                                               class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                                    
                                    @elseif($type === 'textarea')
                                        <textarea name="answers[{{ $qid }}]" 
                                                  rows="3"
                                                  {{ $required ? 'required' : '' }}
                                                  placeholder="Tuliskan jawaban lengkap Anda di sini..."
                                                  class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">{{ $oldVal }}</textarea>

                                    @elseif($type === 'number')
                                        <input type="number" 
                                               name="answers[{{ $qid }}]" 
                                               value="{{ $oldVal }}"
                                               {{ $required ? 'required' : '' }}
                                               placeholder="0"
                                               class="w-full sm:w-1/2 px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">

                                    @elseif($type === 'select')
                                        <select name="answers[{{ $qid }}]" 
                                                {{ $required ? 'required' : '' }}
                                                class="w-full sm:w-2/3 px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                                            <option value="">-- Pilih salah satu opsi --</option>
                                            @foreach($options as $opt)
                                                <option value="{{ $opt }}" {{ $oldVal === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>

                                    @elseif($type === 'radio')
                                        <div class="space-y-2 pt-1">
                                            @foreach($options as $optIdx => $opt)
                                                <label class="flex items-center gap-3 p-2.5 bg-white rounded-xl border border-gray-100 hover:border-teal-200 cursor-pointer transition-all">
                                                    <input type="radio" 
                                                           name="answers[{{ $qid }}]" 
                                                           value="{{ $opt }}" 
                                                           {{ $oldVal === $opt ? 'checked' : '' }}
                                                           {{ $required ? 'required' : '' }}
                                                           class="w-4 h-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                                                    <span class="text-sm text-gray-700">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- SECTION 3: Consent Checkbox & Submit --}}
                <div class="space-y-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 font-bold text-xs flex items-center justify-center">
                            {{ !empty($schema['custom_questions']) && count($schema['custom_questions']) > 0 ? '3' : '2' }}
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900">Persetujuan Partisipasi / Consent Statement</h2>
                    </div>

                    <div class="bg-teal-50/50 border border-teal-100 rounded-2xl p-5 space-y-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="consent_agreed" 
                                   value="1" 
                                   required 
                                   {{ old('consent_agreed') ? 'checked' : '' }}
                                   class="w-5 h-5 mt-0.5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700 leading-snug">
                                <strong>Saya bersedia dan memberikan izin</strong> kepada Universitas Negeri Jakarta untuk mendaftarkan data kontak saya ke pihak <strong>QS Quacquarelli Symonds</strong> sebagai responden evaluasi reputasi <em>QS World University Rankings</em>.
                                <br>
                                <span class="text-xs text-gray-500 italic mt-1 block">
                                    I hereby grant permission to Universitas Negeri Jakarta to submit my contact details to QS Quacquarelli Symonds for the QS Global Survey.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-4 px-6 bg-gradient-to-r from-teal-600 via-teal-700 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold text-base rounded-2xl shadow-lg shadow-teal-600/30 hover:shadow-xl hover:shadow-teal-600/40 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                            <i class="fas fa-paper-plane text-lg"></i>
                            <span>Kirim Formulir & Berikan Persetujuan / Submit Questionnaire</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <footer class="mt-8 text-center text-xs text-gray-400">
            <p>&copy; {{ date('Y') }} Universitas Negeri Jakarta. All rights reserved.</p>
            <p class="mt-1">Kantor Pemeringkatan dan Reputasi Internasional UNJ</p>
        </footer>
    </main>

</body>
</html>
