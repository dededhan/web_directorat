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
                <p class="text-sm font-medium text-teal-600">Skor Akhir Anda</p>
                <p class="mt-2 text-6xl font-bold tracking-tight text-gray-900">{{ $session->score ?? 0 }}</p>
                {{-- <p class="mt-3 text-base text-gray-500">
                    Anda menjawab dengan benar <strong>{{ $correctAnswers }}</strong> dari <strong>{{ $totalQuestions }}</strong> soal.
                </p> --}}
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
