@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="p-6 space-y-6 max-w-7xl mx-auto">
    {{-- Breadcrumb & Action Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
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
                <span class="text-gray-800 font-semibold">Responden Menjawab</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                    <i class="fas fa-clipboard-check"></i>
                </span>
                Daftar Responden Yang Sudah Menjawab
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Tabel khusus responden yang telah memberikan persetujuan (consent) dan mengisi kuesioner pada sesi <strong>{{ $session->name }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $session) }}" 
               class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-xl shadow-xs transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Sesi
            </a>
            <a href="{{ route('admin_pemeringkatan.qs-sessions.export', ['session' => $session, 'consent_status' => 'agreed']) }}" 
               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fas fa-file-excel"></i>
                Export Jawaban (Excel)
            </a>
        </div>
    </div>

    {{-- Stats Cards Banner --}}
    @php
        $accessibleIds = Auth::user()->getAccessibleUserIds();
        $totalInSession = $accessibleIds !== null 
            ? $session->sessionRespondents()->whereIn('added_by', $accessibleIds)->count()
            : $session->sessionRespondents()->count();
        $responseRate = $totalInSession > 0 ? round(($totalAnswered / $totalInSession) * 100, 1) : 0;
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-500 font-medium mb-1">
                <span>Total Menjawab</span>
                <span class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fas fa-check-double"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-emerald-700">{{ number_format($totalAnswered) }}</div>
            <div class="text-[11px] text-gray-400 mt-1 font-medium">Responden terkonfirmasi</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-500 font-medium mb-1">
                <span>Academic Peer</span>
                <span class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                    <i class="fas fa-graduation-cap"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-indigo-700">{{ number_format($academicAnswered) }}</div>
            <div class="text-[11px] text-gray-400 mt-1 font-medium">Akademisi / Pakar</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-500 font-medium mb-1">
                <span>Employer / Industri</span>
                <span class="w-6 h-6 rounded-md bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                    <i class="fas fa-briefcase"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-purple-700">{{ number_format($employeeAnswered) }}</div>
            <div class="text-[11px] text-gray-400 mt-1 font-medium">Mitra Industri / Perusahaan</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-500 font-medium mb-1">
                <span>Tingkat Partisipasi</span>
                <span class="w-6 h-6 rounded-md bg-teal-50 text-teal-600 flex items-center justify-center text-xs">
                    <i class="fas fa-percentage"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-teal-700">{{ $responseRate }}%</div>
            <div class="text-[11px] text-gray-400 mt-1 font-medium">Dari {{ $totalInSession }} total responden</div>
        </div>
    </div>

    {{-- Filter & Search Card --}}
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin_pemeringkatan.qs-sessions.answered', $session) }}" class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex-1 flex flex-col sm:flex-row items-center gap-3">
                {{-- Search Input --}}
                <div class="relative w-full sm:w-80">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama, email, institusi, jabatan..." 
                           class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                {{-- Category Filter --}}
                <select name="category" onchange="this.form.submit()" 
                        class="w-full sm:w-44 px-3 py-2 border border-gray-300 rounded-xl text-xs bg-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    <option value="academic" {{ request('category') === 'academic' ? 'selected' : '' }}>Academic Peer</option>
                    <option value="employee" {{ request('category') === 'employee' ? 'selected' : '' }}>Employer</option>
                </select>

                {{-- Per Page --}}
                <select name="per_page" onchange="this.form.submit()" 
                        class="w-full sm:w-32 px-3 py-2 border border-gray-300 rounded-xl text-xs bg-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                    <i class="fas fa-filter mr-1"></i> Terapkan
                </button>
                @if(request()->hasAny(['search', 'category', 'per_page']))
                    <a href="{{ route('admin_pemeringkatan.qs-sessions.answered', $session) }}" 
                       class="px-3.5 py-2 border border-gray-300 text-gray-600 hover:bg-gray-100 text-xs font-semibold rounded-xl transition" title="Reset Filter">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/70 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-table-list text-teal-600"></i>
                Responden Yang Telah Menjawab ({{ $respondents->total() }})
            </h2>
            <span class="text-xs text-gray-400">
                Menampilkan {{ $respondents->firstItem() ?? 0 }}-{{ $respondents->lastItem() ?? 0 }} dari {{ $respondents->total() }} responden
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50/90 text-gray-500 uppercase tracking-wider text-[11px] border-b border-gray-200">
                        <th class="px-4 py-3.5 text-center w-12">No</th>
                        <th class="px-4 py-3.5">Responden</th>
                        <th class="px-4 py-3.5">Kategori</th>
                        <th class="px-4 py-3.5">Institusi / Afiliasi</th>
                        <th class="px-4 py-3.5">Ditambahkan Oleh</th>
                        <th class="px-4 py-3.5 text-center">Waktu Menjawab</th>
                        <th class="px-4 py-3.5">Jawaban Kuesioner</th>
                        <th class="px-4 py-3.5 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($respondents as $resp)
                        @php
                            $bank = $resp->bankRespondent;
                            $fullname = trim(($bank->first_name ?? '') . ' ' . ($bank->last_name ?? ''));
                            $answers = is_array($resp->form_answers) ? $resp->form_answers : [];
                            $answerCount = count($answers);
                        @endphp
                        <tr class="hover:bg-teal-50/30 transition">
                            {{-- No. --}}
                            <td class="px-4 py-3 text-center font-mono text-gray-500 text-xs">
                                {{ ($respondents->currentPage() - 1) * $respondents->perPage() + $loop->iteration }}
                            </td>

                            {{-- Responden Name & Contact --}}
                            <td class="px-4 py-3">
                                <div class="font-bold text-gray-900">
                                    <a href="{{ route('admin_pemeringkatan.qs-sessions.respondents.show', [$session, $resp]) }}" 
                                       class="hover:text-teal-600 hover:underline transition">
                                        @if($bank->title)
                                            <span class="text-xs text-gray-400 font-normal">{{ $bank->title }}</span>
                                        @endif
                                        {{ $fullname ?: 'Tanpa Nama' }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                    <span><i class="far fa-envelope mr-1 text-gray-400"></i>{{ $bank->email }}</span>
                                    @if($bank->phone)
                                        <span>•</span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bank->phone) }}" target="_blank" 
                                           class="text-teal-700 hover:underline flex items-center gap-1">
                                            <i class="fab fa-whatsapp text-emerald-500"></i>{{ $bank->phone }}
                                        </a>
                                    @endif
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-4 py-3">
                                @if($resp->category === 'academic')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <i class="fas fa-graduation-cap mr-1 text-[10px]"></i> Academic
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        <i class="fas fa-briefcase mr-1 text-[10px]"></i> Employer
                                    </span>
                                @endif
                            </td>

                            {{-- Institution & Position --}}
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">
                                    {{ $bank->institution ?: ($bank->company_name ?: '—') }}
                                </div>
                                <div class="text-[11px] text-gray-500">
                                    {{ $bank->job_title ?: ($bank->position ?: ($bank->department ?: '')) }}
                                    @if($bank->country)
                                        <span class="text-gray-400">({{ $bank->country }})</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Ditambahkan Oleh (User / Level) --}}
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                    <i class="fas fa-user-tag mr-1.5 text-gray-500 text-[10px]"></i>
                                    {{ $resp->added_by_label }}
                                </span>
                            </td>

                            {{-- Waktu Menjawab --}}
                            <td class="px-4 py-3 text-center">
                                @if($resp->form_submitted_at)
                                    <div class="font-semibold text-emerald-700">
                                        {{ $resp->form_submitted_at->translatedFormat('d/m/Y') }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">
                                        {{ $resp->form_submitted_at->translatedFormat('H:i') }} WIB
                                    </div>
                                @elseif($resp->consented_at)
                                    <div class="font-semibold text-emerald-700">
                                        {{ $resp->consented_at->translatedFormat('d/m/Y') }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">
                                        {{ $resp->consented_at->translatedFormat('H:i') }} WIB
                                    </div>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Jawaban Kuesioner Summary --}}
                            <td class="px-4 py-3">
                                @if($answerCount > 0)
                                    <div class="flex items-center gap-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200">
                                            <i class="fas fa-check text-[9px] mr-1 text-teal-600"></i>
                                            {{ $answerCount }} Pertanyaan Terjawab
                                        </span>
                                    </div>
                                @elseif($resp->form_submitted_at)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200">
                                        <i class="fas fa-clipboard-check text-[9px] mr-1 text-teal-600"></i>
                                        Formulir Diserahkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fas fa-check-circle text-[9px] mr-1"></i> Consent OK
                                    </span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin_pemeringkatan.qs-sessions.respondents.show', [$session, $resp]) }}" 
                                   title="Buka Jawaban & Detail Lengkap" 
                                   class="inline-flex items-center px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-semibold shadow-2xs transition gap-1.5">
                                    <i class="fas fa-eye text-[11px]"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center mx-auto mb-3 text-2xl">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="font-bold text-gray-700 text-sm">Belum Ada Responden Yang Menjawab</div>
                                <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                                    @if(request()->hasAny(['search', 'category']))
                                        Tidak ada responden menjawab yang cocok dengan pencarian / filter Anda. Coba reset filter.
                                    @else
                                        Responden pada sesi ini belum ada yang menyetujui (consent) atau mengisi formulir. Kirimkan email undangan consent untuk mengumpulkan respon.
                                    @endif
                                </p>
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
</div>
@endsection
