@include('layout.loginpopup')

{{-- NAVBAR DESKTOP --}}
<nav class="navbar hidden md:block fixed top-0 w-full z-50 bg-[#186862] shadow-md transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="{{ route('home') }}" class="flex items-center space-x-4">
            <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            <div>
                <h1 class="text-white text-xl font-bold">Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h1>
                <p class="text-white text-sm">Universitas Negeri Jakarta</p>
            </div>
        </a>
        <ul class="flex items-center space-x-6 text-white">
            <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition-colors">Beranda</a></li>
            <li class="relative group">
                <a href="#" class="hover:text-yellow-400 transition-colors">Profil</a>
                <ul class="absolute hidden group-hover:block bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-lg w-60">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block px-4 py-2 hover:bg-gray-100">Pimpinan Dit. ISIP</a></li>
                    <li><a href="{{ route('profile.profile') }}" class="block px-4 py-2 hover:bg-gray-100">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="block px-4 py-2 hover:bg-gray-100">Struktur Organisasi</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="hover:text-yellow-400 transition-colors">Sub Direktorat</a>
                <ul class="absolute hidden group-hover:block bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-lg w-72">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block px-4 py-2 hover:bg-gray-100">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}" class="block px-4 py-2 hover:bg-gray-100">Subdirektorat Sistem Informasi dan Pemeringkatan</a></li>
                </ul>
            </li>
            <li><a href="{{ route('Berita.beritahome') }}" class="hover:text-yellow-400 transition-colors">Berita</a></li>
             <li class="relative group">
                <a href="#" class="hover:text-yellow-400 transition-colors">Galeri</a>
                <ul class="absolute hidden group-hover:block bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-lg w-60">
                    <li><a href="{{ route('alumni') }}" class="block px-4 py-2 hover:bg-gray-100">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="block px-4 py-2 hover:bg-gray-100">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="{{ route('document.document') }}" class="hover:text-yellow-400 transition-colors">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" class="hover:text-yellow-400 transition-colors">SSO</a></li>
            <li><a href="#" class="login bg-yellow-400 text-teal-800 px-4 py-2 rounded-full font-semibold hover:bg-yellow-500 transition-colors" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

{{-- NAVBAR MOBILE --}}
<nav class="block md:hidden fixed top-0 w-full z-[1000] bg-[#186862] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-3 px-4">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <img alt="UNJ Logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            <div class="text-white">
                <h1 class="text-base font-bold leading-tight">DITISIP UNJ</h1>
            </div>
        </a>
        <button id="mobile-menu-toggle" class="text-white p-2 focus:outline-none">
            <i id="menu-icon" class="fas fa-bars text-xl"></i>
        </button>
    </div>
</nav>

{{-- SIDEBAR MOBILE --}}
<div id="mobile-sidebar" class="fixed top-0 right-0 w-72 h-full bg-[#186862] z-[1100] transform translate-x-full transition-transform duration-300 ease-in-out md:hidden">
    <div class="flex justify-between items-center p-4 border-b border-white/20">
        <span class="text-white font-bold">Menu</span>
        <button id="close-sidebar" class="text-white p-2 focus:outline-none"><i class="fas fa-times text-xl"></i></button>
    </div>
    <ul class="text-white p-4 space-y-2">
         <li><a href="{{ route('home') }}" class="block py-2 px-3 rounded-md hover:bg-white/20"><i class="fas fa-home w-6 mr-2"></i>Beranda</a></li>
        <li class="sidebar-dropdown">
            <button class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-white/20">
                <span><i class="fas fa-user-tie w-6 mr-2"></i>Profil</span>
                <i class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
            <ul class="hidden pl-8 pt-2 space-y-2">
                <li><a href="{{ route('pimpinan.pimpinan') }}" class="block">Pimpinan DITISIP</a></li>
                <li><a href="{{ route('profile.profile') }}" class="block">Tugas Pokok & Fungsi</a></li>
                <li><a href="{{ route('strukturorganisasi') }}" class="block">Struktur Organisasi</a></li>
            </ul>
        </li>
        <li class="sidebar-dropdown">
            <button class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-white/20">
                <span><i class="fas fa-sitemap w-6 mr-2"></i>Sub Direktorat</span>
                <i class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
            <ul class="hidden pl-8 pt-2 space-y-2">
                <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block">Inovasi & Hilirisasi</a></li>
                <li><a href="{{ route('pemeringkatan.landingpage') }}" class="block">Pemeringkatan & SI</a></li>
            </ul>
        </li>
        <li><a href="{{ route('Berita.beritahome') }}" class="block py-2 px-3 rounded-md hover:bg-white/20"><i class="fas fa-newspaper w-6 mr-2"></i>Berita</a></li>
        <li class="sidebar-dropdown">
             <button class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-white/20">
                <span><i class="fas fa-images w-6 mr-2"></i>Galeri</span>
                <i class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
            <ul class="hidden pl-8 pt-2 space-y-2">
                <li><a href="{{ route('alumni') }}">Alumni Berdampak</a></li>
                <li><a href="{{ route('galeri.sustainability') }}">Sustainability</a></li>
            </ul>
        </li>
        <li><a href="{{ route('document.document') }}" class="block py-2 px-3 rounded-md hover:bg-white/20"><i class="fas fa-file-alt w-6 mr-2"></i>Dokumen</a></li>
        <li><a href="https://sso.unj.ac.id/login" class="block py-2 px-3 rounded-md hover:bg-white/20"><i class="fas fa-key w-6 mr-2"></i>SSO</a></li>
        <li><a href="#" class="login block py-2 px-3 rounded-md hover:bg-white/20" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt w-6 mr-2"></i>Masuk</a></li>
    </ul>
</div>

{{-- OVERLAY untuk sidebar mobile --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[1050] hidden md:hidden"></div>

{{-- Spacer untuk konten agar tidak tertutup navbar fixed --}}
<div class="h-16 md:h-24"></div>
