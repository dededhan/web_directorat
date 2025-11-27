<!-- Image Preview Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex justify-between items-center">
            <h3 id="modalTitle" class="text-xl font-semibold text-white">Cover Image</h3>
            <button type="button" 
                    onclick="document.getElementById('imageModal').classList.add('hidden')"
                    class="text-white hover:text-gray-300 transition-colors">
                <i class='bx bx-x text-3xl'></i>
            </button>
        </div>
        <div class="p-6 flex items-center justify-center bg-gray-50">
            <img id="modalImage" 
                 src="" 
                 alt="Activity Cover" 
                 class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
        </div>
    </div>
</div>
