// Add this to your table_katsinov.js file

document.addEventListener('DOMContentLoaded', function() {
    initOverallCharts();
    initStatusPieChart();
});

// FUNCTIONS FOR OVERALL CHART DISPLAY TOGGLING
function showOverallBarChart() {
    document.getElementById('overallBarChart').style.display = '';
    document.getElementById('overallSpiderWeb').style.display = 'none';
    
    // Update button states
    const buttons = document.querySelector('.overview-header .btn-group').querySelectorAll('button');
    buttons[0].classList.add('active');
    buttons[1].classList.remove('active');
}

function showOverallSpiderweb() {
    document.getElementById('overallBarChart').style.display = 'none';
    document.getElementById('overallSpiderWeb').style.display = '';
    
    // Update button states
    const buttons = document.querySelector('.overview-header .btn-group').querySelectorAll('button');
    buttons[0].classList.remove('active');
    buttons[1].classList.add('active');
}

// INITIALIZE OVERALL ASPECT AVERAGE CHARTS
function initOverallCharts() {
    // Calculate overall averages for all aspects across all innovations
    const aspects = {
        'technology': 'Teknologi (T)',
        'organization': 'Organisasi (O)',
        'risk': 'Risiko (R)',
        'market': 'Pasar (M)',
        'partnership': 'Kemitraan (P)',
        'manufacturing': 'Manufaktur (Mf)',
        'investment': 'Investasi (I)'
    };
    
    // Extract data by parsing DOM (we don't have direct access to backend data)
    let aspectTotals = {};
    let aspectCounts = {};
    
    // Initialize the objects
    Object.keys(aspects).forEach(key => {
        aspectTotals[key] = 0;
        aspectCounts[key] = 0;
    });
    
    // Get all aspect items from all rows
    document.querySelectorAll('.aspect-item').forEach(item => {
        if (item.classList.contains('overall')) return;
        
        const header = item.querySelector('h6').textContent;
        const valueText = item.querySelector('p').textContent;
        const value = parseFloat(valueText);
        
        // Find which aspect this corresponds to
        Object.entries(aspects).forEach(([key, label]) => {
            if (header.includes(label.split(' ')[0])) {
                aspectTotals[key] += value;
                aspectCounts[key]++;
            }
        });
    });
    
    // Calculate averages
    const labels = [];
    const averages = [];
    
    Object.entries(aspects).forEach(([key, label]) => {
        if (aspectCounts[key] > 0) {
            labels.push(label);
            averages.push((aspectTotals[key] / aspectCounts[key]).toFixed(2));
        }
    });
    
    // Initialize charts with the calculated data
    initOverallBarChart(labels, averages);
    initOverallSpiderwebChart(labels, averages);
}

function initOverallBarChart(labels, data) {
    const chartContainer = document.querySelector('#overallBarChart canvas');
    if (!chartContainer) return;
    
    // Clear any existing chart
    if (chartContainer.chart) {
        chartContainer.chart.destroy();
    }
    
    const colors = getColors(labels.length);
    
    const chart = new Chart(chartContainer, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Average Score (%)',
                data: data,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('0.7', '1')),
                borderWidth: 1
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
                        label: function(context) {
                            return context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Average Score (%)'
                    }
                }
            }
        }
    });
    
    // Store chart instance for cleanup if needed later
    chartContainer.chart = chart;
}

function initOverallSpiderwebChart(labels, data) {
    const chartContainer = document.querySelector('#overallSpiderWeb canvas');
    if (!chartContainer) return;
    
    // Clear any existing chart
    if (chartContainer.chart) {
        chartContainer.chart.destroy();
    }
    
    const colors = getColors(labels.length);
    
    const chart = new Chart(chartContainer, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Average Score',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                pointBackgroundColor: colors,
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: {
                        display: true
                    },
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.r + '%';
                        }
                    }
                }
            }
        }
    });
    
    // Store chart instance for cleanup if needed later
    chartContainer.chart = chart;
}

// INITIALIZE STATUS DISTRIBUTION PIE CHART
function initStatusPieChart() {
    const chartContainer = document.querySelector('#statusPieChart canvas');
    if (!chartContainer) return;
    
    // Extract status data from badges
    const statusCounts = {
        'Completed': 0,
        'Pending': 0,
        'Need Review': 0
    };
    
    document.querySelectorAll('span.badge').forEach(badge => {
        const text = badge.textContent.trim();
        
        if (text.includes('Completed')) {
            statusCounts['Completed']++;
        } else if (text.includes('Pending')) {
            statusCounts['Pending']++;
        } else if (text.includes('Need Review')) {
            statusCounts['Need Review']++;
        }
    });
    
    // Clear any existing chart
    if (chartContainer.chart) {
        chartContainer.chart.destroy();
    }
    
    const chart = new Chart(chartContainer, {
        type: 'pie',
        data: {
            labels: Object.keys(statusCounts),
            datasets: [{
                data: Object.values(statusCounts),
                backgroundColor: [
                    'rgba(46, 204, 113, 0.7)',  // green for Completed
                    'rgba(243, 156, 18, 0.7)',  // yellow for Pending
                    'rgba(231, 76, 60, 0.7)'    // red for Need Review
                ],
                borderColor: [
                    'rgb(46, 204, 113)',
                    'rgb(243, 156, 18)',
                    'rgb(231, 76, 60)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    // Store chart instance for cleanup if needed later
    chartContainer.chart = chart;
}

// HELPER FUNCTION FOR CHART COLORS
function getColors(count) {
    const baseColors = [
        'rgba(255, 159, 64, 0.7)',   // orange
        'rgba(75, 192, 192, 0.7)',   // teal
        'rgba(153, 102, 255, 0.7)',  // purple
        'rgba(255, 99, 132, 0.7)',   // pink
        'rgba(255, 205, 86, 0.7)',   // yellow
        'rgba(54, 162, 235, 0.7)',   // blue
        'rgba(201, 203, 207, 0.7)'   // gray
    ];
    
    // If we need more colors than available, just cycle through them
    const colors = [];
    for (let i = 0; i < count; i++) {
        colors.push(baseColors[i % baseColors.length]);
    }
    
    return colors;
}