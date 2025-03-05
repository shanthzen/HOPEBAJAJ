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

    .current-logo {
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
            <h4>Edit Donor</h4>
            <p>Update the donor's information using the form below. All fields marked with an asterisk (*) are required.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                    <form action="{{ route('donors.update', $donor) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">
                                Name<span class="required-star">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $donor->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">
                                Description<span class="required-star">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      required>{{ old('description', $donor->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="contributions" class="form-label">
                                    Contributions<span class="required-star">*</span>
                                </label>
                                <textarea class="form-control @error('contributions') is-invalid @enderror" 
                                          id="contributions" 
                                          name="contributions" 
                                          rows="4" 
                                          required>{{ old('contributions', $donor->contributions) }}</textarea>
                                <div class="form-text">Describe the donor's contributions to the organization</div>
                                @error('contributions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="impact" class="form-label">
                                    Impact<span class="required-star">*</span>
                                </label>
                                <textarea class="form-control @error('impact') is-invalid @enderror" 
                                          id="impact" 
                                          name="impact" 
                                          rows="4" 
                                          required>{{ old('impact', $donor->impact) }}</textarea>
                                <div class="form-text">Describe the impact of the donor's contributions</div>
                                @error('impact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="contact_email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('contact_email') is-invalid @enderror" 
                                       id="contact_email" 
                                       name="contact_email" 
                                       value="{{ old('contact_email', $donor->contact_email) }}">
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label">Phone</label>
                                <input type="text" 
                                       class="form-control @error('contact_phone') is-invalid @enderror" 
                                       id="contact_phone" 
                                       name="contact_phone" 
                                       value="{{ old('contact_phone', $donor->contact_phone) }}">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="website" class="form-label">Website URL</label>
                            <input type="url" 
                                   class="form-control @error('website') is-invalid @enderror" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', $donor->website) }}"
                                   placeholder="https://">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo" class="form-label">Logo</label>
                            @if($donor->logo)
                                <div class="mb-2">
                                    <img src="{{ Storage::url('donors/' . $donor->logo) }}" 
                                         alt="Current Logo" 
                                         class="current-logo">
                                </div>
                            @endif
                            <input type="file" 
                                   class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" 
                                   name="logo"
                                   accept="image/*"
                                   onchange="previewLogo(this)">
                            <div class="form-text">Recommended size: 400x400px. Max size: 2MB</div>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="logoPreview" class="logo-preview d-none">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('donors.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Donor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
