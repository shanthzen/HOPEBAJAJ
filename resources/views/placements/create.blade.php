@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('placements.index') }}" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <h5 class="mb-0">
                        <i class="fas fa-briefcase me-2 text-primary"></i>
                        <span class="fw-semibold">Add New Placement</span>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('placements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Student Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-user me-2"></i>Student Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Batch Number</label>
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
                        </div>
                    </div>
                </div>

                <!-- Placement Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-briefcase me-2"></i>Placement Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Company Name</label>
                                <input type="text" 
                                       name="company_name" 
                                       value="{{ old('company_name') }}" 
                                       class="form-control @error('company_name') is-invalid @enderror" 
                                       required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Designation</label>
                                <input type="text" 
                                       name="designation" 
                                       value="{{ old('designation') }}" 
                                       class="form-control @error('designation') is-invalid @enderror" 
                                       required>
                                @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Salary (LPA)</label>
                                <input type="number" 
                                       step="0.01" 
                                       name="salary" 
                                       value="{{ old('salary') }}" 
                                       class="form-control @error('salary') is-invalid @enderror" 
                                       min="0"
                                       required>
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small">Joining Date</label>
                                <input type="date" 
                                       name="joining_date" 
                                       value="{{ old('joining_date') }}" 
                                       class="form-control @error('joining_date') is-invalid @enderror" 
                                       required>
                                @error('joining_date')
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
                            <i class="fas fa-file-alt me-2"></i>Supporting Documents
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label text-muted small">Upload Documents</label>
                                <input type="file" 
                                       name="supporting_documents" 
                                       class="form-control @error('supporting_documents') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG (max 2MB)</small>
                                @error('supporting_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Placement
                    </button>
                    <a href="{{ route('placements.index') }}" class="btn btn-light ms-2">
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

@push('scripts')
<script>
    // Format phone number input
    document.getElementById('phone_number').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);
    });

    // Format salary input
    document.getElementById('salary').addEventListener('input', function(e) {
        if (this.value < 0) this.value = 0;
    });
</script>
@endpush
