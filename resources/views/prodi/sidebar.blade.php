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
                <li class="{{ request()->routeIs('prodi.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('prodi.dashboard') }}">
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('prodi.news.index') ? 'active' : '' }}">
                    <a href="{{ route('prodi.news.index') }}">
                        <i class='bx bxs-news'></i>
                        <span class="text">Berita</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sustainability Section -->
        <div class="menu-section">
            <h3 class="section-title">Sustainability</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('prodi.sustainability.index') ? 'active' : '' }}">
                    <a href="{{ route('prodi.sustainability.index') }}">
                        <i class='bx bxs-spreadsheet'></i>
                        <span class="text">Sustainability</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('prodi.matakuliah.index') ? 'active' : '' }}">
                    <a href="{{ route('prodi.matakuliah.index') }}">
                        <i class='bx bxs-book'></i>
                        <span class="text">MatKul Sustainability</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('prodi.alumniberdampak.index') ? 'active' : '' }}">
                    <a href="{{ route('prodi.alumniberdampak.index') }}">
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
                <li class="{{ request()->routeIs('prodi.qsresponden.index') ? 'active' : '' }}">
                    <a href="{{ route('prodi.qsresponden.index') }}">
                        <i class='bx bxs-spreadsheet'></i>
                        <span class="text">Tabel Responden</span>
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
