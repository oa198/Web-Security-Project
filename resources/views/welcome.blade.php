@extends('layouts.master')

@section('title', 'University Portal')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="card shadow-lg p-4 border-0" style="max-width: 480px;">
        <div class="text-center mb-3">
            <img src="/logo.png" alt="University Logo" width="72" height="72" class="mb-2 rounded-circle"/>
            <h1 class="h3 fw-bold text-primary">Welcome to Elsewedy University of Technology Portal</h1>
        </div>
        <p class="lead text-center mb-0">
            Please use the menu to navigate through the system features.<br>
            Manage users, academics, enrollments, finances, events, and documents with ease.
        </p>
    </div>
</div>
@endsection
