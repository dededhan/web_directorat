<aside 
    class="flex-shrink-0 w-64 bg-gray-800 text-gray-300 flex flex-col transition-all duration-300"
    :class="{'-ml-64': !sidebarOpen}"
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    x-cloak>


    <div class="h-16 flex items-center justify-center bg-gray-900 shadow-md">
        <i class="fas fa-feather-alt text-white text-2xl mr-3"></i>
        <span class="text-white text-lg font-semibold">Admin Pemeringkatan</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('admin_pemeringkatan.dashboard') }}" 
           class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin_pemeringkatan.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-home fa-fw w-6 text-center"></i>
            <span class="ml-4">Dashboard</span>
        </a>

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.question_banks.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-folder-open fa-fw w-6 text-center"></i>
                    <span class="ml-4">Manajemen Tes</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="#" class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white">Daftar Tes</a>
                
                <a href="{{ route('admin_pemeringkatan.question_banks.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.question_banks.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Bank Soal
                </a>
            </div>
        </div>

        <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-chart-line fa-fw w-6 text-center"></i>
            <span class="ml-4">Hasil & Analitik</span>
        </a>
        
        <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-cog fa-fw w-6 text-center"></i>
            <span class="ml-4">Pengaturan</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200">
                <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                <span class="ml-4">Logout</span>
            </button>
        </form>
    </div>
</aside>

