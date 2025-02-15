window.aspectLegend = function() {
    return {
        showPopup: false,
        showSpiderwebPopup: false,
        selectedAspect: null,
        chart: null,
        
        init() {
            // Initialize any necessary setup
            this.$watch('showPopup', value => {
                if (value) {
                    this.$nextTick(() => {
                        // Any initialization for the popup
                    });
                }
            });
        },

        openSpiderwebAnalysis() {
            console.log('Opening spiderweb analysis'); // Debug log
            this.showSpiderwebPopup = true;
            
            // Ensure the chart updates after a short delay
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

        init() {
            this.$watch('showPopup', value => {
                if (value) {
                    this.$nextTick(() => {
                        this.initializeChart();
                    });
                }
            });
        },

        openAspectAnalysis(aspectCode) {
            this.selectedAspect = {
                ...this.aspectConfig[aspectCode],
                code: aspectCode,
                data: this.calculateAspectData(aspectCode)
            };
            this.showPopup = true;
        },

        calculateAspectData(aspectCode) {
            // Get all radio inputs for this aspect
            const scores = [];
            for (let level = 1; level <= 6; level++) {
                let levelTotal = 0;
                let maxPossible = 0;
                
                document.querySelectorAll(`[name^="indicator${level}_row"]`).forEach(radio => {
                    const row = radio.closest('tr');
                    if (row && row.querySelector('.aspect-cell').textContent.trim() === aspectCode) {
                        if (radio.checked) {
                            levelTotal += parseInt(radio.value);
                        }
                        maxPossible += 5; // Max possible score per question
                    }
                });

                const percentage = maxPossible > 0 ? (levelTotal / maxPossible) * 100 : 0;
                scores.push({
                    level: `KATSINOV ${level}`,
                    score: levelTotal,
                    maxPossible: maxPossible,
                    percentage: percentage
                });
            }
            return scores;
        },

        initializeChart() {
            const ctx = document.getElementById('aspectChart').getContext('2d');
            
            if (this.chart) {
                this.chart.destroy();
            }

            this.chart = new Chart(ctx, {
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
                                callback: value => value + '%'
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
}
