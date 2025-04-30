<nav>
    <!-- All content moved to right side -->
    <div class="navbar-right">
        <!-- User Profile Section -->
        @auth
        <div class="profile-info">
            <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
        @endauth
        
        @guest
        <div class="profile-info">
            <span class="user-name">Guest</span>
        </div>
        @endguest

        <!-- Menu Icon -->
    </div>
</nav>