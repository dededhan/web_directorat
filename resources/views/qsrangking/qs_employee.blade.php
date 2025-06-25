@extends('qsrangking.qs_layout')

@section('form')
    {{-- New style block to make the layout more compact --}}
    <style>
        .form-section {
            margin-bottom: 1.5rem; /* Reduced vertical space between sections */
            padding-bottom: 1.5rem;
        }
        .section-title {
            margin-bottom: 1rem; /* Reduced space below section titles */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Logic for Country Dropdown (existing) ---
            fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    const sortedCountries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                    const countrySelect = document.querySelector('select[name="answer_country"]');
                    countrySelect.innerHTML = '<option value="">Select Country</option>';
                    sortedCountries.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.name.common;
                        option.textContent = country.name.common;
                        countrySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching countries:', error));

            // --- Logic for Industry Dropdown (existing) ---
            const institutionSelect = document.getElementById('institution_select');
            const otherInstitutionInput = document.getElementById('institution_other_input');
            const hiddenInstitutionInput = document.getElementById('answer_institution_hidden');

            function syncInstitutionValue() {
                if (institutionSelect.value === 'other') {
                    otherInstitutionInput.style.display = 'block';
                    hiddenInstitutionInput.value = otherInstitutionInput.value;
                } else {
                    otherInstitutionInput.style.display = 'none';
                    hiddenInstitutionInput.value = institutionSelect.value;
                }
            }

            institutionSelect.addEventListener('change', syncInstitutionValue);
            otherInstitutionInput.addEventListener('input', () => {
                if (institutionSelect.value === 'other') {
                    hiddenInstitutionInput.value = otherInstitutionInput.value;
                }
            });
            syncInstitutionValue();

            // --- NEW: DYNAMIC SURVEY YEAR GENERATION ---
            const surveyContainer = document.getElementById('survey-participation-container');
            const currentYear = new Date().getFullYear();
            const yearsToShow = [currentYear, currentYear - 1]; // Shows current and previous year

            yearsToShow.forEach(year => {
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                const label = document.createElement('label');
                label.className = 'form-label';
                label.textContent = `${year} Survey`;

                const radioGroup = document.createElement('div');
                radioGroup.className = 'radio-group';
                
                // Create "Yes" and "No" radio buttons for the year
                ['yes', 'no'].forEach(val => {
                    const div = document.createElement('div');
                    div.className = 'form-check';

                    const input = document.createElement('input');
                    input.className = 'form-check-input';
                    input.type = 'radio';
                    input.name = `survey_participation[${year}]`; // Name is now an array
                    input.value = val;
                    input.required = true;

                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.textContent = val.charAt(0).toUpperCase() + val.slice(1); // "Yes" or "No"

                    div.append(input, label);
                    radioGroup.append(div);
                });

                formGroup.append(label, radioGroup);
                surveyContainer.appendChild(formGroup);
            });
        });
    </script>

    <form method="POST" action="{{ route('qs-employee.store') }}">
        @csrf
        {{-- Personal Information Section --}}
        <div class="form-section">
            <div class="section-title">Personal Information</div>
            <div class="form-group" style="flex: 0.5 1 150px;">
                <label class="form-label">Title</label>
                <select class="form-select" name="answer_title" required>
                    <option value="">Select</option>
                    <option value="mr">Mr.</option>
                    <option value="ms">Ms.</option>
                </select>
                @error('answer_title') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="answer_firstname" required>
                @error('answer_firstname') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="answer_lastname" required>
                @error('answer_lastname') {{ $message }} @enderror
            </div>
        </div>

        {{-- Professional Details Section --}}
        <div class="form-section">
            <div class="section-title">Professional Details</div>
            <div class="form-group">
                <label class="form-label">Job Title</label>
                <select class="form-select" name="answer_job_title" required>
                    <option value="">Select Job Title</option>
                    <option value="ceo">CEO/President/Managing Director</option>
                    <option value="coo">COO/CFO/CTO/CIO/CMO</option>
                    <option value="vp">Director/Partner/Vice President</option>
                    <option value="shr">Senior Human Resources/Recruitment</option>
                    <option value="ohr">Other Human Resources/Recruitment</option>
                    <option value="exe">Manager/Executive</option>
                    <option value="cons">Consultant/Advisor</option>
                    <option value="coor">Coordinator/Officer</option>
                    <option value="ana">Analyst/Specialist</option>
                    <option value="ass">Assistant/Administrator</option>
                    <option value="other">Other</option>
                </select>
                @error('answer_job_title') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Industry</label>
                <select class="form-select" id="institution_select" required>
                    <option value="">Select Industry</option>
                    <option value="Agriculture/Fishing/Forestry">Agriculture/Fishing/Forestry</option>
                    <option value="Construction/Real Estate">Construction/Real Estate</option>
                    <option value="Consulting/Professional Service">Consulting/Professional Service</option>
                    <option value="Consumer Goods">Consumer Goods</option>
                    <option value="Defense/Security/Rescue">Defense/Security/Rescue</option>
                    <option value="Education">Education</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Entertainment/Leisure">Entertainment/Leisure</option>
                    <option value="Finance/Banking">Finance/Banking</option>
                    <option value="Government/Public Sector">Government/Public Sector</option>
                    <option value="Health/Medical">Health/Medical</option>
                    <option value="Hospitality/Travel/Tourism">Hospitality/Travel/Tourism</option>
                    <option value="HR/Recruitment/Training">HR/Recruitment/Training</option>
                    <option value="Law">Law</option>
                    <option value="Logistics/Transportation">Logistics/Transportation</option>
                    <option value="Manufacturing">Manufacturing</option>
                    <option value="Media/Advertising">Media/Advertising</option>
                    <option value="Metals/Mining">Metals/Mining</option>
                    <option value="Non-profit/Charity">Non-profit/Charity</option>
                    <option value="Oil & Gas">Oil & Gas</option>
                    <option value="Pharma/Biotech">Pharma/Biotech</option>
                    <option value="R&D/Science">R&D/Science</option>
                    <option value="Renewable Energy">Renewable Energy</option>
                    <option value="Retail/Wholesale">Retail/Wholesale</option>
                    <option value="Technology">Technology</option>
                    <option value="Telecoms">Telecoms</option>
                    <option value="Utilities">Utilities</option>
                    <option value="other">Yang lain: (input)</option>
                </select>
                <input type="text" class="form-control mt-2" id="institution_other_input" style="display: none;" placeholder="Please specify your industry">
                <input type="hidden" name="answer_institution" id="answer_institution_hidden">
                @error('answer_institution') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control" name="answer_company" required>
                @error('answer_company') {{ $message }} @enderror
            </div>
        </div>

        {{-- Contact Information Section --}}
        <div class="form-section">
            <div class="section-title">Contact Information</div>
            <div class="form-group">
                <label class="form-label">Country</label>
                <select class="form-select" name="answer_country" required>
                    <option value="">Select Country</option>
                </select>
                @error('answer_country') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="answer_email" required>
                @error('email') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="tel" class="form-control" name="answer_phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" pattern="[0-9]+" title="Please enter numbers only" required>
                @error('phone') {{ $message }} @enderror
            </div>
        </div>

        <!-- === DYNAMIC SURVEY PARTICIPATION SECTION === -->
        <div class="form-section" id="survey-participation-container">
            {{-- This div will be populated dynamically by the script --}}
        </div>
        <!-- IMPORTANT: The backend needs to be updated to handle this data.
             The form now sends an array named 'survey_participation', like:
             survey_participation[2024] = 'yes'
             survey_participation[2023] = 'no'

             Your 'RespondenAnswerController' and database schema must be changed.
             Instead of 'survey_2023' and 'survey_2024' columns, consider a single
             JSON or TEXT column (e.g., 'survey_data') to store the participation results.
        -->
        @error('survey_participation') {{ $message }} @enderror
        
        <button type="submit" class="btn-submit">Submit Survey</button>
    </form>
@stop
