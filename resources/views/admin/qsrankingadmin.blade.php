@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>QS Global Academic Reputation Survey Input</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Survey Input</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Responden Survey Input</h3>
                <div class="mb-3">
                    <label class="form-label">Pilih Tipe Responden</label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="respondent-type" id="academic" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="academic">Academic</label>

                        <input type="radio" class="btn-check" name="respondent-type" id="employer" autocomplete="off">
                        <label class="btn btn-outline-primary" for="employer">Employer</label>
                    </div>
                </div>
            </div>

            <form id="survey-form">
                <!-- Academic Responden Section -->
                <div id="academic-section">
                    <h4>Academic Respondent Details</h4>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="academic-title" class="form-label">Title</label>
                            <select class="form-select" id="academic-title" required>
                                <option value="">Select Title</option>
                                <option value="mr">Mr.</option>
                                <option value="ms">Ms.</option>
                                <option value="dr">Dr.</option>
                                <option value="prof">Prof.</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="academic-first-name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="academic-first-name" required>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="academic-last-name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="academic-last-name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="academic-job-title" class="form-label">Job Title</label>
                            <select class="form-select" id="academic-job-title" required>
                                <option value="">Select Job Title</option>
                                <option value="professor">Professor</option>
                                <option value="associate-professor">Associate Professor</option>
                                <option value="assistant-professor">Assistant Professor</option>
                                <option value="lecturer">Lecturer</option>
                                <option value="researcher">Researcher</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="academic-department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="academic-department" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="academic-institution" class="form-label">Institution/Company Name</label>
                            <input type="text" class="form-control" id="academic-institution" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="academic-country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="academic-country" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="academic-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="academic-email" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="academic-phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="academic-phone" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QS Survey 2023 Participation</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="academic-2023-survey" id="academic-2023-yes" value="yes">
                                    <label class="form-check-label" for="academic-2023-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="academic-2023-survey" id="academic-2023-no" value="no">
                                    <label class="form-check-label" for="academic-2023-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QS Survey 2024 Participation</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="academic-2024-survey" id="academic-2024-yes" value="yes">
                                    <label class="form-check-label" for="academic-2024-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="academic-2024-survey" id="academic-2024-no" value="no">
                                    <label class="form-check-label" for="academic-2024-no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employer Responden Section (Initially Hidden) -->
                <div id="employer-section" style="display:none;">
                    <h4>Employer Respondent Details</h4>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="employer-title" class="form-label">Title</label>
                            <select class="form-select" id="employer-title" required>
                                <option value="">Select Title</option>
                                <option value="mr">Mr.</option>
                                <option value="ms">Ms.</option>
                                <option value="dr">Dr.</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="employer-first-name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="employer-first-name" required>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="employer-last-name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="employer-last-name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="employer-job-title" class="form-label">Job Title</label>
                            <select class="form-select" id="employer-job-title" required>
                                <option value="">Select Job Title</option>
                                <option value="manager">Manager</option>
                                <option value="director">Director</option>
                                <option value="ceo">CEO</option>
                                <option value="hr-manager">HR Manager</option>
                                <option value="recruitment-lead">Recruitment Lead</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="employer-department" class="form-label">Department/Industry</label>
                            <select class="form-select" id="employer-department" required>
                                <option value="">Select Department/Industry</option>
                                <option value="technology">Technology</option>
                                <option value="finance">Finance</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="education">Education</option>
                                <option value="manufacturing">Manufacturing</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="employer-company" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="employer-company" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="employer-country" class="form-label">Country or Territory</label>
                            <input type="text" class="form-control" id="employer-country" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="employer-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="employer-email" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="employer-phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="employer-phone" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QS Survey 2023 Participation</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="employer-2023-survey" id="employer-2023-yes" value="yes">
                                    <label class="form-check-label" for="employer-2023-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="employer-2023-survey" id="employer-2023-no" value="no">
                                    <label class="form-check-label" for="employer-2023-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QS Survey 2024 Participation</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="employer-2024-survey" id="employer-2024-yes" value="yes">
                                    <label class="form-check-label" for="employer-2024-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="employer-2024-survey" id="employer-2024-no" value="no">
                                    <label class="form-check-label" for="employer-2024-no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit Survey Input</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Respondent List</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="respondent-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Job Title</th>
                                <th>Institution/Company</th>
                                <th>Country</th>
                                <th>Email</th>
                                <th>2023 Survey</th>
                                <th>2024 Survey</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="respondent-list">
                            <!-- Dynamically added rows will appear here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const academicRadio = document.getElementById('academic');
            const employerRadio = document.getElementById('employer');
            const academicSection = document.getElementById('academic-section');
            const employerSection = document.getElementById('employer-section');

            academicRadio.addEventListener('change', function() {
                if (this.checked) {
                    academicSection.style.display = 'block';
                    employerSection.style.display = 'none';
                }
            });

            employerRadio.addEventListener('change', function() {
                if (this.checked) {
                    academicSection.style.display = 'none';
                    employerSection.style.display = 'block';
                }
            });
        });
    </script>

    <style>
        .table-data {
            margin-top: 24px;
        }
        
        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .table-data {
            margin-top: 24px;
        }
        
        .badge {
            font-size: 0.7em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }
    </style>
@endsection