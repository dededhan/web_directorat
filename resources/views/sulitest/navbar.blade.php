<header class="h-16 bg-white shadow-md flex items-center justify-between px-6">
    <!-- Sidebar Toggle Button -->
    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
        <i class="fas fa-bars text-xl"></i>
    </button>
    
    <div class="flex-1">
        <h1 class="text-lg font-semibold text-gray-700 hidden sm:block">Dashboard Peserta</h1>
    </div>

    <!-- Profile Dropdown -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
            <span class="text-gray-700 font-medium hidden md:block">{{ auth()->user()->name ?? 'Peserta' }}</span>
            <img src="{{ auth()->user()->avatar ?? 'https://placehold.co/40x40/E2E8F0/4A5568?text=P' }}" alt="avatar" class="h-10 w-10 rounded-full object-cover">
        </button>

        <div x-show="open" @click.away="open = false" 
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 py-1"
             x-transition
             x-cloak>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
            <form method="POST" action="{{ route('sulitest.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
