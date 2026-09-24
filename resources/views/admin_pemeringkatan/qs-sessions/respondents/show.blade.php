@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="p-6 space-y-6 max-w-7xl mx-auto">
    {{-- Breadcrumb & Header Action Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <div>
            <nav class="flex items-center text-xs text-gray-500 mb-2 gap-1.5" aria-label="Breadcrumb">
                <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" class="hover:text-teal-600 transition">
                    QS Sessions
                </a>
                <span>/</span>
                <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $session) }}" class="hover:text-teal-600 transition">
                    {{ $session->name }}
                </a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Detail Responden</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-id-card text-teal-600"></i>
                Detail Responden & Jawaban Kuesioner
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Data profil lengkap, status partisipasi, dan hasil isian formulir kuesioner pada sesi <strong>{{ $session->name }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin_pemeringkatan.qs-sessions.answered', $session) }}" 
               class="px-3.5 py-2 bg-white border border-teal-200 hover:bg-teal-50 text-teal-800 text-xs font-semibold rounded-xl shadow-xs transition flex items-center gap-2">
                <i class="fas fa-list-check text-teal-600"></i>
                Daftar Menjawab
            </a>
            <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $session) }}" 
               class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-xl shadow-xs transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Sesi
            </a>
            <button type="button" onclick="window.print()" 
                    class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fas fa-print"></i>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    {{-- Hero Respondent Banner --}}
    @php
        $fullName = trim(($bank->first_name ?? '') . ' ' . ($bank->last_name ?? ''));
        $initials = '';
        if (!empty($bank->first_name)) $initials .= strtoupper(substr($bank->first_name, 0, 1));
        if (!empty($bank->last_name)) $initials .= strtoupper(substr($bank->last_name, 0, 1));
        if (empty($initials)) $initials = 'R';
    @endphp

    <div class="bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-800 rounded-2xl shadow-lg text-white p-6 sm:p-8 relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-32 -bottom-16 w-48 h-48 bg-emerald-400/10 rounded-full blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center gap-4 sm:gap-6">
                {{-- Avatar Circle --}}
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-xl sm:text-2xl font-black shadow-inner shrink-0">
                    {{ $initials }}
                </div>

                {{-- Name & Title --}}
                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($bank->title)
                            <span class="px-2 py-0.5 rounded text-xs font-medium bg-white/20 text-white border border-white/20">
                                {{ $bank->title }}
                            </span>
                        @endif
                        <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
                            {{ $fullName ?: ($bank->email ?? 'Responden Tanpa Nama') }}
                        </h2>
                    </div>

                    <p class="text-sm text-teal-100 flex items-center gap-2 flex-wrap">
                        @if($bank->job_title)
                            <span>{{ $bank->job_title }}</span>
                        @endif
                        @if($bank->institution || $bank->company_name)
                            <span>•</span>
                            <span class="font-medium">{{ $bank->institution ?: $bank->company_name }}</span>
                        @endif
                        @if($bank->country)
                            <span>•</span>
                            <span>{{ $bank->country }}</span>
                        @endif
                    </p>

                    <div class="flex items-center gap-4 text-xs text-teal-200/90 pt-1 flex-wrap">
                        <span class="flex items-center gap-1.5">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:{{ $bank->email }}" class="hover:underline">{{ $bank->email }}</a>
                        </span>
                        @if($bank->phone)
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-phone-alt"></i>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bank->phone) }}" target="_blank" class="hover:underline">
                                    {{ $bank->phone }}
                                </a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Badges / Pills --}}
            <div class="flex flex-wrap md:flex-col items-start md:items-end gap-2 shrink-0">
                {{-- Category Badge --}}
                @if($category === 'academic')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-teal-900 shadow-sm">
                        <i class="fas fa-graduation-cap text-teal-600 mr-1.5"></i> Academic Peer
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-purple-900 shadow-sm">
                        <i class="fas fa-briefcase text-purple-600 mr-1.5"></i> Employer / Mitra Industri
                    </span>
                @endif

                {{-- Consent Status --}}
                @if($respondent->consent_status === 'agreed')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-400/20 text-emerald-100 border border-emerald-400/40 backdrop-blur-xs">
                        <i class="fas fa-check-circle mr-1.5 text-emerald-300"></i> Consent Diberikan
                    </span>
                @elseif($respondent->consent_status === 'pending')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-400/20 text-amber-100 border border-amber-400/40 backdrop-blur-xs">
                        <i class="far fa-clock mr-1.5 text-amber-300"></i> Menunggu Consent
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-white/80 border border-white/20">
                        Expired
                    </span>
                @endif

                {{-- Form Submission Status --}}
                @if($respondent->hasSubmittedForm() || !empty($answers))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                        <i class="fas fa-clipboard-check mr-1.5 text-emerald-300"></i> Formulir Telah Diserahkan
                    </span>
                @elseif($respondent->consent_status === 'agreed')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                        <i class="fas fa-check-double mr-1.5 text-emerald-300"></i> Direct Consent Diterima
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-black/20 text-white/70 border border-white/10">
                        <i class="fas fa-hourglass-half mr-1.5 text-white/50"></i> Formulir Belum Diisi
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        {{-- LEFT COLUMN: Profil & Metadata Responden --}}
        <div class="space-y-6 lg:col-span-1">
            
            {{-- Card 1: Data Kontak & Profil --}}
            <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/70 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
                        <i class="fas fa-user-circle text-teal-600 text-sm"></i>
                        Profil Responden
                    </h3>
                    <span class="text-[11px] text-gray-400 font-medium">Bank Responden #{{ $bank->id }}</span>
                </div>
                <div class="p-5 divide-y divide-gray-100 text-xs">
                    <div class="py-2.5 first:pt-0 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Gelar (Title)</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->title ?: '—' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Nama Depan</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->first_name ?: '—' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Nama Belakang</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->last_name ?: '—' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Alamat Email</span>
                        <span class="font-semibold text-teal-700 text-right break-all">{{ $bank->email }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Nomor WhatsApp/HP</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->phone ?: '—' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Negara</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->country ?: '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Card 2: Institusi & Posisi --}}
            <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/70 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
                        <i class="fas fa-building text-teal-600 text-sm"></i>
                        Institusi & Afiliasi
                    </h3>
                </div>
                <div class="p-5 divide-y divide-gray-100 text-xs">
                    <div class="py-2.5 first:pt-0 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">
                            {{ $category === 'academic' ? 'Universitas / Institusi' : 'Perusahaan / Organisasi' }}
                        </span>
                        <span class="font-semibold text-gray-800 text-right">
                            {{ $bank->institution ?: ($bank->company_name ?: '—') }}
                        </span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Departemen / Fakultas</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->department ?: '—' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Jabatan / Posisi</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $bank->job_title ?: ($bank->position ?: '—') }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Kategori Sesi</span>
                        <span class="font-semibold capitalize text-teal-700 text-right">{{ $category }}</span>
                    </div>
                </div>
            </div>

            {{-- Card 3: Custom Fields Sesi (Jika Sesi Memiliki Kolom Kustom) --}}
            @if(!empty($customFieldsSchema) && count($customFieldsSchema) > 0)
                <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/70 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
                            <i class="fas fa-sliders-h text-teal-600 text-sm"></i>
                            Data Khusus Sesi (Custom Fields)
                        </h3>
                    </div>
                    <div class="p-5 divide-y divide-gray-100 text-xs">
                        @php
                            $customValues = is_array($respondent->custom_fields) ? $respondent->custom_fields : [];
                        @endphp
                        @foreach($customFieldsSchema as $field)
                            @php
                                $val = $customValues[$field['key']] ?? null;
                            @endphp
                            <div class="py-2.5 first:pt-0 flex justify-between items-start gap-3">
                                <div>
                                    <span class="text-gray-500 font-medium block">{{ $field['label'] }}</span>
                                    <span class="text-[10px] text-gray-400">({{ $field['key'] }})</span>
                                </div>
                                <span class="font-semibold text-gray-800 text-right">
                                    {{ !empty($val) ? (is_array($val) ? implode(', ', $val) : $val) : '—' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Card 4: Histori Partisipasi Sesi --}}
            <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/70 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-teal-600 text-sm"></i>
                        Aktivitas & Log Waktu
                    </h3>
                </div>
                <div class="p-5 divide-y divide-gray-100 text-xs">
                    <div class="py-2.5 first:pt-0 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Ditambahkan Oleh</span>
                        <span class="font-semibold text-teal-800 text-right bg-teal-50 px-2 py-0.5 rounded border border-teal-200">
                            {{ $respondent->added_by_label }}
                        </span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Ditambahkan ke Sesi</span>
                        <span class="font-medium text-gray-700 text-right">
                            {{ $respondent->created_at ? $respondent->created_at->translatedFormat('d M Y, H:i') : '—' }}
                        </span>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Status Pengiriman Email</span>
                        <div class="text-right">
                            @if($respondent->email_sent_at)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    Terkirim ({{ $respondent->email_count }}x)
                                </span>
                                <div class="text-[10px] text-gray-400 mt-0.5">{{ $respondent->email_sent_at->translatedFormat('d M Y, H:i') }}</div>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-500">
                                    Belum Dikirim
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Waktu Persetujuan (Consent)</span>
                        <div class="text-right">
                            @if($respondent->consented_at)
                                <span class="font-semibold text-emerald-700">
                                    {{ $respondent->consented_at->translatedFormat('d M Y, H:i:s') }} WIB
                                </span>
                            @else
                                <span class="text-gray-400">Belum disetujui</span>
                            @endif
                        </div>
                    </div>
                    <div class="py-2.5 flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium">Waktu Submit Formulir</span>
                        <div class="text-right">
                            @if($respondent->form_submitted_at)
                                <span class="font-semibold text-emerald-700">
                                    {{ $respondent->form_submitted_at->translatedFormat('d M Y, H:i:s') }} WIB
                                </span>
                            @else
                                <span class="text-gray-400">Belum submit formulir</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: HASIL JAWABAN KUESIONER & PERSETUJUAN --}}
        <div class="space-y-6 lg:col-span-2">
            
            <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                {{-- Header Card --}}
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-poll-h"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-gray-900">
                                Hasil Isian Formulir Kuesioner & Persetujuan
                            </h2>
                            <p class="text-xs text-gray-500">
                                Kategori: <strong class="capitalize text-teal-700">{{ $category }}</strong>
                                • Mode Sesi: <strong class="text-gray-700">{{ $session->isFormBased() ? 'Formulir Kuesioner (Form-Based)' : 'Tautan Persetujuan (Consent-Only)' }}</strong>
                            </p>
                        </div>
                    </div>

                    @if($respondent->form_submitted_at || !empty($answers))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 self-start sm:self-auto">
                            <i class="fas fa-check-circle mr-1.5 text-emerald-500"></i>
                            Formulir Diserahkan ({{ $respondent->form_submitted_at ? $respondent->form_submitted_at->translatedFormat('d M Y, H:i') . ' WIB' : ($respondent->consented_at ? $respondent->consented_at->translatedFormat('d M Y, H:i') . ' WIB' : 'Selesai') }})
                        </span>
                    @elseif($respondent->consent_status === 'agreed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 self-start sm:self-auto">
                            <i class="fas fa-check-circle mr-1.5 text-emerald-500"></i>
                            Persetujuan Diterima ({{ $respondent->consented_at ? $respondent->consented_at->translatedFormat('d M Y, H:i') . ' WIB' : 'Selesai' }})
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 self-start sm:self-auto">
                            <i class="far fa-clock mr-1.5 text-amber-500"></i>
                            Menunggu Pengisian
                        </span>
                    @endif
                </div>

                {{-- Answers Body --}}
                <div class="p-6">
                    @php
                        $customQuestions = $schema['custom_questions'] ?? [];
                        $hasSubmitted = $respondent->hasSubmittedForm() || $respondent->consent_status === 'agreed' || !empty($answers);
                        $displayedKeys = [];
                    @endphp

                    @if($hasSubmitted)
                        {{-- Submission Notice --}}
                        <div class="mb-6 p-4 rounded-xl bg-emerald-50/80 border border-emerald-200 text-emerald-900 text-xs flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                    <i class="fas fa-check text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-sm block text-emerald-950">
                                        {{ $respondent->form_submitted_at ? 'Formulir Kuesioner Berhasil Diserahkan' : 'Persetujuan Keikutsertaan Berhasil Dikonfirmasi' }}
                                    </span>
                                    <p class="text-emerald-700 text-[11px] mt-0.5">
                                        Responden telah mengonfirmasi data profil dan memberikan persetujuan (consent) untuk sesi pemeringkatan ini.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] font-mono">
                                @if($respondent->form_submitted_at)
                                    <span class="text-emerald-800 bg-white/90 px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs font-medium">
                                        <i class="fas fa-clock mr-1 text-emerald-600"></i> {{ $respondent->form_submitted_at->translatedFormat('d F Y, H:i:s') }} WIB
                                    </span>
                                @elseif($respondent->consented_at)
                                    <span class="text-emerald-800 bg-white/90 px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs font-medium">
                                        <i class="fas fa-clock mr-1 text-emerald-600"></i> {{ $respondent->consented_at->translatedFormat('d F Y, H:i:s') }} WIB
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- SECTION 1: Data Profil & Kontak Terverifikasi --}}
                        <div class="mb-6 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-2xs">
                            <div class="px-5 py-3.5 bg-gray-50/80 border-b border-gray-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-teal-700 text-white flex items-center justify-center text-xs font-bold shrink-0">1</span>
                                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider">
                                        Data Profil & Identitas Kontak Terverifikasi
                                    </h4>
                                </div>
                                <span class="text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    <i class="fas fa-check-circle mr-1"></i> Dikonfirmasi Responden
                                </span>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">Nama Lengkap & Gelar</span>
                                    <span class="font-bold text-gray-900 text-sm">
                                        {{ trim(($bank->title ? $bank->title . ' ' : '') . $bank->first_name . ' ' . $bank->last_name) ?: '—' }}
                                    </span>
                                </div>
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">Alamat Email Resmi</span>
                                    <span class="font-bold text-teal-800 text-sm break-all flex items-center gap-1.5">
                                        <i class="fas fa-envelope text-teal-600 text-xs"></i>
                                        {{ $bank->email }}
                                    </span>
                                </div>
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">Nomor WhatsApp / HP</span>
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ $bank->phone ?: '—' }}
                                    </span>
                                </div>
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">Negara</span>
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ $bank->country ?: '—' }}
                                    </span>
                                </div>
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">
                                        {{ $category === 'academic' ? 'Universitas / Institusi' : 'Perusahaan / Organisasi' }}
                                    </span>
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ $bank->institution ?: ($bank->company_name ?: '—') }}
                                    </span>
                                </div>
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">Fakultas / Departemen</span>
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ $bank->department ?: '—' }}
                                    </span>
                                </div>
                                <div class="p-3 bg-gray-50/60 rounded-lg border border-gray-100 sm:col-span-2">
                                    <span class="text-gray-400 text-[10px] uppercase font-semibold block mb-0.5">Jabatan / Posisi Resmi</span>
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ $bank->job_title ?: ($bank->position ?: '—') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: Pertanyaan Kuesioner Tambahan (Kustom) --}}
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-6 h-6 rounded-lg bg-teal-700 text-white flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Jawaban Pertanyaan Kuesioner Tambahan
                                </h4>
                                @if(count($customQuestions) > 0)
                                    <span class="text-[11px] font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded ml-auto">
                                        {{ count($customQuestions) }} Pertanyaan
                                    </span>
                                @endif
                            </div>

                            @if(count($customQuestions) > 0)
                                <div class="space-y-4">
                                    @foreach($customQuestions as $idx => $q)
                                        @php
                                            $qid = $q['id'] ?? ('q_' . $idx);
                                            $displayedKeys[] = $qid;
                                            $answerValue = $answers[$qid] ?? null;
                                            $isAnswered = !is_null($answerValue) && $answerValue !== '' && $answerValue !== [];
                                        @endphp

                                        <div class="bg-gray-50/80 border border-gray-200 rounded-xl p-5 hover:border-teal-300 transition">
                                            <div class="flex items-start justify-between gap-3 mb-2.5">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-5 h-5 rounded-md bg-teal-600 text-white flex items-center justify-center text-[11px] font-bold shrink-0">
                                                        {{ $idx + 1 }}
                                                    </span>
                                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                        Pertanyaan {{ $idx + 1 }}
                                                    </span>
                                                    @if(!empty($q['required']))
                                                        <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded border border-rose-200">
                                                            Wajib
                                                        </span>
                                                    @endif
                                                </div>

                                                <span class="text-[11px] font-semibold text-gray-500 bg-white px-2 py-0.5 rounded border border-gray-200">
                                                    @if(($q['type'] ?? '') === 'select')
                                                        Pilihan Menu (Select)
                                                    @elseif(($q['type'] ?? '') === 'radio')
                                                        Pilihan Tunggal (Radio)
                                                    @elseif(($q['type'] ?? '') === 'textarea')
                                                        Teks Panjang (Textarea)
                                                    @elseif(($q['type'] ?? '') === 'number')
                                                        Angka (Number)
                                                    @else
                                                        Teks Singkat (Text)
                                                    @endif
                                                </span>
                                            </div>

                                            <h5 class="text-sm font-bold text-gray-900 mb-3 pl-7">
                                                {{ $q['label'] ?? 'Pertanyaan ' . ($idx + 1) }}
                                            </h5>

                                            <div class="pl-7">
                                                @if($isAnswered)
                                                    <div class="bg-white border-l-4 border-teal-500 rounded-r-xl p-4 shadow-2xs border-y border-r border-gray-200">
                                                        <div class="text-[10px] font-bold uppercase tracking-wider text-teal-700 mb-1 flex items-center gap-1.5">
                                                            <i class="fas fa-check-circle text-teal-500"></i> Jawaban Responden:
                                                        </div>
                                                        
                                                        @if(is_array($answerValue))
                                                            <div class="flex flex-wrap gap-1.5 mt-1">
                                                                @foreach($answerValue as $ansItem)
                                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-teal-50 text-teal-800 border border-teal-200">
                                                                        <i class="fas fa-check text-[10px] text-teal-600 mr-1.5"></i>
                                                                        {{ $ansItem }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <p class="text-sm font-medium text-gray-900 whitespace-pre-line leading-relaxed">
                                                                {{ $answerValue }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="bg-white border border-dashed border-gray-300 rounded-xl p-3 text-xs italic text-gray-400">
                                                        (Responden tidak mengisi jawaban pada pertanyaan ini)
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-5 bg-teal-50/50 border border-teal-100 rounded-xl text-teal-900 text-xs flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center shrink-0 text-base">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-800 text-xs block">Tidak Ada Pertanyaan Kuesioner Tambahan Pada Sesi Ini</span>
                                        <span class="text-gray-500 text-[11px] block mt-0.5">
                                            Sesi ini dikonfigurasi menggunakan formulir standar verifikasi profil kontak dan pernyataan persetujuan (consent declaration). Seluruh isian yang diwajibkan telah berhasil diselesaikan oleh responden.
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Remaining answers not in schema (if schema was altered after submission) --}}
                        @php
                            $remainingAnswers = [];
                            foreach ($answers as $k => $v) {
                                if (!in_array($k, $displayedKeys)) {
                                    $remainingAnswers[$k] = $v;
                                }
                            }
                        @endphp

                        @if(!empty($remainingAnswers))
                            <div class="mb-6 pt-5 border-t border-gray-200">
                                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <i class="fas fa-archive text-gray-500"></i>
                                    Jawaban Formulir Tambahan Lainnya
                                </h4>
                                <div class="space-y-3">
                                    @foreach($remainingAnswers as $key => $val)
                                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                            <span class="text-xs font-semibold text-gray-500 block mb-1">Kunci / ID: {{ $key }}</span>
                                            <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-lg border border-gray-200">
                                                {{ is_array($val) ? implode(', ', $val) : $val }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- SECTION 3: Bukti & Catatan Persetujuan (Consent Declaration) --}}
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-2xs">
                            <div class="px-5 py-3.5 bg-gray-50/80 border-b border-gray-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-teal-700 text-white flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider">
                                        Bukti & Catatan Persetujuan (Consent Declaration)
                                    </h4>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                                    <i class="fas fa-check text-[10px]"></i> Disetujui (Agreed)
                                </span>
                            </div>
                            <div class="p-5 text-xs space-y-3">
                                <div class="p-3 bg-emerald-50/50 rounded-lg border border-emerald-100 text-emerald-950 font-medium leading-relaxed">
                                    <i class="fas fa-quote-left text-emerald-600 mr-1.5 opacity-60"></i>
                                    Responden menyatakan bersedia dan menyetujui data profil dan kontaknya di atas digunakan oleh Universitas Negeri Jakarta dan QS (Quacquarelli Symonds) untuk keperluan evaluasi survei pemeringkatan universitas dunia (QS World University Rankings).
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-[11px] pt-1">
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                                        <span class="text-gray-400 block font-semibold uppercase text-[10px]">Waktu Persetujuan</span>
                                        <span class="font-bold text-emerald-800 mt-0.5 block">
                                            {{ $respondent->consented_at ? $respondent->consented_at->translatedFormat('d M Y, H:i:s') . ' WIB' : '—' }}
                                        </span>
                                    </div>
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                                        <span class="text-gray-400 block font-semibold uppercase text-[10px]">Status Tautan (Token)</span>
                                        <span class="font-bold text-gray-700 mt-0.5 block">
                                            Telah Digunakan (Single-use Expired)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- Not yet answered state --}}
                        <div class="text-center py-12 px-6">
                            <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center mx-auto mb-4 text-2xl">
                                <i class="far fa-hourglass"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-800 mb-1">
                                Responden Belum Mengisi Formulir Kuesioner
                            </h3>
                            <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed mb-6">
                                Responden belum membuka atau menyelesaikan formulir pada tautan persetujuan. Setelah responden mengisi dan menekan tombol kirim, semua jawaban survei akan tampil lengkap pada halaman ini.
                            </p>

                            @if(count($customQuestions) > 0)
                                <div class="text-left bg-gray-50 rounded-xl border border-gray-200 p-5 max-w-2xl mx-auto">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <i class="fas fa-list text-gray-500"></i>
                                        Daftar Pertanyaan yang Disiapkan untuk Kategori Ini ({{ count($customQuestions) }} Pertanyaan)
                                    </h4>
                                    <ul class="space-y-2 text-xs text-gray-600">
                                        @foreach($customQuestions as $idx => $q)
                                            <li class="flex items-start gap-2">
                                                <span class="font-bold text-teal-700 shrink-0">{{ $idx + 1 }}.</span>
                                                <div>
                                                    <span class="font-medium text-gray-800">{{ $q['label'] }}</span>
                                                    @if(!empty($q['required']))
                                                        <span class="text-[10px] text-rose-600 font-semibold ml-1">(Wajib)</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>

                {{-- Footer Action Bar --}}
                <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-200 flex items-center justify-between no-print">
                    <span class="text-xs text-gray-400">
                        ID Responden Sesi: <strong class="font-mono text-gray-600">#{{ $respondent->id }}</strong>
                    </span>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $session) }}" 
                           class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 rounded-xl text-xs font-semibold transition flex items-center gap-1.5">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Sesi
                        </a>

                        @if($session->status === 'active' && $respondent->consent_status !== 'agreed')
                            <form action="{{ route('admin_pemeringkatan.qs-sessions.resend', [$session, $respondent]) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Kirimkan email undangan consent ke {{ $bank->email }}?');">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5">
                                    <i class="fas fa-paper-plane"></i> Kirim Ulang Email Consent
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- Print Styling --}}
<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white !important;
    }
    main {
        overflow: visible !important;
    }
    .shadow-sm, .shadow-md, .shadow-lg, .shadow-xs {
        box-shadow: none !important;
    }
    .border {
        border-color: #e5e7eb !important;
    }
    @page {
        margin: 1.5cm;
    }
}
</style>
@endsection
