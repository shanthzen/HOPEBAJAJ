@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        <span class="fw-semibold">Activity Logs</span>
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('activity-logs.export') }}" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export Logs
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filters -->
            <form action="{{ route('activity-logs.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Action Type</label>
                        <select name="action" class="form-select">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Model Type</label>
                        <select name="model_type" class="form-select">
                            <option value="">All Types</option>
                            @foreach($modelTypes as $type)
                                <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                    {{ class_basename($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('activity-logs.index') }}" class="btn btn-light">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Logs Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $index }}</td>
                                <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $log->user ? $log->user->name : 'Unknown' }}</td>
                                <td>
                                    <span class="badge bg-{{ $log->action === 'delete' ? 'danger' : ($log->action === 'create' ? 'success' : 'info') }}-subtle text-{{ $log->action === 'delete' ? 'danger' : ($log->action === 'create' ? 'success' : 'info') }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>
                                    <a href="{{ route('activity-logs.show', $log) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No activity logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .bg-success-subtle {
        background-color: #dcfce7 !important;
    }
    
    .text-success {
        color: #059669 !important;
    }
    
    .bg-danger-subtle {
        background-color: #fee2e2 !important;
    }
    
    .text-danger {
        color: #dc2626 !important;
    }
    
    .bg-info-subtle {
        background-color: #e0f2fe !important;
    }
    
    .text-info {
        color: #0891b2 !important;
    }
</style>
@endpush
