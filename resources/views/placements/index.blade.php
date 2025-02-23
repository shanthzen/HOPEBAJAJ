
@extends('layouts.app')

@section('title', 'Placements')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-briefcase me-2 text-primary"></i>
                    <span class="fw-semibold">Placement Management</span>
                </h5>
                @if(auth()->user()->isAdmin() || auth()->user()->isTrainer())
                <a href="{{ route('placements.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add New Placement
                </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control border-start-0" 
                               placeholder="Search placements..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <select id="batchFilter" class="form-select">
                        <option value="">All Companies</option>
                        @foreach($companies as $company)
                            <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>
                                {{ $company }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Placements Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 20%;">Student Details</th>
                            <th style="width: 20%;">Company Info</th>
                            <th style="width: 15%;">Designation</th>
                            <th style="width: 15%;">Salary</th>
                            <th style="width: 10%;">Joining Date</th>
                            <th class="text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top">
                        @forelse($placements as $placement)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light me-3 d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $placement->name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-layer-group me-1"></i>
                                                Batch {{ $placement->batch_no }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-building me-2 text-primary"></i>
                                        <div class="fw-medium">{{ $placement->company_name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $placement->designation }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">
                                        ₹{{ $placement->salary }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $placement->joining_date->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('placements.show', ['placedStudent' => $placement]) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isTrainer())
                                            <a href="{{ route('placements.edit', ['placedStudent' => $placement]) }}" 
                                               class="btn btn-sm btn-outline-info"
                                               title="Edit Placement">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('placements.destroy', ['placedStudent' => $placement]) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this placement?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete Placement">
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
                                        <i class="fas fa-briefcase fa-3x mb-3"></i>
                                        <p class="mb-1">No placements found</p>
                                        <small>Try adjusting your search criteria</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($placements->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $placements->links() }}
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

@if(session('success'))
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endpush
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const batchFilter = document.getElementById('batchFilter');

    function updateFilters() {
        const searchQuery = searchInput.value;
        const companyQuery = batchFilter.value;

        const params = new URLSearchParams(window.location.search);
        if (searchQuery) params.set('search', searchQuery);
        else params.delete('search');
        if (companyQuery) params.set('company', companyQuery);
        else params.delete('company');

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
