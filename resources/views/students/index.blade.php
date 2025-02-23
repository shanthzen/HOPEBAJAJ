@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate me-2 text-primary"></i>
                    <span class="fw-semibold">Student Management</span>
                </h5>
                @if(in_array(auth()->user()->role, ['admin', 'trainer']))
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add New Student
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
                               placeholder="Search by name, email, phone, 'looking for job', or 'pursuing'..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="batchFilter" class="form-select">
                        <option value="">All Batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>
                                Batch {{ $batch }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-primary-subtle text-primary">
                        <i class="fas fa-users me-1"></i>
                        Total Students: {{ $students->total() }}
                    </span>
                </div>
            </div>

            <!-- Students Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 25%;">Student Details</th>
                            <th style="width: 20%;">Contact Information</th>
                            <th style="width: 15%;">Batch Details</th>
                            <th style="width: 15%;">Faculty</th>
                            <th style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top">
                        @forelse($students as $index => $student)
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($student->student_photo)
                                        <img src="{{ asset('storage/' . $student->student_photo) }}" 
                                             alt="Profile" 
                                             class="rounded-circle me-3"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light me-3 d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-medium">{{ $student->name }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            {{ $student->qualification }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-envelope me-1 text-muted"></i>
                                    {{ $student->email }}
                                </div>
                                <div class="mt-1">
                                    <i class="fas fa-phone me-1 text-muted"></i>
                                    {{ $student->contact_number }}
                                    @if($student->whatsapp_number != $student->contact_number)
                                        <div class="mt-1">
                                            <i class="fab fa-whatsapp me-1 text-success"></i>
                                            {{ $student->whatsapp_number }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-layer-group me-1 text-muted"></i>
                                    Batch {{ $student->batch_no }}
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $student->batch_timings }}
                                </small>
                            </td>
                            <td>
                                <i class="fas fa-chalkboard-teacher me-1 text-muted"></i>
                                {{ $student->faculty_name }}
                            </td>
                            <td>
                                @php
                                    $status = $student->is_pursuing ? 'Pursuing' : 
                                            ($student->looking_for_job ? 'Looking for Job' : 'Working');
                                    
                                    $statusClass = [
                                        'Looking for Job' => 'warning',
                                        'Working' => 'success',
                                        'Pursuing' => 'info'
                                    ][$status] ?? 'secondary';
                                    
                                    $statusIcon = [
                                        'Looking for Job' => 'search',
                                        'Working' => 'briefcase',
                                        'Pursuing' => 'user-graduate'
                                    ][$status] ?? 'info-circle';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }}">
                                    <i class="fas fa-{{ $statusIcon }} me-1"></i>
                                    {{ $status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('students.show', ['student' => $student]) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(in_array(auth()->user()->role, ['admin', 'trainer']))
                                        <a href="{{ route('students.edit', ['student' => $student]) }}" 
                                           class="btn btn-sm btn-outline-info"
                                           title="Edit Student">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', ['student' => $student]) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete Student">
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
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p class="mb-1">No students found</p>
                                    <small>Try adjusting your search criteria</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($students->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $students->links() }}
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const batchFilter = document.getElementById('batchFilter');

    function updateFilters() {
        const searchQuery = searchInput.value;
        const batchQuery = batchFilter.value;

        const params = new URLSearchParams(window.location.search);
        if (searchQuery) params.set('search', searchQuery);
        else params.delete('search');
        if (batchQuery) params.set('batch', batchQuery);
        else params.delete('batch');

        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(updateFilters, 500);
    });

    batchFilter.addEventListener('change', updateFilters);
});
</script>
@endpush
@endsection
