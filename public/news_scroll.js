document.addEventListener("DOMContentLoaded", function () {
    // Save button functionality (just for demonstration)
    if (simpanBtn) {
        simpanBtn.addEventListener("click", function () {
            const judul = document.getElementById("judul_pengumuman").value;
            const isi = document.getElementById("isi_pengumuman").value;

            if (!judul || !isi) {
                alert("Mohon isi judul dan isi pengumuman terlebih dahulu");
                return;
            }

            // Simulate saving
            simpanBtn.disabled = true;
            simpanBtn.innerHTML =
                '<i class="spinner-border spinner-border-sm" role="status"></i> Menyimpan...';

            setTimeout(function () {
                simpanBtn.disabled = false;
                simpanBtn.innerHTML = "Simpan Pengumuman";
                alert("Pengumuman berhasil disimpan");

                // Reset form
                document.getElementById("pengumuman-form").reset();
                document.getElementById("preview-icon").textContent = "";
                document.getElementById("preview-title").textContent = "";
                document.getElementById("preview-content").textContent = "";
            }, 1000);
        });
    }

    // Delete confirmation
    document.querySelectorAll(".delete-pengumuman").forEach((button) => {
        button.addEventListener("click", function () {
            if (confirm("Apakah Anda yakin ingin menghapus pengumuman ini?")) {
                // Simulate deletion (for demonstration)
                const row = this.closest("tr");
                row.style.backgroundColor = "#ffcccc";
                setTimeout(() => {
                    row.remove();
                }, 500);
            }
        });
    });

    // Edit functionality
    document.querySelectorAll(".edit-pengumuman").forEach((button) => {
        button.addEventListener("click", function () {
            const row = this.closest("tr");
            const icon = row.cells[1].textContent;
            const judul = row.cells[2].textContent;
            const isi = row.cells[3].textContent;

            // Populate form
            document.getElementById("icon").value = icon.trim();
            document.getElementById("judul_pengumuman").value = judul;
            document.getElementById("isi_pengumuman").value = isi;

            // Update preview
            document.getElementById("preview-icon").textContent = icon + " ";
            document.getElementById("preview-title").textContent = judul;
            document.getElementById("preview-content").textContent = " " + isi;

            // Scroll to form
            document
                .querySelector(".order")
                .scrollIntoView({ behavior: "smooth" });
        });
    });

    // News scroll functionality
    document.addEventListener("DOMContentLoaded", function () {
        const marquee = document.querySelector(".news-marquee");
        if (!marquee) return; // Exit if marquee element doesn't exist
    
        const announcementsData = document.getElementById("announcements-data");
        if (!announcementsData) return; // Exit if data element doesn't exist
    
        const announcements = JSON.parse(announcementsData.textContent);
    
        if (announcements.length === 0) return;
    
        let currentAnnouncementIndex = 0;
    
        // Function to update the displayed announcement
        function updateAnnouncement(announcement) {
            marquee.innerHTML = `${announcement.icon} <span class="text-yellow-400 font-bold">${announcement.judul_pengumuman}</span> ${announcement.isi_pengumuman}`;
        }
    
        // Initialize with first announcement
        updateAnnouncement(announcements[0]);
    
        // Option 2: Randomly change announcements every 15 seconds
        setInterval(function () {
            const randomIndex = Math.floor(
                Math.random() * announcements.length
            );
            currentAnnouncementIndex = randomIndex;
            updateAnnouncement(announcements[currentAnnouncementIndex]);
        }, 15000);
    });
});
