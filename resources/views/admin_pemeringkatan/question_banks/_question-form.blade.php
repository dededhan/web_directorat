@php
    // cuz im lazy af, i seperate
    $isEdit = isset($question);
    $actionUrl = $isEdit 
        ? route('admin_pemeringkatan.question_banks.questions.update', $question->id) 
        : route('admin_pemeringkatan.question_banks.questions.store', $questionBank->id);
@endphp

<div class="bg-white p-6 rounded-lg shadow-lg border">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ $isEdit ? 'Formulir Edit Soal' : 'Formulir Tambah Soal Baru' }}</h3>
    <form action="{{ $actionUrl }}" method="POST">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif
        <div class="space-y-6">
            <div>
                <label for="question_text" class="block text-sm font-medium text-gray-700">Teks Pertanyaan</label>
                <textarea id="question_text" name="question_text" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Tuliskan pertanyaan di sini...">{{ old('question_text', $question->question_text ?? '') }}</textarea>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Opsi Jawaban & Poin (Bobot)</label>
                
                @for ($i = 0; $i < 5; $i++)
                <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-md">
                    <span class="font-semibold text-gray-500">{{ chr(65 + $i) }}.</span>
                    
                    @if($isEdit && isset($question->options[$i]))
                        <input type="hidden" name="options[{{ $i }}][id]" value="{{ $question->options[$i]->id }}">
                    @endif

                    <div class="flex-grow">
                        <input type="text" name="options[{{ $i }}][text]" placeholder="Teks Opsi {{ chr(65 + $i) }}" required 
                               value="{{ old('options.'.$i.'.text', $question->options[$i]->text ?? '') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                    </div>
                    
                    <div class="w-40">
                        <select name="options[{{ $i }}][points]" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            <option value="" disabled {{ !isset($question->options[$i]) ? 'selected' : '' }}>Pilih Poin</option>
                            @for($p = 1; $p <= 5; $p++)
                                <option value="{{ $p }}" @if(old('options.'.$i.'.points', $question->options[$i]->points ?? '') == $p) selected @endif>{{ $p }} Poin</option>
                            @endfor
                        </select>
                    </div>
                </div>
                @endfor
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200 mt-6">
                <a href="{{ route('admin_pemeringkatan.question_banks.show', $isEdit ? $question->question_bank_id : $questionBank->id) }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 mr-3">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEdit ? 'Update Soal' : 'Simpan Soal' }}
                </button>
            </div>
        </div>
    </form>
</div>

