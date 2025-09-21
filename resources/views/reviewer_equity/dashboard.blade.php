@extends('reviewer_equity.index')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name ?? 'Reviewer' }}!</p>
        </div>
    </div>

    {{-- Simplified stats for the reviewer --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-[#5D78D0] p-5 rounded-lg shadow-md text-white relative overflow-hidden">
            <i class="fa-solid fa-file-signature absolute -right-4 -top-2 text-8xl opacity-10"></i>
            <i class="fa-solid fa-file-signature absolute -right-2 top-10 text-6xl opacity-10"></i>
            <p class="font-semibold text-sm">PROPOSAL PERLU DIREVIEW</p>
            <h2 class="text-4xl font-bold mt-2">5</h2>
            <a href="#" class="text-xs mt-4 inline-block bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">Lihat Detail</a>
        </div>
        <div class="bg-[#5D78D0] p-5 rounded-lg shadow-md text-white relative overflow-hidden">
            <i class="fa-solid fa-check-double absolute -right-4 -top-2 text-8xl opacity-10"></i>
            <i class="fa-solid fa-check-double absolute -right-2 top-10 text-6xl opacity-10"></i>
            <p class="font-semibold text-sm">PROPOSAL SUDAH DIREVIEW</p>
            <h2 class="text-4xl font-bold mt-2">12</h2>
            <a href="#" class="text-xs mt-4 inline-block bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">Lihat Riwayat</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="font-bold text-gray-800 text-lg border-b pb-3">Daftar Proposal</h3>
        <div class="mt-4">
            <p class="text-gray-600">Tabel atau daftar proposal yang perlu direview akan ditampilkan di sini.</p>
            {{-- You can add a table here to list proposals --}}
        </div>
    </div>
@endsection
