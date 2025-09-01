<aside 
    class="flex-shrink-0 w-64 bg-slate-800 text-gray-300 flex flex-col transition-all duration-300"
    :class="{'-ml-64': !sidebarOpen}"
    x-show="sidebarOpen"
    x-cloak>

    <div class="h-16 flex items-center justify-center bg-slate-900 shadow-md">
        <i class="fas fa-feather-alt text-white text-2xl mr-3"></i>
        <span class="text-white text-lg font-semibold">SULITEST</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('sulitest.dashboard') }}" 
           class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('sulitest.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
            <i class="fas fa-home fa-fw w-6 text-center"></i>
            <span class="ml-4">Dashboard</span>
        </a>
        
        <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-history fa-fw w-6 text-center"></i>
            <span class="ml-4">Riwayat Tes</span>
        </a>

        <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-user-circle fa-fw w-6 text-center"></i>
            <span class="ml-4">Pengaturan Akun</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-700">
        <form method="POST" action="{{ route('sulitest.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200">
                <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                <span class="ml-4">Logout</span>
            </button>
        </form>
    </div>
</aside>
