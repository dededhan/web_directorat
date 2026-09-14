<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Hackaton</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen bg-gray-100">
        <aside class="w-64 flex-shrink-0 bg-gray-900 text-gray-300" :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-transition x-cloak>
            <div class="h-16 flex items-center justify-center border-b border-gray-800">
                <i class="fas fa-lightbulb text-amber-400 text-2xl mr-3"></i>
                <span class="text-white text-lg font-semibold">Admin Hackaton</span>
            </div>
            <nav class="px-4 py-6 space-y-2">
                <a href="{{ route('admin_hackaton.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin_hackaton.dashboard') ? 'bg-amber-500 text-gray-900' : 'hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-home w-6 text-center"></i><span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('admin_hackaton.registrations.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin_hackaton.registrations.*') ? 'bg-amber-500 text-gray-900' : 'hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-user-clock w-6 text-center"></i><span class="ml-3">Pendaftaran</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-lg hover:bg-red-600 hover:text-white">
                        <i class="fas fa-sign-out-alt w-6 text-center"></i><span class="ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-800"><i class="fas fa-bars text-xl"></i></button>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:block text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <div class="w-9 h-9 rounded-full bg-amber-500 text-gray-900 flex items-center justify-center font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-6xl mx-auto">
                    @yield('contentadmin_hackaton')
                </div>
            </main>
        </div>
    </div>
    @if (session('success'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3500 });</script>
    @endif
    @if (session('error'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 3500 });</script>
    @endif
</body>
</html>
