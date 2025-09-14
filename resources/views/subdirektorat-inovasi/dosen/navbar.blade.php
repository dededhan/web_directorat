<header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white border-b border-gray-200 shadow-sm z-10 relative">
    <div class="flex items-center">
        <button @click="$dispatch('toggle-sidebar')" class="p-2 -ml-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500 lg:hidden">
            <span class="sr-only">Buka menu</span>
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <div class="relative hidden md:block ml-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class='bx bx-search-alt text-gray-500'></i>
            </span>
            <input type="text"
                   class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                   placeholder="Search...">
        </div>
    </div>

    <div class="flex items-center space-x-2 sm:space-x-4">
        <button class="p-2 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:bg-gray-100">
             <i class='bx bxs-bell text-xl'></i>
        </button>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none p-1 rounded-full focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                <img src="{{ auth()->user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name ?? 'GU').'&background=E2E8F0&color=4A5568' }}" alt="Profile" class="w-9 h-9 rounded-full object-cover">
                <div class="text-left hidden md:block">
                     <div class="font-semibold text-sm text-gray-800">{{ auth()->user()->name ?? 'Guest User' }}</div>
                     <div class="text-xs text-gray-500">Dosen</div>
                </div>
                <i class='bx bx-chevron-down text-gray-500 hidden sm:block'></i>
            </button>

            <div x-show="dropdownOpen" 
                 @click.away="dropdownOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 w-48 mt-2 py-1 bg-white border rounded-md shadow-xl z-20"
                 style="display: none;">
                
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-500 hover:text-white transition-colors">Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-500 hover:text-white transition-colors">Settings</a>
                
                <div class="border-t border-gray-100 my-1"></div>

                <form method="POST" action="{{ route('logout') }}" id="logout-form-dropdown">
                     @csrf
                     <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white transition-colors">
                         Logout
                     </a>
                </form>
            </div>
        </div>
    </div>
</header>