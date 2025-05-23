<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Student Information System</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    @yield('styles')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Setup axios defaults for API requests
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.baseURL = '/api';
        
        // Add token to all requests
        const token = localStorage.getItem('api_token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        
        // Handle 401 responses globally (redirect to login)
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && error.response.status === 401) {
                    localStorage.removeItem('api_token');
                    window.location.href = '/login';
                }
                return Promise.reject(error);
            }
        );
    </script>
    @yield('scripts-head')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gray-800">
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-white font-bold text-lg">SIS Admin</span>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400"></i>
                            Dashboard
                        </a>
                        
                        @can('viewAny', App\Models\AcademicTerm::class)
                        <a href="{{ route('admin.academic-terms.index') }}" class="@if(request()->routeIs('admin.academic-terms*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-calendar-alt mr-3 text-gray-400"></i>
                            Academic Terms
                        </a>
                        @endcan
                        
                        @can('viewAny', App\Models\AcademicCalendar::class)
                        <a href="{{ route('admin.academic-calendars.index') }}" class="@if(request()->routeIs('admin.academic-calendars*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-calendar-day mr-3 text-gray-400"></i>
                            Academic Calendar
                        </a>
                        @endcan
                        
                        @can('viewAny', App\Models\Program::class)
                        <a href="{{ route('admin.programs.index') }}" class="@if(request()->routeIs('admin.programs*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-graduation-cap mr-3 text-gray-400"></i>
                            Programs
                        </a>
                        @endcan
                        
                        @can('viewAny', App\Models\Exam::class)
                        <a href="{{ route('admin.exams.index') }}" class="@if(request()->routeIs('admin.exams*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-file-alt mr-3 text-gray-400"></i>
                            Exams
                        </a>
                        @endcan
                        
                        @can('viewAny', App\Models\ExamResult::class)
                        <a href="{{ route('admin.exam-results.index') }}" class="@if(request()->routeIs('admin.exam-results*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-clipboard-check mr-3 text-gray-400"></i>
                            Exam Results
                        </a>
                        @endcan
                        
                        <!-- User Account Section -->
                        <div class="pt-4 mt-4 border-t border-gray-700">
                            <div class="px-2 space-y-1">
                                <a href="{{ route('profile.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i class="fas fa-user mr-3 text-gray-400"></i>
                                    My Profile
                                </a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navbar -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button type="button" class="md:hidden px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" id="sidebar-toggle">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <h1 class="text-2xl font-semibold text-gray-900 self-center">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">View notifications</span>
                                <i class="fas fa-bell"></i>
                            </button>
                        </div>
                        
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500">
                                        <span class="text-sm font-medium leading-none text-white">{{ auth()->user()->name[0] }}</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main content area -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none p-6">
                <!-- Flash messages -->
                @if (session('success'))
                    <div class="alert-success mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert-info mb-4" role="alert">
                        {{ session('info') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile sidebar script -->
    <script>
        // Toggle mobile sidebar
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.md\\:flex');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-0');
            sidebar.classList.toggle('z-40');
        });
    </script>
    
    @yield('scripts')
</body>
</html>
