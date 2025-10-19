@extends('sulitest.index')

@section('content')
    <div class="mb-6">
        <a href="{{ route('sulitest.riwayat.index') }}" 
           class="inline-flex items-center text-sm font-medium text-teal-600 hover:text-teal-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Riwayat
        </a>
    </div>

    <header class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ $exam->title }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Hasil Ujian - {{ $session->start_time->format('d F Y, H:i') }}</p>
                </div>
                <a href="{{ route('sulitest.riwayat.download', $session->id) }}" 
                   class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                    <i class="fas fa-download mr-2"></i>
                    Download DOCX
                </a>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                        <i class="fas fa-list-ol text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Soal</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalQuestions }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Skor</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalScore }} / {{ $maxPossibleScore }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100">
                        <i class="fas fa-percentage text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Persentase</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $maxPossibleScore > 0 ? round(($totalScore / $maxPossibleScore) * 100, 2) : 0 }}%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Hasil Per Kategori</h2>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Soal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Skor (Diperoleh / Maksimum)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Persentase
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($resultsByCategory as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $category['name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $category['total_questions'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $category['total_points'] }} / {{ $category['max_points'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($category['percentage'] >= 80) bg-green-100 text-green-800
                                        @elseif($category['percentage'] >= 60) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $category['percentage'] }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Ujian</h2>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Peserta</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</dd>
                </div>
                @if(Auth::user()->sulitestProfile)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIM</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->sulitestProfile->nim ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fakultas</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->sulitestProfile->fakultas->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->sulitestProfile->prodi->name ?? '-' }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Waktu Mulai</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->start_time->format('d F Y, H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Waktu Selesai</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->end_time->format('d F Y, H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Durasi Ujian</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->duration }} menit</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kategori Ujian</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->category ?? 'Umum' }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
