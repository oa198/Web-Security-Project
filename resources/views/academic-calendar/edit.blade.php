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
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('academic-calendar.show', $event->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $event->title }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Edit Calendar Event</h1>
            <p class="mt-2 text-sm text-gray-600">Update the details for "{{ $event->title }}"</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('academic-calendar.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-4 py-5 sm:p-6">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 p-4 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700">Event Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Event Type -->
                        <div class="col-span-1">
                            <label for="event_type" class="block text-sm font-medium text-gray-700">Event Type <span class="text-red-500">*</span></label>
                            <select id="event_type" name="event_type" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Event Type</option>
                                <option value="class" {{ old('event_type', $event->event_type) == 'class' ? 'selected' : '' }}>Class</option>
                                <option value="exam" {{ old('event_type', $event->event_type) == 'exam' ? 'selected' : '' }}>Exam</option>
                                <option value="holiday" {{ old('event_type', $event->event_type) == 'holiday' ? 'selected' : '' }}>Holiday</option>
                                <option value="deadline" {{ old('event_type', $event->event_type) == 'deadline' ? 'selected' : '' }}>Deadline</option>
                                <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Academic Term -->
                        <div class="col-span-1">
                            <label for="term_id" class="block text-sm font-medium text-gray-700">Academic Term <span class="text-red-500">*</span></label>
                            <select id="term_id" name="term_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Academic Term</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}" {{ old('term_id', $event->term_id) == $term->id ? 'selected' : '' }}>{{ $term->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="col-span-1">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- End Date -->
                        <div class="col-span-1">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Leave blank for single-day events</p>
                        </div>

                        <!-- All Day Event -->
                        <div class="col-span-1">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="all_day" name="all_day" type="checkbox" value="1" {{ old('all_day', $event->all_day) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="all_day" class="font-medium text-gray-700">All Day Event</label>
                                    <p class="text-gray-500">Check if the event lasts all day</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recurring Event -->
                        <div class="col-span-1">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_recurring" name="is_recurring" type="checkbox" value="1" {{ old('is_recurring', $event->is_recurring) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_recurring" class="font-medium text-gray-700">Recurring Event</label>
                                    <p class="text-gray-500">Check if the event repeats on a schedule</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recurrence Pattern (conditional) -->
                        <div class="col-span-2 recurring-options" style="{{ old('is_recurring', $event->is_recurring) ? '' : 'display: none;' }}">
                            <div class="p-4 bg-gray-50 rounded-md">
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Recurrence Pattern</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Recurrence Type -->
                                    <div>
                                        <label for="recurrence_type" class="block text-sm font-medium text-gray-700">Repeats</label>
                                        <select id="recurrence_type" name="recurrence_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="daily" {{ old('recurrence_type', $event->recurrence_type) == 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="weekly" {{ old('recurrence_type', $event->recurrence_type) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="monthly" {{ old('recurrence_type', $event->recurrence_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        </select>
                                    </div>

                                    <!-- Recurrence Interval -->
                                    <div>
                                        <label for="recurrence_interval" class="block text-sm font-medium text-gray-700">Every</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" min="1" name="recurrence_interval" id="recurrence_interval" value="{{ old('recurrence_interval', $event->recurrence_interval ?? 1) }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-l-md">
                                            <span id="interval-unit" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                {{ old('recurrence_type', $event->recurrence_type) == 'weekly' ? 'week(s)' : (old('recurrence_type', $event->recurrence_type) == 'monthly' ? 'month(s)' : 'day(s)') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- End After -->
                                    <div>
                                        <label for="recurrence_end" class="block text-sm font-medium text-gray-700">Ends After</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" min="1" name="recurrence_end" id="recurrence_end" value="{{ old('recurrence_end', $event->recurrence_end ?? 10) }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-l-md">
                                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                occurrences
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $event->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end space-x-2">
                    <a href="{{ route('academic-calendar.show', $event->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isRecurringCheckbox = document.getElementById('is_recurring');
        const recurringOptions = document.querySelector('.recurring-options');
        const recurrenceType = document.getElementById('recurrence_type');
        const intervalUnit = document.getElementById('interval-unit');

        // Toggle recurring options visibility
        isRecurringCheckbox.addEventListener('change', function() {
            recurringOptions.style.display = this.checked ? 'block' : 'none';
        });

        // Update interval unit text based on recurrence type
        recurrenceType.addEventListener('change', function() {
            switch(this.value) {
                case 'daily':
                    intervalUnit.textContent = 'day(s)';
                    break;
                case 'weekly':
                    intervalUnit.textContent = 'week(s)';
                    break;
                case 'monthly':
                    intervalUnit.textContent = 'month(s)';
                    break;
            }
        });
    });
</script>
@endsection
@endsection
