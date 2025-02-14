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
        <li class="{{ request()->routeIs('admin.responden.index') ? 'active' : '' }}">
            <a href="{{ route('admin.responden.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Responden</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.sustainability.index') ? 'active' : '' }}">
            <a href="{{ route('admin.sustainability.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Sustainability</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('admin.matakuliah.index') ? 'active' : '' }}">
            <a href="{{ route('admin.matakuliah.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">MatKul Sustainability</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('admin.alumniberdampak.index') ? 'active' : '' }}">
            <a href="{{ route('admin.alumniberdampak.index') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Alumni Berdampak</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.qsgeneraltable') ? 'active' : '' }}">
            <a href="{{ route('admin.qsgeneraltable') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Tabel General</span>
            </a>
        </li>
        {{-- <li class="{{ request()->routeIs('admin.respondenacademic') ? 'active' : '' }}">
            <a href="{{ route('admin.respondenacademic') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Tabel Academic</span>
            </a>
        </li> --}}
        <li class="{{ request()->routeIs('admin.qsresponden.index') ? 'active' : '' }}">
            <a href="{{ route('admin.qsresponden.index') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Tabel Responden</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('admin.mahasiswainternational') ? 'active' : '' }}">
            <a href="{{ route('admin.mahasiswainternational') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Mahasiswa International</span>
            </a>
        </li>        
        <li class="{{ request()->routeIs('admin.dataakreditasi') ? 'active' : '' }}">
            <a href="{{ route('admin.dataakreditasi') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">Data Akreditasi</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('admin.international_lecture') ? 'active' : '' }}">
            <a href="{{ route('admin.international_lecture') }}">
                <i class='bx bxs-graduation'></i>
                <span class="text">International Lecture</span>
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