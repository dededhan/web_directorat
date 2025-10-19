<div class="space-y-6">
    <!-- Soal dengan Kategori -->
    @foreach($questionBank->categories as $category)
        @if($category->questions->count() > 0)
        <div class="mb-6">
            <div class="flex items-center mb-4 pb-2 border-b-2 border-teal-500">
                <i class="fas fa-folder text-teal-600 text-lg mr-2"></i>
                <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                <span class="ml-2 text-sm text-gray-500">({{ $category->questions->count() }} soal)</span>
                <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.categories.show', $category->id) }}" class="ml-auto text-sm text-teal-600 hover:text-teal-700">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-3 pl-4">
                @foreach($category->questions as $question)
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-base text-gray-800 font-medium">{{ $question->question_text }}</p>
                            </div>
                            
                            <div class="flex items-center space-x-3 ml-4">
                                <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.edit', $question->id) }}" class="text-gray-400 hover:text-blue-600" title="Edit Soal">
                                    <i class="fas fa-pencil-alt fa-sm"></i>
                                </a>
                                
                                <form id="delete-form-{{ $question->id }}" action="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.destroy', $question->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $question->id }})" class="text-gray-400 hover:text-red-600" title="Hapus Soal">
                                        <i class="fas fa-trash-alt fa-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <ul class="mt-3 space-y-1 pl-4 text-sm">
                            @foreach($question->options as $index => $option)
                                <li class="flex items-center justify-between text-gray-700">
                                    <span>{{ chr(65 + $index) }}. {{ $option->text }}</span>
                                    <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                        {{ $option->points }} Poin
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach

    <!-- Soal Tanpa Kategori -->
    @php
        $uncategorizedQuestions = $questionBank->questions->whereNull('question_category_id');
    @endphp
    
    @if($uncategorizedQuestions->count() > 0)
    <div class="mb-6">
        <div class="flex items-center mb-4 pb-2 border-b-2 border-gray-400">
            <i class="fas fa-folder-open text-gray-600 text-lg mr-2"></i>
            <h3 class="text-lg font-semibold text-gray-900">Tanpa Kategori</h3>
            <span class="ml-2 text-sm text-gray-500">({{ $uncategorizedQuestions->count() }} soal)</span>
        </div>
        
        <div class="space-y-3 pl-4">
            @foreach($uncategorizedQuestions as $question)
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-base text-gray-800 font-medium">{{ $question->question_text }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-3 ml-4">
                            <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.edit', $question->id) }}" class="text-gray-400 hover:text-blue-600" title="Edit Soal">
                                <i class="fas fa-pencil-alt fa-sm"></i>
                            </a>
                            
                            <form id="delete-form-{{ $question->id }}" action="{{ route('admin_pemeringkatan.sulitest_question_banks.questions.destroy', $question->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $question->id }})" class="text-gray-400 hover:text-red-600" title="Hapus Soal">
                                    <i class="fas fa-trash-alt fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <ul class="mt-3 space-y-1 pl-4 text-sm">
                        @foreach($question->options as $index => $option)
                            <li class="flex items-center justify-between text-gray-700">
                                <span>{{ chr(65 + $index) }}. {{ $option->text }}</span>
                                <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                    {{ $option->points }} Poin
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($questionBank->questions->count() == 0)
    <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada soal</h3>
        <p class="mt-1 text-sm text-gray-500">Buat kategori terlebih dahulu, lalu tambahkan soal di dalam kategori.</p>
    </div>
    @endif
</div>

