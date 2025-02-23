@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.jpeg') }}" alt="HOPE Foundation Logo" class="img-fluid mb-4" style="max-width: 200px;">
                <p class="text-muted">Sign in to continue to the dashboard</p>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-gray-700">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-gray-700">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Sign In
                        </button>

                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                                <i class="fas fa-key me-1"></i>Forgot Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary: #3182ce;
        --primary-dark: #2c5282;
        --gray-800: #2d3748;
        --gray-700: #4a5568;
        --gray-600: #718096;
        --gray-200: #e2e8f0;
        --gray-100: #f8fafc;
    }

    .card {
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.5rem;
    }

    .text-gray-800 {
        color: var(--gray-800);
    }

    .text-gray-700 {
        color: var(--gray-700);
    }

    .text-gray-600 {
        color: var(--gray-600);
    }

    .form-control {
        border: 1px solid var(--gray-200);
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .alert-danger {
        background-color: #fff5f5;
        border-color: #feb2b2;
        color: #c53030;
    }

    .invalid-feedback {
        color: #e53e3e;
        font-size: 0.75rem;
    }

    .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
</style>
@endpush
@endsection
