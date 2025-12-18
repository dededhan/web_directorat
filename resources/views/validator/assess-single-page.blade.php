@extends('layouts.app')

@section('title', 'Penilaian Validator - KATSINOV V2')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/validator-single-page.css') }}">
@endsection

@section('content')
    <div class="container-fluid validator-spa">
        <!-- Fixed Header -->
        <div class="validator-header fixed-top bg-white shadow-sm">
            <div class="container-fluid py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">{{ $form->informasiDasar->judul ?? 'Form Penilaian' }}</h4>
                        <small class="text-muted">Dosen: {{ $form->user->name ?? '-' }}</small>
                    </div>
                    <div class="col-md-6">
                        <!-- Progress Bar -->
                        <div class="progress mb-2" style="height: 25px;">
                            <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 0%"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <span id="progress-text">0% Selesai</span>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-info btn-sm" id="btn-form-pendukung-dosen"
                                {{ $isReadOnly ? '' : 'disabled' }}>
                                <i class='bx bx-file'></i> Form Pendukung Dosen
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btn-penilaian"
                                {{ $isReadOnly ? 'disabled' : '' }}>
                                <i class='bx bx-clipboard'></i> Penilaian
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-form-pendukung-validator"
                                {{ $isReadOnly ? 'disabled' : '' }}>
                                <i class='bx bx-note'></i> Form Pendukung Validator
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" id="btn-submit-final"
                                {{ $progress->canSubmit() && !$isReadOnly ? '' : 'disabled' }}>
                                <i class='bx bx-send'></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="content-wrapper" style="margin-top: 130px;">
            <div class="container-fluid">
                <!-- Form Information -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Dasar</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Judul:</strong> {{ $form->informasiDasar->judul ?? '-' }}</p>
                                <p><strong>Fokus Bidang:</strong> {{ $form->informasiDasar->fokus_bidang ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Kategori:</strong> {{ $form->informasiDasar->kategori ?? '-' }}</p>
                                <p><strong>Status:</strong> <span
                                        class="badge bg-{{ $progress->status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($progress->status) }}</span>
                                </p>
                            </div>
                        </div>
                        @if ($isReadOnly)
                            <div class="alert alert-info mb-0">
                                <i class='bx bx-info-circle'></i> <strong>Mode Read-Only:</strong> Penilaian sudah final dan
                                tidak dapat diubah. Anda masih dapat melihat semua data.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dynamic Content Area -->
                <div id="dynamic-content">
                    <!-- Content will be loaded here via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Modals -->
        @include('validator.modals.form-pendukung-dosen')
        @include('validator.modals.agreement')
        @include('validator.modals.submit-confirmation')

        <!-- Floating Save Indicator -->
        <div id="save-indicator" class="position-fixed bottom-0 end-0 m-3" style="display: none;">
            <div class="alert alert-success mb-0">
                <i class='bx bx-check-circle'></i> Tersimpan otomatis
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Pass data to JavaScript
        window.formId = {{ $form->id }};
        window.isReadOnly = {{ $isReadOnly ? 'true' : 'false' }};
        window.progress = @json($progress);
    </script>
    <script src="{{ asset('assets/js/validator-single-page.js') }}"></script>
@endsection
