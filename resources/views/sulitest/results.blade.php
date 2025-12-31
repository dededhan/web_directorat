@extends('sulitest.index')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <h1 class="text-lg font-semibold leading-6 text-gray-900">Hasil Tes: {{ $session->exam->title }}</h1>
        <p class="mt-1 text-sm text-gray-600">Berikut adalah hasil dari tes yang telah Anda selesaikan.</p>
    </div>
</header>

<main class="py-10">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6 text-center">
                @php
                    $isSessionActive = \Carbon\Carbon::now()->lt($session->exam->end_time);
                @endphp
                
                @if($isSessionActive)
                    {{-- Session is still active - hide score --}}
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg class="w-16 h-16 text-teal-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-lg font-semibold text-gray-900 mb-2">Tes Selesai!</p>
                        <p class="text-sm text-gray-600">Skor akan ditampilkan setelah sesi ujian berakhir.</p>
                        <p class="text-xs text-gray-500 mt-2">Sesi berakhir: {{ $session->exam->end_time->format('d F Y, H:i') }}</p>
                    </div>
                @else
                    {{-- Session has ended - show score --}}
                    <p class="text-sm font-medium text-teal-600">Skor Akhir Anda</p>
                    <p class="mt-2 text-6xl font-bold tracking-tight text-gray-900">{{ $session->score ?? 0 }}</p>
                    {{-- <p class="mt-3 text-base text-gray-500">
                        Anda menjawab dengan benar <strong>{{ $correctAnswers }}</strong> dari <strong>{{ $totalQuestions }}</strong> soal.
                    </p> --}}
                @endif
            </div>
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                <a href="{{ route('sulitest.dashboard') }}" class="block w-full text-center rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
