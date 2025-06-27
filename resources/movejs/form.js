function validateForm() {
    let isValid = true;

    // Cek semua radio button terisi
    document.querySelectorAll(".katsinov-table").forEach((table) => {
        const filled = table.querySelectorAll(
            'input[type="radio"]:checked'
        ).length;
        const totalRows =
            table.querySelectorAll("tr:not(.total-row)").length - 1; // Exclude header

        if (filled < totalRows) {
            isValid = false;
            table.scrollIntoView({
                behavior: "smooth",
            });
            table.style.border = "2px solid red";
            setTimeout(() => (table.style.border = ""), 3000);
        }
    });

    return isValid;
}

function collectFormResponses() {
    const responses = [];
    
    document.querySelectorAll('[data-indicator]').forEach(indicatorContainer => {
        const indicatorNumber = parseInt(indicatorContainer.dataset.indicator);
        
        indicatorContainer.querySelectorAll('tr').forEach((row, index) => {
            const aspectCell = row.querySelector('.aspect-cell');
            if (!aspectCell) return; // Skip header and total rows
            
            const aspect = aspectCell.textContent.trim();
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const dropdown = row.querySelector('select.form-select');
            
            if (checkedRadio) {
                const score = parseInt(checkedRadio.value);
                const dropdownValue = dropdown ? dropdown.value : null;
                
                responses.push({
                    indicator: indicatorNumber,
                    row: index, // Row index within the indicator
                    aspect: aspect,
                    score: score,
                    dropdown: dropdownValue
                });
            }
        });
    });
    
    console.log('Collected responses:', responses); // Debug
    return responses;
}

// Enhanced Frontend Submission with Comprehensive Error Handling
async function submitAllIndicators(event) {
    event.preventDefault(); // Prevent default form submission
    
    const btn = document.getElementById("submitAllBtn");

    // Comprehensive validation
    if (!validateForm()) {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Mohon lengkapi semua pertanyaan sebelum mengirimkan formulir.",
            confirmButtonColor: "#176369",
        });
        // return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';

    try {
        // Collect form data manually to ensure complete capture
        const formData = new FormData(document.getElementById("katsinovForm"));
        const detailedResponses = collectDetailedResponses();
        
        if (detailedResponses.length === 0) {
             // Check if indicator 1 was even attempted
            const indicator1Card = document.querySelector(`.indicator-card[data-indicator="1"]`);
            const indicator1Radios = indicator1Card ? indicator1Card.querySelectorAll('input[type="radio"]:checked').length : 0;

            if (indicator1Radios === 0) {
                 Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Mohon isi setidaknya Indikator KATSINOV 1.",
                    confirmButtonColor: "#176369",
                });
                btn.disabled = false;
                btn.innerHTML = document.querySelector('input[name="id"]') ? "Update Indikator KATSINOV" : "Submit Semua Indikator KATSINOV";
                return;
            }
            // If indicator 1 was filled but failed, detailedResponses will be empty as per logic.
            // The backend should handle this (e.g., save basic info and 0 progress).
        }

      const payload = {
            id: formData.get('id') || null, 
            title: formData.get('title'),
            focus_area: formData.get('focus_area'),
            project_name: formData.get('project_name'),
            institution: formData.get('institution'),
            address: formData.get('address'),
            contact: formData.get('contact'),
            assessment_date: formData.get('assessment_date'),
            responses: detailedResponses, // Use the filtered responses
            notes: {} // *** INITIALIZE NOTES OBJECT ***
           
        };
        const uniqueIndicatorsInResponse = [...new Set(detailedResponses.map(item => item.indicator))];

        uniqueIndicatorsInResponse.forEach(indicatorNum => {
            const indicatorCard = document.querySelector(`.indicator-card[data-indicator="${indicatorNum}"]`);
            if (indicatorCard && indicatorCard.style.display === 'block') { // Ensure card is visible
                const noteTextArea = indicatorCard.querySelector(`textarea[name="notes[${indicatorNum}]"]`);
                if (noteTextArea) {
                    payload.notes[indicatorNum] = noteTextArea.value;
                }
            }
        });
        // If no indicators passed, but you still want to save notes for indicator 1 (if it was attempted)
        if (detailedResponses.length === 0) {
            const indicator1Card = document.querySelector(`.indicator-card[data-indicator="1"]`);
            if (indicator1Card && indicator1Card.style.display === 'block') {
                const noteTextArea1 = indicator1Card.querySelector(`textarea[name="notes[1]"]`);
                if (noteTextArea1 && noteTextArea1.value.trim() !== "") {
                    payload.notes[1] = noteTextArea1.value;
                }
            }
        }

         console.log("Final payload being sent:", JSON.stringify(payload, null, 2));


        // Detailed fetch with comprehensive error handling
        const response = await fetch("/katsinov/store", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        // Parse response text
        const responseText = await response.text();
        
        // Log raw response for debugging
        console.log('Raw Response:', responseText);

        // Try to parse the response as JSON
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            console.error('JSON Parsing Error:', parseError);
            throw new Error(`Unexpected response format: ${responseText}`);
        }

        // Check for successful response
        if (!response.ok) {
            // Handle error response from server
            throw new Error(
                data.message || 
                `Submission failed with status ${response.status}`
            );
        }

        // Success handling with fallback values
        Swal.fire({
            icon: "success",
            title: "Berhasil!",
            html: `
            <div style="text-align: center;">
                <h3>Data KATSINOV Berhasil Disimpan</h3>
                <p>Pesan: ${data.message || 'Data berhasil disimpan'}</p>
            </div>
            `,
            confirmButtonText: "OK",
            confirmButtonColor: "#176369",
             allowOutsideClick: false, // Mencegah menutup alert dengan klik di luar
            allowEscapeKey: false    // Mencegah menutup alert dengan tombol Esc
        }).then((result) => {
            if (result.isConfirmed) {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    // MODIFIKASI DI SINI: Kembali ke halaman sebelumnya
                    window.history.back();
                }
            }
        });

    } catch (error) {
        // Comprehensive error logging and display
        console.error("Submission Error:", error);
        
        Swal.fire({
            icon: "error",
            title: "Gagal Menyimpan!",
            html: `
            <div style="background-color: #fff0f3; padding: 20px; border-radius: 10px;">
                <h4>Error Details:</h4>
                <pre style="text-align: left; max-height: 200px; overflow-y: auto;">
${error.message || 'Unknown error occurred'}
                </pre>
            </div>
            `,
            confirmButtonText: "Tutup",
            confirmButtonColor: "#dc3545"
        });
    } finally {
        // Reset button state
        btn.disabled = false;
        btn.innerHTML = "Submit Semua Indikator KATSINOV";
    }
}

// Enhanced response collection function
function collectDetailedResponses() {
    const responses = [];
    const MIN_PERCENTAGE_TO_SUBMIT = 80.0; // Same threshold

    for (let i = 1; i <= 6; i++) { // Assuming max 6 indicators
        const indicatorContainer = document.querySelector(`.indicator-card[data-indicator="${i}"]`);

        // If indicator container doesn't exist or is hidden, stop collecting for this and subsequent ones.
        if (!indicatorContainer || indicatorContainer.style.display === 'none') {
            break; // Stop processing further indicators
        }

        // Get the calculated percentage for this indicator
        // We rely on indikator.js having updated the DOM
        const percentageTextElement = indicatorContainer.querySelector("tr.total-row:last-child td.total-value"); // e.g., (90.00%)
        let currentPercentage = 0;
        if (percentageTextElement && percentageTextElement.textContent) {
            const match = percentageTextElement.textContent.match(/\(([\d.]+)\s*%\)/);
            if (match && match[1]) {
                currentPercentage = parseFloat(match[1]);
            }
        }

        // If current indicator's percentage is below threshold, DO NOT collect its data, and stop.
        if (currentPercentage < MIN_PERCENTAGE_TO_SUBMIT) {
            break; // Stop processing. Data for this indicator (i) and subsequent ones will not be sent.
        }

        // If we reach here, the current indicator (i) has passed the threshold and its data should be collected.
        indicatorContainer.querySelectorAll('table.katsinov-table tr').forEach((row, rowIndex) => {
            const aspectCell = row.querySelector('.aspect-cell');
            if (!aspectCell) return; // Skip header/total rows

            const aspect = aspectCell.textContent.trim();
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const dropdown = row.querySelector('select.form-select');
            
            const response = {
                indicator: i, // Use the current loop's indicator number
                row: rowIndex, // This is the visual row index, might need adjustment if you map to specific sub-questions
                aspect: aspect,
                score: checkedRadio ? parseInt(checkedRadio.value) : null,
                dropdown: dropdown ? dropdown.value : null
            };

            if (response.aspect && 
                (response.score !== null || (response.dropdown && response.dropdown !== "")) &&
                ['T','O','R','M','P','Mf','I'].includes(response.aspect)) { // Ensure valid aspects
                responses.push(response);
            }
        });

        // Collect notes for this valid indicator
        const noteTextArea = indicatorContainer.querySelector(`textarea[name="notes[${i}]"]`);
        if (noteTextArea && noteTextArea.value.trim() !== "") {
            // The main payload construction will grab all notes, or you can add them here
            // For simplicity, let the FormData in submitAllIndicators grab the notes.
        }
    }
    
    console.log('Collected responses to be sent:', JSON.stringify(responses, null, 2));
    return responses;
}


// Override default form submission
document.getElementById('katsinovForm').addEventListener('submit', submitAllIndicators);
// Add console logging for more debug information
function debugSubmit(event) {
    event.preventDefault();
    
    console.log("Form submission initiated");
    
    const formData = new FormData(document.getElementById("katsinovForm"));
    
    // Log all form data
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
    
    // Log responses
    const responses = collectDetailedResponses();
    console.log("Detailed Responses:", responses);
    
    // Fetch debugging
    fetch("/katsinov/store", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        },
        body: formData
    })
    .then(response => {
        console.log("Response status:", response.status);
        console.log("Response headers:", response.headers);
        return response.text(); // Use text() instead of json() to see raw response
    })
    .then(text => {
        console.log("Raw response text:", text);
        try {
            const parsed = JSON.parse(text);
            console.log("Parsed response:", parsed);
        } catch (error) {
            console.error("JSON Parsing error:", error);
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
    });
}

// Optional: Replace original submit handler with debug version
document.getElementById('katsinovForm').addEventListener('submit', debugSubmit);

// Enhanced response collection
function collectDetailedResponses() {
    const responses = [];
    
    document.querySelectorAll('[data-indicator]').forEach(indicatorContainer => {
        const indicatorNumber = parseInt(indicatorContainer.dataset.indicator);
        
        indicatorContainer.querySelectorAll('tr').forEach((row, rowIndex) => {
            const aspectCell = row.querySelector('.aspect-cell');
            if (!aspectCell) return;

            const aspect = aspectCell.textContent.trim();
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const dropdown = row.querySelector('select.form-select');
            
            const response = {
                indicator: indicatorNumber,
                row: rowIndex,
                aspect: aspect,
                score: checkedRadio ? parseInt(checkedRadio.value) : null,
                dropdown: dropdown ? dropdown.value : null
            };

            // Only add if it has meaningful data
            if (response.aspect && (response.score !== null || response.dropdown)) {
                responses.push(response);
            }
        });
    });

    // Log collected responses for debugging
    console.log('Collected Responses:', JSON.stringify(responses, null, 2));
    
    return responses;
}

// Override default form submission
document.getElementById('katsinovForm').addEventListener('submit', submitAllIndicators);

function collectFormResponses() {
    const responses = [];
    
    document.querySelectorAll('[data-indicator]').forEach(indicatorContainer => {
        const indicatorNumber = parseInt(indicatorContainer.dataset.indicator);
        
        // Collect all rows in the current indicator, not just those with radio buttons
        indicatorContainer.querySelectorAll('tr').forEach((row, index) => {
            const aspectCell = row.querySelector('.aspect-cell');
            if (!aspectCell) return; // Skip header and total rows
            
            const aspect = aspectCell.textContent.trim();
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const dropdown = row.querySelector('select.form-select');
            
            // Always push a response, even if no radio is checked
            const response = {
                indicator: indicatorNumber,
                row: index,
                aspect: aspect,
                score: checkedRadio ? parseInt(checkedRadio.value) : null,
                dropdown: dropdown ? dropdown.value : null
            };
            
            responses.push(response);
        });
    });
    
    console.log('Collected responses:', JSON.stringify(responses, null, 2));
    return responses;
}

// Event listener for radio buttons to update the UI and calculations
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            // Trigger chart updates if they exist
            if (window.updateSpiderwebChart) {
                window.updateSpiderwebChart();
            }
            
            // Highlight the selected radio button's parent row
            const row = this.closest('tr');
            if (row) {
                // Remove highlight from all rows in this table
                const table = row.closest('table');
                if (table) {
                    table.querySelectorAll('tr').forEach(r => {
                        r.classList.remove('selected-row');
                    });
                }
                
                // Add highlight to this row
                row.classList.add('selected-row');
            }
        });
    });
    
    // Add CSS for highlighted rows
    const style = document.createElement('style');
    style.textContent = `
        .form-select {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            width: 100%;
            max-width: 80px;
        }

        .form-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Style untuk row dengan dropdown */
        .dropdown-cell {
            padding: 8px;
            text-align: center;
        }
    `;
    document.head.appendChild(style);

});