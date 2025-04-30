<nav>
    <!-- All content moved to right side -->
    <div class="navbar-right">

        @auth
        <div class="profile-info">
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

    </div>
</nav>