<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="admin.css">

	<title>Dashboard Direktorat</title>

	<!-- Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<style>
		/* Style untuk container chart */
		
	</style>
</head>
<body>
	@include('admin.sidebaradmin')

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		@include('admin.navbaradmin')

		<!-- MAIN -->
		<main>
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

			<!-- Summary Boxes -->
			<ul class="box-info">
				<li>
					<i class='bx bxs-news'></i>
					<span class="text">
						<h3>5</h3>
						<p>New Articles</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar'></i>
					<span class="text">
						<h3>3</h3>
						<p>Upcoming Events</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-bell'></i>
					<span class="text">
						<h3>12</h3>
						<p>Notifications</p>
					</span>
				</li>
			</ul>

			<!-- Content Section -->
			<div class="content-data">
				<div class="chart-container">
					<canvas id="visitorChart"></canvas>
				</div>
			</div>
		</main>
	</section>

	<script src="admin.js"></script>
	<script>
		// Data jumlah pengunjung per bulan
		const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni"];
		const data = {
			labels: labels,
			datasets: [{
				label: "Jumlah Pengunjung",
				data: [120, 150, 180, 200, 250, 300], // Data pengunjung
				backgroundColor: "rgba(75, 192, 192, 0.2)",
				borderColor: "rgba(75, 192, 192, 1)",
				borderWidth: 1
			}]
		};

		// Konfigurasi chart
		const config = {
			type: "bar", // Jenis chart: bar, line, pie, dll.
			data: data,
			options: {
				responsive: true,
				maintainAspectRatio: false, // Mengatur rasio chart agar bisa menyesuaikan container
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		};

		// Render chart
		const visitorChart = new Chart(
			document.getElementById("visitorChart"),
			config
		);
	</script>
</body>
</html>
