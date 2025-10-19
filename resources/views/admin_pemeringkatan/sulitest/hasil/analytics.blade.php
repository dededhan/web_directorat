@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li><a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a></li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.hasil.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Hasil & Analitik</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-2">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Analitik: {{ $exam->title }}</h2>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users fa-2x text-teal-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Peserta</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $analytics['total_participants'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line fa-2x text-blue-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rata-rata Skor</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $analytics['avg_score'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Per Kategori Soal -->
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Analitik per Kategori Soal</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Kategori</th>
                            <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Total Peserta</th>
                            <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Rata-rata Skor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($categoryAnalytics as $catId => $catData)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $catData['name'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ $catData['total_participants'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                    {{ $catData['avg_score'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Per Fakultas -->
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Analitik per Fakultas</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Fakultas</th>
                            <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Jumlah Peserta</th>
                            <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Rata-rata Skor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($analytics['by_fakultas'] as $fakultasId => $data)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $data['name'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ $data['count'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $data['avg_score'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Per Prodi (Top 10) -->
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Analitik per Program Studi (Top 10)</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Program Studi</th>
                            <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Jumlah Peserta</th>
                            <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Rata-rata Skor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($analytics['by_prodi']->sortByDesc('count')->take(10) as $prodiId => $data)
                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $data['name'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ $data['count'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">
                                    {{ $data['avg_score'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
