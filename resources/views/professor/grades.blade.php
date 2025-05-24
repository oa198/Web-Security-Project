@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Grade Management</h1>
        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded">Professor Dashboard</span>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Course Selection</h2>
            <p class="text-gray-600">Select a course to manage student grades.</p>
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
        <div id="gradeSection" class="hidden">
            <div class="mb-4 border-t pt-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Student Grades</h2>
                <p class="text-gray-600">Manage grades for <span id="courseName" class="font-medium"></span></p>
            </div>

            <div class="mb-4">
                <label for="sectionSelect" class="block text-sm font-medium text-gray-700 mb-1">Select Section</label>
                <select id="sectionSelect" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                    <option value="">Choose a section</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Midterm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assignments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Letter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentGradesBody" class="bg-white divide-y divide-gray-200">
                        <!-- Student grades will be populated here via JavaScript -->
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                Please select a section to view student grades.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Save All Grades
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // This is just a placeholder for the client-side functionality
    function selectCourse(courseId) {
        // In a real implementation, this would fetch the course data and populate the form
        document.getElementById('gradeSection').classList.remove('hidden');
        
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
        
        // Update the student grades table to show a message
        document.getElementById('studentGradesBody').innerHTML = `
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                    Please select a section to view student grades.
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
            { id: 'STU1001', name: 'John Doe', midterm: 85, final: 92, assignments: 88 },
            { id: 'STU1002', name: 'Jane Smith', midterm: 78, final: 84, assignments: 90 },
            { id: 'STU1003', name: 'Robert Johnson', midterm: 92, final: 88, assignments: 95 }
        ];
        
        let tableHtml = '';
        students.forEach(student => {
            const total = Math.round((student.midterm * 0.3) + (student.final * 0.4) + (student.assignments * 0.3));
            let letter = 'F';
            if (total >= 90) letter = 'A';
            else if (total >= 80) letter = 'B';
            else if (total >= 70) letter = 'C';
            else if (total >= 60) letter = 'D';
            
            tableHtml += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${student.name}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${student.id}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" value="${student.midterm}" min="0" max="100" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" style="width: 70px">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" value="${student.final}" min="0" max="100" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" style="width: 70px">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" value="${student.assignments}" min="0" max="100" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" style="width: 70px">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${total}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${letter}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-primary-600 hover:text-primary-900">Update</button>
                    </td>
                </tr>
            `;
        });
        
        document.getElementById('studentGradesBody').innerHTML = tableHtml;
    });
</script>
@endsection
