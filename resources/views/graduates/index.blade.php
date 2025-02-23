@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap me-2 text-primary"></i>
                    <span class="fw-semibold">Graduate Management</span>
                </h5>
                @if(in_array(auth()->user()->role, ['admin', 'trainer']))
                <a href="{{ route('graduates.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add New Graduate
                </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control border-start-0" 
                               placeholder="Search graduates..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <select id="batchFilter" class="form-select">
                        <option value="">All Batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>
                                {{ $batch }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <select id="courseFilter" class="form-select">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                                {{ $course }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Graduates Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 20%;">Graduate Details</th>
                            <th style="width: 15%;">Course Info</th>
                            <th style="width: 15%;">Duration</th>
                            <th style="width: 15%;">Attendance</th>
                            <th style="width: 15%;">Certificate</th>
                            <th class="text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top">
                        @forelse($graduates as $graduate)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light me-3 d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user-graduate text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $graduate->name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-id-card me-1"></i>
                                                {{ $graduate->certificate_no }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $graduate->course_name }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-layer-group me-1"></i>
                                        Batch {{ $graduate->batch_no }}
                                    </small>
                                </td>
                                <td>
                                    <div>{{ $graduate->course_duration }}</div>
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($graduate->start_date)->format('M d, Y') }} - 
                                        {{ \Carbon\Carbon::parse($graduate->end_date)->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">{{ $graduate->total_days_attended }} days</div>
                                        @php
                                            $startDate = \Carbon\Carbon::parse($graduate->start_date);
                                            $endDate = \Carbon\Carbon::parse($graduate->end_date);
                                            $totalDays = $startDate->diffInDays($endDate) + 1;
                                            $attendancePercentage = min(($graduate->total_days_attended / $totalDays) * 100, 100);
                                            $badgeClass = $attendancePercentage >= 90 ? 'success' : ($attendancePercentage >= 75 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}-subtle text-{{ $badgeClass }}">
                                            {{ number_format($attendancePercentage, 1) }}%
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if($graduate->certificate_path)
                                        <a href="{{ Storage::url($graduate->certificate_path) }}" 
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-alt me-1"></i>View Certificate
                                        </a>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">
                                            <i class="fas fa-exclamation-circle me-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('graduates.show', ['graduate' => $graduate]) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(in_array(auth()->user()->role, ['admin', 'trainer']))
                                            <a href="{{ route('graduates.edit', ['graduate' => $graduate]) }}" 
                                               class="btn btn-sm btn-outline-info"
                                               title="Edit Graduate">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('graduates.destroy', ['graduate' => $graduate]) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this graduate?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete Graduate">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-user-graduate fa-3x mb-3"></i>
                                        <p class="mb-1">No graduates found</p>
                                        <small>Try adjusting your search criteria</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($graduates->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $graduates->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-1px);
        transition: transform 0.2s;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .bg-primary-subtle {
        background-color: #e0f2fe !important;
    }
    
    .text-primary {
        color: #2563eb !important;
    }
    
    .bg-success-subtle {
        background-color: #dcfce7 !important;
    }
    
    .text-success {
        color: #059669 !important;
    }
    
    .bg-warning-subtle {
        background-color: #fef3c7 !important;
    }
    
    .text-warning {
        color: #d97706 !important;
    }
    
    .bg-info-subtle {
        background-color: #e0f2fe !important;
    }
    
    .text-info {
        color: #0891b2 !important;
    }

    .bg-danger-subtle {
        background-color: #fee2e2 !important;
    }
    
    .text-danger {
        color: #dc2626 !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const batchFilter = document.getElementById('batchFilter');
    const courseFilter = document.getElementById('courseFilter');

    function updateFilters() {
        const searchQuery = searchInput.value;
        const batchQuery = batchFilter.value;
        const courseQuery = courseFilter.value;

        const params = new URLSearchParams(window.location.search);
        if (searchQuery) params.set('search', searchQuery);
        else params.delete('search');
        if (batchQuery) params.set('batch', batchQuery);
        else params.delete('batch');
        if (courseQuery) params.set('course', courseQuery);
        else params.delete('course');

        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(updateFilters, 500);
    });

    batchFilter.addEventListener('change', updateFilters);
    courseFilter.addEventListener('change', updateFilters);
});
</script>
@endpush
@endsection
