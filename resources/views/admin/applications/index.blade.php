@extends('layouts.admin')

@section('title', 'Manage Applications')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Student Applications</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Applications</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-file-alt me-1"></i>
                Applications
            </div>
            <div class="d-flex">
                <div class="btn-group me-2">
                    <a href="{{ route('admin.applications.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status', 'pending') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Pending <span class="badge bg-white text-primary">{{ \App\Models\Application::where('status', 'pending')->count() }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                        Approved <span class="badge bg-white text-success">{{ \App\Models\Application::where('status', 'approved')->count() }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                        Rejected <span class="badge bg-white text-danger">{{ \App\Models\Application::where('status', 'rejected')->count() }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-sm {{ request('status') == '' ? 'btn-info' : 'btn-outline-info' }}">
                        All <span class="badge bg-white text-info">{{ \App\Models\Application::count() }}</span>
                    </a>
                </div>
                <form class="d-flex" action="{{ route('admin.applications.index') }}" method="GET">
                    <input type="hidden" name="status" value="{{ request('status', 'pending') }}">
                    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Search applications" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($applications->isEmpty())
                <div class="alert alert-info">
                    No {{ request('status', 'pending') }} applications found.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Applicant</th>
                                <th>Email</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Reviewed By</th>
                                <th>Reviewed At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>{{ $application->user->name }}</td>
                                    <td>{{ $application->user->email }}</td>
                                    <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        @if ($application->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($application->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->reviewer ? $application->reviewer->name : 'N/A' }}</td>
                                    <td>{{ $application->reviewed_at ? $application->reviewed_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if ($application->status == 'pending')
                                                <a href="{{ route('admin.applications.edit', $application->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i> Review
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
