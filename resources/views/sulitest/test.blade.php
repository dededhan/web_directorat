@extends('sulitest.index')

@section('content')
<div class="flex h-screen bg-gray-50" x-data="examPage()">
    <aside class="w-72 flex-shrink-0 border-r border-gray-200 bg-white flex flex-col">
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-gray-900">Navigasi Soal</h2>
            <p class="text-sm text-gray-600">Pilih nomor untuk melompat.</p>
        </div>
        <div class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-5 gap-3">
                @foreach ($all_question_ids as $index => $q_id)
                    @php
                        $number = $index + 1;
                        $isAnswered = isset($user_answers[$q_id]);
                        $isActive = ($number == $current_question_number);
                    @endphp
                    <a id="nav-link-{{ $number }}" href="{{ route('sulitest.test.show', ['session' => $examSession->id, 'questionNumber' => $number]) }}"
                       class="flex items-center justify-center h-10 w-10 rounded-md text-sm font-medium border
                              {{ $isActive ? 'bg-teal-600 text-white border-teal-600' : ($isAnswered ? 'bg-teal-100 text-teal-800 border-teal-200' : 'bg-white text-gray-700 hover:bg-gray-100') }}">
                        {{ $number }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="p-6 border-t">
            <form id="finish-test-form" action="{{ route('sulitest.test.submit', $examSession) }}" method="POST">
                @csrf
                <button type="button" @click="confirmFinish()" class="w-full rounded-md bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                    Selesaikan Ujian
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm z-10">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold leading-6 text-gray-900">{{ $examSession->exam->title }}</h1>
                        <p class="mt-1 text-sm text-gray-600">Menampilkan soal {{ $current_question_number }} dari {{ $total_questions }}</p>
                    </div>
                    <div 
                        x-data="timer({{ $examSession->end_time->timestamp * 1000 }})" 
                        class="flex items-center space-x-2 rounded-full bg-red-100 px-3 py-1.5 text-red-700">
                        <i class="fas fa-clock"></i>
                        <span x-text="time" class="font-mono text-sm font-medium">--:--</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-10">
            <div class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="px-6 py-5">
                        <p class="text-base font-medium text-gray-800 leading-relaxed">{{ $question->question_text ?? 'Gagal memuat soal.' }}</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <fieldset>
                            <legend class="sr-only">Pilihan Jawaban</legend>
                            <div class="divide-y divide-gray-200">
                                @if($question && $question->options)
                                    @foreach($question->options as $option)
                                    <label for="option-{{ $option->id }}" 
                                           class="relative flex items-start p-4 hover:bg-gray-50 cursor-pointer">
                                        <div class="min-w-0 flex-1 text-sm leading-6">
                                            <span class="select-none font-medium text-gray-900">{{ $option->text }}</span>
                                        </div>
                                        <div class="ml-3 flex h-6 items-center">
                                            <input id="option-{{ $option->id }}" name="answer" type="radio" value="{{ $option->id }}"
                                                   @if($option->id == $current_answer_id) checked @endif
                                                   @change="autosave({{ $question->id }}, {{ $option->id }}, {{ $current_question_number }})"
                                                   class="h-4 w-4 border-gray-300 text-teal-600 focus:ring-teal-600">
                                        </div>
                                    </label>
                                    @endforeach
                                @endif
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    @if ($current_question_number > 1)
                        <a href="{{ route('sulitest.test.show', ['session' => $examSession->id, 'questionNumber' => $current_question_number - 1]) }}" class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Soal Sebelumnya
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if ($current_question_number < $total_questions)
                        <a href="{{ route('sulitest.test.show', ['session' => $examSession->id, 'questionNumber' => $current_question_number + 1]) }}" class="rounded-md bg-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                            Soal Berikutnya
                        </a>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <div x-show="showConfirmModal" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 flex items-center justify-center" @keydown.escape.window="showConfirmModal = false">
        <div @click.away="showConfirmModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Selesaikan Ujian?</h3>
            <p class="mt-2 text-sm text-gray-500">Apakah Anda yakin ingin menyelesaikan ujian ini? Anda tidak akan bisa mengubah jawaban Anda lagi.</p>
            <div class="mt-4 flex justify-end space-x-3">
                <button @click="showConfirmModal = false" class="bg-white px-4 py-2 rounded-md text-sm font-medium text-gray-700 border hover:bg-gray-50">Batal</button>
                <button @click="submitForm()" class="bg-red-600 px-4 py-2 rounded-md text-sm font-medium text-white hover:bg-red-700">Ya, Selesaikan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('timer', (expiry) => ({
            expiry: expiry,
            time: "--:--",
            init() {
                this.update();
                const interval = setInterval(() => {
                    this.update();
                }, 1000);
                this.$watch('expiry', () => clearInterval(interval));
            },
            update() {
                let now = new Date().getTime();
                let distance = this.expiry - now;
                if (distance < 0) {
                    this.time = "Waktu Habis";
                    const form = document.getElementById('finish-test-form');
                    if(form) form.submit();
                    return;
                }
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                this.time = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
        }));

        Alpine.data('examPage', () => ({
            showConfirmModal: false,
            autosave(questionId, optionId, questionNumber) {
                const url = "{{ route('sulitest.test.autosave', $examSession->id) }}";
                axios.post(url, {
                    question_id: questionId,
                    option_id: optionId,
                    _token: "{{ csrf_token() }}"
                }).then(response => {
                    console.log('Answer saved!');
                    const navLink = document.getElementById(`nav-link-${questionNumber}`);
                    if (navLink) {
                        navLink.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100', 'bg-teal-600', 'text-white', 'border-teal-600');
                        navLink.classList.add('bg-teal-100', 'text-teal-800', 'border-teal-200');
                    }
                }).catch(error => {
                    console.error('Failed to save answer:', error);
                });
            },
            confirmFinish() {
                this.showConfirmModal = true;
            },
            submitForm() {
                document.getElementById('finish-test-form').submit();
            }
        }));
    });
</script>
@endsection

