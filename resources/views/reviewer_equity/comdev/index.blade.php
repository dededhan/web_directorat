@extends('reviewer_equity.index')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Proposal Comdev</h1>
            <p class="text-gray-500 mt-1">Daftar proposal yang ditugaskan untuk Anda review.</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="font-bold text-gray-800 text-lg border-b pb-3">Daftar Proposal Masuk</h3>
        <div class="mt-4 overflow-x-auto">
            @if($submissions->isEmpty())
                <div class="text-center text-gray-500 py-8">
                    <i class='bx bx-info-circle text-4xl'></i>
                    <p class="mt-2">Belum ada proposal yang ditugaskan kepada Anda.</p>
                </div>
            @else
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Judul Proposal</th>
                            <th class="py-3 px-4 text-left">Nama Sesi</th>
                            <th class="py-3 px-4 text-left">Dosen Pengaju</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submissions as $submission)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $submission->judul }}</td>
                                <td class="py-3 px-4">{{ $submission->sesi->nama_sesi }}</td>
                                <td class="py-3 px-4">{{ $submission->user->name }}</td>
                                <td class="py-3 px-4"><span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $submission->status }}</span></td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('reviewer_equity.comdev.assignments.show', $submission->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Review Proposal
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection