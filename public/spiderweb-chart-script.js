document.addEventListener('DOMContentLoaded', function() {
    let spiderwebChart;
    
    function collectAspectScores() {
        const aspectMap = { 
            'T': 'technology',
            'O': 'organization',
            'R': 'risk',
            'M': 'market',
            'P': 'partnership',
            'Mf': 'manufacturing', // Fixed to match other code
            'I': 'investment'
        };
    
        const indicators = [];
        
        document.querySelectorAll('[data-indicator]').forEach((card) => {
            const indicatorNumber = parseInt(card.dataset.indicator);
            const aspectScores = {
                indicator_number: indicatorNumber,
                technology: { total: 0, count: 0 },
                organization: { total: 0, count: 0 },
                risk: { total: 0, count: 0 },
                market: { total: 0, count: 0 },
                partnership: { total: 0, count: 0 },
                manufacturing: { total: 0, count: 0 },
                investment: { total: 0, count: 0 }
            };
    
            // Hitung skor per aspek dalam indikator ini
            card.querySelectorAll('tr').forEach(row => {
                const aspectCell = row.querySelector('.aspect-cell');
                if (!aspectCell) return;
    
                const aspectCode = aspectCell.textContent.trim();
                
                // Skip if aspect code is not in the mapping
                if (!aspectMap[aspectCode]) {
                    console.warn('Unknown aspect code:', aspectCode);
                    return;
                }
                
                const aspectField = aspectMap[aspectCode];
                const checkedRadio = row.querySelector('input[type="radio"]:checked');
                
                if (checkedRadio && aspectField) {
                    const value = parseInt(checkedRadio.value);
                    
                    if (!isNaN(value)) {
                        aspectScores[aspectField].total += value; // Akumulasi skor
                        aspectScores[aspectField].count++; // Hitung jumlah pertanyaan
                    }
                }
            });
    
            // Konversi ke persentase per aspek
            const processedScores = {
                indicator_number: indicatorNumber
            };
            
            Object.entries(aspectScores).forEach(([key, value]) => {
                if (key === 'indicator_number') {
                    return;
                }
                
                const maxPossible = value.count * 5;
                processedScores[key] = maxPossible > 0 
                    ? ((value.total / maxPossible) * 100)
                    : 0;
            });
    
            indicators.push(processedScores);
        });
    
        console.log('Calculated aspect scores:', indicators);
        return indicators;
    }
        
    function initSpiderwebChart() {
        const ctx = document.getElementById('spiderwebChart');
        if (!ctx) {
            console.error('Spiderweb chart canvas not found');
            return;
        }
        
        const ctxObj = ctx.getContext('2d');
        spiderwebChart = new Chart(ctxObj, {
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
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.r.toFixed(1) + '%';
                            }
                        }
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
            'Mf': { total: 0, count: 0 },
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

                const aspect = aspectCell.textContent.trim();
                if (!aspects.hasOwnProperty(aspect)) return;

                const checkedRadio = row.querySelector('input[type="radio"]:checked');
                
                if (checkedRadio) {
                    const value = parseInt(checkedRadio.value);
                    if (!isNaN(value)) {
                        aspects[aspect].total += value;
                        aspects[aspect].count++;
                    }
                }
            });
        });

        console.log('Raw aspect values:', aspects);

        // Calculate percentage for each aspect
        const values = [
            calculatePercentage(aspects['T']),   // Technology
            calculatePercentage(aspects['O']),   // Organization
            calculatePercentage(aspects['R']),   // Risk
            calculatePercentage(aspects['M']),   // Market
            calculatePercentage(aspects['P']),   // Partnership
            calculatePercentage(aspects['Mf']),  // Manufacturing
            calculatePercentage(aspects['I'])    // Investment
        ];

        return values;
    }

    function calculatePercentage(aspect) {
        if (aspect.count === 0) return 0;
        return (aspect.total / (aspect.count * 5)) * 100;
    }

    function updateSpiderwebChart() {
        if (!spiderwebChart) {
            console.warn('Spiderweb chart not initialized yet');
            initSpiderwebChart();
            if (!spiderwebChart) return;
        }
        
        const values = calculateAspectValues();
        console.log('Calculated aspect values for chart:', values);
        
        spiderwebChart.data.datasets[0].data = values;
        spiderwebChart.update();

        // Update summary elements
        updateSummaryElements(values);
    }
    
    function updateSummaryElements(values) {
        // Calculate statistics
        const average = values.reduce((a, b) => a + b, 0) / values.length;
        const fulfilled = values.filter(value => value >= 80).length;
        
        // Find highest consecutive level
        let highestLevel = 0;
        for (let i = 0; i < values.length; i++) {
            if (values[i] >= 80) {
                highestLevel = i + 1;
            } else {
                break;
            }
        }
        
        // Update UI elements
        const rataRataPencapaianEl = document.querySelector('.rata-rata-pencapaian');
        const aspekTerpenuhinya = document.querySelector('.aspek-terpenuhi');
        const statusKeseluruhanEl = document.querySelector('.status-keseluruhan');
        const katsinovLevelElement = document.querySelector('.katsinov-indicator .value');
        const katsinovDescriptionElement = document.querySelector('.katsinov-indicator .description');

        // Update average display
        if (rataRataPencapaianEl) {
            rataRataPencapaianEl.textContent = average.toFixed(1) + '%';
        }

        // Update fulfilled aspects count
        if (aspekTerpenuhinya) {
            aspekTerpenuhinya.textContent = fulfilled + ' dari 7';
        }
        
        // Update overall status
        if (statusKeseluruhanEl) {
            const status = average >= 80 ? 'TERPENUHI' : 'BELUM TERPENUHI';
            statusKeseluruhanEl.textContent = status;
            
            // Add color class
            statusKeseluruhanEl.className = 'status-keseluruhan text-xl font-bold ' + 
                (status === 'TERPENUHI' ? 'text-green-600' : 'text-red-600');
        }
        
        // Update KATSINOV level if present
        if (katsinovLevelElement) {
            katsinovLevelElement.textContent = highestLevel.toString();
        }
        
        if (katsinovDescriptionElement) {
            katsinovDescriptionElement.textContent = 
                `KATSINOV yang dicapai adalah = KATSINOV ${highestLevel} (${highestLevel > 0 ? 'yang indikatornya terpenuhi' : 'belum ada yang terpenuhi'})`;
        }
    }

    // Initialize chart when document is ready
    if (document.getElementById('spiderwebChart')) {
        initSpiderwebChart();
        
        // Add event listener for all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', updateSpiderwebChart);
        });
        
        // Expose update function globally
        window.updateSpiderwebChart = updateSpiderwebChart;
        
        // Initial update
        setTimeout(updateSpiderwebChart, 100); // Small delay to ensure DOM is ready
    }
});