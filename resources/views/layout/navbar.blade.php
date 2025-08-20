@include('layout.loginpopup')

<!-- Desktop Navbar -->
{{-- This navbar is hidden on small screens (mobile) and becomes visible on medium screens (md) and larger. --}}
<nav class="navbar hidden md:block fixed top-0 w-full z-50 bg-[#186862] shadow-lg transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}">
                <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            </a>
            <div>
                <h1 class="text-white text-xl font-bold">Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h1>
                <p class="text-white text-sm">Universitas Negeri Jakarta</p>
            </div>
        </div>
        <ul class="flex items-center space-x-6 text-sm font-medium">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400 transition-colors">Beranda</a></li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors flex items-center">Profil <i class="fas fa-chevron-down ml-1 text-xs"></i></a>
                <ul class="absolute hidden group-hover:block bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-xl w-60">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block px-4 py-2 hover:bg-gray-100">Pimpinan Dit. ISIP</a></li>
                    <li><a href="{{ route('profile.profile') }}" class="block px-4 py-2 hover:bg-gray-100">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="block px-4 py-2 hover:bg-gray-100">Struktur Organisasi</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors flex items-center">Sub Direktorat <i class="fas fa-chevron-down ml-1 text-xs"></i></a>
                <ul class="absolute hidden group-hover:block bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-xl w-72">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block px-4 py-2 hover:bg-gray-100">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}" class="block px-4 py-2 hover:bg-gray-100">Subdirektorat Sistem Informasi dan Pemeringkatan</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400 transition-colors">Berita</a>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors flex items-center">Galeri <i class="fas fa-chevron-down ml-1 text-xs"></i></a>
                <ul class="absolute hidden group-hover:block bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-xl w-60">
                    <li><a href="{{ route('alumni') }}" class="block px-4 py-2 hover:bg-gray-100">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="block px-4 py-2 hover:bg-gray-100">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400 transition-colors">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400 transition-colors">SSO</a></li>
            <li><a class="login text-white bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-full transition-colors" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

<!-- Mobile Navbar -->
{{-- This navbar is visible only on small screens and hidden on medium screens and larger. --}}
<nav class="navbar block md:hidden fixed top-0 w-full z-50" id="mobile-navbar">
    <div class="bg-[#186862] shadow-lg">
        <div class="container mx-auto flex justify-between items-center py-3 px-4 h-16">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img alt="UNJ Logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
                <div class="text-white">
                    <h1 class="text-base font-bold leading-tight">DITISIP UNJ</h1>
                </div>
            </a>
            
            <button id="mobile-menu-toggle" class="text-white p-2 hover:bg-white/10 rounded-lg transition-colors focus:outline-none">
                <i id="menu-icon" class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar -->
{{-- The sidebar menu for mobile, toggled by the hamburger icon. --}}
<div id="mobile-sidebar" class="fixed top-0 right-0 w-72 h-full bg-[#186862] z-[100] transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto block md:hidden">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 border-b border-white/10 h-16">
        <span class="text-white font-bold text-lg">Menu</span>
        <button id="close-sidebar" class="p-2 text-white hover:bg-white/10 rounded-full transition-colors focus:outline-none">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <!-- Sidebar Menu -->
    <div class="py-2">
        <ul class="flex flex-col space-y-1">
            <li><a href="{{ route('home') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-home w-6 mr-2"></i><span>Beranda</span></a></li>
            
            <!-- Profil Dropdown -->
            <li class="sidebar-dropdown px-2">
                <button class="flex items-center justify-between w-full text-white py-3 px-2 hover:bg-white/10 rounded-md">
                    <div class="flex items-center"><i class="fas fa-user-tie w-6 mr-2"></i><span>Profil</span></div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                </button>
                <ul class="hidden bg-white/5 mt-1 rounded-md overflow-hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Pimpinan DITISIP</a></li>
                    <li><a href="{{ route('profile.profile') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Struktur Organisasi</a></li>
                </ul>
            </li>

            <!-- Sub Direktorat Dropdown -->
            <li class="sidebar-dropdown px-2">
                <button class="flex items-center justify-between w-full text-white py-3 px-2 hover:bg-white/10 rounded-md">
                    <div class="flex items-center"><i class="fas fa-sitemap w-6 mr-2"></i><span>Sub Direktorat</span></div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                </button>
                <ul class="hidden bg-white/5 mt-1 rounded-md overflow-hidden">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Pemeringkatan dan SI</a></li>
                </ul>
            </li>

            <li><a href="{{ route('Berita.beritahome') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-newspaper w-6 mr-2"></i><span>Berita</span></a></li>

            <!-- Galeri Dropdown -->
            <li class="sidebar-dropdown px-2">
                <button class="flex items-center justify-between w-full text-white py-3 px-2 hover:bg-white/10 rounded-md">
                    <div class="flex items-center"><i class="fas fa-images w-6 mr-2"></i><span>Galeri</span></div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                </button>
                <ul class="hidden bg-white/5 mt-1 rounded-md overflow-hidden">
                    <li><a href="{{ route('alumni') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Sustainability</a></li>
                </ul>
            </li>

            <li><a href="{{ route('document.document') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-file-alt w-6 mr-2"></i><span>Dokumen</span></a></li>
            <li><a href="https://sso.unj.ac.id/login" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-key w-6 mr-2"></i><span>SSO</span></a></li>
            <li><a href="#" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2 login" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt w-6 mr-2"></i><span>Masuk</span></a></li>
        </ul>
    </div>
</div>

<!-- Overlay for Mobile Sidebar -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out block md:hidden"></div>
