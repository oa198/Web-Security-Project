@extends('layouts.admin')

@section('title', 'View Application')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">View Application</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.applications.index') }}">Applications</a></li>
        <li class="breadcrumb-item active">View Application</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-alt me-1"></i>
                        Application Details
                    </div>
                    <div>
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        @if ($application->status == 'pending')
                            <a href="{{ route('admin.applications.edit', $application->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Review Application
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Application Status</h5>
                            <div class="mb-4">
                                @if ($application->status == 'pending')
                                    <div class="alert alert-warning">
                                        <i class="fas fa-clock"></i> This application is pending review.
                                    </div>
                                @elseif ($application->status == 'approved')
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i> This application was approved on 
                                        {{ $application->reviewed_at->format('F d, Y') }} by {{ $application->reviewer->name }}.
                                    </div>
                                @else
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle"></i> This application was rejected on 
                                        {{ $application->reviewed_at->format('F d, Y') }} by {{ $application->reviewer->name }}.
                                        @if ($application->rejection_reason)
                                            <p class="mt-2 mb-0"><strong>Reason:</strong> {{ $application->rejection_reason }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

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
                                        @if ($application->user->student)
                                            <tr>
                                                <th>Student ID</th>
                                                <td>{{ $application->user->student->student_id }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Application Details</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Application ID</th>
                                            <td>{{ $application->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($application->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif ($application->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Reviewed By</th>
                                            <td>{{ $application->reviewer ? $application->reviewer->name : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reviewed On</th>
                                            <td>{{ $application->reviewed_at ? $application->reviewed_at->format('F d, Y H:i:s') : 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if ($application->documents && count($application->documents) > 0)
                                <h5>Submitted Documents</h5>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Document Name</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($application->documents as $document)
                                                <tr>
                                                    <td>{{ $document['name'] }}</td>
                                                    <td>{{ $document['type'] }}</td>
                                                    <td>{{ number_format($document['size'] / 1024, 2) }} KB</td>
                                                    <td>
                                                        <a href="{{ Storage::url($document['path']) }}" class="btn btn-sm btn-info" target="_blank">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <a href="{{ Storage::url($document['path']) }}" class="btn btn-sm btn-secondary" download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if ($application->notes)
                                <h5>Notes</h5>
                                <div class="card mb-4">
                                    <div class="card-body bg-light">
                                        {{ $application->notes }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-user-graduate me-1"></i>
                                    Student Record
                                </div>
                                <div class="card-body">
                                    @if ($application->user->student)
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle"></i> Student record has been created.
                                        </div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Student ID</th>
                                                <td>{{ $application->user->student->student_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Academic Standing</th>
                                                <td>{{ $application->user->student->academic_standing }}</td>
                                            </tr>
                                            <tr>
                                                <th>Admission Date</th>
                                                <td>{{ $application->user->student->admission_date->format('F d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Expected Graduation</th>
                                                <td>{{ $application->user->student->expected_graduation_date->format('F Y') }}</td>
                                            </tr>
                                        </table>
                                        <a href="#" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-eye"></i> View Full Student Profile
                                        </a>
                                    @else
                                        @if ($application->status == 'approved')
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Application is approved but student record is not created yet.
                                            </div>
                                            <p>The student record will be created automatically when the student logs in next time.</p>
                                        @elseif ($application->status == 'pending')
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> Student record will be created when the application is approved.
                                            </div>
                                        @else
                                            <div class="alert alert-danger">
                                                <i class="fas fa-times-circle"></i> Application has been rejected. No student record will be created.
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-history me-1"></i>
                                    Application Timeline
                                </div>
                                <div class="card-body">
                                    <ul class="timeline">
                                        <li class="timeline-item">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h4 class="timeline-title">Application Submitted</h4>
                                                <p class="timeline-date">{{ $application->created_at->format('F d, Y H:i') }}</p>
                                                <p>Application submitted by {{ $application->user->name }}</p>
                                            </div>
                                        </li>
                                        @if ($application->status != 'pending')
                                            <li class="timeline-item">
                                                <div class="timeline-marker {{ $application->status == 'approved' ? 'bg-success' : 'bg-danger' }}"></div>
                                                <div class="timeline-content">
                                                    <h4 class="timeline-title">Application {{ ucfirst($application->status) }}</h4>
                                                    <p class="timeline-date">{{ $application->reviewed_at->format('F d, Y H:i') }}</p>
                                                    <p>Application {{ $application->status }} by {{ $application->reviewer->name }}</p>
                                                    @if ($application->rejection_reason)
                                                        <p><strong>Reason:</strong> {{ $application->rejection_reason }}</p>
                                                    @endif
                                                </div>
                                            </li>
                                            @if ($application->status == 'approved' && $application->user->student)
                                                <li class="timeline-item">
                                                    <div class="timeline-marker bg-success"></div>
                                                    <div class="timeline-content">
                                                        <h4 class="timeline-title">Student Record Created</h4>
                                                        <p class="timeline-date">{{ $application->user->student->created_at->format('F d, Y H:i') }}</p>
                                                        <p>Student ID: {{ $application->user->student->student_id }}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        list-style: none;
        padding: 0;
        position: relative;
    }
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #ddd;
        left: 10px;
        margin-left: -1px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    .timeline-marker {
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #007bff;
        left: 10px;
        margin-left: -10px;
    }
    .timeline-content {
        margin-left: 35px;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 4px;
    }
    .timeline-title {
        margin-top: 0;
        font-size: 1rem;
        font-weight: bold;
    }
    .timeline-date {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
</style>
@endsection
