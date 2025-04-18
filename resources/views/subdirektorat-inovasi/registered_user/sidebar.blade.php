<!-- SIDEBAR -->
<style>
    .disabled-link {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<link rel="stylesheet" href="{{ asset('dashboard_main/sidebar_dashboardadmin.css') }}">
<section id="sidebar">
    <div class="brand">
        <!-- Use a button element instead of an icon inside a link -->
        <button type="button" id="toggle-sidebar-btn" style="background: none; border: none; color: white; cursor: pointer; position: absolute; left: 15px; top: 50%; transform: translateY(-50%); padding: 5px; font-size: 24px;">
            <i class='bx bx-menu'></i>
        </button>
        <i class="logo-icon"></i>
        <span class="text">Dashboard Direktorat</span>
    </div>

    <ul class="side-menu top">
        <li
            class="{{ request()->routeIs('subdirektorat-inovasi.registered_user.dashboard') ? 'active' : '' }} @if (Auth::user()->status === 'unactive') disabled @endif">
            <a href="{{ Auth::user()->status === 'active' ? route('subdirektorat-inovasi.registered_user.dashboard') : '#' }}"
                class="@if (Auth::user()->status === 'unactive') disabled-link @endif">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
    </ul>

    <div class="menu-section">
        <h3 class="section-title">Inovasi</h3>
        <ul class="side-menu">
            <!-- Tabel Kasitnov -->
            <li
                class="{{ request()->routeIs('subdirektorat-inovasi.registered_user.TableKatsinov') ? 'active' : '' }} @if (Auth::user()->status === 'unactive') disabled @endif">
                <a href="{{ Auth::user()->status === 'active' ? route('subdirektorat-inovasi.registered_user.tablekatsinov') : '#' }}"
                    class="@if (Auth::user()->status === 'unactive') disabled-link @endif">
                    <i class='bx bxs-graduation'></i>
                    <span class="text">Tabel Kasitnov</span>
                </a>
            </li>

            <!-- Form Katsinov -->
            <li
                class="{{ request()->routeIs('subdirektorat-inovasi.registered_user.form') ? 'active' : '' }} @if (Auth::user()->status === 'unactive') disabled @endif">
                <a href="{{ Auth::user()->status === 'active' ? route('subdirektorat-inovasi.registered_user.form') : '#' }}"
                    class="@if (Auth::user()->status === 'unactive') disabled-link @endif">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Form Katsinov</span>
                </a>
            </li>


        </ul>
    </div>

    <!-- Logout -->
    <ul class="side-menu">
        <li>
            <a href="#" class="logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

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
