@extends('layouts.main')

@section('title', 'Exams - Student Portal')

@section('page-title', 'Exams')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Exams</h2>
    <p class="text-gray-600 mt-1">
        View and prepare for upcoming exams and check past exam results.
    </p>
</div>

<!-- Exam Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-primary-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Exams</p>
                <p class="text-xl font-semibold text-gray-800">{{ $totalCount ?? 6 }}</p>
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
                <p class="text-sm text-gray-500">Upcoming</p>
                <p class="text-xl font-semibold text-gray-800">{{ $upcomingCount ?? 3 }}</p>
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
                <p class="text-xl font-semibold text-gray-800">{{ $completedCount ?? 3 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Exam Actions -->
<div class="flex flex-wrap mb-6 gap-2">
    <a href="{{ route('exams.calendar') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        View Calendar
    </a>
    
    <form action="{{ route('exams.filter') }}" method="GET" class="flex flex-wrap items-center gap-2 ml-auto">
        <select name="course" class="text-sm border-gray-300 rounded-md">
            <option value="">All Courses</option>
            <option value="cs3200">Database Systems</option>
            <option value="cs4550">Web Development</option>
            <option value="cs3700">Computer Networks</option>
            <option value="cs4500">Software Engineering</option>
        </select>
        
        <select name="status" class="text-sm border-gray-300 rounded-md">
            <option value="">All Status</option>
            <option value="upcoming">Upcoming</option>
            <option value="completed">Completed</option>
        </select>
        
        <select name="format" class="text-sm border-gray-300 rounded-md">
            <option value="">All Formats</option>
            <option value="in-person">In-Person</option>
            <option value="virtual">Virtual</option>
        </select>
        
        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Apply Filters
        </button>
    </form>
</div>

<!-- Upcoming Exams -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Exams</h3>
    
    @forelse($upcomingExams ?? [] as $exam)
        <div class="bg-white rounded-lg shadow-sm border p-5 mb-4 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full 
                {{ $exam['date'] === now()->format('Y-m-d') ? 'bg-red-500' : 
                   (strtotime($exam['date']) - time() < 7 * 24 * 3600 ? 'bg-amber-500' : 'bg-blue-500') }}">
            </div>
            <div class="flex flex-wrap justify-between gap-4">
                <div>
                    <div class="flex items-center">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $exam['title'] }}</h4>
                        <span class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $exam['format'] }}
                        </span>
                    </div>
                    <p class="text-gray-600 mt-1">{{ $exam['course_name'] }} ({{ $exam['course_code'] }})</p>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($exam['date'])->format('l, M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($exam['time'])->format('h:i A') }} ({{ $exam['duration'] }} min)</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm text-gray-600">{{ $exam['location'] }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('exams.show', $exam['id']) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        View Details
                    </a>
                    <a href="{{ route('exams.prepare', $exam['id']) }}" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Start Preparation
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-sm border p-5 text-center">
            <p class="text-gray-500">No upcoming exams found.</p>
        </div>
    @endforelse
</div>

<!-- Past Exams -->
<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Past Exams</h3>
    
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Course
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Exam
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Score
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Feedback
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pastExams ?? [] as $exam)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $exam['course_name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $exam['course_code'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $exam['title'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($exam['date'])->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2 flex-shrink-0">
                                        @if(($exam['score'] / $exam['total'] * 100) >= 90)
                                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-green-100">
                                                <span class="text-sm font-medium text-green-800">A</span>
                                            </span>
                                        @elseif(($exam['score'] / $exam['total'] * 100) >= 80)
                                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-blue-100">
                                                <span class="text-sm font-medium text-blue-800">B</span>
                                            </span>
                                        @elseif(($exam['score'] / $exam['total'] * 100) >= 70)
                                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-yellow-100">
                                                <span class="text-sm font-medium text-yellow-800">C</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-red-100">
                                                <span class="text-sm font-medium text-red-800">D</span>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-900">{{ $exam['score'] }}/{{ $exam['total'] }} ({{ round($exam['score'] / $exam['total'] * 100) }}%)</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($exam['feedback_available'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('exams.results', $exam['id']) }}" class="text-primary-600 hover:text-primary-900">View Results</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No past exams found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 