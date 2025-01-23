<nav>
    <i class='bx bx-menu d-flex flex-row'></i>
    
    <div class="user-profile">
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
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Add dropdown or more interactions for user profile
    const profileElement = document.querySelector('.profile-info');
    profileElement.addEventListener('click', function() {
        // Toggle dropdown or show user options
        const dropdown = document.getElementById('user-dropdown');
        dropdown.classList.toggle('show');
    });
});
</script>