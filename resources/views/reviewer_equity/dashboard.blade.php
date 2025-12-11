@extends('reviewer_equity.index')

@section('content')
    <div class="mb-6">
        <div class="bg-gradient-to-r from-[#11A697] to-[#0e8a7c] rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-white/90 text-lg">
                        Dashboard Reviewer 
                        @if(auth()->user()->role === 'reviewer_equity')
                            Community Development
                        @elseif(auth()->user()->role === 'reviewer_hibah')
                            Hibah Modul Ajar
                        @elseif(auth()->user()->role === 'reviewer_student_exchange')
                            Student Exchange
                        @endif
                    </p>
                </div>
                <div class="hidden lg:block">
                    <i class='bx bxs-user-check text-6xl text-white/30'></i>
                </div>
            </div>
        </div>
    </div>

    @php
        $user = auth()->user();
        $isReviewerEquity = $user->role === 'reviewer_equity';
        $isReviewerHibah = $user->role === 'reviewer_hibah';
        $isReviewerStudentExchange = $user->role === 'reviewer_student_exchange';
    @endphp

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Comdev Stats (Hanya untuk reviewer_equity) --}}
        @if($isReviewerEquity)
            @php
                $totalComdevAssignments = $user->submissionsToReview()->count();
                $submissionsWithReviews = \App\Models\ComdevReview::where('reviewer_id', $user->id)
                    ->pluck('comdev_submission_id')
                    ->unique();
                $completedComdevReviews = $submissionsWithReviews->count();
                $pendingComdevReviews = $totalComdevAssignments - $completedComdevReviews;
            @endphp

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <i class='bx bxs-briefcase-alt-2 text-2xl text-blue-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalComdevAssignments }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Total Comdev</h3>
                <p class="text-sm text-gray-500 mt-1">Proposal ditugaskan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $pendingComdevReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Pending Comdev</h3>
                <p class="text-sm text-gray-500 mt-1">Menunggu review</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class='bx bx-check-circle text-2xl text-green-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $completedComdevReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Selesai Comdev</h3>
                <p class="text-sm text-gray-500 mt-1">Sudah direview</p>
            </div>
        @endif

        {{-- Hibah Stats (Hanya untuk reviewer_hibah) --}}
        @if($isReviewerHibah)
            @php
                $totalHibahAssignments = \App\Models\ProposalModul::where('reviewer_id', $user->id)->count();
                $completedHibahReviews = \App\Models\ProposalModul::where('reviewer_id', $user->id)
                    ->whereNotNull('komentar_reviewer')
                    ->count();
                $pendingHibahReviews = $totalHibahAssignments - $completedHibahReviews;
            @endphp

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <i class='bx bxs-book-content text-2xl text-purple-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalHibahAssignments }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Total Hibah Modul</h3>
                <p class="text-sm text-gray-500 mt-1">Proposal ditugaskan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $pendingHibahReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Pending Hibah</h3>
                <p class="text-sm text-gray-500 mt-1">Menunggu review</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class='bx bx-check-circle text-2xl text-green-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $completedHibahReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Selesai Hibah</h3>
                <p class="text-sm text-gray-500 mt-1">Sudah direview</p>
            </div>
        @endif

        {{-- Student Exchange Stats (Hanya untuk reviewer_student_exchange) --}}
        @if($isReviewerStudentExchange)
            @php
                $totalStudentExchangeAssignments = \App\Models\ProposalStudentExchange::where('reviewer_id', $user->id)->count();
                $completedStudentExchangeReviews = \App\Models\ProposalStudentExchange::where('reviewer_id', $user->id)
                    ->whereNotNull('nilai_reviewer')
                    ->count();
                $pendingStudentExchangeReviews = $totalStudentExchangeAssignments - $completedStudentExchangeReviews;
            @endphp

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-teal-100 rounded-xl">
                        <i class='bx bxs-plane-alt text-2xl text-teal-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalStudentExchangeAssignments }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Total Student Exchange</h3>
                <p class="text-sm text-gray-500 mt-1">Proposal ditugaskan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $pendingStudentExchangeReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Pending Review</h3>
                <p class="text-sm text-gray-500 mt-1">Menunggu review</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class='bx bx-check-circle text-2xl text-green-600'></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $completedStudentExchangeReviews }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Selesai Review</h3>
                <p class="text-sm text-gray-500 mt-1">Sudah direview</p>
            </div>
        @endif
    </div>

    {{-- Recent Assignments --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        @if($isReviewerEquity)
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class='bx bxs-briefcase-alt-2 mr-2 text-xl'></i>
                    Proposal Comdev Terbaru
                </h3>
            </div>
            <div class="p-6">
                @php
                    $recentComdev = $user->submissionsToReview()->latest()->take(5)->get();
                @endphp
                @forelse($recentComdev as $submission)
                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-100">
                    <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">{{ $submission->judul }}</h4>
                    <p class="text-sm text-gray-500 mb-2">{{ $submission->user->name }}</p>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            {{ $submission->status }}
                        </span>
                        <a href="{{ route('reviewer_equity.comdev.assignments.show', $submission->id) }}" 
                           class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Review <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada assignment comdev</p>
                @endforelse
                
                @if($recentComdev->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('reviewer_equity.comdev.assignments.index') }}" 
                       class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
                @endif
            </div>
        @endif

        @if($isReviewerHibah)
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class='bx bxs-book-content mr-2 text-xl'></i>
                    Proposal Hibah Modul Terbaru
                </h3>
            </div>
            <div class="p-6">
                @php
                    $recentHibah = \App\Models\ProposalModul::where('reviewer_id', $user->id)
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                @forelse($recentHibah as $proposal)
                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-100">
                    <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">{{ $proposal->judul_modul }}</h4>
                    <p class="text-sm text-gray-500 mb-2">{{ $proposal->user->name }}</p>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                            {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                        </span>
                        <a href="{{ route('reviewer_equity.hibah_modul.show', $proposal->id) }}" 
                           class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                            Review <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada assignment hibah modul</p>
                @endforelse
                
                @if($recentHibah->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('reviewer_equity.hibah_modul.index') }}" 
                       class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                        Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
                @endif
            </div>
        @endif

        @if($isReviewerStudentExchange)
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class='bx bxs-plane-alt mr-2 text-xl'></i>
                    Proposal Student Exchange Terbaru
                </h3>
            </div>
            <div class="p-6">
                @php
                    $recentStudentExchange = \App\Models\ProposalStudentExchange::where('reviewer_id', $user->id)
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                @forelse($recentStudentExchange as $proposal)
                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-100">
                    <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">{{ $proposal->judul_kegiatan }}</h4>
                    <p class="text-sm text-gray-500 mb-2">{{ $proposal->user->name }}</p>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 bg-teal-100 text-teal-800 text-xs font-medium rounded-full">
                            {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                        </span>
                        <a href="{{ route('reviewer_equity.student_exchange.show', $proposal->id) }}" 
                           class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                            Review <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada assignment student exchange</p>
                @endforelse
                
                @if($recentStudentExchange->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('reviewer_equity.student_exchange.index') }}" 
                       class="text-teal-600 hover:text-teal-700 font-medium text-sm">
                        Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
                @endif
            </div>
        @endif
    </div>
@endsection
