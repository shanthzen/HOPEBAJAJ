@extends('layouts.app')

@section('content')
<style>
    .donor-header {
        background: linear-gradient(45deg, #1a237e, #0d47a1);
        padding: 3rem 0;
        margin-bottom: 2rem;
        color: white;
    }

    .donor-logo-large {
        max-height: 200px;
        max-width: 100%;
        object-fit: contain;
    }

    .donor-placeholder-large {
        font-size: 6rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .section-title {
        color: #1a237e;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e3f2fd;
    }

    .impact-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        height: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .impact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    }

    .contact-link {
        color: #1e88e5;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-link:hover {
        color: #1565c0;
        text-decoration: underline;
    }

    .website-button {
        background: linear-gradient(45deg, #1e88e5, #1565c0);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .website-button:hover {
        background: linear-gradient(45deg, #1565c0, #0d47a1);
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="donor-header">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                @if($donor->logo)
                    <img src="{{ Storage::url('donors/' . $donor->logo) }}" 
                         alt="{{ $donor->name }}" 
                         class="donor-logo-large mb-3 mb-md-0">
                @else
                    <i class="fas fa-building donor-placeholder-large mb-3 mb-md-0"></i>
                @endif
            </div>
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-start">
                    <h1 class="display-4 mb-3">{{ $donor->name }}</h1>
                    @if(Auth::user()->isAdmin())
                        <div>
                            <a href="{{ route('donors.edit', $donor) }}" 
                               class="btn btn-light me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('donors.destroy', $donor) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this donor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                <p class="lead mb-0">{{ $donor->description }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="impact-card">
                <h3 class="section-title">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    Impact
                </h3>
                <p class="mb-0">{{ $donor->impact }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="impact-card">
                <h3 class="section-title">
                    <i class="fas fa-gift me-2 text-primary"></i>
                    Contributions
                </h3>
                <p class="mb-0">{{ $donor->contributions }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="section-title">
                        <i class="fas fa-address-card me-2 text-primary"></i>
                        Contact Information
                    </h3>
                    
                    <div class="row g-4">
                        @if($donor->contact_email)
                            <div class="col-md-6">
                                <h5 class="mb-3">Email</h5>
                                <a href="mailto:{{ $donor->contact_email }}" class="contact-link">
                                    <i class="fas fa-envelope me-2"></i>
                                    {{ $donor->contact_email }}
                                </a>
                            </div>
                        @endif

                        @if($donor->contact_phone)
                            <div class="col-md-6">
                                <h5 class="mb-3">Phone</h5>
                                <a href="tel:{{ $donor->contact_phone }}" class="contact-link">
                                    <i class="fas fa-phone me-2"></i>
                                    {{ $donor->contact_phone }}
                                </a>
                            </div>
                        @endif

                        @if($donor->website)
                            <div class="col-12 text-center mt-4">
                                <a href="{{ $donor->website }}" 
                                   class="website-button"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    Visit Official Website
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('donors.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Donors List
        </a>
    </div>
</div>
@endsection
