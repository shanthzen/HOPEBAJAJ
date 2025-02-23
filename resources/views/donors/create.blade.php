@extends('layouts.app')

@section('content')
<style>
    .donor-form-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .form-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .form-header h4 {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .form-header p {
        color: #64748b;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        padding: 1.5rem;
        border: none;
    }

    .form-card .card-header h5 {
        color: white;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .form-card .card-header i {
        font-size: 1.25rem;
        margin-right: 0.75rem;
    }

    .form-card .card-body {
        padding: 2rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border-color: #e2e8f0;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-label {
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .logo-preview-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
    }

    .logo-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 0 auto 1rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .btn-light {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-light:hover {
        background: #f1f5f9;
        transform: translateY(-1px);
    }

    .form-text {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .required-star {
        color: #ef4444;
        margin-left: 2px;
    }
</style>

<div class="donor-form-container">
    <div class="container">
        <div class="form-header">
            <h4>Add New Donor</h4>
            <p>Create a new donor profile by filling out the information below. All fields marked with an asterisk (*) are required.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('donors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Basic Information -->
                    <div class="form-card">
                        <div class="card-header">
                            <h5>
                                <i class="fas fa-user-circle"></i>
                                Basic Information
                            </h5>
                        </div>
                        <div class="card-body">

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Donor Name <span class="required-star">*</span></label>
                                        <input type="text" 
                                               name="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description <span class="required-star">*</span></label>
                                        <textarea name="description" 
                                                  rows="4" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="logo-preview-container">
                                        <img id="logo-preview" 
                                             src="{{ asset('images/placeholder.png') }}" 
                                             alt="Logo Preview"
                                             class="logo-preview">
                                        <div class="mb-3">
                                            <label class="form-label">Upload Logo</label>
                                            <input type="file" 
                                                   name="logo" 
                                                   class="form-control @error('logo') is-invalid @enderror"
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                            <div class="form-text">Recommended size: 200x200px. Max size: 2MB</div>
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contributions & Impact -->
                    <div class="form-card">
                        <div class="card-header">
                            <h5>
                                <i class="fas fa-chart-line"></i>
                                Contributions & Impact
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contributions <span class="required-star">*</span></label>
                                        <textarea name="contributions" 
                                                  rows="4" 
                                                  class="form-control @error('contributions') is-invalid @enderror"
                                                  required>{{ old('contributions') }}</textarea>
                                        <div class="form-text">Describe the donor's contributions to the organization</div>
                                        @error('contributions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Impact <span class="required-star">*</span></label>
                                        <textarea name="impact" 
                                                  rows="4" 
                                                  class="form-control @error('impact') is-invalid @enderror"
                                                  required>{{ old('impact') }}</textarea>
                                        <div class="form-text">Describe the impact of the donor's contributions</div>
                                        @error('impact')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-card">
                        <div class="card-header">
                            <h5>
                                <i class="fas fa-address-card"></i>
                                Contact Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" 
                                               name="contact_email" 
                                               class="form-control @error('contact_email') is-invalid @enderror" 
                                               value="{{ old('contact_email') }}">
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" 
                                               name="contact_phone" 
                                               class="form-control @error('contact_phone') is-invalid @enderror" 
                                               value="{{ old('contact_phone') }}">
                                        @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" 
                                               name="website" 
                                               class="form-control @error('website') is-invalid @enderror" 
                                               value="{{ old('website') }}"
                                               placeholder="e.g., www.example.com">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('donors.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Donor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
