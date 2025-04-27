<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Ranking Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor-list.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e0f2f1;
        }
        
        .hero-gradient {
            background: #D1E7DD;
            color: #006064;
        }
        
        .card {
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .image-frame {
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0, 96, 100, 0.2);
            overflow: hidden;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.8rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.8rem;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(4px);
        }
        
        .btn-back {
            background-color: white;
            color: #00796b;
            border: 2px solid #00796b;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .btn-back:hover {
            background-color: #00796b;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 121, 107, 0.2);
        }
        
        .prose h2 {
            color: #00695c;
            font-weight: 700;
            margin-top: 1.75em;
            margin-bottom: 0.75em;
            font-size: 1.5rem;
        }
        
        .prose h3 {
            color: #00796b;
            font-weight: 600;
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            font-size: 1.25rem;
        }
        
        .prose p {
            margin-bottom: 1.25rem;
            line-height: 1.7;
        }
        
        .prose ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        
        .content-container {
            max-width: 850px;
            margin: 0 auto;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('layout.navbar_pemeringkatan')
    
    <!-- Hero Section -->
    <div class="hero-gradient py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto animate-fade-in">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <!-- Image -->
                    <div class="image-frame p-4 w-48 h-48 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $ranking->gambar) }}" alt="{{ $ranking->judul }}" 
                            class="max-w-full max-h-full object-contain">
                    </div>
                    
                    <!-- Title and Info -->
                    <div class="text-center lg:text-left">
                        <div class="flex justify-center lg:justify-start">
                            <span class="badge mb-3 text-teal-800 bg-white/70 border-teal-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                Ranking Detail
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-3 text-teal-800">{{ $ranking->judul }}</h1>
                        <div class="flex items-center justify-center lg:justify-start text-sm text-teal-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Last updated: {{ $ranking->updated_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-10">
        <div class="content-container">
            <!-- Card Content -->
            <div class="card bg-white p-6 md:p-10 mb-10 animate-fade-in" style="animation-delay: 0.1s; border-top: 4px solid #00796b;">
                <div class="prose prose-teal max-w-none">
                    {!! $ranking->deskripsi !!}
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="flex justify-center mb-16 animate-fade-in" style="animation-delay: 0.2s;">
                <a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" 
                    class="btn-back px-6 py-3 rounded-full flex items-center text-sm md:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" 
                        class="mr-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" 
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Back to Rankings
                </a>
            </div>
        </div>
    </div>

    @include('layout.footer')
    
    <script>
        // Simple scroll animation
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate-fade-in');
            animateElements.forEach(element => {
                element.style.opacity = '0';
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>