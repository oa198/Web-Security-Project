@extends('layouts.app')

@section('title', 'Profile - Student Portal')

@section('page_title', 'My Profile')

@section('content')
<div class="space-y-6">
    @if(!auth()->user()->student)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        You don't have a student record associated with your account. Please contact the administration office to set up your student profile.
                    </p>
                </div>
            </div>
        </div>
    @else
        @php
            $student = auth()->user()->student;
        @endphp

        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-4xl font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    <p class="text-sm text-gray-500 mt-1">Student ID: {{ $student->student_id ?? 'Not Set' }}</p>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="text-gray-900">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Student ID</p>
                    <p class="text-gray-900">{{ $student->student_id ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date of Birth</p>
                    <p class="text-gray-900">{{ $student->date_of_birth ? $student->date_of_birth->format('F d, Y') : 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gender</p>
                    <p class="text-gray-900 capitalize">{{ $student->gender ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone Number</p>
                    <p class="text-gray-900">{{ $student->phone_number ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Emergency Contact</p>
                    <p class="text-gray-900">{{ $student->emergency_contact ?? 'Not Set' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="text-gray-900">{{ $student->address ?? 'Not Set' }}</p>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Department</p>
                    <p class="text-gray-900">{{ $student->department->name ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Program</p>
                    <p class="text-gray-900">{{ $student->program ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Level</p>
                    <p class="text-gray-900">{{ $student->level ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Admission Date</p>
                    <p class="text-gray-900">{{ $student->admission_date ? $student->admission_date->format('F d, Y') : 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Credits Completed</p>
                    <p class="text-gray-900">{{ $student->credits_completed ?? '0' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">GPA</p>
                    <p class="text-gray-900">{{ $student->gpa ? number_format($student->gpa, 2) : '0.00' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Academic Standing</p>
                    <p class="text-gray-900">{{ $student->academic_standing ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Expected Graduation</p>
                    <p class="text-gray-900">{{ $student->expected_graduation_date ? $student->expected_graduation_date->format('F d, Y') : 'Not Set' }}</p>
                </div>
            </div>
        </div>

        <!-- Status Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Financial Hold</p>
                    <p class="text-gray-900">
                        @if($student->financial_hold)
                            <span class="text-red-600">Yes</span>
                        @else
                            <span class="text-green-600">No</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Academic Hold</p>
                    <p class="text-gray-900">
                        @if($student->academic_hold)
                            <span class="text-red-600">Yes</span>
                        @else
                            <span class="text-green-600">No</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Edit Profile Button -->
        <div class="flex justify-end">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Edit Profile
            </a>
        </div>
    @endif
</div>
@endsection 