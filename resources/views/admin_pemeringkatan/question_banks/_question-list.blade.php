<div class="space-y-4">
    @forelse($questionBank->questions as $question)
        <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
            <div class="flex justify-between items-start">
                <p class="text-base text-gray-800 font-medium">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin_pemeringkatan.question_banks.questions.edit', $question->id) }}" class="text-gray-400 hover:text-blue-600" title="Edit Soal">
                        <i class="fas fa-pencil-alt fa-sm"></i>
                    </a>
                    
                    <form id="delete-form-{{ $question->id }}" action="{{ route('admin_pemeringkatan.question_banks.questions.destroy', $question->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $question->id }})" class="text-gray-400 hover:text-red-600" title="Hapus Soal">
                            <i class="fas fa-trash-alt fa-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <ul class="mt-4 space-y-2 pl-6">
                @foreach($question->options as $index => $option)
                    <li class="flex items-center justify-between text-sm text-gray-700">
                        <span>{{ chr(65 + $index) }}. {{ $option->text }}</span>
                        <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/20">
                            {{ $option->points }} Poin
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada soal</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai tambahkan soal baru melalui tab "Tambah Soal Baru".</p>
        </div>
    @endforelse
</div>

