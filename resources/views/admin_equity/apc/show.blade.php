@extends('admin_equity.index')

@php
if (!function_exists('getStatusInfoAdmin')) {
    function getStatusInfoAdmin($status) {
        switch ($status) {
            case 'diajukan': return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
            case 'verifikasi': return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Verifikasi'];
            case 'disetujui': return ['color' => 'green', 'icon' => 'bx-check-circle', 'text' => 'Disetujui'];
            case 'ditolak': return ['color' => 'red', 'icon' => 'bx-x-circle', 'text' => 'Ditolak'];
            default: return ['color' => 'gray', 'icon' => 'bx-question-mark', 'text' => 'Unknown'];
        }
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.index') }}" class="hover:text-teal-600">Manajemen Sesi APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Sesi</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $session->nama_sesi }}</h1>
                <p class="mt-2 text-gray-600">Kelola semua pengajuan jurnal yang masuk dalam sesi ini.</p>
            </div>
        </header>

        {{-- Daftar Pengajuan --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 bg-gray-50 border-b">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class='bx bxs-file-doc mr-3 text-teal-600'></i>
                    Daftar Pengajuan Jurnal
                </h2>
                
                <form method="GET" action="{{ route('admin_equity.apc.show', $session->id) }}" class="mt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <div class="sm:col-span-2 md:col-span-2">
                            <label for="search" class="sr-only">Cari</label>
                            <input type="text" name="search" id="search" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Cari nama dosen, judul..." value="{{ request('search') }}">
                        </div>
                        <div>
                            <label for="status" class="sr-only">Status</label>
                            <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">Semua Status</option>
                                <option value="diajukan" @if(request('status') == 'diajukan') selected @endif>Diajukan</option>
                                <option value="verifikasi" @if(request('status') == 'verifikasi') selected @endif>Verifikasi</option>
                                <option value="disetujui" @if(request('status') == 'disetujui') selected @endif>Disetujui</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full flex justify-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors">Filter</button>
                            <a href="{{ route('admin_equity.apc.show', $session->id) }}" class="p-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" title="Reset Filter">
                                <i class='bx bx-refresh text-xl'></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Jurnal & Artikel</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dosen Pengusul</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($submissions as $submission)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $submission->nama_jurnal_q1 }}</div>
                                <div class="text-sm text-gray-500 mt-1">{{ $submission->judul_artikel }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $submission->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center">
                                @php $statusInfo = getStatusInfoAdmin($submission->status); @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{$statusInfo['color']}}-100 text-{{$statusInfo['color']}}-800">
                                    <i class='bx {{$statusInfo['icon']}} mr-1.5 text-sm'></i>
                                    {{ $statusInfo['text'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-center">
                                <a href="{{ route('admin_equity.apc.submission.show', $submission->id) }}" class="inline-flex items-center px-3 py-1.5 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors text-xs">
                                    <i class='bx bx-search-alt mr-1'></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-16">
                                <i class='bx bx-folder-open text-5xl text-gray-300'></i>
                                <h3 class="font-semibold text-lg text-gray-700 mt-4">Data Tidak Ditemukan</h3>
                                <p class="text-gray-500 text-sm mt-1">Tidak ada proposal yang cocok dengan kriteria filter Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($submissions->hasPages())
            <div class="p-4 bg-gray-50 border-t">
                {{ $submissions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

