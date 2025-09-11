@extends('admin.admin')

@section('contentadmin')
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

            <div class="table-responsive">
                <table class="table table-striped" id="respondent-table">
                    <thead>
                        <tr>
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
                            <th>Tanggal Dibuat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($respondens as $responden)
                            <tr>
                                <td>{{ $responden->title }}</td>
                                <td>{{ $responden->first_name }}</td>
                                <td>{{ $responden->last_name }}</td>
                                <td>{{ $responden->institution }}</td>
                                <td>{{ $responden->company_name }}</td>
                                <td>{{ $responden->job_title }}</td>
                                <td>{{ $responden->country }}</td>
                                <td>{{ $responden->email }}</td>
                                <td>{{ $responden->phone }}</td>
                                <td>{{ $responden->survey_2023 }}</td>
                                <td>{{ $responden->survey_2024 }}</td>
                                <td>{{ $responden->category }}</td>
                                <td>{{ $responden->created_at ? $responden->created_at->format('d M Y, H:i') : 'N/A' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.qsresponden.edit', $responden->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class='bx bxs-edit'></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $responden->id }}">
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

