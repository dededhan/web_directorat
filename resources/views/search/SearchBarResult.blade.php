<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Hasil Pencarian') }} - {{ config('app.name') }}</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('berita.css') }}">
    <link rel="stylesheet" href="{{ asset('unj-navbar.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        :root {
            --primary-color: #186569;
            --primary-light: #2a7a7e;
            --primary-dark: #0d4b4f;
            --accent-color: #ffb74d;
            --text-color: #333333;
            --text-secondary: #555555;
            --background-color: #f8f9fa;
            --card-color: #ffffff;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        /* Preserve Font Awesome icon font family for navbar icons */
        .fas,
        .fab,
        .far,
        .fa,
        [class^="fa-"],
        [class*=" fa-"] {
            font-family: "Font Awesome 5 Free", "Font Awesome 5 Brands", "FontAwesome" !important;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    {{-- Include the responsive navbar --}}
    @include('layout.navbarSearch')

    {{-- A spacer div to push content below the fixed navbar. Height matches navbar height. --}}
    <div class="h-24"></div>

    <main>
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 py-12">
            <div class="container mx-auto px-4 max-w-4xl">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-slate-900 mb-2">{{ __('Hasil Pencarian') }}</h1>
                    <p class="text-lg text-slate-600">
                        {{ __('Mencari: ') }}
                    </p>
                    <p class="font-semibold text-blue-600 break-all"> "{{ $query }}"</p>
                </div>

                <!-- Search Box -->
                <div class="mb-8">
                    <form action="{{ route('search.index') }}" method="GET" class="flex gap-2">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}"
                            placeholder="{{ __('Cari berita, inovasi, program...') }}"
                            class="flex-1 px-4 py-3 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            autocomplete="off"
                            id="searchInput"
                        >
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                        >
                            {{ __('Cari') }}
                        </button>
                    </form>
                </div>

                <!-- Results Count -->
                @if (!$message)
                    <div class="mb-6 text-sm text-slate-600">
                        {{ __('Ditemukan') }} <span class="font-semibold text-slate-900">{{ $results->count() }}</span> {{ __('hasil') }}
                    </div>
                @endif

                <!-- Results or Empty State -->
                @if ($message)
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">{{ $message }}</h3>
                        <p class="text-slate-600 mb-6">{{ __('Coba gunakan kata kunci yang berbeda atau lebih spesifik.') }}</p>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                            {{ __('Kembali ke Beranda') }}
                        </a>
                    </div>
                @else
                    <!-- Results Grid -->
                    <div class="space-y-4">
                        @forelse ($results as $result)

                            @php
                                $isProgramLayanan = $result['type'] === 'Program dan Layanan';
                            @endphp

                            @if($isProgramLayanan)
                                <div class="block cursor-default">
                            @else
                                <a href="{{ $result['url'] }}" class="block">
                            @endif

                                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 sm:p-6">
                                    <div class="flex gap-4">

                                        <!-- Image -->
                                        @if ($result['image'])
                                            <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32 rounded-lg overflow-hidden bg-slate-200">
                                                <img 
                                                    src="{{ $result['image'] }}" 
                                                    alt="{{ $result['title'] }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            </div>
                                        @endif

                                        <!-- Content -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">

                                                <span class="text-sm">
                                                    {{ $result['type_icon'] }}
                                                </span>

                                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                                                    {{ $result['type'] }}
                                                </span>
                                            </div>

                                            <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2">
                                                {{ $result['title'] }}
                                            </h3>

                                            <p class="text-slate-600 text-sm mb-3 line-clamp-2">
                                                {{ $result['description'] }}
                                            </p>

                                            @if ($result['created_at'])
                                                <p class="text-xs text-slate-500">
                                                    {{ $result['created_at']->diffForHumans() ?? '' }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Arrow -->
                                        @if(!$isProgramLayanan)
                                            <div class="flex-shrink-0 flex items-center">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            @if($isProgramLayanan)
                                </div>
                            @else
                                </a>
                            @endif

                        @empty
                            <div class="bg-white rounded-lg shadow p-12 text-center">
                                <p class="text-slate-600">
                                    {{ __('Tidak ada hasil yang ditemukan.') }}
                                </p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('layout.footer')

    <!-- Autocomplete Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            let debounceTimer;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();
                
                if (query.length < 2) return;
                
                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('search.autocomplete') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            // You can enhance this with a suggestion dropdown
                            console.log('Suggestions:', data);
                        });
                }, 300);
            });
        }
    });
    </script>
</body>
</html>
