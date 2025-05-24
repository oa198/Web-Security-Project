@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('schedule.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Schedule</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $schedule->course->code }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl leading-6 font-semibold text-gray-900">
                        {{ $schedule->course->code }} - {{ $schedule->course->name }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ ucfirst($schedule->type) }} Schedule Details
                    </p>
                </div>
                <div class="flex space-x-2">
                    @can('update', $schedule)
                    <a href="{{ route('schedule.edit', $schedule->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Edit
                    </a>
                    @endcan
                    
                    @can('delete', $schedule)
                    <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this schedule?')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <!-- Course Information -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Course
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="font-medium">{{ $schedule->course->code }} - {{ $schedule->course->name }}</div>
                            <div class="text-gray-500">{{ $schedule->course->department->name ?? 'No Department' }}</div>
                        </dd>
                    </div>
                    
                    <!-- Schedule Type -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Schedule Type
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @php
                                $typeColors = [
                                    'lecture' => 'bg-blue-100 text-blue-800',
                                    'lab' => 'bg-red-100 text-red-800',
                                    'tutorial' => 'bg-green-100 text-green-800',
                                    'exam' => 'bg-yellow-100 text-yellow-800',
                                    'other' => 'bg-gray-100 text-gray-800',
                                ];
                                $color = $typeColors[$schedule->type] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($schedule->type) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Instructor -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Instructor
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold mr-3">
                                    {{ substr($schedule->instructor->name ?? 'N/A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium">{{ $schedule->instructor->name ?? 'Not Assigned' }}</p>
                                    <p class="text-gray-500 text-xs">{{ $schedule->instructor->email ?? '' }}</p>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <!-- Academic Term -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Academic Term
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $schedule->term->name ?? 'Not assigned' }}
                        </dd>
                    </div>

                    <!-- Time and Day -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Schedule Time
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @php
                                $days = [
                                    0 => 'Sunday',
                                    1 => 'Monday',
                                    2 => 'Tuesday',
                                    3 => 'Wednesday',
                                    4 => 'Thursday',
                                    5 => 'Friday',
                                    6 => 'Saturday',
                                ];
                                $day = $days[$schedule->day_of_week] ?? 'Unknown';
                            @endphp
                            
                            @if($schedule->is_recurring)
                                <div>Every {{ $day }}, {{ $schedule->start_time->format('g:i A') }} - {{ $schedule->end_time->format('g:i A') }}</div>
                                <div class="text-gray-500 text-xs">{{ $schedule->start_time->diffInMinutes($schedule->end_time) }} minutes</div>
                            @elseif($schedule->specific_date)
                                <div>{{ $schedule->specific_date->format('M d, Y') }} ({{ $day }}), {{ $schedule->start_time->format('g:i A') }} - {{ $schedule->end_time->format('g:i A') }}</div>
                                <div class="text-gray-500 text-xs">{{ $schedule->start_time->diffInMinutes($schedule->end_time) }} minutes</div>
                            @else
                                <div>{{ $day }}, {{ $schedule->start_time->format('g:i A') }} - {{ $schedule->end_time->format('g:i A') }}</div>
                                <div class="text-gray-500 text-xs">{{ $schedule->start_time->diffInMinutes($schedule->end_time) }} minutes</div>
                            @endif
                        </dd>
                    </div>

                    <!-- Location -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Room
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $schedule->room }}
                        </dd>
                    </div>

                    <!-- Notes -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {!! nl2br(e($schedule->notes)) ?: '<span class="text-gray-500">No additional notes</span>' !!}
                        </dd>
                    </div>

                    <!-- Created/Updated Information -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Record Information
                        </dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <div>Created: {{ $schedule->created_at->format('M d, Y h:i A') }}</div>
                            <div>Last Updated: {{ $schedule->updated_at->format('M d, Y h:i A') }}</div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Attendance Section (if applicable) -->
        @if($schedule->type != 'exam' && auth()->user()->can('viewAttendance', $schedule))
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Attendance
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Attendance records for this class
                </p>
            </div>
            <div class="border-t border-gray-200">
                @if(count($attendanceSessions) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Late</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($attendanceSessions as $session)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $session->date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $session->present_count }} ({{ round(($session->present_count / $session->total_students) * 100) }}%)
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $session->absent_count }} ({{ round(($session->absent_count / $session->total_students) * 100) }}%)
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $session->late_count }} ({{ round(($session->late_count / $session->total_students) * 100) }}%)
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('attendance.show', $session->id) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-4 py-5 sm:px-6 text-center">
                    <p class="text-gray-500">No attendance records found for this class.</p>
                    @can('createAttendance', $schedule)
                    <div class="mt-4">
                        <a href="{{ route('attendance.create', ['schedule_id' => $schedule->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Take Attendance
                        </a>
                    </div>
                    @endcan
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('schedule.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Schedule
            </a>
        </div>
    </div>
</div>
@endsection
