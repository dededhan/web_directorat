document.querySelectorAll('.radio-input').forEach(radio => {
    radio.addEventListener('change', calculateTotal);
});

function calculateTotal() {
    let total = 0;
    const rows = 21;
    
    for (let i = 1; i <= rows; i++) {
        const selectedRadio = document.querySelector(`input[name="row${i}"]:checked`);
        if (selectedRadio) {
            total += parseInt(selectedRadio.value);
        }
    }
    
    const totalElement = document.querySelector('.total-value');
    totalElement.textContent = total;
    
    const maxPossible = rows * 5;
    const percentage = (total / maxPossible) * 100;
    const percentageElement = document.querySelectorAll('.total-value')[1];
    percentageElement.textContent = percentage.toFixed(2) + '%';
    
    const statusElement = document.querySelector('.status-cell');
    statusElement.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';
}
document.addEventListener('DOMContentLoaded', () => {
    // First, uniquely name radio buttons for each indicator
    const indicators = document.querySelectorAll('.card');
    indicators.forEach((indicator, index) => {
        const indicatorNum = indicator.querySelector('.main-title')?.textContent.match(/\d+/)?.[0] || index + 1;
        indicator.querySelectorAll('.radio-input').forEach(radio => {
            const rowNum = radio.getAttribute('name').replace('row', '');
            radio.setAttribute('name', `indicator${indicatorNum}_row${rowNum}`);
        });
        
        // Add indicator-specific event listeners
        indicator.querySelectorAll('.radio-input').forEach(radio => {
            radio.addEventListener('change', () => calculateTotal(indicator));
        });
    });

    function calculateTotal(card) {
        let total = 0;
        let countRows = 0;
        
        // Get all checked radios within this card only
        const checkedRadios = card.querySelectorAll('input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            total += parseInt(radio.value);
        });

        // Count total questions in this card
        countRows = card.querySelectorAll('tr:not(.total-row)').length - 1; // Subtract header row

        const maxPossible = countRows * 5;
        const percentage = (total / maxPossible) * 100;

        // Update values for this card only
        const totalValue = card.querySelector('.total-value');
        const percentageValue = card.querySelectorAll('.total-value')[1];
        const statusCell = card.querySelector('.status-cell');

        if (totalValue) totalValue.textContent = total;
        if (percentageValue) percentageValue.textContent = percentage.toFixed(2) + '%';
        if (statusCell) statusCell.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';
    }
});
document.addEventListener('DOMContentLoaded', () => {
    // First, uniquely name radio buttons for indicator 3
    const indicator = document.querySelector('.card');
    const radioInputs = indicator.querySelectorAll('.radio-input');
    
    radioInputs.forEach(radio => {
        const rowNum = radio.getAttribute('name').replace('row', '');
        radio.setAttribute('name', `indicator3_row${rowNum}`);
        radio.addEventListener('change', () => calculateTotal(indicator));
    });

    function calculateTotal(card) {
        let total = 0;
        const checkedRadios = card.querySelectorAll('input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            total += parseInt(radio.value);
        });

        // For indicator 3, we have 21 rows
        const countRows = 21;
        const maxPossible = countRows * 5;
        const percentage = (total / maxPossible) * 100;

        const totalValue = card.querySelector('.total-value');
        const percentageValue = card.querySelectorAll('.total-value')[1];
        const statusCell = card.querySelector('.status-cell');

        if (totalValue) totalValue.textContent = total;
        if (percentageValue) percentageValue.textContent = percentage.toFixed(2) + '%';
        if (statusCell) statusCell.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';
    }
});
    document.querySelectorAll('.row-r').forEach(row => {
  const aspectCell = row.querySelector('.aspect-cell');
  const aspect = aspectCell.textContent.trim();
  
  switch(aspect) {
    case 'T':
      row.style.backgroundColor = 'rgba(254, 215, 170, 0.3)'; // orange-200 with opacity
      break;
    case 'O':
      row.style.backgroundColor = 'rgba(167, 243, 208, 0.3)'; // emerald-200 with opacity
      break;
    case 'R':
      row.style.backgroundColor = 'rgba(199, 210, 254, 0.3)'; // indigo-200 with opacity
      break;
    case 'M':
      row.style.backgroundColor = 'rgba(251, 207, 232, 0.3)'; // pink-200 with opacity
      break;
    case 'P':
      row.style.backgroundColor = 'rgba(245, 208, 254, 0.3)'; // fuchsia-200 with opacity
      break;
    case 'MF':
      row.style.backgroundColor = 'rgba(253, 230, 138, 0.3)'; // amber-200 with opacity
      break;
    case 'I':
      row.style.backgroundColor = 'rgba(217, 249, 157, 0.3)'; // lime-200 with opacity
      break;
  }
});
document.addEventListener('DOMContentLoaded', () => {
    const indicator = document.querySelector('.card');
    const radioInputs = indicator.querySelectorAll('.radio-input');
    
    radioInputs.forEach(radio => {
        const rowNum = radio.getAttribute('name').replace('row', '');
        radio.setAttribute('name', `indicator4_row${rowNum}`);
        radio.addEventListener('change', () => calculateTotal(indicator));
    });

    function calculateTotal(card) {
        let total = 0;
        const checkedRadios = card.querySelectorAll('input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            total += parseInt(radio.value);
        });

        // For indicator 4, we have 22 rows
        const countRows = 22;
        const maxPossible = countRows * 5;
        const percentage = (total / maxPossible) * 100;

        const totalValue = card.querySelector('.total-value');
        const percentageValue = card.querySelectorAll('.total-value')[1];
        const statusCell = card.querySelector('.status-cell');

        if (totalValue) totalValue.textContent = total;
        if (percentageValue) percentageValue.textContent = percentage.toFixed(2) + '%';
        if (statusCell) statusCell.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';
    }
});
document.querySelectorAll('.radio-input').forEach(radio => {
    radio.addEventListener('change', calculateTotal);
});

function calculateTotal() {
    let total = 0;
    const rows = 24; // Updated to 24 rows
    
    for (let i = 1; i <= rows; i++) {
        const selectedRadio = document.querySelector(`input[name="row${i}"]:checked`);
        if (selectedRadio) {
            total += parseInt(selectedRadio.value);
        }
    }
    
    const totalElement = document.querySelector('.total-value');
    totalElement.textContent = total;
    
    const maxPossible = rows * 5;
    const percentage = (total / maxPossible) * 100;
    const percentageElement = document.querySelectorAll('.total-value')[1];
    percentageElement.textContent = percentage.toFixed(2) + '%';
    
    const statusElement = document.querySelector('.status-cell');
    statusElement.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';
}
document.querySelectorAll('.radio-input').forEach(radio => {
    radio.addEventListener('change', calculateTotal);
});

function calculateTotal() {
    let total = 0;
    const rows = 24; // Updated to 24 rows
    
    for (let i = 1; i <= rows; i++) {
        const selectedRadio = document.querySelector(`input[name="row${i}"]:checked`);
        if (selectedRadio) {
            total += parseInt(selectedRadio.value);
        }
    }
    
    const totalElement = document.querySelector('.total-value');
    totalElement.textContent = total;
    
    const maxPossible = rows * 5;
    const percentage = (total / maxPossible) * 100;
    const percentageElement = document.querySelectorAll('.total-value')[1];
    percentageElement.textContent = percentage.toFixed(2) + '%';
    
    const statusElement = document.querySelector('.status-cell');
    statusElement.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';
}
// Comprehensive Indicator and KATSINOV Calculation System

document.addEventListener('DOMContentLoaded', () => {
    // Comprehensive Indicator Configuration
    const INDICATOR_CONFIGS = [
        { id: 1, rows: 21 },
        { id: 2, rows: 21 },
        { id: 3, rows: 21 },
        { id: 4, rows: 22 },
        { id: 5, rows: 24 },
        { id: 6, rows: 24 }
    ];

    // Debugging Utility: Enhanced Logging
    function debugLog(message, data = null) {
        console.group('KATSINOV Calculation Debug');
        console.log(message);
        if (data !== null) {
            console.log('Data:', data);
        }
        console.groupEnd();
    }

    // Robust Indicator Score Calculation
    function calculateIndicatorScore(card) {
        // Validate card input
        if (!card) {
            debugLog('Invalid card input');
            return { 
                percentage: 0, 
                status: 'TIDAK TERPENUHI',
                debug: 'No card found' 
            };
        }

        // Extract card metadata
        const cardTitle = card.querySelector('.main-title')?.textContent || '';
        const indicatorMatch = cardTitle.match(/KATSINOV (\d+)/);
        const indicatorNum = indicatorMatch ? parseInt(indicatorMatch[1]) : 0;

        // Select configuration
        const config = INDICATOR_CONFIGS.find(c => c.id === indicatorNum) || { rows: 21 };
        
        // Comprehensive radio button selection
        const checkedRadios = Array.from(card.querySelectorAll('input[type="radio"]:checked'));
        
        // Robust score calculation with debugging
        const total = checkedRadios.reduce((sum, radio) => {
            const value = parseInt(radio.value || '0');
            debugLog(`Radio Button Debug`, {
                name: radio.name,
                value: value,
                aspect: radio.closest('tr')?.querySelector('.aspect-cell')?.textContent
            });
            return sum + value;
        }, 0);

        // Precise percentage calculation
        const maxPossible = config.rows * 5;
        const percentage = maxPossible > 0 ? (total / maxPossible) * 100 : 0;

        // Status determination
        const status = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';

        // Update UI elements
        const totalValue = card.querySelector('.total-value');
        const percentageValue = card.querySelectorAll('.total-value')[1];
        const statusCell = card.querySelector('.status-cell');

        if (totalValue) totalValue.textContent = total.toString();
        if (percentageValue) percentageValue.textContent = `${percentage.toFixed(2)}%`;
        if (statusCell) statusCell.textContent = status;

        debugLog('Indicator Score Calculation', {
            indicatorNum,
            total,
            maxPossible,
            percentage,
            status
        });

        return { 
            percentage, 
            status,
            total,
            maxPossible
        };
    }

    // Advanced KATSINOV Level Determination
    function updateKatsinovLevel() {
        const cards = document.querySelectorAll('.card');
        const indicators = INDICATOR_CONFIGS.map((config, index) => {
            const card = Array.from(cards).find(card => 
                card.querySelector('.main-title')?.textContent.includes(`KATSINOV ${config.id}`)
            );

            return card ? calculateIndicatorScore(card) : null;
        });

        // Sophisticated Level Determination
        const consecutiveLevels = indicators.reduce((acc, indicator, index) => {
            if (indicator && indicator.percentage >= 20) {
                acc.push(index + 1);
            } else {
                return acc;
            }
            return acc;
        }, []);

        const highestLevel = consecutiveLevels.length > 0 
            ? Math.max(...consecutiveLevels) 
            : 0;

        // Update KATSINOV Display
        const valueDisplay = document.querySelector('.katsinov-indicator .value');
        if (valueDisplay) {
            valueDisplay.textContent = highestLevel.toString();
        }

        debugLog('KATSINOV Level Update', {
            indicators,
            consecutiveLevels,
            highestLevel
        });

        return highestLevel;
    }

    // Radio Button Standardization
    function setupRadioListeners() {
        const indicators = document.querySelectorAll('.card');
        
        indicators.forEach((indicator, index) => {
            const indicatorNum = indicator.querySelector('.main-title')?.textContent.match(/\d+/)?.[0] || (index + 1);
            
            indicator.querySelectorAll('.radio-input').forEach((radio, rowIndex) => {
                // Consistent, predictable naming
                const aspectCell = radio.closest('tr')?.querySelector('.aspect-cell');
                const aspect = aspectCell?.textContent.trim() || 'Unknown';
                
                radio.setAttribute('name', `indicator${indicatorNum}_row${rowIndex + 1}_${aspect}`);
                
                radio.addEventListener('change', () => {
                    calculateIndicatorScore(indicator);
                    updateKatsinovLevel();
                });
            });
        });
    }

    // Initialization Function
    function initializeIndicators() {
        setupRadioListeners();
        updateKatsinovLevel();
    }

    // Global Debugging Exposure
    window.debugKatsinov = {
        calculateIndicatorScore,
        updateKatsinovLevel,
        INDICATOR_CONFIGS
    };

    // Initialize
    initializeIndicators();
});
 src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
    <script>
        // Previous script remains the same, adding date input handling
        document.addEventListener('DOMContentLoaded', () => {
            // ... previous event listeners ...

            // Date input handling
            const dateInput = document.getElementById('measurement-date');
            
            // Optional: Convert selected date to desired format when needed
            dateInput.addEventListener('change', (e) => {
                const selectedDate = new Date(e.target.value);
                const formattedDate = selectedDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).replace(/ /g, '-');
                
                console.log('Selected date:', formattedDate);
                // You can add more logic here if needed
            });
        });
// Tambahkan fungsi ini di indikator.js
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
                    'Manufaktur (MF)',
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

        // Loop melalui semua kartu indikator KATSINOV
        document.querySelectorAll('.card[data-indicator]').forEach(card => {
            // Ambil semua baris dari tabel
            card.querySelectorAll('tr').forEach(row => {
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

        // Hitung persentase untuk setiap aspek
        const values = [
            calculatePercentage(aspects['T']),   // Teknologi
            calculatePercentage(aspects['O']),   // Organisasi
            calculatePercentage(aspects['R']),   // Risiko
            calculatePercentage(aspects['M']),   // Pasar
            calculatePercentage(aspects['P']),   // Kemitraan
            calculatePercentage(aspects['MF']),  // Manufaktur
            calculatePercentage(aspects['I'])    // Investasi
        ];

        return values;
    }

    function calculatePercentage(aspect) {
        if (aspect.count === 0) return 0;
        return (aspect.total / (aspect.count * 5)) * 100;
    }

    function updateChart() {
        const values = calculateAspectValues();
        if (spiderwebChart) {
            spiderwebChart.data.datasets[0].data = values;
            spiderwebChart.update();
        }

        // Update ringkasan
        const average = values.reduce((a, b) => a + b, 0) / values.length;
        const fulfilled = values.filter(value => value >= 80).length;
        
        document.querySelector('.rata-rata-pencapaian').textContent = average.toFixed(1) + '%';
        document.querySelector('.aspek-terpenuhi').textContent = fulfilled + ' dari 7';
        
        const statusElement = document.querySelector('.status-keseluruhan');
        if (statusElement) {
            const status = average >= 80 ? 'TERPENUHI' : 'BELUM TERPENUHI';
            statusElement.textContent = status;
            statusElement.className = 'status-keseluruhan ' + 
                (status === 'TERPENUHI' ? 'text-green-600' : 'text-red-600');
        }
    }

    // Inisialisasi chart
    initSpiderwebChart();

    // Tambahkan event listener untuk semua radio button
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateChart);
    });

    // Update awal
    updateChart();
});

 