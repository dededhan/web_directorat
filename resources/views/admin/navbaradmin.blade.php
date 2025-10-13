<link rel="stylesheet" href="{{ asset('position-fix.css') }}">
<nav class="navbar-admin">
    <div class="navbar-right">
        @auth
        <div class="profile-info">
            <img src="{{ auth()->user()->profile_picture ?? 'default-avatar.png' }}" alt="" class="profile-image">
            <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
        @endauth
        
        @guest
        <div class="profile-info">
            <img src="default-avatar.png" alt="Guest Profile" class="profile-image">
            <span class="user-name">Guest</span>
        </div>
        @endguest
    </div>
</nav>