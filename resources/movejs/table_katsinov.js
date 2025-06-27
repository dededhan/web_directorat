document.querySelectorAll('.toggle-details').forEach(button => {
    button.addEventListener('click', function(e) {
        e.stopPropagation();
        const row = this.closest('tr');
        const targetId = row.getAttribute('data-target');
        const detailRow = document.querySelector(targetId);

        if (detailRow.style.display === 'none') {
            detailRow.style.display = '';
            this.querySelector('i').className = 'bx bx-chevron-up';
            const katsinovId = targetId.substring(9); // Extract ID from #details-XXX
            initCharts(katsinovId);
        } else {
            detailRow.style.display = 'none';
            this.querySelector('i').className = 'bx bx-chevron-down';
        }
    });
});

// Row click to expand
document.querySelectorAll('tr[data-toggle="row-details"]').forEach(row => {
    row.addEventListener('click', function(e) {
        if (!e.target.closest('button')) {
            this.querySelector('.toggle-details').click();
        }
    });
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelectorAll('tr[data-toggle="row-details"]');

    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        let found = false;

        for (let i = 1; i < cells.length - 1; i++) {
            const text = cells[i].textContent.toLowerCase();
            if (text.includes(searchText)) {
                found = true;
                break;
            }
        }

        const targetId = row.getAttribute('data-target');
        const detailRow = document.querySelector(targetId);

        if (found) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
            if (detailRow.style.display !== 'none') {
                detailRow.style.display = 'none';
                row.querySelector('.toggle-details i').className = 'bx bx-chevron-down';
            }
        }
    });
});

function getChartColors() {
    return {
        technology: 'rgba(255, 159, 64, 0.7)',
        organization: 'rgba(75, 192, 192, 0.7)',
        risk: 'rgba(153, 102, 255, 0.7)',
        market: 'rgba(255, 99, 132, 0.7)',
        partnership: 'rgba(255, 205, 86, 0.7)',
        manufacturing: 'rgba(54, 162, 235, 0.7)',
        investment: 'rgba(201, 203, 207, 0.7)'
    };
}

window.initCharts = function(katsinovId) {
    console.log("Initializing charts for katsinov ID:", katsinovId); // Debug log
    // Initialize both charts but show only bar chart initially
    initBarChart(katsinovId);
    initSpiderwebChart(katsinovId);
};

window.showBarChart = function(katsinovId) {
    document.getElementById(`barChart-${katsinovId}`).style.display = '';
    document.getElementById(`spiderWeb-${katsinovId}`).style.display = 'none';
};

window.showSpiderweb = function(katsinovId) {
    document.getElementById(`barChart-${katsinovId}`).style.display = 'none';
    document.getElementById(`spiderWeb-${katsinovId}`).style.display = '';
};

window.initBarChart = function(katsinovId) {
    console.log("Initializing bar chart for katsinov ID:", katsinovId); // Debug log
    const chartContainer = document.querySelector(`#barChart-${katsinovId} canvas`);
    if (!chartContainer) {
        console.error(`Bar chart container for ID ${katsinovId} not found`);
        return;
    }

    // Extract data from DOM elements for this specific katsinov
    const aspectItems = document.querySelectorAll(`#details-${katsinovId} .aspect-item:not(.overall)`);
    if (aspectItems.length === 0) {
        console.error(`No aspect items found for katsinov ID ${katsinovId}`);
        return;
    }

    const labels = [];
    const data = [];

    aspectItems.forEach(item => {
        const header = item.querySelector('h6');
        const value = item.querySelector('p');

        if (!header || !value) {
            console.error("Missing header or value in aspect item", item);
            return;
        }

        labels.push(header.textContent);
        data.push(parseFloat(value.textContent));
    });

    if (labels.length === 0 || data.length === 0) {
        console.error("No valid data extracted for chart");
        return;
    }

    // Clear any existing chart
    if (chartContainer.chart) {
        chartContainer.chart.destroy();
    }

    const colors = Object.values(getChartColors());

    const chart = new Chart(chartContainer, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Aspect Scores (%)',
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
                        text: 'Percentage (%)'
                    }
                }
            }
        }
    });

    // Store chart instance for cleanup if needed later
    chartContainer.chart = chart;
    console.log("Bar chart initialized successfully");
};

window.initSpiderwebChart = function(katsinovId) {
    console.log("Initializing spiderweb chart for katsinov ID:", katsinovId); // Debug log
    const chartContainer = document.querySelector(`#spiderWeb-${katsinovId} canvas`);
    if (!chartContainer) {
        console.error(`Spiderweb chart container for ID ${katsinovId} not found`);
        return;
    }

    // Extract data from DOM elements for this specific katsinov
    const aspectItems = document.querySelectorAll(`#details-${katsinovId} .aspect-item:not(.overall)`);
    if (aspectItems.length === 0) {
        console.error(`No aspect items found for katsinov ID ${katsinovId}`);
        return;
    }

    const labels = [];
    const data = [];

    aspectItems.forEach(item => {
        const header = item.querySelector('h6');
        const value = item.querySelector('p');

        if (!header || !value) {
            console.error("Missing header or value in aspect item", item);
            return;
        }

        labels.push(header.textContent);
        data.push(parseFloat(value.textContent));
    });

    if (labels.length === 0 || data.length === 0) {
        console.error("No valid data extracted for chart");
        return;
    }

    // Clear any existing chart
    if (chartContainer.chart) {
        chartContainer.chart.destroy();
    }

    const colorKeys = Object.keys(getChartColors());
    const colors = colorKeys.map(key => getChartColors()[key]);

    const chart = new Chart(chartContainer, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Aspect Scores',
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
    console.log("Spiderweb chart initialized successfully");


    
};