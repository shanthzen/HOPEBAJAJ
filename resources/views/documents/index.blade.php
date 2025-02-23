@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Documents - {{ $student->full_name }}</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>

                <div class="card-body">
                    @if($documents->isEmpty())
                        <div class="alert alert-info">
                            No documents uploaded yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Status</th>
                                        <th>Verified By</th>
                                        <th>Verified At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>{{ $document->document_name }}</td>
                                            <td>{{ $document->document_type_text }}</td>
                                            <td>{{ $document->formatted_file_size }}</td>
                                            <td>
                                                @if($document->verification_status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($document->verification_status === 'verified')
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $document->verifier?->name ?? '-' }}</td>
                                            <td>{{ $document->verified_at ? $document->verified_at->format('d/m/Y H:i') : '-' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @if(auth()->user()->isAdmin())
                                                        @if($document->verification_status === 'pending')
                                                            <button type="button" class="btn btn-sm btn-success" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#verifyDocumentModal" 
                                                                data-document-id="{{ $document->id }}">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#rejectDocumentModal" 
                                                                data-document-id="{{ $document->id }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                        <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this document?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('students.documents.store', $student) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="document_type" class="form-label">Document Type</label>
                        <select name="document_type" id="document_type" class="form-select" required>
                            <option value="">Select Document Type</option>
                            @foreach($documentTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="document_name" class="form-label">Document Name</label>
                        <input type="text" class="form-control" id="document_name" name="document_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="document" class="form-label">Document File</label>
                        <input type="file" class="form-control" id="document" name="document" required>
                        <small class="text-muted">Max file size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Verify Document Modal -->
<div class="modal fade" id="verifyDocumentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verify Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="verifyDocumentForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">Verification Notes (Optional)</label>
                        <textarea class="form-control" id="verification_notes" name="verification_notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Verify</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Document Modal -->
<div class="modal fade" id="rejectDocumentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="rejectDocumentForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_notes" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="rejection_notes" name="verification_notes" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle verify modal
        const verifyModal = document.getElementById('verifyDocumentModal');
        verifyModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const documentId = button.getAttribute('data-document-id');
            const form = this.querySelector('#verifyDocumentForm');
            form.action = `/documents/${documentId}/verify`;
        });

        // Handle reject modal
        const rejectModal = document.getElementById('rejectDocumentModal');
        rejectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const documentId = button.getAttribute('data-document-id');
            const form = this.querySelector('#rejectDocumentForm');
            form.action = `/documents/${documentId}/reject`;
        });
    });
</script>
@endpush
@endsection
