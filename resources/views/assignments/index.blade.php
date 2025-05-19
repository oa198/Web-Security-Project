@extends('layouts.app')

@section('title', 'Assignments - Student Portal')

@section('page_title', 'Assignments')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-wrap gap-2">
        <button 
            id="all-btn"
            class="px-4 py-2 rounded-lg bg-primary-100 text-primary-800"
            onclick="filterAssignments('all')"
        >
            All
        </button>
        <button 
            id="pending-btn"
            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
            onclick="filterAssignments('pending')"
        >
            Pending
        </button>
        <button 
            id="submitted-btn"
            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
            onclick="filterAssignments('submitted')"
        >
            Submitted
        </button>
        <button 
            id="graded-btn"
            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
            onclick="filterAssignments('graded')"
        >
            Graded
        </button>
    </div>

    <!-- Assignments List -->
    <div class="space-y-4">
        <!-- Pending Assignment -->
        <div class="bg-white rounded-lg shadow-sm border p-5 assignment-card" data-status="pending">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-semibold">Database Final Project</h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pending
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Database Systems (CS 301)</p>
                    <p class="text-sm text-gray-700">Design and implement a database system for a university management system.</p>
                    <p class="text-sm text-gray-600">Due: May 20, 2023, 11:59 PM</p>
                </div>
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center justify-center whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Submit
                </button>
            </div>
        </div>

        <!-- Submitted Assignment -->
        <div class="bg-white rounded-lg shadow-sm border p-5 assignment-card" data-status="submitted">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-semibold">Web Development Midterm</h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Submitted
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Web Development (CS 401)</p>
                    <p class="text-sm text-gray-700">Create a responsive website using HTML, CSS, and JavaScript.</p>
                    <p class="text-sm text-gray-600">Due: May 15, 2023, 11:59 PM</p>
                </div>
            </div>
        </div>

        <!-- Graded Assignment -->
        <div class="bg-white rounded-lg shadow-sm border p-5 assignment-card" data-status="graded">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-semibold">Operating Systems Lab 3</h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-primary-100 text-primary-800 flex items-center">
                            Graded
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Operating Systems (CS 305)</p>
                    <p class="text-sm text-gray-700">Implement a simple process scheduler using C.</p>
                    <p class="text-sm text-gray-600">Due: May 10, 2023, 11:59 PM</p>
                    <p class="text-sm font-medium text-gray-900">Grade: 92%</p>
                </div>
            </div>
        </div>

        <!-- Pending Assignment -->
        <div class="bg-white rounded-lg shadow-sm border p-5 assignment-card" data-status="pending">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-semibold">Software Engineering Group Project</h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pending
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Software Engineering (CS 402)</p>
                    <p class="text-sm text-gray-700">Develop a software application as a team using Agile methodologies.</p>
                    <p class="text-sm text-gray-600">Due: May 30, 2023, 11:59 PM</p>
                </div>
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center justify-center whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Submit
                </button>
            </div>
        </div>

        <!-- Graded Assignment with Low Score -->
        <div class="bg-white rounded-lg shadow-sm border p-5 assignment-card" data-status="graded">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-semibold">Data Structures Quiz 2</h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-primary-100 text-primary-800 flex items-center">
                            Graded
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Data Structures and Algorithms (CS 202)</p>
                    <p class="text-sm text-gray-700">Quiz on trees, heaps, and priority queues.</p>
                    <p class="text-sm text-gray-600">Due: May 8, 2023, 10:00 AM</p>
                    <p class="text-sm font-medium text-gray-900">Grade: 78%</p>
                </div>
            </div>
        </div>

        <!-- Late Submission -->
        <div class="bg-white rounded-lg shadow-sm border p-5 assignment-card" data-status="submitted">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-semibold">Computer Networks Assignment 2</h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Late
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Computer Networks (CS 304)</p>
                    <p class="text-sm text-gray-700">Implement a simple client-server application using TCP/IP.</p>
                    <p class="text-sm text-gray-600">Due: May 5, 2023, 11:59 PM</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterAssignments(status) {
        // Reset all buttons
        document.getElementById('all-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('all-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('pending-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('pending-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('submitted-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('submitted-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('graded-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('graded-btn').classList.add('bg-gray-100', 'text-gray-600');
        
        // Set active button
        if (status === 'all') {
            document.getElementById('all-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('all-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else if (status === 'pending') {
            document.getElementById('pending-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('pending-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else if (status === 'submitted') {
            document.getElementById('submitted-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('submitted-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else if (status === 'graded') {
            document.getElementById('graded-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('graded-btn').classList.remove('bg-gray-100', 'text-gray-600');
        }
        
        // Filter assignments
        const assignments = document.querySelectorAll('.assignment-card');
        assignments.forEach(assignment => {
            if (status === 'all') {
                assignment.classList.remove('hidden');
            } else {
                const assignmentStatus = assignment.getAttribute('data-status');
                if (assignmentStatus === status) {
                    assignment.classList.remove('hidden');
                } else {
                    assignment.classList.add('hidden');
                }
            }
        });
    }
</script>
@endsection 