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
        <i class="fas  text-white text-2xl mr-3"></i>
        <span class="text-white text-lg font-semibold">Admin Pemeringkatan</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('admin_pemeringkatan.dashboard') }}" 
           class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin_pemeringkatan.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-home fa-fw w-6 text-center"></i>
            <span class="ml-4">Dashboard</span>
        </a>

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.sulitest_question_banks.*') || request()->routeIs('admin_pemeringkatan.sulitest_exams.*') || request()->routeIs('admin_pemeringkatan.peserta.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-folder-open fa-fw w-6 text-center"></i>
                    <span class="ml-4">Manajemen SULITEST</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_pemeringkatan.sulitest_exams.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.sulitest_exams.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Manajemen Ujian
                </a>
                
                <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.sulitest_question_banks.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Bank Soal
                </a>

                <a href="{{ route('admin_pemeringkatan.peserta.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.peserta.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Manajemen Peserta
                </a>

                <a href="{{ route('admin_pemeringkatan.hasil.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.hasil.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Hasil & Analitik
                </a>
            </div>
        </div>


        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.the-impact-cms.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-globe fa-fw w-6 text-center"></i>
                    <span class="ml-4">THE Impact</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-1" x-cloak>
                <a href="{{ route('admin_pemeringkatan.the-impact-cms.dashboard') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.the-impact-cms.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Manajemen Content
                </a>
                
            </div>
        </div>

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.responden.*') || request()->routeIs('admin_pemeringkatan.qsresponden.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-users fa-fw w-6 text-center"></i>
                    <span class="ml-4">QS Responden</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_pemeringkatan.responden.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.responden.index') ? 'bg-teal-600 !text-white' : '' }}">
                    Input Responden
                </a>
                
                <a href="{{ route('admin_pemeringkatan.qsresponden.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.qsresponden.*') ? 'bg-teal-600 !text-white' : '' }}">
                    QS Survey Responden
                </a>

                <a href="{{ route('admin_pemeringkatan.responden.graph') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.responden.graph') ? 'bg-teal-600 !text-white' : '' }}">
                    Grafik Responden
                </a>

                <a href="{{ route('admin_pemeringkatan.responden.laporan') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.responden.laporan') ? 'bg-teal-600 !text-white' : '' }}">
                    Laporan Responden
                </a>
            </div>
        </div>

        
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

