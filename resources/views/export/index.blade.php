@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Export Data</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row g-4">
                        <!-- Students Export -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-users text-primary"></i>
                                        Students Data
                                    </h5>
                                    <p class="card-text">Export enrolled students data including personal details, photos, and documents.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('export', ['type' => 'students']) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-file-csv me-2"></i>
                                            Export Students
                                        </a>
                                        <small class="text-muted">{{ App\Models\EnrolledStudent::count() }} records</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Graduates Export -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-graduation-cap text-success"></i>
                                        Graduates Data
                                    </h5>
                                    <p class="card-text">Export graduated students data including course details and certificates.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('export', ['type' => 'graduates']) }}" class="btn btn-outline-success">
                                            <i class="fas fa-file-csv me-2"></i>
                                            Export Graduates
                                        </a>
                                        <small class="text-muted">{{ App\Models\GraduatedStudent::count() }} records</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Placements Export -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-briefcase text-info"></i>
                                        Placements Data
                                    </h5>
                                    <p class="card-text">Export placement data including company details and offer letters.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('export', ['type' => 'placements']) }}" class="btn btn-outline-info">
                                            <i class="fas fa-file-csv me-2"></i>
                                            Export Placements
                                        </a>
                                        <small class="text-muted">{{ App\Models\PlacedStudent::count() }} records</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Complete Backup -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-database text-warning"></i>
                                        Complete Backup
                                    </h5>
                                    <p class="card-text">Export all data including students, graduates, placements, and all associated files.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('export.all') }}" class="btn btn-warning">
                                            <i class="fas fa-file-archive me-2"></i>
                                            Export All Data
                                        </a>
                                        <small class="text-muted">
                                            {{ App\Models\EnrolledStudent::count() + App\Models\GraduatedStudent::count() + App\Models\PlacedStudent::count() }} total records
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .card-text {
        color: #666;
        margin-bottom: 1.5rem;
        min-height: 3rem;
    }

    .table {
        font-size: 0.9rem;
    }

    .badge {
        font-weight: 500;
    }

    .btn .fas {
        width: 1.2rem;
        text-align: center;
    }
</style>
@endpush
