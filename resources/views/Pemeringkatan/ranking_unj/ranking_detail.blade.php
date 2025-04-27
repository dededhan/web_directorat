{{-- @extends('Pemeringkatan.layout') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor-list.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .card-shadow:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .indicators-list {
            counter-reset: indicator;
            overflow: visible;
        }
        
        .indicator {
            margin-bottom: 16px;
            padding-left: 35px;
            position: relative;
        }
        
        .indicator:before {
            content: counter(indicator) ".";
            counter-increment: indicator;
            position: absolute;
            left: 0;
            font-weight: 600;
            color: #3b82f6;
        }
        
        ul.custom-list {
            list-style-type: none;
            padding-left: 25px;
        }
        
        ul.custom-list li {
            margin-bottom: 16px;
            position: relative;
            padding-left: 10px;
        }
        
        ul.custom-list li:before {
            content: "•";
            position: absolute;
            left: -15px;
            color: #3b82f6;
            font-size: 1.2em;
        }
        
        .back-button {
            transition: all 0.2s ease;
        }
        
        .back-button:hover {
            transform: translateX(-3px);
        }
        
        .prose img {
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .prose h2 {
            color: #1e40af;
            font-weight: 600;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }
        
        .prose h3 {
            color: #1e3a8a;
            font-weight: 500;
            margin-top: 1.2em;
            margin-bottom: 0.5em;
        }
        
        .ranking-header {
            background-image: linear-gradient(135deg, #f0f9ff 0%, #e6f0f9 100%);
            border-radius: 12px;
            border-bottom: 3px solid #93c5fd;
        }
        
        .last-updated {
            display: inline-flex;
            align-items: center;
            color: #64748b;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layout.navbar_pemeringkatan')
    
    <div class="container mx-auto py-12 px-4 max-w-5xl">
        <div class="bg-white rounded-xl card-shadow p-0 mb-10 overflow-hidden">
            <!-- Header Section with Gradient Background -->
            <div class="ranking-header p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/4 flex justify-center mb-6 md:mb-0">
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <img src="{{ asset('storage/' . $ranking->gambar) }}" alt="{{ $ranking->judul }}" 
                                class="h-36 w-auto object-contain">
                        </div>
                    </div>
                    <div class="md:w-3/4 md:pl-8 text-center md:text-left">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">{{ $ranking->judul }}</h1>
                        <div class="last-updated">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Last updated: {{ $ranking->updated_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Section -->
            <div class="p-6 md:p-8">
                <div class="prose prose-blue max-w-none">
                    {!! $ranking->deskripsi !!}
                </div>
            </div>
        </div>
        
        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" 
                class="back-button inline-flex items-center px-5 py-2.5 bg-blue-50 text-blue-700 rounded-lg 
                hover:bg-blue-100 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                    class="bi bi-arrow-left mr-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" 
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Back to Rankings
            </a>
        </div>
    </div>

    @include('layout.footer')
</body>
</html>