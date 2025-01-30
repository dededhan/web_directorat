<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand" style="display: flex; flex-direction: column; align-items: center;">
        <i style="margin-bottom: 8px;"></i>
        <span class="text" style="color: white;">Dashboard Direktorat</span>
    </a>
    <ul class="side-menu top">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.news') ? 'active' : '' }}">
            <a href="{{ route('admin.news') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Berita</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.manageuser') ? 'active' : '' }}">
            <a href="{{ route('admin.manageuser') }}">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Manage User</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.responden') ? 'active' : '' }}">
            <a href="{{ route('admin.responden') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Ranking</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-doughnut-chart'></i>
                <span class="text">Event</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Manage User</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </form>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->