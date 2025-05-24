{{-- Course Management Partial View --}}
<div class="space-y-6">
    {{-- Header with Title and Add Button --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Course Management</h2>
        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center text-sm font-medium transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Course
        </button>
    </div>

    {{-- Course Management Table Card --}}
    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Prerequisites</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Visibility</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Sample Course Row 1 --}}
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 text-sm">CS101</td>
                        <td class="py-3 px-4 text-sm">Introduction to Computer Science</td>
                        <td class="py-3 px-4 text-sm">Dr. Sarah Miller</td>
                        <td class="py-3 px-4 text-sm">3</td>
                        <td class="py-3 px-4 text-sm">30</td>
                        <td class="py-3 px-4 text-sm">None</td>
                        <td class="py-3 px-4 text-sm">
                            <button class="p-1 rounded-full text-green-600 hover:bg-green-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="p-1 text-red-600 hover:bg-red-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    {{-- Sample Course Row 2 --}}
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 text-sm">CS202</td>
                        <td class="py-3 px-4 text-sm">Data Structures and Algorithms</td>
                        <td class="py-3 px-4 text-sm">Prof. James Wilson</td>
                        <td class="py-3 px-4 text-sm">4</td>
                        <td class="py-3 px-4 text-sm">30</td>
                        <td class="py-3 px-4 text-sm">CS101</td>
                        <td class="py-3 px-4 text-sm">
                            <button class="p-1 rounded-full text-green-600 hover:bg-green-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="p-1 text-red-600 hover:bg-red-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Sample Course Row 3 --}}
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 text-sm">MATH201</td>
                        <td class="py-3 px-4 text-sm">Calculus II</td>
                        <td class="py-3 px-4 text-sm">Dr. Emily Chen</td>
                        <td class="py-3 px-4 text-sm">4</td>
                        <td class="py-3 px-4 text-sm">30</td>
                        <td class="py-3 px-4 text-sm">MATH101</td>
                        <td class="py-3 px-4 text-sm">
                            <button class="p-1 rounded-full text-green-600 hover:bg-green-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="p-1 text-red-600 hover:bg-red-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Sample Course Row 4 --}}
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 text-sm">ENG105</td>
                        <td class="py-3 px-4 text-sm">Technical Writing</td>
                        <td class="py-3 px-4 text-sm">Prof. Robert Brown</td>
                        <td class="py-3 px-4 text-sm">3</td>
                        <td class="py-3 px-4 text-sm">30</td>
                        <td class="py-3 px-4 text-sm">None</td>
                        <td class="py-3 px-4 text-sm">
                            <button class="p-1 rounded-full text-green-600 hover:bg-green-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="p-1 text-red-600 hover:bg-red-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Sample Course Row 5 --}}
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 text-sm">PHYS101</td>
                        <td class="py-3 px-4 text-sm">Physics for Engineers</td>
                        <td class="py-3 px-4 text-sm">Dr. Michael Grant</td>
                        <td class="py-3 px-4 text-sm">4</td>
                        <td class="py-3 px-4 text-sm">30</td>
                        <td class="py-3 px-4 text-sm">None</td>
                        <td class="py-3 px-4 text-sm">
                            <button class="p-1 rounded-full text-green-600 hover:bg-green-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="p-1 text-red-600 hover:bg-red-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
