 const sdgGoals = [
            "No Poverty",
            "Zero Hunger",
            "Good Health",
            "Quality Education",
            "Gender Equality",
            "Clean Water",
            "Clean Energy",
            "Decent Work",
            "Innovation",
            "Reduced Inequality",
            "Sustainable Cities",
            "Responsible Consumption",
            "Climate Action",
            "Life Below Water",
            "Life on Land",
            "Peace & Justice",
            "Partnerships"
        ];

        // SDG official colors
        const sdgColors = [
            'sdg-1', 'sdg-2', 'sdg-3', 'sdg-4', 'sdg-5', 'sdg-6', 'sdg-7', 'sdg-8', 'sdg-9',
            'sdg-10', 'sdg-11', 'sdg-12', 'sdg-13', 'sdg-14', 'sdg-15', 'sdg-16', 'sdg-17'
        ];

        // Sample data
        const yearData = {
            2024: [65, 72, 58, 84, 69, 77, 63, 71, 56, 68, 74, 62, 59, 51, 67, 73, 81],
            2025: [68, 75, 61, 87, 72, 80, 66, 74, 59, 71, 77, 65, 62, 54, 70, 76, 84]
        };

        const facultyData = {
            FIP: [75, 82, 68, 91, 79, 73, 66, 78, 62, 74, 80, 69, 65, 58, 72, 83, 88],
            FBS: [70, 77, 63, 86, 74, 68, 61, 73, 57, 69, 75, 64, 60, 53, 67, 78, 83],
            FMIPA: [72, 69, 85, 83, 71, 89, 92, 76, 88, 73, 78, 71, 74, 67, 81, 75, 80],
            FT: [68, 64, 79, 80, 67, 85, 89, 91, 85, 70, 82, 78, 76, 63, 77, 72, 77],
            FIS: [78, 74, 66, 88, 83, 71, 63, 75, 59, 81, 84, 67, 71, 56, 69, 86, 89],
            FE: [71, 68, 62, 85, 76, 69, 65, 87, 79, 78, 81, 84, 68, 54, 66, 79, 91],
            FPP: [74, 71, 89, 87, 81, 73, 67, 76, 61, 84, 79, 69, 66, 57, 75, 88, 85],
            FIK: [69, 73, 91, 84, 77, 75, 68, 74, 58, 72, 77, 63, 64, 59, 83, 81, 82]
        };

        const facultyNames = {
            FIP: "Fakultas Ilmu Pendidikan (FIP)",
            FBS: "Fakultas Bahasa dan Seni (FBS)",
            FMIPA: "Fakultas Matematika dan IPA (FMIPA)",
            FT: "Fakultas Teknik",
            FIS: "Fakultas Ilmu Sosial",
            FE: "Fakultas Ekonomi",
            FPP: "Fakultas Pendidikan Psikologi",
            FIK: "Fakultas Ilmu Keolahragaan"
        };

        function createChart(containerId, labelsId, data, goals) {
            const chartContainer = document.getElementById(containerId);
            const labelsContainer = document.getElementById(labelsId);

            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            const maxValue = Math.max(...data);

            data.forEach((value, index) => {
                // Create bar with SDG color
                const bar = document.createElement('div');
                bar.className = `bar ${sdgColors[index]}`;
                bar.style.height = `${(value / maxValue) * 100}%`;
                bar.setAttribute('data-value', `${value}%`);
                bar.title = `${goals[index]}: ${value}%`;

                // Add animation delay for staggered effect
                bar.style.animationDelay = `${index * 0.1}s`;

                chartContainer.appendChild(bar);

                // Create label
                const label = document.createElement('div');
                label.className = 'label';
                label.textContent = goals[index];
                labelsContainer.appendChild(label);
            });
        }

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            updateYearChart();
            updateFacultyChart();
        });

        let sustainabilityData = {
            yearData: {},
            facultyData: {}
        };

        // Fetch data from server
        function fetchSustainabilityData() {
            fetch("{{ route('pemeringkatan.sustainability.data') }}")
                .then(response => response.json())
                .then(data => {
                    sustainabilityData = data;
                    updateYearChart();
                    updateFacultyChart();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    // Fallback to sample data if API fails
                    sustainabilityData = {
                        yearData: {
                            2024: [65, 72, 58, 84, 69, 77, 63, 71, 56, 68, 74, 62, 59, 51, 67, 73, 81],
                            2025: [68, 75, 61, 87, 72, 80, 66, 74, 59, 71, 77, 65, 62, 54, 70, 76, 84]
                        },
                        facultyData: {
                            FIP: [75, 82, 68, 91, 79, 73, 66, 78, 62, 74, 80, 69, 65, 58, 72, 83, 88],
                            // ... other faculties ...
                        }
                    };
                    updateYearChart();
                    updateFacultyChart();
                });
        }

        function updateYearChart() {
            const selectedYear = document.getElementById('year-select').value;
            const data = sustainabilityData.yearData[selectedYear] || [];
            const titleElement = document.getElementById('year-chart-title');
            titleElement.textContent = `Progress Mata Kuliah Sustainability Tahun ${selectedYear}`;
            createChart('year-chart', 'year-labels', data, sdgGoals);
        }

        function updateFacultyChart() {
            const selectedFaculty = document.getElementById('faculty-select').value;
            const data = sustainabilityData.facultyData[selectedFaculty] || [];
            const titleElement = document.getElementById('faculty-chart-title');
            titleElement.textContent = `Progress Mata Kuliah Sustainability ${facultyNames[selectedFaculty]}`;
            createChart('faculty-chart', 'faculty-labels', data, sdgGoals);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchSustainabilityData();
        });