<!-- Import Excel Modal -->
<div x-data="{ open: false }" x-cloak>
    <div x-show="open" 
         @open-import-modal.window="open = true"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="open = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4 flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-white">
                        <i class='bx bx-import mr-2'></i>Import Responden from Excel
                    </h5>
                    <button @click="open = false" class="text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>

                <form action="{{ route('admin_pemeringkatan.responden.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-6 py-6">
                        <div class="mb-4">
                            <label for="excelFile" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Excel File <span class="text-red-500">*</span>
                            </label>
                            <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                                type="file" id="excelFile" name="file" accept=".xlsx,.xls" required>
                            <p class="mt-2 text-xs text-gray-500">File harus sesuai dengan format yang ditentukan (.xlsx, .xls)</p>
                        </div>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class='bx bx-info-circle text-blue-500 text-xl'></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Pastikan format Excel sesuai dengan template yang disediakan. Data duplikat berdasarkan email akan dilewati.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            <i class='bx bx-upload mr-2'></i>Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Export Filter Modal -->
<div x-data="{ open: false }" x-cloak>
    <div x-show="open" 
         @open-export-modal.window="open = true"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="open = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-white">
                        <i class='bx bx-export mr-2'></i>Filter Export Data
                    </h5>
                    <button @click="open = false" class="text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>

                <div class="bg-white px-6 py-6">

                    <div class="mb-4">
                        <label for="exportFilterCategory" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="exportFilterCategory">
                            <option value="">Semua Kategori</option>
                            <option value="academic">Academic</option>
                            <option value="employer">Employee</option>
                        </select>
                    </div>


                    <div class="mb-4">
                        <label for="exportFilterFakultas" class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="exportFilterFakultas">
                            <option value="">Semua Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fpsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fikk">FIKK</option>
                            <option value="fish">FISH</option>
                            <option value="feb">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="exportFilterStatus" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="exportFilterStatus">
                            <option value="">Semua Status</option>
                            <option value="belum">Belum di-email</option>
                            <option value="done">Sudah di-email, belum di-follow up</option>
                            <option value="dones">Sudah di-email, sudah di-follow up</option>
                            <option value="clear">Selesai</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="exportFilterSumberData" class="block text-sm font-medium text-gray-700 mb-2">Sumber Data</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="exportFilterSumberData">
                            <option value="">Semua Sumber</option>
                            <option value="admin_only">Admin Direktorat</option>
                            <option value="non_admin">Fakultas & Prodi</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="exportStartDate" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="exportStartDate">
                        </div>
                        <div>
                            <label for="exportEndDate" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="exportEndDate">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition" id="exportFilteredCSV">
                        <i class='bx bx-file mr-2'></i>Export CSV
                    </button>
                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" id="exportFilteredExcel">
                        <i class='bx bx-download mr-2'></i>Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Export filtered Excel
    document.getElementById('exportFilteredExcel')?.addEventListener('click', function() {
        const category = document.getElementById('exportFilterCategory').value;
        const fakultas = document.getElementById('exportFilterFakultas').value;
        const status = document.getElementById('exportFilterStatus').value;
        const sumberData = document.getElementById('exportFilterSumberData').value;
        const startDate = document.getElementById('exportStartDate').value;
        const endDate = document.getElementById('exportEndDate').value;

        let params = new URLSearchParams();
        if (category) params.append('kategori', category);
        if (fakultas) params.append('fakultas', fakultas);
        if (status) params.append('status', status);
        if (sumberData) params.append('sumber_data', sumberData);
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);

        window.location.href = `{{ route('admin_pemeringkatan.responden.export.excel') }}?${params.toString()}`;
    });

    // Export filtered CSV
    document.getElementById('exportFilteredCSV')?.addEventListener('click', function() {
        const category = document.getElementById('exportFilterCategory').value;
        const fakultas = document.getElementById('exportFilterFakultas').value;
        const status = document.getElementById('exportFilterStatus').value;
        const sumberData = document.getElementById('exportFilterSumberData').value;
        const startDate = document.getElementById('exportStartDate').value;
        const endDate = document.getElementById('exportEndDate').value;

        let params = new URLSearchParams();
        if (category) params.append('kategori', category);
        if (fakultas) params.append('fakultas', fakultas);
        if (status) params.append('status', status);
        if (sumberData) params.append('sumber_data', sumberData);
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);

        window.location.href = `{{ route('admin_pemeringkatan.responden.export.csv') }}?${params.toString()}`;
    });
</script>
