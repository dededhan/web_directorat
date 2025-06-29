<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman dinamis sesuai berita --}}
    <title>{{ $berita['title'] }} - SDG {{ $sdg_id }} UNJ</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
        @include('layout.navbar_hilirisasi')

    <script>
      // Custom Tailwind configuration
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              inter: ['Inter', 'sans-serif'],
            },
            colors: {
              // Warna dari SDG parent akan dimasukkan via inline style
              'sdg-color': '{{ $sdg['color'] }}',
            }
          }
        }
      }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Style untuk konten HTML yang datang dari controller */
        .prose p {
            margin-bottom: 1.25rem;
            line-height: 1.75;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- Header dinamis dengan warna sesuai SDG parent --}}
    <header style="background-color: {{ $sdg['color'] }};" class="text-white">
        <div class="container mx-auto px-6 py-10 flex items-center gap-6">
            <div class="bg-white p-3 rounded-lg shadow-xl w-24 h-24 md:w-32 md:h-32 flex-shrink-0">
                <img src="{{ $sdg['icon'] }}" alt="Icon SDG {{ $sdg_id }}" class="w-full h-full object-contain">
            </div>
            <div class="text-left">
                 <h2 class="text-sm md:text-base font-semibold uppercase tracking-wider">BERITA TERKAIT SDG {{ $sdg_id }}</h2>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight">{{ $sdg['title'] }}</h1>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-6 lg:p-8 my-8">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            <img src="{{ $berita['image'] }}" alt="{{ $berita['title'] }}" class="w-full h-64 md:h-96 object-cover">
            
            <article class="p-6 md:p-10">
                <div class="mb-6 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-sdg-color">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('sdg.show', ['id' => $sdg_id]) }}" class="hover:text-sdg-color">SDG {{ $sdg_id }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-800 font-medium">Detail Berita</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                    {{ $berita['title'] }}
                </h1>
                
                <div class="flex items-center text-gray-600 text-sm mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span>Oleh {{ $berita['author'] }}</span>
                    </div>
                    <span class="mx-3">|</span>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ $berita['date'] }}</span>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-700">
                    {!! $berita['content'] !!}
                </div>

                 <div class="mt-12 pt-8 border-t border-gray-200">
                    <a href="{{ route('sdg.show', ['id' => $sdg_id]) }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white rounded-lg shadow transition-transform hover:-translate-y-1"
                       style="background-color: {{ $sdg['color'] }};">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Laman SDG {{ $sdg_id }}
                    </a>
                </div>
            </article>
        </div>
    </main>

</body>
    @include('layout.footer')
</html>