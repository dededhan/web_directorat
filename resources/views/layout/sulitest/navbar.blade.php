{{-- Navbar khusus untuk halaman Sulitest --}}
<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">
            {{-- Logo & Title --}}
            <a href="{{ route('sulitest.page.index') }}" class="flex items-center space-x-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="Logo UNJ" class="h-10 sm:h-12 w-auto">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-800">SULITEST</h1>
                    <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">UNJ Sustainability Literacy Test</p>
                </div>
            </a>

            {{-- Navigation Links (Desktop) --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('sulitest.page.index') }}" class="text-gray-600 hover:text-teal-600 font-medium transition-colors">Beranda</a>
                <a href="#about" class="text-gray-600 hover:text-teal-600 font-medium transition-colors">Tentang Tes</a>
                <a href="{{ route('sulitest.login') }}" class="bg-teal-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-teal-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login Peserta
                </a>
            </div>

            {{-- Mobile Login Button --}}
            <div class="md:hidden">
                 <a href="{{ route('sulitest.login') }}" class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-teal-700 transition-colors shadow-sm text-sm">
                   Login
                </a>
            </div>
        </div>
    </div>
</nav>
