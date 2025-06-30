<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              inter: ['Inter', 'sans-serif'],
            },
            colors: {
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
        .prose p {
            margin-bottom: 1.25rem;
            line-height: 1.75;
            color: #374151;
        }
    </style>
</head>
<body class="bg-gray-100">

    <header style="background-color: {{ $sdg['color'] }};" class="text-white relative">
        <!-- <div class="absolute top-6 left-6 z-20">
            <a href="{{ route('sdg.show', ['id' => $sdg_id]) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 font-semibold text-white rounded-full shadow-lg border border-white/30 bg-blue-600 hover:bg-blue-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/60"
               style="background-color: #2563eb;">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Kembali ke Laman SDG {{ $sdg_id }}</span>
                <span class="inline sm:hidden">Kembali</span>
            </a>
        </div> -->
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

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            <div class="lg:col-span-8">
                
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
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
                        
                        <div class="flex flex-wrap items-center text-gray-600 text-sm mb-8 gap-x-4 gap-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle mr-2"></i>
                                <span>Oleh {{ $berita['author'] }}</span>
                            </div>
                            <span class="hidden md:inline">|</span>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ $berita['date'] }}</span>
                            </div>
                        </div>
        
                        <div class="prose max-w-none">
                            {!! $berita['content'] !!}
                        </div>
                    </article>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 mt-8 lg:mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">
                        Komentar
                    </h2>
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-2xl text-gray-500"></i>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <p class="font-semibold text-gray-900">Anda</p>
                                    <p class="text-xs text-gray-500">29 Juni 2025</p>
                                </div>
                                <p class="text-gray-700 mt-1">
                                    Inisiatif yang sangat bagus dari UNJ! Program seperti ini sangat dibutuhkan masyarakat untuk meningkatkan kemandirian ekonomi. Sangat relevan dengan SDG.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 mt-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Tinggalkan Komentar</h2>
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-6">
                            <textarea id="comment" name="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis komentar Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all hover:opacity-90 hover:-translate-y-1" style="background-color: {{ $sdg['color'] }};">
                            Kirim Komentar
                        </button>
                    </form>
                </div>

            </div>

            <aside class="lg:col-span-4 space-y-8 lg:sticky lg:top-8 self-start">
                
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-5 border-b border-gray-200 pb-4">
                        Berita Terkait Lainnya
                    </h3>
                    <div class="space-y-5">
                        @forelse ($related_berita as $related)
                            {{-- PERBAIKAN: Menggunakan nama route 'sdg.berita.show' agar konsisten --}}
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => $related['sdg_id'], 'slug' => $related['slug']]) }}" class="block group">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $related['image'] }}" alt="Gambar thumbnail untuk {{ $related['title'] }}" class="w-24 h-20 object-cover rounded-lg flex-shrink-0">
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-base text-gray-800 group-hover:text-sdg-color transition-colors leading-tight">
                                            {{ \Illuminate\Support\Str::limit($related['title'], 60) }}
                                        </h4>
                                        <p class="text-sm text-gray-500 mt-2">
                                            <i class="fas fa-calendar-alt mr-1.5 opacity-75"></i>
                                            {{ $related['date'] }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-sm">Tidak ada berita terkait lainnya.</p>
                        @endforelse
                    </div>
                </div>

            </aside>

        </div>
    </main>

    @include('layout.footer')
</body>
</html>
