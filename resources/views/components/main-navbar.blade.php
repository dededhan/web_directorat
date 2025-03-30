{{-- 
    main-navbar.blade.php - Unified Navigation Bar Component for UNJ Portal
    
    Parameters:
    - $pageTitle: The title to display next to the logo (e.g., 'SUSTAINABILITY', 'ALUMNI IMPACT')
    - $currentPage: The name of the current page/section to highlight in the menu
    - $additionalLinks: Optional array of additional menu items in format:
      [
        ['url' => 'route path', 'text' => 'Link text', 'active' => boolean]
      ]
--}}

<div class="main-navbar-wrapper">
    <nav class="unj-navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="{{ route('home') }}" class="navbar-logo">
                    <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo UNJ">
                    <span class="navbar-title">{{ $pageTitle ?? 'UNJ Portal' }}</span>
                </a>
                
                <div class="navbar-links">
                    <ul class="navbar-menu">
                        <li><a href="{{ route('home') }}" class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                        @if(isset($currentPage))
                            <li><a href="#" class="menu-item active">{{ $currentPage }}</a></li>
                        @endif
                        @if(isset($additionalLinks) && count($additionalLinks) > 0)
                            @foreach($additionalLinks as $link)
                                <li><a href="{{ $link['url'] }}" class="menu-item {{ $link['active'] ? 'active' : '' }}">{{ $link['text'] }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                
                <div class="mobile-menu-button">
                    <button id="mobileMenuToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu (hidden by default) -->
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                @if(isset($currentPage))
                    <li><a href="#" class="active">{{ $currentPage }}</a></li>
                @endif
                @if(isset($additionalLinks) && count($additionalLinks) > 0)
                    @foreach($additionalLinks as $link)
                        <li><a href="{{ $link['url'] }}" class="{{ $link['active'] ? 'active' : '' }}">{{ $link['text'] }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('open');
                mobileMenuToggle.classList.toggle('active');
            });
        }
    });
</script>