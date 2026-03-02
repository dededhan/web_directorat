<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reviewer - Innovation Challenge</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"
        type="image/png">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #a8a8a8;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    @stack('styles')
</head>

<body class="h-full">

    <div class="flex h-full bg-gray-100">
        @include('reviewer_inovchalenge.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Navbar --}}
            <header
                class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white border-b border-gray-200 shadow-sm z-10 relative">
                <div class="flex items-center">
                    <button @click="$dispatch('toggle-sidebar')"
                        class="p-2 -ml-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:outline-none lg:hidden">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                    <div class="ml-4 flex items-center gap-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-cyan-100 text-cyan-700">
                            <i class="fas fa-star mr-1 text-[9px]"></i> REVIEWER
                        </span>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center space-x-2 focus:outline-none p-1 rounded-full focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                            <img src="{{ auth()->user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'GU') . '&background=E2E8F0&color=4A5568' }}"
                                alt="Profile" class="w-9 h-9 rounded-full object-cover">
                            <div class="text-left hidden md:block">
                                <div class="font-semibold text-sm text-gray-800">{{ auth()->user()->name ?? 'Guest' }}
                                </div>
                                <div class="text-xs text-cyan-600 font-medium">Reviewer</div>
                            </div>
                            <i class='bx bx-chevron-down text-gray-500 hidden sm:block'></i>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                            class="absolute right-0 w-48 mt-2 py-1 bg-white border rounded-md shadow-xl z-20"
                            style="display: none;">
                            <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-500 hover:text-white transition-colors">
                                <i class="fas fa-arrow-left mr-1.5 text-xs"></i> Dashboard Dosen
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white transition-colors">
                                    <i class="fas fa-sign-out-alt mr-1.5 text-xs"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
