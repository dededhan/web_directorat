document.addEventListener("DOMContentLoaded", () => {
    // Konfigurasi indikator
    const INDICATOR_CONFIGS = [
        { id: 1, rows: 22 },
        { id: 2, rows: 21 },
        { id: 3, rows: 21 },
        { id: 4, rows: 22 },
        { id: 5, rows: 24 },
        { id: 6, rows: 14 },
    ];

    // Fungsi untuk menandai radio button secara unik
    function setupRadioButtons() {
        const indicators = document.querySelectorAll(".card");

        indicators.forEach((indicator, index) => {
            const indicatorNum =
                indicator
                    .querySelector(".main-title")
                    ?.textContent.match(/\d+/)?.[0] || index + 1;

            indicator
                .querySelectorAll(".radio-input")
                .forEach((radio, rowIndex) => {
                    const aspectCell = radio
                        .closest("tr")
                        ?.querySelector(".aspect-cell");
                    const aspect = aspectCell?.textContent.trim() || "Unknown";

                    // Nama radio button unik untuk setiap indikator dan baris
                    radio.setAttribute(
                        "name",
                        `indicator${indicatorNum}_row${rowIndex + 1}_${aspect}`
                    );

                    radio.addEventListener("change", () => {
                        calculateTotal(indicator, indicatorNum);
                        updateKatsinovLevel();
                    });
                });
        });
    }

    // Fungsi menghitung total skor untuk setiap indikator
    function calculateTotal(card, indicatorNum) {
        const config = INDICATOR_CONFIGS.find(
            (c) => c.id === parseInt(indicatorNum)
        );
        if (!config) return;

        let total = 0;
        const rows = config.rows;

        // Pilih radio button yang sesuai dengan indikator
        const selector = `input[name^="indicator${indicatorNum}_"]:checked`;
        const checkedRadios = card.querySelectorAll(selector);

        checkedRadios.forEach((radio) => {
            total += parseInt(radio.value);
        });

        const totalElement = card.querySelector(".total-value");
        const percentageElement = card.querySelectorAll(".total-value")[1];
        const statusElement = card.querySelector(".status-cell");

        const maxPossible = rows * 5;
        const percentage = (total / maxPossible) * 100;

        if (totalElement) totalElement.textContent = total;
        if (percentageElement)
            percentageElement.textContent = percentage.toFixed(2) + "%";
        if (statusElement)
            statusElement.textContent =
                percentage > 0 ? "TERPENUHI" : "TIDAK TERPENUHI";

        return { total, percentage };
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
        document.querySelectorAll('.katsinov-table').forEach(table => {
            table.querySelectorAll('tr').forEach(row => {
                const dropdown = row.querySelector('select.form-select');
                if (dropdown) {
                    dropdown.addEventListener('change', function() {
                        // Update perhitungan jika diperlukan
                        const indicatorContainer = table.closest('[data-indicator]');
                        if (indicatorContainer) {
                            const indicatorNum = indicatorContainer.dataset.indicator;
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



    // Inisialisasi
    setupRadioButtons();
    setupDropdowns(); 
    updateKatsinovLevel();

    // Debugging (opsional)
    window.debugKatsinov = {
        calculateTotal,
        updateKatsinovLevel,
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
