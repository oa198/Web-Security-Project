@extends('layouts.app')

@section('title', 'Courses - Student Portal')

@section('page_title', 'Courses')

@section('content')
<div class="space-y-6">
    <!-- Filters and Search -->
    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="flex gap-2">
            <button id="all-btn" class="px-4 py-2 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                All Courses
            </button>
            <button id="enrolled-btn" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                Enrolled
            </button>
            <button id="available-btn" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                Available
            </button>
        </div>
        <div class="w-full sm:w-64">
            <input
                type="text"
                id="course-search"
                placeholder="Search courses..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            />
        </div>
    </div>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="courses-container">
        <!-- Sample Courses - Replace with dynamic data in a real application -->
        @php
            $courses = [
                [
                    'id' => 1,
                    'name' => 'Database Systems',
                    'code' => 'CS 4750',
                    'enrolled' => true,
                    'instructor' => 'Dr. Smith',
                    'credits' => 4,
                    'schedule' => [
                        'days' => ['Mon', 'Wed'],
                        'startTime' => '10:00 AM',
                        'endTime' => '11:30 AM',
                        'location' => 'Room 305'
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Web Development',
                    'code' => 'CS 3240',
                    'enrolled' => true,
                    'instructor' => 'Prof. Johnson',
                    'credits' => 3,
                    'schedule' => [
                        'days' => ['Tue', 'Thu'],
                        'startTime' => '1:00 PM',
                        'endTime' => '2:30 PM',
                        'location' => 'Room 201'
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Artificial Intelligence',
                    'code' => 'CS 4670',
                    'enrolled' => false,
                    'instructor' => 'Dr. Williams',
                    'credits' => 4,
                    'schedule' => [
                        'days' => ['Mon', 'Wed', 'Fri'],
                        'startTime' => '2:00 PM',
                        'endTime' => '3:00 PM',
                        'location' => 'Room 401'
                    ]
                ],
                [
                    'id' => 4,
                    'name' => 'Data Structures',
                    'code' => 'CS 2150',
                    'enrolled' => true,
                    'instructor' => 'Dr. Davis',
                    'credits' => 4,
                    'schedule' => [
                        'days' => ['Tue', 'Thu'],
                        'startTime' => '9:30 AM',
                        'endTime' => '11:00 AM',
                        'location' => 'Room 202'
                    ]
                ],
                [
                    'id' => 5,
                    'name' => 'Computer Architecture',
                    'code' => 'CS 3330',
                    'enrolled' => false,
                    'instructor' => 'Prof. Wilson',
                    'credits' => 3,
                    'schedule' => [
                        'days' => ['Mon', 'Wed'],
                        'startTime' => '3:30 PM',
                        'endTime' => '5:00 PM',
                        'location' => 'Room 105'
                    ]
                ],
                [
                    'id' => 6,
                    'name' => 'Machine Learning',
                    'code' => 'CS 4774',
                    'enrolled' => false,
                    'instructor' => 'Dr. Martinez',
                    'credits' => 3,
                    'schedule' => [
                        'days' => ['Wed', 'Fri'],
                        'startTime' => '11:00 AM',
                        'endTime' => '12:30 PM',
                        'location' => 'Room 310'
                    ]
                ]
            ];
        @endphp

        @foreach($courses as $course)
            <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow duration-200 course-card {{ $course['enrolled'] ? 'enrolled' : 'available' }}">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $course['name'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $course['code'] }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course['enrolled'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $course['enrolled'] ? 'Enrolled' : 'Available' }}
                    </span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-sm">{{ $course['instructor'] }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-sm">{{ $course['credits'] }} Credits</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">
                            {{ implode(', ', $course['schedule']['days']) }} • {{ $course['schedule']['startTime'] }} - {{ $course['schedule']['endTime'] }}
                        </span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm">{{ $course['schedule']['location'] }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <button class="w-full py-2 px-4 rounded-lg font-medium {{ $course['enrolled'] ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-primary-600 text-white hover:bg-primary-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $course['enrolled'] ? 'focus:ring-red-500' : 'focus:ring-primary-500' }}">
                        {{ $course['enrolled'] ? 'Drop Course' : 'Enroll' }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allBtn = document.getElementById('all-btn');
        const enrolledBtn = document.getElementById('enrolled-btn');
        const availableBtn = document.getElementById('available-btn');
        const searchInput = document.getElementById('course-search');
        const coursesContainer = document.getElementById('courses-container');
        const courseCards = document.querySelectorAll('.course-card');

        // Filter functionality
        const updateFilters = (filter) => {
            // Update button styles
            allBtn.classList.remove('bg-primary-600', 'text-white');
            enrolledBtn.classList.remove('bg-primary-600', 'text-white');
            availableBtn.classList.remove('bg-primary-600', 'text-white');
            
            allBtn.classList.add('text-gray-700', 'hover:bg-gray-100');
            enrolledBtn.classList.add('text-gray-700', 'hover:bg-gray-100');
            availableBtn.classList.add('text-gray-700', 'hover:bg-gray-100');
            
            if (filter === 'all') {
                allBtn.classList.remove('text-gray-700', 'hover:bg-gray-100');
                allBtn.classList.add('bg-primary-600', 'text-white');
            } else if (filter === 'enrolled') {
                enrolledBtn.classList.remove('text-gray-700', 'hover:bg-gray-100');
                enrolledBtn.classList.add('bg-primary-600', 'text-white');
            } else if (filter === 'available') {
                availableBtn.classList.remove('text-gray-700', 'hover:bg-gray-100');
                availableBtn.classList.add('bg-primary-600', 'text-white');
            }
            
            // Filter cards
            filterCards();
        };
        
        // Search and filter combined
        const filterCards = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const filter = document.querySelector('.bg-primary-600').textContent.trim().toLowerCase();
            
            courseCards.forEach(card => {
                const courseName = card.querySelector('h3').textContent.toLowerCase();
                const courseCode = card.querySelector('p').textContent.toLowerCase();
                const instructor = card.querySelectorAll('.text-sm')[0].textContent.toLowerCase();
                
                const isEnrolled = card.classList.contains('enrolled');
                
                // Check if it matches the filter
                const matchesFilter = 
                    filter === 'all courses' || 
                    (filter === 'enrolled' && isEnrolled) ||
                    (filter === 'available' && !isEnrolled);
                
                // Check if it matches the search term
                const matchesSearch = 
                    courseName.includes(searchTerm) ||
                    courseCode.includes(searchTerm) ||
                    instructor.includes(searchTerm);
                
                // Show/hide based on both conditions
                if (matchesFilter && matchesSearch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        };
        
        // Event listeners
        allBtn.addEventListener('click', () => updateFilters('all'));
        enrolledBtn.addEventListener('click', () => updateFilters('enrolled'));
        availableBtn.addEventListener('click', () => updateFilters('available'));
        searchInput.addEventListener('input', filterCards);
    });
</script>
@endsection 