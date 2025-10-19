@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.hasil.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Hasil & Analitik</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Hasil Ujian: {{ $exam->title }}</h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('admin_pemeringkatan.hasil.analytics', $exam->id) }}" class="inline-flex items-center px-4 py-2 border border-teal-300 rounded-md shadow-sm text-sm font-medium text-teal-700 bg-white hover:bg-teal-50">
                    <i class="fas fa-chart-bar mr-2"></i>Analitik
                </a>
                {{-- <a href="{{ route('admin_pemeringkatan.hasil.export', $exam->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-download mr-2"></i>Export Excel
                </a> --}}
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nama</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">NIM</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fakultas</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Prodi</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Total Poin</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Waktu Mulai</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Durasi</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($results as $result)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $result['user']->name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{ $result['user']->sulitestProfile?->nim ?? '-' }}
                            </td>
                            <td class="px-3 py-4 text-sm">
                                @if($result['user']->sulitestProfile?->fakultas)
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        {{ $result['user']->sulitestProfile->fakultas->abbreviation }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $result['user']->sulitestProfile?->prodi->name ?? '-' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                <span class="inline-flex items-center rounded-md bg-teal-50 px-3 py-1 text-sm font-semibold text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                    {{ $result['total_score'] }} / {{ $result['max_possible_score'] }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{ $result['session']->start_time ? $result['session']->start_time->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                @if($result['duration'])
                                    {{ $result['duration'] }} menit
                                @else
                                    -
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <a href="{{ route('admin_pemeringkatan.hasil.detail', $result['session']->id) }}" class="text-teal-600 hover:text-teal-900">
                                    Detail<span class="sr-only">, {{ $result['user']->name }}</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-sm text-gray-500">
                                <i class="fas fa-inbox fa-2x mb-2 text-gray-400"></i>
                                <p>Belum ada peserta yang menyelesaikan ujian ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
