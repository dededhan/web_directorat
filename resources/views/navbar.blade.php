<div class="social-media-bar py-2">
    <div class="container mx-auto px-6 flex justify-start space-x-4">
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-youtube"></i>
        </a>
    </div>
</div>
@include('loginpopup')
<nav class="navbar">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            <h1 class="text-white text-2xl font-bold">UNIVERSITAS NEGERI JAKARTA</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="#" class="text-white hover:text-yellow-400">Beranda</a></li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Sub Direktorat</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('inovasi.landingpage') }}" class="hover:text-yellow-400">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}" class="hover:text-yellow-400">Subdirektorat Pemeringkatan dan Sistem Informasi</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Profil</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="#" class="hover:text-yellow-400">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksi.tupoksi') }}" class="hover:text-yellow-400">Tugas Pokok dan Fungsi</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Berita</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="#" class="hover:text-yellow-400">Program</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Program</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Galeri</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('alumni') }}" class="hover:text-yellow-400">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="hover:text-yellow-400">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="#" class="text-white hover:text-yellow-400">Portal</a></li>
            <li><a class="login" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>