@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <h5 class="mb-0">Edit Student Details</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Batch Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">Batch Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Batch No</label>
                                <input type="text" class="form-control @error('batch_no') is-invalid @enderror" name="batch_no" value="{{ old('batch_no', $student->batch_no) }}" required>
                                @error('batch_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Batch Timings</label>
                                <input type="time" class="form-control @error('batch_timings') is-invalid @enderror" name="batch_timings" value="{{ old('batch_timings', $student->batch_timings) }}" required>
                                @error('batch_timings')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Faculty Name</label>
                                <input type="text" class="form-control @error('faculty_name') is-invalid @enderror" name="faculty_name" value="{{ old('faculty_name', $student->faculty_name) }}" required>
                                @error('faculty_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Login Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">Login Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Student User ID</label>
                                <input type="text" class="form-control @error('student_user_id') is-invalid @enderror" name="student_user_id" value="{{ old('student_user_id', $student->student_user_id) }}" required>
                                @error('student_user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">User Credential</label>
                                <input type="text" class="form-control @error('user_credential') is-invalid @enderror" name="user_credential" value="{{ old('user_credential', $student->user_credential) }}">
                                @error('user_credential')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">Personal Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Full Name (As per Certificate)</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name', $student->full_name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $student->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Unique ID Proof Type</label>
                                <select class="form-select @error('id_proof_type') is-invalid @enderror" name="id_proof_type" required>
                                    <option value="">Select ID Proof Type</option>
                                    <option value="Aadhar" {{ old('id_proof_type', $student->id_proof_type) == 'Aadhar' ? 'selected' : '' }}>Aadhar</option>
                                    <option value="Voter ID" {{ old('id_proof_type', $student->id_proof_type) == 'Voter ID' ? 'selected' : '' }}>Voter ID</option>
                                    <option value="Driving License" {{ old('id_proof_type', $student->id_proof_type) == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                    <option value="PAN" {{ old('id_proof_type', $student->id_proof_type) == 'PAN' ? 'selected' : '' }}>PAN</option>
                                </select>
                                @error('id_proof_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Unique ID Number</label>
                                <input type="text" class="form-control @error('id_proof_number') is-invalid @enderror" name="id_proof_number" value="{{ old('id_proof_number', $student->id_proof_number) }}" required>
                                @error('id_proof_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Contact Number</label>
                                <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}" pattern="[0-9]{10}" required>
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">WhatsApp Number</label>
                                <input type="tel" class="form-control @error('whatsapp_number') is-invalid @enderror" name="whatsapp_number" value="{{ old('whatsapp_number', $student->whatsapp_number) }}" pattern="[0-9]{10}" required>
                                @error('whatsapp_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Educational Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">Educational Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Qualification</label>
                                <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification', $student->qualification) }}" required>
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Course Enrolled</label>
                                <input type="text" class="form-control @error('course_enrolled') is-invalid @enderror" name="course_enrolled" value="{{ old('course_enrolled', $student->course_enrolled) }}" required>
                                @error('course_enrolled')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">College Name</label>
                                <input type="text" class="form-control @error('college_name') is-invalid @enderror" name="college_name" value="{{ old('college_name', $student->college_name) }}" required>
                                @error('college_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">College Address</label>
                                <textarea class="form-control @error('college_address') is-invalid @enderror" name="college_address" rows="3" required>{{ old('college_address', $student->college_address) }}</textarea>
                                @error('college_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">Status Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Pursuing</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_pursuing" value="1" {{ old('is_pursuing', $student->is_pursuing) ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Looking for Job</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="looking_for_job" value="1" {{ old('looking_for_job', $student->looking_for_job) ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="card inner-card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0">Documents</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Student Photo</label>
                                <input type="file" class="form-control @error('student_photo') is-invalid @enderror" name="student_photo" accept="image/*">
                                @if($student->student_photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $student->student_photo) }}" alt="Current Photo" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                @error('student_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Student Signature</label>
                                <input type="file" class="form-control @error('student_signature') is-invalid @enderror" name="student_signature" accept="image/*">
                                @if($student->student_signature)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $student->student_signature) }}" alt="Current Signature" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                @error('student_signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

    .form-control {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .form-control.is-invalid {
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

    .form-switch {
        padding-left: 2.5em;
    }

    .form-switch .form-check-input {
        width: 2em;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .small {
        font-size: 0.875rem;
    }
</style>
@endpush
