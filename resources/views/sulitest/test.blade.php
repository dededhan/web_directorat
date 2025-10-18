@extends('sulitest.index')

@section('content')
<div class="flex h-screen bg-gray-50" x-data="examPage()">

    <aside class="w-72 flex-shrink-0 border-r border-gray-200 bg-white flex flex-col">
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-gray-900">Navigasi Soal</h2>
            <p class="text-sm text-gray-600">Pilih nomor untuk melompat.</p>
            
            <div class="mt-3">
                <div class="text-sm text-gray-700 font-medium">
                    <span x-text="answeredCount"></span> dari {{ $total_questions }} terjawab
                </div>
            </div>

            <div class="mt-3 space-y-2 text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-teal-600 rounded"></div>
                    <span>Soal Aktif</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-teal-100 rounded border border-teal-200"></div>
                    <span>Sudah Dijawab</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-yellow-100 rounded border border-yellow-400 relative">
                        <i class="fas fa-flag absolute inset-0 flex items-center justify-center text-yellow-600 text-[8px]"></i>
                    </div>
                    <span>Ragu-ragu</span>
                </div>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-5 gap-3">
                @foreach ($all_question_ids as $index => $q_id)
                    @php
                        $number = $index + 1;
                        $isAnswered = isset($user_answers[$q_id]) && $user_answers[$q_id]->option_id !== null;
                        $isFlagged = in_array($q_id, $flagged_question_ids);
                        $isActive = ($number == $current_question_number);
                    @endphp
                    <a id="nav-link-{{ $number }}" 
                       data-question-id="{{ $q_id }}"
                       href="{{ route('sulitest.test.show', ['session' => $examSession->id, 'questionNumber' => $number]) }}"
                       class="relative flex items-center justify-center h-10 w-10 rounded-md text-sm font-medium border
                              {{ $isActive ? 'bg-teal-600 text-white border-teal-600' : ($isFlagged ? 'bg-yellow-100 text-yellow-800 border-yellow-400' : ($isAnswered ? 'bg-teal-100 text-teal-800 border-teal-200' : 'bg-white text-gray-700 hover:bg-gray-100')) }}">
                        {{ $number }}
                        @if($isFlagged)
                            <i class="fas fa-flag absolute top-0 right-0 text-yellow-600 text-[8px]"></i>
                        @endif
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
                        <div class="flex items-center gap-4 mt-1">
                            <p class="text-sm text-gray-600">Menampilkan soal {{ $current_question_number }} dari {{ $total_questions }}</p>
                            <span x-show="savingStatus" x-text="savingStatus" 
                                  :class="savingStatus === 'Tersimpan ✓' ? 'text-green-600' : (savingStatus === 'Gagal ✗' ? 'text-red-600' : 'text-gray-500')"
                                  class="text-xs font-medium"></span>
                        </div>
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

        <main class="flex-1 overflow-y-auto p-10 relative">
            <div class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-lg bg-white shadow relative">
                    <div id="watermark" class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-5 text-4xl font-bold text-gray-500 select-none z-10" style="transform: rotate(-45deg);">
                        {{ Auth::user()->name }}<br>{{ Auth::user()->email }}
                    </div>
                    
                    <div class="px-6 py-5 relative z-20">
                        <p class="text-base font-medium text-gray-800 leading-relaxed select-none">{{ $question->question_text ?? 'Gagal memuat soal.' }}</p>
                    </div>
                    <div class="border-t border-gray-200 relative z-20">
                        <fieldset>
                            <legend class="sr-only">Pilihan Jawaban</legend>
                            <div class="divide-y divide-gray-200">
                                @if($question && $question->options)
                                    @foreach($question->options as $option)
                                    <label for="option-{{ $option->id }}" 
                                           class="relative flex items-start p-4 hover:bg-gray-50 cursor-pointer select-none">
                                        <div class="min-w-0 flex-1 text-sm leading-6">
                                            <span class="font-medium text-gray-900">{{ $option->text }}</span>
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

                <div class="mt-6 flex justify-center">
                    <button @click="toggleFlag()" 
                            :class="isFlagged ? 'bg-yellow-500 text-white hover:bg-yellow-600 border-yellow-600' : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'"
                            class="flex items-center gap-2 px-6 py-3 rounded-md text-sm font-semibold border shadow-sm transition-colors">
                        <i class="fas fa-flag"></i>
                        <span x-text="isFlagged ? 'Ragu-ragu' : 'Tandai Ragu-ragu'"></span>
                    </button>
                </div>

                <div class="mt-6 flex justify-between items-center">
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


    <div x-show="showTabWarning" x-cloak class="fixed inset-0 bg-red-500 bg-opacity-75 transition-opacity z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-3xl mr-3"></i>
                <h3 class="text-lg font-bold text-gray-900">PERINGATAN!</h3>
            </div>
            <p class="text-sm text-gray-700 mb-2">
                Anda meninggalkan halaman ujian (<strong class="text-red-600" x-text="tabSwitchCount + '/' + maxTabSwitches"></strong>).
            </p>
            <p class="text-sm text-red-600 font-semibold">
                Aktivitas ini telah dicatat. Jika dilakukan lagi, ujian akan OTOMATIS diselesaikan!
            </p>
            <div class="mt-4">
                <button @click="showTabWarning = false" class="w-full bg-red-600 px-4 py-2 rounded-md text-sm font-medium text-white hover:bg-red-700">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    let isInternalNavigation = false;

 
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('a[href*="test-session"]').forEach(link => {
            link.addEventListener('click', () => {
                isInternalNavigation = true;
            });
        });
    });

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
                    isInternalNavigation = true; 
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
            showTabWarning: false,
            savingStatus: '',
            tabSwitchCount: 0,
            maxTabSwitches: 3,
            answeredCount: {{ $user_answers->where('option_id', '!=', null)->count() }},
            isFlagged: {{ $current_is_flagged ? 'true' : 'false' }},
            currentQuestionId: {{ $question->id }},
            
            init() {
                this.initAntiCheat();
                this.initWatermarkRotation();
            },
            
            initAntiCheat() {
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        this.tabSwitchCount++;
                        this.showTabWarning = true;
                        
                        this.logActivity('tab_switch', {
                            count: this.tabSwitchCount,
                            timestamp: new Date().toISOString()
                        });
                        
                        if (this.tabSwitchCount >= this.maxTabSwitches) {
                            setTimeout(() => {
                                this.logActivity('auto_submit_tab_violation', { count: this.tabSwitchCount });
                                isInternalNavigation = true;
                                document.getElementById('finish-test-form').submit();
                            }, 2000);
                        }
                    }
                });
                

                document.addEventListener('copy', (e) => {
                    e.preventDefault();
                    this.logActivity('copy_attempt', {});
                    return false;
                });
                

                document.addEventListener('contextmenu', (e) => {
                    e.preventDefault();
                    this.logActivity('right_click_attempt', {});
                    return false;
                });
                

                document.addEventListener('selectstart', (e) => {
                    if (e.target.closest('.select-none')) {
                        e.preventDefault();
                        return false;
                    }
                });
                

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'F12' || 
                        (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
                        (e.ctrlKey && e.key === 'U')) {
                        e.preventDefault();
                        this.logActivity('devtools_attempt', { key: e.key });
                        return false;
                    }
                    

                    if (e.key === 'ArrowLeft' && {{ $current_question_number }} > 1) {
                        isInternalNavigation = true;
                        window.location.href = '{{ route("sulitest.test.show", ["session" => $examSession->id, "questionNumber" => $current_question_number - 1]) }}';
                    }
                    if (e.key === 'ArrowRight' && {{ $current_question_number }} < {{ $total_questions }}) {
                        isInternalNavigation = true;
                        window.location.href = '{{ route("sulitest.test.show", ["session" => $examSession->id, "questionNumber" => $current_question_number + 1]) }}';
                    }
                });
                

                window.addEventListener('beforeunload', (e) => {
                    if (!isInternalNavigation) {
                        e.preventDefault();
                        e.returnValue = 'Ujian sedang berlangsung. Yakin ingin keluar?';
                    }
                });
            },
            
            initWatermarkRotation() {

                setInterval(() => {
                    const watermark = document.getElementById('watermark');
                    if (watermark) {
                        watermark.style.top = (Math.random() * 60 + 20) + '%';
                        watermark.style.left = (Math.random() * 60 + 20) + '%';
                    }
                }, 5000);
            },
            
            toggleFlag() {
                this.isFlagged = !this.isFlagged;
                const url = "{{ route('sulitest.test.toggleFlag', $examSession->id) }}";
                
                axios.post(url, {
                    question_id: this.currentQuestionId,
                    is_flagged: this.isFlagged,
                    _token: "{{ csrf_token() }}"
                }).then(response => {
                    console.log('Flag toggled');
                    

                    const navLink = document.querySelector(`a[data-question-id="${this.currentQuestionId}"]`);
                    if (navLink) {
                        if (this.isFlagged) {
                            navLink.classList.remove('bg-teal-100', 'text-teal-800', 'border-teal-200');
                            navLink.classList.add('bg-yellow-100', 'text-yellow-800', 'border-yellow-400');

                            if (!navLink.querySelector('.fa-flag')) {
                                const flagIcon = document.createElement('i');
                                flagIcon.className = 'fas fa-flag absolute top-0 right-0 text-yellow-600 text-[8px]';
                                navLink.appendChild(flagIcon);
                            }
                        } else {
                            navLink.classList.remove('bg-yellow-100', 'text-yellow-800', 'border-yellow-400');
                            navLink.classList.add('bg-teal-100', 'text-teal-800', 'border-teal-200');

                            const flagIcon = navLink.querySelector('.fa-flag');
                            if (flagIcon) flagIcon.remove();
                        }
                    }
                }).catch(error => {
                    console.error('Failed to toggle flag:', error);
 
                    this.isFlagged = !this.isFlagged;
                });
            },
            
            autosave(questionId, optionId, questionNumber) {
                this.savingStatus = 'Menyimpan...';
                const url = "{{ route('sulitest.test.autosave', $examSession->id) }}";
                
                axios.post(url, {
                    question_id: questionId,
                    option_id: optionId,
                    _token: "{{ csrf_token() }}"
                }).then(response => {
                    this.savingStatus = 'Tersimpan ✓';
                    console.log('Answer saved!');
                    

                    const navLink = document.querySelector(`a[data-question-id="${questionId}"]`);
                    if (navLink && !navLink.classList.contains('bg-yellow-100')) {
                        navLink.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100', 'bg-teal-600', 'text-white', 'border-teal-600');
                        navLink.classList.add('bg-teal-100', 'text-teal-800', 'border-teal-200');
                    }
                    

                    this.answeredCount = document.querySelectorAll('[data-question-id]').length - document.querySelectorAll('.bg-white[data-question-id]').length;
                    

                    setTimeout(() => this.savingStatus = '', 2000);
                    

                    this.logActivity('answer_change', { question_id: questionId, option_id: optionId });
                }).catch(error => {
                    this.savingStatus = 'Gagal ✗';
                    console.error('Failed to save answer:', error);
                    

                    setTimeout(() => {
                        this.autosave(questionId, optionId, questionNumber);
                    }, 3000);
                });
            },
            
            logActivity(activityType, metadata) {
                const url = "{{ route('sulitest.test.logActivity', $examSession->id) }}";
                axios.post(url, {
                    activity_type: activityType,
                    metadata: metadata,
                    _token: "{{ csrf_token() }}"
                }).catch(error => {
                    console.error('Failed to log activity:', error);
                });
            },
            
            confirmFinish() {
                this.showConfirmModal = true;
            },
            
            submitForm() {
                this.logActivity('manual_submit', {});
                isInternalNavigation = true;
                document.getElementById('finish-test-form').submit();
            }
        }));
    });
</script>

<style>
    .select-none {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
</style>
@endsection
