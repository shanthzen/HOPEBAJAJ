@extends('layouts.app')

@section('content')
<style>
    .activity-logs {
        max-width: 1200px;
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

    .log-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .log-header {
        background: var(--accent-color);
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .log-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .log-meta {
        display: flex;
        gap: 2rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .log-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .log-meta-item i {
        color: var(--primary-color);
        width: 16px;
    }

    .log-content {
        padding: 1rem;
    }

    .log-details {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 6px;
        margin-top: 1rem;
    }

    .log-details pre {
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .log-details-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .log-details-item {
        margin-bottom: 0.5rem;
        display: flex;
        gap: 0.5rem;
    }

    .log-details-label {
        font-weight: 500;
        color: var(--text-secondary);
        min-width: 120px;
    }

    .log-details-value {
        color: var(--text-primary);
    }

    .action-create {
        color: #059669;
    }

    .action-update {
        color: #0284c7;
    }

    .action-delete {
        color: #dc2626;
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
</style>

<div class="activity-logs">
    <div class="section-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">
                <i class="fas fa-history me-2"></i>Activity Logs
            </h2>
            <a href="{{ route('activity-logs.export') }}" class="btn btn-light">
                <i class="fas fa-download me-2"></i>Export Logs
            </a>
        </div>

        <form action="{{ route('activity-logs.index') }}" method="GET" class="bg-white p-3 rounded-3">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Action Type</label>
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Model Type</label>
                    <select name="model_type" class="form-select">
                        <option value="">All Models</option>
                        @foreach($modelTypes as $type)
                            <option value="{{ $type }}" {{ request('model_type') === $type ? 'selected' : '' }}>
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
                <div class="col-md-6">
                    <label class="form-label">Search Text</label>
                    <input type="text" name="search" class="form-control" placeholder="Search in details..." value="{{ request('search') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 text-end">
                    <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($logs->count() > 0)
        @foreach($logs as $log)
            <div class="log-card">
                <div class="log-header">
                    <div class="log-title">
                        <i class="fas fa-{{ $log->action === 'create' ? 'plus-circle' : ($log->action === 'update' ? 'edit' : 'trash') }} 
                           action-{{ $log->action }} me-2"></i>
                        {{ ucfirst($log->action) }} {{ class_basename($log->model_type) }}
                    </div>
                    <div class="log-meta">
                        <div class="log-meta-item">
                            <i class="fas fa-user"></i>
                            {{ $log->user->name }}
                        </div>
                        <div class="log-meta-item">
                            <i class="fas fa-calendar"></i>
                            {{ $log->created_at->format('d-m-Y H:i:s') }}
                        </div>
                        <div class="log-meta-item">
                            <i class="fas fa-network-wired"></i>
                            {{ $log->ip_address }}
                        </div>
                    </div>
                </div>

                <div class="log-content">
                    <div class="log-details">
                        <div class="log-details-item">
                            <span class="log-details-label">Model Type:</span>
                            <span class="log-details-value">{{ class_basename($log->model_type) }}</span>
                        </div>
                        <div class="log-details-item">
                            <span class="log-details-label">Model ID:</span>
                            <span class="log-details-value">{{ $log->model_id }}</span>
                        </div>
                        
                        @if($log->details)
                            @if($log->action === 'delete' && isset($log->details['deleted_model']))
                                <div class="log-details-title mt-3">Deleted Model Details:</div>
                                @foreach($log->details['deleted_model']['attributes'] as $key => $value)
                                    <div class="log-details-item">
                                        <span class="log-details-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="log-details-value">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                    </div>
                                @endforeach
                            @elseif($log->action === 'update' && isset($log->details['changed']))
                                <div class="log-details-title mt-3">Changed Fields:</div>
                                @foreach($log->details['changed'] as $key => $value)
                                    <div class="log-details-item">
                                        <span class="log-details-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="log-details-value">
                                            From: {{ $log->details['original'][$key] ?? 'null' }}
                                            <i class="fas fa-arrow-right mx-2"></i>
                                            To: {{ $value }}
                                        </span>
                                    </div>
                                @endforeach
                            @elseif($log->action === 'create' && isset($log->details['attributes']))
                                <div class="log-details-title mt-3">Created With:</div>
                                @foreach($log->details['attributes'] as $key => $value)
                                    <div class="log-details-item">
                                        <span class="log-details-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="log-details-value">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $logs->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-history empty-icon"></i>
            <h3 class="empty-title">No Activity Logs</h3>
            <p class="empty-description">There are no activity logs recorded yet.</p>
        </div>
    @endif
</div>
@endsection
