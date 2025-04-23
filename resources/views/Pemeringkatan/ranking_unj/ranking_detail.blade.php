{{-- @extends('Pemeringkatan.layout') --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('home.css') }}">
@push('styles')
<style>
    .indicators-list {
        counter-reset: indicator;
        overflow: visible;
    }
    
    .indicator {
        margin-bottom: 10px;
        padding-left: 30px;
        position: relative;
    }
    
    .indicator:before {
        content: counter(indicator) ".";
        counter-increment: indicator;
        position: absolute;
        left: 0;
        color: #3498db;
    }
    
    ul.custom-list {
        list-style-type: none;
        padding-left: 20px;
    }
    
    ul.custom-list li {
        margin-bottom: 15px;
        position: relative;
    }
    
    ul.custom-list li:before {
        content: "•";
        position: absolute;
        left: -15px;
        color: #3498db;
    }
</style>
@endpush
@include('layout.navbar_pemeringkatan')
{{-- @section('content') --}}
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row items-center mb-6">
            <div class="md:w-1/4 flex justify-center mb-4 md:mb-0">
                <img src="{{ asset('storage/' . $ranking->gambar) }}" alt="{{ $ranking->judul }}" class="h-32 object-contain">
            </div>
            <div class="md:w-3/4 md:pl-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $ranking->judul }}</h1>
                <div class="text-sm text-gray-500">
                    <span>Last updated: {{ $ranking->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        
        <div class="border-t pt-6">
            <div class="prose max-w-none">
                {!! $ranking->deskripsi !!}
            </div>
        </div>
    </div>
    
    <div class="flex justify-between mt-8">
        <a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left mr-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Back to Rankings
        </a>
    </div>
</div>

@include('layout.footer')
{{-- @endsection --}}