@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        <span class="fw-semibold">Activity Log Details</span>
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('activity-logs.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-info me-2"></i>Basic Information
                        </h6>
                        <table class="table table-borderless">
                            <tr>
                                <th width="150" class="text-secondary">Date & Time</th>
                                <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">User</th>
                                <td>{{ $log->user ? $log->user->name : 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Action</th>
                                <td>
                                    <span class="badge bg-{{ $log->action === 'delete' ? 'danger' : ($log->action === 'create' ? 'success' : 'info') }}-subtle text-{{ $log->action === 'delete' ? 'danger' : ($log->action === 'create' ? 'success' : 'info') }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Model Type</th>
                                <td>{{ class_basename($log->model_type) }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Model ID</th>
                                <td>{{ $log->model_id }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">IP Address</th>
                                <td>{{ $log->ip_address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Change Details -->
                    @if($log->details)
                    <div class="mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-exchange-alt me-2"></i>Change Details
                        </h6>
                        @if($log->action === 'update' && isset($log->details['changed']))
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($log->details['changed'] as $field => $newValue)
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $field)) }}</td>
                                                <td>{{ $log->details['original'][$field] ?? 'N/A' }}</td>
                                                <td>{{ $newValue }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($log->action === 'create' && isset($log->details['attributes']))
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($log->details['attributes'] as $field => $value)
                                            @if(!in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at']))
                                                <tr>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $field)) }}</td>
                                                    <td>{{ $value }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No detailed changes to display for this action.
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
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

    .table-sm th,
    .table-sm td {
        padding: 0.5rem;
    }
</style>
@endpush
