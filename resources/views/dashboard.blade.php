@extends('layouts.main')

@section('title', 'Dashboard - Student Portal')

@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600 mt-1">
        Here's what's happening with your academics today.
    </p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-primary-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Current GPA</p>
                <p class="text-xl font-semibold text-gray-800">3.85</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Current Courses</p>
                <p class="text-xl font-semibold text-gray-800">5</p>
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
                <p class="text-sm text-gray-500">Due Soon</p>
                <p class="text-xl font-semibold text-gray-800">7</p>
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
                <p class="text-xl font-semibold text-gray-800">24</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Upcoming Assignments -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border p-5 h-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Upcoming Assignments</h3>
                <a href="/assignments" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="flex-shrink-0 w-2 h-10 bg-amber-500 rounded-full"></div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Web Development Quiz</p>
                                <p class="text-xs text-gray-500">Web Development • Prof. Smith</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-amber-600">Due today</p>
                                <p class="text-xs text-gray-500 mt-0.5">11:59 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="flex-shrink-0 w-2 h-10 bg-amber-500 rounded-full"></div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Software Engineering SCRUM Report</p>
                                <p class="text-xs text-gray-500">Software Engineering • Prof. Davis</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-amber-600">Due today</p>
                                <p class="text-xs text-gray-500 mt-0.5">11:59 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0 w-2 h-10 bg-blue-500 rounded-full"></div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">SQL Challenge</p>
                                <p class="text-xs text-gray-500">Database Systems • Prof. Johnson</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-blue-600">Due in 2 days</p>
                                <p class="text-xs text-gray-500 mt-0.5">May 19, 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0 w-2 h-10 bg-blue-500 rounded-full"></div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">JavaScript Framework Comparison</p>
                                <p class="text-xs text-gray-500">Web Development • Prof. Smith</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-blue-600">Due in 4 days</p>
                                <p class="text-xs text-gray-500 mt-0.5">May 21, 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Overview -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border p-5 h-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Course Overview</h3>
                <a href="/courses" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-900">Database Systems</span>
                        <span class="text-green-600">A (95%)</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 95%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-900">Web Development</span>
                        <span class="text-green-600">A- (91%)</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 91%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-900">Computer Networks</span>
                        <span class="text-green-600">B+ (88%)</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 88%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-900">Software Engineering</span>
                        <span class="text-green-600">A (93%)</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 93%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-900">Data Science</span>
                        <span class="text-amber-600">B (85%)</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Class Schedule -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border p-5 h-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Today's Schedule</h3>
                <a href="/schedule" class="text-primary-600 hover:text-primary-700 text-sm font-medium">Full Schedule</a>
            </div>
            
            <div class="space-y-3">
                <div class="flex p-3 bg-gray-50 rounded-lg">
                    <div class="w-16 flex-shrink-0 flex flex-col items-center justify-center">
                        <span class="text-sm font-semibold text-gray-900">9:00 AM</span>
                        <span class="text-xs text-gray-500">10:50 AM</span>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex flex-wrap justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Database Systems</p>
                                <p class="text-xs text-gray-500">Prof. Johnson • SCI 102</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Lecture
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex p-3 bg-gray-50 rounded-lg">
                    <div class="w-16 flex-shrink-0 flex flex-col items-center justify-center">
                        <span class="text-sm font-semibold text-gray-900">11:00 AM</span>
                        <span class="text-xs text-gray-500">12:20 PM</span>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex flex-wrap justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Software Engineering</p>
                                <p class="text-xs text-gray-500">Prof. Davis • ENG 305</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Lecture
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex p-3 bg-gray-50 rounded-lg">
                    <div class="w-16 flex-shrink-0 flex flex-col items-center justify-center">
                        <span class="text-sm font-semibold text-gray-900">2:00 PM</span>
                        <span class="text-xs text-gray-500">3:50 PM</span>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex flex-wrap justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Web Development</p>
                                <p class="text-xs text-gray-500">Prof. Smith • COMP 201</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Lab
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Notifications -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border p-5 h-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Notifications</h3>
                <a href="/notifications" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>
            
            <div class="space-y-4">
                <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Database Final Project Posted</p>
                            <p class="text-xs text-blue-700 mt-1">The final project for Database Systems has been posted. Due May 30.</p>
                            <p class="text-xs text-blue-600 mt-1">2 hours ago</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Quiz Grade Posted</p>
                            <p class="text-xs text-green-700 mt-1">Your Web Development Quiz 3 has been graded. Score: 92%</p>
                            <p class="text-xs text-green-600 mt-1">Yesterday</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-amber-800">Class Canceled</p>
                            <p class="text-xs text-amber-700 mt-1">Computer Networks class on Friday, May 19 has been canceled.</p>
                            <p class="text-xs text-amber-600 mt-1">2 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="bg-white rounded-lg shadow-sm border p-5">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Financial Summary</h3>
        <a href="/financial" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View Details</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500 mb-1">Current Term Balance</p>
            <p class="text-2xl font-bold text-gray-900">$0.00</p>
            <p class="text-xs text-green-600 mt-1">Paid in Full</p>
        </div>
        
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500 mb-1">Financial Aid</p>
            <p class="text-2xl font-bold text-gray-900">$12,500.00</p>
            <p class="text-xs text-gray-600 mt-1">Disbursed for Spring 2023</p>
        </div>
        
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500 mb-1">Next Payment Due</p>
            <p class="text-2xl font-bold text-gray-900">Aug 15, 2023</p>
            <p class="text-xs text-gray-600 mt-1">Fall 2023 Tuition</p>
        </div>
    </div>
    
    <div class="mt-2">
        <a href="/financial/payment" class="inline-flex items-center px-4 py-2 border border-primary-300 text-sm font-medium rounded-md text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <svg class="mr-2 -ml-1 h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            Make a Payment
        </a>
    </div>
</div>
@endsection 