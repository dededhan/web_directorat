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
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.hasil.show', $session->exam_id) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $session->exam->title }}</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-2">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Detail Hasil: {{ $session->user->name }}</h2>
        </div>
    </div>

    <!-- Info Peserta -->
    <div class="mt-6 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Peserta</h3>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">NIM</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->user->sulitestProfile?->nim ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Fakultas</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->user->sulitestProfile?->fakultas->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $session->user->sulitestProfile?->prodi->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Poin</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center rounded-md bg-teal-50 px-3 py-1 text-lg font-semibold text-teal-700 ring-1 ring-inset ring-teal-600/20">
                            {{ $totalScore }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Breakdown per Kategori -->
    <div class="mt-6 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Breakdown per Kategori</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($categoryScores as $categoryId => $category)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-900">{{ $category['name'] }}</h4>
                        <span class="text-xs text-gray-500">{{ $category['question_count'] }} soal</span>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-teal-600">{{ $category['total_points'] }}</div>
                        <div class="text-xs text-gray-500">dari {{ $category['max_possible'] }} poin</div>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-center">
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-600 h-2 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $category['percentage'] }}%</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detail Jawaban per Kategori -->
    <div class="mt-6">
        @foreach($answersByCategory as $categoryId => $answers)
        @php
            $categoryName = $answers->first()->question->category->name ?? 'Tanpa Kategori';
        @endphp
        <div class="bg-white shadow sm:rounded-lg mb-4">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-folder text-teal-600 mr-2"></i>{{ $categoryName }}
                </h3>
                <div class="space-y-4">
                    @foreach($answers as $index => $answer)
                    <div class="border-l-4 border-teal-500 pl-4 py-2">
                        <p class="text-sm font-medium text-gray-900">{{ $loop->iteration }}. {{ $answer->question->question_text }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                <span class="text-sm text-gray-600">Jawaban: </span>
                                <span class="text-sm font-medium text-gray-900">{{ $answer->option->text }}</span>
                            </div>
                            <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                {{ $answer->points }} poin
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
