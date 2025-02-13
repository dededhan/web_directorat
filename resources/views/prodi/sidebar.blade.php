<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand" style="display: flex; flex-direction: column; align-items: center;">
        <i style="margin-bottom: 8px;"></i>
        <span class="text" style="color: white;">Dashboard Direktorat</span>
    </a>
    <ul class="side-menu top">
        <li class="{{ request()->routeIs('prodi.dashboard') ? 'active' : '' }}">
            <a href="{{ route('prodi.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('prodi.sustainability.index') ? 'active' : '' }}">
            <a href="{{ route('prodi.sustainability.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Sustainability</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('prodi.matakuliah.index') ? 'active' : '' }}">
            <a href="{{ route('prodi.matakuliah.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Mata Kuliah Sustainability</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('prodi.alumniberdampak.index') ? 'active' : '' }}">
            <a href="{{ route('prodi.alumniberdampak.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Alumni Berdampak</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('prodi.qsresponden.index') ? 'active' : '' }}">
            <a href="{{ route('prodi.qsresponden.index') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Tabel Responden</span>
            </a>
        </li>

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