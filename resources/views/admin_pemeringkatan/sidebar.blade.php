<aside 
    class="flex-shrink-0 w-56 bg-gray-800 text-gray-300 flex flex-col transition-all duration-300"
    :class="{'-ml-56': !sidebarOpen}"
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    x-cloak>


    <div class="h-16 flex items-center justify-center bg-gray-900 shadow-md px-3">
        <i class="fas fa-chart-line text-teal-400 text-lg mr-2"></i>
        <span class="text-white text-sm font-semibold truncate">
            @if(Auth::check() && Auth::user()->isProdi())
                QS Campaign Prodi
            @elseif(Auth::check() && Auth::user()->isFakultas())
                QS Campaign Fakultas
            @else
                Admin Pemeringkatan
            @endif
        </span>
    </div>

    <nav class="flex-1 px-2.5 py-4 space-y-1 overflow-y-auto">
        @if(Auth::check() && !Auth::user()->isDirectorateAdmin())
            {{-- Non-directorate (Prodi & Fakultas): Only show QS Campaign --}}
            <div class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Menu Utama
            </div>
            <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" 
               class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('admin_pemeringkatan.qs-sessions.*') ? 'bg-teal-600 text-white shadow-xs' : 'hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-bullhorn fa-fw w-5 text-center text-teal-400 text-sm"></i>
                <span class="ml-2.5 font-medium truncate">QS Campaign (Sesi)</span>
            </a>
            <a href="{{ route('admin_pemeringkatan.reports.index') }}" 
               class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('admin_pemeringkatan.reports.*') ? 'bg-teal-600 text-white shadow-xs' : 'hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-chart-pie fa-fw w-5 text-center text-teal-400 text-sm"></i>
                <span class="ml-2.5 font-medium truncate">Laporan & Analitik</span>
            </a>
        @else
            {{-- Directorate Admin: Show all menus --}}
            <a href="{{ route('admin_pemeringkatan.dashboard') }}" 
               class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('admin_pemeringkatan.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-home fa-fw w-5 text-center text-sm"></i>
                <span class="ml-2.5 truncate">Dashboard</span>
            </a>
         {{-- Content Management / CMS Dropdown --}}
        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.berita.*') || 
                                 request()->routeIs('admin_pemeringkatan.alumni-berdampak.*') || 
                                 request()->routeIs('admin_pemeringkatan.kegiatan-sustainability.*') || 
                                 request()->routeIs('admin_pemeringkatan.mata-kuliah-sustainability.*') 
                                 ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none text-sm">
                <div class="flex items-center truncate">
                    <i class="fas fa-edit fa-fw w-5 text-center text-sm flex-shrink-0"></i>
                    <span class="ml-2.5 truncate">Content Management</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 ml-1" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 pl-5 space-y-1" x-cloak>
                <a href="{{ route('admin_pemeringkatan.berita.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.berita.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-newspaper fa-xs mr-1.5"></i>
                    Berita
                </a>
                
                <a href="{{ route('admin_pemeringkatan.alumni-berdampak.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.alumni-berdampak.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-user-graduate fa-xs mr-1.5"></i>
                    Alumni Berdampak
                </a>
                
                <a href="{{ route('admin_pemeringkatan.kegiatan-sustainability.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.kegiatan-sustainability.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-leaf fa-xs mr-1.5"></i>
                    Kegiatan Sustainability
                </a>
                
                <a href="{{ route('admin_pemeringkatan.mata-kuliah-sustainability.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.mata-kuliah-sustainability.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-book fa-xs mr-1.5"></i>
                    Mata Kuliah Sustainability
                </a>
            </div>
        </div>

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.sulitest_question_banks.*') || request()->routeIs('admin_pemeringkatan.sulitest_exams.*') || request()->routeIs('admin_pemeringkatan.peserta.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none text-sm">
                <div class="flex items-center truncate">
                    <i class="fas fa-folder-open fa-fw w-5 text-center text-sm flex-shrink-0"></i>
                    <span class="ml-2.5 truncate">Manajemen SULITEST</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 ml-1" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 pl-5 space-y-1" x-cloak>
                <a href="{{ route('admin_pemeringkatan.sulitest_exams.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.sulitest_exams.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Manajemen Ujian
                </a>
                
                <a href="{{ route('admin_pemeringkatan.sulitest_question_banks.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.sulitest_question_banks.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Bank Soal
                </a>

                <a href="{{ route('admin_pemeringkatan.peserta.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.peserta.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Manajemen Peserta
                </a>

                <a href="{{ route('admin_pemeringkatan.hasil.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.hasil.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Hasil & Analitik
                </a>
            </div>
        </div>

        {{-- QS Campaign & Responden Bank --}}
        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.qs-sessions.*') || request()->routeIs('admin_pemeringkatan.responden-bank.*') || request()->routeIs('admin_pemeringkatan.reports.*') || request()->routeIs('admin_pemeringkatan.email.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none text-sm">
                <div class="flex items-center truncate">
                    <i class="fas fa-bullhorn fa-fw w-5 text-center text-teal-400 text-sm flex-shrink-0"></i>
                    <span class="ml-2.5 font-medium truncate">QS Campaign (Sesi)</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 ml-1" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 pl-5 space-y-1" x-cloak>
                <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.qs-sessions.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-calendar-alt fa-xs mr-1.5"></i>
                    QS Sessions
                </a>
                <a href="{{ route('admin_pemeringkatan.responden-bank.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.responden-bank.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-database fa-xs mr-1.5"></i>
                    Responden Bank
                </a>
                <a href="{{ route('admin_pemeringkatan.reports.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.reports.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-chart-pie fa-xs mr-1.5"></i>
                    Laporan & Analitik
                </a>
                @if(Auth::user()->isDirectorateAdmin())
                <a href="{{ route('admin_pemeringkatan.email.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.email.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-envelope-open-text fa-xs mr-1.5"></i>
                    Email Templates
                </a>
                @endif
            </div>
        </div>

        {{-- Data Tables Dropdown --}}
        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.responden.*') || request()->routeIs('admin_pemeringkatan.qsresponden.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none text-sm">
                <div class="flex items-center truncate">
                    <i class="fas fa-table fa-fw w-5 text-center text-sm flex-shrink-0"></i>
                    <span class="ml-2.5 truncate">Data Tables</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 ml-1" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 pl-5 space-y-1" x-cloak>
                <a href="{{ route('admin_pemeringkatan.responden.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.responden.index') ? 'bg-teal-600 !text-white' : '' }}">
                    Calon Responden
                </a>
                
                <a href="{{ route('admin_pemeringkatan.qsresponden.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.qsresponden.*') ? 'bg-teal-600 !text-white' : '' }}">
                    QS Responden
                </a>

                <a href="{{ route('admin_pemeringkatan.responden.graph') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.responden.graph') ? 'bg-teal-600 !text-white' : '' }}">
                    Grafik Jawaban
                </a>

                <a href="{{ route('admin_pemeringkatan.responden.laporan') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.responden.laporan') ? 'bg-teal-600 !text-white' : '' }}">
                    Laporan Responden
                </a>
            </div>
        </div>

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.the-impact-cms.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none text-sm">
                <div class="flex items-center truncate">
                    <i class="fas fa-globe fa-fw w-5 text-center text-sm flex-shrink-0"></i>
                    <span class="ml-2.5 truncate">THE Impact</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 ml-1" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 pl-5 space-y-1" x-cloak>
                <a href="{{ route('admin_pemeringkatan.the-impact-cms.dashboard') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-700 hover:text-white truncate {{ request()->routeIs('admin_pemeringkatan.the-impact-cms.*') ? 'bg-teal-600 !text-white' : '' }}">
                    Manajemen Content
                </a>
            </div>
        </div>

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.data-akreditasi.*') || request()->routeIs('admin_pemeringkatan.mahasiswa-international.*') || request()->routeIs('admin_pemeringkatan.indikator.*') || request()->routeIs('admin_pemeringkatan.ranking.*') || request()->routeIs('admin_pemeringkatan.international-lecture.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none text-sm">
                <div class="flex items-center truncate">
                    <i class="fas fa-globe fa-fw w-5 text-center text-sm flex-shrink-0"></i>
                    <span class="ml-2.5 truncate">International</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 ml-1" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 pl-5 space-y-1" x-cloak>
              
                <a href="{{ route('admin_pemeringkatan.international-lecture.index') }}" 
                   onclick="try{sessionStorage.removeItem('intl_lecture_show_table')}catch(e){}"
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-600 hover:text-white transition-colors truncate {{ request()->routeIs('admin_pemeringkatan.international-lecture.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-chalkboard-teacher fa-xs mr-1.5"></i>
                    International Lecture
                </a>

                <a href="{{ route('admin_pemeringkatan.mahasiswa-international.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-600 hover:text-white transition-colors truncate {{ request()->routeIs('admin_pemeringkatan.mahasiswa-international.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-user-graduate fa-xs mr-1.5"></i>
                    Mahasiswa International
                </a>

                <a href="{{ route('admin_pemeringkatan.indikator.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-600 hover:text-white transition-colors truncate {{ request()->routeIs('admin_pemeringkatan.indikator.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-chart-line fa-xs mr-1.5"></i>
                    Indikator Pemeringkatan
                </a>

                <a href="{{ route('admin_pemeringkatan.ranking.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-600 hover:text-white transition-colors truncate {{ request()->routeIs('admin_pemeringkatan.ranking.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-trophy fa-xs mr-1.5"></i>
                    Ranking Pemeringkatan
                </a>

                <a href="{{ route('admin_pemeringkatan.data-akreditasi.index') }}" 
                   class="block px-3 py-1.5 text-xs rounded-lg hover:bg-gray-600 hover:text-white transition-colors truncate {{ request()->routeIs('admin_pemeringkatan.data-akreditasi.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-certificate fa-xs mr-1.5"></i>
                    Data Akreditasi
                </a>

                <a href="#" 
                   class="block px-3 py-1.5 text-xs rounded-lg text-gray-500 cursor-not-allowed truncate">
                    <i class="fas fa-clock fa-xs mr-1.5"></i>
                    Global Engagement
                </a>
            </div>
        </div>

        {{-- User Management --}}
        <a href="{{ route('admin_pemeringkatan.manageuser.index') }}" 
           class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('admin_pemeringkatan.manageuser.*') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-users fa-fw w-5 text-center text-sm"></i>
            <span class="ml-2.5 truncate">Manajemen User</span>
        </a>

        {{-- Manajemen Struktur Organisasi --}}
        <a href="{{ route('admin_pemeringkatan.structure-organization.index') }}" 
           class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('admin_pemeringkatan.structure-organization.*') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-project-diagram fa-fw w-5 text-center text-sm"></i>
            <span class="ml-2.5 truncate">Struktur Organisasi</span>
        </a>
        @endif
  
    </nav>

    <div class="p-3 border-t border-gray-700">
        @if(Auth::check())
            <div class="px-3 py-2 text-xs text-gray-300 bg-gray-900/80 rounded-xl mb-2.5 border border-gray-700/80">
                <div class="text-gray-400 uppercase text-[10px] font-bold tracking-wider">Unit / Tingkat:</div>
                <div class="text-teal-300 font-bold truncate mt-0.5 text-[11px] flex items-center gap-1.5">
                    <i class="fas fa-user-circle text-teal-400 text-xs"></i>
                    {{ Auth::user()->unit_label }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200 text-sm">
                <i class="fas fa-sign-out-alt fa-fw w-5 text-center text-sm"></i>
                <span class="ml-2.5">Logout</span>
            </button>
        </form>
    </div>
</aside>
