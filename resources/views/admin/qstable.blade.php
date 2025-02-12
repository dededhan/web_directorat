@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>QS General Respondents</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">QS Respondents</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>General Respondent Data</h3>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped" id="respondent-table">
                    <thead>
                        <tr>
                            <th>Respondent Type</th>
                            <th>Full Name</th>
                            <th>Institution</th>
                            <th>Activity</th>
                            <th>Activity Date</th>
                            <th>Country</th>
                            <th>Contact Info</th>
                            <th>Survey Participation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quesionerGenerals as $data)
                        <tr>
                            <td>{{ $data->respondent_type }}</td>
                            <td>{{ $data->firstname }} {{ $data->lastname }}</td>
                            <td>{{ $data->institution }}</td>
                            <td>{{ $data->activity_name }}</td>
                            <td>{{ $data->activity_date }}</td>
                            <td>{{ $data->country }}</td>
                            <td>
                                Email: {{ $data->email }}<br>
                                Phone: {{ $data->phone }}
                            </td>
                            <td>
                                2023: {!! $data->survey_2023 === 'yes' ? '✓' : '✗' !!}<br>
                                2024: {!! $data->survey_2024 === 'yes' ? '✓' : '✗' !!}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
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

        .table-responsive {
            overflow-x: auto;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        .head {
            margin-bottom: 20px;
        }

        .head h3 {
            font-weight: 600;
            color: #333;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 14px;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 12px;
            }
        }
    </style>
@endsection