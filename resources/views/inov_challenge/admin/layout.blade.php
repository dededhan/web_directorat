<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Innovation Challenge Admin')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.js"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"
        type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/js/app.js'])

    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-50">
        @include('inov_challenge.admin.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Top Navbar -->
            <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Innovation Challenge')</h1>
                        <p class="text-sm text-gray-600 mt-1">@yield('page-description', '')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class='bx bx-bell text-2xl'></i>
                            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-3 border-l pl-4">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-500">Admin</p>
                            </div>
                            <div
                                class="h-10 w-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm"
                        role="alert">
                        <div class="flex items-center">
                            <i class='bx bx-check-circle text-2xl mr-3'></i>
                            <div>
                                <p class="font-semibold">Success!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-green-700 hover:text-green-900">
                                <i class='bx bx-x text-2xl'></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm"
                        role="alert">
                        <div class="flex items-center">
                            <i class='bx bx-error-circle text-2xl mr-3'></i>
                            <div>
                                <p class="font-semibold">Error!</p>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-red-700 hover:text-red-900">
                                <i class='bx bx-x text-2xl'></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm"
                        role="alert">
                        <div class="flex items-center">
                            <i class='bx bx-info-circle text-2xl mr-3'></i>
                            <div>
                                <p class="font-semibold">Info</p>
                                <p class="text-sm">{{ session('info') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-blue-700 hover:text-blue-900">
                                <i class='bx bx-x text-2xl'></i>
                            </button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>

</html>
