@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Department Course Management</h1>
        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded">{{ $department->name }}</span>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Department Courses</h2>
                <p class="text-gray-600">Manage courses offered by your department.</p>
            </div>
            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Add New Course
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Professor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($courses as $course)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $course->name }}</div>
                            <div class="text-xs text-gray-500">{{ $course->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $course->code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($course->professor)
                                    {{ $course->professor->user->name }}
                                @else
                                    <span class="text-yellow-600">Not Assigned</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $course->credits }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($course->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-primary-600 hover:text-primary-900 mr-3">View</a>
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No courses found in your department.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Course Statistics</h2>
            <p class="text-gray-600">Overview of course enrollment and performance metrics.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Total Courses</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $courses->total() }}</p>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Active Sections</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2">
                    @php
                        $sectionCount = 0;
                        foreach($courses as $course) {
                            $sectionCount += $course->sections->count();
                        }
                    @endphp
                    {{ $sectionCount }}
                </p>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Total Enrollment</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2">
                    @php
                        $enrollmentCount = 0;
                        foreach($courses as $course) {
                            foreach($course->sections as $section) {
                                $enrollmentCount += $section->enrollments->count();
                            }
                        }
                    @endphp
                    {{ $enrollmentCount }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
