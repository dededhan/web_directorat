@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="p-6 sm:p-8 lg:p-10">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Dashboard SULITEST</h1>
        <p class="text-gray-600 mt-1.5">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}!</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-100 flex items-center space-x-4 transform hover:scale-[1.02] transition-transform duration-200">
            <div class="bg-teal-100 p-3 rounded-xl">
                <i class="fas fa-clipboard-list text-2xl text-teal-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Jumlah Tes Aktif</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">12</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-100 flex items-center space-x-4 transform hover:scale-[1.02] transition-transform duration-200">
            <div class="bg-blue-100 p-3 rounded-xl">
                <i class="fas fa-file-alt text-2xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Soal di Bank</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">1,250</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-100 flex items-center space-x-4 transform hover:scale-[1.02] transition-transform duration-200">
            <div class="bg-yellow-100 p-3 rounded-xl">
                <i class="fas fa-users text-2xl text-yellow-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Peserta Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">89</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-100 flex items-center space-x-4 transform hover:scale-[1.02] transition-transform duration-200">
            <div class="bg-green-100 p-3 rounded-xl">
                <i class="fas fa-star text-2xl text-green-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Rata-rata Skor</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">78.5</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-xs border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terkini</h2>
        <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
            <i class="fas fa-chart-bar text-4xl text-gray-400"></i>
            <p class="mt-4 text-gray-500 font-medium">Grafik atau tabel aktivitas akan ditampilkan di sini.</p>
        </div>
    </div>
</div>
@endsection
