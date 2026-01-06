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
         {{-- Content Management / CMS Dropdown --}}
        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.berita.*') || 
                                 request()->routeIs('admin_pemeringkatan.alumni-berdampak.*') || 
                                 request()->routeIs('admin_pemeringkatan.kegiatan-sustainability.*') || 
                                 request()->routeIs('admin_pemeringkatan.mata-kuliah-sustainability.*') 
                                 ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-edit fa-fw w-6 text-center"></i>
                    <span class="ml-4">Content Management</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_pemeringkatan.berita.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.berita.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-newspaper fa-xs mr-2"></i>
                    Berita123
                </a>
                
                <a href="{{ route('admin_pemeringkatan.alumni-berdampak.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.alumni-berdampak.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-user-graduate fa-xs mr-2"></i>
                    Alumni Berdampak
                </a>
                
                <a href="{{ route('admin_pemeringkatan.kegiatan-sustainability.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.kegiatan-sustainability.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-leaf fa-xs mr-2"></i>
                    Kegiatan Sustainability
                </a>
                
                <a href="{{ route('admin_pemeringkatan.mata-kuliah-sustainability.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.mata-kuliah-sustainability.*') ? 'bg-teal-600 !text-white' : '' }}">
                    <i class="fas fa-book fa-xs mr-2"></i>
                    Mata Kuliah Sustainability
                </a>
            </div>
        </div>

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
          {{-- Data Tables Dropdown --}}
        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.responden.*') || request()->routeIs('admin_pemeringkatan.qsresponden.*') || request()->routeIs('admin_pemeringkatan.email.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-table fa-fw w-6 text-center"></i>
                    <span class="ml-4">Data Tables</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_pemeringkatan.responden.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.responden.index') ? 'bg-teal-600 !text-white' : '' }}">
                    Responden
                </a>
                
                <a href="{{ route('admin_pemeringkatan.qsresponden.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.qsresponden.*') ? 'bg-teal-600 !text-white' : '' }}">
                    QS Responden
                </a>


                <a href="{{ route('admin_pemeringkatan.responden.graph') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.responden.graph') ? 'bg-teal-600 !text-white' : '' }}">
                    Grafik Jawaban
                </a>

                <a href="{{ route('admin_pemeringkatan.responden.laporan') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin_pemeringkatan.responden.laporan') ? 'bg-teal-600 !text-white' : '' }}">
                    Laporan Responden
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

      

        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.data-akreditasi.*') || request()->routeIs('admin_pemeringkatan.mahasiswa-international.*') || request()->routeIs('admin_pemeringkatan.indikator.*') || request()->routeIs('admin_pemeringkatan.ranking.*') || request()->routeIs('admin_pemeringkatan.international-lecture.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-globe fa-fw w-6 text-center"></i>
                    <span class="ml-4">International</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
              
                <a href="{{ route('admin_pemeringkatan.data-akreditasi.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-600 hover:text-white transition-colors {{ request()->routeIs('admin_pemeringkatan.data-akreditasi.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-certificate fa-xs mr-2"></i>
                    Data Akreditasi
                </a>

                <a href="{{ route('admin_pemeringkatan.mahasiswa-international.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-600 hover:text-white transition-colors {{ request()->routeIs('admin_pemeringkatan.mahasiswa-international.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-user-graduate fa-xs mr-2"></i>
                    Mahasiswa International
                </a>

                <a href="{{ route('admin_pemeringkatan.indikator.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-600 hover:text-white transition-colors {{ request()->routeIs('admin_pemeringkatan.indikator.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-chart-line fa-xs mr-2"></i>
                    Indikator Pemeringkatan
                </a>

                <a href="{{ route('admin_pemeringkatan.ranking.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-600 hover:text-white transition-colors {{ request()->routeIs('admin_pemeringkatan.ranking.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-trophy fa-xs mr-2"></i>
                    Ranking Pemeringkatan
                </a>

                <a href="{{ route('admin_pemeringkatan.international-lecture.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg hover:bg-gray-600 hover:text-white transition-colors {{ request()->routeIs('admin_pemeringkatan.international-lecture.*') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="fas fa-chalkboard-teacher fa-xs mr-2"></i>
                    International Lecture
                </a>

                <a href="#" 
                   class="block px-4 py-2 text-sm rounded-lg text-gray-500 cursor-not-allowed">
                    <i class="fas fa-clock fa-xs mr-1"></i>
                    Global Engagement
                </a>
            </div>
        </div>

        {{-- Lecture Staff International Dropdown --}}
        <div x-data="{ open: {{ request()->routeIs('admin_pemeringkatan.international-faculty-staff.*') || request()->routeIs('admin_pemeringkatan.international-faculty-activities.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none {{ request()->routeIs('admin_pemeringkatan.international-faculty-staff.*') || request()->routeIs('admin_pemeringkatan.international-faculty-activities.*') ? 'bg-gray-700 text-white' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-user-graduate fa-fw w-6 text-center"></i>
                    <span class="ml-4">Lecture Staff</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_pemeringkatan.international-faculty-staff.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin_pemeringkatan.international-faculty-staff.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-gray-700 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-user-tie fa-xs mr-2"></i>
                    Faculty Staff Profile
                </a>
                
                <a href="{{ route('admin_pemeringkatan.international-faculty-activities.index') }}" 
                   class="block px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin_pemeringkatan.international-faculty-activities.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-gray-700 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-newspaper fa-xs mr-2"></i>
                    Faculty Activities
                </a>
            </div>
        </div>

        {{-- User Management --}}
        <a href="{{ route('admin_pemeringkatan.manageuser.index') }}" 
           class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin_pemeringkatan.manageuser.*') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-users fa-fw w-6 text-center"></i>
            <span class="ml-4">Manajemen User</span>
        </a>

       

        {{-- Settings --}}
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

