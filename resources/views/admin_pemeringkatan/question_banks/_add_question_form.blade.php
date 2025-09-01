<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Formulir Tambah Soal Baru</h3>
    <form action="#" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="question_text" class="block text-sm font-medium text-gray-700">Teks Soal</label>
                <textarea id="question_text" name="question_text" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="context" class="block text-sm font-medium text-gray-700">Konteks (Opsional)</label>
                    <input type="text" name="context" id="context" placeholder="Contoh: Logika Penalaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                </div>
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700">Bobot / Nilai (1-5)</label>
                    <select name="weight" id="weight" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        <option value="1">1 - Sangat Mudah</option>
                        <option value="2">2 - Mudah</option>
                        <option value="3" selected>3 - Sedang</option>
                        <option value="4">4 - Sulit</option>
                        <option value="5">5 - Sangat Sulit</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Pilihan Jawaban (Pilih jawaban yang benar)</label>
                @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center space-x-3">
                    <input type="radio" name="correct_option" value="{{ $i }}" id="correct_option_{{ $i }}" required class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                    <input type="text" name="options[]" id="option_{{ $i }}" placeholder="Pilihan Jawaban {{ $i + 1 }}" required class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                </div>
                @endfor
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                    Simpan Soal
                </button>
            </div>
        </div>
    </form>
</div>

