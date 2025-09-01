@extends('sulitest.index')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-4xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold leading-6 text-gray-900">{{ $test_title }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Soal {{ $current_question_number }} dari {{ $total_questions }}</p>
                </div>
                <div class="flex items-center space-x-2 rounded-full bg-red-100 px-3 py-1.5 text-red-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span id="timer" class="font-mono text-sm font-medium">--:--</span>
                </div>
            </div>
        </div>
    </header>

    <main class="py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form id="test-form" action="{{ route('sulitest.test.submit', ['session' => $session_id]) }}" method="POST">
                @csrf
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="px-6 py-5">
                        <p class="text-base font-medium text-gray-800">{{ $question['question'] }}</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <fieldset>
                            <legend class="sr-only">Pilihan Jawaban</legend>
                            <div class="divide-y divide-gray-200">
                                @foreach($question['options'] as $index => $option)
                                <div class="relative flex items-start p-4 hover:bg-gray-50">
                                    <div class="min-w-0 flex-1 text-sm leading-6">
                                        <label for="option-{{ $index }}" class="select-none font-medium text-gray-900">{{ $option }}</label>
                                    </div>
                                    <div class="ml-3 flex h-6 items-center">
                                        <input id="option-{{ $index }}" name="answer" type="radio" value="{{ $option }}" class="h-4 w-4 border-gray-300 text-teal-600 focus:ring-teal-600" required>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="rounded-md bg-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                        @if($current_question_number == $total_questions)
                            Selesaikan Tes
                        @else
                            Soal Berikutnya
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timerElement = document.getElementById('timer');
        const testForm = document.getElementById('test-form');
        let timeRemaining = {{ $duration * 60 }}; // Konversi menit ke detik

        const timerInterval = setInterval(() => {
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                timerElement.textContent = 'Waktu Habis';
                // Otomatis submit form saat waktu habis
                testForm.submit();
                return;
            }

            timeRemaining--;

            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;

            timerElement.textContent = 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');

        }, 1000);
    });
</script>
@endsection

