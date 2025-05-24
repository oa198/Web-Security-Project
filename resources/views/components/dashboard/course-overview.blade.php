<x-ui.card 
    title="Current Courses" 
    subtitle="Enrolled courses this semester"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('courses.index') }}" class="text-sm text-purple-600 hover:underline">View All</a>
    </x-slot>
    
    <div class="space-y-4">
        @if(isset($courses) && count($courses) > 0)
            @foreach($courses as $course)
            <div class="flex items-start">
                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $course->name ?? 'Course Name' }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $course->code ?? 'Course Code' }} • {{ $course->credits ?? '0' }} Credits
                            </p>
                        </div>
                        <x-ui.badge variant="primary" size="sm">
                            {{ $course->department->name ?? 'Department' }}
                        </x-ui.badge>
                    </div>
                    <p class="text-sm text-gray-700 mt-1">
                        Instructor: {{ $course->instructor->name ?? 'Instructor Name' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $course->schedule ?? 'Schedule Information' }} • {{ $course->location ?? 'Location' }}
                    </p>
                </div>
            </div>
            @endforeach
        @else
            <div class="p-4 flex flex-col items-center justify-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-sm font-medium text-gray-900">No courses found</h3>
                <p class="text-xs text-gray-500 mt-1">You don't have any enrolled courses for this semester.</p>
            </div>
        @endif
    </div>
</x-ui.card>
