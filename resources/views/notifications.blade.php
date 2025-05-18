@extends('layouts.main')

@section('title', 'Notifications - Student Portal')

@section('page-title', 'Notifications')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Notifications</h2>
    <p class="text-gray-600 mt-1">
        Stay updated with important announcements and alerts.
    </p>
</div>

<!-- Notification Filters -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select id="type" class="text-sm border-gray-200 rounded-md w-40">
                    <option>All Types</option>
                    <option>Academic</option>
                    <option>Deadline</option>
                    <option>Financial</option>
                    <option>System</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" class="text-sm border-gray-200 rounded-md w-40">
                    <option>All Status</option>
                    <option>Read</option>
                    <option>Unread</option>
                </select>
            </div>
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <select id="date" class="text-sm border-gray-200 rounded-md w-40">
                    <option>All Time</option>
                    <option>Today</option>
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Term</option>
                </select>
            </div>
        </div>
        <div class="relative">
            <input type="text" placeholder="Search notifications..." class="pl-8 pr-4 py-2 border border-gray-200 rounded-md w-64">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-2.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- Notification Count Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Notifications</p>
                <p class="text-xl font-semibold text-gray-800">{{ $totalNotifications ?? 12 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-amber-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Unread</p>
                <p class="text-xl font-semibold text-gray-800">{{ $unreadNotifications ?? 3 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg p-4 shadow-sm border">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Read</p>
                <p class="text-xl font-semibold text-gray-800">{{ $readNotifications ?? 9 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Recent Notifications</h3>
        <a href="{{ route('notifications.mark-all-as-read') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">Mark All as Read</a>
    </div>
    
    <div class="space-y-4">
        <!-- Unread notifications with dot indicator -->
        @forelse($notifications ?? [] as $notification)
            @if(!$notification['read'])
                <div class="p-4 
                    @if($notification['type'] == 'info') bg-blue-50 border-blue-100
                    @elseif($notification['type'] == 'success') bg-green-50 border-green-100
                    @elseif($notification['type'] == 'warning') bg-amber-50 border-amber-100
                    @else bg-gray-50 border-gray-200 @endif 
                    rounded-lg border relative">
                    <div class="absolute top-4 right-4 h-2 w-2 
                        @if($notification['type'] == 'info') bg-blue-600
                        @elseif($notification['type'] == 'success') bg-green-600
                        @elseif($notification['type'] == 'warning') bg-amber-600
                        @else bg-gray-600 @endif 
                        rounded-full"></div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 
                                @if($notification['type'] == 'info') text-blue-600
                                @elseif($notification['type'] == 'success') text-green-600
                                @elseif($notification['type'] == 'warning') text-amber-600
                                @else text-gray-600 @endif"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                @if($notification['type'] == 'info')
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                @elseif($notification['type'] == 'success')
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                @elseif($notification['type'] == 'warning')
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                @endif
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium 
                                @if($notification['type'] == 'info') text-blue-800
                                @elseif($notification['type'] == 'success') text-green-800
                                @elseif($notification['type'] == 'warning') text-amber-800
                                @else text-gray-800 @endif">
                                {{ $notification['title'] }}
                            </h4>
                            <div class="mt-2 text-sm 
                                @if($notification['type'] == 'info') text-blue-700
                                @elseif($notification['type'] == 'success') text-green-700
                                @elseif($notification['type'] == 'warning') text-amber-700
                                @else text-gray-700 @endif">
                                <p>{{ $notification['content'] }}</p>
                            </div>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs 
                                    @if($notification['type'] == 'info') text-blue-600
                                    @elseif($notification['type'] == 'success') text-green-600
                                    @elseif($notification['type'] == 'warning') text-amber-600
                                    @else text-gray-600 @endif">
                                    {{ $notification['created_at']->diffForHumans() ?? '2 hours ago' }}
                                </span>
                                <div>
                                    <a href="{{ route('notifications.mark-as-read', $notification['id']) }}" class="text-xs 
                                        @if($notification['type'] == 'info') text-blue-800
                                        @elseif($notification['type'] == 'success') text-green-800
                                        @elseif($notification['type'] == 'warning') text-amber-800
                                        @else text-gray-800 @endif 
                                        font-medium mr-2">Mark as Read</a>
                                    <a href="{{ route('notifications.show', $notification['id']) }}" class="text-xs 
                                        @if($notification['type'] == 'info') text-blue-800
                                        @elseif($notification['type'] == 'success') text-green-800
                                        @elseif($notification['type'] == 'warning') text-amber-800
                                        @else text-gray-800 @endif 
                                        font-medium">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                @if($notification['type'] == 'info')
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                @elseif($notification['type'] == 'success')
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                @endif
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-800">{{ $notification['title'] }}</h4>
                            <div class="mt-2 text-sm text-gray-700">
                                <p>{{ $notification['content'] }}</p>
                            </div>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs text-gray-500">{{ $notification['created_at']->diffForHumans() ?? '4 days ago' }}</span>
                                <a href="{{ route('notifications.show', $notification['id']) }}" class="text-xs text-gray-700 font-medium">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="p-4 text-center text-gray-500">
                No notifications found.
            </div>
        @endforelse
        
        @if(!isset($notifications) || count($notifications) > 5)
        <div class="mt-6 flex justify-center">
            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Load More
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Notification Settings -->
<div class="bg-white rounded-lg shadow-sm border p-5">
    <h3 class="font-semibold text-gray-900 mb-4">Notification Settings</h3>
    <form action="{{ route('notifications.settings') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">Email Notifications</p>
                    <p class="text-xs text-gray-500">Receive notifications via email</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="email_notifications" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">Assignment Deadlines</p>
                    <p class="text-xs text-gray-500">Get reminded about upcoming due dates</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="assignment_deadlines" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">Grade Updates</p>
                    <p class="text-xs text-gray-500">Be notified when new grades are posted</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="grade_updates" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">Course Announcements</p>
                    <p class="text-xs text-gray-500">Receive general course announcements</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="course_announcements" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">Financial Updates</p>
                    <p class="text-xs text-gray-500">Get alerted about bills and payments</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="financial_updates" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 border border-primary-300 rounded-md text-sm font-medium text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection