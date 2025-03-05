@extends('layouts.app')

@section('content')
<style>
    .donor-section {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }

    .section-header {
        background: var(--primary-color);
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    .donor-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }

    .donor-header {
        background: var(--accent-color);
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid #e5e7eb;
    }

    .logo-container {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        background: white;
        border-radius: 50%;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .donor-logo {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .donor-placeholder {
        font-size: 4rem;
        color: var(--primary-color);
        opacity: 0.5;
    }

    .donor-details {
        padding: 2rem;
    }

    .donor-name {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .donor-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .contact-info {
        background: var(--accent-color);
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-item i {
        width: 24px;
        color: var(--primary-color);
        margin-right: 1rem;
    }

    .donor-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-website {
        background: var(--primary-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-website:hover {
        background: var(--hover-color);
        color: white;
        transform: translateY(-2px);
    }

    .admin-controls {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .btn-control {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .btn-control:hover {
        transform: scale(1.1);
    }

    .btn-edit {
        background: var(--primary-color);
    }

    .btn-delete {
        background: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--accent-color);
        border-radius: 10px;
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--primary-color);
        opacity: 0.5;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-description {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    .alert-success {
        background: var(--primary-color);
        color: white;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success .btn-close {
        filter: brightness(0) invert(1);
    }
</style>

<div class="donor-section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h2 class="section-title">
            <i class="fas fa-hands-helping me-2"></i>Our Donor
        </h2>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('donors.create') }}" class="btn btn-light">
                <i class="fas fa-plus-circle me-2"></i>Add Donor
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($donors->count() > 0)
        @foreach($donors as $donor)
            <div class="donor-card">
                @if(Auth::user()->isAdmin())
                    <div class="admin-controls">
                        <a href="{{ route('donors.edit', $donor) }}" class="btn-control btn-edit" title="Edit Donor">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('donors.destroy', $donor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-control btn-delete" title="Delete Donor" 
                                    onclick="return confirm('Are you sure you want to delete this donor?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endif

                <div class="donor-header">
                    <div class="logo-container">
                        @if($donor->logo)
                            <img src="{{ Storage::url('donors/' . $donor->logo) }}" alt="{{ $donor->name }}" class="donor-logo">
                        @else
                            <i class="fas fa-building donor-placeholder"></i>
                        @endif
                    </div>
                </div>

                <div class="donor-details">
                    <h3 class="donor-name">{{ $donor->name }}</h3>
                    <p class="donor-description">{{ $donor->description }}</p>

                    <div class="contact-info">
                        @if($donor->contact_email)
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $donor->contact_email }}</span>
                            </div>
                        @endif
                        @if($donor->contact_phone)
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ $donor->contact_phone }}</span>
                            </div>
                        @endif
                    </div>

                    @if($donor->website)
                        <div class="donor-actions">
                            <a href="{{ $donor->website }}" class="btn-website" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Website
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-hands-helping empty-icon"></i>
            <h3 class="empty-title">No Donor Found</h3>
            <p class="empty-description">There is no donor registered at the moment.</p>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('donors.create') }}" class="btn-website">
                    <i class="fas fa-plus-circle"></i>
                    Add First Donor
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
