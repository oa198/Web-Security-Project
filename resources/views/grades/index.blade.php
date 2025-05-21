@extends('layouts.app')

@section('title', 'Grades - Student Portal')

@section('page_title', 'Grades')

@section('content')
<div class="space-y-6">
    <!-- Sample Grades Data - Replace with dynamic data in a real application -->
    @php
        $grades = [
            [
                'courseId' => 1,
                'courseCode' => 'CS 4750',
                'courseName' => 'Database Systems',
                'credits' => 4,
                'grade' => 'A',
                'semester' => 'Fall',
                'year' => '2023'
            ],
            [
                'courseId' => 2,
                'courseCode' => 'CS 3240',
                'courseName' => 'Web Development',
                'credits' => 3,
                'grade' => 'B+',
                'semester' => 'Fall',
                'year' => '2023'
            ],
            [
                'courseId' => 3,
                'courseCode' => 'CS 2150',
                'courseName' => 'Data Structures',
                'credits' => 4,
                'grade' => 'A-',
                'semester' => 'Spring',
                'year' => '2023'
            ],
            [
                'courseId' => 4,
                'courseCode' => 'CS 3140',
                'courseName' => 'Software Engineering',
                'credits' => 3,
                'grade' => 'B',
                'semester' => 'Spring',
                'year' => '2023'
            ],
            [
                'courseId' => 5,
                'courseCode' => 'CS 2110',
                'courseName' => 'Computer Organization',
                'credits' => 3,
                'grade' => 'A',
                'semester' => 'Fall',
                'year' => '2022'
            ],
            [
                'courseId' => 6,
                'courseCode' => 'MATH 3351',
                'courseName' => 'Linear Algebra',
                'credits' => 3,
                'grade' => 'B-',
                'semester' => 'Fall',
                'year' => '2022'
            ]
        ];

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
                $totalPoints += $gradePoints[$grade['grade']] * $grade['credits'];
                $totalCredits += $grade['credits'];
            }

            return number_format($totalPoints / $totalCredits, 2);
        }

        function getGradeColor($grade) {
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
                $percentages = [
                    'A' => ($gradeDistribution['A'] / $totalCourses) * 100,
                    'B' => ($gradeDistribution['B'] / $totalCourses) * 100,
                    'C' => ($gradeDistribution['C'] / $totalCourses) * 100,
                    'D' => ($gradeDistribution['D'] / $totalCourses) * 100,
                    'F' => ($gradeDistribution['F'] / $totalCourses) * 100
                ];
            @endphp
            <div class="absolute top-0 left-0 h-full bg-green-500" style="width: {{ $percentages['A'] }}%"></div>
            <div class="absolute top-0 left-{{ $percentages['A'] }}% h-full bg-primary-500" style="width: {{ $percentages['B'] }}%"></div>
            <div class="absolute top-0 left-{{ $percentages['A'] + $percentages['B'] }}% h-full bg-yellow-500" style="width: {{ $percentages['C'] }}%"></div>
            <div class="absolute top-0 left-{{ $percentages['A'] + $percentages['B'] + $percentages['C'] }}% h-full bg-orange-500" style="width: {{ $percentages['D'] }}%"></div>
            <div class="absolute top-0 left-{{ $percentages['A'] + $percentages['B'] + $percentages['C'] + $percentages['D'] }}% h-full bg-red-500" style="width: {{ $percentages['F'] }}%"></div>
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-500">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                <span>A ({{ $gradeDistribution['A'] }})</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-primary-500 rounded-full mr-1"></div>
                <span>B ({{ $gradeDistribution['B'] }})</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></div>
                <span>C ({{ $gradeDistribution['C'] }})</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-orange-500 rounded-full mr-1"></div>
                <span>D ({{ $gradeDistribution['D'] }})</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                <span>F ({{ $gradeDistribution['F'] }})</span>
            </div>
        </div>
    </div>
</div>
@endsection 