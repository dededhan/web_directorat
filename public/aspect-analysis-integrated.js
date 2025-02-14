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

    window.aspectLegend = function() {
        return {
            showPopup: false,
            selectedAspect: null,
            chart: null,

            // Aspect configurations matching existing color scheme
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

            calculateAspectData(aspectCode) {
                const aspectScores = [];
                
                // Calculate scores for each KATSINOV level
                INDICATOR_CONFIGS.forEach(config => {
                    const indicator = document.querySelector(`.card:has(.main-title:contains("KATSINOV ${config.id}"))`);
                    if (!indicator) return;

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
                            levelTotal += parseInt(checkedRadio.value);
                        }
                        maxPossible += 5; // Maximum possible score per question
                    });

                    const percentage = maxPossible > 0 ? (levelTotal / maxPossible) * 100 : 0;
                    aspectScores.push({
                        level: `KATSINOV ${config.id}`,
                        score: levelTotal,
                        maxPossible: maxPossible,
                        percentage: percentage
                    });
                });

                return aspectScores;
            },

            initializeChart() {
                const ctx = document.getElementById('aspectChart').getContext('2d');
                
                if (this.chart) {
                    this.chart.destroy();
                }

                const aspectData = this.calculateAspectData(this.selectedAspect.code);
                
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: aspectData.map(d => d.level),
                        datasets: [{
                            label: 'Pencapaian (%)',
                            data: aspectData.map(d => d.percentage),
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

            openAspectAnalysis(aspectCode) {
                this.selectedAspect = {
                    ...this.aspectConfig[aspectCode],
                    code: aspectCode
                };
                this.showPopup = true;
                
                // Initialize chart after popup is shown
                this.$nextTick(() => {
                    this.initializeChart();
                });
            },

            calculateAverage() {
                const aspectData = this.calculateAspectData(this.selectedAspect.code);
                const percentages = aspectData.map(d => d.percentage);
                return (percentages.reduce((a, b) => a + b, 0) / percentages.length).toFixed(2);
            },

            getMaxKatsinovLevel() {
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
            }
        };
    };

    // Initialize aspect analysis
    initializeAspectAnalysis();
});

function initializeAspectAnalysis() {
    // Add click handlers to legend items
    document.querySelectorAll('.legend-item').forEach(item => {
        const aspectCode = item.querySelector('span').textContent.match(/\((.*?)\)/)[1];
        item.setAttribute('data-aspect', aspectCode);
    });
}