window.aspectLegend = function() {
    return {
        showPopup: false,
        selectedAspect: null,
        chart: null,
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
            // Ensure the aspect code matches the configuration
            const normalizedCode = aspectCode === 'Mf' ? 'Mf' : aspectCode;
            
            // Check if the aspect exists in the configuration
            if (!this.aspectConfig[normalizedCode]) {
                console.error('Invalid aspect code:', aspectCode);
                return;
            }

            // Set the selected aspect with calculation
            this.selectedAspect = {
                ...this.aspectConfig[normalizedCode],
                code: normalizedCode,
                data: this.calculateAspectData(normalizedCode)
            };

            // Ensure popup is shown
            this.showPopup = true;

            // Delay chart initialization to ensure DOM is ready
            setTimeout(() => {
                this.initializeChart();
            }, 50);
        },

        calculateAspectData(aspectCode) {
            const KATSINOV_LEVELS = 6;
            const scores = [];

            for (let level = 1; level <= KATSINOV_LEVELS; level++) {
                const levelRows = document.querySelectorAll(`[name^="indicator${level}_row"]`);
                
                let levelTotal = 0;
                let maxPossible = 0;
                let aspectRowsCount = 0;

                levelRows.forEach(radio => {
                    const row = radio.closest('tr');
                    if (row && row.querySelector('.aspect-cell').textContent.trim() === aspectCode) {
                        aspectRowsCount++;
                        maxPossible += 5; // Each row can score max 5
                        if (radio.checked) {
                            levelTotal += parseInt(radio.value);
                        }
                    }
                });

                const percentage = aspectRowsCount > 0 
                    ? (levelTotal / (aspectRowsCount * 5)) * 100 
                    : 0;

                scores.push({
                    level: `KATSINOV ${level}`,
                    score: levelTotal,
                    maxPossible: aspectRowsCount * 5,
                    percentage: percentage
                });
            }

            return scores;
        },

        initializeChart() {
            const ctx = document.getElementById('aspectChart');
            
            // Ensure context exists
            if (!ctx) {
                console.error('Chart canvas not found');
                return;
            }

            // Destroy existing chart if it exists
            if (this.chart) {
                this.chart.destroy();
            }

            // Get 2D context
            const context = ctx.getContext('2d');

            this.chart = new Chart(context, {
                type: 'line',
                data: {
                    labels: this.selectedAspect.data.map(d => d.level),
                    datasets: [{
                        label: 'Achievement (%)',
                        data: this.selectedAspect.data.map(d => d.percentage),
                        borderColor: this.selectedAspect.color,
                        backgroundColor: this.selectedAspect.color + '40',
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
                                callback: value => `${value}%`
                            }
                        }
                    }
                }
            });
        },

        calculateAverage() {
            const percentages = this.selectedAspect.data.map(d => d.percentage);
            const average = percentages.reduce((a, b) => a + b, 0) / percentages.length;
            return average.toFixed(2);
        },

        getMaxKatsinovLevel() {
            let maxLevel = 0;
            for (let i = 0; i < this.selectedAspect.data.length; i++) {
                if (this.selectedAspect.data[i].percentage >= 80) {
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