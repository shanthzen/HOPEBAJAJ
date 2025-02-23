@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Data Management</h2>

            <!-- Student Records -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Student Records</h5>
                    <span class="badge bg-primary">{{ $studentsCount }} Records</span>
                </div>
                <div class="card-body">
                    <p>Export student records in your preferred format:</p>
                    <div class="btn-group">
                        <button onclick="exportData('students', 'csv')" class="btn btn-outline-primary">
                            <i class="fas fa-file-csv"></i> CSV
                        </button>
                        <button onclick="exportData('students', 'pdf')" class="btn btn-outline-danger">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Graduate Records -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Graduate Records</h5>
                    <span class="badge bg-success">{{ $graduatesCount }} Records</span>
                </div>
                <div class="card-body">
                    <p>Export graduate records in your preferred format:</p>
                    <div class="btn-group">
                        <button onclick="exportData('graduates', 'csv')" class="btn btn-outline-primary">
                            <i class="fas fa-file-csv"></i> CSV
                        </button>
                        <button onclick="exportData('graduates', 'pdf')" class="btn btn-outline-danger">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Placement Records -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Placement Records</h5>
                    <span class="badge bg-info">{{ $placementsCount }} Records</span>
                </div>
                <div class="card-body">
                    <p>Export placement records in your preferred format:</p>
                    <div class="btn-group">
                        <button onclick="exportData('placements', 'csv')" class="btn btn-outline-primary">
                            <i class="fas fa-file-csv"></i> CSV
                        </button>
                        <button onclick="exportData('placements', 'pdf')" class="btn btn-outline-danger">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Export History -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Export History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Format</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exportHistory as $export)
                                <tr>
                                    <td>{{ $export->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $export->type === 'students' ? 'primary' : ($export->type === 'graduates' ? 'success' : 'info') }}">
                                            {{ ucfirst($export->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ strtoupper($export->format) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $export->status === 'completed' ? 'success' : ($export->status === 'failed' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($export->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($export->status === 'completed')
                                        <button onclick="downloadExport({{ $export->id }})" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> Download
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No export history available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@push('scripts')
<script>
function exportData(type, format) {
    // Show loading state
    Swal.fire({
        title: 'Exporting...',
        text: 'Please wait while we prepare your export',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Make the export request
    fetch(`/data/export/${type}?format=${format}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Start the download
            window.location.href = `/data/download/${data.export_id}`;
            
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message
            });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Export Failed',
            text: error.message || 'An error occurred during export'
        });
    });
}

function downloadExport(id) {
    window.location.href = `/data/download/${id}`;
}
</script>
@endpush
@endsection
