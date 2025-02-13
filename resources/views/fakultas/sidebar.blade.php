<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand" style="display: flex; flex-direction: column; align-items: center;">
        <i style="margin-bottom: 8px;"></i>
        <span class="text" style="color: white;">Dashboard Direktorat</span>
    </a>
    <ul class="side-menu top">
        <li class="{{ Request::is('fakultas/dashboard') ? 'active' : '' }}">
            <a href="{{ route('fakultas.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="{{ Request::is('fakultas/sustainability*') ? 'active' : '' }}">
            <a href="{{ route('fakultas.sustainability.index') }}">
                <i class='bx bx-line-chart'></i>
                <span class="text">Sustainability</span>
            </a>
        </li>
        <li class="{{ Request::is('fakultas/matakuliah*') ? 'active' : '' }}">
            <a href="{{ route('fakultas.matakuliah.index') }}">
                <i class='bx bx-book'></i>
                <span class="text">Mata Kuliah</span>
            </a>
        </li>
        <li class="{{ Request::is('fakultas/alumniberdampak*') ? 'active' : '' }}">
            <a href="{{ route('fakultas.alumniberdampak.index') }}">
                <i class='bx bx-user-voice'></i>
                <span class="text">Alumni Berdampak</span>
            </a>
        </li>
        <li class="{{ Request::is('fakultas/qsresponden*') ? 'active' : '' }}">
            <a href="{{ route('fakultas.qsresponden.index') }}">
                <i class='bx bx-user-check'></i>
                <span class="text">QS Responden</span>
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