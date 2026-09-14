<header class="flex h-16 flex-shrink-0 items-center justify-between bg-white px-6 shadow-md">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen" type="button"
            class="text-gray-500 transition hover:text-gray-800 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <span class="hidden items-center rounded-full border border-amber-200 bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 sm:inline-flex">
            <i class="fas fa-lightbulb mr-1.5"></i> Hackaton Panel
        </span>
    </div>

    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" type="button" class="flex items-center space-x-3 focus:outline-none">
            <span class="hidden font-medium text-gray-700 md:block">{{ auth()->user()->name ?? 'Admin' }}</span>
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 font-bold text-gray-900">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </button>

        <div x-show="open" @click.away="open = false"
            class="absolute right-0 z-20 mt-2 w-48 rounded-md bg-white py-1 shadow-xl" x-transition x-cloak>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>
