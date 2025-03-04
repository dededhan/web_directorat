<!-- SIDEBAR -->
<section id="sidebar">
    <!-- Brand Logo -->
    <a href="#" class="brand">
        <i class="logo-icon"></i>
        <span class="text">Dashboard Direktorat</span>
    </a>
    
    <!-- Navigation Menu -->
    <nav class="side-navigation">
        <!-- Main Menu Section -->
        <div class="menu-section">
            <h3 class="section-title">Main Menu</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.news') ? 'active' : '' }}">
                    <a href="{{ route('admin.news') }}">
                        <i class='bx bxs-news'></i>
                        <span class="text">Berita</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.manageuser.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.manageuser.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Manage User</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sustainability Section -->
        <div class="menu-section">
            <h3 class="section-title">Sustainability</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.sustainability.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.sustainability.index') }}">
                        <i class='bx bxs-spreadsheet'></i>
                        <span class="text">Sustainability</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.matakuliah.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.matakuliah.index') }}">
                        <i class='bx bxs-book'></i>
                        <span class="text">MatKul Sustainability</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.alumniberdampak.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.alumniberdampak.index') }}">
                        <i class='bx bxs-group'></i>
                        <span class="text">Alumni Berdampak</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Data Tables Section -->
        <div class="menu-section">
            <h3 class="section-title">Data Tables</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.responden.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.responden.index') }}">
                        <i class='bx bxs-user-voice'></i>
                        <span class="text">Responden</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.qsgeneraltable') ? 'active' : '' }}">
                    <a href="{{ route('admin.qsgeneraltable') }}">
                        <i class='bx bxs-spreadsheet'></i>
                        <span class="text">Tabel General</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.qsresponden.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.qsresponden.index') }}">
                        <i class='bx bxs-spreadsheet'></i>
                        <span class="text">Tabel Responden</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- International Section -->
        <div class="menu-section">
            <h3 class="section-title">International</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.mahasiswainternational.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.mahasiswainternational.index') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Mahasiswa International</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.dataakreditasi.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.dataakreditasi.index') }}">
                        <i class='bx bxs-spreadsheet'></i>
                        <span class="text">Data Akreditasi</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.internationallecture.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.internationallecture.index') }}">
                        <i class='bx bxs-school'></i>
                        <span class="text">International Lecture</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Inovasi Section -->
        <div class="menu-section">
            <h3 class="section-title">Inovasi</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.Katsinov.TableKatsinov') ? 'active' : '' }}">
                    <a href="{{ route('admin.Katsinov.TableKatsinov') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Tabel Kasitnov</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.Katsinov.form') ? 'active' : '' }}">
                    <a href="{{ route('admin.Katsinov.form') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Katsinov</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.Katsinov.informasidasar') ? 'active' : '' }}">
                    <a href="{{ route('admin.Katsinov.informasidasar') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Informasi Dasar</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.Katsinov.formberitaacara') ? 'active' : '' }}">
                    <a href="{{ route('admin.Katsinov.formberitaacara') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Berita Acara</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.Katsinov.formjudul') ? 'active' : '' }}">
                    <a href="{{ route('admin.Katsinov.formjudul') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Judul</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.Katsinov.formrecordhasilpengukuran') ? 'active' : '' }}">
                    <a href="{{ route('admin.Katsinov.formrecordhasilpengukuran') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Record</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Settings Section -->
        <div class="menu-section">
            <h3 class="section-title">Settings</h3>
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
        </div>
    </nav>
</section>
<!-- SIDEBAR -->