@extends('qsrangking.qs_layout')

@section('form')
    <script>
        // Fetch countries when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    // Sort countries alphabetically by name
                    const sortedCountries = data.sort((a, b) => {
                        return a.name.common.localeCompare(b.name.common);
                    });
                    
                    const countrySelect = document.querySelector('select[name="answer_country"]');
                    // Clear existing options except the first one
                    countrySelect.innerHTML = '<option value="">Select Country</option>';
                    
                    // Add countries to select element
                    sortedCountries.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.name.common;
                        option.textContent = country.name.common;
                        countrySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching countries:', error));
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
            <div class="form-group">
                <label class="form-label">Institution</label>
                <input type="text" class="form-control" name="answer_institution">
                @error('answer_institution') {{ $message }} @enderror
            </div>
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