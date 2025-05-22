@extends('layouts.app')

@section('title', 'Dashboard - Student Portal')

@section('page_title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">
        Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
    </h2>
    <p class="text-gray-600 mt-1">
        Here's an overview of your academic performance.
    </p>
</div>

@if(auth()->user()->student)
<div class="space-y-6">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm border">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-primary-100 w-12 h-12 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Enrolled Courses</p>
                    <p class="text-xl font-semibold text-gray-800">{{ auth()->user()->student->enrollments->where('status', 'approved')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm border">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 w-12 h-12 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Attendance</p>
                    <p class="text-xl font-semibold text-gray-800">{{ number_format(auth()->user()->student->attendance_rate ?? 0, 1) }}%</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm border">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Current GPA</p>
                    <p class="text-xl font-semibold text-gray-800">{{ number_format(auth()->user()->student->gpa ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Course Overview -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Course Overview</h3>
                    <a href="{{ route('courses.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse(auth()->user()->student->enrollments->where('status', 'approved') as $enrollment)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <p class="text-sm font-medium text-gray-900">{{ $enrollment->course->name }}</p>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($enrollment->progress, 1) }}%</p>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No enrolled courses</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Recent Notifications -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Notifications</h3>
                    <a href="{{ route('notifications.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse(auth()->user()->notifications->take(3) as $notification)
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-10 h-10 {{ $notification->data['type'] ?? 'bg-blue-100' }} rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $notification->data['type'] ?? 'text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No recent notifications</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Class Schedule -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Today's Schedule</h3>
                    <a href="{{ route('schedule.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View Week</a>
                </div>
                <div class="space-y-3">
                    @if(auth()->user()->student && auth()->user()->student->todaySchedule)
                        @forelse(auth()->user()->student->todaySchedule as $schedule)
                        <div class="flex p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-2 h-10 bg-primary-500 rounded-full"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $schedule->course->name }}</p>
                                <p class="text-xs text-gray-500">{{ $schedule->start_time->format('h:i A') }} - {{ $schedule->end_time->format('h:i A') }} • {{ $schedule->room }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">No classes scheduled for today</p>
                        @endforelse
                    @else
                        <p class="text-gray-500 text-sm">Schedule information not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="bg-white rounded-lg shadow-sm border p-6">
    <div class="text-center">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Student Profile Not Found</h3>
        <p class="text-gray-600 mb-4">You need to complete your student profile to access the dashboard features.</p>
        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Complete Profile
        </a>
    </div>
</div>
@endif
@endsection 