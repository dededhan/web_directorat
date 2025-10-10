@extends('reviewer_hibah.index')

@section('content')
<div class="p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-purple-100 text-lg">Dashboard Reviewer Hibah Modul Ajar</p>
                </div>
                <div class="hidden lg:block">
                    <i class='bx bxs-book-reader text-6xl text-white/30'></i>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Assignments -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <i class='bx bx-task text-2xl text-purple-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalAssignments }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Total Assignment</h3>
                <p class="text-sm text-gray-500 mt-1">Proposal yang ditugaskan</p>
            </div>

            <!-- Pending Reviews -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $pendingReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Menunggu Review</h3>
                <p class="text-sm text-gray-500 mt-1">Belum direview</p>
            </div>

            <!-- Completed Reviews -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class='bx bx-check-circle text-2xl text-green-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $completedReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Selesai Direview</h3>
                <p class="text-sm text-gray-500 mt-1">Sudah dikirim ke admin</p>
            </div>
        </div>

        <!-- Recent Assignments -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bx-list-ul mr-3'></i>
                    Assignment Terbaru
                </h2>
            </div>

            <div class="p-6">
                @if($recentAssignments->count() > 0)
                <div class="space-y-4">
                    @foreach($recentAssignments as $proposal)
                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-2">{{ $proposal->judul_modul }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i class='bx bx-user mr-1'></i>
                                        {{ $proposal->user->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class='bx bx-calendar mr-1'></i>
                                        {{ $proposal->sesi->nama_sesi }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800
                                    @elseif($proposal->status === 'menunggu_direview') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                                </span>
                                <a href="{{ route('reviewer_hibah.hibah_modul.show', $proposal->id) }}" 
                                   class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors">
                                    Review
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('reviewer_hibah.hibah_modul.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-purple-100 text-purple-700 font-semibold rounded-xl hover:bg-purple-200 transition-colors">
                        Lihat Semua Assignment
                        <i class='bx bx-right-arrow-alt ml-2 text-xl'></i>
                    </a>
                </div>
                @else
                <div class="text-center py-12">
                    <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                    <p class="text-gray-500 text-lg font-medium">Belum ada assignment</p>
                    <p class="text-gray-400 text-sm mt-2">Assignment akan muncul setelah admin menugaskan Anda sebagai reviewer</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
