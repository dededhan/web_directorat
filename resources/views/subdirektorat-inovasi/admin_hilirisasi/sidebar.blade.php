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
        <span class="text">Dashboard Hilirisasi</span>
    </div>

    <!-- Navigation Menu -->
    <nav class="side-navigation">
        <!-- Inovasi Section -->
        <div class="menu-section">
            <h3 class="section-title">Inovasi</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('inovasi.admin_hilirisasi.TableKatsinov') ? 'active' : '' }}">
                    <a href="{{ route('inovasi.admin_hilirisasi.TableKatsinov') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Tabel Kasitnov</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('inovasi.admin_hilirisasi.form') ? 'active' : '' }}">
                    <a href="{{ route('inovasi.admin_hilirisasi.form') }}">
                        <i class='bx bxs-file-plus'></i>
                        <span class="text">Form Katsinov</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- SDGs Section -->
        <div class="menu-section">
            <h3 class="section-title">SDGs</h3>
            <ul class="side-menu">
                <li class="{{ request()->routeIs('inovasi.admin_hilirisasi.SDGs.program_kegiatan') ? 'active' : '' }}">
                    <a href="{{ route('inovasi.admin_hilirisasi.SDGs.program_kegiatan') }}">
                        <i class='bx bxs-graduation'></i>
                        <span class="text">Program</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('inovasi.admin_hilirisasi.SDGs.publikasi_riset') ? 'active' : '' }}">
                    <a href="{{ route('inovasi.admin_hilirisasi.SDGs.publikasi_riset') }}">
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