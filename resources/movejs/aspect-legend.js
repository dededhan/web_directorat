window.aspectLegend = function() {
    return {
        showPopup: false,
        showSpiderwebPopup: false,
        selectedAspect: null,
        charts: {}, // Store chart instances by aspect code
        
        init() {
            this.$watch('showPopup', value => {
                if (value && this.selectedAspect) {
                    this.$nextTick(() => {
                        this.initializeChart(this.selectedAspect.code);
                    });
                }
            });
            
            // Load saved data if available on page load
            this.loadSavedData();
        },
        
        loadSavedData() {
            // Check if we're in edit mode by looking for existing data in the form
            const existingResponses = document.querySelectorAll('input[type="radio"][checked]');
            if (existingResponses.length > 0) {
                console.log('Found existing responses, applying values');
                
                // Select all checked radio buttons
                existingResponses.forEach(radio => {
                    radio.checked = true;
                    
                    // Highlight the row
                    const row = radio.closest('tr');
                    if (row) {
                        row.classList.add('selected-row');
                    }
                });
                
                // Update charts if needed
                if (window.updateSpiderwebChart) {
                    window.updateSpiderwebChart();
                }
            }
        },

        openSpiderwebAnalysis() {
            console.log('Opening spiderweb analysis');
            this.showSpiderwebPopup = true;
            
            this.$nextTick(() => {
                if (window.updateSpiderwebChart) {
                    window.updateSpiderwebChart();
                } else {
                    console.error('updateSpiderwebChart function not found');
                }
            });
        },

        aspectConfig: {
            T: {
                name: 'Aspek Teknologi',
                gradient: 'linear-gradient(135deg, #fad961 0%, #f76b1c 100%)',
                color: '#f76b1c'
            },
            O: {
                name: 'Aspek Organisasi',
                gradient: 'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)',
                color: '#8fd3f4'
            },
            R: {
                name: 'Aspek Risiko',
                gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                color: '#764ba2'
            },
            M: {
                name: 'Aspek Pasar',
                gradient: 'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)',
                color: '#ff9a9e'
            },
            P: {
                name: 'Aspek Kemitraan',
                gradient: 'linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%)',
                color: '#fab2ff'
            },
            Mf: {
                name: 'Aspek Manufaktur',
                gradient: 'linear-gradient(135deg, #f6d365 0%, #fda085 100%)',
                color: '#fda085'
            },
            I: {
                name: 'Aspek Investasi',
                gradient: 'linear-gradient(135deg, #96fbc4 0%, #f9f586 100%)',
                color: '#f9f586'
            }
        },

        openAspectAnalysis(aspectCode) {
            this.selectedAspect = {
                ...this.aspectConfig[aspectCode],
                code: aspectCode
            };
            this.showPopup = true;
        },

        // Method to initialize chart for a specific aspect
        initializeAspectChart(aspectCode) {
            if (!aspectCode) {
                console.error('No aspect code provided for chart initialization');
                return;
            }
            
            console.log(`Initializing chart for aspect: ${aspectCode}`);
            
            const canvasId = `aspectChart-${aspectCode}`;
            const canvas = document.getElementById(canvasId);
            
            if (!canvas) {
                console.error(`Canvas element with ID ${canvasId} not found`);
                return;
            }
            
            // If there's already a chart for this aspect, destroy it first
            if (this.charts[aspectCode]) {
                this.charts[aspectCode].destroy();
            }
            
            const aspectData = this.calculateAspectData(aspectCode);
            const aspectConfig = this.aspectConfig[aspectCode];
            
            if (!aspectConfig) {
                console.error(`No configuration found for aspect: ${aspectCode}`);
                return;
            }
            
            this.charts[aspectCode] = new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: aspectData.map(d => d.level),
                    datasets: [{
                        label: 'Pencapaian (%)',
                        data: aspectData.map(d => d.percentage),
                        borderColor: aspectConfig.color,
                        backgroundColor: aspectConfig.color + '40',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => `Pencapaian: ${context.raw.toFixed(2)}%`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: value => value + '%'
                            }
                        }
                    }
                }
            });
            
            console.log(`Chart initialized for aspect: ${aspectCode}`);
        },

        calculateAspectData(aspectCode) {
            const scores = [];
            
            // Calculate scores for each KATSINOV level
            for (let level = 1; level <= 6; level++) {
                // Find the indicator container for this level
                const indicator = document.querySelector(`[data-indicator="${level}"]`);
                if (!indicator) {
                    console.warn(`Indicator for KATSINOV ${level} not found`);
                    continue;
                }
                
                let levelTotal = 0;
                let maxPossible = 0;
                
                // Get all rows for this aspect in this indicator
                const aspectRows = Array.from(indicator.querySelectorAll('tr'))
                    .filter(row => {
                        const aspectCell = row.querySelector('.aspect-cell');
                        return aspectCell && aspectCell.textContent.trim() === aspectCode;
                    });
                
                // Calculate scores for this aspect's rows
                aspectRows.forEach(row => {
                    const checkedRadio = row.querySelector('input[type="radio"]:checked');
                    if (checkedRadio) {
                        const value = parseInt(checkedRadio.value);
                        if (!isNaN(value)) {
                            levelTotal += value;
                        }
                    }
                    maxPossible += 5; // Maximum possible score per question is 5
                });
                
                const percentage = maxPossible > 0 ? (levelTotal / maxPossible) * 100 : 0;
                
                scores.push({
                    level: `KATSINOV ${level}`,
                    score: levelTotal,
                    maxPossible: maxPossible,
                    percentage: percentage
                });
            }
            
            console.log(`Calculated scores for ${aspectCode}:`, scores);
            return scores;
        },

        // Legacy method for backward compatibility
        initializeChart(aspectCode) {
            return this.initializeAspectChart(aspectCode);
        },

        calculateAverage() {
            if (!this.selectedAspect) return '0.00';
            
            const aspectData = this.calculateAspectData(this.selectedAspect.code);
            const validPercentages = aspectData
                .map(d => d.percentage)
                .filter(p => !isNaN(p));
            
            if (validPercentages.length === 0) return '0.00';
            
            const average = validPercentages.reduce((a, b) => a + b, 0) / validPercentages.length;
            return average.toFixed(2);
        },

        getMaxKatsinovLevel() {
            if (!this.selectedAspect) return 0;
            
            const aspectData = this.calculateAspectData(this.selectedAspect.code);
            let maxLevel = 0;
            
            for (let i = 0; i < aspectData.length; i++) {
                if (aspectData[i].percentage >= 80) {
                    maxLevel = i + 1;
                } else {
                    break;
                }
            }
            
            return maxLevel;
        },

        getStatus() {
            const average = parseFloat(this.calculateAverage());
            if (average >= 80) return 'SANGAT BAIK';
            if (average >= 60) return 'BAIK';
            if (average >= 40) return 'CUKUP';
            if (average >= 20) return 'KURANG';
            return 'SANGAT KURANG';
        },

        getStatusClass() {
            const status = this.getStatus().toLowerCase().replace(' ', '-');
            return `status-${status}`;
        }
    };
};