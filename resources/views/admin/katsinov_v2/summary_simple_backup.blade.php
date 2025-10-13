@extends('admin.admin')

@section('contentadmin')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ route('admin.katsinov-v2.show', $katsinov->id) }}" 
               class="text-blue-600 hover:text-blue-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">📊 Summary Keseluruhan Penilaian</h1>
        </div>
        <p class="text-gray-600 ml-9">Hasil penilaian kelayakan inovasi: <span class="font-semibold">{{ $katsinov->title }}</span></p>
    </div>

    {{-- Overall Score Card --}}
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl shadow-lg p-8 mb-6 border-2 border-blue-200">
        <div class="text-center">
            <p class="text-lg text-gray-600 mb-3">Skor Keseluruhan</p>
            <div class="flex items-center justify-center gap-6 mb-4">
                <div class="relative">
                    <div class="text-7xl font-black {{ $overallAverage >= 80 ? 'text-green-600' : ($overallAverage >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ number_format($overallAverage, 1) }}%
                    </div>
                    <div class="absolute -top-2 -right-2">
                        @if($overallAverage >= 80)
                            <span class="text-4xl">🏆</span>
                        @elseif($overallAverage >= 60)
                            <span class="text-4xl">⭐</span>
                        @else
                            <span class="text-4xl">📝</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="inline-block px-8 py-3 rounded-full text-xl font-bold {{ $overallAverage >= 80 ? 'bg-green-100 text-green-700 border-2 border-green-500' : ($overallAverage >= 60 ? 'bg-yellow-100 text-yellow-700 border-2 border-yellow-500' : 'bg-red-100 text-red-700 border-2 border-red-500') }}">
                @if($overallAverage >= 80)
                    ✅ LAYAK UNTUK DIKEMBANGKAN
                @elseif($overallAverage >= 60)
                    ⚠️ CUKUP LAYAK - PERLU PERBAIKAN
                @else
                    ❌ TIDAK LAYAK - PERLU REVISI BESAR
                @endif
            </div>
            
            <div class="mt-4 text-sm text-gray-600">
                <p>Status: <span class="font-semibold">{{ ucfirst($katsinov->status) }}</span></p>
                @if($katsinov->reviewer)
                    <p>Reviewer: <span class="font-semibold">{{ $katsinov->reviewer->name }}</span></p>
                @endif
            </div>
        </div>
    </div>

    {{-- Indicator Scores --}}
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <span>📈</span>
            <span>Skor Per Indikator</span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($indicatorScores as $index => $data)
                @php
                    $colorClass = $data['status'] === 'excellent' ? 'green' : ($data['status'] === 'good' ? 'yellow' : 'red');
                    $bgColor = $data['status'] === 'excellent' ? 'bg-green-50' : ($data['status'] === 'good' ? 'bg-yellow-50' : 'bg-red-50');
                    $borderColor = $data['status'] === 'excellent' ? 'border-green-200' : ($data['status'] === 'good' ? 'border-yellow-200' : 'border-red-200');
                @endphp
                
                <div class="relative {{ $bgColor }} rounded-lg p-6 border-2 {{ $borderColor }} hover:shadow-xl transition duration-300">
                    {{-- Badge Number --}}
                    <div class="absolute -top-3 -left-3 w-10 h-10 bg-{{ $colorClass }}-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                        {{ $index }}
                    </div>
                    
                    <div class="mt-2">
                        <h3 class="font-bold text-gray-800 mb-3 text-lg">Indikator {{ $index }}</h3>
                        
                        {{-- Percentage Circle --}}
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-4xl font-black text-{{ $colorClass }}-600">
                                    {{ number_format($data['percentage'], 1) }}%
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $data['score'] }} / {{ $data['max_score'] }} poin
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">
                                    <div class="font-semibold">{{ $data['total_rows'] }} pertanyaan</div>
                                    @if($data['status'] === 'excellent')
                                        <div class="text-green-600 font-bold mt-1">✓ Sangat Baik</div>
                                    @elseif($data['status'] === 'good')
                                        <div class="text-yellow-600 font-bold mt-1">~ Cukup</div>
                                    @else
                                        <div class="text-red-600 font-bold mt-1">✗ Kurang</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Progress Bar --}}
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="bg-{{ $colorClass }}-600 h-4 rounded-full transition-all duration-1000 ease-out flex items-center justify-end px-2" 
                                 style="width: {{ $data['percentage'] }}%">
                                <span class="text-xs text-white font-bold">{{ number_format($data['percentage'], 0) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Aspect Scores --}}
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <span>🎯</span>
            <span>Skor Per Aspek</span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($aspectScores as $aspect => $data)
                @php
                    $colorClass = $data['status'] === 'excellent' ? 'green' : ($data['status'] === 'good' ? 'yellow' : 'red');
                    $bgColor = $data['status'] === 'excellent' ? 'bg-green-50' : ($data['status'] === 'good' ? 'bg-yellow-50' : 'bg-red-50');
                @endphp
                
                <div class="relative {{ $bgColor }} rounded-lg p-5 border-2 border-{{ $data['color'] }}-200 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">{{ $data['icon'] }}</span>
                        <span class="text-xs px-2 py-1 bg-white rounded-full text-gray-600 font-semibold">
                            {{ $aspect }}
                        </span>
                    </div>
                    
                    <h3 class="font-bold text-gray-800 mb-2">{{ $data['label'] }}</h3>
                    
                    <div class="flex items-end justify-between mb-2">
                        <div class="text-3xl font-black text-{{ $colorClass }}-600">
                            {{ number_format($data['percentage'], 1) }}%
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $data['rows'] }} rows
                        </div>
                    </div>
                    
                    {{-- Mini Progress Bar --}}
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-{{ $data['color'] }}-600 h-2 rounded-full transition-all duration-1000" 
                             style="width: {{ $data['percentage'] }}%">
                        </div>
                    </div>
                    
                    <div class="mt-2 text-xs text-gray-600">
                        {{ $data['score'] }} / {{ $data['max_score'] }} poin
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Notes Section --}}
    @if($katsinov->notes->count() > 0)
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <span>📝</span>
            <span>Catatan Tambahan</span>
        </h2>
        
        <div class="space-y-3">
            @foreach($katsinov->notes as $note)
                <div class="flex gap-4 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                            {{ $note->indicator_number }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-blue-800 mb-1">Indikator {{ $note->indicator_number }}</div>
                        <p class="text-gray-700">{{ $note->notes }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Legend & Info --}}
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl shadow p-6 mb-6">
        <h3 class="font-bold text-gray-800 mb-4">📌 Keterangan Penilaian</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-4 h-4 bg-green-600 rounded"></div>
                <span class="text-gray-700"><strong>80% - 100%:</strong> Sangat Layak (Excellent)</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-4 h-4 bg-yellow-600 rounded"></div>
                <span class="text-gray-700"><strong>60% - 79%:</strong> Cukup Layak (Good)</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-4 h-4 bg-red-600 rounded"></div>
                <span class="text-gray-700"><strong>< 60%:</strong> Tidak Layak (Poor)</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3 justify-center">
        <a href="{{ route('admin.katsinov-v2.show', $katsinov->id) }}" 
           class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Detail
        </a>
        
        <a href="{{ route('admin.katsinov-v2.print', $katsinov->id) }}" 
           target="_blank"
           class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Proposal
        </a>
        
        @if($katsinov->status === 'completed')
        <a href="{{ route('admin.katsinov-v2.certificate', $katsinov->id) }}" 
           target="_blank"
           class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Unduh Sertifikat
        </a>
        @endif
    </div>
</div>
@endsection
