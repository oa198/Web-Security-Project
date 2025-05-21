<header class="bg-white shadow-sm border-b lg:border-0">
    <div class="flex items-center justify-between p-4">
        <!-- Mobile Menu Button -->
        <button class="lg:hidden" id="open-sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Page Title -->
        <h1 class="text-xl font-semibold text-gray-900 hidden lg:block">@yield('page_title', 'Dashboard')</h1>
        
        <div class="flex items-center">
            <!-- Search -->
            <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="query" placeholder="Search..." class="bg-transparent border-none focus:outline-none ml-2 w-48">
            </form>
            
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="absolute top-1 right-1 w-5 h-5 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">
                        {{ $unreadNotificationsCount }}
                    </span>
                    @else
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>
                
                <!-- Notification Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200" style="display: none;">
                    <div class="px-4 py-2 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                    </div>
                    
                    @if(isset($notifications) && count($notifications) > 0)
                        <div class="max-h-80 overflow-y-auto">
                            @foreach($notifications->take(5) as $notification)
                                <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 {{ $notification->read_at ? '' : 'bg-purple-50' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->data['message'] ?? $notification->data['body'] ?? '' }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ 
                                            isset($notification->data['type']) ? 
                                                ($notification->data['type'] == 'success' ? 'bg-green-100 text-green-800' : 
                                                ($notification->data['type'] == 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                                                ($notification->data['type'] == 'error' ? 'bg-red-100 text-red-800' : 
                                                'bg-blue-100 text-blue-800'))) 
                                            : 'bg-blue-100 text-blue-800' 
                                        }}">
                                            {{ $notification->data['type'] ?? 'info' }}
                                        </span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1">
                                        {{ $notification->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-4 py-5 text-center">
                            <p class="text-sm text-gray-500">No notifications yet</p>
                        </div>
                    @endif
                    
                    <div class="px-4 py-2 border-t border-gray-200">
                        <a href="{{ route('notifications.index') }}" class="text-xs text-primary-600 hover:underline">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Profile -->
            <div class="relative ml-3" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="hidden md:inline-block font-medium text-sm text-gray-700">
                        {{ auth()->user()->name }}
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <!-- Profile Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200" style="display: none;">
                    <a href="{{ route('settings.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Alpine.js - Include this in your layout if not already present -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> 