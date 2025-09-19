@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="head-title">
        <div class="left">
            <h1>QS Responden Table</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
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
                <table class="table table-striped" id="respondent-table">
                    <thead>
                        <tr>
                            <th>Input Source</th>
                            <th>Title</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Institution</th>
                            <th>Company Name</th>
                            <th>Job Title</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>2023 Survey</th>
                            <th>2024 Survey</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($respondens as $responden)
                            <tr>
                                <td>
                                    @if($responden->responden && $responden->responden->user)
                                        @php
                                            $user = $responden->responden->user;
                                            $role = $user->role;
                                            $name = $user->name;
                                            
                                            if ($role === 'admin_direktorat') {
                                                $displayText = 'Direktorat';
                                            } elseif ($role === 'fakultas') {
                                                $displayText = 'Fakultas (' . strtoupper($name) . ')';
                                            } elseif ($role === 'prodi') {
                                                $parts = explode('-', $name, 2);
                                                $facultyCode = $parts[0] ?? '';
                                                $prodiName = $parts[1] ?? 'Unknown';
                                                $displayText = 'Prodi (' . strtoupper($facultyCode) . ' - ' . ucwords($prodiName) . ')';
                                            } else {
                                                $displayText = ucfirst($role) . ' (' . $name . ')';
                                            }
                                        @endphp
                                        {{ $displayText }}
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                <td>{{ Str::ucfirst($responden->title) }}</td>
                                <td>{{ Str::title($responden->first_name) }}</td>
                                <td>{{ Str::title($responden->last_name) }}</td>
                                <td>{{ Str::title($responden->institution) }}</td>
                                <td>{{ $responden->company_name }}</td>
                                <td>{{ $responden->job_title }}</td>
                                <td>{{ Str::title($responden->country) }}</td>
                                <td>{{ $responden->email }}</td>
                                <td>{{ $responden->phone }}</td>
                                <td>{{ Str::ucfirst($responden->survey_2023) }}</td>
                                <td>{{ Str::ucfirst($responden->survey_2024) }}</td>
                                <td>{{ $responden->category === 'employer' ? 'Employee' : Str::ucfirst($responden->category) }}</td>
                                <td>
                                    <!-- Add action buttons if needed -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
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