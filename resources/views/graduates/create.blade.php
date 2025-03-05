@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('graduates.index') }}" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <h5 class="mb-0">
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        <span class="fw-semibold">Add Graduate</span>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('graduates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Basic Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Batch No</label>
                                <input type="text" 
                                       name="batch_no" 
                                       value="{{ old('batch_no') }}" 
                                       class="form-control @error('batch_no') is-invalid @enderror" 
                                       required>
                                @error('batch_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Certificate No</label>
                                <input type="text" 
                                       name="certificate_no" 
                                       value="{{ old('certificate_no') }}" 
                                       class="form-control @error('certificate_no') is-invalid @enderror" 
                                       required>
                                @error('certificate_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-user me-2"></i>Personal Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Name</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Phone Number</label>
                                <input type="tel" 
                                       name="phone_number" 
                                       value="{{ old('phone_number') }}" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       pattern="[0-9]{10}"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">ID Proof Type</label>
                                <select name="id_proof_type" 
                                        class="form-select @error('id_proof_type') is-invalid @enderror" 
                                        required>
                                    <option value="">Select ID Proof Type</option>
                                    <option value="Aadhar" {{ old('id_proof_type') == 'Aadhar' ? 'selected' : '' }}>Aadhar</option>
                                    <option value="Voter ID" {{ old('id_proof_type') == 'Voter ID' ? 'selected' : '' }}>Voter ID</option>
                                    <option value="Driving License" {{ old('id_proof_type') == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                    <option value="PAN" {{ old('id_proof_type') == 'PAN' ? 'selected' : '' }}>PAN</option>
                                </select>
                                @error('id_proof_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">ID Proof Number</label>
                                <input type="text" 
                                       name="id_proof_number" 
                                       value="{{ old('id_proof_number') }}" 
                                       class="form-control @error('id_proof_number') is-invalid @enderror" 
                                       required>
                                @error('id_proof_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-book me-2"></i>Course Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Course Name</label>
                                <input type="text" 
                                       name="course_name" 
                                       value="{{ old('course_name') }}" 
                                       class="form-control @error('course_name') is-invalid @enderror" 
                                       required>
                                @error('course_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Course Duration</label>
                                <input type="text" 
                                       name="course_duration" 
                                       value="{{ old('course_duration') }}" 
                                       class="form-control @error('course_duration') is-invalid @enderror" 
                                       required>
                                @error('course_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Start Date</label>
                                <input type="date" 
                                       name="start_date" 
                                       value="{{ old('start_date') }}" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">End Date</label>
                                <input type="date" 
                                       name="end_date" 
                                       value="{{ old('end_date') }}" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Total Days Attended</label>
                                <input type="number" 
                                       name="total_days_attended" 
                                       value="{{ old('total_days_attended') }}" 
                                       class="form-control @error('total_days_attended') is-invalid @enderror" 
                                       min="0"
                                       required>
                                @error('total_days_attended')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>Documents
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Certificate</label>
                                <input type="file" 
                                       name="certificate" 
                                       class="form-control @error('certificate') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                @error('certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Graduate
                    </button>
                    <a href="{{ route('graduates.index') }}" class="btn btn-light ms-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .container-fluid {
        padding: 1.5rem;
    }

    .card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        transition: all 0.15s ease-in-out;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }

    .btn-light:hover {
        background-color: #e2e6ea;
        border-color: #dae0e5;
    }

    .inner-card {
        border: 1px solid rgba(0, 0, 0, 0.125);
        margin-bottom: 1.5rem;
    }

    .inner-card .card-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1.25rem;
    }

    .inner-card .card-body {
        padding: 1.25rem;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .small {
        font-size: 0.875rem;
    }

    .fw-semibold {
        font-weight: 600;
    }
</style>
@endpush
