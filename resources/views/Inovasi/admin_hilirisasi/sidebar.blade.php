<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand" style="display: flex; flex-direction: column; align-items: center;">
        <i style="margin-bottom: 8px;"></i>
        <span class="text" style="color: white;">Dashboard Hilirisasi</span>
    </a>
    <ul class="side-menu top">
        <li class="{{ Request::is('Inovasi/admin_hilirisasi/dashboard') ? 'active' : '' }}">
            <a href="{{ route('inovasi.admin_hilirisasi.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('Inovasi.admin_hilirisasi.tablekasitnov') ? 'active' : '' }}">
            <a href="{{ route('inovasi.admin_hilirisasi.tablekasitnov') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Tabel Kasitnov</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li>
            <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</section>