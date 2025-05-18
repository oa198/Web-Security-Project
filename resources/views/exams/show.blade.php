@extends('layouts.main')

@section('title', 'Exam Details - Student Portal')

@section('page-title', 'Exam Details')

@section('content')
<div class="mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $exam['title'] ?? 'Midterm Examination' }}</h2>
            <p class="text-gray-600 mt-1">{{ $exam['course_name'] ?? 'Database Systems' }} ({{ $exam['course_code'] ?? 'CS3200' }})</p>
        </div>
        
        @if(($exam['date'] ?? '2023-06-15') >= date('Y-m-d'))
            <div class="flex items-center">
                <div class="text-right mr-4">
                    <p class="text-sm text-gray-500">Time Remaining</p>
                    <p class="text-lg font-semibold text-gray-800" id="countdown">
                        @php
                            $examDate = $exam['date'] ?? '2023-06-15';
                            $examTime = $exam['time'] ?? '10:00:00';
                            $datetime = $examDate . ' ' . $examTime;
                            $timestamp = strtotime($datetime) - time();
                            $days = floor($timestamp / (60 * 60 * 24));
                            $hours = floor(($timestamp % (60 * 60 * 24)) / (60 * 60));
                            $minutes = floor(($timestamp % (60 * 60)) / 60);
                        @endphp
                        {{ $days }}d {{ $hours }}h {{ $minutes }}m
                    </p>
                </div>
                <a href="{{ route('exams.prepare', $exam['id'] ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Start Preparation
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Exam Status Card -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-1.5 h-full 
        {{ ($exam['date'] ?? '2023-06-15') === date('Y-m-d') ? 'bg-red-500' : 
           (strtotime(($exam['date'] ?? '2023-06-15')) - time() < 7 * 24 * 3600 ? 'bg-amber-500' : 'bg-blue-500') }}">
    </div>
    
    <div class="pl-4">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
                @if(($exam['date'] ?? '2023-06-15') === date('Y-m-d'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        Today
                    </span>
                @elseif(strtotime(($exam['date'] ?? '2023-06-15')) - time() < 7 * 24 * 3600)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                        This Week
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Upcoming
                    </span>
                @endif
            </div>
            <div class="ml-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    {{ $exam['format'] ?? 'In-Person' }}
                </span>
            </div>
            <div class="ml-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                    {{ $exam['weight'] ?? '25' }}% of Final Grade
                </span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-1">Date & Time</h4>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-900">
                        {{ \Carbon\Carbon::parse($exam['date'] ?? '2023-06-15')->format('l, F d, Y') }} at 
                        {{ \Carbon\Carbon::parse($exam['time'] ?? '10:00:00')->format('h:i A') }}
                    </p>
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-1">Duration</h4>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-900">{{ $exam['duration'] ?? '120' }} minutes</p>
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-1">Location</h4>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-gray-900">{{ $exam['location'] ?? 'West Hall, Room 201' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Exam Details -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Exam Information</h3>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Description</h4>
                <p class="text-gray-700 mb-4">
                    {{ $exam['description'] ?? 'This midterm examination covers all material from weeks 1-7, including database design, normalization, SQL queries, and transaction management. The exam will test your understanding of both theoretical concepts and practical applications.' }}
                </p>
                
                <h4 class="font-medium text-gray-900 mb-3">Format</h4>
                <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                    @foreach($exam['format_details'] ?? ['Multiple choice questions (40%)', 'Short answer questions (30%)', 'SQL query writing (20%)', 'Database design problem (10%)'] as $format)
                        <li>{{ $format }}</li>
                    @endforeach
                </ul>
                
                <h4 class="font-medium text-gray-900 mb-3">Materials Allowed</h4>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    @foreach($exam['materials'] ?? ['One double-sided 8.5" x 11" cheat sheet', 'Non-programmable calculator', 'No electronic devices allowed'] as $material)
                        <li>{{ $material }}</li>
                    @endforeach
                </ul>
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Topics Covered</h4>
                <div class="space-y-3">
                    @foreach($exam['topics'] ?? ['Database Design', 'Normalization', 'SQL Queries', 'Transaction Management', 'Indexing', 'Query Optimization'] as $topic)
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ $topic }}</span>
                        </div>
                    @endforeach
                </div>
                
                <h4 class="font-medium text-gray-900 mt-6 mb-3">Instructor Notes</h4>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                {{ $exam['instructor_notes'] ?? 'Please arrive 15 minutes early to set up. Focus on understanding concepts rather than memorizing. Practice writing SQL queries as they will be a significant portion of the exam. Review all homework assignments and practice problems.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Study Resources -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Study Resources</h3>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($exam['resources'] ?? [
                ['title' => 'Practice Exam', 'type' => 'PDF', 'link' => '#', 'icon' => 'document'],
                ['title' => 'Study Guide', 'type' => 'PDF', 'link' => '#', 'icon' => 'book'],
                ['title' => 'SQL Query Examples', 'type' => 'Code', 'link' => '#', 'icon' => 'code'],
                ['title' => 'Lecture Slides (Weeks 1-7)', 'type' => 'Slides', 'link' => '#', 'icon' => 'presentation'],
                ['title' => 'Review Session Recording', 'type' => 'Video', 'link' => '#', 'icon' => 'video'],
                ['title' => 'Database Normalization Cheat Sheet', 'type' => 'PDF', 'link' => '#', 'icon' => 'document']
            ] as $resource)
                <a href="{{ $resource['link'] }}" class="flex items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                    @if($resource['icon'] === 'document')
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-primary-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    @elseif($resource['icon'] === 'book')
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @elseif($resource['icon'] === 'code')
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                    @elseif($resource['icon'] === 'presentation')
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-purple-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                    @elseif($resource['icon'] === 'video')
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-red-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ $resource['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $resource['type'] }}</p>
                    </div>
                    
                    <div class="ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Related Assignments -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Related Assignments</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Assignment
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Due Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Grade
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($exam['related_assignments'] ?? [
                    ['id' => 1, 'title' => 'Database Design Project', 'due_date' => '2023-05-15', 'status' => 'Completed', 'grade' => '92/100'],
                    ['id' => 2, 'title' => 'SQL Query Assignment', 'due_date' => '2023-05-22', 'status' => 'Completed', 'grade' => '88/100'],
                    ['id' => 3, 'title' => 'Normalization Homework', 'due_date' => '2023-05-29', 'status' => 'Completed', 'grade' => '95/100'],
                    ['id' => 4, 'title' => 'Transaction Management Lab', 'due_date' => '2023-06-05', 'status' => 'Completed', 'grade' => '90/100']
                ] as $assignment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $assignment['title'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($assignment['due_date'])->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($assignment['status'] === 'Completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($assignment['status'] === 'In Progress')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Not Started
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $assignment['grade'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('assignments.show', $assignment['id']) }}" class="text-primary-600 hover:text-primary-900">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Simple countdown timer
    function updateCountdown() {
        const examDate = '{{ $exam['date'] ?? '2023-06-15' }}';
        const examTime = '{{ $exam['time'] ?? '10:00:00' }}';
        const examDateTime = new Date(`${examDate}T${examTime}`);
        const now = new Date();
        
        const diff = examDateTime - now;
        
        if (diff <= 0) {
            document.getElementById('countdown').textContent = 'Exam in progress';
            return;
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        document.getElementById('countdown').textContent = `${days}d ${hours}h ${minutes}m`;
    }
    
    // Update countdown every minute
    updateCountdown();
    setInterval(updateCountdown, 60000);
</script>
@endsection 