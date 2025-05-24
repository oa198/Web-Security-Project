@extends('layouts.app')

@section('title', 'Administrator Dashboard')

@section('styles')
<!-- Tailwind CSS via CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Administrator Dashboard</h1>
    
    <!-- Tabs -->
    <div class="mb-8">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <!-- Course Management Tab -->
                <button onclick="openTab('courses')" id="courses-tab" 
                    class="tab-btn border-purple-500 text-purple-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Course Management
                </button>
                
                <!-- Student Management Tab -->
                <button onclick="openTab('students')" id="students-tab"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Student Management
                </button>
                
                <!-- Admissions Tab -->
                <button onclick="openTab('admissions')" id="admissions-tab"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Admissions
                </button>
                
                <!-- Financial Tab -->
                <button onclick="openTab('financial')" id="financial-tab"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Financial
                </button>
            </nav>
        </div>
        
        <!-- Tab Content -->
        <div class="mt-6">
            <!-- Course Management Content -->
            <div id="courses-content" class="tab-content">
                @include('admin.partials.course-management')
            </div>
            
            <!-- Student Management Content -->
            <div id="students-content" class="tab-content hidden">
                @include('admin.partials.student-management')
            </div>
            
            <!-- Admissions Content -->
            <div id="admissions-content" class="tab-content hidden">
                @include('admin.partials.admissions-management')
            </div>
            
            <!-- Financial Content -->
            <div id="financial-content" class="tab-content hidden">
                @include('admin.partials.financial-management')
            </div>
        </div>
    </div>
</div>

<!-- Tab Switching JavaScript -->
<script>
    function openTab(tabName) {
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Show the selected tab content
        document.getElementById(`${tabName}-content`).classList.remove('hidden');
        
        // Update tab button styles
        const tabButtons = document.querySelectorAll('.tab-btn');
        tabButtons.forEach(btn => {
            btn.classList.remove('border-purple-500', 'text-purple-600');
            btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
        
        // Set active tab button style
        const activeButton = document.getElementById(`${tabName}-tab`);
        activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        activeButton.classList.add('border-purple-500', 'text-purple-600');
    }
</script>
@endsection