<div class="space-y-4">
    @forelse($questions as $question)
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <div class="flex justify-between items-start">
                <p class="text-base text-gray-800">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                <div class="flex space-x-2 text-xs">
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 font-medium text-gray-600">Konteks: {{ $question->context ?? 'N/A' }}</span>
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-1 font-medium text-blue-700">Bobot: {{ $question->weight }}</span>
                </div>
            </div>
            <ul class="mt-4 space-y-2 pl-6">
                @foreach($question->options as $option)
                    <li class="flex items-center text-sm {{ $option->is_correct ? 'font-semibold text-teal-700' : 'text-gray-600' }}">
                        @if($option->is_correct)
                            <i class="fas fa-check-circle text-teal-500 mr-2"></i>
                        @else
                            <i class="fas fa-circle text-gray-300 mr-2" style="font-size: 0.5rem;"></i>
                        @endif
                        {{ $option->option_text }}
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
            <p class="text-sm text-gray-500">Belum ada soal di dalam bank soal ini.</p>
        </div>
    @endforelse
</div>

