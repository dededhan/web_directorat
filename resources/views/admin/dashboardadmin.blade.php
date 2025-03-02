@extends('admin.admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/dashboard_admin.css') }}">


@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard Direktorat</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Home</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>

    <!-- Quick Stats Section (Redesigned) -->
    <div class="container quick-stats-container">
        <div class="section-title">
            <h2>Overview</h2>
            <div class="title-underline"></div>
        </div>
        <div class="quick-stats-grid">
            <div class="quick-stat-item">
                <div class="stat-icon">
                    <i class='bx bxs-news'></i>
                </div>
                <div class="stat-number">5</div>
                <div class="stat-title">New Articles</div>
            </div>
            <div class="quick-stat-item">
                <div class="stat-icon">
                    <i class='bx bxs-calendar'></i>
                </div>
                <div class="stat-number">3</div>
                <div class="stat-title">Upcoming Events</div>
            </div>
            <div class="quick-stat-item">
                <div class="stat-icon">
                    <i class='bx bxs-bell'></i>
                </div>
                <div class="stat-number">12</div>
                <div class="stat-title">Notifications</div>
            </div>
            <div class="quick-stat-item">
                <div class="stat-icon">
                    <i class='bx bxs-user-check'></i>
                </div>
                <div class="stat-number">8</div>
                <div class="stat-title">New Users</div>
            </div>
        </div>
    </div>

    <!-- UNJ dalam Prestasi Section -->
    <div class="container unj-prestasi-container">
        <div class="section-title text-center">
            <h2>UNJ dalam <span class="highlight">Prestasi</span></h2>
            <div class="title-underline"></div>
        </div>
        <div class="prestasi-grid">
            <!-- Row 1 -->
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-group'></i>
                </div>
                <div class="prestasi-number">30,673</div>
                <div class="prestasi-title">Mahasiswa</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bx-world'></i>
                </div>
                <div class="prestasi-number">125</div>
                <div class="prestasi-title">Mahasiswa Internasional</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-bulb'></i>
                </div>
                <div class="prestasi-number">130</div>
                <div class="prestasi-title">Guru Besar</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-user-voice'></i>
                </div>
                <div class="prestasi-number">1,132</div>
                <div class="prestasi-title">Dosen</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-user-badge'></i>
                </div>
                <div class="prestasi-number">4</div>
                <div class="prestasi-title">Dosen Internasional</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="prestasi-number">774</div>
                <div class="prestasi-title">Tendik</div>
            </div>
            
            <!-- Row 2 -->
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-building-house'></i>
                </div>
                <div class="prestasi-number">8</div>
                <div class="prestasi-title">Fakultas</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-school'></i>
                </div>
                <div class="prestasi-number">1</div>
                <div class="prestasi-title">Sekolah</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-grid'></i>
                </div>
                <div class="prestasi-number">116</div>
                <div class="prestasi-title">Program Studi</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-graduation'></i>
                </div>
                <div class="prestasi-number">3,681</div>
                <div class="prestasi-title">terindeks Scopus</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-file'></i>
                </div>
                <div class="prestasi-number">2,459</div>
                <div class="prestasi-title">HKI</div>
            </div>
            <div class="prestasi-item">
                <div class="prestasi-icon">
                    <i class='bx bxs-certificate'></i>
                </div>
                <div class="prestasi-number">123</div>
                <div class="prestasi-title">Hak Paten</div>
            </div>
        </div>
        
        <!-- Akreditasi Info -->
        <div class="akreditasi-wrapper">
            <div class="akreditasi-item nasional">
                <div class="akreditasi-number">116 Prodi</div>
                <div class="akreditasi-title">Terakreditasi Nasional</div>
            </div>
            <div class="akreditasi-item internasional">
                <div class="akreditasi-number">60 Prodi</div>
                <div class="akreditasi-title">Terakreditasi Internasional</div>
            </div>
        </div>
    </div>

    <!-- Visitor Chart Container -->
    <div class="container chart-container">
        <div class="section-title">
            <h2>Visitor Statistics</h2>
            <div class="title-underline"></div>
        </div>
        <div class="content-data">
            <div class="chart-wrapper">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="container activity-container">
        <div class="section-title">
            <h2>Recent Activity</h2>
            <div class="title-underline"></div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Activity</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Admin1</td>
                        <td>Updated website content</td>
                        <td>Today, 14:20</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    <tr>
                        <td>Admin2</td>
                        <td>Added new event</td>
                        <td>Today, 12:30</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    <tr>
                        <td>Editor1</td>
                        <td>Posted new article</td>
                        <td>Yesterday, 16:45</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    <tr>
                        <td>Admin1</td>
                        <td>System maintenance</td>
                        <td>Feb 25, 09:30</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="{{ asset('dashboard_main/dashboard/dashboard_admin..js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush
@endsection