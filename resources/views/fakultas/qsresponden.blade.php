@extends('fakultas.index')

@section('contentfakultas')
    @php
        // mapping 1
        $employeeJobTitles = [
            'ceo' => 'CEO/President/Managing Director',
            'coo' => 'COO/CFO/CTO/CIO/CMO',
            'vp' => 'Director/Partner/Vice President',
            'shr' => 'Senior Human Resources/Recruitment',
            'ohr' => 'Other Human Resources/Recruitment',
            'exe' => 'Manager/Executive',
            'cons' => 'Consultant/Advisor',
            'coor' => 'Coordinator/Officer',
            'ana' => 'Analyst/Specialist',
            'ass' => 'Assistant/Administrator',
            'other' => 'Other',
        ];

        // mapping 2
        $academicJobTitles = [
            'vc' => 'President/Vice-Chancellor',
            'vp' => 'Vice-President/Deputy Vice-Chancellor',
            'sa' => 'Senior Administrator',
            'hod' => 'Head of Department',
            'ass' => 'Professor/Associate Professor',
            'ap' => 'Assistant Professor',
            'sl' => 'Senior Lecturer',
            'lec' => 'Lecturer',
            'rs' => 'Research Specialist',
            'fm' => 'Administrator/Functional Manager',
            'ra' => 'Research Assistant',
            'ta' => 'Teaching Assistant',
            'ao' => 'Admissions Officer',
            'la' => 'Librarian/Library Assistant',
            'other' => 'Other',
        ];
    @endphp
    <div class="head-title">
        <div class="left">
            <h1>QS Responden Table</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('fakultas.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">QS Responden Table</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>QS Respondent Data</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="respondent-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Institution / Industry</th>
                            <th>Company Name</th>
                            <th>Job Title</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>2023 Survey</th>
                            <th>2024 Survey</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($respondens as $responden)
                            <tr>
                                <td>{{ Str::ucfirst($responden->title) }}</td>
                                <td>{{ Str::title($responden->first_name) }}</td>
                                <td>{{ Str::title($responden->last_name) }}</td>
                                <td>{{ Str::title($responden->institution) }}</td>
                                <td>{{ $responden->company_name }}</td>
                                <td>
                                    @php
                                        $jobTitleKey = $responden->job_title;
                                        $jobTitleDisplay = Str::title(str_replace('_', ' ', $jobTitleKey));

                                        if ($responden->category === 'academic') {
                                            $jobTitleDisplay = $academicJobTitles[$jobTitleKey] ?? $jobTitleDisplay;
                                        } elseif ($responden->category === 'employee' || $responden->category === 'employer') {
                                            $jobTitleDisplay = $employeeJobTitles[$jobTitleKey] ?? $jobTitleDisplay;
                                        }
                                    @endphp
                                    {{ $jobTitleDisplay }}
                                </td>
                                <td>{{ Str::title($responden->country) }}</td>
                                <td>{{ $responden->email }}</td>
                                <td>{{ $responden->phone }}</td>
                                <td>{{ Str::ucfirst($responden->survey_2023) }}</td>
                                <td>{{ Str::ucfirst($responden->survey_2024) }}</td>
                                <td>{{ Str::ucfirst($responden->category) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-4">
                    {{ $respondens->links() }}
                </div>
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

        .table thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
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
        }
    </style>
@endsection
