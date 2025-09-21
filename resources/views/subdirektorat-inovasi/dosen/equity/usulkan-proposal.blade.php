@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" 
                       class="inline-flex items-center text-gray-500 hover:text-teal-600 transition-colors duration-200">
                        <i class='bx bx-home mr-2 text-lg'></i>
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class='bx bx-chevron-right text-gray-400 mx-1'></i>
                        <span class="font-medium text-gray-700">Usulkan Proposal</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="text-center lg:text-left">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-3">
                    Usulkan Proposal Penelitian/Pengabdian
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto lg:mx-0">
                    Pilih skema penelitian atau pengabdian yang sesuai dengan minat dan keahlian Anda
                </p>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-8">
                <div class="text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-white mb-2">Skema Proposal Tersedia</h2>
                    <p class="text-teal-100 text-sm">
                        Daftar skema penelitian dan pengabdian yang dapat Anda ajukan
                    </p>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="p-6 lg:p-8">
                
                {{-- Desktop Table --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left py-4 px-6 font-semibold text-gray-700 rounded-tl-lg">
                                    Skema & Deskripsi
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                    Dana Maksimal
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                    Periode Submit
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                    Tim
                                </th>
                                <th class="text-center py-4 px-6 font-semibold text-gray-700 rounded-tr-lg">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($sesiTersedia as $sesi)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-6 px-6">
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-base mb-1">
                                                {{ $sesi->nama_sesi }}
                                            </h3>
                                            <p class="text-gray-600 text-sm leading-relaxed">
                                                {{ $sesi->deskripsi }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-6 px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-money text-green-500 mr-2 text-lg'></i>
                                            <span class="font-semibold text-green-600">
                                                Rp {{ number_format($sesi->dana_maksimal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-6">
                                        <div class="flex items-center text-gray-700">
                                            <i class='bx bx-calendar text-blue-500 mr-2 text-lg'></i>
                                            <div class="text-sm">
                                                <div class="font-medium">
                                                    {{ \Carbon\Carbon::parse($sesi->periode_awal)->isoFormat('D MMM Y') }}
                                                </div>
                                                <div class="text-gray-500">
                                                    s/d {{ \Carbon\Carbon::parse($sesi->periode_akhir)->isoFormat('D MMM Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-group text-purple-500 mr-2 text-lg'></i>
                                            <span class="font-medium text-gray-700">
                                                {{ $sesi->min_anggota }} - {{ $sesi->max_anggota }} Orang
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-6">
                                        @php
                                            $submissionsForThisSession = $userSubmissions->get($sesi->id);
                                            $draftCount = $submissionsForThisSession ? $submissionsForThisSession->where('status', 'draft')->count() : 0;
                                            $submittedCount = $submissionsForThisSession ? $submissionsForThisSession->where('status', '!=', 'draft')->count() : 0;
                                        @endphp

                                        @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($sesi->periode_akhir)->endOfDay()))
                                            <div class="text-center">
                                                <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 font-medium rounded-lg text-sm">
                                                    <i class='bx bx-lock mr-2'></i>
                                                    Sudah Ditutup
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center space-y-3">
                                                <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.createIdentitas', $sesi->id) }}" 
                                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-lg hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                    <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                                    Usulkan Baru
                                                </a>

                                             
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <div class="flex flex-col items-center">
                                            <i class='bx bx-folder-open text-6xl text-gray-300 mb-4'></i>
                                            <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak Ada Sesi Tersedia</h3>
                                            <p class="text-gray-400 text-sm">Saat ini belum ada sesi proposal yang dibuka.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="lg:hidden space-y-4">
                    @forelse ($sesiTersedia as $sesi)
                        <div class="bg-gradient-to-r from-white to-gray-50 rounded-2xl border border-gray-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-200">
                            
                            {{-- Card Header --}}
                            <div class="bg-gradient-to-r from-teal-50 to-teal-100 px-5 py-4 border-b border-teal-200">
                                <h3 class="font-bold text-teal-800 text-lg mb-1">{{ $sesi->nama_sesi }}</h3>
                                <p class="text-teal-600 text-sm leading-relaxed">{{ $sesi->deskripsi }}</p>
                            </div>

                            {{-- Card Content --}}
                            <div class="p-5 space-y-4">
                                
                                {{-- Dana --}}
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-600 font-medium text-sm flex items-center">
                                        <i class='bx bx-money text-green-500 mr-2 text-lg'></i>
                                        Dana Maksimal
                                    </span>
                                    <span class="font-bold text-green-600">
                                        Rp {{ number_format($sesi->dana_maksimal, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Periode --}}
                                <div class="flex items-start justify-between py-2">
                                    <span class="text-gray-600 font-medium text-sm flex items-center">
                                        <i class='bx bx-calendar text-blue-500 mr-2 text-lg'></i>
                                        Periode Submit
                                    </span>
                                    <div class="text-right text-sm">
                                        <div class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($sesi->periode_awal)->isoFormat('D MMM Y') }}
                                        </div>
                                        <div class="text-gray-500">
                                            s/d {{ \Carbon\Carbon::parse($sesi->periode_akhir)->isoFormat('D MMM Y') }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Anggota --}}
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-600 font-medium text-sm flex items-center">
                                        <i class='bx bx-group text-purple-500 mr-2 text-lg'></i>
                                        Anggota Tim
                                    </span>
                                    <span class="font-semibold text-gray-700">
                                        {{ $sesi->min_anggota }} - {{ $sesi->max_anggota }} Orang
                                    </span>
                                </div>

                                {{-- Action Section --}}
                                <div class="pt-4 border-t border-gray-200">
                                    @php
                                        $submissionsForThisSession = $userSubmissions->get($sesi->id);
                                        $draftCount = $submissionsForThisSession ? $submissionsForThisSession->where('status', 'draft')->count() : 0;
                                        $submittedCount = $submissionsForThisSession ? $submissionsForThisSession->where('status', '!=', 'draft')->count() : 0;
                                    @endphp

                                    @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($sesi->periode_akhir)->endOfDay()))
                                        <div class="text-center">
                                            <span class="inline-flex items-center px-4 py-3 bg-gray-100 text-gray-500 font-medium rounded-xl text-sm w-full justify-center">
                                                <i class='bx bx-lock mr-2'></i>
                                                Sudah Ditutup
                                            </span>
                                        </div>
                                    @else
                                        <div class="space-y-3">
                                            <a href="{{ route('subdirektorat-inovasi.dosen.equity.proposal.createIdentitas', $sesi->id) }}" 
                                               class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-[1.02] transition-all duration-200 shadow-md hover:shadow-lg w-full">
                                                <i class='bx bx-plus-circle mr-2 text-lg'></i>
                                                Usulkan Baru
                                            </a>

                                            @if ($draftCount > 0 || $submittedCount > 0)
                                                <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}?sesi_id={{ $sesi->id }}" 
                                                   class="block text-center text-sky-600 hover:text-sky-800 text-sm font-medium hover:underline transition-colors duration-200">
                                                    <i class='bx bx-file-find mr-1'></i>
                                                    Lihat Proposal Saya ({{ $draftCount }} Draft, {{ $submittedCount }} Diajukan)
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-folder-open text-6xl text-gray-300 mb-4'></i>
                                <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak Ada Sesi Tersedia</h3>
                                <p class="text-gray-400 text-sm">Saat ini belum ada sesi proposal yang dibuka.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection