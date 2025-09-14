@extends('subdirektorat-inovasi.dosen.index') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="bg-slate-50 min-h-screen p-4 sm:p-6 lg:p-8">

    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Portofolio Saya</h1>
            <nav class="text-sm text-slate-500 mt-1" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="#" class="hover:text-teal-600">Home</a>
                        <i class='bx bx-chevron-right text-lg mx-2'></i>
                    </li>
                    <li class="font-medium text-slate-700">
                        Portofolio
                    </li>
                </ol>
            </nav>
        </div>
        <a href="#" class="inline-flex items-center px-4 py-2 bg-teal-500 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">
            <i class='bx bx-plus mr-2 text-lg'></i>
            Tambah Portofolio
        </a>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-8">

        <aside class="lg:col-span-1 mb-8 lg:mb-0">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-8">
                <h2 class="text-xl font-bold text-slate-800">Kategori Portofolio</h2>
                <p class="text-slate-500 text-sm mt-1">Filter portofolio berdasarkan kategori.</p>
                <form class="mt-6 space-y-4">
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select id="kategori" name="kategori" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                            <option>Semua Kategori</option>
                            <option>Bidang Penelitian</option>
                            <option>Bidang Pengabdian</option>
                            <option>Publikasi Ilmiah</option>
                            <option>Hak Kekayaan Intelektual</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-teal-500 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">
                        Filter
                    </button>
                </form>
            </div>
        </aside>

        <main class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md">
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-xl font-bold text-slate-800">Manajemen Data Portofolio</h2>
                    <p class="text-slate-500 text-sm mt-1">Daftar semua portofolio yang telah Anda tambahkan.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">Judul Portofolio</th>
                                <th scope="col" class="px-6 py-3 font-medium hidden md:table-cell">Kategori</th>
                                <th scope="col" class="px-6 py-3 font-medium hidden lg:table-cell">Tanggal</th>
                                <th scope="col" class="px-6 py-3 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @forelse ($portfolios as $portfolio) --}}
                            {{-- Data Dummy Row 1 --}}
                            <tr class="bg-white border-b hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">Pengembangan Model Deteksi Dini Penyakit Jantung</div>
                                    <div class="text-xs text-slate-500 lg:hidden mt-1">2024 - 2025</div>
                                    <div class="text-xs text-slate-500 md:hidden mt-1">Bidang Penelitian</div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">Bidang Penelitian</td>
                                <td class="px-6 py-4 hidden lg:table-cell">2024 - 2025</td>
                                <td class="px-6 py-4 text-center">
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button @click="open = !open" class="text-slate-500 hover:text-teal-600">
                                            <i class='bx bx-dots-vertical-rounded text-xl'></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20">
                                            <div class="py-1">
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i class='bx bxs-detail mr-2'></i>Detail</a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i class='bx bxs-edit mr-2'></i>Edit</a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class='bx bxs-trash mr-2'></i>Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- Data Dummy Row 2 --}}
                            <tr class="bg-white border-b hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">Pelatihan Kewirausahaan Digital untuk UMKM</div>
                                    <div class="text-xs text-slate-500 lg:hidden mt-1">2023</div>
                                    <div class="text-xs text-slate-500 md:hidden mt-1">Bidang Pengabdian</div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">Bidang Pengabdian</td>
                                <td class="px-6 py-4 hidden lg:table-cell">2023</td>
                                <td class="px-6 py-4 text-center">
                                     <div x-data="{ open: false }" class="relative inline-block">
                                        <button @click="open = !open" class="text-slate-500 hover:text-teal-600">
                                            <i class='bx bx-dots-vertical-rounded text-xl'></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20">
                                            <div class="py-1">
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i class='bx bxs-detail mr-2'></i>Detail</a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i class='bx bxs-edit mr-2'></i>Edit</a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class='bx bxs-trash mr-2'></i>Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            {{-- @empty --}}
                            {{-- Tampilan jika data kosong --}}
                            {{-- <tr>
                                <td colspan="4">
                                    <div class="text-center py-16 px-6">
                                        <i class='bx bxs-folder-open text-6xl text-slate-300'></i>
                                        <h3 class="mt-4 text-lg font-semibold text-slate-700">Belum Ada Portofolio</h3>
                                        <p class="mt-1 text-sm text-slate-500">Mulai tambahkan portofolio pertama Anda untuk melacak pencapaian.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-teal-500 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            <i class='bx bx-plus mr-2'></i>
                                            Tambah Portofolio
                                        </a>
                                    </div>
                                </td>
                            </tr> --}}
                            {{-- @endforelse --}}

                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-200">
                     <div class="flex justify-between items-center text-sm">
                        <div class="text-slate-600">
                            Menampilkan <span class="font-semibold">1</span> sampai <span class="font-semibold">2</span> dari <span class="font-semibold">2</span> data
                        </div>
                        <div class="inline-flex -space-x-px">
                            <button class="px-3 py-1 border border-slate-300 rounded-l-lg hover:bg-slate-100 disabled:opacity-50" disabled>&laquo;</button>
                            <button class="px-3 py-1 border border-slate-300 bg-teal-50 text-teal-600">1</button>
                            <button class="px-3 py-1 border border-slate-300 rounded-r-lg hover:bg-slate-100">&raquo;</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection