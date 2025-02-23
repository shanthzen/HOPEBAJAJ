@extends('layouts.app')

@section('title', 'Upload Document')

@section('content')
<div class="container-fluid dashboard-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h5 class="mb-0">Upload New Document</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->batch_no }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Document Type</label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="Certificate" {{ old('type') == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                                <option value="ID Card" {{ old('type') == 'ID Card' ? 'selected' : '' }}>ID Card</option>
                                <option value="Course Completion" {{ old('type') == 'Course Completion' ? 'selected' : '' }}>Course Completion</option>
                                <option value="Achievement" {{ old('type') == 'Achievement' ? 'selected' : '' }}>Achievement</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">Document File</label>
                            <input type="file" name="document" id="document" 
                                class="form-control @error('document') is-invalid @enderror" 
                                accept=".pdf,.doc,.docx" required>
                            <div class="form-text">Allowed formats: PDF, DOC, DOCX. Maximum size: 2MB</div>
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="issued_at" class="form-label">Issue Date</label>
                            <input type="date" name="issued_at" id="issued_at" 
                                class="form-control @error('issued_at') is-invalid @enderror" 
                                value="{{ old('issued_at', date('Y-m-d')) }}" required>
                            @error('issued_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('documents.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i> Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
