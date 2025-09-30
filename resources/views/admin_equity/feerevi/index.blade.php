@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Manajemen Fee Reviewer</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Fee Reviewer</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua sesi pembayaran insentif untuk reviewer.</p>
                </div>
                <div class="flex-shrink-0">
                    {{-- Tombol dummy untuk menambah sesi --}}
                    <button
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-plus-circle mr-2 text-lg'></i>
                        Buat Sesi Baru
                    </button>
                </div>
            </div>
        </header>

        {{-- Main Content Card (Dummy Content) --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-wallet-alt mr-3 text-2xl'></i>
                            Daftar Sesi Fee Reviewer
                        </h2>
                        <p class="mt-2 text-teal-100">Daftar sesi pembayaran insentif yang telah dibuat.</p>
                    </div>
                </div>
            </div>

            {{-- Dummy Table/Card View --}}
            <div class="p-8">
                <div class="flex flex-col items-center py-10">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center mb-6">
                        <i class='bx bx-calendar-event text-4xl text-indigo-500'></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Data Belum Tersedia</h3>
                    <p class="text-gray-500 max-w-md text-center">Silakan buat sesi baru untuk memulai manajemen pembayaran Fee Reviewer.</p>
                </div>
            </div>
            
            {{-- Dummy Pagination --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan 0 hingga 0 dari 0 hasil
                    </div>
                    {{-- Dummy pagination links --}}
                    <div class="pagination-wrapper">
                        <div class="pagination flex gap-0.25rem">
                            <span class="active span p-2 text-white bg-teal-600 rounded-lg">1</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection