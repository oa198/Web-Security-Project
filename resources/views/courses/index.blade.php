@extends('layouts.main')

@section('title', 'Courses - Student Portal')

@section('page-title', 'Courses')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Courses</h2>
    <p class="text-gray-600 mt-1">
        View and manage your enrolled courses
    </p>
</div>

<!-- Course Filters -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select id="semester" name="semester" form="course-filter-form" class="text-sm border-gray-200 rounded-md w-40">
                    <option value="all">All Semesters</option>
                    @foreach ($semesters ?? ['Fall 2023', 'Spring 2023', 'Fall 2022'] as $semester)
                        <option value="{{ $semester }}">{{ $semester }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select id="department" name="department" form="course-filter-form" class="text-sm border-gray-200 rounded-md w-44">
                    <option value="all">All Departments</option>
                    @foreach ($departments ?? ['Computer Science', 'Mathematics', 'Physics', 'Biology'] as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" form="course-filter-form" class="text-sm border-gray-200 rounded-md w-40">
                    <option value="all">All Status</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="mt-6">
                <form id="course-filter-form" action="{{ route('courses.filter') }}" method="GET">
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md text-sm font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>
        <div class="relative">
            <form action="{{ route('courses.search') }}" method="GET">
                <input type="text" name="q" placeholder="Search courses..." class="pl-8 pr-4 py-2 border border-gray-200 rounded-md w-64">
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Current Semester Courses -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Semester: {{ $currentSemester ?? 'Fall 2023' }}</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($currentCourses ?? [] as $course)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="h-2 
                    @if($course['progress'] < 25) bg-red-500
                    @elseif($course['progress'] < 50) bg-amber-500
                    @elseif($course['progress'] < 75) bg-blue-500
                    @else bg-green-500 @endif" 
                    style="width: {{ $course['progress'] }}%">
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $course['name'] }}</h4>
                        <span class="text-xs font-medium bg-gray-100 text-gray-800 px-2 py-1 rounded">
                            {{ $course['credits'] }} Credits
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">{{ $course['code'] }}</p>
                    
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-gray-700">{{ $course['professor'] }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-700">{{ $course['schedule'] }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-700">{{ $course['location'] }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-700">Progress</div>
                            <div class="text-xs text-gray-500">{{ $course['progress'] }}% Complete</div>
                        </div>
                        <a href="{{ route('courses.show', $course['id']) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            View Course
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 p-5 bg-white rounded-lg border border-gray-200 shadow-sm text-center text-gray-500">
                No courses found for the current semester.
            </div>
        @endforelse
    </div>
    
    @if(!isset($currentCourses) || count($currentCourses) > 3)
        <div class="mt-4 text-center">
            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Show More
            </button>
        </div>
    @endif
</div>

<!-- Completed Courses -->
<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Completed Courses</h3>
    
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Course Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Code
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Semester
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Instructor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Grade
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Credits
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($completedCourses ?? [] as $course)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $course['name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $course['code'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $course['semester'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $course['instructor'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($course['grade'] == 'A' || $course['grade'] == 'A-') bg-green-100 text-green-800 
                                    @elseif($course['grade'] == 'B+' || $course['grade'] == 'B' || $course['grade'] == 'B-') bg-blue-100 text-blue-800
                                    @elseif($course['grade'] == 'C+' || $course['grade'] == 'C' || $course['grade'] == 'C-') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $course['grade'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $course['credits'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('courses.show', $course['id']) }}" class="text-primary-600 hover:text-primary-700">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No completed courses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if(!isset($completedCourses) || count($completedCourses) > 5)
        <div class="mt-4 text-center">
            <a href="{{ route('courses.completed') }}" class="inline-block px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                View All Completed Courses
            </a>
        </div>
    @endif
</div>
@endsection 