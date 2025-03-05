@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Student Details</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('students.edit', ['student' => $student]) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Student Documents Section -->
            <div class="mb-4">
                <h6 class="text-primary mb-3 border-bottom pb-2">
                    <i class="fas fa-file-alt me-2"></i>Student Documents
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-center mb-3">Photo</h6>
                                <div class="text-center mb-4">
                                    @if($student->student_photo)
                                        <img src="{{ url('storage/' . $student->student_photo) }}" 
                                             alt="Student Photo" 
                                             class="img-thumbnail" 
                                             style="max-height: 200px; width: auto;">
                                    @else
                                        <div class="placeholder-image">
                                            <i class="fas fa-user-circle fa-5x text-secondary"></i>
                                            <p class="text-muted mt-2">No photo uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-center mb-3">Signature</h6>
                                <div class="text-center">
                                    @if($student->student_signature)
                                        <img src="{{ url('storage/' . $student->student_signature) }}" 
                                             alt="Student Signature" 
                                             class="img-thumbnail" 
                                             style="max-height: 100px; width: auto;">
                                    @else
                                        <div class="placeholder-image">
                                            <i class="fas fa-signature fa-3x text-secondary"></i>
                                            <p class="text-muted mt-2">No signature uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Full Name</label>
                            <div>{{ $student->full_name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Student User ID</label>
                            <div>{{ $student->student_user_id }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">User Credential</label>
                            <div>{{ $student->user_credential }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <div>{{ $student->email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Contact Number</label>
                            <div>{{ $student->contact_number }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">WhatsApp</label>
                            <div>{{ $student->whatsapp_number }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Date of Birth</label>
                            <div>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">ID Proof</label>
                            <div>{{ $student->id_proof_type }} - {{ $student->id_proof_number }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Gender</label>
                            <div>{{ $student->gender }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Batch Information -->
            <div class="mb-4">
                <h6 class="text-primary mb-3 border-bottom pb-2">
                    <i class="fas fa-clock me-2"></i>Batch Information
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">Batch No</th>
                                <td>{{ $student->batch_no }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Batch Timings</th>
                                <td>{{ $student->batch_timings }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Faculty</th>
                                <td>{{ $student->faculty_name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Educational Information -->
            <div class="mb-4">
                <h6 class="text-primary mb-3 border-bottom pb-2">
                    <i class="fas fa-graduation-cap me-2"></i>Educational Information
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">Course Enrolled</th>
                                <td>{{ $student->course_enrolled }}</td>
                            </tr>
                            <tr>
                                <th width="180" class="text-secondary">Qualification</th>
                                <td>{{ $student->qualification }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">College</th>
                                <td>{{ $student->college_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">College Address</th>
                                <td>{{ $student->college_address ?: 'Not provided' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="mb-4">
                <h6 class="text-primary mb-3 border-bottom pb-2">
                    <i class="fas fa-info-circle me-2"></i>Status Information
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">Currently Pursuing</th>
                                <td>{{ $student->is_pursuing ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Looking for Job</th>
                                <td>{{ $student->looking_for_job ? 'Yes' : 'No' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
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

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: #6c757d;
        padding: 1rem 0;
        border: none;
    }

    .table td {
        padding: 1rem 0;
        border: none;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 0.375rem;
    }

    .bg-success {
        background-color: #198754 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
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

    .text-primary {
        color: #0d6efd !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }

    .placeholder-image {
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        text-align: center;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        max-width: 100%;
        height: auto;
    }

    .fas {
        margin-right: 0.5rem;
    }

    h6.text-primary {
        font-weight: 600;
        font-size: 1rem;
    }
</style>
@endpush
