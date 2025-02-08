<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Respondent Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <style>
        /* Previous styles remain the same */
        :root {
            --primary-color: #176369;
            --primary-light: #207378;
            --primary-dark: #0e4548;
        }
        
        body {
            background: #e6f0f1;
            padding: 2rem;
        }
        
        .form-container {
            max-width: 100%;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(23, 99, 105, 0.1);
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-weight: 600;
        }
        .form-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dde5e6;
        }
        
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--primary-color);
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #a3c7c9;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(23, 99, 105, 0.2);
            outline: none;
        }
        
        .section-title {
            width: 100%;
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .btn-submit {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-submit:hover {
            background: var(--primary-light);
        }

        .date-input-wrapper {
            position: relative;
        }

        .date-input-wrapper:after {
            content: "📅";
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .error {
            border-color: #dc3545 !important;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>General Respondent Form</h2>
        <form method="POST" id="respondentForm" onsubmit="return validateForm(event)" action="{{ route('qs_general.store') }}">
        {{-- <form method="POST" id="respondentForm" onsubmit="return validateForm(event)" action="{{ route('qs-general.store') }}">     --}}
            <!-- Previous form sections remain the same until contact information -->
            @csrf
            <div class="form-section">
                <div class="section-title">Personal Information</div>
                <div class="form-group">
                    <label class="form-label">Respondent Type</label>
                    <select class="form-select" name="general_respondent_type" required>
                        <option value="">Select Respondent Type</option>
                        <option value="student">Student</option>
                        <option value="dosen">Dosen</option>
                        <option value="guru">Guru</option>
                        <option value="profesional">Profesional</option>
                        <option value="wiraswasta">Wiraswasta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="general_firstname" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="general_lastname" required>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">Institution Details</div>
                <div class="form-group">
                    <label class="form-label">Institution</label>
                    <input type="text" class="form-control" name="general_institution" required>
                </div>
            </div>
            <div class="form-section">
                <div class="section-title">Activity Details</div>
                <div class="form-group">
                    <label class="form-label">Activity Name</label>
                    <input type="text" class="form-control" name="general_activity_name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Activity Date</label>
                    <div class="date-input-wrapper">
                        <input type="text" class="form-control datepicker" name="general_activity_date" placeholder="Select date" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">Contact Information</div>
                <!-- Update the country select element -->
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <select class="form-select" name="general_country" id="countrySelect" required>
                        <option value="">Select Country</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="general_email" id="email" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" name="general_phone" id="phone" required>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">Survey Participation</div>
                <div class="form-group">
                    <label class="form-label">2023 Survey</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="general_survey2023" value="yes" required>
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="general_survey2023" value="no">
                        <label class="form-check-label">No</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">2024 Survey</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="general_survey2024" value="yes" required>
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="general_survey2024" value="no">
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
 
            <button type="submit" class="btn-submit">Submit Survey</button>
        </form>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Existing datepicker initialization
    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        minDate: "today",
        disableMobile: false,
        allowInput: true,
        locale: {
            firstDayOfWeek: 1
        }
    });

    // Phone number validation
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        // Remove any non-digit characters
        this.value = this.value.replace(/\D/g, '');
    });

    // Countries API implementation
    const countrySelect = document.getElementById('countrySelect');
    //*
    // Rather than using a third party country list api solution, 
    // I suggest to use the built in Intl function such as below.
    // Much faster, and did not require background client request todo it.
    // */
    function getCountries(lang = 'en') {
        const A = 65
        const Z = 90
        const countryName = new Intl.DisplayNames([lang], { type: 'region' });
        const countries = {}
        for(let i=A; i<=Z; ++i) {
            for(let j=A; j<=Z; ++j) {
                let code = String.fromCharCode(i) + String.fromCharCode(j)
                let name = countryName.of(code)
                if (code !== name) {
                    countries[code] = name
                }
            }
        }
        return Object.values(countries)
    } 
    // above function will return an array of ['Ascension Island', 'Andorra', 'Argentina',.....]
    async function fetchCountries() {
        try {
            // Show loading state
            countrySelect.innerHTML = '<option value="">Loading countries...</option>';
            countrySelect.disabled = true;
            
            // Fetch countries from REST Countries API
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();
            
            // Sort countries by name
            countries.sort((a, b) => {
                const nameA = a.name.common.toUpperCase();
                const nameB = b.name.common.toUpperCase();
                return nameA.localeCompare(nameB);
            });
            
            // Reset select with empty option
            countrySelect.innerHTML = '<option value="">Select Country</option>';
            
            // Add countries to select
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.cca2; // ISO 3166-1 alpha-2 code
                option.textContent = country.name.common;
                countrySelect.appendChild(option);
            });

            // Enable select
            countrySelect.disabled = false;

            // Set Indonesia as default
            const indonesiaOption = Array.from(countrySelect.options).find(option => option.value === 'ID');
            if (indonesiaOption) {
                indonesiaOption.selected = true;
            }
        } catch (error) {
            console.error('Error fetching countries:', error);
            countrySelect.innerHTML = '<option value="">Error loading countries</option>';
            countrySelect.disabled = false;
        }
    }

    // Call the function to fetch countries
    fetchCountries();
});

// Form validation function
function validateForm(event) {
    event.preventDefault();
    
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    let isValid = true;

    // Validate email (must contain @)
    if (!email.value.includes('@')) {
        alert('Email harus menggunakan @');
        email.classList.add('error');
        email.focus();
        isValid = false;
    } else {
        email.classList.remove('error');
    }

    // Validate phone (must be numbers only)
    if (!/^\d+$/.test(phone.value)) {
        alert('Nomor telepon hanya boleh berisi angka');
        phone.classList.add('error');
        if (isValid) phone.focus();
        isValid = false;
    } else {
        phone.classList.remove('error');
    }

    if (isValid) {
        // If all validations pass, submit the form
        document.getElementById('respondentForm').submit();
    }

    return isValid;
}
</script>
</body>
</html>
@include('pemeringkatan.footerpemeringkatan')