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
                        <i class='bx bx-export mr-2'></i>Export QS Responden Data
                    </h5>
                    <button @click="open = false" class="text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>

                <div class="bg-white px-6 py-6">
                    <form id="exportQSForm">
                        <div class="mb-4">
                            <h6 class="font-semibold mb-3 text-gray-700">Export Filters (Optional)</h6>
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="">All Categories</option>
                                        <option value="academic" {{ request('category') === 'academic' ? 'selected' : '' }}>Academic</option>
                                        <option value="employee" {{ in_array(request('category'), ['employee', 'employer']) ? 'selected' : '' }}>Employee</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Input Source (Fakultas)</label>
                                    <select name="fakultas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="">All Sources</option>
                                        <option value="direktorat">Direktorat</option>
                                        <option value="fik">FIK</option>
                                        <option value="feb">FEB</option>
                                        <option value="fkip">FKIP</option>
                                        <option value="faperta">FAPERTA</option>
                                        <option value="fisip">FISIP</option>
                                        <option value="fh">FH</option>
                                        <option value="ft">FT</option>
                                        <option value="fmipa">FMIPA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-semibold mb-3 text-gray-700">Date Range Filter (Optional)</h6>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        value="{{ request('end_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class='bx bx-info-circle text-blue-500 text-xl'></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Export will include all current filters applied above (search, category, country, job title, surveys). The date range is optional and will further filter the results.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="button" id="btnDoQSExport" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class='bx bx-download mr-2'></i>Download Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportBtn = document.getElementById('btnDoQSExport');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                const params = new URLSearchParams(window.location.search);
                const startDate = document.querySelector('#exportQSForm input[name="start_date"]').value;
                const endDate = document.querySelector('#exportQSForm input[name="end_date"]').value;
                const category = document.querySelector('#exportQSForm select[name="category"]').value;
                const fakultas = document.querySelector('#exportQSForm select[name="fakultas"]').value;
                
                if (startDate) params.set('start_date', startDate);
                else params.delete('start_date');
                if (endDate) params.set('end_date', endDate);
                else params.delete('end_date');
                if (category) params.set('category', category);
                else params.delete('category');
                if (fakultas) params.set('fakultas', fakultas);
                else params.delete('fakultas');
                
                const url = `{{ route('admin_pemeringkatan.qsresponden.export') }}` + '?' + params.toString();
                window.location.href = url;
            });
        }
    });
</script>
