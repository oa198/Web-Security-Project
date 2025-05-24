<x-ui.card 
    title="Recent Notifications" 
    subtitle="Latest updates and alerts"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('notifications.index') }}" class="text-sm text-purple-600 hover:underline">View All</a>
    </x-slot>
    
    @if(isset($notifications) && count($notifications) > 0)
        <div class="divide-y divide-gray-100">
            @foreach($notifications as $notification)
                @php
                    $type = $notification['type'] ?? 'info';
                    $icon = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                    $color = 'text-blue-500';
                    $bgColor = '';
                    
                    if ($type === 'warning') {
                        $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                        $color = 'text-yellow-500';
                    } elseif ($type === 'success') {
                        $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                        $color = 'text-green-500';
                    } elseif ($type === 'error') {
                        $icon = 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z';
                        $color = 'text-red-500';
                    }
                    
                    // Highlight unread notifications
                    if (!$notification['is_read']) {
                        $bgColor = 'bg-purple-50';
                    }
                @endphp
                <div class="py-3 flex items-start {{ $bgColor }}">
                    <div class="mt-0.5 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $color }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <h4 class="font-medium text-gray-900">{{ $notification['title'] }}</h4>
                            <x-ui.badge variant="{{ $type }}" size="sm">{{ $type }}</x-ui.badge>
                        </div>
                        <p class="text-sm text-gray-700 mt-1">{{ $notification['message'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $notification['created_at'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-4 flex flex-col items-center justify-center text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900">No new notifications</h3>
            <p class="text-xs text-gray-500 mt-1">You're all caught up! Check back later for new updates.</p>
        </div>
    @endif
</x-ui.card>
