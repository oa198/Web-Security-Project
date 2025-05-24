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
                        <a href="{{ route('academic-calendar.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Academic Calendar</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $event->title }}</span>
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

        <!-- Event Details Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl leading-6 font-semibold text-gray-900">
                        {{ $event->title }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Academic Calendar Event Details
                    </p>
                </div>
                <div class="flex space-x-2">
                    @can('update', $event)
                    <a href="{{ route('academic-calendar.edit', $event->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Edit
                    </a>
                    @endcan
                    
                    @can('delete', $event)
                    <form action="{{ route('academic-calendar.destroy', $event->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this event?')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
                    <!-- Event Type -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Event Type
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @php
                                $typeColors = [
                                    'class' => 'bg-blue-100 text-blue-800',
                                    'exam' => 'bg-red-100 text-red-800',
                                    'holiday' => 'bg-green-100 text-green-800',
                                    'deadline' => 'bg-yellow-100 text-yellow-800',
                                    'other' => 'bg-gray-100 text-gray-800',
                                ];
                                $color = $typeColors[$event->event_type] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($event->event_type) }}
                            </span>
                        </dd>
                    </div>
                    
                    <!-- Date Information -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($event->end_date && $event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d'))
                                {{ $event->start_date->format('M d, Y') }} - {{ $event->end_date->format('M d, Y') }}
                                <span class="text-gray-500 text-xs ml-2">({{ $event->start_date->diffInDays($event->end_date) + 1 }} days)</span>
                            @else
                                {{ $event->start_date->format('M d, Y') }}
                            @endif
                            
                            @if($event->all_day)
                                <span class="ml-2 px-2 py-0.5 inline-flex text-xs leading-4 font-medium rounded-full bg-blue-100 text-blue-800">
                                    All Day
                                </span>
                            @endif
                        </dd>
                    </div>

                    <!-- Academic Term -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Academic Term
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $event->term->name ?? 'Not assigned' }}
                        </dd>
                    </div>

                    <!-- Location -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Location
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $event->location ?? 'No location specified' }}
                        </dd>
                    </div>

                    <!-- Recurrence Information -->
                    @if($event->is_recurring)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Recurrence
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @php
                                $intervalText = '';
                                if ($event->recurrence_type == 'daily') {
                                    $intervalText = 'day' . ($event->recurrence_interval > 1 ? 's' : '');
                                } elseif ($event->recurrence_type == 'weekly') {
                                    $intervalText = 'week' . ($event->recurrence_interval > 1 ? 's' : '');
                                } elseif ($event->recurrence_type == 'monthly') {
                                    $intervalText = 'month' . ($event->recurrence_interval > 1 ? 's' : '');
                                }
                            @endphp
                            
                            Repeats every {{ $event->recurrence_interval }} {{ $intervalText }} for {{ $event->recurrence_end }} occurrences
                        </dd>
                    </div>
                    @endif

                    <!-- Description -->
                    <div class="bg-{{ $event->is_recurring ? 'white' : 'gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Description
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {!! nl2br(e($event->description)) ?: '<span class="text-gray-500">No description provided</span>' !!}
                        </dd>
                    </div>

                    <!-- Created/Updated Information -->
                    <div class="bg-{{ $event->is_recurring ? 'gray-50' : 'white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Record Information
                        </dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <div>Created: {{ $event->created_at->format('M d, Y h:i A') }}</div>
                            <div>Last Updated: {{ $event->updated_at->format('M d, Y h:i A') }}</div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Related Events Section (if event is recurring) -->
        @if($event->is_recurring && count($relatedEvents) > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Recurring Instances
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Other occurrences of this recurring event
                </p>
            </div>
            <div class="border-t border-gray-200">
                <ul class="divide-y divide-gray-200">
                    @foreach($relatedEvents as $relatedEvent)
                    <li class="px-4 py-3 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm font-medium text-gray-900">{{ $relatedEvent->start_date->format('M d, Y') }}</span>
                                @if($relatedEvent->id == $event->id)
                                <span class="ml-2 px-2 py-0.5 inline-flex text-xs leading-4 font-medium rounded-full bg-blue-100 text-blue-800">Current</span>
                                @endif
                            </div>
                            <a href="{{ route('academic-calendar.show', $relatedEvent->id) }}" class="text-sm text-blue-600 hover:text-blue-900">View</a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('academic-calendar.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Calendar
            </a>
        </div>
    </div>
</div>
@endsection
