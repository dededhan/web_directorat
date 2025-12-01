const sdgGoals = [
        "No Poverty", "Zero Hunger", "Good Health", "Quality Education", "Gender Equality",
        "Clean Water", "Clean Energy", "Decent Work", "Innovation", "Reduced Inequality",
        "Sustainable Cities", "Responsible Consumption", "Climate Action", "Life Below Water",
        "Life on Land", "Peace & Justice", "Partnerships"
    ];

    const sdgColors = [
        'sdg-1', 'sdg-2', 'sdg-3', 'sdg-4', 'sdg-5', 'sdg-6', 'sdg-7', 'sdg-8', 'sdg-9',
        'sdg-10', 'sdg-11', 'sdg-12', 'sdg-13', 'sdg-14', 'sdg-15', 'sdg-16', 'sdg-17'
    ];

    const facultyNames = {
        FIP: "Fakultas Ilmu Pendidikan (FIP)", FBS: "Fakultas Bahasa dan Seni (FBS)",
        FMIPA: "Fakultas Matematika dan IPA (FMIPA)", FT: "Fakultas Teknik",
        FIS: "Fakultas Ilmu Sosial", FE: "Fakultas Ekonomi",
        FPP: "Fakultas Pendidikan Psikologi", FIK: "Fakultas Ilmu Keolahragaan"
    };

    function createChart(containerId, labelsId, data, goals) {
        const chartContainer = document.getElementById(containerId);
        const labelsContainer = document.getElementById(labelsId);
        
        chartContainer.innerHTML = '';
        labelsContainer.innerHTML = '';

        if (!data || data.length === 0) { // Handle no data or empty data
            // You can display a message in the chart area if you want
            // chartContainer.innerHTML = '<p style="text-align:center; padding-top: 50px;">Tidak ada data untuk ditampilkan.</p>';
            return;
        }
        
        const maxValue = Math.max(...data) || 1;
        
        data.forEach((value, index) => {
            const bar = document.createElement('div');
            bar.className = `bar ${sdgColors[index]}`;
            bar.style.height = `${(value / maxValue) * 100}%`;
            bar.setAttribute('data-value', `${value}`);
            bar.title = `${goals[index]}: ${value} Kegiatan`;
            bar.style.animationDelay = `${index * 0.1}s`;
            chartContainer.appendChild(bar);

            const label = document.createElement('div');
            label.className = 'label';
            label.textContent = goals[index];
            labelsContainer.appendChild(label);
        });
    }

    async function populateYearDropdown() {
        const yearSelect = document.getElementById('year-select');
        try {
            // Ensure this route is defined in your web.php and points to the new controller method
            const response = await fetch('/Pemeringkatan/kegiatansustainability/get-distinct-years');
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            const years = await response.json();

            yearSelect.innerHTML = ''; // Clear "Memuat tahun..." or any previous options

            if (years && years.length > 0) {
                years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                });
                // Optionally select the most recent year (first in the sorted list if backend sorts desc)
                if (yearSelect.options.length > 0) {
                     yearSelect.value = yearSelect.options[0].value; // Select the first year
                }
               yearSelect.disabled = false;
            } else {
                const option = document.createElement('option');
                option.textContent = 'Tidak ada data tahun';
                option.value = "";
                yearSelect.appendChild(option);
                yearSelect.disabled = true;
            }
        } catch (error) {
            console.error('Error populating year dropdown:', error);
            yearSelect.innerHTML = '<option value="">Gagal memuat tahun</option>';
            yearSelect.disabled = true;
        }
    }

    async function updateYearChart() {
        const yearSelect = document.getElementById('year-select');
        if (yearSelect.disabled || !yearSelect.value) {
            document.getElementById('year-chart-title').textContent = 'Pilih Tahun untuk Melihat Data';
            createChart('year-chart', 'year-labels', [], sdgGoals); // Clear chart
            return;
        }
        const year = yearSelect.value;
        try {
            const response = await fetch(`/Pemeringkatan/kegiatansustainability/yearly?year=${year}`);
            if (!response.ok) throw new Error(`Network response was not ok: ${response.statusText}`);
            
            const data = await response.json();
            document.getElementById('year-chart-title').textContent = `Progress Kegiatan Sustainability Tahun ${year}`;
            createChart('year-chart', 'year-labels', data, sdgGoals);
        } catch (error) {
            console.error('Error fetching yearly data:', error);
            document.getElementById('year-chart-title').textContent = `Gagal memuat data untuk tahun ${year}`;
            createChart('year-chart', 'year-labels', [], sdgGoals); // Clear chart on error
        }
    }

    async function updateFacultyChart() {
        const facultySelect = document.getElementById('faculty-select');
        const yearSelect = document.getElementById('year-select');

        if (yearSelect.disabled || !yearSelect.value) {
            document.getElementById('faculty-chart-title').textContent = 'Pilih Tahun dan Fakultas untuk Melihat Data';
            createChart('faculty-chart', 'faculty-labels', [], sdgGoals); // Clear chart
            return;
        }

        const faculty = facultySelect.value;
        const year = yearSelect.value;
        
        try {
            const response = await fetch(`/Pemeringkatan/kegiatansustainability/faculty?faculty=${faculty.toLowerCase()}&year=${year}`);
            if (!response.ok) throw new Error(`Network response was not ok: ${response.statusText}`);
            
            const data = await response.json();
            const facultyDisplayName = facultyNames[faculty] || `Fakultas ${faculty}`;
            document.getElementById('faculty-chart-title').textContent = 
                `Progress Kegiatan Sustainability ${facultyDisplayName} Tahun ${year}`;
            createChart('faculty-chart', 'faculty-labels', data, sdgGoals);
        } catch (error) {
            console.error(`Error fetching faculty data for ${faculty} in ${year}:`, error);
            const facultyDisplayName = facultyNames[faculty] || `Fakultas ${faculty}`;
            document.getElementById('faculty-chart-title').textContent = `Gagal memuat data untuk ${facultyDisplayName} Tahun ${year}`;
            createChart('faculty-chart', 'faculty-labels', [], sdgGoals); // Clear chart on error
        }
    }

    function updateCharts() {
        updateYearChart(); // This will now use the dynamically set year
        updateFacultyChart(); // This will also use the dynamically set year
    }

    document.addEventListener('DOMContentLoaded', async function() {
        await populateYearDropdown(); // Wait for years to be populated
        
        const yearSelect = document.getElementById('year-select');
        if (!yearSelect.disabled && yearSelect.value) {
            updateCharts(); // Then update charts based on the now populated and selected year
        } else {
            // Initial state if no years are loaded or an error occurred
            document.getElementById('year-chart-title').textContent = 'Data Kegiatan Sustainability Tidak Tersedia';
            document.getElementById('faculty-chart-title').textContent = 'Pilih Tahun dan Fakultas untuk Melihat Data';
            createChart('year-chart', 'year-labels', [], sdgGoals);
            createChart('faculty-chart', 'faculty-labels', [], sdgGoals);
        }
    });