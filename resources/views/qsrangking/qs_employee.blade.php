@extends('qsrangking.qs_layout')

@section('form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    const sortedCountries = data.sort((a, b) => {
                        return a.name.common.localeCompare(b.name.common);
                    });
                    
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
        });
    </script>

    <form method="POST" action="{{ route('qs-employee.store') }}">
        @csrf
        <div class="form-section">
            <div class="section-title">Personal Information</div>
            <div class="form-group">
                <label class="form-label">Title</label>
                <select class="form-select" name="answer_title">
                    <option value="">Select Title</option>
                    <option value="mr">Mr.</option>
                    <option value="ms">Ms.</option>
                </select>
                @error('answer_title') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="answer_firstname">
                @error('answer_firstname') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="answer_lastname">
                @error('answer_lastname') {{ $message }} @enderror
            </div>
        </div>
        <div class="form-section">
            <div class="section-title">Professional Details</div>
            <div class="form-group">
                <label class="form-label">Job Title</label>
                <select class="form-select" name="answer_job_title">
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
            <!-- === MODIFIED INSTITUTION/INDUSTRY FIELD === -->
            <div class="form-group">
                <label class="form-label">Industry</label>
                <select class="form-select" id="institution_select">
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
                <!-- This input is for the "Other" option and is hidden by default -->
                <input type="text" class="form-control mt-2" id="institution_other_input" style="display: none;" placeholder="Please specify your industry">
                <!-- This hidden input will hold the final value for the backend -->
                <input type="hidden" name="answer_institution" id="answer_institution_hidden">
                @error('answer_institution') {{ $message }} @enderror
            </div>
            <!-- === END OF MODIFICATION === -->
            <div class="form-group">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control" name="answer_company">
                @error('answer_company') {{ $message }} @enderror
            </div>
        </div>
        <div class="form-section">
            <div class="section-title">Contact Information</div>
            <div class="form-group">
                <label class="form-label">Country</label>
                <select class="form-select" name="answer_country">
                    <option value="">Select Country</option>
                    <!-- Countries will be populated by JavaScript -->
                </select>
                @error('answer_country') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="answer_email">
                @error('email') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="tel" class="form-control" name="answer_phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" pattern="[0-9]+" title="Please enter numbers only">
                @error('phone') {{ $message }} @enderror
            </div>
        </div>
        <div class="form-section">
            <div class="section-title">Survey Participation</div>
            <div class="form-group">
                <label class="form-label">2023 Survey</label>
                <div class="radio-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="yes" name="answer_survey_2023">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="no" name="answer_survey_2023">
                        <label class="form-check-label">No</label>
                    </div>
                    @error('answer_survey_2023') {{ $message }} @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">2024 Survey</label>
                <div class="radio-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="yes" name="answer_survey_2024">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="no" name="answer_survey_2024">
                        <label class="form-check-label">No</label>
                    </div>
                    @error('answer_survey_2024') {{ $message }} @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn-submit">Submit Survey</button>
    </form>
@stop
