<x-ui.card 
    title="Current Courses" 
    subtitle="4 courses this semester"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('courses.index') }}" class="text-sm text-purple-600 hover:underline">View All</a>
    </x-slot>
    
    <div class="space-y-4">
        <!-- Course 1 -->
        <div class="flex items-start">
            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">Introduction to Computer Science</h4>
                        <p class="text-xs text-gray-500 mt-0.5">
                            CS101 • 3 Credits
                        </p>
                    </div>
                    <x-ui.badge variant="primary" size="sm">
                        Computer Science
                    </x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">
                    Instructor: Dr. Sarah Miller
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    Mon, Wed • 10:00 - 11:30 • Science Building 305
                </p>
            </div>
        </div>
        
        <!-- Course 2 -->
        <div class="flex items-start">
            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">Data Structures and Algorithms</h4>
                        <p class="text-xs text-gray-500 mt-0.5">
                            CS202 • 4 Credits
                        </p>
                    </div>
                    <x-ui.badge variant="primary" size="sm">
                        Computer Science
                    </x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">
                    Instructor: Prof. James Wilson
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    Tue, Thu • 13:00 - 14:30 • Tech Building 405
                </p>
            </div>
        </div>
        
        <!-- Course 3 -->
        <div class="flex items-start">
            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">Calculus II</h4>
                        <p class="text-xs text-gray-500 mt-0.5">
                            MATH201 • 4 Credits
                        </p>
                    </div>
                    <x-ui.badge variant="info" size="sm">
                        Mathematics
                    </x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">
                    Instructor: Dr. Emily Chen
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    Mon, Wed, Fri • 09:00 - 10:00 • Math Building 201
                </p>
            </div>
        </div>
        
        <!-- Course 4 -->
        <div class="flex items-start">
            <div class="p-2 bg-green-100 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">Technical Writing</h4>
                        <p class="text-xs text-gray-500 mt-0.5">
                            ENG105 • 3 Credits
                        </p>
                    </div>
                    <x-ui.badge variant="success" size="sm">
                        English
                    </x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">
                    Instructor: Prof. Robert Brown
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    Tue, Thu • 15:00 - 16:30 • Humanities 102
                </p>
            </div>
        </div>
    </div>
</x-ui.card>
