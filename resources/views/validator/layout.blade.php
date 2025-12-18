<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"
        type="image/png">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <title>@yield('title', 'Validator V2 - KATSINOV')</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div x-data="{ appState: { isSubmitting: false } }" x-init="window.Alpine.store('appState', appState)" class="flex h-screen overflow-hidden">
        @include('validator.sidebar')

        <div class="flex flex-1 flex-col overflow-hidden">
            <nav class="bg-white shadow-sm border-b px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-800">KATSINOV Validator V2</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                <i class='bx bx-log-out'></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="flex-1 overflow-y-auto p-6">
                @yield('contentvalidator')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
