document.addEventListener('DOMContentLoaded', function() {
    let spiderwebChart;
    
    function initSpiderwebChart() {
        const ctx = document.getElementById('spiderwebChart').getContext('2d');
        spiderwebChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: [
                    'Teknologi (T)',
                    'Organisasi (O)', 
                    'Risiko (R)', 
                    'Pasar (M)', 
                    'Kemitraan (P)', 
                    'Manufaktur (Mf)', 
                    'Investasi (I)'
                ],
                datasets: [{
                    label: 'Nilai Aspek KATSINOV',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    fill: true,
                    backgroundColor: 'rgba(23, 99, 105, 0.2)',
                    borderColor: 'rgb(23, 99, 105)',
                    pointBackgroundColor: 'rgb(23, 99, 105)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(23, 99, 105)'
                }]
            },
            options: {
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    function calculateAspectValues() {
        const aspects = {
            'T': { total: 0, count: 0 },
            'O': { total: 0, count: 0 },
            'R': { total: 0, count: 0 },
            'M': { total: 0, count: 0 },
            'P': { total: 0, count: 0 },
            'MF': { total: 0, count: 0 },
            'I': { total: 0, count: 0 }
        };

        // Get all KATSINOV indicator tables
        const indicators = document.querySelectorAll('.katsinov-table');
        
        indicators.forEach(table => {
            // Find all rows with radio buttons
            const rows = table.querySelectorAll('tr:not(.total-row)');
            
            rows.forEach(row => {
                const aspectCell = row.querySelector('.aspect-cell');
                if (!aspectCell) return;

                const aspect = aspectCell.textContent.trim().toUpperCase();
                const checkedRadio = row.querySelector('input[type="radio"]:checked');
                
                if (checkedRadio && aspects.hasOwnProperty(aspect)) {
                    const value = parseInt(checkedRadio.value);
                    if (!isNaN(value)) {
                        aspects[aspect].total += value;
                        aspects[aspect].count++;
                    }
                }
            });
        });

        // Calculate percentage for each aspect
        const values = [
            calculatePercentage(aspects['T']),   // Technology
            calculatePercentage(aspects['O']),   // Organization
            calculatePercentage(aspects['R']),   // Risk
            calculatePercentage(aspects['M']),   // Market
            calculatePercentage(aspects['P']),   // Partnership
            calculatePercentage(aspects['MF']),  // Manufacturing
            calculatePercentage(aspects['I'])    // Investment
        ];

        return values;
    }

    function calculatePercentage(aspect) {
        if (aspect.count === 0) return 0;
        return (aspect.total / (aspect.count * 5)) * 100;
    }

    function updateSpiderwebChart() {
        const values = calculateAspectValues();
        
        if (spiderwebChart) {
            spiderwebChart.data.datasets[0].data = values;
            spiderwebChart.update();
        }

        // Update summary
        const average = values.reduce((a, b) => a + b, 0) / values.length;
        const fulfilled = values.filter(value => value >= 80).length;
        
        // Update KATSINOV level indicator
        const katsinovLevelElement = document.querySelector('.katsinov-indicator .value');
        const katsinovDescriptionElement = document.querySelector('.katsinov-indicator .description');
        
        const highestLevel = values.reduce((level, value, index) => 
            value >= 80 ? Math.max(level, index + 1) : level, 0);
        
        if (katsinovLevelElement) {
            katsinovLevelElement.textContent = highestLevel.toString();
        }
        
        if (katsinovDescriptionElement) {
            katsinovDescriptionElement.textContent = `KATSINOV yang dicapai adalah = KATSINOV ${highestLevel} (yang indikatornya terpenuhi)`;
        }

        // Update overall status elements
        const rataRataPencapaianEl = document.querySelector('.rata-rata-pencapaian');
        const aspekTerpenuhinya = document.querySelector('.aspek-terpenuhi');
        const statusKeseluruhanEl = document.querySelector('.status-keseluruhan');

        if (rataRataPencapaianEl) {
            rataRataPencapaianEl.textContent = average.toFixed(1) + '%';
        }

        if (aspekTerpenuhinya) {
            aspekTerpenuhinya.textContent = fulfilled + ' dari 7';
        }
        
        if (statusKeseluruhanEl) {
            const status = average >= 80 ? 'TERPENUHI' : 'BELUM TERPENUHI';
            statusKeseluruhanEl.textContent = status;
            statusKeseluruhanEl.className = 'status-keseluruhan ' + 
                (status === 'TERPENUHI' ? 'text-green-600' : 'text-red-600');
        }
    }

    // Initialize chart
    initSpiderwebChart();

    // Add event listener for all radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateSpiderwebChart);
    });

    // Expose update function globally
    window.updateSpiderwebChart = updateSpiderwebChart;

    // Initial update
    updateSpiderwebChart();
});