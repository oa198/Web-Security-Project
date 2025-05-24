{{-- Student Management Partial View --}}
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Student Management</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Student List Panel --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h3 class="font-medium text-gray-900 text-lg">Student List</h3>
                
                {{-- Search Input --}}
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Search students..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    />
                </div>
                
                {{-- Student List --}}
                <div class="space-y-2 mt-4">
                    {{-- Sample Student 1 - Active --}}
                    <button
                        onclick="selectStudent('S2023001')"
                        id="student-S2023001"
                        class="w-full flex items-center p-3 rounded-lg transition-colors bg-purple-50 border-purple-200 border"
                    >
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-semibold">
                            AJ
                        </div>
                        <div class="ml-3 text-left">
                            <p class="font-medium text-gray-900">Alex Johnson</p>
                            <p class="text-sm text-gray-500">S2023001</p>
                        </div>
                    </button>

                    {{-- Sample Student 2 --}}
                    <button
                        onclick="selectStudent('S2023002')"
                        id="student-S2023002"
                        class="w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border"
                    >
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                            ED
                        </div>
                        <div class="ml-3 text-left">
                            <p class="font-medium text-gray-900">Emily Davis</p>
                            <p class="text-sm text-gray-500">S2023002</p>
                        </div>
                    </button>

                    {{-- Sample Student 3 --}}
                    <button
                        onclick="selectStudent('S2023003')"
                        id="student-S2023003"
                        class="w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border"
                    >
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold">
                            MB
                        </div>
                        <div class="ml-3 text-left">
                            <p class="font-medium text-gray-900">Michael Brown</p>
                            <p class="text-sm text-gray-500">S2023003</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        {{-- Student Details Panel --}}
        <div class="lg:col-span-2">
            {{-- Student Profile Card --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-semibold text-xl">
                            AJ
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Alex Johnson</h3>
                            <p class="text-gray-500">S2023001</p>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-600">
                                    Department: Computer Science
                                </p>
                                <p class="text-sm text-gray-600">
                                    Enrollment Year: 2022
                                </p>
                                <p class="text-sm text-gray-600">
                                    Credits Completed: 45
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Good Standing
                        </span>
                        <p class="text-sm text-gray-500 text-right">GPA: 3.59</p>
                    </div>
                </div>
            </div>

            {{-- Enrolled Courses Card --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="font-medium text-gray-900 text-lg mb-4">Enrolled Courses</h3>
                <div class="space-y-4">
                    {{-- Course 1 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Introduction to Computer Science</p>
                            <p class="text-sm text-gray-600">CS101 • 3 Credits</p>
                            <p class="text-sm text-gray-500">
                                Mon, Wed • 10:00 - 11:30
                            </p>
                        </div>
                        <button class="px-3 py-1 bg-white border border-red-300 rounded text-red-600 text-sm hover:bg-red-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Drop
                        </button>
                    </div>
                    
                    {{-- Course 2 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Data Structures and Algorithms</p>
                            <p class="text-sm text-gray-600">CS202 • 4 Credits</p>
                            <p class="text-sm text-gray-500">
                                Tue, Thu • 13:00 - 14:30
                            </p>
                        </div>
                        <button class="px-3 py-1 bg-white border border-red-300 rounded text-red-600 text-sm hover:bg-red-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Drop
                        </button>
                    </div>
                    
                    {{-- Course 3 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Calculus II</p>
                            <p class="text-sm text-gray-600">MATH201 • 4 Credits</p>
                            <p class="text-sm text-gray-500">
                                Mon, Wed, Fri • 09:00 - 10:00
                            </p>
                        </div>
                        <button class="px-3 py-1 bg-white border border-red-300 rounded text-red-600 text-sm hover:bg-red-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Drop
                        </button>
                    </div>
                    
                    {{-- Course 4 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Technical Writing</p>
                            <p class="text-sm text-gray-600">ENG105 • 3 Credits</p>
                            <p class="text-sm text-gray-500">
                                Tue, Thu • 15:00 - 16:30
                            </p>
                        </div>
                        <button class="px-3 py-1 bg-white border border-red-300 rounded text-red-600 text-sm hover:bg-red-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Drop
                        </button>
                    </div>
                </div>
            </div>

            {{-- Academic Performance Card --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="font-medium text-gray-900 text-lg mb-4">Academic Performance</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Grade Card 1 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Programming Fundamentals</p>
                            <p class="text-sm text-gray-600">CS100 • Fall 2022</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            A
                        </span>
                    </div>
                    
                    {{-- Grade Card 2 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Calculus I</p>
                            <p class="text-sm text-gray-600">MATH101 • Fall 2022</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            B+
                        </span>
                    </div>
                    
                    {{-- Grade Card 3 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Introduction to Psychology</p>
                            <p class="text-sm text-gray-600">PSYC101 • Fall 2022</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            A-
                        </span>
                    </div>
                    
                    {{-- Grade Card 4 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">English Composition</p>
                            <p class="text-sm text-gray-600">ENG101 • Fall 2022</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            A
                        </span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4">
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Override Registration
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Change Academic Status
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    View Financial Details
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function selectStudent(studentId) {
        // Reset all student buttons
        const studentButtons = document.querySelectorAll('[id^="student-"]');
        studentButtons.forEach(btn => {
            btn.classList.remove('bg-purple-50', 'border-purple-200');
            btn.classList.add('hover:bg-gray-50', 'border-transparent');
        });
        
        // Highlight the selected student
        const selectedButton = document.getElementById(`student-${studentId}`);
        if (selectedButton) {
            selectedButton.classList.remove('hover:bg-gray-50', 'border-transparent');
            selectedButton.classList.add('bg-purple-50', 'border-purple-200');
        }
        
        // In a real application, you would fetch student data here
        // and update the UI with the selected student's information
    }
</script>
