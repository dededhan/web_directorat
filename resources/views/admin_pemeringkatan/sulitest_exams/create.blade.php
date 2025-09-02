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
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Buat Ujian Baru</h2>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg border">
            <form action="{{ route('admin_pemeringkatan.sulitest_exams.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Ujian</label>
                            <input type="text" name="title" id="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Contoh: Ujian Kenaikan Pangkat 2024">
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Deskripsi singkat mengenai ujian ini..."></textarea>
                        </div>
                         <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <input type="text" name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Contoh: Psikotes, Tes Akademik">
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                <input type="datetime-local" name="start_time" id="start_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                <input type="datetime-local" name="end_time" id="end_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Durasi Pengerjaan (Menit)</label>
                            <input type="number" name="duration" id="duration" required min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Contoh: 90">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                             <div>
                                <label for="question_bank_id" class="block text-sm font-medium text-gray-700">Pilih Bank Soal</label>
                                <select name="question_bank_id" id="question_bank_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                    <option value="" disabled selected>-- Pilih Paket Soal --</option>
                                    @foreach($questionBanks as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div>
                                <label for="number_of_questions" class="block text-sm font-medium text-gray-700">Jumlah Soal (Acak)</label>
                                <input type="number" name="number_of_questions" id="number_of_questions" required min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Contoh: 50">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Peserta Ujian</h3>
                    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-yellow-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                Fitur untuk menetapkan peserta (assign users) akan dikembangkan pada tahap selanjutnya.
                                </p>
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
                        Simpan Ujian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
