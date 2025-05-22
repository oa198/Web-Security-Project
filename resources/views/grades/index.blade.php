@extends('layouts.app')

@section('title', 'Grades - Student Portal')

@section('page_title', 'Grades')

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
        @php
            // Get grades from database for the authenticated user
            $grades = auth()->user()->student->enrollments()
                ->with(['course', 'grades'])
                ->get()
                ->map(function($enrollment) {
                    return [
                        'courseId' => $enrollment->course->id,
                        'courseCode' => $enrollment->course->code,
                        'courseName' => $enrollment->course->title,
                        'credits' => $enrollment->course->credits,
                        'grade' => $enrollment->grades->first()?->grade ?? 'N/A',
                        'semester' => $enrollment->semester,
                        'year' => $enrollment->academic_year
                    ];
                });

            // Group grades by semester
            $gradesBySemester = [];
            foreach ($grades as $grade) {
                $key = $grade['semester'] . ' ' . $grade['year'];
                if (!isset($gradesBySemester[$key])) {
                    $gradesBySemester[$key] = [];
                }
                $gradesBySemester[$key][] = $grade;
            }

            // Calculate GPA
            function calculateGPA($grades) {
                $gradePoints = [
                    'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
                    'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
                    'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
                    'D+' => 1.3, 'D' => 1.0, 'D-' => 0.7,
                    'F' => 0.0
                ];

                $totalPoints = 0;
                $totalCredits = 0;

                foreach ($grades as $grade) {
                    if ($grade['grade'] !== 'N/A') {
                        $totalPoints += $gradePoints[$grade['grade']] * $grade['credits'];
                        $totalCredits += $grade['credits'];
                    }
                }

                return $totalCredits > 0 ? number_format($totalPoints / $totalCredits, 2) : 0;
            }

            function getGradeColor($grade) {
                if ($grade === 'N/A') return 'bg-gray-100 text-gray-800';
                if (strpos($grade, 'A') === 0) return 'bg-green-100 text-green-800';
                if (strpos($grade, 'B') === 0) return 'bg-primary-100 text-primary-800';
                if (strpos($grade, 'C') === 0) return 'bg-yellow-100 text-yellow-800';
                return 'bg-red-100 text-red-800';
            }
        @endphp

        <!-- GPA Overview -->
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Current GPA</h3>
                    <p class="text-primary-100">Overall academic performance</p>
                </div>
                <div class="text-4xl font-bold">{{ calculateGPA($grades) }}</div>
            </div>
        </div>

        <!-- Grades by Semester -->
        @foreach($gradesBySemester as $semester => $semesterGrades)
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $semester }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4">Course Code</th>
                                <th class="text-left py-3 px-4">Course Name</th>
                                <th class="text-left py-3 px-4">Credits</th>
                                <th class="text-left py-3 px-4">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semesterGrades as $grade)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 px-4">{{ $grade['courseCode'] }}</td>
                                    <td class="py-3 px-4">{{ $grade['courseName'] }}</td>
                                    <td class="py-3 px-4">{{ $grade['credits'] }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ getGradeColor($grade['grade']) }}">
                                            {{ $grade['grade'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <!-- Grade Distribution -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Grade Distribution</h3>
            <div class="relative h-10 bg-gray-200 rounded-full overflow-hidden">
                @php
                    $gradeDistribution = [
                        'A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'F' => 0
                    ];
                    
                    foreach ($grades as $grade) {
                        $letterGrade = substr($grade['grade'], 0, 1);
                        $gradeDistribution[$letterGrade]++;
                    }
                    
                    $totalCourses = count($grades);
                    $percentages = [];
                    
                    if ($totalCourses > 0) {
                        foreach ($gradeDistribution as $grade => $count) {
                            $percentages[$grade] = ($count / $totalCourses) * 100;
                        }
                    } else {
                        // If no grades, set all percentages to 0
                        foreach ($gradeDistribution as $grade => $count) {
                            $percentages[$grade] = 0;
                        }
                    }
                @endphp

                @foreach($percentages as $grade => $percentage)
                    <div class="absolute h-full bg-{{ $grade === 'A' ? 'green' : ($grade === 'B' ? 'blue' : ($grade === 'C' ? 'yellow' : ($grade === 'D' ? 'orange' : 'red'))) }}-500"
                         style="width: {{ $percentage }}%; left: {{ array_sum(array_slice($percentages, 0, array_search($grade, array_keys($percentages)))) }}%">
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between mt-2 text-sm text-gray-600">
                @foreach($gradeDistribution as $grade => $count)
                    <div>
                        {{ $grade }}: {{ $count }} ({{ number_format($percentages[$grade], 1) }}%)
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 