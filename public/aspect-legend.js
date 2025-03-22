window.aspectLegend = function() {
    return {
        showPopup: false,
        showSpiderwebPopup: false,
        selectedAspect: null,
        chart: null,
        
        init() {
            this.$watch('showPopup', value => {
                if (value) {
                    this.$nextTick(() => {
                        this.initializeChart();
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

        calculateAspectData(aspectCode) {
            const scores = [];
            const aspectConfigs = [
                { level: 1, selector: `input[name^="indicator1_row"][name$="_${aspectCode}"]:checked` },
                { level: 2, selector: `input[name^="indicator2_row"][name$="_${aspectCode}"]:checked` },
                { level: 3, selector: `input[name^="indicator3_row"][name$="_${aspectCode}"]:checked` },
                { level: 4, selector: `input[name^="indicator4_row"][name$="_${aspectCode}"]:checked` },
                { level: 5, selector: `input[name^="indicator5_row"][name$="_${aspectCode}"]:checked` },
                { level: 6, selector: `input[name^="indicator6_row"][name$="_${aspectCode}"]:checked` }
            ];
            
            aspectConfigs.forEach(config => {
                let levelTotal = 0;
                
                // Count total questions for this aspect in this level
                const allQuestions = document.querySelectorAll(`input[name^="indicator${config.level}_row"][name$="_${aspectCode}"]`);
                const questionsPerRow = 6; // Since each question has 6 radio buttons (0-5)
                const totalQuestions = Math.ceil(allQuestions.length / questionsPerRow);
                const maxPossible = totalQuestions * 5; // Each question can score up to 5 points
                
                // Get checked radio buttons for this level
                const checkedRadios = document.querySelectorAll(config.selector);
                checkedRadios.forEach(radio => {
                    const value = parseInt(radio.value);
                    if (!isNaN(value)) {
                        levelTotal += value;
                    }
                });

                const percentage = maxPossible > 0 ? (levelTotal / maxPossible) * 100 : 0;
                
                scores.push({
                    level: `KATSINOV ${config.level}`,
                    score: levelTotal,
                    maxPossible: maxPossible,
                    percentage: percentage
                });
            });

            console.log(`Calculated scores for ${aspectCode}:`, scores);
            return scores;
        },

        initializeChart() {
            const ctx = document.getElementById('aspectChart');
            if (!ctx) {
                console.error('Canvas element #aspectChart not found');
                return;
            }
            
            const ctxObj = ctx.getContext('2d');
            
            if (this.chart) {
                this.chart.destroy();
            }

            const aspectData = this.calculateAspectData(this.selectedAspect.code);
            
            this.chart = new Chart(ctxObj, {
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

        calculateAverage() {
            const aspectData = this.calculateAspectData(this.selectedAspect.code);
            const validPercentages = aspectData
                .map(d => d.percentage)
                .filter(p => !isNaN(p));
            
            if (validPercentages.length === 0) return '0.00';
            
            const average = validPercentages.reduce((a, b) => a + b, 0) / validPercentages.length;
            return average.toFixed(2);
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
        },

        getStatusClass() {
            const status = this.getStatus().toLowerCase().replace(' ', '-');
            return `status-${status}`;
        }
    };
};