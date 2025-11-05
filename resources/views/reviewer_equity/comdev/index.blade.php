@extends('reviewer_equity.index')

@section('content')
    {{-- Header Section --}}
    <div class="mb-6 md:mb-8">
        <div class="bg-gradient-to-r from-[#11A697] to-[#0e8a7c] rounded-xl shadow-lg p-6 md:p-8 text-white">
            <div class="flex items-start space-x-4">
                <div class="hidden md:flex items-center justify-center w-16 h-16 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class='bx bx-clipboard text-4xl'></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">Manajemen Proposal Comdev</h1>
                    <p class="text-white/90 text-sm md:text-base">Daftar proposal yang ditugaskan untuk Anda review</p>
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
            @if($submissions->isEmpty())
                <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-8 md:p-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <i class='bx bx-inbox text-5xl md:text-6xl text-gray-400'></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-700 mb-2">Belum Ada Proposal</h3>
                        <p class="text-sm md:text-base text-gray-500 max-w-md">Belum ada proposal yang ditugaskan kepada Anda saat ini.</p>
                    </div>
                </div>
            @else
                {{-- Desktop Table View --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                            <tr>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Proposal</th>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Sesi</th>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Dosen Pengaju</th>
                                <th class="py-4 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="py-4 px-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($submissions as $submission)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <p class="font-semibold text-gray-800 line-clamp-2">{{ $submission->judul }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm text-gray-600">{{ $submission->sesi->nama_sesi }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <i class='bx bx-user-circle text-2xl text-gray-400 mr-2'></i>
                                            <span class="text-sm font-medium text-gray-700">{{ $submission->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $submission->status }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <a href="{{ route('reviewer_equity.comdev.assignments.show', $submission->id) }}" class="inline-flex items-center px-4 py-2 bg-[#11A697] text-white rounded-lg hover:bg-[#0e8a7c] font-medium text-sm transition-all hover:shadow-md">
                                            <i class='bx bx-edit-alt text-lg mr-1'></i>
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View --}}
                <div class="lg:hidden space-y-4">
                    @foreach ($submissions as $submission)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-4 space-y-3">
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1 line-clamp-2">{{ $submission->judul }}</h4>
                                    <p class="text-xs text-gray-500">{{ $submission->sesi->nama_sesi }}</p>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class='bx bx-user-circle text-xl mr-2'></i>
                                    <span>{{ $submission->user->name }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between pt-2 border-t">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $submission->status }}</span>
                                    <a href="{{ route('reviewer_equity.comdev.assignments.show', $submission->id) }}" class="inline-flex items-center px-4 py-2 bg-[#11A697] text-white rounded-lg hover:bg-[#0e8a7c] font-medium text-sm transition-all">
                                        <i class='bx bx-edit-alt mr-1'></i>
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection