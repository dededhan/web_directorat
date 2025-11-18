@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="head-title">
        <div class="left">
            <h1>Add QS Survey Responden</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route('admin_pemeringkatan.qsresponden.index') }}">QS Responden</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Create</a>
                </li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Create New QS Survey Responden</h3>
            </div>

            <form method="POST" action="{{ route('admin_pemeringkatan.qsresponden.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <select class="form-select" name="title" id="title" required>
                            <option value="">Select</option>
                            <option value="mr">Mr.</option>
                            <option value="mrs">Mrs.</option>
                            <option value="ms">Ms.</option>
                            <option value="prof">Prof.</option>
                            <option value="dr">Dr.</option>
                        </select>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="institution" class="form-label">Institution/Organization</label>
                        <input type="text" class="form-control" name="institution" id="institution" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="company_name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="job_title" class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="job_title" id="job_title" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" id="country" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Select Category</option>
                            <option value="academic">Academic</option>
                            <option value="employee">Employee/Employer</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="survey_2023" class="form-label">Survey 2023</label>
                        <select class="form-select" name="survey_2023" id="survey_2023">
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="survey_2024" class="form-label">Survey 2024</label>
                        <select class="form-select" name="survey_2024" id="survey_2024">
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <a href="{{ route('admin_pemeringkatan.qsresponden.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Responden</button>
                </div>
            </form>
        </div>
    </div>

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

        .head {
            margin-bottom: 20px;
        }

        .head h3 {
            font-weight: 600;
            color: #333;
        }
    </style>
@endsection
