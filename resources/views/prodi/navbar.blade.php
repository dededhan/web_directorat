<nav>
    <!-- All content moved to right side -->
    <div class="navbar-right">
        <!-- User Profile Section -->
        @auth
        <div class="profile-info">
            <img src="{{ auth()->user()->profile_picture ?? 'default-avatar.png' }}" alt="Profile Picture" class="profile-image">
            <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
        @endauth
        
        @guest
        <div class="profile-info">
            <img src="default-avatar.png" alt="Guest Profile" class="profile-image">
            <span class="user-name">Guest</span>
        </div>
        @endguest

        <!-- Menu Icon -->
        {{-- <i class='bx bx-menu'></i> --}}
    </div>
</nav>