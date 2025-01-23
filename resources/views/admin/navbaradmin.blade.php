<nav>
    
<i class='bx bx-menu d-flex flex-row position-absolute top-2 end-0' style="font-size: 40px;"></i>
    <a href="#" class="logo">
    <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo">
    </a>
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