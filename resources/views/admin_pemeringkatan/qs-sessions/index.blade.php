@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-bullhorn text-teal-600"></i>
                QS Campaign Sessions
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola sesi kampanye QS World University Ranking & pantau status consent responden secara real-time.
            </p>
        </div>
        @if(Auth::user()->isDirectorateAdmin())
        <div>
            <a href="{{ route('admin_pemeringkatan.qs-sessions.create') }}" 
               class="inline-flex items-center px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium text-sm rounded-lg shadow-sm hover:shadow transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>
                Buat Sesi Baru
            </a>
        </div>
        @endif
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

    {{-- Filters & Search --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin_pemeringkatan.qs-sessions.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama sesi..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            <div class="w-full md:w-48">
                <select name="status" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    @if(Auth::user()->isDirectorateAdmin())
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    @endif
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-sm font-medium transition flex items-center">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Session Cards / List --}}
    @if($sessions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($sessions as $session)
                @php
                    $total = $session->total_count;
                    $agreed = $session->agreed_count;
                    $pending = $session->pending_count;
                    $emailed = $session->email_sent_count;
                    $percent = $session->consent_rate;
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/80 hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                    <div class="p-5">
                        {{-- Top row: Status & Dates --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-1.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($session->status === 'active') bg-emerald-100 text-emerald-800 border border-emerald-200
                                    @elseif($session->status === 'draft') bg-amber-100 text-amber-800 border border-amber-200
                                    @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                        @if($session->status === 'active') bg-emerald-500 animate-pulse
                                        @elseif($session->status === 'draft') bg-amber-500
                                        @else bg-gray-400 @endif"></span>
                                    {{ ucfirst($session->status) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium
                                    @if($session->isFormBased()) bg-purple-50 text-purple-700 border border-purple-200
                                    @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                    <i class="fas @if($session->isFormBased()) fa-file-signature text-purple-500 @else fa-mouse-pointer text-blue-500 @endif mr-1"></i>
                                    {{ $session->isFormBased() ? 'Form' : '1-Click' }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-400">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $session->start_date ? $session->start_date->format('d M Y') : '—' }}
                                @if($session->end_date)
                                    s/d {{ $session->end_date->format('d M Y') }}
                                @endif
                            </span>
                        </div>

                        {{-- Name & Description --}}
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-teal-600 transition-colors line-clamp-1 mb-1">
                            <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $session) }}">
                                {{ $session->name }}
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500 line-clamp-2 min-h-[32px] mb-4">
                            {{ $session->description ?: 'Tidak ada deskripsi.' }}
                        </p>

                        {{-- Stats Progress Bar --}}
                        <div class="space-y-2 pt-2 border-t border-gray-100">
                            <div class="flex justify-between text-xs font-medium">
                                <span class="text-gray-600">Consent Rate</span>
                                <span class="text-teal-700 font-bold">{{ $percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-teal-500 to-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 pt-2 text-center text-xs">
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <div class="text-gray-400 font-medium">Total</div>
                                    <div class="text-sm font-bold text-gray-800">{{ number_format($total) }}</div>
                                </div>
                                <div class="bg-emerald-50 rounded-lg p-2">
                                    <div class="text-emerald-600 font-medium">Agreed</div>
                                    <div class="text-sm font-bold text-emerald-800">{{ number_format($agreed) }}</div>
                                </div>
                                <div class="bg-amber-50 rounded-lg p-2">
                                    <div class="text-amber-600 font-medium">Pending</div>
                                    <div class="text-sm font-bold text-amber-800">{{ number_format($pending) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-5 py-3 bg-gray-50/70 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="text-gray-400">
                            <i class="fas fa-envelope mr-1"></i> {{ $emailed }} terkirim
                        </span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin_pemeringkatan.qs-sessions.show', $session) }}" 
                               class="inline-flex items-center px-2.5 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-700 font-medium rounded-md transition">
                                <i class="fas fa-users-cog mr-1"></i> Kelola
                            </a>
                            @if(Auth::user()->isDirectorateAdmin())
                            <a href="{{ route('admin_pemeringkatan.qs-sessions.edit', $session) }}" 
                               class="p-1.5 text-gray-500 hover:text-gray-700 rounded hover:bg-gray-200 transition" title="Edit Sesi">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin_pemeringkatan.qs-sessions.destroy', $session) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 rounded hover:bg-red-50 transition" title="Hapus Sesi">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $sessions->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Belum ada Sesi Campaign</h3>
            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                Mulai dengan membuat sesi kampanye baru untuk mengelompokkan responden dan memantau persetujuan (consent) QS.
            </p>
            @if(Auth::user()->isDirectorateAdmin())
            <div class="mt-6">
                <a href="{{ route('admin_pemeringkatan.qs-sessions.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg shadow transition">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Sesi Pertama
                </a>
            </div>
            @endif
        </div>
    @endif
</div>
@endsection
