@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div x-data="{ openImportModal: false }" class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-database text-teal-600"></i>
                Bank Responden (Central Registry)
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pusat data induk calon dan riwayat responden QS UNJ. Email bersifat unik sebagai pengidentifikasi utama.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin_pemeringkatan.responden-bank.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                <i class="fas fa-user-plus mr-2"></i> Tambah Responden
            </a>
            <button @click="openImportModal = true" type="button"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                <i class="fas fa-file-excel mr-2"></i> Import Excel
            </button>
            <a href="{{ route('admin_pemeringkatan.responden-bank.export', request()->query()) }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-lg shadow-sm transition">
                <i class="fas fa-download mr-2 text-gray-500"></i> Export Excel
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

    {{-- Search and Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin_pemeringkatan.responden-bank.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, email, institusi, jabatan, perusahaan..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="w-full md:w-36">
                <select name="category" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Kategori</option>
                    <option value="academic" {{ request('category') === 'academic' ? 'selected' : '' }}>Academic</option>
                    <option value="employee" {{ request('category') === 'employee' ? 'selected' : '' }}>Employer</option>
                </select>
            </div>

            <div class="w-full md:w-44">
                <select name="source" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Sumber</option>
                    <option value="legacy_migration" {{ request('source') === 'legacy_migration' ? 'selected' : '' }}>Legacy Migration</option>
                    <option value="manual" {{ request('source') === 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="import" {{ request('source') === 'import' ? 'selected' : '' }}>Excel Import</option>
                    <option value="form_submission" {{ request('source') === 'form_submission' ? 'selected' : '' }}>Form Submission</option>
                </select>
            </div>

            <div class="w-full md:w-36">
                <input type="text" name="country" value="{{ request('country') }}" 
                       placeholder="Negara..." 
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category', 'source', 'country']))
                    <a href="{{ route('admin_pemeringkatan.responden-bank.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-sm font-medium transition flex items-center">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Bank Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-3 bg-gray-50/70 border-b border-gray-200 flex justify-between items-center text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-semibold text-gray-700">{{ $respondents->firstItem() ?? 0 }}-{{ $respondents->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-gray-700">{{ number_format($respondents->total()) }}</span> total responden di bank
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs">Tampilkan:</span>
                <select onchange="window.location.href = this.value" class="border border-gray-200 rounded px-2 py-0.5 text-xs bg-white">
                    @foreach([25, 50, 100, 200] as $size)
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $size]) }}" {{ request('per_page', 50) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-semibold tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama & Kontak</th>
                        <th class="px-4 py-3 text-left">Institusi / Perusahaan</th>
                        <th class="px-4 py-3 text-left">Jabatan / Departemen</th>
                        <th class="px-4 py-3 text-center">Kategori</th>
                        <th class="px-4 py-3 text-center">Negara</th>
                        <th class="px-4 py-3 text-center">Sumber</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($respondents as $resp)
                        @php
                            $fullname = trim(($resp->first_name ?? '') . ' ' . ($resp->last_name ?? ''));
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">
                                    @if($resp->title)
                                        <span class="text-xs text-gray-400 mr-0.5">{{ $resp->title }}</span>
                                    @endif
                                    {{ $fullname ?: 'Tanpa Nama' }}
                                </div>
                                <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                    <span><i class="far fa-envelope mr-1 text-gray-400"></i>{{ $resp->email }}</span>
                                    @if($resp->phone)
                                        <span>• <i class="fas fa-phone-alt text-[10px] text-gray-400 mr-0.5"></i>{{ $resp->phone }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 text-xs font-medium">
                                    {{ $resp->institution ?: ($resp->company_name ?: '—') }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-xs text-gray-700">
                                    {{ $resp->job_title ?: ($resp->position ?: '—') }}
                                </div>
                                @if($resp->department)
                                    <div class="text-[11px] text-gray-400">{{ $resp->department }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($resp->category === 'academic')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        Academic
                                    </span>
                                @elseif($resp->category === 'employee')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                        Employer
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-xs text-gray-600">
                                {{ $resp->country ?: '—' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-medium
                                    @if($resp->source === 'legacy_migration') bg-slate-100 text-slate-700
                                    @elseif($resp->source === 'manual') bg-teal-50 text-teal-700 border border-teal-200
                                    @elseif($resp->source === 'import') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                    {{ ucwords(str_replace('_', ' ', $resp->source)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin_pemeringkatan.responden-bank.edit', $resp) }}" 
                                   class="p-1.5 text-gray-500 hover:text-teal-700 rounded hover:bg-gray-100 transition inline-block"
                                   title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin_pemeringkatan.responden-bank.destroy', $resp) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus responden ini dari Bank? Pastikan responden tidak sedang berada di sesi aktif.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 rounded hover:bg-red-50 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-database text-xl"></i>
                                </div>
                                <div class="font-medium text-gray-700">Belum ada data di Bank Responden</div>
                                <div class="text-xs text-gray-400 mt-1">Tambahkan responden secara manual atau gunakan fitur Import Excel.</div>
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

    {{-- Import Excel Modal --}}
    <div x-show="openImportModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openImportModal = false" 
             class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 bg-emerald-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-file-excel text-lg"></i>
                    <h3 class="font-bold text-lg">Import ke Bank Responden</h3>
                </div>
                <button @click="openImportModal = false" class="text-white/80 hover:text-white text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin_pemeringkatan.responden-bank.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <p class="text-xs text-gray-600">
                        Upload berkas Excel (.xlsx / .xls). Responden dengan email yang sudah ada akan otomatis di-skip (tidak diduplikasi).
                    </p>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Pilih File Excel <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="file" accept=".xlsx,.xls" required
                               class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-200 rounded-lg p-1.5 cursor-pointer">
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-500 space-y-1">
                        <div class="font-semibold text-gray-700">Format Kolom Header yang Dikenali:</div>
                        <div><code class="bg-gray-200 px-1 rounded">email</code>, <code class="bg-gray-200 px-1 rounded">first_name</code>, <code class="bg-gray-200 px-1 rounded">last_name</code>, <code class="bg-gray-200 px-1 rounded">institution</code>, <code class="bg-gray-200 px-1 rounded">phone</code>, <code class="bg-gray-200 px-1 rounded">category</code> (academic/employee), <code class="bg-gray-200 px-1 rounded">country</code>, <code class="bg-gray-200 px-1 rounded">job_title</code></div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button @click="openImportModal = false" type="button" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <i class="fas fa-upload mr-1"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
