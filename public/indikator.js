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
    // Global configuration for indicators
    const INDICATOR_CONFIGS = [
        { id: 1, rows: 21 },
        { id: 2, rows: 21 },
        { id: 3, rows: 21 },
        { id: 4, rows: 22 },
        { id: 5, rows: 24 },
        { id: 6, rows: 24 }
    ];

    // Utility function to calculate indicator score
    function calculateIndicatorScore(card) {
        let total = 0;
        const checkedRadios = card.querySelectorAll('input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            total += parseInt(radio.value);
        });

        // Find configuration for this card
        const cardTitle = card.querySelector('.main-title')?.textContent;
        const indicatorConfig = INDICATOR_CONFIGS.find(config => 
            cardTitle && cardTitle.includes(`KATSINOV ${config.id}`)
        ) || { rows: 21 }; // Default to 21 rows if not found

        const maxPossible = indicatorConfig.rows * 5;
        const percentage = (total / maxPossible) * 100;

        // Update card-specific elements
        const totalValue = card.querySelector('.total-value');
        const percentageValue = card.querySelectorAll('.total-value')[1];
        const statusCell = card.querySelector('.status-cell');

        if (totalValue) totalValue.textContent = total;
        if (percentageValue) percentageValue.textContent = percentage.toFixed(2) + '%';
        if (statusCell) statusCell.textContent = percentage > 0 ? 'TERPENUHI' : 'TIDAK TERPENUHI';

        return percentage > 0;
    }

    // Function to update KATSINOV level
    function updateKatsinovLevel() {
        console.log('Updating KATSINOV Level');
        const cards = document.querySelectorAll('.card');
        const indicators = [];

        // Calculate status for each KATSINOV indicator
        INDICATOR_CONFIGS.forEach((config, index) => {
            const card = Array.from(cards).find(card => 
                card.querySelector('.main-title')?.textContent.includes(`KATSINOV ${config.id}`)
            );

            if (card) {
                indicators[index] = calculateIndicatorScore(card);
            }
        });

        // Determine highest consecutive KATSINOV level
        let highestLevel = 0;
        for (let i = 0; i < indicators.length; i++) {
            if (indicators[i]) {
                highestLevel = i + 1;
            } else {
                break;
            }
        }

        // Update KATSINOV display
        const valueDisplay = document.querySelector('.katsinov-indicator .value');
        if (valueDisplay) {
            valueDisplay.textContent = highestLevel;
        }

        console.log('Highest KATSINOV Level:', highestLevel);
        return highestLevel;
    }

   
    // Setup radio button event listeners
    function setupRadioListeners() {
        const indicators = document.querySelectorAll('.card');
        
        indicators.forEach((indicator, index) => {
            const indicatorNum = indicator.querySelector('.main-title')?.textContent.match(/\d+/)?.[0] || index + 1;
            
            // Uniquely name radio buttons
            indicator.querySelectorAll('.radio-input').forEach(radio => {
                const rowNum = radio.getAttribute('name').replace('row', '');
                radio.setAttribute('name', `indicator${indicatorNum}_row${rowNum}`);
                
                // Add change event listener
                radio.addEventListener('change', () => {
                    calculateIndicatorScore(indicator);
                    updateKatsinovLevel();
                });
            });
        });
    }

    // Initialize everything
    function initializeIndicators() {
        setupRadioListeners();
        colorCodeRows();
        updateKatsinovLevel();
    }

    // Expose functions globally for debugging
    window.updateKatsinovLevel = updateKatsinovLevel;
    window.calculateIndicatorScore = calculateIndicatorScore;

    // Run initialization
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
 