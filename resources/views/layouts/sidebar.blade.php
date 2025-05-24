<aside class="fixed inset-y-0 left-0 bg-white shadow-lg w-64 transform transition-transform duration-200 ease-in-out z-10 lg:relative lg:translate-x-0" id="sidebar" x-data="{ activeSub: null }">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-lg font-semibold">Student Portal</span>
            </div>
            <button class="lg:hidden" id="close-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('dashboard') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('courses.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('courses.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('courses.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Courses
                    </a>
                </li>
                <li>
                    <a href="{{ route('departments.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('departments.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('departments.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Departments
                    </a>
                </li>
                <li>
                    <a href="{{ route('grades.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('grades.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('grades.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Grades
                    </a>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2 {{ request()->routeIs('schedule.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('schedule.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="flex-1">Schedule</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('schedule.index') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('schedule.index') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                All Schedules
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('schedule.calendar') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('schedule.calendar') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Calendar View
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('schedule.create') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('schedule.create') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Create Schedule
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('notifications.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('notifications.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('notifications.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Notifications
                    </a>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2 {{ request()->routeIs('financial.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('financial.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="flex-1">Financial</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('financial.index') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('financial.index') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Overview
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.payment-history') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('financial.payment-history') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Payment History
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.invoices') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('financial.invoices') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Invoices
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.payment-form') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('financial.payment-form') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Make Payment
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.scholarship-application') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('financial.scholarship-application') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Scholarships
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('documents.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('documents.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('documents.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                        </svg>
                        Documents
                    </a>
                </li>
                
                <!-- Faculty Module -->
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2 {{ request()->routeIs('faculty.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('faculty.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="flex-1">Faculty</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('faculty.index') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('faculty.index') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                All Faculty
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('departments.index') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('departments.index') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Departments
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Academic Calendar Module -->
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2 {{ request()->routeIs('academic-calendar.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('academic-calendar.*') ? 'text-primary-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="flex-1">Academic Calendar</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('academic-calendar.index') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('academic-calendar.index') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                All Events
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('academic-calendar.calendar') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('academic-calendar.calendar') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Calendar View
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('academic-calendar.current') }}" class="flex items-center pl-8 pr-4 py-2 {{ request()->routeIs('academic-calendar.current') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }}">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Current Events
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Admin Section - Only visible to users with admin role -->
                @role('admin')
                <li class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ADMIN CONTROLS</h3>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2 {{ request()->routeIs('admin.users.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="flex-1">User Management</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                All Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.create') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Create User
                            </a>
                        </li>
                    </ul>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2 {{ request()->routeIs('admin.roles.*') ? 'text-gray-900 bg-primary-100 border-r-4 border-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="flex-1">Roles & Permissions</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                All Roles
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.permissions.index') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                All Permissions
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                
                <!-- Department Head Section - Only visible to department heads -->
                @role('department_head')
                <li class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">DEPARTMENT HEAD</h3>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="flex-1">Department Management</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('department.staff') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Staff Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('department.courses') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Course Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('department.statistics') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Department Statistics
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                
                <!-- Professor Section - Only visible to professors -->
                @role('professor')
                <li class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">PROFESSOR TOOLS</h3>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="flex-1">Teaching</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('professor.courses') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                My Courses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('professor.grades') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Grade Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('professor.attendance') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Attendance
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                
                <!-- Financial Officer Section - Only visible to financial officers -->
                @role('financial_officer')
                <li class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">FINANCIAL TOOLS</h3>
                </li>
                <li x-data="{open: false}" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center w-full px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="flex-1">Financial Management</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" class="pl-4 py-2 space-y-1 bg-gray-50" style="display: none;">
                        <li>
                            <a href="{{ route('financial.admin.dashboard') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Finance Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.admin.payments') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Process Payments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.admin.scholarships') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Scholarship Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financial.admin.reports') }}" class="flex items-center pl-8 pr-4 py-2">
                                <span class="w-1 h-1 rounded-full bg-gray-400 mr-3"></span>
                                Financial Reports
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
        </nav>

        <!-- User Profile -->
        @if(auth()->check())
        <div class="p-4 border-t">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                <div class="ml-auto">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</aside>

<!-- Mobile Menu Button -->
<button class="fixed bottom-4 right-4 p-3 bg-primary-600 text-white rounded-full shadow-lg lg:hidden z-20" id="open-sidebar">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<script>
    // Add this to your app.js or in a script tag
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const openSidebar = document.getElementById('open-sidebar');
        const closeSidebar = document.getElementById('close-sidebar');
        
        if (openSidebar && closeSidebar && sidebar) {
            openSidebar.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
            });
            
            closeSidebar.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
            });
        }
    });
</script> 