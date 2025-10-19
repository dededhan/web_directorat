@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                    <a href="{{ route('admin_pemeringkatan.sulitest_exams.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Manajemen Ujian</a>
                </li>
            </ol>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Edit Ujian: {{ $exam->title }}</h2>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg border">
            <form action="{{ route('admin_pemeringkatan.sulitest_exams.update', $exam) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Ujian</label>
                            <input type="text" name="title" id="title" required value="{{ old('title', $exam->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">{{ old('description', $exam->description) }}</textarea>
                        </div>
                         <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <input type="text" name="category" id="category" value="{{ old('category', $exam->category) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                <input type="datetime-local" name="start_time" id="start_time" required value="{{ old('start_time', $exam->start_time->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                <input type="datetime-local" name="end_time" id="end_time" required value="{{ old('end_time', $exam->end_time->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Durasi Pengerjaan (Menit)</label>
                            <input type="number" name="duration" id="duration" required min="1" value="{{ old('duration', $exam->duration) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                             <div>
                                <label for="question_bank_id" class="block text-sm font-medium text-gray-700">Pilih Bank Soal</label>
                                <select name="question_bank_id" id="question_bank_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                    @foreach($questionBanks as $id => $name)
                                        <option value="{{ $id }}" {{ $exam->question_bank_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div>
                                <label for="number_of_questions" class="block text-sm font-medium text-gray-700">Jumlah Soal (Acak)</label>
                                <input type="number" name="number_of_questions" id="number_of_questions" required min="1" value="{{ old('number_of_questions', $exam->number_of_questions) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('admin_pemeringkatan.sulitest_exams.index') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 mr-3">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                        <i class="fas fa-save mr-2"></i>
                        Update Ujian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
