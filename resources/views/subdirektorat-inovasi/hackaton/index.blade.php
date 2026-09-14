<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hackaton UNJ | Direktorat Inovasi</title>
	<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('home.css') }}">
	<style>
		.hackaton-page { background: #f5f7fa; color: #333; font-family: 'Segoe UI', Tahoma, sans-serif; }
		.hackaton-hero { background: linear-gradient(135deg, rgba(138,75,8,.96), rgba(217,119,6,.94), rgba(245,158,11,.9)); border-radius: 1rem; color: #fff; overflow: hidden; padding: 5rem 2rem; position: relative; text-align: center; }
		.hackaton-hero::before { background: url('https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png') center/300px no-repeat; content: ''; inset: 0; opacity: .06; position: absolute; }
		.hackaton-content { margin: 0 auto; max-width: 700px; position: relative; z-index: 1; }
		.hackaton-section { background: #fff; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,.05); margin-bottom: 2rem; padding: 3rem; }
		.hackaton-title { border-bottom: 3px solid #d97706; color: #8a4b08; font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; padding-bottom: .8rem; }
		.hackaton-card { border: 1px solid #e8e8e8; border-radius: .75rem; padding: 1.75rem; transition: .25s ease; }
		.hackaton-card:hover { border-color: #d97706; box-shadow: 0 12px 25px rgba(138,75,8,.1); transform: translateY(-4px); }
		@media (max-width: 768px) { .hackaton-section { padding: 1.5rem; } }
	</style>
</head>

@include('layout.navbar_hilirisasi')

<body>
	<div class="hackaton-page" style="padding-top: 70px;">
		<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:py-12">
			<section class="hackaton-hero mb-8">
				<div class="hackaton-content">
					<span class="mb-5 inline-block rounded-full border border-white/30 bg-white/15 px-5 py-2 text-xs font-bold uppercase tracking-[.2em]">Program Inovasi UNJ</span>
					<h1 class="text-4xl font-bold leading-tight sm:text-6xl">Hackaton UNJ</h1>
					<p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-amber-50 sm:text-lg">Ruang kolaborasi untuk mengubah ide kreatif menjadi solusi inovatif yang menjawab tantangan nyata.</p>
					<div class="mt-8 flex flex-wrap justify-center gap-3">
						<a href="{{ route('hackaton.register.form') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 font-bold text-amber-800 shadow-lg transition hover:bg-amber-50"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
						<a href="{{ route('hackaton.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/50 bg-white/10 px-6 py-3 font-bold text-white transition hover:bg-white/20"><i class="fas fa-sign-in-alt"></i> {{ auth()->check() ? 'Buka Dashboard' : 'Masuk Peserta' }}</a>
						<a href="#tentang" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/50 bg-white/10 px-6 py-3 font-bold text-white transition hover:bg-white/20"><i class="fas fa-info-circle"></i> Pelajari Program</a>
					</div>
				</div>
			</section>

			<section id="tentang" class="hackaton-section">
				<h2 class="hackaton-title">Tentang Hackaton</h2>
				<p class="text-base leading-8 text-gray-600">Hackaton UNJ merupakan wadah bagi civitas akademika dan mitra untuk berkolaborasi, merumuskan masalah, serta mengembangkan prototipe solusi berbasis inovasi. Peserta akan mengikuti rangkaian kegiatan sesuai ketentuan event yang dibuka oleh Direktorat Inovasi dan Hilirisasi.</p>
				<div class="mt-8 grid gap-5 md:grid-cols-3">
					<div class="hackaton-card"><div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-700"><i class="fas fa-lightbulb text-xl"></i></div><h3 class="mb-2 text-lg font-bold text-amber-900">Kembangkan Ide</h3><p class="text-sm leading-6 text-gray-600">Rumuskan gagasan yang relevan untuk menjawab tantangan dan kebutuhan nyata.</p></div>
					<div class="hackaton-card"><div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-sky-100 text-sky-700"><i class="fas fa-users text-xl"></i></div><h3 class="mb-2 text-lg font-bold text-amber-900">Kolaborasi</h3><p class="text-sm leading-6 text-gray-600">Bangun tim lintas disiplin dan belajar dari peserta serta mentor lainnya.</p></div>
					<div class="hackaton-card"><div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-700"><i class="fas fa-rocket text-xl"></i></div><h3 class="mb-2 text-lg font-bold text-amber-900">Ciptakan Dampak</h3><p class="text-sm leading-6 text-gray-600">Kembangkan solusi yang dapat diuji, dipresentasikan, dan memberi manfaat.</p></div>
				</div>
			</section>

			<section class="hackaton-section">
				<h2 class="hackaton-title">Alur Keikutsertaan</h2>
				<div class="grid gap-5 md:grid-cols-4">
					@foreach ([['icon' => 'fa-user-plus', 'title' => 'Registrasi', 'text' => 'Buat akun peserta melalui halaman pendaftaran.'], ['icon' => 'fa-clipboard-check', 'title' => 'Verifikasi', 'text' => 'Admin memeriksa dan menyetujui pendaftaran.'], ['icon' => 'fa-users', 'title' => 'Ikuti Event', 'text' => 'Lengkapi ketentuan dan rangkaian kegiatan Hackaton.'], ['icon' => 'fa-trophy', 'title' => 'Presentasi', 'text' => 'Tampilkan solusi dan raih kesempatan pengembangan.']] as $step => $item)
						<div class="relative text-center"><div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-amber-100 text-xl font-bold text-amber-700"><i class="fas {{ $item['icon'] }}"></i></div><p class="mb-2 text-xs font-bold uppercase tracking-wider text-amber-600">Langkah {{ $step + 1 }}</p><h3 class="mb-2 font-bold text-gray-800">{{ $item['title'] }}</h3><p class="text-sm leading-6 text-gray-600">{{ $item['text'] }}</p></div>
					@endforeach
				</div>
			</section>

			<section class="rounded-2xl bg-gradient-to-r from-[#8a4b08] to-[#d97706] px-6 py-10 text-center text-white shadow-lg sm:px-10">
				<h2 class="text-2xl font-bold sm:text-3xl">Siap membawa ide Anda lebih jauh?</h2>
				<p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-amber-50">Buat akun Hackaton sekarang. Informasi event, ketentuan, dan jadwal lengkap akan mengikuti pembukaan program.</p>
				<a href="{{ route('hackaton.register.form') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 font-bold text-amber-800 transition hover:bg-amber-50"><i class="fas fa-arrow-right"></i> Mulai Pendaftaran</a>
			</section>
		</div>
	</div>
	@include('layout.footer')
</body>
</html>
