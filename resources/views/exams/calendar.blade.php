@extends('layouts.main')

@section('title', 'Exam Calendar - Student Portal')

@section('page-title', 'Exam Calendar')

@section('content')
<div class="mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Exam Schedule</h2>
            <p class="text-gray-600 mt-1">
                View and manage your upcoming exams and assessments
            </p>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('exams.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Back to Exams
            </a>
            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Calendar
            </a>
        </div>
    </div>
</div>

<!-- Calendar Navigation -->
<div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
    <div class="flex flex-wrap items-center justify-between">
        <div class="flex items-center space-x-2">
            <button type="button" id="prev-month" class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <h3 class="text-lg font-semibold text-gray-900" id="current-month">June 2023</h3>
            
            <button type="button" id="next-month" class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <button type="button" id="today-btn" class="ml-4 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Today
            </button>
        </div>
        
        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
            <button type="button" data-view="month" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 view-btn active-view">
                Month
            </button>
            <button type="button" data-view="week" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 view-btn">
                Week
            </button>
            <button type="button" data-view="list" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 view-btn">
                List
            </button>
        </div>
    </div>
</div>

<!-- Month View -->
<div id="month-view" class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <!-- Days of Week Header -->
    <div class="grid grid-cols-7 gap-px bg-gray-200 border-b">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="bg-gray-50 p-2 text-center text-sm font-medium text-gray-500">
                {{ $day }}
            </div>
        @endforeach
    </div>
    
    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 grid-rows-5 gap-px bg-gray-200">
        @php
            // Sample data for demonstration
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $currentMonth = \Carbon\Carbon::now()->month;
            $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
            $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth()->dayOfWeek;
            
            // Sample exams data
            $exams = [
                [
                    'id' => 1,
                    'title' => 'Midterm Exam',
                    'course' => 'Database Systems',
                    'date' => \Carbon\Carbon::now()->addDays(5)->format('Y-m-d'),
                    'time' => '10:00 AM',
                    'type' => 'In-Person',
                    'color' => 'bg-red-100 text-red-800 border-red-200'
                ],
                [
                    'id' => 2,
                    'title' => 'Final Project',
                    'course' => 'Web Development',
                    'date' => \Carbon\Carbon::now()->addDays(12)->format('Y-m-d'),
                    'time' => '2:00 PM',
                    'type' => 'Online',
                    'color' => 'bg-blue-100 text-blue-800 border-blue-200'
                ],
                [
                    'id' => 3,
                    'title' => 'Quiz 3',
                    'course' => 'Computer Networks',
                    'date' => \Carbon\Carbon::now()->addDays(3)->format('Y-m-d'),
                    'time' => '9:30 AM',
                    'type' => 'In-Person',
                    'color' => 'bg-amber-100 text-amber-800 border-amber-200'
                ],
                [
                    'id' => 4,
                    'title' => 'Final Exam',
                    'course' => 'Software Engineering',
                    'date' => \Carbon\Carbon::now()->addDays(20)->format('Y-m-d'),
                    'time' => '1:00 PM',
                    'type' => 'In-Person',
                    'color' => 'bg-green-100 text-green-800 border-green-200'
                ]
            ];
            
            // Group exams by date
            $examsByDate = [];
            foreach ($exams as $exam) {
                if (!isset($examsByDate[$exam['date']])) {
                    $examsByDate[$exam['date']] = [];
                }
                $examsByDate[$exam['date']][] = $exam;
            }
        @endphp
        
        @for($i = 0; $i < 35; $i++)
            @php
                $day = $i - $firstDayOfMonth + 1;
                $isCurrentMonth = $day > 0 && $day <= $daysInMonth;
                $date = \Carbon\Carbon::now()->setDay($isCurrentMonth ? $day : 1)->format('Y-m-d');
                if (!$isCurrentMonth && $day > $daysInMonth) {
                    $date = \Carbon\Carbon::now()->addMonth()->setDay($day - $daysInMonth)->format('Y-m-d');
                } elseif (!$isCurrentMonth) {
                    $date = \Carbon\Carbon::now()->subMonth()->endOfMonth()->subDays($firstDayOfMonth - $i - 1)->format('Y-m-d');
                }
                $isToday = $date === $today;
                $hasExams = isset($examsByDate[$date]);
            @endphp
            
            <div class="min-h-[120px] bg-white p-1 {{ !$isCurrentMonth ? 'bg-gray-50' : '' }}">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm {{ $isToday ? 'font-bold text-primary-600' : (!$isCurrentMonth ? 'text-gray-400' : 'text-gray-700') }}">
                        {{ $day > 0 ? ($day <= $daysInMonth ? $day : $day - $daysInMonth) : \Carbon\Carbon::now()->subMonth()->endOfMonth()->subDays($firstDayOfMonth - $i - 1)->day }}
                    </span>
                    
                    @if($isToday)
                        <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary-600 text-xs font-medium text-white">
                            Today
                        </span>
                    @endif
                </div>
                
                <div class="space-y-1">
                    @if($hasExams)
                        @foreach($examsByDate[$date] as $exam)
                            <a href="{{ route('exams.show', $exam['id']) }}" class="block px-2 py-1 rounded-md text-xs {{ $exam['color'] }} border truncate">
                                <div class="font-medium">{{ $exam['title'] }}</div>
                                <div>{{ $exam['time'] }} · {{ $exam['type'] }}</div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        @endfor
    </div>
</div>

<!-- Week View (Initially Hidden) -->
<div id="week-view" class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6 hidden">
    <div class="p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900" id="current-week">June 5 - June 11, 2023</h3>
    </div>
    
    <div class="grid grid-cols-8 gap-px bg-gray-200">
        <!-- Time Column -->
        <div class="bg-white">
            <div class="h-12 border-b"></div> <!-- Empty cell for header alignment -->
            @for($hour = 8; $hour <= 20; $hour++)
                <div class="h-16 flex items-center justify-center border-b">
                    <span class="text-xs text-gray-500">{{ $hour % 12 ?: 12 }}:00 {{ $hour >= 12 ? 'PM' : 'AM' }}</span>
                </div>
            @endfor
        </div>
        
        <!-- Days Columns -->
        @php
            $today = \Carbon\Carbon::now();
            $startOfWeek = $today->copy()->startOfWeek();
        @endphp
        
        @for($day = 0; $day < 7; $day++)
            @php
                $currentDay = $startOfWeek->copy()->addDays($day);
                $isToday = $currentDay->isToday();
                $dayExams = [];
                
                // Find exams for this day
                foreach ($exams as $exam) {
                    if ($exam['date'] === $currentDay->format('Y-m-d')) {
                        $dayExams[] = $exam;
                    }
                }
            @endphp
            
            <div class="bg-white">
                <!-- Day Header -->
                <div class="h-12 flex flex-col items-center justify-center border-b {{ $isToday ? 'bg-primary-50' : '' }}">
                    <span class="text-xs font-medium {{ $isToday ? 'text-primary-600' : 'text-gray-500' }}">
                        {{ $currentDay->format('D') }}
                    </span>
                    <span class="text-sm font-semibold {{ $isToday ? 'text-primary-600' : 'text-gray-900' }}">
                        {{ $currentDay->format('j') }}
                    </span>
                </div>
                
                <!-- Time Slots -->
                <div class="relative">
                    @for($hour = 8; $hour <= 20; $hour++)
                        <div class="h-16 border-b"></div>
                    @endfor
                    
                    <!-- Exams for this day -->
                    @foreach($dayExams as $exam)
                        @php
                            // Calculate position based on time
                            $examTime = \Carbon\Carbon::parse($exam['time']);
                            $hour = $examTime->hour;
                            $minute = $examTime->minute;
                            $top = (($hour - 8) * 64) + ($minute / 60 * 64); // 64px per hour
                            $height = 64; // Default 1 hour height
                        @endphp
                        
                        <div class="absolute left-0 right-0 mx-1 p-1 rounded-md {{ $exam['color'] }} border" style="top: {{ $top }}px; height: {{ $height }}px;">
                            <div class="text-xs font-medium truncate">{{ $exam['title'] }}</div>
                            <div class="text-xs truncate">{{ $exam['time'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endfor
    </div>
</div>

<!-- List View (Initially Hidden) -->
<div id="list-view" class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6 hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Upcoming Exams</h3>
    </div>
    
    <div class="divide-y divide-gray-200">
        @if(count($exams) > 0)
            @php
                // Sort exams by date
                usort($exams, function($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });
            @endphp
            
            @foreach($exams as $exam)
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $exam['title'] }}</h4>
                                <span class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium {{ str_replace('bg-', 'bg-', $exam['color']) }}">
                                    {{ $exam['type'] }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600">{{ $exam['course'] }}</p>
                            
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($exam['date'])->format('l, F j, Y') }} at {{ $exam['time'] }}
                            </div>
                        </div>
                        
                        <div class="ml-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('exams.show', $exam['id']) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    View Details
                                </a>
                                <a href="{{ route('exams.prepare', $exam['id']) }}" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Prepare
                                </a>
                            </div>
                            
                            <div class="mt-2 text-sm text-gray-500 text-right">
                                @php
                                    $daysUntil = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($exam['date']));
                                @endphp
                                
                                @if($daysUntil === 0)
                                    <span class="font-medium text-red-600">Today</span>
                                @else
                                    <span class="font-medium {{ $daysUntil <= 7 ? 'text-amber-600' : 'text-gray-600' }}">
                                        {{ $daysUntil }} days away
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">No upcoming exams found.</p>
            </div>
        @endif
    </div>
</div>

<!-- Legend -->
<div class="bg-white rounded-lg shadow-sm border p-4">
    <h3 class="text-sm font-medium text-gray-700 mb-3">Exam Types</h3>
    <div class="flex flex-wrap gap-4">
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
            <span class="text-sm text-gray-600">Midterm Exams</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
            <span class="text-sm text-gray-600">Final Projects</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-amber-500 mr-2"></div>
            <span class="text-sm text-gray-600">Quizzes</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
            <span class="text-sm text-gray-600">Final Exams</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View switching
        const viewButtons = document.querySelectorAll('.view-btn');
        const views = {
            'month': document.getElementById('month-view'),
            'week': document.getElementById('week-view'),
            'list': document.getElementById('list-view')
        };
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const viewType = this.getAttribute('data-view');
                
                // Update active button
                viewButtons.forEach(btn => {
                    btn.classList.remove('bg-primary-600', 'text-white');
                    btn.classList.remove('active-view');
                    btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                });
                
                this.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                this.classList.add('bg-primary-600', 'text-white', 'border-transparent', 'active-view');
                
                // Show selected view, hide others
                Object.keys(views).forEach(key => {
                    if (key === viewType) {
                        views[key].classList.remove('hidden');
                    } else {
                        views[key].classList.add('hidden');
                    }
                });
            });
        });
        
        // Month navigation
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        const currentMonthEl = document.getElementById('current-month');
        const todayBtn = document.getElementById('today-btn');
        
        let currentDate = new Date();
        updateMonthDisplay();
        
        prevMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateMonthDisplay();
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateMonthDisplay();
        });
        
        todayBtn.addEventListener('click', function() {
            currentDate = new Date();
            updateMonthDisplay();
        });
        
        function updateMonthDisplay() {
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
            
            // In a real application, you would also update the calendar grid here
        }
    });
</script>
@endsection 