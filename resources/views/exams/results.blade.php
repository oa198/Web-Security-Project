@extends('layouts.main')

@section('title', 'Exam Results - Student Portal')

@section('page-title', 'Exam Results')

@section('content')
<div class="mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $exam['title'] ?? 'Midterm Examination' }}</h2>
            <p class="text-gray-600 mt-1">{{ $exam['course_name'] ?? 'Database Systems' }} ({{ $exam['course_code'] ?? 'CS3200' }})</p>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('exams.show', $exam['id'] ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Back to Exam
            </a>
            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Results
            </a>
        </div>
    </div>
</div>

<!-- Results Summary Card -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Results Summary</h3>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Score -->
            <div class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-lg">
                @php
                    $score = $exam['score'] ?? 85;
                    $total = $exam['total'] ?? 100;
                    $percentage = ($score / $total) * 100;
                    
                    if ($percentage >= 90) {
                        $gradeClass = 'text-green-600';
                        $grade = 'A';
                    } elseif ($percentage >= 80) {
                        $gradeClass = 'text-blue-600';
                        $grade = 'B';
                    } elseif ($percentage >= 70) {
                        $gradeClass = 'text-yellow-600';
                        $grade = 'C';
                    } elseif ($percentage >= 60) {
                        $gradeClass = 'text-orange-600';
                        $grade = 'D';
                    } else {
                        $gradeClass = 'text-red-600';
                        $grade = 'F';
                    }
                @endphp
                
                <div class="relative">
                    <svg class="w-32 h-32" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background circle -->
                        <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="2"></circle>
                        
                        <!-- Progress circle -->
                        <circle 
                            cx="18" 
                            cy="18" 
                            r="16" 
                            fill="none" 
                            stroke="{{ $percentage >= 90 ? '#059669' : ($percentage >= 80 ? '#2563eb' : ($percentage >= 70 ? '#d97706' : ($percentage >= 60 ? '#ea580c' : '#dc2626'))) }}" 
                            stroke-width="2" 
                            stroke-dasharray="100" 
                            stroke-dashoffset="{{ 100 - $percentage }}" 
                            transform="rotate(-90 18 18)"
                        ></circle>
                        
                        <!-- Text in the middle -->
                        <text x="18" y="18" text-anchor="middle" dy=".3em" font-size="10" fill="#374151" font-weight="bold">{{ round($percentage) }}%</text>
                    </svg>
                    
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 mt-6">
                        <span class="text-4xl font-bold {{ $gradeClass }}">{{ $grade }}</span>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-lg font-semibold text-gray-900">{{ $score }}/{{ $total }} points</p>
                    <p class="text-sm text-gray-500">Completed on {{ \Carbon\Carbon::parse($exam['completed_date'] ?? '2023-06-15')->format('M d, Y') }}</p>
                </div>
            </div>
            
            <!-- Performance by Section -->
            <div class="col-span-2">
                <h4 class="font-medium text-gray-900 mb-4">Performance by Section</h4>
                
                <div class="space-y-4">
                    @foreach($exam['sections'] ?? [
                        ['name' => 'Multiple Choice', 'score' => 32, 'total' => 40, 'weight' => 40],
                        ['name' => 'Short Answer', 'score' => 25, 'total' => 30, 'weight' => 30],
                        ['name' => 'SQL Queries', 'score' => 18, 'total' => 20, 'weight' => 20],
                        ['name' => 'Database Design', 'score' => 10, 'total' => 10, 'weight' => 10]
                    ] as $section)
                        @php
                            $sectionPercentage = ($section['score'] / $section['total']) * 100;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">{{ $section['name'] }}</span>
                                    <span class="text-xs text-gray-500 ml-2">({{ $section['weight'] }}%)</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $section['score'] }}/{{ $section['total'] }} ({{ round($sectionPercentage) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full {{ $sectionPercentage >= 90 ? 'bg-green-600' : ($sectionPercentage >= 80 ? 'bg-blue-600' : ($sectionPercentage >= 70 ? 'bg-yellow-600' : ($sectionPercentage >= 60 ? 'bg-orange-600' : 'bg-red-600'))) }}" style="width: {{ $sectionPercentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    <h4 class="font-medium text-gray-900 mb-3">Instructor Feedback</h4>
                    <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-700">
                        <p>{{ $exam['feedback'] ?? 'You demonstrated a solid understanding of database concepts, particularly in database design and normalization. Your SQL queries were generally correct, but there were a few issues with complex joins and subqueries. Focus on improving your understanding of transaction management concepts for the final exam. Overall, this is a strong performance that shows good progress in the course.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Class Performance -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Class Performance</h3>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Score Distribution</h4>
                <div class="h-64 flex items-end space-x-2">
                    @foreach($exam['distribution'] ?? [2, 5, 8, 15, 25, 20, 12, 8, 3, 2] as $index => $count)
                        @php
                            $percentage = ($count / max($exam['distribution'] ?? [2, 5, 8, 15, 25, 20, 12, 8, 3, 2])) * 100;
                            $range = ($index * 10) . '-' . (($index + 1) * 10);
                            
                            if ($index == 0) $range = '0-10';
                            if ($index == 9) $range = '90-100';
                            
                            // Determine if current student's score falls in this range
                            $studentScoreInRange = false;
                            $studentPercentage = ($score / $total) * 100;
                            $rangeStart = $index * 10;
                            $rangeEnd = ($index + 1) * 10;
                            
                            if ($studentPercentage >= $rangeStart && $studentPercentage < $rangeEnd) {
                                $studentScoreInRange = true;
                            }
                            // Special case for 90-100
                            if ($index == 9 && $studentPercentage >= 90) {
                                $studentScoreInRange = true;
                            }
                        @endphp
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-full bg-{{ $studentScoreInRange ? 'primary' : 'gray' }}-200 rounded-t-md relative" style="height: {{ $percentage }}%">
                                <div class="w-full bg-{{ $studentScoreInRange ? 'primary' : 'gray' }}-500 rounded-t-md absolute bottom-0" style="height: {{ $percentage * 0.9 }}%"></div>
                                @if($studentScoreInRange)
                                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $range }}</div>
                            <div class="text-xs text-gray-700">{{ $count }}</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 flex justify-between text-sm text-gray-500">
                    <div>Score Range (%)</div>
                    <div>Number of Students</div>
                </div>
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Statistics</h4>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Class Average:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $exam['class_avg'] ?? '78' }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Median Score:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $exam['median'] ?? '80' }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Highest Score:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $exam['highest'] ?? '98' }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Lowest Score:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $exam['lowest'] ?? '45' }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Standard Deviation:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $exam['std_dev'] ?? '12.5' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Your Percentile:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $exam['percentile'] ?? '75' }}th</span>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Your score is {{ $percentage > $exam['class_avg'] ? 'above' : 'below' }} the class average by {{ abs(round($percentage - ($exam['class_avg'] ?? 78))) }} percentage points.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Answers -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Detailed Answers</h3>
        <div>
            <select class="text-sm border-gray-300 rounded-md">
                <option>All Questions</option>
                <option>Multiple Choice</option>
                <option>Short Answer</option>
                <option>SQL Queries</option>
                <option>Database Design</option>
                <option>Incorrect Only</option>
            </select>
        </div>
    </div>
    
    <div class="divide-y divide-gray-200">
        @foreach($exam['questions'] ?? [
            [
                'number' => 1, 
                'type' => 'Multiple Choice', 
                'text' => 'Which normal form deals with transitive dependencies?',
                'options' => ['1NF', '2NF', '3NF', '4NF'],
                'correct' => 2,
                'student_answer' => 2,
                'points' => 4,
                'earned' => 4,
                'explanation' => 'Third Normal Form (3NF) deals with transitive dependencies by requiring that all attributes be functionally dependent only on the primary key.'
            ],
            [
                'number' => 2, 
                'type' => 'Multiple Choice', 
                'text' => 'Which SQL statement is used to create a new database?',
                'options' => ['CREATE DB', 'CREATE DATABASE', 'NEW DATABASE', 'MAKE DATABASE'],
                'correct' => 1,
                'student_answer' => 1,
                'points' => 4,
                'earned' => 4,
                'explanation' => 'CREATE DATABASE is the correct SQL statement to create a new database.'
            ],
            [
                'number' => 3, 
                'type' => 'Short Answer', 
                'text' => 'Explain the difference between INNER JOIN and LEFT JOIN in SQL.',
                'correct_answer' => 'INNER JOIN returns only the matching rows between tables, while LEFT JOIN returns all rows from the left table and matching rows from the right table.',
                'student_answer' => 'INNER JOIN only returns rows that match in both tables. LEFT JOIN returns all rows from the left table and matching rows from the right table, with NULL values for non-matching right table columns.',
                'points' => 6,
                'earned' => 6,
                'feedback' => 'Excellent explanation that clearly differentiates between the two join types.'
            ],
            [
                'number' => 4, 
                'type' => 'SQL Query', 
                'text' => 'Write a SQL query to retrieve the names of all students who have a GPA greater than 3.5 and are enrolled in at least one Computer Science course.',
                'correct_answer' => "SELECT DISTINCT s.name FROM students s JOIN enrollments e ON s.id = e.student_id JOIN courses c ON e.course_id = c.id WHERE s.gpa > 3.5 AND c.department = 'Computer Science';",
                'student_answer' => "SELECT s.name FROM students s JOIN enrollments e ON s.id = e.student_id JOIN courses c ON e.course_id = c.id WHERE s.gpa > 3.5 AND c.department = 'Computer Science';",
                'points' => 8,
                'earned' => 7,
                'feedback' => 'Your query is mostly correct, but you forgot to use DISTINCT which could result in duplicate student names if a student is enrolled in multiple CS courses.'
            ]
        ] as $question)
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <span class="font-medium text-gray-900">Question {{ $question['number'] }}</span>
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $question['earned'] == $question['points'] ? 'bg-green-100 text-green-800' : ($question['earned'] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $question['type'] }}
                            </span>
                        </div>
                        
                        <p class="text-gray-700 mb-4">{{ $question['text'] }}</p>
                        
                        @if(isset($question['options']))
                            <div class="space-y-2 mb-4">
                                @foreach($question['options'] as $index => $option)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-5 w-5 rounded-full border {{ $index === $question['correct'] ? 'bg-green-100 border-green-500' : ($index === $question['student_answer'] && $index !== $question['correct'] ? 'bg-red-100 border-red-500' : 'border-gray-300') }} flex items-center justify-center">
                                            @if($index === $question['correct'])
                                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            @elseif($index === $question['student_answer'] && $index !== $question['correct'])
                                                <svg class="h-3 w-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="ml-2 text-sm {{ $index === $question['correct'] ? 'text-green-700 font-medium' : ($index === $question['student_answer'] && $index !== $question['correct'] ? 'text-red-700' : 'text-gray-700') }}">
                                            {{ $option }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="mb-2">
                                    <h5 class="text-sm font-medium text-gray-700">Your Answer:</h5>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm text-gray-800">
                                        {{ $question['student_answer'] }}
                                    </div>
                                </div>
                                
                                <div>
                                    <h5 class="text-sm font-medium text-gray-700">Correct Answer:</h5>
                                    <div class="mt-1 p-3 bg-green-50 rounded-md text-sm text-gray-800">
                                        {{ $question['correct_answer'] }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 p-3 {{ $question['earned'] == $question['points'] ? 'bg-green-50 border-l-4 border-green-500' : ($question['earned'] > 0 ? 'bg-yellow-50 border-l-4 border-yellow-500' : 'bg-red-50 border-l-4 border-red-500') }} rounded-r-md">
                            <h5 class="text-sm font-medium {{ $question['earned'] == $question['points'] ? 'text-green-800' : ($question['earned'] > 0 ? 'text-yellow-800' : 'text-red-800') }}">
                                Feedback:
                            </h5>
                            <p class="text-sm {{ $question['earned'] == $question['points'] ? 'text-green-700' : ($question['earned'] > 0 ? 'text-yellow-700' : 'text-red-700') }}">
                                {{ $question['explanation'] ?? $question['feedback'] }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="ml-6 flex-shrink-0 text-right">
                        <div class="text-2xl font-bold {{ $question['earned'] == $question['points'] ? 'text-green-600' : ($question['earned'] > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $question['earned'] }}/{{ $question['points'] }}
                        </div>
                        <div class="text-sm text-gray-500">points</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="px-6 py-4 bg-gray-50 border-t">
        <div class="flex justify-between items-center">
            <div class="flex space-x-2">
                <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Previous
                </button>
                <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Next
                </button>
            </div>
            
            <div class="text-sm text-gray-500">
                Showing 1-4 of 40 questions
            </div>
        </div>
    </div>
</div>

<style>
    circle {
        transition: stroke-dashoffset 1s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for the progress circle
        const circle = document.querySelector('circle:nth-child(2)');
        const originalOffset = circle.getAttribute('stroke-dashoffset');
        
        circle.setAttribute('stroke-dashoffset', '100');
        setTimeout(() => {
            circle.setAttribute('stroke-dashoffset', originalOffset);
        }, 500);
    });
</script>
@endsection 