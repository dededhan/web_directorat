<!-- SIDEBAR -->
<link rel="stylesheet" href="{{ asset('dashboard_main/sidebar_dashboardadmin.css') }}">
<section id="sidebar">
    <a href="#" class="brand" style="display: flex; flex-direction: column; align-items: center;">
        <i style="margin-bottom: 8px;"></i>
        <span class="text" style="color: white;">Dashboard Dosen</span>
    </a>
    <ul class="side-menu top">

        <li class="{{ request()->routeIs('inovasi.dosen.dashboard') ? 'active' : '' }}">
            <a href="{{ route('inovasi.dosen.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
    </ul>

    <div class="menu-section">
        <h3 class="section-title">Inovasi</h3>
        <ul class="side-menu">
            <li class="{{ request()->routeIs('inovasi.dosen.tablekasitnov') ? 'active' : '' }}">
                <a href="{{ route('inovasi.dosen.tablekasitnov') }}">
                    <i class='bx bxs-graduation'></i>
                    <span class="text">Tabel Kasitnov</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('inovasi.dosen.form') ? 'active' : '' }}">
                <a href="{{ route('inovasi.dosen.form') }}">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Form Katsinov</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('inovasi.dosen.forminformasidasar.index') ? 'active' : '' }}">
                <a href="{{ route('inovasi.dosen.forminformasidasar.index') }}">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Form Informasi Dasar</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('inovasi.dosen.formberitaacara.index') ? 'active' : '' }}">
                <a href="{{ route('inovasi.dosen.formberitaacara.index') }}">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Form Berita Acara</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('inovasi.dosen.formjudul') ? 'active' : '' }}">
                <a href="{{ route('inovasi.dosen.formjudul') }}">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Form Judul</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('inovasi.dosen.formrecordhasilpengukuran.index') ? 'active' : '' }}">
                <a href="{{ route('inovasi.dosen.formrecordhasilpengukuran.index') }}">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Form Record</span>
                </a>
            </li>
        </ul>
    </div>

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