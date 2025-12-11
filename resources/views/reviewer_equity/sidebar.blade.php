<div x-data="{
        open: true,
        mobileOpen: false,
        equityOpen: {{ request()->routeIs('reviewer_equity.comdev.*') ? 'true' : 'false' }},
        hibahOpen: {{ request()->routeIs('reviewer_equity.hibah_modul.*') ? 'true' : 'false' }},
        studentExchangeOpen: {{ request()->routeIs('reviewer_equity.student_exchange.*') ? 'true' : 'false' }}
     }"
     @window.toggle-sidebar.document="mobileOpen = !mobileOpen">

    <div x-show="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" style="display: none;"></div>

    <div class="fixed inset-y-0 left-0 z-30 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none"
         :class="{
             '-translate-x-full': !mobileOpen,
             'translate-x-0': mobileOpen,
             'w-64': open,
             'w-20': !open
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-4">
            <a href="#" class="flex items-center space-x-2 overflow-hidden" x-show="open">
                <i class='bx bxs-user-check text-3xl text-teal-400'></i>
                <span class="whitespace-nowrap text-lg font-bold">Reviewer UNJ</span>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <button @click="mobileOpen = false" class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto py-4 px-2">

            <div>
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('reviewer_equity.dashboard') }}"
                   class="flex items-center space-x-3 rounded-md p-2 transition-colors duration-200 {{ request()->routeIs('reviewer_equity.dashboard') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-dashboard text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Dashboard</span>
                </a>
            </div>

            {{-- Community Development Section - Hanya untuk reviewer_equity --}}
            @if(auth()->user()->role === 'reviewer_equity')
            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Community Development</h3>
                <button @click="equityOpen = !equityOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <i class='bx bxs-briefcase-alt-2 text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Comdev</span>
                    </div>
                    <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': equityOpen}"></i>
                </button>
                <div x-show="equityOpen" x-collapse class="pt-1 pl-5" style="display: none;">
                    <a href="{{ route('reviewer_equity.comdev.assignments.index') }}"
                       class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('reviewer_equity.comdev.*') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                        <i class='bx bxs-folder-open text-lg'></i>
                        <span x-show="open">Daftar Proposal</span>
                    </a>
                </div>
            </div>
            @endif

            {{-- Hibah Modul Section - Hanya untuk reviewer_hibah --}}
            @if(auth()->user()->role === 'reviewer_hibah')
            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Hibah Modul Ajar</h3>
                <button @click="hibahOpen = !hibahOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <i class='bx bxs-book-content text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Hibah Modul</span>
                    </div>
                    <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': hibahOpen}"></i>
                </button>
                <div x-show="hibahOpen" x-collapse class="pt-1 pl-5" style="display: none;">
                    <a href="{{ route('reviewer_equity.hibah_modul.index') }}"
                       class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('reviewer_equity.hibah_modul.*') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                        <i class='bx bx-task text-lg'></i>
                        <span x-show="open">Daftar Review</span>
                    </a>
                </div>
            </div>
            @endif

            {{-- Student Exchange Section - Hanya untuk reviewer_student_exchange --}}
            @if(auth()->user()->role === 'reviewer_student_exchange')
            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Student Exchange</h3>
                <button @click="studentExchangeOpen = !studentExchangeOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <i class='bx bxs-plane-alt text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Student Exchange</span>
                    </div>
                    <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': studentExchangeOpen}"></i>
                </button>
                <div x-show="studentExchangeOpen" x-collapse class="pt-1 pl-5" style="display: none;">
                    <a href="{{ route('reviewer_equity.student_exchange.index') }}"
                       class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('reviewer_equity.student_exchange.*') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                        <i class='bx bx-list-ul text-lg'></i>
                        <span x-show="open">Daftar Review</span>
                    </a>
                </div>
            </div>
            @endif

        </nav>

        <div class="border-t border-gray-700 py-2 px-2">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-red-600 hover:text-white">
                    <i class='bx bxs-log-out-circle text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>

