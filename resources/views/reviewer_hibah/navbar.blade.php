<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
                <div class="ml-4 lg:ml-0">
                    <h1 class="text-xl font-bold text-gray-800">Reviewer Hibah Modul Ajar</h1>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center space-x-2 px-3 py-2 bg-purple-50 rounded-lg">
                    <i class='bx bx-calendar text-purple-600'></i>
                    <span class="text-sm font-medium text-purple-700">{{ now()->translatedFormat('d F Y') }}</span>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class='bx bx-user-circle text-2xl'></i>
                        <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                        <i class='bx bx-chevron-down text-sm'></i>
                    </button>

                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-200"
                         style="display: none;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center space-x-2">
                                <i class='bx bx-log-out'></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
