<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #8b5cf6;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6d28d9;
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 h-full w-64 bg-white border-r border-gray-200 z-30 transform transition-transform duration-300 ease-in-out lg:translate-x-0" id="sidebar">
            <div class="h-full flex flex-col">
                <!-- Logo and Mobile Close Button -->
                <div class="h-16 px-4 border-b border-gray-200 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="ml-2 text-xl font-bold text-primary-600">UniSIS</span>
                    </a>
                    <button class="p-1 rounded-full hover:bg-gray-100 lg:hidden" id="closeSidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- User Profile -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                            {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ auth()->user() ? auth()->user()->name : 'User' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user() ? auth()->user()->email : 'user@example.com' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-2 py-4 overflow-y-auto">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('courses.*') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Courses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('grades.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('grades.*') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Grades</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/schedule') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('schedule') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Schedule</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/assignments') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('assignments') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <span>Assignments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/notifications') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('notifications') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span>Notifications</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/financial') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('financial') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Financial</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/documents') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('documents') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Documents</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Footer Menu -->
                <div class="p-4 border-t border-gray-200">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ url('/settings') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('settings') ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        
        <!-- Mobile toggle button -->
        <button class="fixed bottom-4 right-4 p-3 bg-primary-600 text-white rounded-full shadow-lg lg:hidden z-20" id="openSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
  
        <!-- Main Content Area -->
        <div class="lg:pl-64 flex flex-col flex-1 min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="h-16 px-4 md:px-6 flex items-center justify-between">
                    <!-- Page Title -->
                    <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    
                    <!-- Search - Hidden on Mobile -->
                    <div class="hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 w-72">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <form action="{{ route('search') }}" method="GET">
                            <input type="text" name="query" placeholder="Search..." class="bg-transparent outline-none flex-1 text-sm">
                        </form>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="flex items-center">
                        <div class="relative inline-block">
                            <button type="button" class="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none" id="notificationBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- Notification Dropdown - Hidden by default -->
                            <div class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200" id="notificationDropdown">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">New Assignment Posted</p>
                                                <p class="text-xs text-gray-500 mt-1">Your instructor has posted a new assignment in Database Systems.</p>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                info
                                            </span>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-1">
                                            2 hours ago
                                        </p>
                                    </div>
                                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Quiz Graded</p>
                                                <p class="text-xs text-gray-500 mt-1">Your Web Development quiz has been graded.</p>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                success
                                            </span>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-1">
                                            Yesterday
                                        </p>
                                    </div>
                                </div>
                                <div class="px-4 py-2 border-t border-gray-200">
                                    <a href="{{ url('/notifications') }}" class="text-xs text-primary-600 hover:underline">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6">
                @if(session('info'))
                <div class="mb-4 p-4 bg-primary-100 text-primary-800 rounded-lg">
                    {{ session('info') }}
                </div>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="py-4 px-6 text-center text-sm text-gray-500 border-t border-gray-200">
                © {{ date('Y') }} Student Information System. All rights reserved.
            </footer>
        </div>
    </div>
    
    <script>
        // Mobile sidebar toggle
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
        });
        
        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
        });
        
        // Notification dropdown toggle
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        
        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', function() {
                notificationDropdown.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!notificationBtn.contains(event.target) && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }
    </script>
    
    @yield('scripts')
</body>
</html> 