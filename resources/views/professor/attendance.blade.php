@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Attendance Management</h1>
        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded">Professor Dashboard</span>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Course Selection</h2>
            <p class="text-gray-600">Select a course to manage student attendance.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @forelse($courses as $course)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer" 
                 onclick="selectCourse({{ $course->id }})">
                <h3 class="font-medium text-gray-900">{{ $course->name }}</h3>
                <p class="text-sm text-gray-500">{{ $course->code }}</p>
                <div class="mt-2 text-xs text-gray-500">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                        {{ $course->sections->count() }} section(s)
                    </span>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-4 text-gray-500">
                You are not assigned to any courses yet.
            </div>
            @endforelse
        </div>

        @if($courses->isNotEmpty())
        <div id="attendanceSection" class="hidden">
            <div class="mb-4 border-t pt-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Student Attendance</h2>
                <p class="text-gray-600">Manage attendance for <span id="courseName" class="font-medium"></span></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="sectionSelect" class="block text-sm font-medium text-gray-700 mb-1">Select Section</label>
                    <select id="sectionSelect" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                        <option value="">Choose a section</option>
                    </select>
                </div>
                <div>
                    <label for="dateSelect" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="dateSelect" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Late</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody id="studentAttendanceBody" class="bg-white divide-y divide-gray-200">
                        <!-- Student attendance will be populated here via JavaScript -->
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Please select a section to view student attendance.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Save Attendance
                </button>
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Attendance Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Overall Attendance</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2">85%</p>
                <p class="text-xs text-gray-500">Average across all courses</p>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Students with Perfect Attendance</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2">24</p>
                <p class="text-xs text-gray-500">Out of 120 total students</p>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Students with Low Attendance</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2">8</p>
                <p class="text-xs text-gray-500">Below 75% attendance</p>
            </div>
        </div>
    </div>
</div>

<script>
    // This is just a placeholder for the client-side functionality
    function selectCourse(courseId) {
        // In a real implementation, this would fetch the course data and populate the form
        document.getElementById('attendanceSection').classList.remove('hidden');
        
        // Get the course name from the UI (this is just a demo)
        const courseElements = document.querySelectorAll('.border.border-gray-200');
        let courseName = "Selected Course";
        
        courseElements.forEach(element => {
            if (element.onclick.toString().includes(courseId)) {
                courseName = element.querySelector('h3').innerText;
            }
        });
        
        document.getElementById('courseName').innerText = courseName;
        
        // Clear and populate the section dropdown (demo only)
        const sectionSelect = document.getElementById('sectionSelect');
        sectionSelect.innerHTML = '<option value="">Choose a section</option>';
        
        // Add some dummy sections
        for (let i = 1; i <= 3; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.innerText = `Section ${i}`;
            sectionSelect.appendChild(option);
        }
        
        // Update the student attendance table to show a message
        document.getElementById('studentAttendanceBody').innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                    Please select a section to view student attendance.
                </td>
            </tr>
        `;
    }
    
    // Handle section selection
    document.getElementById('sectionSelect')?.addEventListener('change', function() {
        const sectionId = this.value;
        if (!sectionId) return;
        
        // In a real implementation, this would fetch the students in this section
        // For demo purposes, we'll just populate with dummy data
        const students = [
            { id: 'STU1001', name: 'John Doe' },
            { id: 'STU1002', name: 'Jane Smith' },
            { id: 'STU1003', name: 'Robert Johnson' }
        ];
        
        let tableHtml = '';
        students.forEach(student => {
            tableHtml += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${student.name}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${student.id}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="radio" name="attendance_${student.id}" value="present" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="radio" name="attendance_${student.id}" value="late" class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="radio" name="attendance_${student.id}" value="absent" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="text" placeholder="Optional notes" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" style="width: 100%">
                    </td>
                </tr>
            `;
        });
        
        document.getElementById('studentAttendanceBody').innerHTML = tableHtml;
    });
</script>
@endsection
