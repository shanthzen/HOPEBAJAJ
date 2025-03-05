@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Graduate</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('graduates.update', $graduate->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <h5>Course Information</h5>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Batch No</label>
                                <input type="text" name="batch_no" value="{{ $graduate->batch_no }}"
                                       class="form-control @error('batch_no') is-invalid @enderror" required>
                                @error('batch_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Certificate No</label>
                                <input type="text" name="certificate_no" value="{{ $graduate->certificate_no }}"
                                       class="form-control @error('certificate_no') is-invalid @enderror" required>
                                @error('certificate_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Course Name</label>
                                <input type="text" name="course_name" value="{{ $graduate->course_name }}"
                                       class="form-control @error('course_name') is-invalid @enderror" required>
                                @error('course_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Course Duration</label>
                                <input type="text" name="course_duration" value="{{ $graduate->course_duration }}"
                                       class="form-control @error('course_duration') is-invalid @enderror" required>
                                @error('course_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" value="{{ optional($graduate->start_date)->format('Y-m-d') }}"
                                       class="form-control @error('start_date') is-invalid @enderror" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" value="{{ optional($graduate->end_date)->format('Y-m-d') }}"
                                       class="form-control @error('end_date') is-invalid @enderror" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <h5>Personal Information</h5>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" value="{{ $graduate->name }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" value="{{ $graduate->phone_number }}"
                                       class="form-control @error('phone_number') is-invalid @enderror" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Aadhar Number</label>
                                <input type="text" name="aadhar_number" value="{{ $graduate->aadhar_number }}"
                                       class="form-control @error('aadhar_number') is-invalid @enderror" required
                                       pattern="[0-9]{12}" title="Please enter a valid 12-digit Aadhar number">
                                @error('aadhar_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Total Days Attended</label>
                                <input type="number" name="total_days_attended" value="{{ $graduate->total_days_attended }}"
                                       class="form-control @error('total_days_attended') is-invalid @enderror" required min="1">
                                @error('total_days_attended')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <h5>Certificate Management</h5>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Current Certificate</label>
                                @if($graduate->certificate_path)
                                    <div>
                                        <a href="{{ asset('storage/' . $graduate->certificate_path) }}" target="_blank" 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-file me-1"></i> View Certificate
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">No certificate uploaded</p>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Upload New Certificate</label>
                                <input type="file" name="certificate" class="form-control @error('certificate') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Supported formats: PDF, JPG, JPEG, PNG (max 2MB)</small>
                                @error('certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Graduate</button>
                                <a href="{{ route('graduates.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
