@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate me-2 text-primary"></i>
                    <span class="fw-semibold">{{ isset($student) ? 'Edit Student' : 'Create New Student' }}</span>
                </h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($student))
                    @method('PUT')
                @endif

                <!-- Batch Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Batch Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Batch No</label>
                                <input type="text" name="batch_no" class="form-control @error('batch_no') is-invalid @enderror" 
                                       value="{{ old('batch_no', $student->batch_no ?? '') }}" required>
                                @error('batch_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Batch Timings</label>
                                <input type="time" name="batch_timings" class="form-control @error('batch_timings') is-invalid @enderror" 
                                       value="{{ old('batch_timings', $student->batch_timings ?? '') }}" required>
                                @error('batch_timings')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Faculty Name</label>
                                <input type="text" name="faculty_name" class="form-control @error('faculty_name') is-invalid @enderror" 
                                       value="{{ old('faculty_name', $student->faculty_name ?? '') }}" required>
                                @error('faculty_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Login Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Login Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">User ID (Email)</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $student->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" {{ isset($student) ? '' : 'required' }}>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Personal Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name (As per Certificate)</label>
                                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                                       value="{{ old('full_name', $student->full_name ?? '') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email ID</label>
                                <input type="email" name="personal_email" class="form-control @error('personal_email') is-invalid @enderror" 
                                       value="{{ old('personal_email', $student->personal_email ?? '') }}" required>
                                @error('personal_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">ID Proof Type</label>
                                <select name="id_proof_type" class="form-select @error('id_proof_type') is-invalid @enderror" required>
                                    <option value="">Select ID Proof Type</option>
                                    @foreach(['Aadhar', 'Voter ID', 'Driving License', 'PAN'] as $type)
                                        <option value="{{ $type }}" {{ old('id_proof_type', $student->id_proof_type ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_proof_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">ID Proof Number</label>
                                <input type="text" name="id_proof_number" class="form-control @error('id_proof_number') is-invalid @enderror" 
                                       value="{{ old('id_proof_number', $student->id_proof_number ?? '') }}" required>
                                @error('id_proof_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}" 
                                       max="{{ date('Y-m-d') }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Contact Number</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $student->phone ?? '') }}" 
                                       pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="tel" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" 
                                       value="{{ old('whatsapp_number', $student->whatsapp_number ?? '') }}"
                                       pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" required>
                                @error('whatsapp_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Select Gender</option>
                                    @foreach(['Male', 'Female'] as $gender)
                                        <option value="{{ $gender }}" {{ old('gender', $student->gender ?? '') == $gender ? 'selected' : '' }}>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Educational Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Educational Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Qualification</label>
                                <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" 
                                       value="{{ old('qualification', $student->qualification ?? '') }}" required>
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">College Name</label>
                                <input type="text" name="college_name" class="form-control @error('college_name') is-invalid @enderror" 
                                       value="{{ old('college_name', $student->college_name ?? '') }}" required>
                                @error('college_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">College Address</label>
                                <textarea name="college_address" class="form-control @error('college_address') is-invalid @enderror" 
                                          rows="3">{{ old('college_address', $student->college_address ?? '') }}</textarea>
                                @error('college_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Status Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label d-block">Currently Pursuing</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="pursuing" class="form-check-input" role="switch" 
                                           value="1" {{ old('pursuing', $student->pursuing ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label d-block">Looking for Job</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="looking_for_job" class="form-check-input" role="switch" 
                                           value="1" {{ old('looking_for_job', $student->looking_for_job ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Documents</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Student Photo</label>
                                <input type="file" name="student_photo" class="form-control @error('student_photo') is-invalid @enderror" 
                                       accept="image/*" {{ isset($student) ? '' : 'required' }}>
                                <div class="form-text">Supported formats: JPG, PNG. Max size: 2MB</div>
                                @error('student_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(isset($student) && $student->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Current Photo" class="img-thumbnail" style="height: 100px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Student Signature</label>
                                <input type="file" name="student_signature" class="form-control @error('student_signature') is-invalid @enderror" 
                                       accept="image/*" {{ isset($student) ? '' : 'required' }}>
                                <div class="form-text">Supported formats: JPG, PNG. Max size: 1MB</div>
                                @error('student_signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(isset($student) && $student->student_signature)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $student->student_signature) }}" alt="Current Signature" class="img-thumbnail" style="height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($student) ? 'Update' : 'Create' }} Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const password = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (password.type === 'password') {
        password.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Format date input to dd-mm-yyyy
document.addEventListener('DOMContentLoaded', function() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const date = new Date(this.value);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            this.value = `${year}-${month}-${day}`;
        });
    });
});
</script>
@endpush
