@extends('layouts.app')

@section('title', 'Notifications - Student Portal')

@section('page_title', 'Notifications')

@section('content')
<div class="space-y-6">
    <!-- Header with filters -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex gap-2">
            <button
                id="all-btn"
                class="px-4 py-2 rounded-lg bg-primary-100 text-primary-800"
                onclick="filterNotifications('all')"
            >
                All Notifications
            </button>
            <button
                id="unread-btn"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
                onclick="filterNotifications('unread')"
            >
                Unread
            </button>
        </div>
        <button class="text-primary-600 hover:text-primary-700" onclick="markAllAsRead()">
            Mark all as read
        </button>
    </div>

    <!-- Notifications List -->
    <div class="space-y-4">
        <!-- Success Notification - Unread -->
        <div class="bg-primary-50 rounded-lg shadow-sm border p-5 notification-card" data-read="false">
            <div class="flex items-start gap-4">
                <div class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                Assignment Graded
                            </h3>
                            <p class="text-gray-600 mt-1">Your Web Development Midterm has been graded. You received a score of 92%.</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                            success
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        May 16, 2023, 2:30 PM
                    </p>
                </div>
            </div>
        </div>

        <!-- Warning Notification - Unread -->
        <div class="bg-primary-50 rounded-lg shadow-sm border p-5 notification-card" data-read="false">
            <div class="flex items-start gap-4">
                <div class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                Assignment Due Soon
                            </h3>
                            <p class="text-gray-600 mt-1">Your Database Final Project is due in 2 days. Make sure to submit on time.</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                            warning
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        May 18, 2023, 9:15 AM
                    </p>
                </div>
            </div>
        </div>

        <!-- Error Notification - Read -->
        <div class="bg-white rounded-lg shadow-sm border p-5 notification-card" data-read="true">
            <div class="flex items-start gap-4">
                <div class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                Course Registration Failed
                            </h3>
                            <p class="text-gray-600 mt-1">Your attempt to register for CS 501 Advanced Database Systems failed due to a prerequisite requirement.</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                            error
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        May 12, 2023, 11:45 AM
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Notification - Read -->
        <div class="bg-white rounded-lg shadow-sm border p-5 notification-card" data-read="true">
            <div class="flex items-start gap-4">
                <div class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                Campus Announcement
                            </h3>
                            <p class="text-gray-600 mt-1">The university library will be closed for renovation from June 1 to June 5. Online resources will remain available.</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            info
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        May 10, 2023, 3:00 PM
                    </p>
                </div>
            </div>
        </div>

        <!-- Success Notification - Read -->
        <div class="bg-white rounded-lg shadow-sm border p-5 notification-card" data-read="true">
            <div class="flex items-start gap-4">
                <div class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                Payment Received
                            </h3>
                            <p class="text-gray-600 mt-1">Your tuition payment for Spring 2023 has been processed successfully.</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                            success
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        May 5, 2023, 9:30 AM
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Notification - Read -->
        <div class="bg-white rounded-lg shadow-sm border p-5 notification-card" data-read="true">
            <div class="flex items-start gap-4">
                <div class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                New Course Available
                            </h3>
                            <p class="text-gray-600 mt-1">CS 450: Machine Learning will be available for registration in the Fall 2023 semester.</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            info
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        May 1, 2023, 10:15 AM
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterNotifications(filter) {
        // Reset button styles
        document.getElementById('all-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('all-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('unread-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('unread-btn').classList.add('bg-gray-100', 'text-gray-600');
        
        // Set active button
        if (filter === 'all') {
            document.getElementById('all-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('all-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else {
            document.getElementById('unread-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('unread-btn').classList.remove('bg-gray-100', 'text-gray-600');
        }
        
        // Filter notifications
        const notifications = document.querySelectorAll('.notification-card');
        notifications.forEach(notification => {
            if (filter === 'all') {
                notification.classList.remove('hidden');
            } else {
                const isRead = notification.getAttribute('data-read') === 'true';
                if (!isRead) {
                    notification.classList.remove('hidden');
                } else {
                    notification.classList.add('hidden');
                }
            }
        });
    }
    
    function markAllAsRead() {
        const unreadNotifications = document.querySelectorAll('.notification-card[data-read="false"]');
        unreadNotifications.forEach(notification => {
            notification.setAttribute('data-read', 'true');
            notification.classList.remove('bg-primary-50');
            notification.classList.add('bg-white');
        });
    }
</script>
@endsection 