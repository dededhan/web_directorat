<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Equity Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('comdev', () => ({
                // Properti untuk state management
                editModalOpen: false,
                editData: {},
                editFormAction: '',

                // Fungsi yang dipanggil saat halaman dimuat
                init() {
                    const successMessage = document.body.dataset.success;
                    const errorMessage = document.body.dataset.error;
                    if (successMessage) Swal.fire({ title: 'Berhasil!', text: successMessage, icon: 'success', timer: 3000, showConfirmButton: false });
                    if (errorMessage) Swal.fire({ title: 'Gagal!', text: errorMessage, icon: 'error' });
                },

                // Fungsi untuk konfirmasi form create
                confirmCreate(form) {
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Simpan sesi proposal baru ini?', icon: 'question', 
                        showCancelButton: true, confirmButtonColor: '#0ea5e9', cancelButtonColor: '#6b7280', 
                        confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                },

                // Fungsi untuk konfirmasi form delete
                confirmDelete(sessionId) {
                    Swal.fire({
                        title: 'Anda Yakin?', text: 'Sesi yang dihapus tidak dapat dikembalikan!', icon: 'warning',
                        showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) {
                            this.$refs[`deleteForm${sessionId}`].submit();
                        }
                    });
                },

                // Fungsi untuk membuka modal edit
                openEditModal(sessionId) {
                    Swal.fire({ title: 'Memuat Data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    fetch(`/admin_equity/comdevproposal/${sessionId}/detail`)
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            this.editData = data;
                            this.editFormAction = `/admin_equity/comdevproposal/${sessionId}`;
                            this.editModalOpen = true;
                            Swal.close();
                        })
                        .catch(error => Swal.fire('Error!', 'Gagal mengambil detail data.', 'error'));
                },
                
                // Fungsi untuk konfirmasi form update
                confirmUpdate(form) {
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Simpan perubahan pada sesi ini?', icon: 'question',
                        showCancelButton: true, confirmButtonColor: '#0ea5e9', cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) {
                            Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                            const formData = new FormData(form);
                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.editModalOpen = false;
                                    Swal.fire('Berhasil!', data.message, 'success').then(() => window.location.reload());
                                } else {
                                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                                }
                            })
                            .catch(error => Swal.fire('Error!', 'Tidak dapat menghubungi server.', 'error'));
                        }
                    });
                }
            }));
        });
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body
    class="bg-gray-100"
    data-success="{{ session('success') }}"
    data-error="{{ session('error') }}"
>
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-100">
        @include('admin_equity.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin_equity.navbar')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>