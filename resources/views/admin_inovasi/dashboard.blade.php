@extends('admin_inovasi.index')

@section('contentadmin_inovasi')


<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin Inovasi</h1>
    <p class="text-gray-600 mt-1">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}!</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-teal-100 p-3 rounded-full">
            <i class="fas fa-lightbulb text-2xl text-teal-600"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Inovasi</p>
            <p class="text-2xl font-bold text-gray-800">0</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-file-alt text-2xl text-blue-600"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Proposal Aktif</p>
            <p class="text-2xl font-bold text-gray-800">0</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-yellow-100 p-3 rounded-full">
            <i class="fas fa-users text-2xl text-yellow-600"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Tim Inovator</p>
            <p class="text-2xl font-bold text-gray-800">0</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-star text-2xl text-green-600"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Rating Rata-rata</p>
            <p class="text-2xl font-bold text-gray-800">0</p>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Aktivitas Terkini</h2>
    <div class="text-center py-10 border-2 border-dashed border-gray-300 rounded-lg">
        <i class="fas fa-chart-bar text-4xl text-gray-400"></i>
        <p class="mt-4 text-gray-500">Grafik atau tabel aktivitas akan ditampilkan di sini.</p>
    </div>
</div>

@endsection
