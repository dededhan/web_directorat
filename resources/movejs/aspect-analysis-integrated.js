document.addEventListener('DOMContentLoaded', () => {
    // Integrate with existing INDICATOR_CONFIGS
    const INDICATOR_CONFIGS = [
        { id: 1, rows: 21 },
        { id: 2, rows: 21 },
        { id: 3, rows: 21 },
        { id: 4, rows: 22 },
        { id: 5, rows: 24 },
        { id: 6, rows: 24 }
    ];

    // Function to collect aspect scores for all indicators
    function collectAspectScores() {
        const aspectMap = { 
            'T': 'technology',
            'O': 'organization',
            'R': 'risk',
            'M': 'market',
            'P': 'partnership',
            'Mf': 'manufacturing', 
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
                const aspectField = aspectMap[aspectCode];
                const checkedRadio = row.querySelector('input[type="radio"]:checked');
                
                if (checkedRadio && aspectField) {
                    const value = parseInt(checkedRadio.value);
                    if (!isNaN(value)) {
                        aspectScores[aspectField].total += value; // Akumulasi skor
                        aspectScores[aspectField].count++;        // Hitung jumlah pertanyaan
                    }
                }
            });

            // Konversi ke persentase per aspek
            const processedScores = {};
            processedScores.indicator_number = indicatorNumber;
            
            Object.entries(aspectScores).forEach(([key, value]) => {
                if (key === 'indicator_number') {
                    return;
                }
                
                const maxPossible = value.count * 5;
                processedScores[key] = maxPossible > 0 
                    ? ((value.total / maxPossible) * 100).toFixed(2)
                    : 0;
            });

            indicators.push(processedScores);
        });

        return indicators;
    }

    // Initialize aspect analysis and attach listeners
    function initializeAspectAnalysis() {
        // Initialize aspect dropdowns
        document.querySelectorAll('.aspect-dropdown').forEach(dropdown => {
            const aspectCodeElement = dropdown.querySelector('span');
            if (aspectCodeElement) {
                const aspectText = aspectCodeElement.textContent;
                const aspectCodeMatch = aspectText.match(/\((.*?)\)/);
                
                if (aspectCodeMatch && aspectCodeMatch[1]) {
                    const aspectCode = aspectCodeMatch[1];
                    
                    // Ensure the Alpine.js data is properly set
                    if (!dropdown.__x) {
                        console.warn(`Alpine.js not initialized for dropdown with aspect ${aspectCode}`);
                    }
                    
                    // When radio buttons change, update all open charts
                    document.querySelectorAll('.radio-input').forEach(radio => {
                        radio.addEventListener('change', () => {
                            if (window.aspectLegend) {
                                const aspectLegendInstance = window.aspectLegend();
                                
                                // Check if this dropdown is open
                                if (dropdown.__x && dropdown.__x.$data.isOpen) {
                                    // Get the aspect code from data
                                    const currentAspectCode = dropdown.__x.$data.aspectCode;
                                    if (currentAspectCode) {
                                        // Reinitialize the chart with new data
                                        aspectLegendInstance.initializeAspectChart(currentAspectCode);
                                    }
                                }
                            }
                        });
                    });
                }
            }
        });
    }

    // Add a helper function to check if a chart is initialized and visible
    function checkChartsVisibility() {
        document.querySelectorAll('.aspect-dropdown').forEach(dropdown => {
            if (dropdown.__x && dropdown.__x.$data.isOpen) {
                const aspectCode = dropdown.__x.$data.aspectCode;
                if (aspectCode && window.aspectLegend) {
                    window.aspectLegend().initializeAspectChart(aspectCode);
                }
            }
        });
    }

    // Initialize on page load with delay to ensure Alpine.js is ready
    setTimeout(() => {
        initializeAspectAnalysis();
        
        // Add event listeners to all radio buttons for updating charts
        document.querySelectorAll('.radio-input').forEach(radio => {
            radio.addEventListener('change', () => {
                // Update all open charts
                checkChartsVisibility();
                
                // Update scores in hidden form fields
                const scores = collectAspectScores();
                scores.forEach((indicator, index) => {
                    Object.entries(indicator).forEach(([field, value]) => {
                        const input = document.querySelector(
                            `input[name="indicators[${index}][${field}]"]`
                        );
                        if (input) input.value = value;
                    });
                });
                
                console.log('Updated scores after radio change:', scores);
            });
        });
    }, 500);
});