@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Ujian SULITEST</h1>
            <p class="mt-1 text-sm text-gray-600">Buat, kelola, dan pantau semua sesi ujian di sini.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin_pemeringkatan.sulitest_exams.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                <i class="fas fa-plus mr-2"></i>
                Buat Ujian Baru
            </a>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Judul Ujian</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Durasi</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jadwal</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Paket Soal</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($exams as $exam)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900">{{ $exam->title }}</div>
                                    <div class="text-gray-500">{{ $exam->category }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $exam->duration }} Menit</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $exam->start_time->format('d M Y, H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $exam->questionBank->name ?? 'N/A' }} ({{ $exam->number_of_questions }} Soal)</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-3">
                                    <a href="{{ route('admin_pemeringkatan.sulitest_exams.show', $exam) }}" class="text-blue-600 hover:text-blue-900">Kelola</a>
                                    <a href="{{ route('admin_pemeringkatan.sulitest_exams.edit', $exam) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                    <form action="{{ route('admin_pemeringkatan.sulitest_exams.destroy', $exam) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-sm text-gray-500">
                                    <i class="fas fa-calendar-times fa-2x mb-2 text-gray-400"></i>
                                    <p>Belum ada ujian yang dibuat.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


