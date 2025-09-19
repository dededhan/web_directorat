@extends('admin_equity.index')

@section('content')
<div x-data="comdev">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Sesi Comdev</h1>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="#" class="hover:text-sky-600">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Community Development</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class='bx bxs-add-to-queue text-xl mr-2 text-sky-600'></i>Input Sesi Proposal Baru
            </h2>
        </div>
        {{-- PERUBAHAN DI SINI: Padding diubah dari p-6 menjadi p-8 --}}
        <div class="p-8">
            <form id="createSessionForm" method="POST" action="{{ route('admin_equity.comdevproposal.store') }}" @submit.prevent="confirmCreate($event.target)">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="space-y-6">
                        <div>
                            <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi / Skema</label>
                            <input type="text" name="nama_sesi" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Contoh: Hibah Penelitian Comdev 2025" required>
                        </div>
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="8" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"></textarea>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label for="dana_maksimal" class="block text-sm font-medium text-gray-700">Dana Maksimal</label>
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500">Rp</span></div>
                                <input type="number" name="dana_maksimal" class="bg-gray-100 pl-8 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="50000000" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Periode Submit</label>
                            <div class="flex items-center mt-1 space-x-2">
                                <input type="date" name="periode_awal" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                <span class="text-gray-500">s/d</span>
                                <input type="date" name="periode_akhir" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Anggota Tim</label>
                            <div class="flex items-center mt-1 space-x-2">
                                <input type="number" name="min_anggota" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Min" required>
                                <span class="text-gray-500">-</span>
                                <input type="number" name="max_anggota" class="bg-gray-100 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Max" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-sky-600 border border-transparent rounded-md font-semibold text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Sesi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b"><h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class='bx bx-list-ul text-xl mr-2 text-sky-600'></i>Daftar Sesi Tersedia</h2></div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nama Sesi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Dana</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Anggota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sessions as $session)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $session->nama_sesi }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($session->periode_awal)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMM Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $session->min_anggota }} - {{ $session->max_anggota }} orang</td>
                            <td class="px-6 py-4">
                                @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tutup</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buka</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="openEditModal({{ $session->id }})" class="text-yellow-600 hover:text-yellow-900" title="Edit"><i class='bx bxs-edit text-lg'></i></button>
                                    <form method="POST" action="{{ route('admin_equity.comdevproposal.destroy', $session->id) }}" x-ref="deleteForm{{$session->id}}">
                                        @csrf @method('DELETE')
                                        <button type="button" @click="confirmDelete({{ $session->id }})" class="text-red-600 hover:text-red-900" title="Hapus"><i class='bx bxs-trash text-lg'></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada sesi proposal yang dibuat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($sessions->hasPages())
        <div class="p-4 border-t bg-gray-50">{{ $sessions->links() }}</div>
        @endif
    </div>

    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="editModalOpen" @click="editModalOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form id="editSessionForm" :action="editFormAction" method="POST" @submit.prevent="confirmUpdate($event.target)">
                    @csrf @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Edit Sesi Proposal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2"><label class="block text-sm">Nama Sesi</label><input type="text" name="nama_sesi" x-model="editData.nama_sesi" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                            <div class="md:col-span-2"><label class="block text-sm">Deskripsi</label><textarea name="deskripsi" x-model="editData.deskripsi" rows="3" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
                            <div><label class="block text-sm">Dana Maksimal</label><input type="number" name="dana_maksimal" x-model="editData.dana_maksimal" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                            <div><label class="block text-sm">Periode Awal</label><input type="date" name="periode_awal" x-model="editData.periode_awal" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                            <div><label class="block text-sm">Periode Akhir</label><input type="date" name="periode_akhir" x-model="editData.periode_akhir" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                            <div><label class="block text-sm">Anggota</label><div class="flex items-center space-x-2"><input type="number" name="min_anggota" x-model="editData.min_anggota" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Min" required><span class="text-gray-500">-</span><input type="number" name="max_anggota" x-model="editData.max_anggota" class="bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Max" required></div></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-medium text-white hover:bg-sky-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan Perubahan</button>
                        <button type="button" @click="editModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection