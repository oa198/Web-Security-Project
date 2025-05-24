<x-ui.card 
    title="Recent Notifications" 
    subtitle="Latest updates and alerts"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('notifications.index') }}" class="text-sm text-purple-600 hover:underline">View All</a>
    </x-slot>
    
    <div class="divide-y divide-gray-100">
        <!-- Notification 1 - Info -->
        <div class="py-3 flex items-start bg-purple-50">
            <div class="mt-0.5 mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <h4 class="font-medium text-gray-900">Course Registration Open</h4>
                    <x-ui.badge variant="info" size="sm">info</x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">Registration for Fall 2023 courses is now open. Please log in to select your courses.</p>
                <p class="text-xs text-gray-500 mt-1">
                    May 20, 2023 09:30 AM
                </p>
            </div>
        </div>
        
        <!-- Notification 2 - Warning -->
        <div class="py-3 flex items-start">
            <div class="mt-0.5 mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <h4 class="font-medium text-gray-900">Assignment Due Soon</h4>
                    <x-ui.badge variant="warning" size="sm">warning</x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">Your Data Structures project is due in 48 hours. Please ensure timely submission.</p>
                <p class="text-xs text-gray-500 mt-1">
                    May 22, 2023 02:15 PM
                </p>
            </div>
        </div>
        
        <!-- Notification 3 - Success -->
        <div class="py-3 flex items-start">
            <div class="mt-0.5 mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <h4 class="font-medium text-gray-900">Grade Posted</h4>
                    <x-ui.badge variant="success" size="sm">success</x-ui.badge>
                </div>
                <p class="text-sm text-gray-700 mt-1">Your Calculus II midterm grade has been posted. You received an A-.</p>
                <p class="text-xs text-gray-500 mt-1">
                    May 18, 2023 11:45 AM
                </p>
            </div>
        </div>
    </div>
</x-ui.card>
