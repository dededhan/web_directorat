@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>General Respondent Submissions</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">General Respondent Submissions</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>General Respondent Submissions</h3>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Respondent Type</th>
                            <th>Name</th>
                            <th>Institution</th>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>Phone</th>
                            {{-- <th>2023 Survey</th>
                            <th>2024 Survey</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quesionerGenerals as $respondent)
                            <tr>
                                <td>{{ $respondent->respondent_type }}</td>
                                <td>{{ $respondent->firstname }} {{ $respondent->lastname }}</td>
                                <td>{{ $respondent->institution }}</td>
                                <td>{{ $respondent->activity_name }}</td>
                                <td>{{ $respondent->activity_date }}</td>
                                <td>{{ $respondent->country }}</td>
                                <td>{{ $respondent->email }}</td>
                                <td>{{ $respondent->phone }}</td>
                                {{-- <td>{{ $respondent->survey_2023 }}</td>
                                <td>{{ $respondent->survey_2024 }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

        .table-responsive {
            overflow-x: auto;
        }
        
        .badge {
            font-size: 0.7em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .table th {
            white-space: nowrap;
        }
    </style>
@endsection