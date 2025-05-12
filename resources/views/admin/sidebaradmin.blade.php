<!-- SIDEBAR -->
<section id="sidebar">
    <!-- Brand Logo -->

    <link rel="stylesheet" href="{{ asset('dashboard_main/sidebar_dashboardadmin.css') }}">
    <div class="brand">
        <!-- Use a button element instead of an icon inside a link -->
        <button type="button" id="toggle-sidebar-btn"
            style="background: none; border: none; color: white; cursor: pointer; position: absolute; left: 15px; top: 50%; transform: translateY(-50%); padding: 5px; font-size: 24px;">
            <i class='bx bx-menu'></i>
        </button>
        <i class="logo-icon"></i>
        <span class="text">Dashboard Direktorat</span>
    </div>

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
                <li class="{{ request()->routeIs('admin.manageuser.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.manageuser.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Manage User</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.news.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.news.index') }}">
                        <i class='bx bxs-news'></i>
                        <span class="text">Berita</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.news-scroll.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.news-scroll.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Berita Scroll</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.program-layanan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.program-layanan.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Program dan Layanan</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.document.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.document.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Document</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.youtube.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.youtube.index') }}">
                        <i class='bx bxl-youtube'></i>
                        <span class="text">Youtube</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.instagram.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.instagram.index') }}">
                        <i class='bx bxl-instagram'></i>
                        <span class="text">Instagram</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.sejarah.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.sejarah.index') }}">
                        <i class='bx bxl-building'></i>
                        <span class="text">Sejarah</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.pimpinan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pimpinan.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Pimpinan</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.gallery.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.gallery.index') }}">
                        <i class='bx bxs-user'></i>
                        <span class="text">Galery</span>
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
                        <span class="text">MK Sustainability</span>
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
                <li class="{{ request()->routeIs('admin.ranking.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.ranking.index') }}">
                        <i class='bx bxs-school'></i>
                        <span class="text">Ranking Pemeringkatan</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.indikator.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.indikator.index') }}">
                        <i class='bx bxs-school'></i>
                        <span class="text">Indikator Pemeringkatan</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- International Section -->

        <div class="menu-section">
            <h3 class="section-title">Lecture Staff International</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.international_faculty_staff.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.international_faculty_staff.index') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Faculty Staff Profile</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Inovasi Section -->
        <div class="menu-section">
            <h3 class="section-title">Inovasi</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.katsinov.TableKatsinov') ? 'active' : '' }}">
                    <a href="{{ route('admin.katsinov.TableKatsinov') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Tabel Katsinov</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.katsinov.form') ? 'active' : '' }}">
                    <a href="{{ route('admin.katsinov.form') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Katsinov</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.produk_inovasi') ? 'active' : '' }}">
                    <a href="{{ route('admin.produk_inovasi') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Produk Inovasi</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="menu-section">
            <h3 class="section-title">SDGs</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('admin.SDGs.program-kegiatan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.SDGs.program-kegiatan.index') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Program</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.SDGs.publikasi-riset.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.SDGs.publikasi-riset.index') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Publikasi & Riset</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Settings Section -->
        <div class="menu-section">
            <h3 class="section-title">Settings</h3>
            <ul class="side-menu">
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#" class="logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class='bx bxs-log-out-circle'></i>
                            <span class="text">Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        // Execute immediately when DOM is ready
        (function() {
            // Try different ways to attach the event
            var btn = document.getElementById('toggle-sidebar-btn');
            var sidebar = document.getElementById('sidebar');

            if (btn && sidebar) {
                // Method 1: Direct property
                btn.onclick = function() {
                    sidebar.classList.toggle('hide');
                };

                // Method 2: Add event listener
                btn.addEventListener('click', function() {
                    sidebar.classList.toggle('hide');
                });

                // Method 3: Add event to parent
                document.addEventListener('click', function(e) {
                    if (e.target === btn || e.target.closest('#toggle-sidebar-btn')) {
                        sidebar.classList.toggle('hide');
                    }
                });
            }
        })();
    </script>
</section>
<!-- SIDEBAR -->
