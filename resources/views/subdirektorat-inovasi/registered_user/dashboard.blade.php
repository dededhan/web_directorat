@extends('subdirektorat-inovasi.registered_user.index')

@section('contentregistered_user')
    <div class="space-y-6 p-6">
        {{-- Header Section --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-600 via-teal-500 to-cyan-500 p-8 shadow-lg">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5"></div>
            <div class="absolute -right-12 -top-12 h-64 w-64 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-8 -right-8 h-48 w-48 rounded-full bg-white/10"></div>
            
            <div class="relative z-10">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1.5 backdrop-blur-sm">
                    <i class='bx bxs-user-circle text-white'></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-white">Dashboard User</span>
                </div>
                <h1 class="text-4xl font-bold text-white">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="mt-3 text-base text-teal-50">Lengkapi pembayaran registrasi Anda untuk mengaktifkan akun.</p>
            </div>
        </section>

        {{-- Alert Info --}}
        <div class="rounded-2xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-cyan-50 p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100">
                    <i class='bx bx-info-circle text-2xl text-blue-600'></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-blue-900">Informasi Penting</h3>
                    <p class="mt-1 text-sm text-blue-800">Silakan upload bukti pembayaran Anda untuk mengkonfirmasi registrasi. Akun Anda akan diaktifkan setelah pembayaran terverifikasi.</p>
                </div>
            </div>
        </div>

        {{-- Payment Form Card --}}
        <div class="rounded-3xl bg-white p-8 shadow-xl">
            <div class="mb-8 flex items-center justify-between border-b border-gray-200 pb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Upload Bukti Pembayaran</h2>
                    <p class="mt-1 text-sm text-gray-500">Upload bukti transfer untuk verifikasi pembayaran</p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-500">
                    <i class='bx bx-receipt text-2xl text-white'></i>
                </div>
            </div>

            <form id="payment-form" method="POST" action="#" enctype="multipart/form-data">
                @csrf
                
                {{-- Payment Information Card --}}
                <div class="mb-8 rounded-2xl border-2 border-teal-200 bg-gradient-to-br from-teal-50 to-cyan-50 p-6">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100">
                            <i class='bx bx-credit-card text-xl text-teal-600'></i>
                        </div>
                        <h3 class="text-lg font-bold text-teal-900">Informasi Pembayaran</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between rounded-lg bg-white p-3">
                            <span class="text-sm text-gray-600">Bank Transfer</span>
                            <span class="font-bold text-gray-800">Bank Mandiri</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-white p-3">
                            <span class="text-sm text-gray-600">Nomor Rekening</span>
                            <span class="font-mono font-bold text-gray-800">1234-5678-9012-3456</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-white p-3">
                            <span class="text-sm text-gray-600">Nama Rekening</span>
                            <span class="font-bold text-gray-800">Pusat Inovasi dan Teknologi</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-white p-3">
                            <span class="text-sm text-gray-600">Jumlah Transfer</span>
                            <span class="text-xl font-bold text-teal-600">Rp 500.000</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 rounded-xl border-2 border-amber-300 bg-amber-50 p-4">
                        <div class="flex items-start gap-3">
                            <i class='bx bx-error-circle text-xl text-amber-600'></i>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-amber-900">Catatan Penting:</p>
                                <p class="mt-1 text-xs text-amber-800">Pastikan pembayaran Anda mencantumkan <strong>nama lengkap</strong> dan <strong>nomor registrasi</strong> pada keterangan transaksi.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Upload Area --}}
                <div class="mb-8">
                    <label for="payment_receipt" class="mb-3 block text-sm font-semibold text-gray-700">
                        Bukti Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="cursor-pointer rounded-2xl border-3 border-dashed border-teal-300 bg-gradient-to-br from-teal-50/50 to-cyan-50/50 p-12 text-center transition-all hover:border-teal-400 hover:bg-teal-50/70" 
                         id="uploadArea">
                        <div class="mb-4 flex justify-center">
                            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-teal-100">
                                <i class='bx bx-upload upload-icon text-5xl text-teal-600'></i>
                            </div>
                        </div>
                        <div class="upload-text">
                            <p class="mb-2 text-base font-semibold text-gray-700">Drag and drop file Anda di sini</p>
                            <p class="mb-4 text-sm text-gray-500">atau</p>
                            <button type="button" class="browse-btn inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 px-6 py-3 font-semibold text-white transition-all hover:from-teal-600 hover:to-cyan-600 hover:shadow-lg" id="browseBtn">
                                <i class='bx bx-folder-open'></i>
                                Pilih File
                            </button>
                        </div>
                        <input type="file" name="payment_receipt" id="payment_receipt" class="hidden" accept="image/*,application/pdf" hidden>
                    </div>
                    
                    <div class="mt-4 rounded-xl bg-gray-50 p-4">
                        <p class="mb-2 text-xs font-semibold text-gray-700">Persyaratan File:</p>
                        <ul class="space-y-1.5 text-xs text-gray-600">
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check-circle text-teal-500'></i>
                                <span>Upload gambar yang jelas dari bukti pembayaran/screenshot transfer</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check-circle text-teal-500'></i>
                                <span>Format yang diterima: JPG, PNG, atau PDF</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check-circle text-teal-500'></i>
                                <span>Pastikan semua detail pembayaran terlihat jelas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check-circle text-teal-500'></i>
                                <span>Ukuran file maksimal: 5MB</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Confirmation Checkbox --}}
                <div class="mb-8">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border-2 border-gray-200 bg-gray-50 p-4 transition-all hover:border-teal-400 hover:bg-teal-50/30">
                        <input type="checkbox" id="payment_confirm" name="payment_confirm" required 
                               class="mt-1 h-5 w-5 rounded border-gray-300 text-teal-600 focus:ring-2 focus:ring-teal-500">
                        <span class="flex-1 text-sm text-gray-700">
                            Saya mengkonfirmasi bahwa saya telah menyelesaikan pembayaran dan bukti transfer yang diupload adalah <strong>valid dan benar</strong>.
                        </span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 px-8 py-4 font-bold text-white shadow-lg transition-all hover:from-teal-600 hover:to-cyan-600 hover:shadow-xl">
                        <i class='bx bx-check-circle text-xl'></i>
                        Submit Pembayaran
                    </button>
                </div>
            </form>
        </div>

        {{-- Payment Status Card --}}
        <div class="rounded-3xl bg-white p-8 shadow-xl">
            <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Status Pembayaran</h2>
                    <p class="mt-1 text-sm text-gray-500">Pantau status verifikasi pembayaran Anda</p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500">
                    <i class='bx bx-time-five text-2xl text-white'></i>
                </div>
            </div>
            
            <div class="rounded-2xl border-2 border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-6">
                <div class="flex items-start gap-5">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-400 shadow-lg">
                        <i class='bx bx-time text-3xl text-white'></i>
                    </div>
                    <div class="flex-1">
                        <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-amber-500"></span>
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700">Pending</span>
                        </div>
                        <h3 class="text-xl font-bold text-amber-900">Pembayaran Menunggu Verifikasi</h3>
                        <p class="mt-2 text-sm text-amber-800">Pembayaran Anda sedang menunggu verifikasi oleh tim admin. Proses verifikasi biasanya memakan waktu 1-2 hari kerja.</p>
                        <div class="mt-4 flex items-center gap-2 text-xs text-amber-700">
                            <i class='bx bx-calendar'></i>
                            <span class="font-semibold">Disubmit:</span>
                            <span>28 Maret 2025</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('payment_receipt');
            const browseBtn = document.getElementById('browseBtn');
            
            // Browse button click handler
            browseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });
            
            // Upload area click handler
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            // File selected handler
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name;
                    
                    // Show file name in upload area
                    const uploadText = document.querySelector('.upload-text p:first-child');
                    uploadText.textContent = `File terpilih: ${fileName}`;
                    uploadText.classList.remove('text-gray-700');
                    uploadText.classList.add('text-green-700', 'font-bold');
                    
                    // Change upload area style
                    uploadArea.classList.remove('border-teal-300', 'bg-gradient-to-br', 'from-teal-50/50', 'to-cyan-50/50');
                    uploadArea.classList.add('border-green-400', 'bg-green-50');
                    
                    // Change icon
                    const uploadIcon = document.querySelector('.upload-icon');
                    uploadIcon.classList.remove('bx-upload', 'text-teal-600');
                    uploadIcon.classList.add('bx-check-circle', 'text-green-600');
                }
            });
            
            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Highlight drop area when dragging over it
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                uploadArea.classList.add('ring-4', 'ring-teal-200', 'scale-[1.02]');
            }
            
            function unhighlight() {
                uploadArea.classList.remove('ring-4', 'ring-teal-200', 'scale-[1.02]');
            }
            
            // Handle dropped files
            uploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                if (files.length > 0) {
                    const fileName = files[0].name;
                    
                    // Show file name in upload area
                    const uploadText = document.querySelector('.upload-text p:first-child');
                    uploadText.textContent = `File terpilih: ${fileName}`;
                    uploadText.classList.remove('text-gray-700');
                    uploadText.classList.add('text-green-700', 'font-bold');
                    
                    // Change upload area style
                    uploadArea.classList.remove('border-teal-300', 'bg-gradient-to-br', 'from-teal-50/50', 'to-cyan-50/50');
                    uploadArea.classList.add('border-green-400', 'bg-green-50');
                    
                    // Change icon
                    const uploadIcon = document.querySelector('.upload-icon');
                    uploadIcon.classList.remove('bx-upload', 'text-teal-600');
                    uploadIcon.classList.add('bx-check-circle', 'text-green-600');
                }
            }
            
            // Form submission
            const paymentForm = document.getElementById('payment-form');
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validation: check if file is selected
                if (fileInput.files.length === 0) {
                    alert('Mohon upload bukti pembayaran terlebih dahulu!');
                    return;
                }
                
                // Here you would normally process the form submission
                // For now, just show a success message
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil Disubmit!',
                    text: 'Bukti pembayaran Anda telah diterima. Tim kami akan memverifikasi pembayaran dalam 1-2 hari kerja.',
                    confirmButtonColor: '#14b8a6',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
@endsection