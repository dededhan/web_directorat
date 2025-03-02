// Initialize chart when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Data jumlah pengunjung per bulan
    const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni"];
    const data = {
        labels: labels,
        datasets: [{
            label: "Jumlah Pengunjung",
            data: [120, 150, 180, 200, 250, 300], // Data pengunjung
            backgroundColor: "rgba(0, 128, 128, 0.2)",
            borderColor: "rgba(0, 128, 128, 1)",
            borderWidth: 1
        }]
    };

    // Konfigurasi chart
    const config = {
        type: "bar", // Jenis chart: bar, line, pie, dll.
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false, // Mengatur rasio chart agar bisa menyesuaikan container
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Render chart
    const ctx = document.getElementById("visitorChart");
    if (ctx) {
        const visitorChart = new Chart(ctx, config);
    }
    
    // Regular counter animation for other statistics
    const regularCounters = document.querySelectorAll('.akreditasi-number, .quick-stat-item .stat-number');
    regularCounters.forEach(counter => {
        const target = parseInt(counter.textContent.replace(/,/g, ''));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps approx
        
        // Starting from 0
        if(!isNaN(target)) {
            counter.textContent = '0';
            
            let count = 0;
            const updateCount = () => {
                if(count < target) {
                    count += increment;
                    counter.textContent = Math.ceil(count).toLocaleString();
                    requestAnimationFrame(updateCount);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };
            
            updateCount();
        }
    });
    
    // Fast scrolling animation specifically for UNJ DALAM PRESTASI numbers
    const prestasiCounters = document.querySelectorAll('.prestasi-number');
    prestasiCounters.forEach(counter => {
        const target = parseInt(counter.textContent.replace(/,/g, ''));
        const duration = 1000; // 1 second - faster animation
        
        // Starting from a higher percentage of the target value
        if(!isNaN(target)) {
            const startPercentage = 0.7; // Start from 70% of the target value
            let startValue = Math.floor(target * startPercentage);
            counter.textContent = startValue.toLocaleString();
            
            // Calculate increment for smoother animation
            const frameDuration = 16; // ~60fps
            const totalFrames = duration / frameDuration;
            const increment = (target - startValue) / totalFrames;
            
            let currentValue = startValue;
            const updateCount = () => {
                if(currentValue < target) {
                    currentValue += increment;
                    counter.textContent = Math.ceil(currentValue).toLocaleString();
                    requestAnimationFrame(updateCount);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };
            
            // Start immediately
            updateCount();
        }
    });
});