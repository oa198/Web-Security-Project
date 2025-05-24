@extends('layouts.admin')

@section('title', 'Review Application')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Review Application</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.applications.index') }}">Applications</a></li>
        <li class="breadcrumb-item active">Review Application</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-alt me-1"></i>
                        Review Application #{{ $application->id }}
                    </div>
                    <div>
                        <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($application->status !== 'pending')
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> This application has already been {{ $application->status }}. You cannot modify it anymore.
                        </div>
                    @else
                        <form action="{{ route('admin.applications.update', $application->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Applicant Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $application->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $application->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Submitted On</th>
                                            <td>{{ $application->created_at->format('F d, Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Documents</h5>
                                    @if ($application->documents && count($application->documents) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Document Name</th>
                                                        <th>Type</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($application->documents as $document)
                                                        <tr>
                                                            <td>{{ $document['name'] }}</td>
                                                            <td>{{ $document['type'] }}</td>
                                                            <td>
                                                                <a href="{{ Storage::url($document['path']) }}" class="btn btn-sm btn-info" target="_blank">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            No documents were submitted with this application.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($application->notes)
                                <div class="mb-4">
                                    <h5>Applicant Notes</h5>
                                    <div class="card">
                                        <div class="card-body bg-light">
                                            {{ $application->notes }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <h5>Application Decision</h5>
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status-approved" value="approved" required>
                                    <label class="form-check-label" for="status-approved">
                                        <span class="badge bg-success">Approve</span> - Accept this application and create a student record
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status-rejected" value="rejected">
                                    <label class="form-check-label" for="status-rejected">
                                        <span class="badge bg-danger">Reject</span> - Decline this application
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status-pending" value="pending">
                                    <label class="form-check-label" for="status-pending">
                                        <span class="badge bg-warning text-dark">Pending</span> - Keep this application pending for now
                                    </label>
                                </div>
                                @error('status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="rejection-reason-container" style="display: none;">
                                <label for="rejection_reason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3">{{ old('rejection_reason') }}</textarea>
                                <div class="form-text">Please provide a reason why this application is being rejected. This will be shared with the applicant.</div>
                                @error('rejection_reason')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Internal Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $application->notes) }}</textarea>
                                <div class="form-text">These notes are for internal use only and will not be shared with the applicant.</div>
                                @error('notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Decision</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide rejection reason based on status selection
        const statusRadios = document.querySelectorAll('input[name="status"]');
        const rejectionReasonContainer = document.getElementById('rejection-reason-container');
        
        statusRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'rejected') {
                    rejectionReasonContainer.style.display = 'block';
                    document.getElementById('rejection_reason').setAttribute('required', 'required');
                } else {
                    rejectionReasonContainer.style.display = 'none';
                    document.getElementById('rejection_reason').removeAttribute('required');
                }
            });
        });
        
        // Initialize based on any pre-selected value (e.g., from validation errors)
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        if (selectedStatus && selectedStatus.value === 'rejected') {
            rejectionReasonContainer.style.display = 'block';
            document.getElementById('rejection_reason').setAttribute('required', 'required');
        }
    });
</script>
@endpush
@endsection
