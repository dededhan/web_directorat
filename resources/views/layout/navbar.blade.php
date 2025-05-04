@include('layout.loginpopup')

<nav class="bg-teal-700 fixed w-full z-50">
    <!-- Desktop Navbar -->
    <div class="hidden md:block">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <!-- Logo and Site Title -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                             alt="UNJ Logo" 
                             class="h-12 w-auto mr-3">
                        <div class="text-white">
                            <h1 class="text-lg font-bold leading-tight">Direktorat Inovasi</h1>
                            <p class="text-sm">Universitas Negeri Jakarta</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-white hover:text-yellow-400 transition-colors">Beranda</a>
                    <a href="{{ route('Berita.index') }}" class="text-white hover:text-yellow-400 transition-colors">Berita</a>
                    <a href="{{ route('Galeri.index') }}" class="text-white hover:text-yellow-400 transition-colors">Galeri</a>
                    <a href="{{ route('login') }}" class="bg-yellow-400 text-teal-800 px-4 py-2 rounded-lg font-medium hover:bg-yellow-500 transition-colors">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navbar -->
    <div class="md:hidden">
        <div class="px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Mobile Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                         alt="UNJ Logo" 
                         class="h-10 w-auto mr-2">
                    <div class="text-white text-sm">
                        <h1 class="font-bold leading-tight">Direktorat Inovasi</h1>
                        <p class="text-xs">UNJ</p>
                    </div>
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden bg-teal-800">
            <div class="px-4 py-3 space-y-3">
                <a href="{{ route('home') }}" class="block text-white hover:bg-teal-600 px-3 py-2 rounded-lg">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="{{ route('Berita.index') }}" class="block text-white hover:bg-teal-600 px-3 py-2 rounded-lg">
                    <i class="fas fa-newspaper mr-2"></i>Berita
                </a>
                <a href="{{ route('Galeri.index') }}" class="block text-white hover:bg-teal-600 px-3 py-2 rounded-lg">
                    <i class="fas fa-images mr-2"></i>Galeri
                </a>
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="block bg-yellow-400 text-teal-800 px-3 py-2 rounded-lg font-medium text-center hover:bg-yellow-500 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Spacer to prevent content from hiding under fixed navbar -->
<div class="h-16 md:h-20"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', function() {
        // Toggle menu visibility
        const isMenuHidden = mobileMenu.classList.contains('hidden');
        
        // Toggle icon between bars and times
        mobileMenuButton.innerHTML = isMenuHidden 
            ? '<i class="fas fa-times text-2xl"></i>' 
            : '<i class="fas fa-bars text-2xl"></i>';

        // Toggle menu with animation
        if (isMenuHidden) {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('animate-fade-in');
        } else {
            mobileMenu.classList.add('animate-fade-out');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('animate-fade-out');
            }, 200);
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!mobileMenu.contains(event.target) && 
            !mobileMenuButton.contains(event.target) && 
            !mobileMenu.classList.contains('hidden')) {
            mobileMenuButton.click();
        }
    });
});
</script>

<style>
/* Animation classes */
.animate-fade-in {
    animation: fadeIn 0.2s ease-in-out;
}

.animate-fade-out {
    animation: fadeOut 0.2s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}
</style>