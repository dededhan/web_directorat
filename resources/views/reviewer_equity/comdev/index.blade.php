@extends('reviewer_equity.index')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Proposal Comdev</h1>
            <p class="text-gray-500 mt-1">Review and manage proposal submissions.</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="font-bold text-gray-800 text-lg border-b pb-3">Daftar Proposal Masuk</h3>
        <div class="mt-4">
            <div class="text-center text-gray-500 py-8">
                <i class='bx bx-info-circle text-4xl'></i>
                <p class="mt-2">Data proposal dari dosen akan ditampilkan di sini.</p>
                <p class="text-sm">Saat ini belum ada data untuk ditampilkan.</p>
            </div>
            {{-- A table to list proposals will be added here later --}}
        </div>
    </div>
@endsection
