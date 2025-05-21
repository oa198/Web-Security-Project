@extends('layouts.app')

@section('title', 'Dashboard - Student Portal')

@section('page_title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">
        Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
    </h2>
    <p class="text-gray-600 mt-1">
        Here's an overview of your academic performance and upcoming tasks.
    </p>
</div>

<div class="space-y-6">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm border">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-primary-100 w-12 h-12 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Enrolled Courses</p>
                    <p class="text-xl font-semibold text-gray-800">6</p>
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
                    <p class="text-xl font-semibold text-gray-800">92%</p>
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
                    <p class="text-xl font-semibold text-gray-800">3.8</p>
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
                    <p class="text-sm text-gray-500">Pending Tasks</p>
                    <p class="text-xl font-semibold text-gray-800">5</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Upcoming Assignments -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Assignments</h3>
                    <a href="{{ route('assignments.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-2 h-10 bg-red-500 rounded-full"></div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">Database Systems: Final Project</p>
                            <p class="text-xs text-gray-500">Due: Tomorrow, 11:59 PM</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-2 h-10 bg-amber-500 rounded-full"></div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">Software Engineering: Weekly Quiz</p>
                            <p class="text-xs text-gray-500">Due: May 20, 2023</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-2 h-10 bg-green-500 rounded-full"></div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">Computer Networks: Lab Report</p>
                            <p class="text-xs text-gray-500">Due: May 25, 2023</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Course Overview -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Course Overview</h3>
                    <a href="{{ route('courses.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <p class="text-sm font-medium text-gray-900">Database Systems</p>
                            <p class="text-sm font-semibold text-gray-900">92%</p>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <p class="text-sm font-medium text-gray-900">Web Development</p>
                            <p class="text-sm font-semibold text-gray-900">85%</p>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <p class="text-sm font-medium text-gray-900">Software Engineering</p>
                            <p class="text-sm font-semibold text-gray-900">78%</p>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
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
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Database Systems class cancelled today</p>
                            <p class="text-xs text-gray-500">15 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Your assignment has been graded</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">New quiz available in Software Engineering</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Class Schedule -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Today's Schedule</h3>
                    <a href="{{ route('schedule.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View Week</a>
                </div>
                <div class="space-y-3">
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-2 h-10 bg-primary-500 rounded-full"></div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Database Systems</p>
                            <p class="text-xs text-gray-500">09:00 AM - 10:30 AM • Room 305</p>
                        </div>
                    </div>
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-2 h-10 bg-amber-500 rounded-full"></div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Computer Networks Lab</p>
                            <p class="text-xs text-gray-500">11:00 AM - 12:30 PM • Lab 201</p>
                        </div>
                    </div>
                    <div class="flex p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-2 h-10 bg-green-500 rounded-full"></div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Software Engineering</p>
                            <p class="text-xs text-gray-500">02:00 PM - 03:30 PM • Room 401</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 