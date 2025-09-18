@extends('admin.admin')

@section('contentadmin')
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
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">QS Responden Table</a>
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
                <h3>QS Respondent Data</h3>
            </div>

            <form method="GET" action="{{ route('admin.qsresponden.index') }}" class="mb-3">
                <div class="filter-card p-3 mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4">
                            <label class="form-label">Search</label>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, email, institution, company, country, job title">
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All</option>
                                <option value="academic" {{ request('category')==='academic' ? 'selected' : '' }}>Academic</option>
                                <option value="employee" {{ request('category')==='employee' || request('category')==='employer' ? 'selected' : '' }}>Employee</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" value="{{ request('country') }}" class="form-control" placeholder="e.g. Indonesia">
                        </div>
                        <div class="col-lg-4 col-md-8">
                            <label class="form-label">Job Title</label>
                            <select name="job_title" class="form-select">
                                <option value="">All Job Titles</option>
                                <optgroup label="Academic">
                                    @foreach($academicJobTitles as $key=>$label)
                                        <option value="{{ $key }}" {{ request('job_title')===$key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Employee">
                                    @foreach($employeeJobTitles as $key=>$label)
                                        <option value="{{ $key }}" {{ request('job_title')===$key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">Rows</label>
                            <select name="per_page" class="form-select">
                                @foreach([25,50,100,200] as $n)
                                    <option value="{{ $n }}" {{ (int)request('per_page',50)===$n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">Survey 2023</label>
                            <select name="survey_2023" class="form-select">
                                <option value="">All</option>
                                <option value="yes" {{ request('survey_2023')==='yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ request('survey_2023')==='no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">Survey 2024</label>
                            <select name="survey_2024" class="form-select">
                                <option value="">All</option>
                                <option value="yes" {{ request('survey_2024')==='yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ request('survey_2024')==='no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-lg-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">Apply</button>
                            <a href="{{ route('admin.qsresponden.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

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
                            <th>Tanggal Dibuat</th>
                            <th>Actions</th>
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
                                <td>{{ $responden->category === 'employer' ? 'Employee' : Str::ucfirst($responden->category) }}</td>
                                <td>{{ $responden->created_at ? $responden->created_at->format('d M Y, H:i') : 'N/A' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.qsresponden.edit', $responden->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class='bx bxs-edit'></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-id="{{ $responden->id }}">
                                            <i class='bx bxs-trash'></i>
                                        </button>
                                        <form id="delete-form-{{ $responden->id }}"
                                            action="{{ route('admin.qsresponden.destroy', $responden->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">Tidak ada data</td>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const respondenId = this.dataset.id;
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${respondenId}`).submit();
                        }
                    });
                });
            });
        });
    </script>

    <style>
        .filter-card {
            background: #f8f9fb;
            border: 1px solid #e9ecef;
            border-radius: 12px;
        }
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

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 12px;
            }
        }
    </style>
@endsection
