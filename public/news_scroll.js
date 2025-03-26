document.addEventListener('DOMContentLoaded', function() {

    
    // Save button functionality (just for demonstration)
    if (simpanBtn) {
        simpanBtn.addEventListener('click', function() {
            const judul = document.getElementById('judul_pengumuman').value;
            const isi = document.getElementById('isi_pengumuman').value;
            
            if (!judul || !isi) {
                alert('Mohon isi judul dan isi pengumuman terlebih dahulu');
                return;
            }
            
            // Simulate saving
            simpanBtn.disabled = true;
            simpanBtn.innerHTML = '<i class="spinner-border spinner-border-sm" role="status"></i> Menyimpan...';
            
            setTimeout(function() {
                simpanBtn.disabled = false;
                simpanBtn.innerHTML = 'Simpan Pengumuman';
                alert('Pengumuman berhasil disimpan');
                
                // Reset form
                document.getElementById('pengumuman-form').reset();
                document.getElementById('preview-icon').textContent = '';
                document.getElementById('preview-title').textContent = '';
                document.getElementById('preview-content').textContent = '';
            }, 1000);
        });
    }
    
    // Delete confirmation
    document.querySelectorAll('.delete-pengumuman').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
                // Simulate deletion (for demonstration)
                const row = this.closest('tr');
                row.style.backgroundColor = '#ffcccc';
                setTimeout(() => {
                    row.remove();
                }, 500);
            }
        });
    });
    
    // Edit functionality
    document.querySelectorAll('.edit-pengumuman').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const icon = row.cells[1].textContent;
            const judul = row.cells[2].textContent;
            const isi = row.cells[3].textContent;
            
            // Populate form
            document.getElementById('icon').value = icon.trim();
            document.getElementById('judul_pengumuman').value = judul;
            document.getElementById('isi_pengumuman').value = isi;
            
            // Update preview
            document.getElementById('preview-icon').textContent = icon + ' ';
            document.getElementById('preview-title').textContent = judul;
            document.getElementById('preview-content').textContent = ' ' + isi;
            
            // Scroll to form
            document.querySelector('.order').scrollIntoView({ behavior: 'smooth' });
        });
    });
});