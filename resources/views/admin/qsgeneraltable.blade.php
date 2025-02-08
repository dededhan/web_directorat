@extends('admin.admin')

@section('contentadmin')
<div class="container">
    <h2>General Respondent Submissions</h2>
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
                    <th>2023 Survey</th>
                    <th>2024 Survey</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quesionerGenerals as $respondent)
                <tr>
                    <td>{{ $respondent->respondent_type }}</td>
                    <td>{{ $respondent->firstname }} {{ $respondent->lastname }}</td>
                    <td>{{ $respondent->institution }}</td>
                    <td>{{ $respondent->activity_name }}</td>
                    <td>{{ $respondent->activity_date }}</td>
                    <td>{{ $respondent->country }}</td>
                    <td>{{ $respondent->email }}</td>
                    <td>{{ $respondent->phone }}</td>
                    <td>{{ $respondent->survey_2023 }}</td>
                    <td>{{ $respondent->survey_2024 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection