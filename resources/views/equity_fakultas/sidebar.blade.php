<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        visitingProfessorOpen: false,
        jointSupervisionOpen: false,
        employerMeetingOpen: false,
        init() {
            this.$watch('mobileOpen', value => {
                if (value) { document.body.style.overflow = 'hidden'; } 
                else { document.body.style.overflow = ''; }
            });
            window.toggleSidebar = () => { this.mobileOpen = !this.mobileOpen; };
        },
        toggleMobile() { this.mobileOpen = !this.mobileOpen; }
    }"
    @resize.window="open = window.innerWidth >= 1024"
    @toggle-sidebar.window="mobileOpen = !this.mobileOpen"
    @keydown.escape.window="toggleMobile()"
    class="relative">

    <button type="button" 
            @click="toggleMobile()"
            x-show="!mobileOpen"
            class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-md p-2 text-gray-600 bg-white shadow-lg hover:bg-gray-100 focus:outline-none lg:hidden">
        <span class="sr-only">Buka menu</span>
        <i class='bx bx-menu text-xl'></i>
    </button>

    <div x-show="mobileOpen" 
         @click="toggleMobile()"
         x-transition
         class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
         style="display: none;"></div>

    <div x-show="mobileOpen || window.innerWidth >= 1024"
         class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30"
         :class="{
             '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <i class='bx bxs-graduation text-2xl text-teal-400'></i>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Fakultas UNJ</span>
                    <span class="text-xs text-gray-400">Academic System</span>
                </div>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 lg:block"><i class='bx bx-menu text-2xl'></i></button>
            <button @click="toggleMobile()" class="rounded-md p-2 hover:bg-gray-700 lg:hidden"><i class='bx bx-x text-2xl'></i></button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">
            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('equity_fakultas.dashboard') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors {{ request()->routeIs('equity_fakultas.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>
            
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Program</h3>
                
                {{-- Menu 1: Visiting Proffesor --}}
                <button @click="visitingProfessorOpen = !visitingProfessorOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-user-voice text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Visiting Proffesor</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': visitingProfessorOpen}"></i>
                    </div>
                </button>
                <div x-show="visitingProfessorOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('equity_fakultas.visiting-professors.index') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors hover:bg-gray-700 ml-4">
    <i class='bx bxs-folder-open text-2xl flex-shrink-0'></i>
    <span>Manajemen</span>
</a>
<a href="{{ route('equity_fakultas.visiting-professors.create') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors hover:bg-gray-700 ml-4">
    <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
    <span>Pengusulan</span>
</a>
                </div>

                {{-- Menu 2: Joint Supervision --}}
                <button @click="jointSupervisionOpen = !jointSupervisionOpen" 
                        class="mt-2 flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-group text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Joint Supervision</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': jointSupervisionOpen}"></i>
                    </div>
                </button>
                <div x-show="jointSupervisionOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                      <a href="{{ route('equity_fakultas.joint-supervision.index') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors hover:bg-gray-700 ml-4">
        <i class='bx bxs-folder-open text-2xl flex-shrink-0'></i>
        <span>Manajemen</span>
    </a>
    {{-- GANTI INI --}}
    <a href="{{ route('equity_fakultas.joint-supervision.create') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors hover:bg-gray-700 ml-4">
        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
        <span>Pengusulan</span>
    </a>
                </div>

                {{-- Menu 3: Employer Meeting --}}
                <button @click="employerMeetingOpen = !employerMeetingOpen" 
                        class="mt-2 flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-business text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Employer Meeting</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': employerMeetingOpen}"></i>
                    </div>
                </button>
                <div x-show="employerMeetingOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('equity_fakultas.employer-meetings.index') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors hover:bg-gray-700 ml-4">
        <i class='bx bxs-folder-open text-2xl flex-shrink-0'></i>
        <span>Manajemen</span>
    </a>
    {{-- GANTI INI --}}
    <a href="{{ route('equity_fakultas.employer-meetings.create') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors hover:bg-gray-700 ml-4">
        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
        <span>Pengusulan</span>
                </div>
            </div>
            
        </nav>

        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center space-x-4 rounded-lg p-3 transition-colors hover:bg-red-600 hover:text-white" :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-log-out-circle text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>

