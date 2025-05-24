@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Course Schedule</h1>
    <div class="card mt-4">
        <div class="card-body">
            <h3>{{ $course->name ?? $course->title }}</h3>
            <p><strong>Code:</strong> {{ $course->code }}</p>
            <p><strong>Schedule:</strong> {{ $course->schedule ?? 'No schedule available.' }}</p>
            <p><strong>Location:</strong> {{ $course->location ?? 'TBA' }}</p>
        </div>
    </div>
    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course</a>
</div>
@endsection 