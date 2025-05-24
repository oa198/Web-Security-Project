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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Create Schedule</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Create New Schedule</h1>
            <p class="mt-2 text-sm text-gray-600">Add a new class schedule to the system.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('schedule.store') }}" method="POST">
                @csrf
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
                        <!-- Course -->
                        <div class="col-span-1">
                            <label for="course_id" class="block text-sm font-medium text-gray-700">Course <span class="text-red-500">*</span></label>
                            <select id="course_id" name="course_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->code }} - {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Academic Term -->
                        <div class="col-span-1">
                            <label for="term_id" class="block text-sm font-medium text-gray-700">Academic Term <span class="text-red-500">*</span></label>
                            <select id="term_id" name="term_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Academic Term</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}" {{ old('term_id') == $term->id ? 'selected' : '' }}>
                                        {{ $term->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Schedule Type -->
                        <div class="col-span-1">
                            <label for="type" class="block text-sm font-medium text-gray-700">Schedule Type <span class="text-red-500">*</span></label>
                            <select id="type" name="type" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Type</option>
                                <option value="lecture" {{ old('type') == 'lecture' ? 'selected' : '' }}>Lecture</option>
                                <option value="lab" {{ old('type') == 'lab' ? 'selected' : '' }}>Laboratory</option>
                                <option value="tutorial" {{ old('type') == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                                <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Examination</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Room -->
                        <div class="col-span-1">
                            <label for="room" class="block text-sm font-medium text-gray-700">Room <span class="text-red-500">*</span></label>
                            <input type="text" name="room" id="room" value="{{ old('room') }}" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g., A-101">
                        </div>

                        <!-- Instructor -->
                        <div class="col-span-1">
                            <label for="instructor_id" class="block text-sm font-medium text-gray-700">Instructor <span class="text-red-500">*</span></label>
                            <select id="instructor_id" name="instructor_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Instructor</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Day of Week -->
                        <div class="col-span-1">
                            <label for="day_of_week" class="block text-sm font-medium text-gray-700">Day of Week <span class="text-red-500">*</span></label>
                            <select id="day_of_week" name="day_of_week" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Day</option>
                                <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Monday</option>
                                <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Tuesday</option>
                                <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Wednesday</option>
                                <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Thursday</option>
                                <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Friday</option>
                                <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Saturday</option>
                                <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Sunday</option>
                            </select>
                        </div>

                        <!-- Start Time -->
                        <div class="col-span-1">
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- End Time -->
                        <div class="col-span-1">
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Schedule for Specific Date (for exams or one-time events) -->
                        <div class="col-span-1">
                            <label for="specific_date" class="block text-sm font-medium text-gray-700">Specific Date</label>
                            <input type="date" name="specific_date" id="specific_date" value="{{ old('specific_date') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">For one-time events only (leave blank for recurring weekly schedule)</p>
                        </div>

                        <!-- Recurring Schedule -->
                        <div class="col-span-1">
                            <div class="flex items-start mt-7">
                                <div class="flex items-center h-5">
                                    <input id="is_recurring" name="is_recurring" type="checkbox" value="1" {{ old('is_recurring', true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_recurring" class="font-medium text-gray-700">Recurring Weekly Schedule</label>
                                    <p class="text-gray-500">This class occurs every week at the specified day and time</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Additional information about this schedule">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end space-x-2">
                    <a href="{{ route('schedule.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const specificDateInput = document.getElementById('specific_date');
        const isRecurringCheck = document.getElementById('is_recurring');

        // Toggle visibility based on schedule type
        typeSelect.addEventListener('change', function() {
            if (this.value === 'exam') {
                specificDateInput.parentElement.classList.remove('hidden');
                isRecurringCheck.checked = false;
                isRecurringCheck.parentElement.parentElement.parentElement.classList.add('hidden');
            } else {
                isRecurringCheck.parentElement.parentElement.parentElement.classList.remove('hidden');
                if (isRecurringCheck.checked) {
                    specificDateInput.value = '';
                    specificDateInput.parentElement.classList.add('hidden');
                } else {
                    specificDateInput.parentElement.classList.remove('hidden');
                }
            }
        });

        // Toggle specific date visibility based on recurring checkbox
        isRecurringCheck.addEventListener('change', function() {
            if (this.checked) {
                specificDateInput.value = '';
                specificDateInput.parentElement.classList.add('hidden');
            } else {
                specificDateInput.parentElement.classList.remove('hidden');
            }
        });

        // Initialize the form state
        if (typeSelect.value === 'exam') {
            isRecurringCheck.checked = false;
            isRecurringCheck.parentElement.parentElement.parentElement.classList.add('hidden');
            specificDateInput.parentElement.classList.remove('hidden');
        } else if (isRecurringCheck.checked) {
            specificDateInput.parentElement.classList.add('hidden');
        }
    });
</script>
@endsection
@endsection
