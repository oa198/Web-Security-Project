@extends('layouts.app')

@section('styles')
<style>
    .calendar-day {
        min-height: 120px;
        background-color: white;
    }
    .calendar-day.inactive {
        background-color: #f3f4f6;
    }
    .calendar-day:hover {
        background-color: #f9fafb;
    }
    .event-dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .calendar-event {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        margin-bottom: 2px;
        font-size: 0.75rem;
        padding: 2px 4px;
        border-radius: 2px;
    }
    .event-class {
        background-color: #dbeafe;
        border-left: 3px solid #3b82f6;
    }
    .event-exam {
        background-color: #fee2e2;
        border-left: 3px solid #ef4444;
    }
    .event-holiday {
        background-color: #d1fae5;
        border-left: 3px solid #10b981;
    }
    .event-deadline {
        background-color: #fef3c7;
        border-left: 3px solid #f59e0b;
    }
    .event-other {
        background-color: #f3f4f6;
        border-left: 3px solid #6b7280;
    }
</style>
@endsection

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
                        <a href="{{ route('academic-calendar.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Academic Calendar</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Calendar View</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Academic Calendar</h1>
            <div class="flex space-x-2">
                <a href="{{ route('academic-calendar.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    List View
                </a>
                @can('create', App\Models\AcademicCalendar::class)
                <a href="{{ route('academic-calendar.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Event
                </a>
                @endcan
            </div>
        </div>

        <!-- Month Navigation -->
        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow">
            <a href="{{ route('academic-calendar.calendar', ['month' => $prevMonth, 'year' => $prevYear]) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Previous Month
            </a>
            
            <h2 class="text-xl font-semibold text-gray-800">{{ $monthName }} {{ $year }}</h2>
            
            <a href="{{ route('academic-calendar.calendar', ['month' => $nextMonth, 'year' => $nextYear]) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Next Month
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Filter by Term -->
        <div class="mb-6">
            <form action="{{ route('academic-calendar.calendar') }}" method="GET" class="flex items-center space-x-4">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">
                
                <div class="flex-1 max-w-xs">
                    <label for="term_id" class="block text-sm font-medium text-gray-700">Filter by Academic Term</label>
                    <select id="term_id" name="term_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">All Terms</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}" {{ request('term_id') == $term->id ? 'selected' : '' }}>{{ $term->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filter
                    </button>
                    
                    @if(request('term_id'))
                    <a href="{{ route('academic-calendar.calendar', ['month' => $month, 'year' => $year]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Clear
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Calendar Legend -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Event Types</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <span class="event-dot bg-blue-500 mr-2"></span>
                    <span class="text-sm text-gray-600">Class</span>
                </div>
                <div class="flex items-center">
                    <span class="event-dot bg-red-500 mr-2"></span>
                    <span class="text-sm text-gray-600">Exam</span>
                </div>
                <div class="flex items-center">
                    <span class="event-dot bg-green-500 mr-2"></span>
                    <span class="text-sm text-gray-600">Holiday</span>
                </div>
                <div class="flex items-center">
                    <span class="event-dot bg-yellow-500 mr-2"></span>
                    <span class="text-sm text-gray-600">Deadline</span>
                </div>
                <div class="flex items-center">
                    <span class="event-dot bg-gray-500 mr-2"></span>
                    <span class="text-sm text-gray-600">Other</span>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Calendar Header (Days of Week) -->
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                <div class="p-2 text-center bg-gray-100 text-gray-700 font-medium">
                    {{ $dayName }}
                </div>
                @endforeach
            </div>
            
            <!-- Calendar Body -->
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                @foreach($calendarDays as $day)
                <div class="calendar-day {{ $day['current_month'] ? '' : 'inactive' }} p-2">
                    <div class="flex justify-between items-start">
                        <span class="font-medium text-sm {{ $day['today'] ? 'bg-blue-500 text-white rounded-full h-6 w-6 flex items-center justify-center' : '' }}">
                            {{ $day['day'] }}
                        </span>
                        @if(count($day['events']) > 0)
                        <span class="text-xs text-gray-500">{{ count($day['events']) }} event{{ count($day['events']) > 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                    <div class="mt-1">
                        @foreach($day['events'] as $event)
                        <div class="calendar-event event-{{ $event->event_type }}" title="{{ $event->title }}">
                            <a href="{{ route('academic-calendar.show', $event->id) }}" class="text-gray-900 hover:text-blue-600">
                                {{ $event->title }}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
