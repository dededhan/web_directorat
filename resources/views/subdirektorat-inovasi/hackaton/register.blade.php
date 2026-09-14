<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Akun | UNJ Hackaton</title>
	<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
	@vite(['resources/css/app.css'])
	<link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
	<script src="{{ asset('fontawesome/all.min.js') }}" defer></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
	<link rel="stylesheet" href="{{ asset('home.css') }}">
	<style>
		body { font-family: 'Inter', sans-serif; }
		.hackaton-pattern {
			background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='.07'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
		}
		.input-field { transition: box-shadow .2s, border-color .2s; }
		.input-field:focus { box-shadow: 0 0 0 3px rgba(245, 158, 11, .15); }
	</style>
</head>

@include('layout.navbar_hilirisasi')

<body class="bg-gray-50">
	<div class="min-h-screen relative overflow-hidden" style="margin-top: 70px;">
		<div class="absolute inset-0 pointer-events-none overflow-hidden">
			<div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-gradient-to-br from-amber-400/20 to-orange-300/10 blur-3xl"></div>
			<div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-gradient-to-tr from-sky-400/15 to-cyan-300/10 blur-3xl"></div>
		</div>

		<div class="relative z-10 flex items-center justify-center px-4 py-10 sm:px-6">
			<div class="w-full max-w-5xl overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-2xl">
				<div class="flex flex-col lg:flex-row">
					<section class="hackaton-pattern relative flex flex-col justify-between bg-gradient-to-br from-[#8a4b08] via-[#d97706] to-[#f59e0b] p-8 text-white lg:w-5/12 lg:p-10">
						<div>
							<div class="mb-10 flex items-center gap-3">
								<div class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-white/15 backdrop-blur-sm">
									<i class="fas fa-lightbulb text-xl text-yellow-100"></i>
								</div>
								<div>
									<h3 class="text-lg font-bold leading-tight">Registrasi Hackaton</h3>
									<p class="text-xs font-medium tracking-wider text-amber-100">UNJ INNOVATION</p>
								</div>
							</div>
							<h1 class="text-3xl font-extrabold leading-tight lg:text-4xl">Mulai dari<br><span class="text-yellow-100">ide Anda.</span></h1>
							<p class="mt-4 max-w-xs text-sm leading-relaxed text-amber-50">Daftarkan diri Anda untuk bergabung dalam ruang kolaborasi dan membangun solusi inovatif bersama Hackaton UNJ.</p>
							<div class="mt-8 space-y-4">
								<div class="flex items-start gap-3"><i class="fas fa-users mt-1 w-5 text-center text-yellow-100"></i><span class="text-sm">Kolaborasi lintas bidang</span></div>
								<div class="flex items-start gap-3"><i class="fas fa-rocket mt-1 w-5 text-center text-yellow-100"></i><span class="text-sm">Kembangkan solusi berdampak</span></div>
								<div class="flex items-start gap-3"><i class="fas fa-award mt-1 w-5 text-center text-yellow-100"></i><span class="text-sm">Tumbuh bersama ekosistem inovasi</span></div>
							</div>
						</div>
						<p class="mt-10 text-xs text-amber-100">Pendaftaran akan ditinjau oleh admin sebelum akun diaktifkan.</p>
					</section>

					<section class="p-8 lg:w-7/12 lg:p-10" x-data="{ showPassword: false, showConfirmation: false }">
						<div class="mb-8">
							<div class="mb-1 flex items-center gap-3">
								<div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-500 to-orange-600 shadow-md"><i class="fas fa-user-plus text-lg text-white"></i></div>
								<div><h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2><p class="mt-0.5 text-sm text-gray-500">Lengkapi data berikut untuk mendaftar</p></div>
							</div>
						</div>

						@if (session('success'))
							<div class="mb-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700"><i class="fas fa-check-circle mt-0.5"></i><span>{{ session('success') }}</span></div>
						@endif
						@if ($errors->any())
							<div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"><ul class="list-disc space-y-1 pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
						@endif

						<form action="{{ route('hackaton.register.submit') }}" method="POST" class="space-y-5">
							@csrf
							<div>
								<label for="name" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Nama Lengkap <span class="text-red-400">*</span></label>
								<div class="relative"><i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i><input id="name" name="name" type="text" value="{{ old('name') }}" required class="input-field w-full rounded-xl border-2 border-gray-200 bg-gray-50/50 py-3 pl-11 pr-4 text-sm focus:border-amber-500 focus:bg-white focus:outline-none" placeholder="Masukkan nama lengkap Anda"></div>
							</div>
							<div>
								<label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Email <span class="text-red-400">*</span></label>
								<div class="relative"><i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i><input id="email" name="email" type="email" value="{{ old('email') }}" required class="input-field w-full rounded-xl border-2 border-gray-200 bg-gray-50/50 py-3 pl-11 pr-4 text-sm focus:border-amber-500 focus:bg-white focus:outline-none" placeholder="contoh@email.com"></div>
							</div>
							<div>
								<label for="role" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Daftar Sebagai <span class="text-red-400">*</span></label>
								<div class="relative"><i class="fas fa-id-badge absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i><select id="role" name="role" required class="input-field w-full appearance-none rounded-xl border-2 border-gray-200 bg-gray-50/50 py-3 pl-11 pr-10 text-sm focus:border-amber-500 focus:bg-white focus:outline-none"><option value="">Pilih role peserta</option>@foreach ($roleLabels as $roleKey => $roleLabel)<option value="{{ $roleKey }}" @selected(old('role') === $roleKey)>{{ $roleLabel }}</option>@endforeach</select><i class="fas fa-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400"></i></div>
							</div>
							<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
								<div><label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Password <span class="text-red-400">*</span></label><div class="relative"><i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i><input :type="showPassword ? 'text' : 'password'" id="password" name="password" required class="input-field w-full rounded-xl border-2 border-gray-200 bg-gray-50/50 py-3 pl-11 pr-11 text-sm focus:border-amber-500 focus:bg-white focus:outline-none" placeholder="Min. 8 karakter"><button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400"><i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i></button></div></div>
								<div><label for="password_confirmation" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Konfirmasi <span class="text-red-400">*</span></label><div class="relative"><i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i><input :type="showConfirmation ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required class="input-field w-full rounded-xl border-2 border-gray-200 bg-gray-50/50 py-3 pl-11 pr-11 text-sm focus:border-amber-500 focus:bg-white focus:outline-none" placeholder="Ulangi password"><button type="button" @click="showConfirmation = !showConfirmation" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400"><i class="fas" :class="showConfirmation ? 'fa-eye-slash' : 'fa-eye'"></i></button></div></div>
							</div>
							<button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#8a4b08] via-[#d97706] to-[#f59e0b] px-6 py-3.5 text-sm font-bold tracking-wide text-white shadow-lg transition hover:brightness-105"><i class="fas fa-paper-plane"></i> Kirim Pendaftaran</button>
							<p class="text-center text-sm text-gray-500">Sudah punya akun? <a href="{{ route('hackaton.dashboard') }}" class="font-semibold text-amber-700 hover:underline">Masuk di sini</a></p>
						</form>
					</section>
				</div>
			</div>
		</div>
	</div>
	@include('layout.footer')
</body>
</html>
