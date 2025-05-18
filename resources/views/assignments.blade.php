@extends('layouts.main')

@section('title', 'Assignments - Student Portal')

@section('page-title', 'Assignments')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Assignments</h2>
    <p class="text-gray-600 mt-1">
        Track and manage your assignments across all courses.
    </p>
</div>

<!-- Assignment Filters -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <form action="{{ route('assignments.filter') }}" method="GET">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4">
                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select id="course" name="course" class="text-sm border-gray-200 rounded-md w-40">
                        <option value="">All Courses</option>
                        <option value="database">Database Systems</option>
                        <option value="web">Web Development</option>
                        <option value="network">Computer Networks</option>
                        <option value="software">Software Engineering</option>
                        <option value="data">Data Science</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="text-sm border-gray-200 rounded-md w-40">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="in_progress">In Progress</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select id="priority" name="priority" class="text-sm border-gray-200 rounded-md w-40">
                        <option value="">All Priorities</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>
            <div class="relative">
                <input type="text" name="search" placeholder="Search assignments..." class="pl-8 pr-4 py-2 border border-gray-200 rounded-md w-64">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-2.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <button type="submit" class="hidden">Search</button>
            </div>
        </div>
    </form>
</div>

<!-- Assignment Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Overdue</p>
                <p class="text-xl font-semibold text-gray-800">{{ $overdueCount ?? 2 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-amber-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Due Today</p>
                <p class="text-xl font-semibold text-gray-800">{{ $dueTodayCount ?? 3 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Upcoming</p>
                <p class="text-xl font-semibold text-gray-800">{{ $upcomingCount ?? 12 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Completed</p>
                <p class="text-xl font-semibold text-gray-800">{{ $completedCount ?? 24 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Overdue Assignments -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Overdue Assignments</h3>
    </div>
    <div class="space-y-3">
        @forelse($overdue ?? [] as $assignment)
        <div class="flex items-center p-3 bg-red-50 rounded-lg border border-red-100">
            <div class="flex-shrink-0 w-2 h-10 bg-red-500 rounded-full"></div>
            <div class="ml-3 flex-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $assignment['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $assignment['course'] }} • {{ $assignment['instructor'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-red-600">
                            @if(isset($assignment['due_date']) && $assignment['due_date']->diffInDays(now()) == 1)
                                1 day overdue
                            @elseif(isset($assignment['due_date']))
                                {{ $assignment['due_date']->diffInDays(now()) }} days overdue
                            @else
                                Overdue
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            @if(isset($assignment['due_date']))
                                {{ $assignment['due_date']->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-2 flex justify-between items-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                        {{ ucfirst($assignment['priority'] ?? 'High') }} Priority
                    </span>
                    <a href="{{ route('assignments.submit', $assignment['id']) }}" class="text-xs text-primary-600 font-medium hover:text-primary-700">Submit Now</a>
                </div>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500">
            No overdue assignments found.
        </div>
        @endforelse
    </div>
</div>

<!-- Due Today -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Due Today</h3>
    </div>
    <div class="space-y-3">
        @forelse($dueToday ?? [] as $assignment)
        <div class="flex items-center p-3 bg-amber-50 rounded-lg border border-amber-100">
            <div class="flex-shrink-0 w-2 h-10 bg-amber-500 rounded-full"></div>
            <div class="ml-3 flex-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $assignment['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $assignment['course'] }} • {{ $assignment['instructor'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-amber-600">Due today</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            @if(isset($assignment['due_date']) && $assignment['due_date'] instanceof \DateTime)
                                {{ $assignment['due_date']->format('h:i A') }}
                            @else
                                {{ $assignment['due_time'] ?? '11:59 PM' }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-2 flex justify-between items-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                        {{ ucfirst($assignment['priority'] ?? 'Medium') }} Priority
                    </span>
                    @if($assignment['title'] == 'Web Development Quiz')
                    <a href="{{ route('assignments.start', $assignment['id']) }}" class="text-xs text-primary-600 font-medium hover:text-primary-700">Start Quiz</a>
                    @else
                    <a href="{{ route('assignments.submit', $assignment['id']) }}" class="text-xs text-primary-600 font-medium hover:text-primary-700">Submit Now</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500">
            No assignments due today.
        </div>
        @endforelse
    </div>
</div>

<!-- Upcoming Assignments -->
<div class="bg-white rounded-lg shadow-sm border p-5">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Upcoming Assignments</h3>
    </div>
    <div class="space-y-3">
        @forelse($upcoming ?? [] as $assignment)
        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
            <div class="flex-shrink-0 w-2 h-10 bg-blue-500 rounded-full"></div>
            <div class="ml-3 flex-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $assignment['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $assignment['course'] }} • {{ $assignment['instructor'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-blue-600">
                            @if(isset($assignment['due_date']) && $assignment['due_date'] instanceof \DateTime)
                                Due in {{ $assignment['due_date']->diffInDays(now()) }} days
                            @else
                                {{ $assignment['due_date'] ?? 'Upcoming' }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            @if(isset($assignment['due_date']) && $assignment['due_date'] instanceof \DateTime)
                                {{ $assignment['due_date']->format('M d, Y') }}
                            @else
                                {{ $assignment['due_time'] ?? '' }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-2 flex justify-between items-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                        @if(($assignment['priority'] ?? '') == 'high') bg-red-100 text-red-800
                        @elseif(($assignment['priority'] ?? '') == 'medium') bg-amber-100 text-amber-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($assignment['priority'] ?? 'Low') }} Priority
                    </span>
                    <a href="{{ route('assignments.start', $assignment['id']) }}" class="text-xs text-primary-600 font-medium hover:text-primary-700">Start Assignment</a>
                </div>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500">
            No upcoming assignments.
        </div>
        @endforelse
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('assignments.index') }}" class="text-sm text-primary-600 font-medium hover:text-primary-700">
            View All Assignments
        </a>
    </div>
</div>
@endsection 
@endsection 