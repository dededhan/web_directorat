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

    <form method="POST" action="{{ route('qs-academic.store') }}">
        @csrf
        <div class="form-section">
            <div class="section-title">ACADEMIC Information</div>
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
            <div class="section-title">ACADEMIC Details</div>
            <div class="form-group">
                <label class="form-label">Job Title</label>
                <select class="form-select" name="answer_job_title">
                    <option value="">Select Job Title</option>
                    <option value="vc">President/Vice-Chancellor</option>
                    <option value="vp">Vice-President/Deputy Vice-Chancellor</option>
                    <option value="sa">Senior Administrator</option>
                    <option value="hod">Head of Department</option>
                    <option value="ass">Professor/Associate Professor</option>
                    <option value="ap">Assistant Professor</option>
                    <option value="sl">Senior Lecturer</option>
                    <option value="lec">Lecturer</option>
                    <option value="rs">Research Specialist</option>
                    <option value="fm">Administrator/Functional Manager</option>
                    <option value="ra">Research Assistant</option>
                    <option value="ta">Teaching Assistant</option>
                    <option value="ao">Admissions Officer</option>
                    <option value="la">Librarian/Library Assistant</option>
                    <option value="other">Other</option>
                </select>
                @error('answer_job_title') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Institution</label>
                <input type="text" class="form-control" name="answer_institution">
                @error('answer_instititution') {{ $message }} @enderror
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
                        <input class="form-check-input" type="radio" name="answer_survey_2023" value="yes">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_survey_2023" value="no">
                        <label class="form-check-label">No</label>
                    </div>
                    @error('answer_survey_2023') {{ $message }} @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">2024 Survey</label>
                <div class="radio-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_survey_2024" value="yes">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_survey_2024" value="no">
                        <label class="form-check-label">No</label>
                    </div>
                    @error('answer_survey_2024') {{ $message }} @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn-submit">Submit Survey</button>
    </form>
@stop