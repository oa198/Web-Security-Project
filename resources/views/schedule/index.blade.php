@extends('layouts.app')

@section('title', 'Schedule - Student Portal')

@section('page_title', 'Class Schedule')

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
        <!-- View Toggle -->
        <div class="flex gap-2">
            <button
                id="week-view-btn"
                class="px-4 py-2 rounded-lg bg-primary-100 text-primary-800"
                onclick="toggleView('week')"
            >
                Week View
            </button>
            <button
                id="list-view-btn"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600"
                onclick="toggleView('list')"
            >
                List View
            </button>
        </div>

        <!-- Week View -->
        <div id="week-view" class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-20 px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monday</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuesday</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wednesday</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thursday</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Friday</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $timeSlots = [
                            '8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM',
                            '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM',
                            '6:00 PM', '7:00 PM', '8:00 PM'
                        ];
                        
                        // Get current semester's enrollments with sections
                        $enrollments = auth()->user()->student->enrollments()
                            ->with(['section.course'])
                            ->where('status', 'active')
                            ->get();
                        
                        // Create a schedule array
                        $schedule = [];
                        foreach ($timeSlots as $time) {
                            $schedule[$time] = [
                                'Monday' => null,
                                'Tuesday' => null,
                                'Wednesday' => null,
                                'Thursday' => null,
                                'Friday' => null
                            ];
                        }
                        
                        // Fill in the schedule with actual enrollments
                        foreach ($enrollments as $enrollment) {
                            $section = $enrollment->section;
                            $course = $section->course;
                            $days = str_split($section->days);
                            
                            foreach ($days as $day) {
                                $dayName = match($day) {
                                    'M' => 'Monday',
                                    'T' => 'Tuesday',
                                    'W' => 'Wednesday',
                                    'R' => 'Thursday',
                                    'F' => 'Friday',
                                    default => null
                                };
                                
                                if ($dayName && $section->start_time) {
                                    $time = date('g:i A', strtotime($section->start_time));
                                    if (isset($schedule[$time][$dayName])) {
                                        $schedule[$time][$dayName] = [
                                            'course' => $course,
                                            'section' => $section
                                        ];
                                    }
                                }
                            }
                        }
                    @endphp

                    @foreach($timeSlots as $timeSlot)
                    <tr class="border-t border-gray-100">
                        <td class="py-2 align-top text-xs text-gray-500">{{ $timeSlot }}</td>
                        
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <td class="p-1 align-top">
                            @if($schedule[$timeSlot][$day])
                                @php
                                    $course = $schedule[$timeSlot][$day]['course'];
                                    $section = $schedule[$timeSlot][$day]['section'];
                                    $colorClass = match($course->code[0]) {
                                        'C' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'E' => 'bg-green-100 text-green-800 border-green-200',
                                        'M' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'P' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200'
                                    };
                                @endphp
                                <div class="p-1.5 text-xs rounded border {{ $colorClass }}">
                                    <div class="font-medium">{{ $course->code }}</div>
                                    <div class="text-[10px] truncate">{{ $section->room }}</div>
                                </div>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- List View -->
        <div id="list-view" class="space-y-4 hidden">
            <!-- Monday -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Monday</h3>
                <div class="space-y-3">
                    @foreach($enrollments as $enrollment)
                        @if(str_contains($enrollment->section->days, 'M'))
                            @php
                                $course = $enrollment->section->course;
                                $section = $enrollment->section;
                                $colorClass = match($course->code[0]) {
                                    'C' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'E' => 'bg-green-100 text-green-800 border-green-200',
                                    'M' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'P' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <div class="p-3 rounded-lg {{ $colorClass }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $course->title }}</h4>
                                        <p class="text-sm">{{ $course->code }}</p>
                                    </div>
                                    <div class="text-sm">
                                        {{ date('g:i A', strtotime($section->start_time)) }} - {{ date('g:i A', strtotime($section->end_time)) }}
                                    </div>
                                </div>
                                <div class="mt-2 text-sm">
                                    <p>{{ $section->professor->name }}</p>
                                    <p>{{ $section->room }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Tuesday -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tuesday</h3>
                <div class="space-y-3">
                    @foreach($enrollments as $enrollment)
                        @if(str_contains($enrollment->section->days, 'T'))
                            @php
                                $course = $enrollment->section->course;
                                $section = $enrollment->section;
                                $colorClass = match($course->code[0]) {
                                    'C' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'E' => 'bg-green-100 text-green-800 border-green-200',
                                    'M' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'P' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <div class="p-3 rounded-lg {{ $colorClass }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $course->title }}</h4>
                                        <p class="text-sm">{{ $course->code }}</p>
                                    </div>
                                    <div class="text-sm">
                                        {{ date('g:i A', strtotime($section->start_time)) }} - {{ date('g:i A', strtotime($section->end_time)) }}
                                    </div>
                                </div>
                                <div class="mt-2 text-sm">
                                    <p>{{ $section->professor->name }}</p>
                                    <p>{{ $section->room }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Wednesday -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Wednesday</h3>
                <div class="space-y-3">
                    @foreach($enrollments as $enrollment)
                        @if(str_contains($enrollment->section->days, 'W'))
                            @php
                                $course = $enrollment->section->course;
                                $section = $enrollment->section;
                                $colorClass = match($course->code[0]) {
                                    'C' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'E' => 'bg-green-100 text-green-800 border-green-200',
                                    'M' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'P' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <div class="p-3 rounded-lg {{ $colorClass }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $course->title }}</h4>
                                        <p class="text-sm">{{ $course->code }}</p>
                                    </div>
                                    <div class="text-sm">
                                        {{ date('g:i A', strtotime($section->start_time)) }} - {{ date('g:i A', strtotime($section->end_time)) }}
                                    </div>
                                </div>
                                <div class="mt-2 text-sm">
                                    <p>{{ $section->professor->name }}</p>
                                    <p>{{ $section->room }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Thursday -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thursday</h3>
                <div class="space-y-3">
                    @foreach($enrollments as $enrollment)
                        @if(str_contains($enrollment->section->days, 'R'))
                            @php
                                $course = $enrollment->section->course;
                                $section = $enrollment->section;
                                $colorClass = match($course->code[0]) {
                                    'C' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'E' => 'bg-green-100 text-green-800 border-green-200',
                                    'M' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'P' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <div class="p-3 rounded-lg {{ $colorClass }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $course->title }}</h4>
                                        <p class="text-sm">{{ $course->code }}</p>
                                    </div>
                                    <div class="text-sm">
                                        {{ date('g:i A', strtotime($section->start_time)) }} - {{ date('g:i A', strtotime($section->end_time)) }}
                                    </div>
                                </div>
                                <div class="mt-2 text-sm">
                                    <p>{{ $section->professor->name }}</p>
                                    <p>{{ $section->room }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Friday -->
            <div class="bg-white rounded-lg shadow-sm border p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Friday</h3>
                <div class="space-y-3">
                    @foreach($enrollments as $enrollment)
                        @if(str_contains($enrollment->section->days, 'F'))
                            @php
                                $course = $enrollment->section->course;
                                $section = $enrollment->section;
                                $colorClass = match($course->code[0]) {
                                    'C' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'E' => 'bg-green-100 text-green-800 border-green-200',
                                    'M' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'P' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <div class="p-3 rounded-lg {{ $colorClass }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $course->title }}</h4>
                                        <p class="text-sm">{{ $course->code }}</p>
                                    </div>
                                    <div class="text-sm">
                                        {{ date('g:i A', strtotime($section->start_time)) }} - {{ date('g:i A', strtotime($section->end_time)) }}
                                    </div>
                                </div>
                                <div class="mt-2 text-sm">
                                    <p>{{ $section->professor->name }}</p>
                                    <p>{{ $section->room }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function toggleView(view) {
        const weekView = document.getElementById('week-view');
        const listView = document.getElementById('list-view');
        const weekBtn = document.getElementById('week-view-btn');
        const listBtn = document.getElementById('list-view-btn');

        if (view === 'week') {
            weekView.classList.remove('hidden');
            listView.classList.add('hidden');
            weekBtn.classList.remove('bg-gray-100', 'text-gray-600');
            weekBtn.classList.add('bg-primary-100', 'text-primary-800');
            listBtn.classList.remove('bg-primary-100', 'text-primary-800');
            listBtn.classList.add('bg-gray-100', 'text-gray-600');
        } else {
            weekView.classList.add('hidden');
            listView.classList.remove('hidden');
            listBtn.classList.remove('bg-gray-100', 'text-gray-600');
            listBtn.classList.add('bg-primary-100', 'text-primary-800');
            weekBtn.classList.remove('bg-primary-100', 'text-primary-800');
            weekBtn.classList.add('bg-gray-100', 'text-gray-600');
        }
    }
</script>
@endpush
@endsection 