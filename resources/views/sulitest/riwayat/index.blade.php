@extends('sulitest.index')

@section('content')
    <header class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900">Riwayat Ujian</h1>
            <p class="mt-1 text-sm text-gray-600">Berikut adalah daftar ujian yang telah Anda selesaikan.</p>
        </div>
    </header>

    @if(session('error'))
        <div class="mb-6 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <main>
        <div class="space-y-4">
            @forelse ($sessions as $session)
                @php
                    $exam = $session->exam;
                    $canAccess = now()->gte($exam->end_time);
                @endphp
                <div class="overflow-hidden rounded-lg bg-white shadow hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100">
                                            <i class="fas fa-file-alt text-teal-600 text-xl"></i>
                                        </span>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h3>
                                        <p class="text-sm text-gray-500">{{ $exam->category ?? 'Umum' }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                        <span>{{ $session->start_time->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                                        <span>Durasi: {{ $exam->duration }} menit</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-chart-line mr-2 text-gray-400"></i>
                                        <span>Skor: <strong>{{ $session->score ?? 0 }}</strong></span>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-6 flex flex-col space-y-2">
                                @if($canAccess)
                                    <a href="{{ route('sulitest.riwayat.detail', $session->id) }}" 
                                       class="inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </a>
                                    <a href="{{ route('sulitest.riwayat.download', $session->id) }}" 
                                       class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                        <i class="fas fa-download mr-2"></i>
                                        Download DOCX
                                    </a>
                                @else
                                    <div class="inline-flex items-center rounded-md bg-yellow-50 px-4 py-2 text-sm font-medium text-yellow-800 border border-yellow-200">
                                        <i class="fas fa-lock mr-2"></i>
                                        Hasil tersedia setelah {{ $exam->end_time->format('d M Y, H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <i class="fas fa-inbox text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-gray-500 mb-6">Anda belum menyelesaikan ujian apapun.</p>
                    <a href="{{ route('sulitest.dashboard') }}" 
                       class="inline-flex items-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            @endforelse
        </div>
    </main>
@endsection
