@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Hasil & Analitik SULITEST</h1>
            <p class="mt-1 text-sm text-gray-600">Lihat hasil ujian dan analitik per ujian.</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($exams as $exam)
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clipboard-list fa-2x text-teal-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ $exam->title }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $exam->exam_sessions_count }}</div>
                                <div class="ml-2 text-sm text-gray-500">Peserta Selesai</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm flex justify-between items-center">
                    <a href="{{ route('admin_pemeringkatan.hasil.show', $exam->id) }}" class="font-medium text-teal-600 hover:text-teal-900">
                        Lihat Hasil <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                    <a href="{{ route('admin_pemeringkatan.hasil.analytics', $exam->id) }}" class="font-medium text-blue-600 hover:text-blue-900">
                        <i class="fas fa-chart-bar mr-1"></i> Analitik
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <i class="fas fa-clipboard-list fa-3x text-gray-400"></i>
            <p class="mt-4 text-sm text-gray-500">Belum ada ujian yang tersedia</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
