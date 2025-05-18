@extends('layouts.main')

@section('title', 'Schedule - Student Portal')

@section('page-title', 'Schedule')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Class Schedule</h2>
    <p class="text-gray-600 mt-1">
        View and manage your academic schedule for each term.
    </p>
</div>

<!-- Schedule Controls -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label for="term" class="block text-sm font-medium text-gray-700 mb-1">Term</label>
                <select id="term" class="text-sm border-gray-200 rounded-md w-48">
                    <option>Spring 2023 (Current)</option>
                    <option>Fall 2022</option>
                    <option>Spring 2022</option>
                </select>
            </div>
            <div>
                <label for="view" class="block text-sm font-medium text-gray-700 mb-1">View</label>
                <select id="view" class="text-sm border-gray-200 rounded-md w-40">
                    <option>Week View</option>
                    <option>Month View</option>
                    <option>List View</option>
                </select>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 border border-gray-300 bg-white rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Today
            </button>
            <button class="p-2 border border-gray-300 bg-white rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="p-2 border border-gray-300 bg-white rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div class="text-sm font-medium text-gray-900 mx-2">
                May 15 - 21, 2023
            </div>
        </div>
    </div>
</div>

<!-- Weekly Schedule Grid -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="grid grid-cols-8 bg-gray-50 border-b text-center">
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Time</div>
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Monday</div>
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Tuesday</div>
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Wednesday</div>
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Thursday</div>
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Friday</div>
        <div class="py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">Saturday</div>
        <div class="py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Sunday</div>
    </div>
    
    <!-- Schedule content would be here, but we'll keep it minimal -->
    <div class="relative">
        <!-- Time slots -->
        <div class="grid grid-cols-8 h-24 border-b">
            <div class="border-r p-1 text-xs text-gray-500">9:00 AM</div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-blue-100 border-l-4 border-blue-600 rounded-r p-2">
                    <p class="text-xs font-medium text-blue-900">Database Systems</p>
                    <p class="text-xs text-blue-700">9:00 - 10:50 AM</p>
                    <p class="text-xs text-blue-700">SCI 102</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-blue-100 border-l-4 border-blue-600 rounded-r p-2">
                    <p class="text-xs font-medium text-blue-900">Database Systems</p>
                    <p class="text-xs text-blue-700">9:00 - 10:50 AM</p>
                    <p class="text-xs text-blue-700">SCI 102</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-blue-100 border-l-4 border-blue-600 rounded-r p-2">
                    <p class="text-xs font-medium text-blue-900">Database Systems</p>
                    <p class="text-xs text-blue-700">9:00 - 10:50 AM</p>
                    <p class="text-xs text-blue-700">SCI 102</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div></div>
        </div>
        
        <div class="grid grid-cols-8 h-24 border-b">
            <div class="border-r p-1 text-xs text-gray-500">11:00 AM</div>
            <div class="border-r"></div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-green-100 border-l-4 border-green-600 rounded-r p-2">
                    <p class="text-xs font-medium text-green-900">Software Engineering</p>
                    <p class="text-xs text-green-700">11:00 - 12:20 PM</p>
                    <p class="text-xs text-green-700">ENG 305</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-green-100 border-l-4 border-green-600 rounded-r p-2">
                    <p class="text-xs font-medium text-green-900">Software Engineering</p>
                    <p class="text-xs text-green-700">11:00 - 12:20 PM</p>
                    <p class="text-xs text-green-700">ENG 305</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div></div>
        </div>
        
        <!-- Just a few more time slots for brevity -->
        <div class="grid grid-cols-8 h-24 border-b">
            <div class="border-r p-1 text-xs text-gray-500">2:00 PM</div>
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-purple-100 border-l-4 border-purple-600 rounded-r p-2">
                    <p class="text-xs font-medium text-purple-900">Web Development</p>
                    <p class="text-xs text-purple-700">2:00 - 3:50 PM</p>
                    <p class="text-xs text-purple-700">COMP 201</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div class="border-r relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-purple-100 border-l-4 border-purple-600 rounded-r p-2">
                    <p class="text-xs font-medium text-purple-900">Web Development</p>
                    <p class="text-xs text-purple-700">2:00 - 3:50 PM</p>
                    <p class="text-xs text-purple-700">COMP 201</p>
                </div>
            </div>
            <div class="border-r"></div>
            <div></div>
        </div>
    </div>
</div>

<!-- Course Schedule Summary -->
<div class="bg-white rounded-lg shadow-sm border p-5">
    <h3 class="font-semibold text-gray-900 mb-4">Current Term Courses</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium">DB</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Database Systems</div>
                                <div class="text-xs text-gray-500">CS 340</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        MWF 9:00 - 10:50 AM
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        SCI 102
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        Prof. Johnson
                    </td>
                </tr>
                
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-green-100 flex items-center justify-center">
                                <span class="text-green-600 font-medium">SE</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Software Engineering</div>
                                <div class="text-xs text-gray-500">CS 361</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        TR 11:00 AM - 12:20 PM
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        ENG 305
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        Prof. Davis
                    </td>
                </tr>
                
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-purple-100 flex items-center justify-center">
                                <span class="text-purple-600 font-medium">WD</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Web Development</div>
                                <div class="text-xs text-gray-500">CS 290</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        WF 2:00 - 3:50 PM
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        COMP 201
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        Prof. Smith
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection