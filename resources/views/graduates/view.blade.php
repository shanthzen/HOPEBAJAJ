@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Graduate Details</h5>
                </div>
                <div class="col-auto">
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('graduates.edit', $graduate->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @endif
                    <a href="{{ route('graduates.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">Batch No</th>
                                <td>{{ $graduate->batch_no }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Certificate No</th>
                                <td>{{ $graduate->certificate_no }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Full Name</th>
                                <td>{{ $graduate->name }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Phone Number</th>
                                <td>{{ $graduate->phone_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Course Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-graduation-cap me-2"></i>Course Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">Course Name</th>
                                <td>{{ $graduate->course_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Course Duration</th>
                                <td>{{ $graduate->course_duration }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Start Date</th>
                                <td>{{ $graduate->start_date ? $graduate->start_date->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">End Date</th>
                                <td>{{ $graduate->end_date ? $graduate->end_date->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Total Days Attended</th>
                                <td>{{ $graduate->total_days_attended ?? 0 }} days</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- ID Proof Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card me-2"></i>ID Proof Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">ID Type</th>
                                <td>{{ $graduate->id_proof_type }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">ID Number</th>
                                <td>{{ $graduate->id_proof_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Certificate Document -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>Certificate Document
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($graduate->certificate_path)
                            <div class="text-center">
                                @if(Str::endsWith(strtolower($graduate->certificate_path), ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ asset('storage/' . $graduate->certificate_path) }}" 
                                         alt="Certificate Document" 
                                         class="img-fluid mb-3 rounded">
                                @endif
                                <div class="d-grid">
                                    <a href="{{ asset('storage/' . $graduate->certificate_path) }}" 
                                       class="btn btn-primary" 
                                       target="_blank">
                                        <i class="fas fa-download me-2"></i>View Document
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No certificate uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Record Information -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Record Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180" class="text-secondary">Created At</th>
                                <td>{{ $graduate->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Last Updated</th>
                                <td>{{ $graduate->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('graduates.destroy', $graduate->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this graduate record? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete Graduate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
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
