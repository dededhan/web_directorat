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
function collectNotes() {
    const notes = {};
    
    // Get all notes textareas using the pattern "notes[indicator_number]"
    document.querySelectorAll('textarea[name^="notes["]').forEach(textarea => {
        // Extract the indicator number from the name attribute
        const match = textarea.name.match(/notes\[(\d+)\]/);
        if (match && match[1]) {
            const indicatorNumber = match[1];
            notes[indicatorNumber] = textarea.value.trim();
        }
    });
    
    console.log('Collected notes:', notes);
    return notes;
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
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';

    try {
        // Collect form data manually to ensure complete capture
        const formData = new FormData(document.getElementById("katsinovForm"));
        
        // Collect responses with detailed logging
        const responses = collectDetailedResponses();
        // Collect notes from all indicators
        const notes = collectNotes();
        // Prepare payload with separate basic information and responses
        const payload = {
            title: formData.get('title'),
            focus_area: formData.get('focus_area'),
            project_name: formData.get('project_name'),
            institution: formData.get('institution'),
            address: formData.get('address'),
            contact: formData.get('contact'),
            assessment_date: formData.get('assessment_date'),
            responses: responses,
            notes: notes
        };

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
            confirmButtonColor: "#176369"
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
    
    document.querySelectorAll('[data-indicator]').forEach(indicatorContainer => {
        const indicatorNumber = parseInt(indicatorContainer.dataset.indicator);
        
        indicatorContainer.querySelectorAll('tr').forEach((row, rowIndex) => {
            const aspectCell = row.querySelector('.aspect-cell');
            if (!aspectCell) return;

            const aspect = aspectCell.textContent.trim();
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const dropdown = row.querySelector('select.form-select');
            
            // Prepare response object with all required fields
            const response = {
                indicator: indicatorNumber,
                row: rowIndex,
                aspect: aspect,
                score: checkedRadio ? parseInt(checkedRadio.value) : null,
                dropdown: dropdown ? dropdown.value : null
            };

            // Validate response before adding
            if (response.aspect && 
                (response.score !== null || response.dropdown) && 
                ['T','O','R','M','P','Mf','I'].includes(response.aspect)) {
                responses.push(response);
            }
        });
    });

    // Validate responses
    if (responses.length === 0) {
        throw new Error("Tidak ada respons yang dikumpulkan. Harap lengkapi semua bagian.");
    }

    // Log collected responses for debugging
    console.log('Collected Responses:', JSON.stringify(responses, null, 2));
    
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