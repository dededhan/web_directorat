<header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
    <!-- Search Bar -->
    <div class="flex items-center">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class='bx bx-search-alt text-gray-500'></i>
            </span>
            <input type="text"
                   class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                   placeholder="Search...">
        </div>
    </div>

    <!-- Profile Info -->
    <div class="flex items-center space-x-4">
        <button class="p-2 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:bg-gray-100">
             <i class='bx bxs-bell text-xl'></i>
        </button>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                <img src="{{ auth()->user()->profile_picture ?? 'https://placehold.co/40x40/E2E8F0/4A5568?text=A' }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                <div class="text-left hidden md:block">
                     <div class="font-semibold text-sm text-gray-800">{{ auth()->user()->name ?? 'Guest User' }}</div>
                     <div class="text-xs text-gray-500">Dosen</div>
                </div>
                <i class='bx bx-chevron-down text-gray-500'></i>
            </button>

            <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                 class="absolute right-0 w-48 mt-2 py-2 bg-white border rounded-md shadow-xl z-20"
                 x-transition>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-500 hover:text-white">Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-500 hover:text-white">Settings</a>
                <form method="POST" action="{{ route('logout') }}" id="logout-form-dropdown">
                     @csrf
                     <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-teal-500 hover:text-white">
                         Logout
                     </a>
                </form>
            </div>
        </div>
    </div>
</header>
