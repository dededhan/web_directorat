document.addEventListener("DOMContentLoaded", () => {
    // --- TOOLTIP FUNCTIONALITY ---
    function setupTooltips() {
        const tooltip = document.createElement("div");
        tooltip.id = "radio-tooltip";
        document.body.appendChild(tooltip);

        const radioCells = document.querySelectorAll("td[data-description]");

        radioCells.forEach((cell) => {
            cell.addEventListener("mouseenter", (event) => {
                const description = cell.getAttribute("data-description");
                if (description) {
                    tooltip.textContent = description;
                    tooltip.style.display = "block";
                    updateTooltipPosition(event, tooltip);
                }
            });

            cell.addEventListener("mousemove", (event) => {
                if (tooltip.style.display === "block") {
                    updateTooltipPosition(event, tooltip);
                }
            });

            cell.addEventListener("mouseleave", () => {
                tooltip.style.display = "none";
            });
        });
    }

    function updateTooltipPosition(event, tooltip) {
        const x = event.clientX;
        const y = event.clientY;
        tooltip.style.top = `${y + 10}px`;
        tooltip.style.left = `${x + 10}px`;
    }

    // Konfigurasi indikator
    const INDICATOR_CONFIGS = [
        { id: 1, rows: 22, name: "Indikator KATSINOV 1" },
        { id: 2, rows: 21, name: "Indikator KATSINOV 2" },
        { id: 3, rows: 21, name: "Indikator KATSINOV 3" },
        { id: 4, rows: 22, name: "Indikator KATSINOV 4" },
        { id: 5, rows: 24, name: "Indikator KATSINOV 5" },
        { id: 6, rows: 14, name: "Indikator KATSINOV 6" },
    ];

    const MIN_PERCENTAGE_TO_PROCEED = MIN_PERCENTAGE_FROM_SERVER;
    // Fungsi untuk menandai radio button secara unik
    function setupRadioButtons() {
        const indicatorCards = document.querySelectorAll(".indicator-card");

        indicatorCards.forEach((indicatorCard) => {
            const indicatorNum = parseInt(indicatorCard.dataset.indicator);
            const config = INDICATOR_CONFIGS.find((c) => c.id === indicatorNum);
            if (!config) return;

            // Set indicator header text (if you want dynamic titles based on config)
            const headerElement =
                indicatorCard.querySelector(".indicator-header");
            if (headerElement) {
                // headerElement.textContent = config.name; // Already set in Blade
            }

            indicatorCard
                .querySelectorAll("table.katsinov-table tr:not(.total-row)") // Process only data rows
                .forEach((row, rowIndex) => {
                    if (rowIndex === 0) return; // Skip header row of the table

                    const radioInputs = row.querySelectorAll(".radio-input");
                    const aspectCell = row.querySelector(".aspect-cell");
                    const aspect =
                        aspectCell?.textContent.trim() || `aspect${rowIndex}`;

                    radioInputs.forEach((radio) => {
                        // Make name unique per row within an indicator
                        radio.setAttribute(
                            "name",
                            `indicator${indicatorNum}_row${rowIndex}` // Simplified naming, original Blade already handles uniqueness well for submission
                        );
                        radio.addEventListener("change", () => {
                            calculateTotal(indicatorCard, indicatorNum);
                            updateIndicatorVisibility(); // Updated to control flow
                            updateKatsinovLevel(); // If you have this for overall level
                        });
                    });
                });
        });
    }

    // Fungsi menghitung total skor untuk setiap indikator
    function calculateTotal(card, indicatorNum) {
        const config = INDICATOR_CONFIGS.find(
            (c) => c.id === parseInt(indicatorNum)
        );
        if (!config) return { total: 0, percentage: 0 };

        let totalScore = 0;
        const rows = config.rows;

        // Select checked radio buttons specific to this indicator card
        const checkedRadios = card.querySelectorAll(
            'input[type="radio"]:checked'
        );

        checkedRadios.forEach((radio) => {
            totalScore += parseInt(radio.value);
        });

        const totalElement = card.querySelector("tr.total-row td.total-value"); // First total-value for score
        const percentageElement = card.querySelector(
            "tr.total-row:last-child td.total-value"
        ); // Second total-value for percentage
        const statusElement = card.querySelector(
            "tr.total-row:last-child td.status-cell"
        );

        const maxPossibleScore = rows * 5;
        const percentage =
            maxPossibleScore > 0 ? (totalScore / maxPossibleScore) * 100 : 0;

        if (totalElement) totalElement.textContent = totalScore; // Display raw score if needed, or score/2 as per your blade.
        // Your blade shows `sum('score') / 2`. If radio values are 0-5, then this sum is correct.
        // If you intend to display the sum of values 0-5, then it's just `totalScore`.
        // For this logic, the raw `totalScore` and `percentage` are what matter.

        if (percentageElement)
            percentageElement.textContent = `(${percentage.toFixed(2)}%)`; // Matched blade format

        if (statusElement) {
            statusElement.textContent =
                percentage >= MIN_PERCENTAGE_TO_PROCEED
                    ? "TERPENUHI"
                    : "TIDAK TERPENUHI";
        }
        return { total: totalScore, percentage: percentage };
    }

    // Fungsi untuk mengontrol visibilitas indikator
    function updateIndicatorVisibility() {
        let previousIndicatorPassed = true;

        for (let i = 1; i <= INDICATOR_CONFIGS.length; i++) {
            const currentIndicatorCard = document.querySelector(
                `.indicator-card[data-indicator="${i}"]`
            );
            const nextIndicatorCard = document.querySelector(
                `.indicator-card[data-indicator="${i + 1}"]`
            );

            if (!currentIndicatorCard) continue;

            if (i === 1) {
                // Indicator 1 is always processed for visibility check
                currentIndicatorCard.style.display = "block";
            }

            // If the current indicator is supposed to be visible (either it's the first or the previous one passed)
            if (currentIndicatorCard.style.display === "block") {
                const result = calculateTotal(currentIndicatorCard, i); // Recalculate to be sure
                if (result.percentage < MIN_PERCENTAGE_TO_PROCEED) {
                    previousIndicatorPassed = false;
                    // Hide all subsequent indicators
                    for (let j = i + 1; j <= INDICATOR_CONFIGS.length; j++) {
                        const subseqCard = document.querySelector(
                            `.indicator-card[data-indicator="${j}"]`
                        );
                        if (subseqCard) subseqCard.style.display = "none";
                    }
                }

                if (nextIndicatorCard) {
                    if (previousIndicatorPassed) {
                        nextIndicatorCard.style.display = "block";
                    } else {
                        nextIndicatorCard.style.display = "none";
                    }
                }
            } else {
                // If current card is hidden, all subsequent ones should also be hidden
                if (nextIndicatorCard) {
                    nextIndicatorCard.style.display = "none";
                }
                previousIndicatorPassed = false; // Ensures no further indicators are shown
            }
        }
    }

    // Fungsi update level KATSINOV
    function updateKatsinovLevel() {
        const indicators = INDICATOR_CONFIGS.map((config) => {
            const card = document.querySelector(
                `.card:has(.main-title:contains("KATSINOV ${config.id}"))`
            );
            return card ? calculateTotal(card, config.id) : null;
        });

        // Tentukan level tertinggi yang tercapai
        const highestLevel = indicators.reduce((highest, indicator, index) => {
            return indicator && indicator.percentage >= 20
                ? index + 1
                : highest;
        }, 0);

        // Update display level KATSINOV
        const valueDisplay = document.querySelector(
            ".katsinov-indicator .value"
        );
        if (valueDisplay) {
            valueDisplay.textContent = highestLevel.toString();
        }

        return highestLevel;
    }

    function setupDropdowns() {
        document.querySelectorAll(".katsinov-table").forEach((table) => {
            table.querySelectorAll("tr").forEach((row) => {
                const dropdown = row.querySelector("select.form-select");
                if (dropdown) {
                    dropdown.addEventListener("change", function () {
                        // Update perhitungan jika diperlukan
                        const indicatorContainer =
                            table.closest("[data-indicator]");
                        if (indicatorContainer) {
                            const indicatorNum =
                                indicatorContainer.dataset.indicator;
                            calculateTotal(indicatorContainer, indicatorNum);
                            updateKatsinovLevel();
                        }

                        // Jika ada chart, update juga
                        if (window.updateChart) {
                            window.updateChart();
                        }
                    });
                }
            });
        });
    }
    function syncDropdownOptionHints() {
        // Loop setiap baris tabel di semua indikator
        document
            .querySelectorAll(
                ".katsinov-table tr.row-t, .katsinov-table tr.row-m, .katsinov-table tr.row-o, .katsinov-table tr.row-mf, .katsinov-table tr.row-i, .katsinov-table tr.row-p, .katsinov-table tr.row-r"
            )
            .forEach((row) => {
                // 1. Buat pemetaan dari skor (0-5) ke deskripsinya untuk baris ini
                const descriptionMap = {};
                row.querySelectorAll("td[data-description]").forEach((cell) => {
                    const radio = cell.querySelector("input.radio-input");
                    if (radio) {
                        // key = nilai radio (e.g., "0"), value = deskripsi dari data-attribute
                        descriptionMap[radio.value] = cell.dataset.description;
                    }
                });

                // 2. Temukan dropdown di baris yang sama
                const dropdown = row.querySelector("select.form-select");
                if (dropdown) {
                    // 3. Loop setiap <option> di dalam dropdown tersebut
                    dropdown.querySelectorAll("option").forEach((option) => {
                        // Teks di dalam option adalah skornya (0, 1, 2, dst.)
                        const score = option.textContent.trim();

                        // Jika ada deskripsi yang cocok di map, set sebagai title
                        if (descriptionMap[score]) {
                            option.setAttribute("title", descriptionMap[score]);
                        }
                    });
                }
            });
    }

    // Inisialisasi
    setupRadioButtons();
    setupDropdowns();
    setupTooltips();
    syncDropdownOptionHints();
    updateIndicatorVisibility(); // Initial check
    updateKatsinovLevel();

    // Debugging (opsional)
    window.debugKatsinov = {
        calculateTotal,
        updateKatsinovLevel,
        updateIndicatorVisibility,
        INDICATOR_CONFIGS,
    };
});

// Spiderweb Chart Update (dari kode sebelumnya)
document.addEventListener("DOMContentLoaded", function () {
    let spiderwebChart;

    function initSpiderwebChart() {
        const ctx = document.getElementById("spiderwebChart").getContext("2d");
        spiderwebChart = new Chart(ctx, {
            type: "radar",
            data: {
                labels: [
                    "Teknologi (T)",
                    "Organisasi (O)",
                    "Risiko (R)",
                    "Pasar (M)",
                    "Kemitraan (P)",
                    "Manufaktur (MF)",
                    "Investasi (I)",
                ],
                datasets: [
                    {
                        label: "Nilai Aspek KATSINOV",
                        data: [0, 0, 0, 0, 0, 0, 0],
                        fill: true,
                        backgroundColor: "rgba(23, 99, 105, 0.2)",
                        borderColor: "rgb(23, 99, 105)",
                        pointBackgroundColor: "rgb(23, 99, 105)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgb(23, 99, 105)",
                    },
                ],
            },
            options: {
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    }

    function calculateAspectValues() {
        const aspects = {
            T: { total: 0, count: 0 },
            O: { total: 0, count: 0 },
            R: { total: 0, count: 0 },
            M: { total: 0, count: 0 },
            P: { total: 0, count: 0 },
            MF: { total: 0, count: 0 },
            I: { total: 0, count: 0 },
        };

        // Loop melalui semua kartu indikator KATSINOV
        document.querySelectorAll(".card[data-indicator]").forEach((card) => {
            // Ambil semua baris dari tabel
            card.querySelectorAll("tr").forEach((row) => {
                const aspectCell = row.querySelector(".aspect-cell");
                if (!aspectCell) return;

                const aspect = aspectCell.textContent.trim().toUpperCase();
                const checkedRadio = row.querySelector(
                    'input[type="radio"]:checked'
                );

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
            calculatePercentage(aspects["T"]), // Teknologi
            calculatePercentage(aspects["O"]), // Organisasi
            calculatePercentage(aspects["R"]), // Risiko
            calculatePercentage(aspects["M"]), // Pasar
            calculatePercentage(aspects["P"]), // Kemitraan
            calculatePercentage(aspects["MF"]), // Manufaktur
            calculatePercentage(aspects["I"]), // Investasi
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
        const fulfilled = values.filter((value) => value >= 80).length;

        document.querySelector(".rata-rata-pencapaian").textContent =
            average.toFixed(1) + "%";
        document.querySelector(".aspek-terpenuhi").textContent =
            fulfilled + " dari 7";

        const statusElement = document.querySelector(".status-keseluruhan");
        if (statusElement) {
            const status = average >= 80 ? "TERPENUHI" : "BELUM TERPENUHI";
            statusElement.textContent = status;
            statusElement.className =
                "status-keseluruhan " +
                (status === "TERPENUHI" ? "text-green-600" : "text-red-600");
        }
    }

    // Inisialisasi chart
    initSpiderwebChart();

    // Tambahkan event listener untuk semua radio button
    document.querySelectorAll('input[type="radio"]').forEach((radio) => {
        radio.addEventListener("change", updateChart);
    });

    // Update awal
    updateChart();
});

// Styling untuk baris berdasarkan aspek
document.querySelectorAll(".row-r").forEach((row) => {
    const aspectCell = row.querySelector(".aspect-cell");
    const aspect = aspectCell.textContent.trim();

    switch (aspect) {
        case "T":
            row.style.backgroundColor = "rgba(254, 215, 170, 0.3)";
            break;
        case "O":
            row.style.backgroundColor = "rgba(167, 243, 208, 0.3)";
            break;
        case "R":
            row.style.backgroundColor = "rgba(199, 210, 254, 0.3)";
            break;
        case "M":
            row.style.backgroundColor = "rgba(251, 207, 232, 0.3)";
            break;
        case "P":
            row.style.backgroundColor = "rgba(245, 208, 254, 0.3)";
            break;
        case "MF":
            row.style.backgroundColor = "rgba(253, 230, 138, 0.3)";
            break;
        case "I":
            row.style.backgroundColor = "rgba(217, 249, 157, 0.3)";
            break;
    }
});
document.addEventListener("DOMContentLoaded", () => {
    // Fungsi untuk membatasi pemilihan radio button
    function setupExclusiveRadioButtons() {
        const tables = document.querySelectorAll(".katsinov-table");

        tables.forEach((table) => {
            const rows = table.querySelectorAll("tr");

            rows.forEach((row) => {
                const radioButtons = row.querySelectorAll(
                    'input[type="radio"]'
                );

                radioButtons.forEach((radio) => {
                    radio.addEventListener("change", function () {
                        // Jika radio button ini dipilih
                        if (this.checked) {
                            // Batalkan pilihan radio button lain dalam baris yang sama
                            radioButtons.forEach((otherRadio) => {
                                if (otherRadio !== this) {
                                    otherRadio.checked = false;
                                }
                            });
                        }
                    });
                });
            });
        });
    }

    // Panggil fungsi setup radio button
    setupExclusiveRadioButtons();
});
