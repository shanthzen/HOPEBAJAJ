@extends('layouts.app')

@section('title', 'Student Portal')

@section('content')
<div class="container-fluid dashboard-container">
    <div class="row g-4">
        <!-- Student Profile Card -->
        <div class="col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-4">
                        <div class="avatar-circle mx-auto">
                            <span class="initials">{{ substr($student->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">{{ $student->name }}</h5>
                    <p class="text-muted mb-3">{{ $student->email }}</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h6 class="text-muted mb-1">Batch</h6>
                                <p class="mb-0 fw-bold">{{ $student->batch->name }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h6 class="text-muted mb-1">Roll No</h6>
                                <p class="mb-0 fw-bold">{{ $student->roll_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">My Documents</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Issue Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            {{ $document->type }}
                                        </div>
                                    </td>
                                    <td>{{ $document->issued_at->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">Available</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('student.document.download', $document->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        No documents available yet
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Progress -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Course Progress</h5>
                </div>
                <div class="card-body p-4">
                    <div class="progress mb-3" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                            style="width: {{ $student->progress }}%"
                            aria-valuenow="{{ $student->progress }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            {{ $student->progress }}% Complete
                        </div>
                    </div>
                    <div class="row g-4 mt-2">
                        @foreach($modules as $module)
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">{{ $module->name }}</span>
                                <span class="text-muted">{{ $module->completion_percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" role="progressbar" 
                                    style="width: {{ $module->completion_percentage }}%"
                                    aria-valuenow="{{ $module->completion_percentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-circle {
        width: 100px;
        height: 100px;
        background-color: #1a73e8;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .initials {
        font-size: 40px;
        color: white;
        font-weight: 500;
        text-transform: uppercase;
    }
    .progress {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
    }
</style>
@endpush
