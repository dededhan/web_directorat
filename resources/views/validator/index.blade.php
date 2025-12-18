@extends('validator.layout')

@section('title', 'Dashboard Validator - KATSINOV V2')

@section('contentvalidator')
    <div class="container-fluid py-4">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class='bx bx-clipboard'></i> Form Penilaian Saya</h4>
        </div>
        <!-- Statistics Cards -->
        <div class="row mt-4">

            <div class="col-md-3">

                <div class="card border-left-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Form</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $forms->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class='bx bx-file bx-lg text-primary'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-warning">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dalam Progress</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $forms->filter(function ($form) {
                                            $progress = App\Models\ValidatorProgress::where('form_id', $form->id)->where('validator_id', Auth::id())->first();
                                            return $progress && $progress->status === 'in_progress';
                                        })->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class='bx bx-time bx-lg text-warning'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-success">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $forms->filter(function ($form) {
                                            $progress = App\Models\ValidatorProgress::where('form_id', $form->id)->where('validator_id', Auth::id())->first();
                                            return $progress && $progress->status === 'completed';
                                        })->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class='bx bx-check-circle bx-lg text-success'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-secondary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Belum Dimulai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $forms->filter(function ($form) {
                                            $progress = App\Models\ValidatorProgress::where('form_id', $form->id)->where('validator_id', Auth::id())->first();
                                            return $progress && $progress->status === 'assigned';
                                        })->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class='bx bx-list-ul bx-lg text-secondary'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        @if ($forms->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="30%">Judul Form</th>
                                            <th width="15%">Dosen</th>
                                            <th width="12%">Tanggal Ditugaskan</th>
                                            <th width="15%">Status</th>
                                            <th width="13%">Progress</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($forms as $index => $form)
                                            @php
                                                $progress = App\Models\ValidatorProgress::where('form_id', $form->id)
                                                    ->where('validator_id', Auth::id())
                                                    ->first();

                                                $progressPercentage = 0;

                                                if ($progress) {
                                                    $completed = 0;
                                                    $total = 0;

                                                    // Form Dosen (always completed - read only)
                                                    $total++;
                                                    $completed++;

                                                    // Persetujuan
                                                    $total++;
                                                    if ($form->validator_agreement_signature) {
                                                        $completed++;
                                                    }

                                                    // Penilaian IRL (only categories filled by dosen)
                                                    $assessments = \App\Models\KatsinovResponse::where(
                                                        'katsinov_id',
                                                        $form->id,
                                                    )
                                                        ->get()
                                                        ->groupBy('indicator_number');
                                                    $categoryComments = \App\Models\KatsinovNote::where(
                                                        'katsinov_id',
                                                        $form->id,
                                                    )
                                                        ->get()
                                                        ->keyBy('indicator_number');

                                                    $filledIRLNumbers = $assessments->keys()->toArray();

                                                    if (!empty($filledIRLNumbers)) {
                                                        $categories = \App\Models\KatsinovCategory::with('indicators')
                                                            ->get()
                                                            ->filter(function ($category) use ($filledIRLNumbers) {
                                                                $categoryNumber = (int) str_replace(
                                                                    ['IRL', 'K'],
                                                                    '',
                                                                    $category->code,
                                                                );
                                                                return in_array($categoryNumber, $filledIRLNumbers);
                                                            })
                                                            ->values();
                                                    } else {
                                                        $categories = collect();
                                                    }

                                                    foreach ($categories as $category) {
                                                        $total++;

                                                        $irlNumber = (int) str_replace(
                                                            ['IRL', 'K'],
                                                            '',
                                                            $category->code,
                                                        );
                                                        $categoryResponses = $assessments->get($irlNumber, collect());
                                                        $totalIndicators = $category->indicators->count();
                                                        $assessedIndicators = $categoryResponses
                                                            ->filter(function ($response) {
                                                                return !empty($response->dropdown_value);
                                                            })
                                                            ->count();

                                                        $hasComment = !empty(
                                                            $categoryComments[$irlNumber]->notes ?? ''
                                                        );

                                                        if (
                                                            $assessedIndicators === $totalIndicators &&
                                                            $totalIndicators > 0 &&
                                                            $hasComment
                                                        ) {
                                                            $completed++;
                                                        }
                                                    }

                                                    // Berita Acara
                                                    $total++;
                                                    $beritaAcara = \App\Models\KatsinovBerita::where(
                                                        'katsinov_id',
                                                        $form->id,
                                                    )->first();
                                                    if ($beritaAcara && $beritaAcara->title) {
                                                        $completed++;
                                                    }

                                                    // Record Hasil
                                                    $total++;
                                                    $validatorRecord = \App\Models\FormRecordHasilPengukuran::where(
                                                        'katsinov_id',
                                                        $form->id,
                                                    )->first();
                                                    if ($validatorRecord && $validatorRecord->nama_penanggung_jawab) {
                                                        $completed++;
                                                    }

                                                    if ($total > 0) {
                                                        $progressPercentage = ($completed / $total) * 100;
                                                    }
                                                    
                                                    // Auto-update status to completed if progress is 100%
                                                    if ($progressPercentage >= 100 && $progress->status !== 'completed') {
                                                        $progress->status = 'completed';
                                                        $progress->save();
                                                        
                                                        // Also update katsinov status
                                                        $form->status = 'completed';
                                                        $form->save();
                                                    }
                                                }

                                                $statusBadge = 'secondary';
                                                $statusText = 'Assigned';
                                                if ($progress) {
                                                    switch ($progress->status) {
                                                        case 'assigned':
                                                            $statusBadge = 'secondary';
                                                            $statusText = 'Ditugaskan';
                                                            break;
                                                        case 'in_progress':
                                                            $statusBadge = 'warning';
                                                            $statusText = 'Dalam Progress';
                                                            break;
                                                        case 'in_review':
                                                            $statusBadge = 'info';
                                                            $statusText = 'Dalam Review';
                                                            break;
                                                        case 'completed':
                                                            $statusBadge = 'success';
                                                            $statusText = 'Selesai';
                                                            break;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $form->title ?? 'Form #' . $form->id }}</strong>
                                                    <br><small class="text-muted">{{ $form->project_name }}</small>
                                                    @if ($form->focus_area)
                                                        <br><small class="text-muted">Fokus: {{ $form->focus_area }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $form->user->name ?? '-' }}</td>
                                                <td class="text-center">
                                                    {{ $form->submitted_at ? $form->submitted_at->format('d M Y') : ($form->created_at ? $form->created_at->format('d M Y') : '-') }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $statusBadge }}">{{ $statusText }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $progressColor = 'bg-danger';
                                                        if ($progressPercentage >= 67) {
                                                            $progressColor = 'bg-success';
                                                        } elseif ($progressPercentage >= 34) {
                                                            $progressColor = 'bg-warning';
                                                        }
                                                    @endphp
                                                    <div class="progress" style="height: 25px; background-color: #e9ecef;">
                                                        <div class="progress-bar {{ $progressColor }}" role="progressbar"
                                                            style="width: {{ $progressPercentage > 0 ? $progressPercentage : 5 }}%; min-width: 40px;"
                                                            aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ round($progressPercentage) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('validator.assess', $form->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class='bx bx-edit'></i>
                                                            {{ $progress && $progress->status === 'completed' ? 'Lihat' : 'Nilai' }}
                                                        </a>
                                                        
                                                        @if($progress && $progress->status === 'completed')
                                                            {{-- Download Certificate --}}
                                                          
                                                            
                                                            {{-- Download Report Pengukuran --}}
                                                            <button onclick="downloadReport({{ $form->id }})" 
                                                                    class="btn btn-sm btn-info"
                                                                    title="Download Report Pengukuran">
                                                                <i class='bx bx-download'></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class='bx bx-info-circle'></i> Belum ada form yang ditugaskan kepada Anda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .border-left-primary {
            border-left: 4px solid #0d6efd;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107;
        }

        .border-left-success {
            border-left: 4px solid #198754;
        }

        .border-left-secondary {
            border-left: 4px solid #6c757d;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .font-weight-bold {
            font-weight: 700;
        }

        .text-gray-800 {
            color: #343a40;
        }
    </style>

    <script>
        function downloadCertificate(formId) {
            // Direct download with proper handling
            window.location.href = '/validator/' + formId + '/certificate';
        }

        function downloadReport(formId) {
            // Direct download with proper handling
            window.location.href = '/validator/' + formId + '/download-report';
        }
    </script>
@endsection
