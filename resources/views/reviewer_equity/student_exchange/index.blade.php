@extends('reviewer_equity.index')

@section('content')
    {{-- Header Section --}}
    <div class="mb-6 md:mb-8">
        <div class="bg-gradient-to-r from-[#11A697] to-[#0e8a7c] rounded-xl shadow-lg p-6 md:p-8 text-white">
            <div class="flex items-start space-x-4">
                <div class="hidden md:flex items-center justify-center w-16 h-16 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class='bx bx-world text-4xl'></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">Review Proposal Student Exchange</h1>
                    <p class="text-white/90 text-sm md:text-base">Daftar proposal student exchange yang ditugaskan untuk Anda review</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-gray-50 to-white p-4 md:p-6 border-b border-gray-200">
            <h3 class="font-bold text-gray-800 text-lg md:text-xl flex items-center">
                <i class='bx bx-list-ul text-2xl mr-2 text-[#11A697]'></i>
                Daftar Proposal Masuk
            </h3>
        </div>
        
        <div class="p-4 md:p-6">
            @if($proposals->isEmpty())
                <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-8 md:p-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <i class='bx bx-inbox text-5xl md:text-6xl text-gray-400'></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-700 mb-2">Belum Ada Proposal</h3>
                        <p class="text-sm md:text-base text-gray-500 max-w-md">Belum ada proposal student exchange yang ditugaskan kepada Anda saat ini.</p>
                    </div>
                </div>
            @else
                {{-- Desktop Table View --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                            <tr>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Kegiatan</th>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pengusul</th>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Sesi</th>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status Review</th>
                                <th class="py-4 px-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($proposals as $proposal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-start">
                                        <i class='bx bx-world text-indigo-500 text-xl mr-2 mt-1'></i>
                                        <div>
                                            <p class="font-semibold text-gray-800 line-clamp-2">{{ $proposal->judul_kegiatan }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class='bx bx-calendar text-xs'></i>
                                                {{ $proposal->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-2">
                                            <i class='bx bxs-user text-indigo-600'></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $proposal->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $proposal->user->nidn ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="text-sm text-gray-800 font-medium">{{ $proposal->sesi->nama_sesi ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    @if($proposal->komentar_reviewer)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class='bx bx-check-circle mr-1'></i>
                                            Sudah Direview
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class='bx bx-time-five mr-1'></i>
                                            Menunggu Review
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('reviewer_equity.student_exchange.show', $proposal->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#11A697] hover:bg-[#0e8a7c] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i class='bx bx-show mr-1'></i>
                                        Detail & Review
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View --}}
                <div class="lg:hidden space-y-4">
                    @foreach ($proposals as $proposal)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-4 space-y-3">
                                {{-- Judul --}}
                                <div class="flex items-start space-x-2">
                                    <i class='bx bx-world text-indigo-500 text-xl mt-1'></i>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 line-clamp-2">{{ $proposal->judul_kegiatan }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class='bx bx-calendar text-xs'></i>
                                            {{ $proposal->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Pengusul --}}
                                <div class="flex items-center pt-2 border-t border-gray-100">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-2">
                                        <i class='bx bxs-user text-indigo-600'></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-800">{{ $proposal->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $proposal->user->nidn ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Sesi --}}
                                <div class="pt-2 border-t border-gray-100">
                                    <p class="text-xs text-gray-500 mb-1">Sesi</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $proposal->sesi->nama_sesi ?? '-' }}</p>
                                </div>

                                {{-- Status & Action --}}
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    @if($proposal->komentar_reviewer)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class='bx bx-check-circle mr-1'></i>
                                            Sudah Direview
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class='bx bx-time-five mr-1'></i>
                                            Pending
                                        </span>
                                    @endif
                                    
                                    <a href="{{ route('reviewer_equity.student_exchange.show', $proposal->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-[#11A697] hover:bg-[#0e8a7c] text-white text-xs font-medium rounded-lg transition-colors">
                                        <i class='bx bx-show mr-1'></i>
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $proposals->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
