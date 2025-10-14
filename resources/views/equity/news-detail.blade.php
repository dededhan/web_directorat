<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - Program EQUITY UNJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

    <style>
        .fas, .fab, .fa-solid, .fa-brands {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'serif': ['Lora', 'serif'],
                    },
                    colors: {
                        'brand': {
                            'dark': '#1A1A1A',
                            'light': '#F9F9F9',
                            'accent': '#B8860B',
                            'accent-light': '#D4AC0D',
                        }
                    }
                }
            }
        }
    </script>
</head>

@include('layout.loginpopup')
<body class="bg-white font-sans text-brand-dark antialiased">
    @include('layout.navbar')

    <main class="pt-20 md:pt-24">
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <a href="{{ route('equity') }}" class="inline-flex items-center text-brand-accent hover:text-brand-accent-light transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Program EQUITY
                </a>
            </div>

            <div class="mb-6">
                <span class="inline-block px-4 py-1 bg-{{ $news->gradient_color }}-100 text-{{ $news->gradient_color }}-800 rounded-full text-sm font-semibold mb-4">
                    {{ $news->category }}
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-brand-dark leading-tight">
                    {{ $news->title }}
                </h1>
                <div class="flex items-center mt-4 text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2"></i>
                    <time datetime="{{ $news->created_at->toIso8601String() }}">
                        {{ $news->created_at->format('d F Y') }}
                    </time>
                    <span class="mx-3">•</span>
                    <i class="fas fa-user mr-2"></i>
                    <span>{{ $news->user->name ?? 'Admin EQUITY' }}</span>
                </div>
            </div>

            <div class="mb-8">
                <img src="{{ asset('storage/' . $news->image) }}" 
                     alt="{{ $news->title }}" 
                     class="w-full h-auto rounded-2xl shadow-2xl">
            </div>

            @if($news->description)
            <div class="prose prose-lg max-w-none">
                <div class="text-gray-700 leading-relaxed text-justify">
                    {!! $news->description !!}
                </div>
            </div>
            @endif

            @if($relatedNews->count() > 0)
            <div class="mt-16">
                <h3 class="text-2xl font-serif font-bold mb-6">Berita Terkait</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedNews as $related)
                    <a href="{{ route('equity.news.show', $related->slug) }}" class="group block">
                        <div class="relative h-48 rounded-lg overflow-hidden mb-3">
                            <img src="{{ asset('storage/' . $related->image) }}" 
                                 alt="{{ $related->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 text-xs font-semibold rounded-full">
                                {{ $related->category }}
                            </span>
                        </div>
                        <h4 class="text-base font-bold text-brand-dark group-hover:text-brand-accent transition-colors line-clamp-2">
                            {{ $related->title }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </article>
    </main>

    @include('layout.footer')
</body>
</html>
