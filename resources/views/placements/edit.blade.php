@extends('layouts.app')

@section('title', 'Edit Placement')

@section('content')
<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Placement</h4>
                <a href="{{ route('placements.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('placements.update', ['placedStudent' => $placement]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Student Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Student Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="batch_no" class="form-label">Batch Number</label>
                                    <input type="text" class="form-control @error('batch_no') is-invalid @enderror" 
                                           id="batch_no" name="batch_no" value="{{ old('batch_no', $placement->batch_no) }}" required>
                                    @error('batch_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $placement->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                           id="phone_number" name="phone_number" 
                                           value="{{ old('phone_number', $placement->phone_number) }}" 
                                           required maxlength="10" pattern="[0-9]{10}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Placement Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-briefcase me-2"></i>Placement Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" name="company_name" 
                                           value="{{ old('company_name', $placement->company_name) }}" required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                                           id="designation" name="designation" 
                                           value="{{ old('designation', $placement->designation) }}" required>
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="salary" class="form-label">Salary (LPA)</label>
                                    <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" 
                                           id="salary" name="salary" value="{{ old('salary', $placement->salary) }}" 
                                           required min="0">
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="joining_date" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror" 
                                           id="joining_date" name="joining_date" 
                                           value="{{ old('joining_date', $placement->joining_date->format('Y-m-d')) }}" required>
                                    @error('joining_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supporting Documents -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>Supporting Documents
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $docPath = $placement->getRawOriginal('supporting_documents');
                        @endphp
                        @if($docPath && Storage::disk('public')->exists($docPath))
                            <div class="mb-3">
                                <label class="text-muted d-block mb-2">Current Document</label>
                                @if(Str::endsWith(strtolower($docPath), ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ Storage::url($docPath) }}" 
                                         alt="Supporting Document" 
                                         class="img-fluid mb-3 rounded" 
                                         style="max-height: 200px;">
                                @endif
                                <div class="d-grid">
                                    <a href="{{ Storage::url($docPath) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-2"></i>View Current Document
                                    </a>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="supporting_documents" class="form-label">Upload New Document</label>
                            <input type="file" class="form-control @error('supporting_documents') is-invalid @enderror" 
                                   id="supporting_documents" name="supporting_documents">
                            <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG (max 2MB)</small>
                            @error('supporting_documents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('placements.show', ['placedStudent' => $placement]) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Placement</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
@endsection
