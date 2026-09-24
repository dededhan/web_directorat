@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div x-data="sessionManager()" class="p-6 space-y-6">
    {{-- Breadcrumb & Top Bar --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
                <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" class="hover:text-teal-600 transition">
                    QS Sessions
                </a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium">{{ $qs_session->name }}</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-gray-900">{{ $qs_session->name }}</h1>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                    @if($qs_session->status === 'active') bg-emerald-100 text-emerald-800 border border-emerald-200
                    @elseif($qs_session->status === 'draft') bg-amber-100 text-amber-800 border border-amber-200
                    @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                        @if($qs_session->status === 'active') bg-emerald-500
                        @elseif($qs_session->status === 'draft') bg-amber-500
                        @else bg-gray-400 @endif"></span>
                    {{ ucfirst($qs_session->status) }}
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                    @if($qs_session->isFormBased()) bg-purple-100 text-purple-800 border border-purple-200
                    @else bg-blue-100 text-blue-800 border border-blue-200 @endif">
                    <i class="fas @if($qs_session->isFormBased()) fa-file-signature text-purple-600 @else fa-mouse-pointer text-blue-600 @endif mr-1.5"></i>
                    {{ $qs_session->isFormBased() ? 'Form-Based Mode' : 'Consent-Only Mode' }}
                </span>
            </div>
            @if($qs_session->description)
                <p class="text-sm text-gray-500 mt-1 max-w-2xl">{{ $qs_session->description }}</p>
            @endif
        </div>
        <div class="flex items-center gap-2">
            @if(Auth::user()->isDirectorateAdmin())
            <a href="{{ route('admin_pemeringkatan.qs-sessions.edit', $qs_session) }}" 
               class="inline-flex items-center px-3.5 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-edit mr-1.5 text-gray-500"></i> Edit Sesi
            </a>
            @endif
            <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" 
               class="inline-flex items-center px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
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
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- Stats Cards --}}
    @php
        $totalResp = $stats['totalResp'] ?? $qs_session->total_count;
        $agreedResp = $stats['agreedResp'] ?? $qs_session->agreed_count;
        $pendingResp = $stats['pendingResp'] ?? $qs_session->pending_count;
        $emailedResp = $stats['emailedResp'] ?? $qs_session->email_sent_count;
        $academicResp = $stats['academicResp'] ?? ($qs_session->sessionRespondents()->where('category', 'academic')->count());
        $employeeResp = $stats['employeeResp'] ?? ($qs_session->sessionRespondents()->where('category', 'employee')->count());
        $rate = $stats['rate'] ?? $qs_session->consent_rate;
        $schema = $qs_session->getCustomFieldsSchema();
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-gray-500 font-medium">Total Responden</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalResp) }}</div>
            <div class="text-[11px] text-gray-400 mt-1">
                <span class="text-indigo-600 font-semibold">{{ $academicResp }} Acad</span> • 
                <span class="text-purple-600 font-semibold">{{ $employeeResp }} Empl</span>
            </div>
        </div>

        <a href="{{ route('admin_pemeringkatan.qs-sessions.answered', $qs_session) }}" 
           class="bg-white p-4 rounded-xl shadow-sm border border-emerald-200 hover:border-emerald-400 hover:bg-emerald-50/30 transition group block">
            <div class="flex items-center justify-between text-xs text-emerald-600 font-medium">
                <span>Consent Agreed</span>
                <i class="fas fa-arrow-right text-[10px] text-emerald-400 group-hover:translate-x-0.5 transition-transform"></i>
            </div>
            <div class="text-2xl font-bold text-emerald-700 mt-1">{{ number_format($agreedResp) }}</div>
            <div class="text-[11px] text-emerald-600 mt-1 font-semibold flex items-center justify-between">
                <span>{{ $rate }}% conversion</span>
                <span class="text-[10px] underline">Lihat Tabel →</span>
            </div>
        </a>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-amber-600 font-medium">Pending Consent</div>
            <div class="text-2xl font-bold text-amber-700 mt-1">{{ number_format($pendingResp) }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Belum klik persetujuan</div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-blue-600 font-medium">Email Terkirim</div>
            <div class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($emailedResp) }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Dari {{ $totalResp }} responden</div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-purple-600 font-medium">Belum Di-Email</div>
            <div class="text-2xl font-bold text-purple-700 mt-1">{{ number_format(max(0, $totalResp - $emailedResp)) }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Siap dikirim</div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-gray-500 font-medium">Custom Fields</div>
            <div class="text-2xl font-bold text-teal-600 mt-1">{{ count($schema) }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Kolom kustom aktif</div>
        </div>
    </div>

    {{-- Action Toolbar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            {{-- 1. Tambah Responden Langsung ke Sesi (Primary) --}}
            <button @click="openAddModal = true; addForm = { email: '', phone: '', checking: false, checkResult: null }" 
                    type="button"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                <i class="fas fa-plus mr-2"></i>
                Tambah Responden
            </button>

            {{-- 2. Import Excel --}}
            <button @click="openImportModal = true" 
                    type="button"
                    class="inline-flex items-center px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-file-excel mr-1.5"></i>
                Import Excel
            </button>

            @if(Auth::user()->isDirectorateAdmin())
            {{-- 3. Pilih dari Bank (Secondary) --}}
            <button @click="openAssignModal = true; loadAvailableRespondents()" 
                    type="button"
                    class="inline-flex items-center px-3.5 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-database mr-1.5 text-gray-500"></i>
                Pilih dari Bank
            </button>

            {{-- 4. Kelola Custom Fields --}}
            <button @click="openFieldsModal = true" 
                    type="button"
                    class="inline-flex items-center px-3.5 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-sliders-h mr-1.5 text-teal-600"></i>
                Custom Fields ({{ count($schema) }})
            </button>

            {{-- 5. Desain Form Kuesioner --}}
            <button @click="openFormDesignerModal = true" 
                    type="button"
                    class="inline-flex items-center px-3.5 py-2 @if($qs_session->isFormBased()) bg-purple-600 hover:bg-purple-700 text-white @else bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 @endif text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-file-signature mr-1.5 @if(!$qs_session->isFormBased()) text-purple-600 @endif"></i>
                Desain Form Kuesioner
            </button>
            @endif
        </div>

        <div class="flex items-center gap-2">
            {{-- Dedicated Answered Respondents Page --}}
            <a href="{{ route('admin_pemeringkatan.qs-sessions.answered', $qs_session) }}" 
               class="inline-flex items-center px-3.5 py-2 bg-emerald-50 border border-emerald-300 hover:bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-lg shadow-sm transition">
                <i class="fas fa-clipboard-check mr-1.5 text-emerald-600"></i>
                Responden Menjawab ({{ $agreedResp }})
            </a>

            {{-- Export Excel --}}
            <a href="{{ route('admin_pemeringkatan.qs-sessions.export', $qs_session) }}" 
               class="inline-flex items-center px-3.5 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-download mr-1.5 text-gray-500"></i> Export Excel
            </a>

            @if(Auth::user()->isDirectorateAdmin())
            {{-- Kirim Email Consent --}}
            <button @click="openEmailModal = true"
                    type="button"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fas fa-paper-plane mr-2"></i>
                Kirim Email Consent
            </button>
            @endif
        </div>
    </div>

    {{-- Bulk Action Floating Banner (appears when rows are selected) --}}
    <div x-show="selectedIds.length > 0" x-transition x-cloak
         class="bg-teal-50 border border-teal-200 rounded-xl p-3.5 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-lg bg-teal-600 text-white flex items-center justify-center font-bold text-sm">
                <span x-text="selectedIds.length"></span>
            </span>
            <div>
                <span class="text-sm font-bold text-gray-800" x-text="selectedIds.length + ' responden dipilih'"></span>
                <span class="text-xs text-gray-500 ml-1">Pilih tindakan massal di bawah:</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if(Auth::user()->isDirectorateAdmin())
            <button @click="openEmailModal = true; emailSendMode = 'selected'" 
                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5">
                <i class="fas fa-paper-plane"></i> Kirim Email
            </button>
            @endif
            <button @click="confirmBulkDelete()" 
                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5">
                <i class="fas fa-trash-alt"></i> Hapus Terpilih
            </button>
            <button @click="selectedIds = []" class="px-2.5 py-1.5 text-xs text-gray-500 hover:text-gray-700">
                Batal
            </button>
        </div>
    </div>

    {{-- Filter & Search Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin_pemeringkatan.qs-sessions.show', $qs_session) }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, email, institusi..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="w-full md:w-36">
                <select name="category" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Kategori: Semua</option>
                    <option value="academic" {{ request('category') === 'academic' ? 'selected' : '' }}>Academic</option>
                    <option value="employee" {{ request('category') === 'employee' ? 'selected' : '' }}>Employer</option>
                </select>
            </div>

            <div class="w-full md:w-40">
                <select name="consent_status" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Consent: Semua</option>
                    <option value="pending" {{ request('consent_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="agreed" {{ request('consent_status') === 'agreed' ? 'selected' : '' }}>Agreed</option>
                    <option value="expired" {{ request('consent_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <div class="w-full md:w-36">
                <select name="email_status" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Status Email</option>
                    <option value="sent" {{ request('email_status') === 'sent' ? 'selected' : '' }}>Terkirim</option>
                    <option value="not_sent" {{ request('email_status') === 'not_sent' ? 'selected' : '' }}>Belum Terkirim</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category', 'consent_status', 'email_status']))
                    <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $qs_session) }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-sm font-medium transition flex items-center">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Respondents Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-semibold tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center w-12">
                            <input type="checkbox" @change="toggleSelectAll($event)" 
                                   class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 h-4 w-4">
                        </th>
                        <th scope="col" class="px-4 py-3 text-left">Responden</th>
                        <th scope="col" class="px-4 py-3 text-left">Institusi / Perusahaan</th>
                        <th scope="col" class="px-4 py-3 text-left">Kategori</th>
                        @if(count($schema) > 0)
                            <th scope="col" class="px-4 py-3 text-left">Custom Fields</th>
                        @endif
                        <th scope="col" class="px-4 py-3 text-center">Status Consent</th>
                        <th scope="col" class="px-4 py-3 text-center">Status Email</th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($respondents as $resp)
                        @php
                            $bank = $resp->bankRespondent;
                            $fullname = trim(($bank->first_name ?? '') . ' ' . ($bank->last_name ?? ''));
                            $customData = is_array($resp->custom_fields) ? $resp->custom_fields : [];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" value="{{ $resp->id }}" 
                                       x-model="selectedIds"
                                       class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 h-4 w-4">
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">
                                    <a href="{{ route('admin_pemeringkatan.qs-sessions.respondents.show', [$qs_session, $resp]) }}" class="hover:text-teal-600 hover:underline transition">
                                        @if($bank->title)
                                            <span class="text-xs text-gray-400 font-normal">{{ $bank->title }}</span>
                                        @endif
                                        {{ $fullname ?: 'Tanpa Nama' }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                    <span><i class="far fa-envelope mr-1 text-gray-400"></i>{{ $bank->email }}</span>
                                    @if($bank->phone)
                                        <span>• <i class="fas fa-phone-alt text-[10px] text-gray-400 mr-0.5"></i>{{ $bank->phone }}</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span class="inline-flex items-center text-[10px] font-medium text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded border border-gray-200" title="Ditambahkan oleh unit / user">
                                        <i class="fas fa-user-tag text-[9px] text-gray-400 mr-1"></i> {{ $resp->added_by_label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 text-xs font-medium">
                                    {{ $bank->institution ?: ($bank->company_name ?: '—') }}
                                </div>
                                <div class="text-[11px] text-gray-400">
                                    {{ $bank->job_title ?: ($bank->position ?: ($bank->department ?: '')) }}
                                    @if($bank->country)
                                        ({{ $bank->country }})
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($resp->category === 'academic')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <i class="fas fa-graduation-cap mr-1 text-[10px]"></i> Academic
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                        <i class="fas fa-briefcase mr-1 text-[10px]"></i> Employer
                                    </span>
                                @endif
                            </td>

                            {{-- Custom Fields Column --}}
                            @if(count($schema) > 0)
                                <td class="px-4 py-3">
                                    <div class="space-y-1 text-xs">
                                        @php $hasVal = false; @endphp
                                        @foreach($schema as $f)
                                            @if(!empty($customData[$f['key']]))
                                                @php $hasVal = true; @endphp
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-gray-400 text-[10px] uppercase font-semibold">{{ $f['label'] }}:</span>
                                                    <span class="font-medium text-gray-700 bg-gray-100 px-1.5 py-0.5 rounded text-[11px]">{{ $customData[$f['key']] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if(!$hasVal)
                                            <span class="text-gray-300 text-xs">—</span>
                                        @endif
                                    </div>
                                </td>
                            @endif

                            <td class="px-4 py-3 text-center">
                                @if($resp->consent_status === 'agreed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check-circle mr-1 text-emerald-600"></i> Agreed
                                    </span>
                                    @if($resp->consented_at)
                                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $resp->consented_at->format('d/m/y H:i') }}</div>
                                    @endif
                                @elseif($resp->consent_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <i class="far fa-clock mr-1 text-amber-600"></i> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                        Expired
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($resp->email_sent_at)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="fas fa-check mr-1 text-[10px]"></i> Terkirim ({{ $resp->email_count }}x)
                                    </span>
                                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $resp->email_sent_at->format('d/m/y H:i') }}</div>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">
                                        Belum Dikirim
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                {{-- Lihat Detail & Jawaban Kuesioner Responden (Dedicated Page) --}}
                                <a href="{{ route('admin_pemeringkatan.qs-sessions.respondents.show', [$qs_session, $resp]) }}" 
                                   title="{{ ($resp->hasAnswered() || !empty($resp->form_answers)) ? 'Lihat Detail & Jawaban Kuesioner' : 'Lihat Detail Responden' }}" 
                                   class="p-1.5 {{ ($resp->hasAnswered() || !empty($resp->form_answers)) ? 'text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50' : 'text-gray-500 hover:text-teal-700 hover:bg-gray-100' }} rounded transition inline-flex items-center">
                                    <i class="fas {{ ($resp->hasAnswered() || !empty($resp->form_answers)) ? 'fa-clipboard-check' : 'fa-eye' }}"></i>
                                </a>

                                {{-- Edit Button (in-session modal) --}}
                                <button type="button" 
                                        @click="editRespondent({{ json_encode([
                                            'id' => $resp->id,
                                            'title' => $bank->title,
                                            'first_name' => $bank->first_name,
                                            'last_name' => $bank->last_name,
                                            'email' => $bank->email,
                                            'phone' => $bank->phone,
                                            'category' => $resp->category,
                                            'institution' => $bank->institution,
                                            'company_name' => $bank->company_name,
                                            'department' => $bank->department,
                                            'job_title' => $bank->job_title,
                                            'country' => $bank->country,
                                            'custom_fields' => $customData,
                                        ]) }})"
                                        title="Edit Responden di Sesi Ini" 
                                        class="p-1.5 text-gray-500 hover:text-teal-700 hover:bg-gray-100 rounded transition">
                                    <i class="fas fa-edit"></i>
                                </button>

                                @if(Auth::user()->isDirectorateAdmin())
                                {{-- Resend Email Button --}}
                                <form action="{{ route('admin_pemeringkatan.qs-sessions.resend', [$qs_session, $resp]) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Kirim email consent ke {{ $bank->email }}?');">
                                    @csrf
                                    <button type="submit" title="Kirim / Resend Email" 
                                            class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded transition">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Single Delete Button --}}
                                <form id="delete-form-{{ $resp->id }}" action="{{ route('admin_pemeringkatan.qs-sessions.unassign', [$qs_session, $resp]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            @click="confirmSingleDelete({{ $resp->id }}, '{{ $bank->email }}', '{{ $resp->consent_status }}')"
                                            title="Hapus Responden dari Sesi" 
                                            class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($schema) > 0 ? 8 : 7 }}" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                                <div class="font-medium text-gray-700">Belum ada responden di sesi ini</div>
                                <div class="text-xs text-gray-400 mt-1">Gunakan tombol "+ Tambah Responden" atau "Import Excel" di atas.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($respondents->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $respondents->links() }}
            </div>
        @endif
    </div>



    {{-- MODAL 1: Tambah Responden Langsung ke Sesi (Primary) --}}
    <div x-show="openAddModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openAddModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 bg-teal-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-plus text-lg"></i>
                    <h3 class="font-bold text-lg">Tambah Responden Baru ke Sesi Ini</h3>
                </div>
                <button @click="openAddModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin_pemeringkatan.qs-sessions.respondents.store', $qs_session) }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kategori Responden <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition border-teal-500 bg-teal-50/50">
                                <input type="radio" name="category" value="academic" checked required class="text-teal-600 focus:ring-teal-500">
                                <span class="ml-2 text-xs font-semibold text-gray-800">
                                    <i class="fas fa-graduation-cap text-indigo-500 mr-1"></i> Academic
                                </span>
                            </label>
                            <label class="flex items-center p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition border-gray-200">
                                <input type="radio" name="category" value="employee" required class="text-teal-600 focus:ring-teal-500">
                                <span class="ml-2 text-xs font-semibold text-gray-800">
                                    <i class="fas fa-briefcase text-purple-500 mr-1"></i> Employer
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Title</label>
                            <select name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">—</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Prof.">Prof.</option>
                            </select>
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Depan / Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" required placeholder="Contoh: Budi Santoso"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Belakang</label>
                            <input type="text" name="last_name" placeholder="Nama belakang (opsional)"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required placeholder="nama@institusi.ac.id"
                                   x-model="addForm.email"
                                   @input.debounce.400ms="checkAddAvailability()"
                                   @blur="checkAddAvailability()"
                                   class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                                   :class="addForm.checkResult && !addForm.checkResult.allowed && addForm.checkResult.field === 'email' ? 'border-red-500 ring-1 ring-red-500 bg-red-50/30' : 'border-gray-300'">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" placeholder="+62 812 3456 7890"
                                   x-model="addForm.phone"
                                   @input.debounce.400ms="checkAddAvailability()"
                                   @blur="checkAddAvailability()"
                                   class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                                   :class="addForm.checkResult && !addForm.checkResult.allowed && addForm.checkResult.field === 'phone' ? 'border-red-500 ring-1 ring-red-500 bg-red-50/30' : 'border-gray-300'">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Negara</label>
                            <input type="text" name="country" value="Indonesia" placeholder="Indonesia"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    {{-- Dynamic Live Alert Banner for Duplicate & Bank Check --}}
                    <div>
                        {{-- Loading Spinner --}}
                        <div x-show="addForm.checking" x-cloak class="p-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-500 flex items-center gap-2">
                            <i class="fas fa-spinner fa-spin text-teal-600"></i>
                            <span>Memeriksa ketersediaan email & nomor telepon...</span>
                        </div>

                        {{-- Blocked Alert (Red / Amber) --}}
                        <div x-show="!addForm.checking && addForm.checkResult && !addForm.checkResult.allowed" x-cloak
                             class="p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-800 flex items-start gap-2.5 shadow-xs">
                            <i class="fas fa-exclamation-triangle text-red-600 text-base mt-0.5 flex-shrink-0"></i>
                            <div class="space-y-0.5">
                                <div class="font-bold text-red-900">Perhatian: Responden Tidak Dapat Ditambahkan</div>
                                <div x-text="addForm.checkResult?.message"></div>
                            </div>
                        </div>

                        {{-- Allowed with Note (Pending in other session) --}}
                        <div x-show="!addForm.checking && addForm.checkResult && addForm.checkResult.allowed && addForm.checkResult.status === 'pending_in_other_session'" x-cloak
                             class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-800 flex items-start gap-2.5">
                            <i class="fas fa-info-circle text-blue-600 text-base mt-0.5 flex-shrink-0"></i>
                            <div class="space-y-0.5">
                                <div class="font-bold text-blue-900">Responden Ditemukan di Sesi Lain (Belum Consent)</div>
                                <div x-text="addForm.checkResult?.message"></div>
                            </div>
                        </div>

                        {{-- Fresh & Available (Green Check) --}}
                        <div x-show="!addForm.checking && addForm.checkResult && addForm.checkResult.allowed && addForm.checkResult.status === 'ok' && addForm.email && addForm.email.length >= 5" x-cloak
                             class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-600 text-sm flex-shrink-0"></i>
                            <span x-text="addForm.checkResult?.message"></span>
                        </div>
                    </div>

                    {{-- Institusi & Pekerjaan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Institusi / Universitas</label>
                            <input type="text" name="institution" placeholder="Contoh: Universitas Gadjah Mada"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Perusahaan (Bila Employer)</label>
                            <input type="text" name="company_name" placeholder="Contoh: PT Telkom"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Fakultas / Departemen</label>
                            <input type="text" name="department" placeholder="Contoh: Fakultas Teknik"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Jabatan / Posisi</label>
                            <input type="text" name="job_title" placeholder="Contoh: Dosen / Peneliti"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    {{-- Custom Fields Section (if configured) --}}
                    @if(count($schema) > 0)
                        <div class="pt-3 border-t border-teal-100">
                            <h4 class="text-xs font-bold text-teal-800 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                <i class="fas fa-sliders-h text-teal-600"></i> Custom Fields Sesi Ini
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 bg-teal-50/40 p-3.5 rounded-xl border border-teal-100">
                                @foreach($schema as $field)
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ $field['label'] }}
                                            @if(!empty($field['required'])) <span class="text-red-500">*</span> @endif
                                        </label>
                                        @if($field['type'] === 'select')
                                            <select name="custom_fields[{{ $field['key'] }}]" 
                                                    {{ !empty($field['required']) ? 'required' : '' }}
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                                                <option value="">— Pilih {{ $field['label'] }} —</option>
                                                @foreach($field['options'] ?? [] as $opt)
                                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($field['type'] === 'number')
                                            <input type="number" name="custom_fields[{{ $field['key'] }}]" 
                                                   {{ !empty($field['required']) ? 'required' : '' }}
                                                   placeholder="{{ $field['label'] }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        @elseif($field['type'] === 'date')
                                            <input type="date" name="custom_fields[{{ $field['key'] }}]" 
                                                   {{ !empty($field['required']) ? 'required' : '' }}
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        @else
                                            <input type="text" name="custom_fields[{{ $field['key'] }}]" 
                                                   {{ !empty($field['required']) ? 'required' : '' }}
                                                   placeholder="{{ $field['label'] }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openAddModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            :disabled="addForm.checkResult && !addForm.checkResult.allowed"
                            :class="addForm.checkResult && !addForm.checkResult.allowed ? 'opacity-50 cursor-not-allowed bg-gray-400' : 'bg-teal-600 hover:bg-teal-700'"
                            class="px-5 py-2 text-white text-sm font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5">
                        <i class="fas fa-check"></i>
                        <span>Simpan Responden</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 2: Edit Responden di Sesi --}}
    <div x-show="openEditModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openEditModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 bg-teal-700 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-edit text-lg"></i>
                    <h3 class="font-bold text-lg">Edit Data Responden</h3>
                </div>
                <button @click="openEditModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form :action="'{{ url('admin_pemeringkatan/qs-sessions/' . $qs_session->id . '/respondents') }}/' + editingRespondent.id" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kategori Responden <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                                   :class="editingRespondent.category === 'academic' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-200'">
                                <input type="radio" name="category" value="academic" x-model="editingRespondent.category" required class="text-teal-600 focus:ring-teal-500">
                                <span class="ml-2 text-xs font-semibold text-gray-800">
                                    <i class="fas fa-graduation-cap text-indigo-500 mr-1"></i> Academic
                                </span>
                            </label>
                            <label class="flex items-center p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                                   :class="editingRespondent.category === 'employee' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-200'">
                                <input type="radio" name="category" value="employee" x-model="editingRespondent.category" required class="text-teal-600 focus:ring-teal-500">
                                <span class="ml-2 text-xs font-semibold text-gray-800">
                                    <i class="fas fa-briefcase text-purple-500 mr-1"></i> Employer
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Title</label>
                            <select name="title" x-model="editingRespondent.title" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">—</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Prof.">Prof.</option>
                            </select>
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Depan / Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" x-model="editingRespondent.first_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Belakang</label>
                            <input type="text" name="last_name" x-model="editingRespondent.last_name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" x-model="editingRespondent.email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" x-model="editingRespondent.phone"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Negara</label>
                            <input type="text" name="country" x-model="editingRespondent.country"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    {{-- Institusi & Pekerjaan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Institusi / Universitas</label>
                            <input type="text" name="institution" x-model="editingRespondent.institution"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Perusahaan</label>
                            <input type="text" name="company_name" x-model="editingRespondent.company_name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Fakultas / Departemen</label>
                            <input type="text" name="department" x-model="editingRespondent.department"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Jabatan / Posisi</label>
                            <input type="text" name="job_title" x-model="editingRespondent.job_title"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    {{-- Custom Fields Section --}}
                    @if(count($schema) > 0)
                        <div class="pt-3 border-t border-teal-100">
                            <h4 class="text-xs font-bold text-teal-800 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                <i class="fas fa-sliders-h text-teal-600"></i> Custom Fields Sesi Ini
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 bg-teal-50/40 p-3.5 rounded-xl border border-teal-100">
                                @foreach($schema as $field)
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ $field['label'] }}
                                        </label>
                                        @if($field['type'] === 'select')
                                            <select name="custom_fields[{{ $field['key'] }}]" 
                                                    x-model="editingRespondent.custom_fields['{{ $field['key'] }}']"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                                                <option value="">— Pilih {{ $field['label'] }} —</option>
                                                @foreach($field['options'] ?? [] as $opt)
                                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($field['type'] === 'number')
                                            <input type="number" name="custom_fields[{{ $field['key'] }}]" 
                                                   x-model="editingRespondent.custom_fields['{{ $field['key'] }}']"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        @elseif($field['type'] === 'date')
                                            <input type="date" name="custom_fields[{{ $field['key'] }}]" 
                                                   x-model="editingRespondent.custom_fields['{{ $field['key'] }}']"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        @else
                                            <input type="text" name="custom_fields[{{ $field['key'] }}]" 
                                                   x-model="editingRespondent.custom_fields['{{ $field['key'] }}']"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openEditModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <i class="fas fa-save mr-1.5"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 3: Kelola Custom Fields Sesi --}}
    <div x-show="openFieldsModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openFieldsModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 bg-teal-800 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-sliders-h text-lg"></i>
                    <h3 class="font-bold text-lg">Kelola Custom Fields Sesi</h3>
                </div>
                <button @click="openFieldsModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin_pemeringkatan.qs-sessions.custom-fields-schema.update', $qs_session) }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                    <p class="text-xs text-gray-500">
                        Atur kolom tambahan khusus untuk sesi ini (misal: Fakultas/Unit, NIDN, Catatan Khusus). Kolom ini otomatis tersedia pada form responden dan file Excel import/export.
                    </p>

                    <div class="space-y-3">
                        <template x-for="(field, index) in customFields" :key="index">
                            <div class="p-3.5 bg-gray-50 border border-gray-200 rounded-xl space-y-3 relative group">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-teal-800" x-text="'Field #' + (index + 1)"></span>
                                    <button type="button" @click="removeCustomField(index)" class="text-red-500 hover:text-red-700 text-xs">
                                        <i class="fas fa-trash mr-1"></i> Hapus Field
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-700 mb-1">Label Kolom <span class="text-red-500">*</span></label>
                                        <input type="text" :name="'fields[' + index + '][label]'" x-model="field.label" required placeholder="Contoh: Fakultas / Unit"
                                               class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-teal-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-700 mb-1">Tipe Input <span class="text-red-500">*</span></label>
                                        <select :name="'fields[' + index + '][type]'" x-model="field.type" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs bg-white focus:ring-2 focus:ring-teal-500">
                                            <option value="text">Teks Bebas (Text)</option>
                                            <option value="number">Angka (Number)</option>
                                            <option value="date">Tanggal (Date)</option>
                                            <option value="select">Pilihan Dropdown (Select)</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- If select type: show options input --}}
                                <div x-show="field.type === 'select'">
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Opsi Dropdown (Pisahkan dengan koma)</label>
                                    <input type="text" :name="'fields[' + index + '][options]'" x-model="field.options_str" placeholder="FMIPA, FT, FIP, FBS, FE, FIS, FIK, FPsi"
                                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-teal-500">
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="checkbox" :name="'fields[' + index + '][required]'" value="1" x-model="field.required" class="rounded text-teal-600 focus:ring-teal-500 h-3.5 w-3.5">
                                    <span class="text-xs text-gray-600">Wajib diisi (Required)</span>
                                </div>
                            </div>
                        </template>

                        <div class="text-center pt-2">
                            <button type="button" @click="addCustomField()" 
                                    class="inline-flex items-center px-4 py-2 border-2 border-dashed border-teal-300 hover:border-teal-500 text-teal-700 text-xs font-semibold rounded-xl hover:bg-teal-50/50 transition">
                                <i class="fas fa-plus mr-1.5"></i> Tambah Field Kustom
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openFieldsModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <i class="fas fa-save mr-1.5"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 4: Assign from Bank (Existing) --}}
    <div x-show="openAssignModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openAssignModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-3xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 bg-teal-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-database text-lg"></i>
                    <h3 class="font-bold text-lg">Pilih dari Bank Responden</h3>
                </div>
                <button @click="openAssignModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin_pemeringkatan.qs-sessions.assign', $qs_session) }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kategori di Sesi Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                                   :class="assignCategory === 'academic' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-200'">
                                <input type="radio" name="category" value="academic" x-model="assignCategory" required class="text-teal-600 focus:ring-teal-500">
                                <span class="ml-2 text-xs font-medium text-gray-800">
                                    <i class="fas fa-graduation-cap text-indigo-500 mr-1"></i> Academic
                                </span>
                            </label>
                            <label class="flex items-center p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                                   :class="assignCategory === 'employee' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-200'">
                                <input type="radio" name="category" value="employee" x-model="assignCategory" required class="text-teal-600 focus:ring-teal-500">
                                <span class="ml-2 text-xs font-medium text-gray-800">
                                    <i class="fas fa-briefcase text-purple-500 mr-1"></i> Employer
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="relative">
                        <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                        <input type="text" x-model="bankSearch" @input.debounce.300ms="loadAvailableRespondents()" 
                               placeholder="Cari nama, email, institusi di bank..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-200 flex justify-between items-center text-xs text-gray-600">
                            <span class="font-semibold">Responden Tersedia (Belum ada di sesi ini)</span>
                            <span x-text="availableBank.length + ' responden ditemukan'"></span>
                        </div>
                        <div class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                            <template x-if="loadingBank">
                                <div class="p-8 text-center text-gray-400">
                                    <i class="fas fa-circle-notch fa-spin text-2xl mb-2"></i>
                                    <div class="text-xs">Memuat responden dari bank...</div>
                                </div>
                            </template>
                            <template x-if="!loadingBank && availableBank.length === 0">
                                <div class="p-8 text-center text-gray-400">
                                    <i class="fas fa-folder-open text-2xl mb-2"></i>
                                    <div class="text-xs">Tidak ada responden yang cocok atau semua sudah ditambahkan.</div>
                                </div>
                            </template>
                            <template x-for="person in availableBank" :key="person.id">
                                <label class="flex items-center px-4 py-2 hover:bg-gray-50 cursor-pointer transition">
                                    <input type="checkbox" name="respondent_ids[]" :value="person.id" 
                                           class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 h-4 w-4">
                                    <div class="ml-3 flex-1">
                                        <div class="text-xs font-semibold text-gray-900" x-text="person.first_name + ' ' + (person.last_name || '')"></div>
                                        <div class="text-[11px] text-gray-500" x-text="person.email + ' • ' + (person.institution || person.company_name || '—')"></div>
                                    </div>
                                    <span class="text-[10px] px-2 py-0.5 rounded font-medium"
                                          :class="person.category === 'academic' ? 'bg-indigo-50 text-indigo-700' : 'bg-purple-50 text-purple-700'"
                                          x-text="person.category || 'general'"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openAssignModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <i class="fas fa-plus mr-1"></i> Tambahkan ke Sesi
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 5: Import Excel --}}
    <div x-show="openImportModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openImportModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 bg-emerald-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-file-excel text-lg"></i>
                    <h3 class="font-bold text-lg">Import Responden ke Sesi</h3>
                </div>
                <button @click="openImportModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin_pemeringkatan.qs-sessions.import', $qs_session) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kategori Responden <span class="text-red-500">*</span>
                        </label>
                        <select name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="academic">Academic Respondent</option>
                            <option value="employee">Employer Respondent</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Pilih File Excel (.xlsx / .xls) <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="file" accept=".xlsx,.xls" required
                               class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-200 rounded-lg p-1.5 cursor-pointer">
                    </div>

                    {{-- Download Template Excel Box --}}
                    <div class="flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-xl p-3.5">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm shrink-0">
                                <i class="fas fa-file-download"></i>
                            </span>
                            <div>
                                <div class="text-xs font-bold text-emerald-900">Format Template Import (.xlsx)</div>
                                <div class="text-[11px] text-emerald-700">Dilengkapi format kolom standar & custom field sesi ini</div>
                            </div>
                        </div>
                        <a href="{{ route('admin_pemeringkatan.qs-sessions.template', $qs_session) }}" 
                           class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition flex items-center gap-1.5 shrink-0">
                            <i class="fas fa-download"></i> Unduh Template
                        </a>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-500 space-y-1">
                        <div class="font-semibold text-gray-700">Format Kolom Excel:</div>
                        <div>Kolom wajib: <code class="bg-gray-200 px-1 rounded">email</code>, <code class="bg-gray-200 px-1 rounded">first_name</code></div>
                        <div>Kolom opsional: <code class="bg-gray-200 px-1 rounded">last_name</code>, <code class="bg-gray-200 px-1 rounded">institution</code>, <code class="bg-gray-200 px-1 rounded">phone</code>, <code class="bg-gray-200 px-1 rounded">job_title</code></div>
                        @if(count($schema) > 0)
                            <div class="pt-1 text-teal-700 font-semibold">Custom fields sesi juga otomatis dikenali:</div>
                            <div class="text-[11px] text-teal-600">
                                @foreach($schema as $f)
                                    <code class="bg-teal-100 px-1 rounded">{{ $f['key'] }}</code>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openImportModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <i class="fas fa-upload mr-1"></i> Mulai Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 6: Kirim Email Consent --}}
    <div x-show="openEmailModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openEmailModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 bg-blue-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-paper-plane text-lg"></i>
                    <h3 class="font-bold text-lg">Kirim Email Permohonan Consent</h3>
                </div>
                <button @click="openEmailModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin_pemeringkatan.qs-sessions.send-email', $qs_session) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600">
                        Email undangan persetujuan (consent) akan dikirimkan ke responden dengan tautan persetujuan 1-klik (tanpa formulir pengisian ulang).
                    </p>

                    <div class="space-y-3">
                        <label class="flex items-start p-3 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                               :class="emailSendMode === 'selected' ? 'border-blue-500 bg-blue-50/50' : 'border-gray-200'">
                            <input type="radio" name="email_mode" value="selected" x-model="emailSendMode" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-2.5">
                                <div class="text-sm font-semibold text-gray-800">
                                    Kirim ke responden terpilih saja
                                </div>
                                <div class="text-xs text-gray-500" x-text="selectedIds.length + ' responden saat ini dipilih dari tabel.'"></div>
                            </div>
                        </label>

                        <label class="flex items-start p-3 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                               :class="emailSendMode === 'all_unsent' ? 'border-blue-500 bg-blue-50/50' : 'border-gray-200'">
                            <input type="radio" name="email_mode" value="all_unsent" x-model="emailSendMode" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-2.5">
                                <div class="text-sm font-semibold text-gray-800">
                                    Kirim massal ke SEMUA yang belum pernah di-email
                                </div>
                                <div class="text-xs text-gray-500">
                                    Otomatis mengirimkan ke {{ max(0, $totalResp - $emailedResp) }} responden yang belum menerima email.
                                </div>
                            </div>
                        </label>
                    </div>

                    <template x-if="emailSendMode === 'all_unsent'">
                        <input type="hidden" name="send_all" value="1">
                    </template>
                    <template x-if="emailSendMode === 'selected'">
                        <div>
                            <template x-for="id in selectedIds" :key="id">
                                <input type="hidden" name="respondent_ids[]" :value="id">
                            </template>
                        </div>
                    </template>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openEmailModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            :disabled="emailSendMode === 'selected' && selectedIds.length === 0"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <i class="fas fa-paper-plane mr-1"></i> Mulai Kirim Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Designer Modal (Academic vs Employer Form Customization) --}}
    <div x-show="openFormDesignerModal" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openFormDesignerModal = false"
             class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden animate-fade-in">
            
            {{-- Modal Header --}}
            <div class="px-6 py-5 bg-gradient-to-r from-purple-700 via-indigo-700 to-teal-700 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-tasks text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Desain Formulir Kuesioner Responden</h3>
                        <p class="text-xs text-purple-100">Kustomisasi kolom profil & pertanyaan kuesioner terpisah untuk Academic dan Employer.</p>
                    </div>
                </div>
                <button @click="openFormDesignerModal = false" class="text-white/80 hover:text-white p-2 rounded-lg hover:bg-white/10 transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            {{-- Tabs: Academic vs Employer --}}
            <div class="flex border-b border-gray-200 bg-gray-50 px-6 pt-3">
                <button type="button" 
                        @click="activeFormTab = 'academic'"
                        :class="activeFormTab === 'academic' ? 'border-b-2 border-indigo-600 text-indigo-700 font-bold bg-white' : 'text-gray-500 hover:text-gray-700'"
                        class="px-5 py-3 text-sm rounded-t-xl transition flex items-center gap-2">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Formulir Akademik (Academic)</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800" x-text="(academicSchema.custom_questions || []).length + ' Pertanyaan'"></span>
                </button>
                <button type="button" 
                        @click="activeFormTab = 'employee'"
                        :class="activeFormTab === 'employee' ? 'border-b-2 border-purple-600 text-purple-700 font-bold bg-white' : 'text-gray-500 hover:text-gray-700'"
                        class="px-5 py-3 text-sm rounded-t-xl transition flex items-center gap-2">
                    <i class="fas fa-briefcase"></i>
                    <span>Formulir Industri (Employer)</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-purple-100 text-purple-800" x-text="(employeeSchema.custom_questions || []).length + ' Pertanyaan'"></span>
                </button>
            </div>

            {{-- Modal Body (Scrollable) --}}
            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-sm">
                
                {{-- TAB 1: ACADEMIC --}}
                <div x-show="activeFormTab === 'academic'" class="space-y-6">
                    <div class="bg-indigo-50/60 border border-indigo-100 p-4 rounded-xl text-xs text-indigo-900 flex items-center gap-2">
                        <i class="fas fa-info-circle text-indigo-600 text-base"></i>
                        <span>Pengaturan ini berlaku saat responden kategori <strong>Academic</strong> membuka tautan kuesioner pada sesi ini.</span>
                    </div>

                    {{-- Standard Fields Academic --}}
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-3 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-indigo-600"></i>
                            Kolom Profil Standar (Academic)
                        </h4>
                        <div class="border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">
                            <template x-for="(config, fieldKey) in academicSchema.standard_fields" :key="fieldKey">
                                <div class="p-3.5 bg-white hover:bg-gray-50 flex items-center justify-between transition">
                                    <div>
                                        <span class="font-semibold text-gray-800 capitalize" x-text="getFieldDisplayName(fieldKey)"></span>
                                        <span class="text-xs text-gray-400 ml-2" x-text="'(' + fieldKey + ')'"></span>
                                    </div>
                                    <div class="flex items-center gap-6 text-xs">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" x-model="config.enabled" class="rounded text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-gray-700">Tampilkan</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer" :class="!config.enabled ? 'opacity-40 pointer-events-none' : ''">
                                            <input type="checkbox" x-model="config.required" :disabled="!config.enabled" class="rounded text-red-600 focus:ring-red-500">
                                            <span class="text-red-600 font-medium">Wajib Diisi</span>
                                        </label>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Custom Questions Academic --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wider flex items-center gap-2">
                                <i class="fas fa-question-circle text-indigo-600"></i>
                                Pertanyaan Tambahan / Kuesioner (Academic)
                            </h4>
                            <button type="button" @click="addCustomQuestion('academic')" 
                                    class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow-sm transition flex items-center gap-1.5">
                                <i class="fas fa-plus"></i> Tambah Pertanyaan
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-if="!academicSchema.custom_questions || academicSchema.custom_questions.length === 0">
                                <div class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl text-gray-400 text-xs">
                                    Belum ada pertanyaan tambahan untuk Academic. Klik <strong>"+ Tambah Pertanyaan"</strong> untuk membuat survei kuesioner.
                                </div>
                            </template>

                            <template x-for="(q, idx) in academicSchema.custom_questions" :key="q.id || idx">
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-3 relative group">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                                            <div class="md:col-span-2">
                                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Pertanyaan / Label Kuesioner</label>
                                                <input type="text" x-model="q.label" placeholder="Contoh: Bidang riset utama Anda?"
                                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Tipe Input</label>
                                                <select x-model="q.type" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                                    <option value="text">Teks Singkat (Text)</option>
                                                    <option value="textarea">Teks Panjang (Textarea)</option>
                                                    <option value="number">Angka (Number)</option>
                                                    <option value="select">Pilihan Menu (Select Dropdown)</option>
                                                    <option value="radio">Pilihan Opsi (Radio Button)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeCustomQuestion('academic', idx)" 
                                                class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Hapus Pertanyaan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>

                                    {{-- Options for select/radio --}}
                                    <template x-if="q.type === 'select' || q.type === 'radio'">
                                        <div class="pt-2 border-t border-gray-200">
                                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Opsi Jawaban (pisahkan dengan koma)</label>
                                            <input type="text" 
                                                   :value="(q.options || []).join(', ')" 
                                                   @input="q.options = $event.target.value.split(',').map(s => s.trim()).filter(Boolean)"
                                                   placeholder="Contoh: Ya, Tidak, Belum Menentukan"
                                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                        </div>
                                    </template>

                                    <div class="flex items-center justify-between text-xs pt-1">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" x-model="q.required" class="rounded text-red-600 focus:ring-red-500">
                                            <span class="text-red-600 font-medium">Wajib Diisi oleh Responden</span>
                                        </label>
                                        <span class="text-gray-400 text-[10px]" x-text="'ID: ' + q.id"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: EMPLOYEE --}}
                <div x-show="activeFormTab === 'employee'" class="space-y-6">
                    <div class="bg-purple-50/60 border border-purple-100 p-4 rounded-xl text-xs text-purple-900 flex items-center gap-2">
                        <i class="fas fa-info-circle text-purple-600 text-base"></i>
                        <span>Pengaturan ini berlaku saat responden kategori <strong>Employer / Mitra Industri</strong> membuka tautan kuesioner pada sesi ini.</span>
                    </div>

                    {{-- Standard Fields Employee --}}
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-3 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-purple-600"></i>
                            Kolom Profil Standar (Employer)
                        </h4>
                        <div class="border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">
                            <template x-for="(config, fieldKey) in employeeSchema.standard_fields" :key="fieldKey">
                                <div class="p-3.5 bg-white hover:bg-gray-50 flex items-center justify-between transition">
                                    <div>
                                        <span class="font-semibold text-gray-800 capitalize" x-text="getFieldDisplayName(fieldKey)"></span>
                                        <span class="text-xs text-gray-400 ml-2" x-text="'(' + fieldKey + ')'"></span>
                                    </div>
                                    <div class="flex items-center gap-6 text-xs">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" x-model="config.enabled" class="rounded text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-700">Tampilkan</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer" :class="!config.enabled ? 'opacity-40 pointer-events-none' : ''">
                                            <input type="checkbox" x-model="config.required" :disabled="!config.enabled" class="rounded text-red-600 focus:ring-red-500">
                                            <span class="text-red-600 font-medium">Wajib Diisi</span>
                                        </label>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Custom Questions Employee --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wider flex items-center gap-2">
                                <i class="fas fa-question-circle text-purple-600"></i>
                                Pertanyaan Tambahan / Kuesioner (Employer)
                            </h4>
                            <button type="button" @click="addCustomQuestion('employee')" 
                                    class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-semibold shadow-sm transition flex items-center gap-1.5">
                                <i class="fas fa-plus"></i> Tambah Pertanyaan
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-if="!employeeSchema.custom_questions || employeeSchema.custom_questions.length === 0">
                                <div class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl text-gray-400 text-xs">
                                    Belum ada pertanyaan tambahan untuk Employer. Klik <strong>"+ Tambah Pertanyaan"</strong> untuk membuat survei kuesioner.
                                </div>
                            </template>

                            <template x-for="(q, idx) in employeeSchema.custom_questions" :key="q.id || idx">
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-3 relative group">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                                            <div class="md:col-span-2">
                                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Pertanyaan / Label Kuesioner</label>
                                                <input type="text" x-model="q.label" placeholder="Contoh: Berapa banyak lulusan UNJ yang bekerja di perusahaan Anda?"
                                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Tipe Input</label>
                                                <select x-model="q.type" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                                                    <option value="text">Teks Singkat (Text)</option>
                                                    <option value="textarea">Teks Panjang (Textarea)</option>
                                                    <option value="number">Angka (Number)</option>
                                                    <option value="select">Pilihan Menu (Select Dropdown)</option>
                                                    <option value="radio">Pilihan Opsi (Radio Button)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeCustomQuestion('employee', idx)" 
                                                class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Hapus Pertanyaan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>

                                    {{-- Options for select/radio --}}
                                    <template x-if="q.type === 'select' || q.type === 'radio'">
                                        <div class="pt-2 border-t border-gray-200">
                                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Opsi Jawaban (pisahkan dengan koma)</label>
                                            <input type="text" 
                                                   :value="(q.options || []).join(', ')" 
                                                   @input="q.options = $event.target.value.split(',').map(s => s.trim()).filter(Boolean)"
                                                   placeholder="Contoh: 1-5 orang, 6-20 orang, Lebih dari 20 orang"
                                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                                        </div>
                                    </template>

                                    <div class="flex items-center justify-between text-xs pt-1">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" x-model="q.required" class="rounded text-red-600 focus:ring-red-500">
                                            <span class="text-red-600 font-medium">Wajib Diisi oleh Responden</span>
                                        </label>
                                        <span class="text-gray-400 text-[10px]" x-text="'ID: ' + q.id"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <span class="text-xs text-gray-500">Perubahan akan langsung diterapkan pada tautan pengisian formulir.</span>
                <div class="flex items-center gap-3">
                    <button type="button" @click="openFormDesignerModal = false" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium transition">
                        Tutup
                    </button>
                    <button type="button" @click="saveFormSchema()" :disabled="savingSchema"
                            class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin" x-show="savingSchema" x-cloak></i>
                        <i class="fas fa-save" x-show="!savingSchema"></i>
                        <span>Simpan Desain Formulir</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Answers Viewer Modal --}}
    <div x-show="openAnswersModal" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openAnswersModal = false"
             class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] flex flex-col overflow-hidden animate-fade-in">
            
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-700 to-teal-700 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-clipboard-check text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold">Hasil Pengisian Kuesioner Responden</h3>
                        <p class="text-xs text-emerald-100" x-text="currentAnswersRespondentName || 'Responden'"></p>
                    </div>
                </div>
                <button @click="openAnswersModal = false" class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-5 flex-1">
                <template x-if="loadingAnswers">
                    <div class="text-center py-12">
                        <i class="fas fa-circle-notch fa-spin text-3xl text-teal-600 mb-3"></i>
                        <p class="text-sm text-gray-500">Memuat jawaban kuesioner...</p>
                    </div>
                </template>

                <template x-if="!loadingAnswers && currentAnswersData">
                    <div class="space-y-5">
                        {{-- Meta Info Card --}}
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-gray-400 block uppercase font-semibold">Responden:</span>
                                <span class="font-bold text-gray-800" x-text="(currentAnswersData.respondent?.bank_respondent?.first_name || '') + ' ' + (currentAnswersData.respondent?.bank_respondent?.last_name || '')"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block uppercase font-semibold">Email:</span>
                                <span class="font-medium text-gray-700" x-text="currentAnswersData.respondent?.bank_respondent?.email"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block uppercase font-semibold">Kategori:</span>
                                <span class="capitalize font-bold text-indigo-700" x-text="currentAnswersData.category"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block uppercase font-semibold">Waktu Submit:</span>
                                <span class="font-medium text-emerald-700" x-text="currentAnswersData.submitted_at || '—'"></span>
                            </div>
                        </div>

                        {{-- Submitted Answers List --}}
                        <div class="space-y-4">
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fas fa-list-ul text-teal-600"></i>
                                Jawaban Pertanyaan Kuesioner
                            </h4>

                            <template x-if="!currentAnswersData.schema?.custom_questions || currentAnswersData.schema.custom_questions.length === 0">
                                <p class="text-xs text-gray-400 italic">Tidak ada pertanyaan kuesioner kustom yang tercatat pada sesi ini.</p>
                            </template>

                            <template x-for="(q, idx) in currentAnswersData.schema?.custom_questions || []" :key="q.id">
                                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-xs space-y-1.5">
                                    <div class="text-xs font-semibold text-gray-500" x-text="'Pertanyaan ' + (idx + 1) + ':'"></div>
                                    <div class="text-sm font-bold text-gray-900" x-text="q.label"></div>
                                    <div class="pt-2 border-t border-gray-100">
                                        <div class="text-sm text-teal-800 font-medium bg-teal-50/70 p-3 rounded-lg border border-teal-100" 
                                             x-text="currentAnswersData.answers[q.id] || '(Tidak dijawab)'"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="px-6 py-3.5 bg-gray-50 border-t border-gray-200 flex items-center justify-end">
                <button type="button" @click="openAnswersModal = false" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden Form for Bulk Delete --}}
    <form id="bulk-delete-form" action="{{ route('admin_pemeringkatan.qs-sessions.bulk-delete', $qs_session) }}" method="POST" class="hidden">
        @csrf
        <template x-for="id in selectedIds" :key="id">
            <input type="hidden" name="respondent_ids[]" :value="id">
        </template>
    </form>
</div>

<script>
function sessionManager() {
    return {
        selectedIds: [],
        openAddModal: false,
        openEditModal: false,
        openFieldsModal: false,
        openAssignModal: false,
        openImportModal: false,
        openEmailModal: false,
        addForm: {
            email: '',
            phone: '',
            checking: false,
            checkResult: null
        },
        openFormDesignerModal: false,
        activeFormTab: 'academic',
        academicSchema: {!! json_encode($qs_session->getFormSchema('academic')) !!},
        employeeSchema: {!! json_encode($qs_session->getFormSchema('employee')) !!},
        savingSchema: false,
        openAnswersModal: false,
        loadingAnswers: false,
        currentAnswersRespondentName: '',
        currentAnswersData: null,
        assignCategory: 'academic',
        bankSearch: '',
        availableBank: [],
        loadingBank: false,
        emailSendMode: 'all_unsent',
        editingRespondent: {
            id: null,
            title: '',
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            category: 'academic',
            institution: '',
            company_name: '',
            department: '',
            job_title: '',
            country: 'Indonesia',
            custom_fields: {}
        },
        customFields: {!! json_encode(array_map(function($f) {
            $f['options_str'] = is_array($f['options'] ?? null) ? implode(', ', $f['options']) : ($f['options'] ?? '');
            return $f;
        }, $schema)) !!},

        getFieldDisplayName(key) {
            const map = {
                title: 'Gelar Kehormatan (Title)',
                first_name: 'Nama Depan',
                last_name: 'Nama Belakang',
                institution: 'Nama Universitas / Institusi',
                company_name: 'Nama Perusahaan / Industri',
                job_title: 'Jabatan / Posisi Pekerjaan',
                department: 'Departemen / Fakultas / Divisi',
                country: 'Negara (Country)',
                phone: 'Nomor Telepon / WhatsApp'
            };
            return map[key] || key;
        },

        addCustomQuestion(tab) {
            const target = tab === 'academic' ? this.academicSchema : this.employeeSchema;
            if (!target.custom_questions) target.custom_questions = [];
            target.custom_questions.push({
                id: 'q_' + Date.now(),
                label: '',
                type: 'text',
                options: [],
                required: false
            });
        },

        removeCustomQuestion(tab, index) {
            const target = tab === 'academic' ? this.academicSchema : this.employeeSchema;
            target.custom_questions.splice(index, 1);
        },

        async saveFormSchema() {
            this.savingSchema = true;
            try {
                const url = '{{ route("admin_pemeringkatan.qs-sessions.form-schema.update", $qs_session) }}';
                const res = await axios.post(url, {
                    academic_form_schema: this.academicSchema,
                    employee_form_schema: this.employeeSchema
                });
                if (res.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.data.message || 'Desain formulir kuesioner berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    this.openFormDesignerModal = false;
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: err.response?.data?.message || 'Terjadi kesalahan saat menyimpan skema kuesioner.'
                });
            } finally {
                this.savingSchema = false;
            }
        },

        async viewAnswers(respondentId, respondentName) {
            this.currentAnswersRespondentName = respondentName;
            this.openAnswersModal = true;
            this.loadingAnswers = true;
            this.currentAnswersData = null;

            try {
                const url = '{{ url("admin_pemeringkatan/qs-sessions/" . $qs_session->id . "/respondents") }}/' + respondentId + '/answers';
                const res = await axios.get(url);
                this.currentAnswersData = res.data;
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Jawaban',
                    text: 'Tidak dapat mengambil jawaban kuesioner responden.'
                });
                this.openAnswersModal = false;
            } finally {
                this.loadingAnswers = false;
            }
        },

        async checkAddAvailability() {
            const email = (this.addForm.email || '').trim();
            const phone = (this.addForm.phone || '').trim();

            if (!email) {
                this.addForm.checkResult = null;
                return;
            }

            this.addForm.checking = true;
            try {
                const url = '{{ route("admin_pemeringkatan.qs-sessions.check-respondent", $qs_session) }}'
                    + '?email=' + encodeURIComponent(email)
                    + (phone ? '&phone=' + encodeURIComponent(phone) : '');
                const res = await axios.get(url);
                this.addForm.checkResult = res.data;
            } catch (err) {
                console.error(err);
            } finally {
                this.addForm.checking = false;
            }
        },

        toggleSelectAll(e) {
            if (e.target.checked) {
                const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                this.selectedIds = Array.from(checkboxes).map(cb => cb.value);
            } else {
                this.selectedIds = [];
            }
        },

        editRespondent(data) {
            this.editingRespondent = {
                id: data.id,
                title: data.title || '',
                first_name: data.first_name || '',
                last_name: data.last_name || '',
                email: data.email || '',
                phone: data.phone || '',
                category: data.category || 'academic',
                institution: data.institution || '',
                company_name: data.company_name || '',
                department: data.department || '',
                job_title: data.job_title || '',
                country: data.country || 'Indonesia',
                custom_fields: data.custom_fields || {}
            };
            this.openEditModal = true;
        },

        addCustomField() {
            this.customFields.push({
                label: '',
                key: '',
                type: 'text',
                options_str: '',
                required: false
            });
        },

        removeCustomField(index) {
            this.customFields.splice(index, 1);
        },

        confirmSingleDelete(id, email, status) {
            let title = 'Hapus Responden?';
            let text = `Apakah Anda yakin ingin mengeluarkan ${email} dari sesi ini?`;
            let icon = 'warning';

            if (status === 'agreed') {
                title = 'Perhatian: Responden Sudah Consent!';
                text = `Responden ${email} sudah memberikan persetujuan (consent). Menghapus responden akan mencabut status keikutsertaannya dari sesi ini (namun catatan audit log tetap tersimpan). Lanjutkan?`;
                icon = 'warning';
            }

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        },

        confirmBulkDelete() {
            if (this.selectedIds.length === 0) return;

            Swal.fire({
                title: 'Hapus ' + this.selectedIds.length + ' Responden Terpilih?',
                text: 'Responden yang dipilih akan dikeluarkan dari sesi kampanye ini. Jika ada yang sudah memberikan consent, data partisipasinya dalam sesi ini akan dicabut.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Semua Terpilih!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bulk-delete-form').submit();
                }
            });
        },

        async loadAvailableRespondents() {
            this.loadingBank = true;
            try {
                const url = '{{ route("admin_pemeringkatan.qs-sessions.available-respondents", $qs_session) }}' 
                    + '?search=' + encodeURIComponent(this.bankSearch);
                const res = await axios.get(url);
                this.availableBank = res.data.data || [];
            } catch (err) {
                console.error(err);
                window.Alert?.error('Gagal memuat responden bank');
            } finally {
                this.loadingBank = false;
            }
        }
    }
}
</script>
@endsection
